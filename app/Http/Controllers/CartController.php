<?php

namespace App\Http\Controllers;

use App\Models\AbandonedCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'session_token' => 'required|string',
            'cart_data' => 'nullable|array',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'alt_phone' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'landmark' => 'nullable|string|max:255',
        ]);

        $sessionToken = $request->input('session_token');
        $cartData = $request->input('cart_data', []);

        // Find existing active cart
        $cart = AbandonedCart::where('session_token', $sessionToken)
            ->where('status', 'active')
            ->first();

        if (empty($cartData)) {
            if ($cart) {
                $cart->delete();
            }
            return response()->json(['success' => true, 'message' => 'Cart cleared.']);
        }

        if (!$cart) {
            $cart = new AbandonedCart();
            $cart->session_token = $sessionToken;
            $cart->status = 'active';
        }

        $cart->user_id = Auth::check() ? Auth::id() : null;

        // Update details if they are filled in the request
        if ($request->filled('name')) $cart->name = $request->name;
        if ($request->filled('phone')) $cart->phone = $request->phone;
        
        // Also populate default fields if Auth user is logged in and details are empty
        if (Auth::check()) {
            $user = Auth::user();
            if (empty($cart->name)) $cart->name = $user->name;
            if (empty($cart->phone)) $cart->phone = $user->phone;
            $cart->email = $user->email;
        }

        if ($request->filled('address')) $cart->shipping_address = $request->address;
        if ($request->filled('city')) $cart->shipping_city = $request->city;
        if ($request->filled('pincode')) $cart->shipping_pincode = $request->pincode;
        if ($request->filled('landmark')) $cart->shipping_landmark = $request->landmark;

        $cart->cart_data = $cartData;
        $cart->last_activity_at = now();
        $cart->save();

        return response()->json(['success' => true, 'cart_id' => $cart->id]);
    }
}
