<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showSignin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember' => 'nullable|boolean'
        ]);

        $identifier = $request->input('email');
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $identifier,
            'password' => $request->input('password')
        ];
        
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status === 'blocked') {
                Auth::logout();
                return response()->json(['error' => 'Your account has been suspended. Please contact customer support.'], 403);
            }

            // Super Admin (1) or Admin (2) redirects to Admin Panel Dashboard
            if (in_array($user->role_id, [1, 2])) {
                $redirectUrl = route('admin.dashboard');
            } else {
                $redirectUrl = $request->input('redirect_url');
                if (is_null($redirectUrl) || $redirectUrl === '') {
                    $redirectUrl = route('home');
                }
            }

            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'loggedIn' => true
                ],
                'redirect_url' => $redirectUrl
            ]);
        }

        return response()->json(['error' => 'Invalid email/phone address or password. Please try again.'], 401);
    }

    public function showSignup()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'role_id' => null, // Default Customer
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account registered successfully!'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }
}
