@extends('layouts.app')

@section('title', 'My Profile - Al Barr | Kashmiri Organic Staples')

@section('styles')
<style>
    .profile-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        min-height: 80vh;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Glow Spheres */
    .profile-glow {
        position: absolute;
        width: 450px;
        height: 450px;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.08;
        z-index: 1;
        pointer-events: none;
    }
    .profile-glow-green { background: var(--color-blue-dark); top: -5%; left: -5%; }
    .profile-glow-saffron { background: var(--color-saffron-orange); bottom: -5%; right: -5%; }

    .profile-container {
        max-width: 960px;
        margin: 0 auto;
        width: 100%;
        position: relative;
        z-index: 5;
        padding: 0 var(--spacing-md);
    }

    .profile-header {
        text-align: center;
        margin-bottom: var(--spacing-xl);
    }

    .profile-title {
        font-family: var(--font-secondary);
        font-size: 2.3rem;
        color: var(--color-blue-dark);
        font-weight: 800;
        margin-bottom: 8px;
    }

    .profile-subtitle {
        color: var(--color-text-secondary);
        font-size: 1.02rem;
    }

    /* Account Switch Tab Layout */
    .profile-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: var(--spacing-xl);
        align-items: start;
    }

    /* Sidebar Navigation */
    .profile-sidebar {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
        text-align: center;
    }

    .profile-avatar-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-bottom: var(--spacing-sm);
    }

    .profile-avatar-circle {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--color-blue-dark);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-family: var(--font-secondary);
        font-weight: 700;
        border: 4px solid #fff;
        box-shadow: var(--shadow-md);
        position: relative;
        cursor: pointer;
        transition: var(--transition-fast);
    }

    .profile-avatar-circle:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(1, 136, 73, 0.2);
    }

    .profile-avatar-edit-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--color-saffron-orange);
        color: #fff;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        border: 2px solid #fff;
    }

    .profile-user-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0;
    }

    .profile-user-role {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--color-saffron-orange);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: -6px;
    }

    .profile-side-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
    }

    .profile-side-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--color-text-secondary);
        font-weight: 600;
        font-size: 0.92rem;
        transition: var(--transition-fast);
        cursor: pointer;
        text-decoration: none;
    }

    .profile-side-link:hover {
        background-color: rgba(1, 136, 73, 0.05);
        color: var(--color-blue-dark);
    }

    .profile-side-link.active {
        background-color: var(--color-blue-dark);
        color: #fff;
    }

    /* Form Details Card */
    .profile-content-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 24px;
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        text-align: left;
    }

    .content-section-title {
        font-family: var(--font-secondary);
        font-size: 1.4rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-lg);
        border-bottom: 1.5px solid var(--color-border-light);
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    .form-full-row {
        grid-column: span 2;
    }

    .profile-input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .profile-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-input {
        width: 100%;
        padding: 12px 14px;
        background-color: var(--color-cream);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-size: 0.95rem;
        color: var(--color-text-primary);
        transition: var(--transition-fast);
    }

    .profile-input:focus {
        border-color: var(--color-blue-medium);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(2, 154, 77, 0.08);
        outline: none;
    }

    .profile-input:disabled {
        background-color: rgba(0,0,0,0.03);
        color: var(--color-text-muted);
        cursor: not-allowed;
    }

    /* Payment selection radio blocks */
    .payment-prefs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-lg);
    }

    .payment-pref-card {
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-xs);
        padding: var(--spacing-md);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-align: center;
        transition: var(--transition-fast);
        position: relative;
    }

    .payment-pref-card:hover {
        border-color: var(--color-blue-medium);
        background-color: rgba(2, 154, 77, 0.02);
    }

    .payment-pref-card.active {
        border-color: var(--color-blue-dark);
        background-color: var(--color-blue-light);
    }

    .payment-pref-icon {
        font-size: 1.5rem;
    }

    .payment-pref-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    .payment-pref-check {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: var(--color-blue-dark);
        color: #fff;
        font-size: 0.65rem;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .payment-pref-card.active .payment-pref-check {
        display: flex;
    }

    .btn-profile-save {
        padding: 13px 32px;
        background: var(--color-saffron-gradient);
        color: #fff;
        border: none;
        border-radius: var(--radius-xs);
        font-weight: 700;
        font-family: var(--font-secondary);
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition-fast);
        box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-profile-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
    }

    /* Guest State / Logged-out Card */
    .profile-guest-card {
        max-width: 500px;
        margin: var(--spacing-xxl) auto;
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 24px;
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-lg);
        text-align: center;
    }

    .guest-icon {
        font-size: 3.5rem;
        margin-bottom: var(--spacing-md);
    }

    .guest-title {
        font-family: var(--font-secondary);
        font-size: 1.5rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .guest-text {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: var(--spacing-lg);
    }

    .guest-buttons {
        display: flex;
        gap: var(--spacing-md);
        justify-content: center;
    }

    .btn-guest-signin {
        padding: 12px 28px;
        background-color: var(--color-blue-dark);
        color: #fff;
        border-radius: var(--radius-xs);
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition-fast);
        text-decoration: none;
    }

    .btn-guest-signin:hover {
        background-color: var(--color-blue-medium);
    }

    .btn-guest-signup {
        padding: 12px 28px;
        border: 1.5px solid var(--color-border);
        color: var(--color-blue-dark);
        border-radius: var(--radius-xs);
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition-fast);
        text-decoration: none;
    }

    .btn-guest-signup:hover {
        background-color: var(--color-cream);
    }

    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-full-row {
            grid-column: span 1;
        }
        .payment-prefs-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $defaultAddress = $addresses->first();
