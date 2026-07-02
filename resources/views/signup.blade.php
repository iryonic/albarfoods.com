@extends('layouts.app')

@section('title', 'Register & Sign Up - Al Barr | Kashmiri Organic Staples')

@section('styles')
<style>
    .auth-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        min-height: 80vh;
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

    .password-strength-meter {
        height: 4px;
        background-color: var(--color-border-light);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 2px;
        display: none;
    }

    .password-strength-bar {
        height: 100%;
        width: 0;
        transition: width 0.3s ease, background-color 0.3s ease;
    }

    .password-strength-text {
        font-size: 0.78rem;
        font-weight: 700;
        margin-top: 4px;
    }

    .password-checklist {
        display: none;
        flex-direction: column;
        gap: 6px;
        margin-top: 4px;
        background: rgba(11, 25, 44, 0.02);
        padding: 12px;
        border-radius: 12px;
        border: 1px solid var(--color-border);
    }

    .checklist-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: var(--color-text-muted);
        font-weight: 600;
        transition: var(--transition-fast);
    }

    .checklist-item.valid {
        color: var(--color-blue-dark);
    }

    .chk-icon {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .password-match-indicator {
        font-size: 0.78rem;
        font-weight: 700;
        margin-top: 4px;
        display: none;
    }

    .terms-label-wrap {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 0.85rem;
        color: var(--color-text-secondary);
        cursor: pointer;
        line-height: 1.4;
    }

    .terms-checkbox {
        accent-color: var(--color-blue-dark);
        width: 16px;
        height: 16px;
        margin-top: 2px;
        flex-shrink: 0;
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
                    <h1 class="auth-title">Create Account</h1>
                    <p class="auth-subtitle">Join the Al Barr organic family</p>
                </div>

                <form class="auth-form" id="signup-form" onsubmit="event.preventDefault(); handleSignUp();">
                    
                    <!-- Full Name -->
                    <div class="auth-group">
                        <label for="reg-name" class="auth-label">Full Name *</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input type="text" id="reg-name" class="auth-input" placeholder="e.g. Irfan Manzoor" required>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="auth-group">
                        <label for="reg-email" class="auth-label">Email Address *</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input type="email" id="reg-email" class="auth-input" placeholder="e.g. irfan@example.com" required>
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div class="auth-group">
                        <label for="reg-phone" class="auth-label">Mobile Number (Optional)</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </span>
                            <input type="tel" id="reg-phone" class="auth-input" placeholder="e.g. 9419012345" maxlength="10">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="auth-group">
                        <label for="reg-password" class="auth-label">Choose Password *</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" id="reg-password" class="auth-input" style="padding-right: 44px;" placeholder="Min 6 characters" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('reg-password')" aria-label="Toggle password visibility">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;" id="eye-icon-reg-password">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>

                        <!-- Strength Meter Checklist -->
                        <div class="password-strength-meter" id="pass-strength-meter">
                            <div class="password-strength-bar" id="pass-strength-bar"></div>
                        </div>
                        <div class="password-strength-text" id="pass-strength-text"></div>
                        
                        <div class="password-checklist" id="reg-password-checklist">
                            <div class="checklist-item" id="chk-length">
                                <svg class="chk-icon"></svg>
                                <span>At least 6 characters long</span>
                            </div>
                            <div class="checklist-item" id="chk-case">
                                <svg class="chk-icon"></svg>
                                <span>Mix of UPPER and lowercase letters</span>
                            </div>
                            <div class="checklist-item" id="chk-num-spec">
                                <svg class="chk-icon"></svg>
                                <span>Contains a number or special character</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="auth-group">
                        <label for="reg-confirm-password" class="auth-label">Confirm Password *</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" id="reg-confirm-password" class="auth-input" style="padding-right: 44px;" placeholder="Re-enter password" required>
                        </div>
                        <div class="password-match-indicator" id="pass-match-indicator"></div>
                    </div>

                    <!-- Terms & Conditions Checkbox -->
                    <div class="auth-group" style="margin-top: 4px;">
                        <label class="terms-label-wrap">
                            <input type="checkbox" id="reg-terms" class="terms-checkbox" required>
                            <span>I agree to Al Barr's <a href="/terms" target="_blank" style="color: var(--color-blue-medium); font-weight:700;">Terms &amp; Conditions</a> and <a href="/privacy" target="_blank" style="color: var(--color-blue-medium); font-weight:700;">Privacy Policy</a>.</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-auth-submit" id="btn-signup-submit">
                        Register &amp; Sign Up
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
                    Already have an account? 
                    <a href="/signin" class="auth-footer-link" id="link-goto-signin">Sign In</a>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Simulation modals removed -->
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
    });

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

    // Password Strength Analyzer Checklist
    const regPassword = document.getElementById('reg-password');
    const strengthMeter = document.getElementById('pass-strength-meter');
    const strengthBar = document.getElementById('pass-strength-bar');
    const strengthText = document.getElementById('pass-strength-text');
    const checklist = document.getElementById('reg-password-checklist');

    const chkLength = document.getElementById('chk-length');
    const chkCase = document.getElementById('chk-case');
    const chkNumSpec = document.getElementById('chk-num-spec');

    regPassword.addEventListener('input', () => {
        const val = regPassword.value;
        if (val.length > 0) {
            strengthMeter.style.display = 'flex';
            checklist.style.display = 'flex';
        } else {
            strengthMeter.style.display = 'none';
            checklist.style.display = 'none';
        }

        const hasLength = val.length >= 6;
        toggleChecklistItem(chkLength, hasLength);

        const hasCase = /[a-z]/.test(val) && /[A-Z]/.test(val);
        toggleChecklistItem(chkCase, hasCase);

        const hasNumSpec = /[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val);
        toggleChecklistItem(chkNumSpec, hasNumSpec);

        let score = 0;
        if (hasLength) score++;
        if (hasCase) score++;
        if (hasNumSpec) score++;

        let barWidth = '0%';
        let barColor = 'var(--color-border-light)';
        let strengthLabel = 'Weak';

        if (val.length > 0) {
            if (score === 1) {
                barWidth = '33%';
                barColor = '#EA4335';
                strengthLabel = 'Weak';
            } else if (score === 2) {
                barWidth = '66%';
                barColor = '#FBBC05';
                strengthLabel = 'Medium';
            } else if (score === 3) {
                barWidth = '100%';
                barColor = 'var(--color-blue-dark)';
                strengthLabel = 'Strong';
            }
        }

        strengthBar.style.width = barWidth;
        strengthBar.style.backgroundColor = barColor;
        strengthText.innerText = `Password Strength: ${strengthLabel}`;
        strengthText.style.color = score === 3 ? 'var(--color-blue-dark)' : score === 2 ? '#FBBC05' : '#EA4335';
    });

    function toggleChecklistItem(item, isValid) {
        const icon = item.querySelector('.chk-icon');
        if (isValid) {
            item.classList.add('valid');
            icon.innerHTML = `
                <polyline points="20 6 9 17 4 12" style="stroke: var(--color-blue-dark); stroke-width: 3; fill: none;"></polyline>
            `;
            icon.setAttribute('viewBox', '0 0 24 24');
        } else {
            item.classList.remove('valid');
            icon.innerHTML = `
                <circle cx="12" cy="12" r="10" style="stroke: var(--color-text-muted); stroke-width: 3; fill: none;"></circle>
            `;
            icon.setAttribute('viewBox', '0 0 24 24');
        }
    }

    const regConfirmPassword = document.getElementById('reg-confirm-password');
    const matchIndicator = document.getElementById('pass-match-indicator');

    function checkPasswordMatch() {
        const pass = regPassword.value;
        const confirmPass = regConfirmPassword.value;

        if (confirmPass.length === 0) {
            matchIndicator.style.display = 'none';
            regConfirmPassword.style.borderColor = 'var(--color-border)';
            return;
        }

        matchIndicator.style.display = 'block';
        if (pass === confirmPass) {
            matchIndicator.innerText = '✓ Passwords match';
            matchIndicator.style.color = 'var(--color-blue-dark)';
            regConfirmPassword.style.borderColor = 'var(--color-blue-dark)';
        } else {
            matchIndicator.innerText = '✗ Passwords do not match';
            matchIndicator.style.color = '#EA4335';
            regConfirmPassword.style.borderColor = '#EA4335';
        }
    }

    regPassword.addEventListener('input', checkPasswordMatch);
    regConfirmPassword.addEventListener('input', checkPasswordMatch);

    function shakeCard() {
        const card = document.querySelector('.auth-card');
        card.classList.add('shake-element');
        setTimeout(() => { card.classList.remove('shake-element'); }, 500);
    }

    // Sign Up action using actual Laravel Auth controller endpoint
    function handleSignUp() {
        const name = document.getElementById('reg-name').value.trim();
        const email = document.getElementById('reg-email').value.trim();
        const phone = document.getElementById('reg-phone').value.trim();
        const password = document.getElementById('reg-password').value;
        const confirmPassword = document.getElementById('reg-confirm-password').value;
        const termsChecked = document.getElementById('reg-terms').checked;


        if (!name || !email || !phone || !password || !confirmPassword || !termsChecked) {
            shakeCard();
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Please fill in all required fields.', 'error');
            }
            return;
        }

        const hasLength = password.length >= 6;
        const hasCase = /[a-z]/.test(password) && /[A-Z]/.test(password);
        const hasNumSpec = /[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password);
        const isStrong = hasLength && hasCase && hasNumSpec;

        if (!isStrong) {
            shakeCard();
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Please satisfy all password strength requirements.', 'error');
            } else {
                alert('Please satisfy all password strength requirements.');
            }
            return;
        }

        if (password !== confirmPassword) {
            shakeCard();
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Passwords do not match. Please check again.', 'error');
            } else {
                alert('Passwords do not match.');
            }
            return;
        }

        const btn = document.getElementById('btn-signup-submit');
        btn.innerHTML = `<span class="spinner-loader" style="display:inline-block; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 8px; vertical-align: middle;"></span> Registering...`;
        btn.disabled = true;

        fetch('/signup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone,
                password: password
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                sessionStorage.setItem('al_barr_signup_email', email);
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(`Account registered successfully! Redirecting to sign in...`);
                }
                setTimeout(() => {
                    const params = new URLSearchParams(window.location.search);
                    const redirectParam = params.get('redirect') ? `?redirect=${encodeURIComponent(params.get('redirect'))}` : '';
                    window.location.href = `/signin${redirectParam}`;
                }, 1200);
            } else {
                btn.innerHTML = 'Register & Sign Up';
                btn.disabled = false;
                shakeCard();
                let errMsg = '';
                if (body.errors) {
                    errMsg = Object.values(body.errors).flat().join(' ');
                } else {
                    errMsg = body.error || body.message || 'Registration failed. Please try again.';
                }
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(errMsg, 'error');
                } else {
                    alert(errMsg);
                }
            }
        })
        .catch(err => {
            btn.innerHTML = 'Register & Sign Up';
            btn.disabled = false;
            console.error(err);
            alert('Something went wrong. Please try again.');
        });
    }

    function openAuthModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('active');
    }

    function closeAuthModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('active');
    }

    function handleSocialSignUp(provider) {
        if (provider === 'Google') {
            openAuthModal('google-modal');
        } else if (provider === 'WhatsApp') {
            openAuthModal('whatsapp-modal');
        }
    }

    function selectGoogleAccount(name, email) {
        const modalContent = document.querySelector('#google-modal .auth-modal-content');
        modalContent.innerHTML = `
            <div style="padding: 40px 20px; text-align: center;">
                <span class="spinner-loader" style="display:inline-block; width: 42px; height: 42px; border: 4px solid rgba(2, 154, 77, 0.1); border-top-color: var(--color-blue-dark); border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 20px;"></span>
                <h3 style="font-family: var(--font-secondary); font-size: 1.25rem; font-weight: 700; color: var(--color-blue-dark);">Connecting to Google...</h3>
                <p style="color: var(--color-text-secondary); font-size: 0.88rem;">Signing up with account ${email}</p>
            </div>
        `;

        // Attempt signup simulation on backend (registers as customer)
        fetch('/signup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: name,
                email: email,
                phone: '9906' + Math.floor(100000 + Math.random() * 900000).toString(),
                password: 'Admin@Albar123'
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                // Now sign in automatically
                fetch('/signin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email,
                        password: 'Admin@Albar123',
                        remember: true,
                        redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
                    })
                })
                .then(r => r.json())
                .then(signinData => {
                    if (signinData.success) {
                        localStorage.setItem('al_barr_user', JSON.stringify(signinData.user));
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast(`Welcome, ${name}! Registered & logged in.`);
                        }
                        setTimeout(() => {
                            window.location.href = signinData.redirect_url;
                        }, 800);
                    } else {
                        window.location.href = '/signin';
                    }
                });
            } else {
                // If already registered, just log in!
                fetch('/signin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email,
                        password: 'Admin@Albar123',
                        remember: true,
                        redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
                    })
                })
                .then(r => r.json())
                .then(signinData => {
                    if (signinData.success) {
                        localStorage.setItem('al_barr_user', JSON.stringify(signinData.user));
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast(`Welcome back, ${name}! Signed in via Google.`);
                        }
                        setTimeout(() => {
                            window.location.href = signinData.redirect_url;
                        }, 800);
                    } else {
                        alert(body.error || body.message || 'Google signup simulation failed.');
                        window.location.reload();
                    }
                });
            }
        })
        .catch(err => {
            console.error(err);
            alert('Google registration simulation error.');
            window.location.reload();
        });
    }

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

        // Auto-signup & login via WhatsApp
        const waEmail = 'wa.' + phoneInput + '@albarfoods.com';
        fetch('/signup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: 'WhatsApp Patron',
                email: waEmail,
                phone: phoneInput,
                password: 'Admin@Albar123'
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            fetch('/signin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: waEmail,
                    password: 'Admin@Albar123',
                    remember: true,
                    redirect_url: new URLSearchParams(window.location.search).get('redirect') || ''
                })
            })
            .then(r => r.json())
            .then(signinData => {
                if (signinData.success) {
                    localStorage.setItem('al_barr_user', JSON.stringify(signinData.user));
                    if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                        AlBarrCart.showToast('WhatsApp OTP Verified! Signing in...');
                    }
                    setTimeout(() => {
                        window.location.href = signinData.redirect_url;
                    }, 800);
                } else {
                    window.location.reload();
                }
            });
        });
    }
</script>
@endsection
