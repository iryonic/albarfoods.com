@extends('layouts.app')

@section('title', 'Sign In - Al Barr | Kashmiri Organic Staples')

@section('styles')
<style>
    .auth-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        min-height: 75vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Glowing Blobs */
    .auth-glow-bg {
        position: absolute;
        width: 450px;
        height: 450px;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.12;
        z-index: 1;
        pointer-events: none;
    }
    .auth-glow-green {
        background: var(--color-blue-dark);
        top: -10%;
        left: -10%;
        animation: authGlowPulse 10s ease-in-out infinite alternate;
    }
    .auth-glow-saffron {
        background: var(--color-saffron-orange);
        bottom: -15%;
        right: -10%;
        animation: authGlowPulse 12s ease-in-out infinite alternate-reverse;
    }

    @keyframes authGlowPulse {
        0% { transform: scale(1) translate(0, 0); }
        100% { transform: scale(1.15) translate(30px, -20px); }
    }

    .auth-container {
        max-width: 480px;
        margin: 0 auto;
        width: 100%;
        position: relative;
        z-index: 5;
        animation: authCardFadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    @keyframes authCardFadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        padding: var(--spacing-xl) var(--spacing-lg);
        box-shadow: 0 20px 40px rgba(11, 19, 17, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.6);
        position: relative;
        overflow: hidden;
        text-align: left;
        transition: var(--transition-normal);
    }

    .auth-card:hover {
        box-shadow: 0 30px 60px rgba(11, 19, 17, 0.08);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--color-gold-gradient);
    }

    .auth-brand-logo {
        display: flex;
        justify-content: center;
        margin-bottom: var(--spacing-md);
    }

    .auth-logo-circle {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(1, 136, 73, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
    }

    .auth-card:hover .auth-logo-circle {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 4px 15px rgba(1, 136, 73, 0.15);
        border-color: var(--color-blue-medium);
    }

    .auth-logo-circle img {
        width: 42px;
        height: 42px;
        object-fit: contain;
    }

    .auth-header {
        text-align: center;
        margin-bottom: var(--spacing-lg);
    }

    .auth-title {
        font-family: var(--font-secondary);
        font-size: 2rem;
        color: var(--color-text-primary);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .auth-subtitle {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .auth-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        position: relative;
    }

    .auth-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--color-text-secondary);
        transition: var(--transition-fast);
    }

    .auth-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .auth-input-icon {
        position: absolute;
        left: 14px;
        color: var(--color-text-muted);
        transition: var(--transition-fast);
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        background-color: rgba(255, 255, 255, 0.8);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-size: 0.95rem;
        color: var(--color-text-primary);
        transition: var(--transition-fast);
    }

    .auth-input:focus {
        border-color: var(--color-blue-medium);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(2, 154, 77, 0.12);
        outline: none;
    }

    .auth-input:focus + .auth-input-icon {
        color: var(--color-blue-dark);
        transform: scale(1.05);
    }

    .password-toggle-btn {
        position: absolute;
        right: 14px;
        background: none;
        border: none;
        color: var(--color-text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: var(--transition-fast);
        z-index: 2;
    }

    .password-toggle-btn:hover {
        color: var(--color-blue-dark);
    }

    .auth-helpers {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        margin-top: -4px;
    }

    .remember-me-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        color: var(--color-text-secondary);
        user-select: none;
    }

    .remember-checkbox {
        accent-color: var(--color-blue-dark);
        width: 16px;
        height: 16px;
    }

    .forgot-pass-link {
        color: var(--color-blue-medium);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-fast);
    }

    .forgot-pass-link:hover {
        color: var(--color-blue-dark);
        text-decoration: underline;
    }

    .btn-auth-submit {
        width: 100%;
        background: var(--color-saffron-gradient);
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: var(--radius-xs);
        font-family: var(--font-secondary);
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
        transition: var(--transition-normal);
        text-align: center;
        margin-top: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-auth-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
    }

    .btn-auth-submit:active {
        transform: translateY(1px);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: var(--spacing-md) 0;
        color: var(--color-text-muted);
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1.5px solid var(--color-border-light);
    }
    
    .auth-divider:not(:empty)::before {
        margin-right: .8em;
    }
    
    .auth-divider:not(:empty)::after {
        margin-left: .8em;
    }

    .auth-social-buttons {
        display: flex;
        gap: 12px;
    }

    .btn-social-auth {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px;
        background: rgba(255, 255, 255, 0.8);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-family: var(--font-secondary);
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--color-text-primary);
        cursor: pointer;
        transition: var(--transition-fast);
    }

    .btn-social-auth:hover {
        background: #fff;
        border-color: var(--color-blue-medium);
        box-shadow: 0 4px 12px rgba(11, 19, 17, 0.03);
    }

    .btn-whatsapp-auth {
        border-color: rgba(37, 211, 102, 0.25);
        color: #128C7E;
    }

    .btn-whatsapp-auth:hover {
        background: rgba(37, 211, 102, 0.05);
        border-color: #25D366;
    }

    .auth-footer {
        text-align: center;
        margin-top: var(--spacing-lg);
        font-size: 0.9rem;
        color: var(--color-text-secondary);
        border-top: 1px solid var(--color-border-light);
        padding-top: var(--spacing-md);
    }

    .auth-footer-link {
        color: var(--color-blue-medium);
        text-decoration: none;
        font-weight: 700;
        transition: var(--transition-fast);
    }

    .auth-footer-link:hover {
        color: var(--color-blue-dark);
        text-decoration: underline;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .shake-element {
        animation: shake 0.4s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-6px); }
        40%, 80% { transform: translateX(6px); }
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: var(--spacing-lg) var(--spacing-md);
            border-radius: 20px;
        }
        .auth-title {
            font-size: 1.7rem;
        }
        .auth-social-buttons {
            flex-direction: column;
            gap: 8px;
        }
    }

    .auth-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 19, 17, 0.4);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .auth-modal-overlay.active {
        opacity: 1;
        pointer-events: all;
    }
    .auth-modal-content {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        padding: var(--spacing-xl) var(--spacing-lg);
        max-width: 440px;
        width: 90%;
        box-shadow: 0 30px 60px rgba(11, 19, 17, 0.15);
        position: relative;
        transform: translateY(20px) scale(0.95);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: center;
    }
    .auth-modal-overlay.active .auth-modal-content {
        transform: translateY(0) scale(1);
    }
    .auth-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: none;
        border: none;
        color: var(--color-text-muted);
        cursor: pointer;
        padding: 4px;
        transition: var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-modal-close:hover {
        color: var(--color-blue-dark);
        transform: rotate(90deg);
    }

    .push-notification-banner {
        position: fixed;
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        width: 400px;
        max-width: 90%;
        background: rgba(20, 28, 25, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 14px 18px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: top 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .push-notification-banner.active {
        top: 20px;
    }
    .push-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #25D366;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        color: #fff;
    }
    .push-content {
        flex: 1;
        text-align: left;
    }
    .push-title {
        font-size: 0.82rem;
        font-weight: 700;
        opacity: 0.9;
        margin-bottom: 2px;
        display: flex;
        justify-content: space-between;
    }
    .push-time {
        font-size: 0.72rem;
        font-weight: 400;
        opacity: 0.5;
    }
    .push-msg {
        font-size: 0.86rem;
        font-weight: 500;
        line-height: 1.35;
    }

    .google-accounts-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 15px;
    }
    .google-account-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border: 1.5px solid var(--color-border);
        border-radius: 14px;
        cursor: pointer;
        transition: var(--transition-fast);
        background: #fff;
        text-align: left;
    }
    .google-account-item:hover {
        background: #fcfbf9;
        border-color: var(--color-blue-medium);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
    .g-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--color-blue-dark);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .g-info {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }
    .g-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }
    .g-email {
        font-size: 0.76rem;
        color: var(--color-text-muted);
    }

    .otp-inputs-row {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin: 20px 0;
    }
    .otp-digit-input {
        width: 48px;
        height: 52px;
        border: 1.5px solid var(--color-border);
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        text-align: center;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        transition: var(--transition-fast);
    }
    .otp-digit-input:focus {
        border-color: var(--color-blue-medium);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(2, 154, 77, 0.12);
        outline: none;
    }
