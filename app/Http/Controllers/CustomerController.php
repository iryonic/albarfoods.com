<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('signin', ['redirect' => 'profile']);
        }

        $user = Auth::user();
        $addresses = $user->addresses;

        return view('profile', compact('user', 'addresses'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:users,phone,' . $user->id,
            'current_password' => 'nullable|string|required_with:new_password',
            'new_password' => 'nullable|string|min:6'
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return response()->json(['error' => 'Incorrect current password.'], 400);
            }
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->save();

        return response()->json(['success' => 'Profile updated successfully!']);
    }

    public function updateAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'label' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'alt_phone' => 'nullable|string|regex:/^[0-9]{10}$/',
            'pincode' => 'required|string|regex:/^[0-9]{6}$/',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'landmark' => 'nullable|string|max:255'
        ]);

        // Find or create address
        $address = UserAddress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'label' => $request->input('label')
            ],
            [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'alt_phone' => $request->input('alt_phone'),
                'pincode' => $request->input('pincode'),
                'city' => $request->input('city'),
                'address' => $request->input('address'),
                'landmark' => $request->input('landmark')
            ]
        );

        return response()->json(['success' => 'Address saved successfully!', 'address' => $address]);
    }

    public function wishlist()
    {
        return view('wishlist');
    }
}