@endphp
<main class="profile-page-wrap">
    <!-- Floating spheres -->
    <div class="profile-glow profile-glow-green"></div>
    <div class="profile-glow profile-glow-saffron"></div>

    <div class="profile-container">
        
        <!-- Logged-in Dashboard View -->
        <div id="profile-dashboard-view">
            <div class="profile-header">
                <h1 class="profile-title">My Account</h1>
                <p class="profile-subtitle">Review personal credentials, secure orchard delivery addresses, and set default payment channels.</p>
            </div>

            <div class="profile-grid">
                
                <!-- Left: Navigation Sidebar -->
                <aside class="profile-sidebar">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar-circle" id="profile-avatar-img" onclick="triggerAvatarRegen()">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                            <div class="profile-avatar-edit-badge" title="Regenerate theme background">♻️</div>
                        </div>
                        <h3 class="profile-user-name" id="profile-display-name">{{ $user->name }}</h3>
                        <span class="profile-user-role">Al Barr Patron</span>
                    </div>

                    <ul class="profile-side-menu">
                        <li><a href="/profile" class="profile-side-link active">👤 Personal Profile</a></li>
                        <li><a href="/orders" class="profile-side-link">📦 My Orders</a></li>
                        <li><a href="/wishlist" class="profile-side-link">❤️ My Wishlist</a></li>
                        <li><a href="/tickets" class="profile-side-link">🎟️ Support Tickets</a></li>
                        <li><a href="/track-order" class="profile-side-link">📍 Track Shipment</a></li>
                        <li><a href="#" onclick="handleHeaderSignOut(event)" class="profile-side-link" style="color: var(--color-red);">🚪 Sign Out</a></li>
                    </ul>
                </aside>

                <!-- Right: Editor Cards -->
                <div class="profile-content-card">
                    
                    <form id="profile-form" onsubmit="handleProfileSave(event)">
                        <h3 class="content-section-title">
                            <span>👤</span> Credentials Info
                        </h3>

                        <div class="form-grid">
                            <div class="profile-input-group">
                                <label for="prof-name" class="profile-label">Full Name *</label>
                                <input type="text" id="prof-name" class="profile-input" value="{{ $user->name }}" required>
                            </div>
                            <div class="profile-input-group">
                                <label for="prof-email" class="profile-label">Email Address *</label>
                                <input type="email" id="prof-email" class="profile-input" value="{{ $user->email }}" required disabled>
                            </div>
                            <div class="profile-input-group form-full-row">
                                <label for="prof-phone" class="profile-label">Mobile Number *</label>
                                <input type="tel" id="prof-phone" class="profile-input" value="{{ $user->phone }}" required>
                            </div>
                        </div>

                        <h3 class="content-section-title" style="margin-top: var(--spacing-xl);">
                            <span>📍</span> Orchard Shipping Address
                        </h3>

                        <div class="form-grid">
                            <div class="profile-input-group form-full-row">
                                <label for="prof-address" class="profile-label">Street Address *</label>
                                <input type="text" id="prof-address" class="profile-input" placeholder="e.g. House No., Street, Sector" value="{{ $defaultAddress ? $defaultAddress->address : '' }}" required>
                            </div>
                            <div class="profile-input-group">
                                <label for="prof-city" class="profile-label">City *</label>
                                <input type="text" id="prof-city" class="profile-input" placeholder="e.g. Srinagar" value="{{ $defaultAddress ? $defaultAddress->city : 'Srinagar' }}" required>
                            </div>
                            <div class="profile-input-group">
                                <label for="prof-pincode" class="profile-label">Pin Code *</label>
                                <input type="text" id="prof-pincode" class="profile-input" placeholder="e.g. 190006" value="{{ $defaultAddress ? $defaultAddress->pincode : '' }}" required>
                            </div>
                            <div class="profile-input-group form-full-row">
                                <label for="prof-landmark" class="profile-label">Landmark</label>
                                <input type="text" id="prof-landmark" class="profile-input" placeholder="e.g. Near University Main Gate" value="{{ $defaultAddress ? $defaultAddress->landmark : '' }}">
                            </div>
                        </div>

                        <h3 class="content-section-title" style="margin-top: var(--spacing-xl);">
                            <span>💳</span> Default Payment Preference
                        </h3>

                        <div class="payment-prefs-grid">
                            <!-- COD -->
                            <div class="payment-pref-card active" id="pref-pay-cod" onclick="selectPaymentPref('cod')">
                                <div class="payment-pref-check">✓</div>
                                <div class="payment-pref-icon">💵</div>
                                <div class="payment-pref-title">Cash on Delivery</div>
                            </div>
                            <!-- UPI -->
                            <div class="payment-pref-card" id="pref-pay-upi" onclick="selectPaymentPref('upi')">
                                <div class="payment-pref-check">✓</div>
                                <div class="payment-pref-icon">📱</div>
                                <div class="payment-pref-title">UPI / QR Scan</div>
                            </div>
                            <!-- Bank Transfer -->
                            <div class="payment-pref-card" id="pref-pay-bank" onclick="selectPaymentPref('bank')">
                                <div class="payment-pref-check">✓</div>
                                <div class="payment-pref-icon">🏛️</div>
                                <div class="payment-pref-title">Direct J&K Bank</div>
                            </div>
                        </div>

                        <div style="text-align: right; margin-top: var(--spacing-lg);">
                            <button type="submit" class="btn-profile-save" id="btn-save-profile">
                                <span>💾</span> Save Changes
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
    let selectedPaymentMethod = 'cod';
    const AVATAR_PALETTES = [
        { bg: '#018849', color: '#ffffff' },
        { bg: '#FF5500', color: '#ffffff' },
        { bg: '#FFB300', color: '#000000' },
        { bg: '#0b192c', color: '#ffffff' },
        { bg: '#4a3f35', color: '#ffffff' }
    ];

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize client side settings from local storage
        const userJson = localStorage.getItem('al_barr_user');
        if (userJson) {
            try {
                const userData = JSON.parse(userJson);
                selectedPaymentMethod = userData.paymentPref || 'cod';
                selectPaymentPref(selectedPaymentMethod);
            } catch(e) {}
        }
        
        // Restore avatar color choice if saved
        const savedColorIdx = localStorage.getItem('al_barr_avatar_color_idx') || 0;
        applyAvatarPalette(savedColorIdx);
    });

    // Toggle Payment selection card
    function selectPaymentPref(method) {
        selectedPaymentMethod = method;
        document.querySelectorAll('.payment-pref-card').forEach(card => card.classList.remove('active'));
        
        if (method === 'cod') {
            document.getElementById('pref-pay-cod').classList.add('active');
        } else if (method === 'upi') {
            document.getElementById('pref-pay-upi').classList.add('active');
        } else if (method === 'bank') {
            document.getElementById('pref-pay-bank').classList.add('active');
        }
    }

    // Letter avatar color randomiser
    function triggerAvatarRegen() {
        const currentIdx = parseInt(localStorage.getItem('al_barr_avatar_color_idx') || 0);
        const nextIdx = (currentIdx + 1) % AVATAR_PALETTES.length;
        localStorage.setItem('al_barr_avatar_color_idx', nextIdx);
        applyAvatarPalette(nextIdx);
        
        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
            AlBarrCart.showToast('Profile theme accent updated!');
        }
    }

    function applyAvatarPalette(idx) {
        const palette = AVATAR_PALETTES[idx] || AVATAR_PALETTES[0];
        const avatarDiv = document.getElementById('profile-avatar-img');
        if (avatarDiv) {
            avatarDiv.style.backgroundColor = palette.bg;
            avatarDiv.style.color = palette.color;
        }
    }

    // Save Form action using Laravel routes
    function handleProfileSave(e) {
        e.preventDefault();
        
        const btn = document.getElementById('btn-save-profile');
        const originalHtml = btn.innerHTML;
        btn.innerHTML = `<span class="spinner-loader" style="display:inline-block; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 8px; vertical-align: middle;"></span> Saving...`;
        btn.disabled = true;

        const name = document.getElementById('prof-name').value.trim();
        const phone = document.getElementById('prof-phone').value.trim();
        const address = document.getElementById('prof-address').value.trim();
        const city = document.getElementById('prof-city').value.trim();
        const pincode = document.getElementById('prof-pincode').value.trim();
        const landmark = document.getElementById('prof-landmark').value.trim();

        // 1. Save credentials to Laravel
        fetch('/profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: name,
                phone: phone
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status !== 200) {
                throw new Error(body.error || 'Failed to update personal credentials');
            }

            // 2. Save Address to Laravel
            return fetch('/profile/address', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    label: 'Home',
                    name: name,
                    phone: phone,
                    pincode: pincode,
                    city: city,
                    address: address,
                    landmark: landmark
                })
            });
        })
        .then(response => response.json())
        .then(addrData => {
            if (addrData.success) {
                // Update Local Storage User details
                const userJson = localStorage.getItem('al_barr_user');
                if (userJson) {
                    try {
                        const userData = JSON.parse(userJson);
                        userData.name = name;
                        userData.phone = phone;
                        userData.address = address;
                        userData.city = city;
                        userData.pincode = pincode;
                        userData.landmark = landmark;
                        userData.paymentPref = selectedPaymentMethod;
                        localStorage.setItem('al_barr_user', JSON.stringify(userData));
                    } catch(e) {}
                }

                // Update welcomes in header
                document.getElementById('profile-display-name').innerText = name;
                const headerWelcomeVal = document.getElementById('header-user-welcome-val');
                if (headerWelcomeVal) {
                    headerWelcomeVal.innerHTML = `${name} <svg class="badge-arrow-down" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 2px; transition: transform var(--transition-fast);"><polyline points="6 9 12 15 18 9"></polyline></svg>`;
                }
                const dropdownWelcome = document.getElementById('header-dropdown-welcome');
                if (dropdownWelcome) dropdownWelcome.innerText = `Namaste, ${name}!`;
                
                const drawerWelcome = document.getElementById('drawer-user-welcome');
                if (drawerWelcome) drawerWelcome.innerText = `Welcome, ${name}`;

                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast('Profile and address saved successfully!');
                } else {
                    alert('Profile and address saved successfully!');
                }
            } else {
                throw new Error(addrData.error || 'Failed to update shipping address');
            }
        })
        .catch(err => {
            console.error(err);
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast(err.message || 'Verification failed. Please try again.', 'error');
            } else {
                alert(err.message || 'Verification failed. Please try again.');
            }
        })
        .finally(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        });
    }
</script>
@endsection