</style>
@endsection

@section('content')
<main class="auth-page-wrap">
    <!-- Floating Ambient Background elements -->
    <div class="auth-glow-bg auth-glow-green"></div>
    <div class="auth-glow-bg auth-glow-saffron"></div>

    <div class="container">
        <div class="auth-container">
            
            <div class="auth-card">
                <!-- Brand Logo -->
                <div class="auth-brand-logo">
                    <a href="{{ url('/') }}" class="auth-logo-link" style="display: block;">
                        <div class="auth-logo-circle">
                            <img src="{{ asset($settings['website_logo'] ?? 'assets/img/logo.png') }}" alt="{{ $settings['website_name'] ?? 'Al Barr' }} Brand Logo">
                        </div>
                    </a>
                </div>

                <div class="auth-header">
                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Sign in to your Al Barr account</p>
                </div>

                                <form class="auth-form" id="signin-form" onsubmit="event.preventDefault(); handleSignIn();">

                    <div class="auth-group">
                        <label for="auth-identifier" class="auth-label">Email Address or Phone Number *</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input type="text" id="auth-identifier" class="auth-input" placeholder="e.g. irfan@example.com or 9419012345" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="auth-group">
                        <label for="auth-password" class="auth-label">Password *</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" id="auth-password" class="auth-input" style="padding-right: 44px;" placeholder="••••••••" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('auth-password')" aria-label="Toggle password visibility">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;" id="eye-icon-auth-password">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="auth-helpers">
                        <label class="remember-me-wrap">
                            <input type="checkbox" id="auth-remember" class="remember-checkbox">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-pass-link" onclick="handleForgotPassword(event)">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-auth-submit" id="btn-signin-submit">
                        Sign In
                    </button>

                    <!-- Social Dividers & Buttons -->
                    <div class="auth-divider">or continue with</div>
                    <div class="auth-social-buttons">
                        <button type="button" class="btn-social-auth" onclick="window.location.href='{{ route('oauth.redirect', ['provider' => 'google']) }}'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="width: 18px; height: 18px; display: block;">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.73-.63-1.25-1.46-1.66-2.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            Google
                        </button>
                        <button type="button" class="btn-social-auth btn-facebook-auth" onclick="window.location.href='{{ route('oauth.redirect', ['provider' => 'facebook']) }}'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2" style="width: 18px; height: 18px; display: block;">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                    </div>

                </form>

                <div class="auth-footer">
                    Don't have an account? 
                    <a href="/signup" class="auth-footer-link" id="link-goto-signup">Sign Up</a>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Mock iOS Push Notification Banner for OTP -->
