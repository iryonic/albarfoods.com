<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\WhatsAppService;

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
                    'role_id' => $user->role_id,
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

    /**
     * Generate a 6-digit OTP, store in session, and send it via Fast2SMS.
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string|regex:/^[0-9]{10}$/']);

        $phone = $request->input('phone');
        $otp   = (string) random_int(100000, 999999);

        // Store OTP + expiry (5 minutes) + phone in session
        $request->session()->put('otp_data', [
            'phone'      => $phone,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5)->timestamp,
        ]);

        // ── Send OTP via WhatsApp Cloud API ──────────────────────────────
        $res = WhatsAppService::sendOtp($phone, $otp);
        $smsSent = $res['success'];
        $smsError = $res['error'] ?? null;

        if (!$smsSent) {
            if (config('app.env') === 'local') {
                // In local dev, do NOT delete the session so they can still test by looking at the logs!
                \Log::info("Local Dev OTP fallback: WhatsApp failed, but keeping OTP active in session. Phone: {$phone}, Generated OTP: {$otp}");
                return response()->json([
                    'error' => "Failed to send WhatsApp: {$smsError}. (Dev Tip: Since APP_ENV=local, you can retrieve the OTP from storage/logs/laravel.log to test the flow.)",
                ], 500);
            }

            // In production, clear session so user can retry cleanly
            $request->session()->forget('otp_data');
            \Log::error("WhatsApp failed for {$phone}: {$smsError}");
            return response()->json([
                'error' => 'Failed to send OTP via WhatsApp: ' . $smsError,
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => "OTP sent to +91 {$phone} via WhatsApp. Valid for 5 minutes.",
        ]);
    }

    /**
     * Verify submitted OTP against session value
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string', 'otp' => 'required|string|size:6']);

        $data = $request->session()->get('otp_data');

        if (!$data)                                 return response()->json(['error' => 'No OTP session found. Please request a new OTP.'], 400);
        if ($data['phone'] !== $request->input('phone')) return response()->json(['error' => 'Phone number mismatch.'], 400);
        if (now()->timestamp > $data['expires_at']) return response()->json(['error' => 'OTP has expired. Please request a new one.'], 400);
        if ($data['otp'] !== $request->input('otp'))   return response()->json(['error' => 'Incorrect OTP. Please try again.'], 400);

        // Mark phone as verified in session for the signup flow
        $request->session()->put('otp_phone_verified', $data['phone']);
        $request->session()->forget('otp_data');

        return response()->json(['success' => true, 'message' => 'Phone number verified successfully!']);
    }

    /**
     * Sign in using OTP only (password-less login via phone number)
     */
    public function signinWithOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string', 'otp' => 'required|string|size:6']);

        $data = $request->session()->get('otp_data');

        if (!$data || $data['phone'] !== $request->input('phone') || $data['otp'] !== $request->input('otp')) {
            return response()->json(['error' => 'Invalid or expired OTP.'], 400);
        }
        if (now()->timestamp > $data['expires_at']) {
            return response()->json(['error' => 'OTP has expired. Please request a new one.'], 400);
        }

        $user = User::where('phone', $request->input('phone'))->first();
        if (!$user) return response()->json(['error' => 'No account found with this phone number. Please sign up first.'], 404);

        if ($user->status === 'blocked') return response()->json(['error' => 'Your account has been suspended.'], 403);

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->forget('otp_data');

        $redirectUrl = in_array($user->role_id, [1, 2]) ? route('admin.dashboard') : route('home');

        return response()->json([
            'success' => true,
            'user'    => ['name' => $user->name, 'email' => $user->email, 'phone' => $user->phone, 'role_id' => $user->role_id, 'loggedIn' => true],
            'redirect_url' => $redirectUrl,
        ]);
    }
}
