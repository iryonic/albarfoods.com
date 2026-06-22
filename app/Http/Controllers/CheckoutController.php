<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            'payment_method' => 'required|string|in:cod,bank,razorpay,cashfree,paytm,paypal',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.weight' => 'required|string',
            'coupon_code' => 'nullable|string',
            'session_token' => 'nullable|string'
        ]);

        try {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            $methodInput = $request->input('payment_method');
            
            $isEnabled = true;
            if ($methodInput === 'cod') {
                $isEnabled = (!isset($settings['payment_cod_status']) || $settings['payment_cod_status'] === 'enabled');
            } elseif ($methodInput === 'bank') {
                $isEnabled = (!isset($settings['payment_bank_status']) || $settings['payment_bank_status'] === 'enabled');
            } else {
                $statusKey = "payment_{$methodInput}_status";
                $isEnabled = (isset($settings[$statusKey]) && $settings[$statusKey] === 'enabled');
            }

            if (!$isEnabled) {
                return response()->json(['error' => 'The selected payment method is currently unavailable. Please select another method.'], 400);
            }

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

            $paymentMethodDisplay = 'Cash on Delivery (COD)';
            if ($methodInput === 'bank') {
                $paymentMethodDisplay = 'Direct Bank Transfer (J&K Bank)';
            } elseif ($methodInput === 'razorpay') {
                $paymentMethodDisplay = 'Razorpay Online';
            } elseif ($methodInput === 'cashfree') {
                $paymentMethodDisplay = 'Cashfree Online';
            } elseif ($methodInput === 'paytm') {
                $paymentMethodDisplay = 'Paytm Online';
            } elseif ($methodInput === 'paypal') {
                $paymentMethodDisplay = 'PayPal Online';
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
                'payment_method' => $paymentMethodDisplay,
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

            // Mark abandoned cart as completed
            if ($request->filled('session_token')) {
                \App\Models\AbandonedCart::where('session_token', $request->input('session_token'))
                    ->where('status', 'active')
                    ->update(['status' => 'completed']);
            }

            // Handle Razorpay API call
            $razorpayOrderId = null;
            $keyId = '';
            if ($methodInput === 'razorpay') {
                $keyId = $settings['payment_razorpay_key_id'] ?? '';
                $keySecret = $settings['payment_razorpay_key_secret'] ?? '';

                if (empty($keyId) || empty($keySecret)) {
                    throw new \Exception('Razorpay integration keys are not configured in settings.');
                }
                
                $response = Http::withBasicAuth($keyId, $keySecret)
                    ->post('https://api.razorpay.com/v1/orders', [
                        'amount' => round($grandTotal * 100), // in paise
                        'currency' => 'INR',
                        'receipt' => $orderNumber
                    ]);
                
                if ($response->failed()) {
                    throw new \Exception('Razorpay order creation failed: ' . ($response->json('error.description') ?? 'Unknown error'));
                }
                
                $razorpayOrderId = $response->json('id');
                
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'Razorpay',
                    'transaction_reference' => $razorpayOrderId,
                    'amount' => $grandTotal,
                    'status' => 'Pending'
                ]);
            }

            DB::commit();

            if (in_array($methodInput, ['cod', 'bank'])) {
                session(['last_order' => $order->load('items')]);
                return response()->json([
                    'success' => true,
                    'order_id' => $orderNumber,
                    'redirect_url' => route('order-success')
                ]);
            }

            if ($methodInput === 'razorpay') {
                return response()->json([
                    'success' => true,
                    'payment_required' => true,
                    'payment_method' => 'razorpay',
                    'razorpay_order_id' => $razorpayOrderId,
                    'amount' => round($grandTotal * 100),
                    'key_id' => $keyId,
                    'name' => $request->input('name'),
                    'email' => Auth::check() ? Auth::user()->email : '',
                    'phone' => $request->input('phone'),
                    'order_number' => $orderNumber
                ]);
            }

            // Redirect for Cashfree, Paytm, PayPal simulation
            return response()->json([
                'success' => true,
                'payment_required' => true,
                'payment_method' => 'simulate',
                'redirect_url' => route('checkout.payment.simulate', ['order_number' => $orderNumber])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order. ' . $e->getMessage()], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'order_number' => 'required|string'
        ]);

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $keySecret = $settings['payment_razorpay_key_secret'] ?? '';

        $razorpay_order_id = $request->input('razorpay_order_id');
        $razorpay_payment_id = $request->input('razorpay_payment_id');
        $razorpay_signature = $request->input('razorpay_signature');

        $generatedSignature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $keySecret);

        if ($generatedSignature === $razorpay_signature) {
            $order = Order::where('order_number', $request->input('order_number'))->first();
            if ($order) {
                $order->update([
                    'payment_status' => 'Completed',
                    'status' => 'Confirmed'
                ]);

                // Update payment record
                $payment = Payment::where('transaction_reference', $razorpay_order_id)->first();
                if ($payment) {
                    $payment->update([
                        'status' => 'Completed',
                        'transaction_reference' => $razorpay_payment_id,
                        'payload' => $request->all()
                    ]);
                } else {
                    Payment::create([
                        'order_id' => $order->id,
                        'payment_method' => 'Razorpay',
                        'transaction_reference' => $razorpay_payment_id,
                        'amount' => $order->grand_total,
                        'status' => 'Completed',
                        'payload' => $request->all()
                    ]);
                }

                session(['last_order' => $order->load('items')]);

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'error' => 'Payment signature verification failed.'], 400);
    }

    public function simulatePayment($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        if ($order->payment_status === 'Completed') {
            return redirect()->route('order-success');
        }
        
        $method = 'Online Payment';
        if (str_contains($order->payment_method, 'Cashfree')) {
            $method = 'Cashfree';
        } elseif (str_contains($order->payment_method, 'Paytm')) {
            $method = 'Paytm';
        } elseif (str_contains($order->payment_method, 'PayPal')) {
            $method = 'PayPal';
        }

        return view('checkout-payment-simulate', compact('order', 'method'));
    }

    public function verifySimulatedPayment(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'status' => 'required|string|in:success,failed',
            'payment_method' => 'required|string'
        ]);

        $order = Order::where('order_number', $request->input('order_number'))->firstOrFail();

        if ($request->input('status') === 'success') {
            $order->update([
                'payment_status' => 'Completed',
                'status' => 'Confirmed'
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->input('payment_method'),
                'transaction_reference' => 'SIM-' . strtoupper(uniqid()),
                'amount' => $order->grand_total,
                'status' => 'Completed',
                'payload' => $request->all()
            ]);

            session(['last_order' => $order->load('items')]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('order-success')
            ]);
        } else {
            $order->update([
                'payment_status' => 'Failed',
                'status' => 'Cancelled'
            ]);
            
            // Restore stock!
            foreach ($order->items as $item) {
                if ($item->product_variant_id) {
                    $variant = ProductVariant::find($item->product_variant_id);
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                        
                        DB::table('inventory_logs')->insert([
                            'product_variant_id' => $variant->id,
                            'quantity_change' => $item->quantity,
                            'type' => 'Stock In',
                            'log_message' => "Order #{$order->order_number} payment failed - stock restored",
                            'created_at' => now()
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => false,
                'error' => 'Payment failed. Stock has been restored.'
            ]);
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
