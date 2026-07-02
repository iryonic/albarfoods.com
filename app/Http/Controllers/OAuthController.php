<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404, "Authentication provider not supported.");
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Throwable $e) {
            \Log::error("OAuth redirect failed for {$provider}: " . $e->getMessage());
            return redirect()->route('signin')->with('error', "Failed to connect with {$provider}. Please try another way.");
        }
    }

    /**
     * Obtain the user information from the provider and authenticate.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404, "Authentication provider not supported.");
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            \Log::error("OAuth callback failed for {$provider}: " . $e->getMessage());
            return redirect()->route('signin')->with('error', "Could not retrieve user info from {$provider}. Please try again.");
        }

        $email = $socialUser->getEmail();
        $name = $socialUser->getName() ?? $socialUser->getNickname() ?? 'Social User';
        $socialId = $socialUser->getId();

        if (empty($email)) {
            return redirect()->route('signin')->with('error', "Your {$provider} account does not have a public email address. Please sign up using email and password.");
        }

        // Find existing user by provider ID or email
        $user = User::where("{$provider}_id", $socialId)
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            // Update provider ID if not set
            if (empty($user->{"{$provider}_id"})) {
                $user->{"{$provider}_id"} = $socialId;
                $user->save();
            }
        } else {
            // Register a new user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => null, // Password-less account
                "{$provider}_id" => $socialId,
                'role_id' => null, // Default Customer
                'status' => 'active',
            ]);
        }

        if ($user->status === 'blocked') {
            return redirect()->route('signin')->with('error', 'Your account has been suspended.');
        }

        // Log the user in
        Auth::login($user, true);
        session()->regenerate();

        // Redirect based on role
        if (in_array($user->role_id, [1, 2])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }
}
