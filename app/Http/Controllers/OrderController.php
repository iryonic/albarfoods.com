<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('signin', ['redirect' => 'orders']);
        }

        $orders = Order::where('user_id', Auth::id())
            ->with('items.variant.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders', compact('orders'));
    }

    public function track(Request $request)
    {
        $order = null;
        $searched = false;

        if ($request->has('order_number') && !empty($request->order_number)) {
            $searched = true;
            $orderNumber = trim($request->order_number);
            
            // Allow tracking by order number (and optional phone validation)
            $query = Order::with('items.variant.product')->where('order_number', $orderNumber);
            
            if ($request->has('phone') && !empty($request->phone)) {
                $query->where('shipping_phone', trim($request->phone));
            }
            
            $order = $query->first();
        }

        return view('track-order', compact('order', 'searched'));
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        $order = Order::where('order_number', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (in_array(strtolower($order->status), ['pending', 'confirmed', 'processing'])) {
            $order->status = 'Cancelled';
            $order->save();

            // Restore stock
            foreach ($order->items as $item) {
                $variant = $item->variant;
                if ($variant) {
                    $variant->increment('stock', $item->quantity);
                    DB::table('inventory_logs')->insert([
                        'product_variant_id' => $variant->id,
                        'quantity_change' => $item->quantity,
                        'type' => 'Stock In',
                        'log_message' => "Order #{$order->order_number} cancelled by customer",
                        'created_at' => now()
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Order cancelled successfully.']);
        }

        return response()->json(['error' => 'This order is already shipped or processed and cannot be cancelled.'], 400);
    }

    public function requestReturn(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'reason' => 'required|string|min:10',
            'evidence' => 'nullable|array',
            'evidence.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 1. Verify status is Delivered
        if (strtolower($order->status) !== 'delivered') {
            return response()->json(['error' => 'Returns are only allowed for delivered orders.'], 400);
        }

        // 2. Check if a return already exists
        $existing = \App\Models\ReturnRequest::where('order_id', $order->id)->first();
        if ($existing) {
            return response()->json(['error' => 'A return request has already been submitted for this order.'], 400);
        }

        // 3. Handle file uploads
        $imagePaths = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $filename = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/evidence'), $filename);
                $imagePaths[] = 'uploads/evidence/' . $filename;
            }
        }

        // 4. Create Return Request
        \App\Models\ReturnRequest::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'status' => 'Requested',
            'reason' => $request->reason,
            'evidence_images' => $imagePaths
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your return request has been submitted successfully and is under review.'
        ]);
    }
}
