<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'alt_phone' => 'nullable|string|regex:/^[0-9]{10}$/',
            'pincode' => 'required|string|regex:/^[0-9]{6}$/',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'landmark' => 'nullable|string|max:255',
            'payment_method' => 'required|string|in:cod,bank',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.weight' => 'required|string',
            'coupon_code' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $cartItems = $request->input('cart');
            $subtotal = 0;
            $itemsToInsert = [];

            // 1. Verify pricing and availability of items
            foreach ($cartItems as $item) {
                // Find variant by product_id and weight
                $variant = ProductVariant::where('product_id', $item['id'])
                    ->where('weight', $item['weight'])
                    ->first();

                if (!$variant) {
                    return response()->json(['error' => "Product variant for ID {$item['id']} ({$item['weight']}) not found."], 400);
                }

                if ($variant->stock < $item['qty']) {
                    return response()->json(['error' => "Insufficient stock for {$item['title']} ({$item['weight']}). Only {$variant->stock} units left."], 400);
                }

                $itemTotal = $variant->price * $item['qty'];
                $subtotal += $itemTotal;

                $itemsToInsert[] = [
                    'product_variant_id' => $variant->id,
                    'title' => $variant->product->title,
                    'weight' => $variant->weight,
                    'price' => $variant->price,
                    'quantity' => $item['qty'],
                    'variant_model' => $variant // keep track for stock deduction later
                ];
            }

            // 2. Validate Coupon Code
            $discount = 0;
            $coupon = null;
            if ($request->filled('coupon_code')) {
                $code = strtoupper($request->input('coupon_code'));
                $coupon = Coupon::where('code', $code)
                    ->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                    })
                    ->first();

                if ($coupon) {
                    if ($subtotal >= $coupon->min_order_amount) {
                        if ($coupon->type === 'percentage') {
                            $discount = $subtotal * ($coupon->value / 100);
                        } else {
                            $discount = min($coupon->value, $subtotal);
                        }
                    }
                }
            }

            // 3. Calculate delivery charges (threshold is ₹999)
            $deliveryCharge = ($subtotal >= 999) ? 0 : 60;
            $grandTotal = $subtotal - $discount + $deliveryCharge;

            // 4. Create unique order number
            $orderNumber = 'ALB-' . date('Ymd') . '-' . rand(1000, 9900);
            while (Order::where('order_number', $orderNumber)->exists()) {
                $orderNumber = 'ALB-' . date('Ymd') . '-' . rand(1000, 9900);
            }

            // 5. Save Order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'order_number' => $orderNumber,
                'status' => 'Pending',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_charge' => $deliveryCharge,
                'grand_total' => $grandTotal,
                'payment_method' => $request->input('payment_method') === 'cod' ? 'Cash on Delivery (COD)' : 'Direct Bank Transfer (J&K Bank)',
                'payment_status' => 'Pending',
                'shipping_name' => $request->input('name'),
                'shipping_phone' => $request->input('phone'),
                'shipping_alt_phone' => $request->input('alt_phone'),
                'shipping_address' => $request->input('address'),
                'shipping_pincode' => $request->input('pincode'),
                'shipping_city' => $request->input('city'),
                'shipping_landmark' => $request->input('landmark'),
                'order_notes' => $request->input('notes')
            ]);

            // 6. Save Order Items & Deduct Stock
            foreach ($itemsToInsert as $itemData) {
                $variant = $itemData['variant_model'];
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'title' => $itemData['title'],
                    'weight' => $itemData['weight'],
                    'price' => $itemData['price'],
                    'quantity' => $itemData['quantity']
                ]);

                // Deduct stock
                $variant->decrement('stock', $itemData['quantity']);

                // Log inventory change
                DB::table('inventory_logs')->insert([
                    'product_variant_id' => $variant->id,
                    'quantity_change' => -$itemData['quantity'],
                    'type' => 'Stock Out',
                    'log_message' => "Order #{$orderNumber} placed",
                    'created_at' => now()
                ]);
            }

            // 7. Record Coupon Usage
            if ($coupon) {
                $coupon->increment('used_count');
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'order_id' => $order->id
                ]);
            }

            DB::commit();

            // Save order data in session to render in success view
            session(['last_order' => $order->load('items')]);

            return response()->json([
                'success' => true,
                'order_id' => $orderNumber,
                'redirect_url' => route('order-success')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order. Please try again: ' . $e->getMessage()], 500);
        }
    }

    public function success()
    {
        $order = session('last_order');
        if (!$order) {
            return redirect()->route('home');
        }
        return view('order-success', compact('order'));
    }
}