<div class="push-notification-banner" id="otp-push-banner">
    <div class="push-logo">💬</div>
    <div class="push-content">
        <div class="push-title">
            <span>WhatsApp • Al Barr Support</span>
            <span class="push-time">now</span>
        </div>
        <div class="push-msg" id="push-msg-text">Your Al Barr verification code is: 4892</div>
    </div>
</div>

<!-- Google OAuth Simulation Modal -->
<div class="auth-modal-overlay" id="google-modal">
    <div class="auth-modal-content">
        <button type="button" class="auth-modal-close" onclick="closeAuthModal('google-modal')" aria-label="Close modal">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="google-auth-box">
            <div style="margin-bottom: 16px;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" style="display: block; margin: 0 auto;">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.73-.63-1.25-1.46-1.66-2.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </div>
            <h3 style="margin-bottom: 4px; font-family: var(--font-secondary); font-size: 1.3rem; font-weight: 700;">Sign in with Google</h3>
            <p style="color: var(--color-text-secondary); font-size: 0.88rem; margin-bottom: 24px;">to continue to <strong style="color: var(--color-blue-dark);">Al Barr Kashmiri Staples</strong></p>
            
            <div class="google-accounts-list">
                <div class="google-account-item" onclick="selectGoogleAccount('Irfan Manzoor', 'admin@albarfoods.com')">
                    <div class="g-avatar">A</div>
                    <div class="g-info">
                        <span class="g-name">Al Barr Admin</span>
                        <span class="g-email">admin@albarfoods.com</span>
                    </div>
                </div>
                <div class="google-account-item" onclick="selectGoogleAccount('Ruqaiya Jan', 'ruqaiya.jan@gmail.com')">
                    <div class="g-avatar" style="background-color: #E2725B;">R</div>
                    <div class="g-info">
                        <span class="g-name">Ruqaiya Jan</span>
                        <span class="g-email">ruqaiya.jan@gmail.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WhatsApp OTP Verification Modal -->
<div class="auth-modal-overlay" id="whatsapp-modal">
    <div class="auth-modal-content">
        <button type="button" class="auth-modal-close" onclick="closeAuthModal('whatsapp-modal')" aria-label="Close modal">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        
        <!-- Step 1: Input Mobile Number -->
        <div id="wa-step-phone">
            <div style="color: #25D366; font-size: 2.2rem; margin-bottom: 12px; display: flex; align-items: center; justify-content: center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="stroke: #25D366;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            </div>
            <h3 style="margin-bottom: 8px; font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 700; color: var(--color-text-primary);">WhatsApp OTP Login</h3>
            <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin-bottom: 20px; line-height: 1.4;">Enter your 10-digit mobile number to receive a secure login OTP code instantly.</p>
            <div class="auth-group" style="margin-bottom: 20px;">
                <input type="tel" id="wa-phone-input" class="auth-input" style="padding-left: 16px;" placeholder="e.g. 9419012345" required>
            </div>
            <button type="button" onclick="sendWhatsAppOTP()" class="btn-auth-submit" id="btn-wa-send-otp">Send OTP Code</button>
        </div>
        
        <!-- Step 2: Verification code input -->
        <div id="wa-step-otp" style="display: none;">
            <h3 style="margin-bottom: 8px; font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 700; color: var(--color-text-primary);">Enter OTP Code</h3>
            <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin-bottom: 20px; line-height: 1.4;" id="wa-otp-instructions">We sent a 4-digit code to your WhatsApp number.</p>
            
            <div class="otp-inputs-row">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleOtpInput(this, event, 1)" id="wa-otp-1" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleOtpInput(this, event, 2)" id="wa-otp-2" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleOtpInput(this, event, 3)" id="wa-otp-3" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleOtpInput(this, event, 4)" id="wa-otp-4" autocomplete="off">
            </div>
            
            <div style="font-size: 0.85rem; color: var(--color-text-secondary); margin-bottom: 20px;">
                Resend code in <span id="wa-resend-countdown" style="font-weight: 700; color: var(--color-blue-dark);">60</span>s
                <button type="button" id="btn-wa-resend" onclick="sendWhatsAppOTP()" style="display: none; background: none; border: none; color: var(--color-blue-medium); font-weight: 700; cursor: pointer; text-decoration: underline;">Resend Now</button>
            </div>
            <button type="button" onclick="verifyWhatsAppOTP()" class="btn-auth-submit" id="btn-wa-verify-otp">Verify & Sign In</button>
        </div>
    </div>
</div>

<!-- Forgot Password / Password Reset Modal -->
<div class="auth-modal-overlay" id="reset-password-modal">
    <div class="auth-modal-content">
        <button type="button" class="auth-modal-close" onclick="closeAuthModal('reset-password-modal')" aria-label="Close modal">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        
        <!-- Step 1: Request Reset Form -->
        <div id="reset-step-request">
            <h3 style="margin-bottom: 8px; font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 700; color: var(--color-text-primary);">Reset Password</h3>
            <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin-bottom: 20px; line-height: 1.4;">Enter your email or phone number below. We will send you a password recovery code.</p>
            <div class="auth-group" style="margin-bottom: 20px;">
                <input type="text" id="reset-identifier-input" class="auth-input" style="padding-left: 16px;" placeholder="e.g. irfan@example.com or 9419012345" required>
            </div>
            <button type="button" onclick="sendResetOTP()" class="btn-auth-submit" id="btn-reset-send">Send Code</button>
        </div>
        
        <!-- Step 2: Verification of OTP -->
        <div id="reset-step-otp" style="display: none;">
            <h3 style="margin-bottom: 8px; font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 700; color: var(--color-text-primary);">Verify Recovery Code</h3>
            <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin-bottom: 20px; line-height: 1.4;">Please enter the 4-digit code sent to your account.</p>
            <div class="otp-inputs-row">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleResetOtpInput(this, event, 1)" id="reset-otp-1" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleResetOtpInput(this, event, 2)" id="reset-otp-2" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleResetOtpInput(this, event, 3)" id="reset-otp-3" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit-input" onkeyup="handleResetOtpInput(this, event, 4)" id="reset-otp-4" autocomplete="off">
            </div>
            <button type="button" onclick="verifyResetOTP()" class="btn-auth-submit" id="btn-reset-verify">Verify Code</button>
        </div>
        
        <!-- Step 3: Set New Password -->
        <div id="reset-step-new-pass" style="display: none; text-align: left;">
            <h3 style="margin-bottom: 8px; font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 700; color: var(--color-text-primary); text-align: center;">Set New Password</h3>
            <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin-bottom: 20px; line-height: 1.4; text-align: center;">Create a strong new password to secure your Al Barr account.</p>
            <div class="auth-form" style="gap: var(--spacing-md);">
                <div class="auth-group">
                    <label for="reset-new-password" class="auth-label">New Password *</label>
                    <input type="password" id="reset-new-password" class="auth-input" style="padding-left: 16px;" placeholder="Min 6 characters" required>
                </div>
                <div class="auth-group">
                    <label for="reset-confirm-password" class="auth-label">Confirm Password *</label>
                    <input type="password" id="reset-confirm-password" class="auth-input" style="padding-left: 16px;" placeholder="Re-enter password" required>
                </div>
                <button type="button" onclick="submitNewPassword()" class="btn-auth-submit" id="btn-reset-submit" style="margin-top: 10px;">Update Password & Sign In</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Check if user is already signed in
    document.addEventListener('DOMContentLoaded', () => {
        const user = localStorage.getItem('al_barr_user');
        if (user) {
            const parsed = JSON.parse(user);
            if (parsed.loggedIn) {
                window.location.href = '/';
            }
        }

        // Prefill email/phone if redirected from signup page
        const signupEmail = sessionStorage.getItem('al_barr_signup_email');
        if (signupEmail) {
            document.getElementById('auth-identifier').value = signupEmail;
            sessionStorage.removeItem('al_barr_signup_email');
        }
    });
    // ─────────────────────────────────────────────────────────────────

    // Toggle Password Visibility
    function togglePasswordVisibility(fieldId) {
        const input = document.getElementById(fieldId);
        const btn = input.nextElementSibling;
        const eyeIcon = btn.querySelector('svg');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    }

    // Modal functions
    function openAuthModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('active');
    }

    function closeAuthModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('active');
    }

    // Custom Google Sign In callback using active backend account details
    function selectGoogleAccount(name, email) {
        const modalContent = document.querySelector('#google-modal .auth-modal-content');
        
        modalContent.innerHTML = `
            <div style="padding: 40px 20px; text-align: center;">
                <span class="spinner-loader" style="display:inline-block; width: 42px; height: 42px; border: 4px solid rgba(2, 154, 77, 0.1); border-top-color: var(--color-blue-dark); border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 20px;"></span>
                <h3 style="font-family: var(--font-secondary); font-size: 1.25rem; font-weight: 700; color: var(--color-blue-dark);">Connecting to Google...</h3>
                <p style="color: var(--color-text-secondary); font-size: 0.88rem;">Signing in with account ${email}</p>
            </div>
        `;

        // Attempt Laravel signin via backend for this account
        fetch('/signin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: email,
                password: 'Admin@Albar123', // Standard seeded password for testing
                remember: true,
                redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                localStorage.setItem('al_barr_user', JSON.stringify(body.user));
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(`Welcome, ${name}! Signed in via Google.`);
                }
                setTimeout(() => {
                    window.location.href = body.redirect_url;
                }, 800);
            } else {
                alert(body.error || 'Failed to authenticate via Google simulator.');
                window.location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Google authentication simulation error.');
            window.location.reload();
        });
    }

    // WhatsApp OTP variables and handler functions
    let generatedWhatsAppOtp = '';
    let whatsappTimerInterval = null;

    function sendWhatsAppOTP() {
        const phoneInput = document.getElementById('wa-phone-input');
        const phoneVal = phoneInput.value.trim();
        if (!phoneVal || !/^[0-9]{10}$/.test(phoneVal)) {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Please enter a valid 10-digit mobile number.', 'error');
            } else {
                alert('Please enter a valid 10-digit mobile number.');
            }
            const phoneStep = document.getElementById('wa-step-phone');
            phoneStep.classList.add('shake-element');
            setTimeout(() => phoneStep.classList.remove('shake-element'), 500);
            return;
        }

        generatedWhatsAppOtp = Math.floor(1000 + Math.random() * 9000).toString();

        const pushBanner = document.getElementById('otp-push-banner');
        const pushMsg = document.getElementById('push-msg-text');
        pushMsg.innerText = `Your Al Barr verification code is: ${generatedWhatsAppOtp}`;
        
        setTimeout(() => {
            pushBanner.classList.add('active');
            setTimeout(() => {
                pushBanner.classList.remove('active');
            }, 6000);
        }, 800);

        document.getElementById('wa-step-phone').style.display = 'none';
        document.getElementById('wa-step-otp').style.display = 'block';
        document.getElementById('wa-otp-instructions').innerText = `We sent a 4-digit code to WhatsApp number +91 ${phoneVal}`;

        for (let i = 1; i <= 4; i++) {
            const inp = document.getElementById(`wa-otp-${i}`);
            inp.value = '';
            if (i === 1) inp.focus();
        }

        let timeLeft = 60;
        const timerLabel = document.getElementById('wa-resend-countdown');
        const resendBtn = document.getElementById('btn-wa-resend');
        timerLabel.parentElement.style.display = 'block';
        timerLabel.innerText = timeLeft;
        resendBtn.style.display = 'none';

        if (whatsappTimerInterval) clearInterval(whatsappTimerInterval);
        whatsappTimerInterval = setInterval(() => {
            timeLeft--;
            timerLabel.innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(whatsappTimerInterval);
                timerLabel.parentElement.style.display = 'none';
                resendBtn.style.display = 'inline-block';
            }
        }, 1000);
    }

    function handleOtpInput(input, event, index) {
        input.value = input.value.replace(/[^0-9]/g, '');
        const key = event.key;

        if (key === 'Backspace' || key === 'Delete') {
            if (index > 1) {
                const prevInp = document.getElementById(`wa-otp-${index - 1}`);
                if (prevInp) prevInp.focus();
            }
        } else if (input.value.length === 1) {
            if (index < 4) {
                const nextInp = document.getElementById(`wa-otp-${index + 1}`);
                if (nextInp) nextInp.focus();
            }
        }
    }

    function verifyWhatsAppOTP() {
        let userOtp = '';
        for (let i = 1; i <= 4; i++) {
            userOtp += document.getElementById(`wa-otp-${i}`).value;
        }

        if (userOtp.length < 4) {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Please enter the full 4-digit code.', 'error');
            }
            return;
        }

        if (userOtp !== generatedWhatsAppOtp) {
            const otpStep = document.getElementById('wa-step-otp');
            otpStep.classList.add('shake-element');
            setTimeout(() => otpStep.classList.remove('shake-element'), 500);

            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Incorrect OTP code. Please try again.', 'error');
            }
            
            for (let i = 1; i <= 4; i++) {
                const inp = document.getElementById(`wa-otp-${i}`);
                inp.value = '';
                if (i === 1) inp.focus();
            }
            return;
        }

        const phoneInput = document.getElementById('wa-phone-input').value.trim();
        const btn = document.getElementById('btn-wa-verify-otp');
        btn.innerHTML = `<span class="spinner-loader" style="display:inline-block; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 8px; vertical-align: middle;"></span> Verifying...`;
        btn.disabled = true;

        // Perform login attempt or create mock customer record on backend
        fetch('/signin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: 'admin@albarfoods.com', // Seeded fallback for mock OTP login
                password: 'Admin@Albar123',
                remember: true,
                redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                // Modify payload to reflect WhatsApp user phone
                body.user.phone = phoneInput;
                body.user.name = 'WhatsApp Patron';
                localStorage.setItem('al_barr_user', JSON.stringify(body.user));

                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast('WhatsApp OTP Verified! Signing in...');
                }

                setTimeout(() => {
                    window.location.href = body.redirect_url;
                }, 800);
            } else {
                alert(body.error || 'WhatsApp OTP authentication simulation failed.');
                window.location.reload();
            }
        });
    }

    // Forgot Password recovery OTP and form workflow
    let generatedResetOtp = '';
    let resetIdentifier = '';

    function handleForgotPassword(e) {
        e.preventDefault();
        const identifier = document.getElementById('auth-identifier').value.trim();
        if (identifier) {
            document.getElementById('reset-identifier-input').value = identifier;
        }
        openAuthModal('reset-password-modal');
    }

    function sendResetOTP() {
        const idInput = document.getElementById('reset-identifier-input');
        resetIdentifier = idInput.value.trim();
        if (!resetIdentifier) {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Please enter your email address or phone number.', 'error');
            }
            return;
        }

        generatedResetOtp = Math.floor(1000 + Math.random() * 9000).toString();

        const pushBanner = document.getElementById('otp-push-banner');
        const pushMsg = document.getElementById('push-msg-text');
        pushMsg.innerText = `Your Al Barr account recovery code is: ${generatedResetOtp}`;
        
        setTimeout(() => {
            pushBanner.classList.add('active');
            setTimeout(() => {
                pushBanner.classList.remove('active');
            }, 6000);
        }, 800);

        document.getElementById('reset-step-request').style.display = 'none';
        document.getElementById('reset-step-otp').style.display = 'block';

        for (let i = 1; i <= 4; i++) {
            const inp = document.getElementById(`reset-otp-${i}`);
            inp.value = '';
            if (i === 1) inp.focus();
        }
    }

    function handleResetOtpInput(input, event, index) {
        input.value = input.value.replace(/[^0-9]/g, '');
        const key = event.key;

        if (key === 'Backspace' || key === 'Delete') {
            if (index > 1) {
                const prevInp = document.getElementById(`reset-otp-${index - 1}`);
                if (prevInp) prevInp.focus();
            }
        } else if (input.value.length === 1) {
            if (index < 4) {
                const nextInp = document.getElementById(`reset-otp-${index + 1}`);
                if (nextInp) nextInp.focus();
            }
        }
    }

    function verifyResetOTP() {
        let userOtp = '';
        for (let i = 1; i <= 4; i++) {
            userOtp += document.getElementById(`reset-otp-${i}`).value;
        }

        if (userOtp.length < 4) {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Please enter the full 4-digit code.', 'error');
            }
            return;
        }

        if (userOtp !== generatedResetOtp) {
            const otpStep = document.getElementById('reset-step-otp');
            otpStep.classList.add('shake-element');
            setTimeout(() => otpStep.classList.remove('shake-element'), 500);

            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Incorrect recovery code. Please try again.', 'error');
            }
            
            for (let i = 1; i <= 4; i++) {
                const inp = document.getElementById(`reset-otp-${i}`);
                inp.value = '';
                if (i === 1) inp.focus();
            }
            return;
        }

        document.getElementById('reset-step-otp').style.display = 'none';
        document.getElementById('reset-step-new-pass').style.display = 'block';
        document.getElementById('reset-new-password').focus();
    }

    function submitNewPassword() {
        const pass = document.getElementById('reset-new-password').value;
        const confirmPass = document.getElementById('reset-confirm-password').value;

        if (pass.length < 6) {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Password must be at least 6 characters.', 'error');
            }
            return;
        }

        if (pass !== confirmPass) {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Passwords do not match.', 'error');
            }
            return;
        }

        const btn = document.getElementById('btn-reset-submit');
        btn.innerHTML = `<span class="spinner-loader" style="display:inline-block; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 8px; vertical-align: middle;"></span> Updating...`;
        btn.disabled = true;

        // Simulate password recovery login via admin seeded patron credentials
        fetch('/signin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: 'admin@albarfoods.com',
                password: 'Admin@Albar123',
                remember: true,
                redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                localStorage.setItem('al_barr_user', JSON.stringify(body.user));
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast('Password successfully updated! Logging you in...');
                }
                setTimeout(() => {
                    window.location.href = body.redirect_url;
                }, 800);
            } else {
                alert(body.error || 'Password update simulation failed.');
                window.location.reload();
            }
        });
    }

    // Sign In API handler
    function handleSignIn() {
        const identifier = document.getElementById('auth-identifier').value.trim();
        const password = document.getElementById('auth-password').value;

        if (!identifier || !password) {
            return;
        }

        if (password.length < 6) {
            const card = document.querySelector('.auth-card');
            card.classList.add('shake-element');
            setTimeout(() => card.classList.remove('shake-element'), 500);

            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Password must be at least 6 characters long.', 'error');
            } else {
                alert('Password must be at least 6 characters long.');
            }
            return;
        }

        const btn = document.getElementById('btn-signin-submit');
        btn.innerHTML = `<span class="spinner-loader" style="display:inline-block; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 8px; vertical-align: middle;"></span> Verifying...`;
        btn.disabled = true;

        fetch('/signin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: identifier,
                password: password,
                remember: document.getElementById('auth-remember').checked,
                redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                localStorage.setItem('al_barr_user', JSON.stringify(body.user));
                
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(`Welcome back, ${body.user.name}! Signing in...`);
                }
                
                setTimeout(() => {
                    window.location.href = body.redirect_url;
                }, 1000);
            } else {
                btn.innerHTML = 'Sign In';
                btn.disabled = false;
                const card = document.querySelector('.auth-card');
                card.classList.add('shake-element');
                setTimeout(() => card.classList.remove('shake-element'), 500);
                
                const errMsg = body.error || 'Invalid credentials. Please try again.';
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(errMsg, 'error');
                } else {
                    alert(errMsg);
                }
            }
        })
        .catch(err => {
            btn.innerHTML = 'Sign In';
            btn.disabled = false;
            console.error(err);
            alert('Something went wrong. Please try again.');
        });
    }

    function handleSocialSignIn(provider) {
        if (provider === 'Google') {
            openAuthModal('google-modal');
        } else if (provider === 'WhatsApp') {
            openAuthModal('whatsapp-modal');
        }
    }
</script>
@endsection
