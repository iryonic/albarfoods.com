@extends('layouts.admin')

@section('title', 'Global Settings — Al Barr Admin')
@section('header_title', 'Global Settings')

@section('styles')
<style>
    /* ─── Page Header ─── */
    .settings-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: var(--spacing-xl);
    }

    .settings-hero h2 {
        font-family: var(--font-secondary);
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0;
    }

    .settings-hero p {
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        margin: 4px 0 0;
    }

    /* ─── Layout: Nav + Content Side by Side ─── */
    .settings-layout {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: var(--spacing-xl);
        align-items: start;
    }

    @media (max-width: 900px) {
        .settings-layout { grid-template-columns: 1fr; }
        .settings-tab-nav {
            position: static !important;
            display: flex !important;
            flex-direction: row !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
            border-radius: 10px !important;
            background: #fff !important;
            margin-bottom: 16px !important;
            -webkit-overflow-scrolling: touch;
            box-shadow: var(--shadow-admin-sm) !important;
        }
        .settings-tab-nav-label {
            display: none !important;
        }
        .settings-nav-btn {
            flex: 0 0 auto !important;
            width: auto !important;
            padding: 12px 18px !important;
            border-left: none !important;
            border-bottom: 3px solid transparent !important;
            text-align: center !important;
        }
        .settings-nav-btn.active {
            border-bottom: 3px solid var(--color-admin-gold) !important;
            border-left-color: transparent !important;
            background: rgba(197, 168, 128, 0.08) !important;
        }
    }

    /* ─── Vertical Tab Nav ─── */
    .settings-tab-nav {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        overflow: hidden;
        box-shadow: var(--shadow-admin-sm);
        position: sticky;
        top: 90px;
    }

    .settings-tab-nav-label {
        padding: 14px 18px 10px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--color-admin-text-muted);
        border-bottom: 1px solid var(--color-admin-border);
    }

    .settings-nav-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 13px 18px;
        background: none;
        border: none;
        border-left: 3px solid transparent;
        text-align: left;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--color-admin-text-muted);
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
    }

    .settings-nav-btn:hover {
        background: var(--color-admin-border-light);
        color: var(--color-admin-text-main);
    }

    .settings-nav-btn.active {
        color: var(--color-admin-text-main);
        background: rgba(197, 168, 128, 0.08);
        border-left-color: var(--color-admin-gold);
        font-weight: 700;
    }

    .nav-btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        color: inherit;
    }

    /* ─── Settings Content Area ─── */
    .settings-content-area {
        min-width: 0;
    }

    .settings-tab-pane {
        display: none;
    }

    .settings-tab-pane.active {
        display: block;
        animation: fadeIn 0.25s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ─── Admin Card ─── */
    .admin-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-admin-sm);
        margin-bottom: var(--spacing-xl);
        transition: box-shadow 0.2s;
    }

    .admin-card:hover { box-shadow: var(--shadow-admin-md); }

    .settings-section-title {
        font-family: var(--font-secondary);
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0 0 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--color-admin-border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .settings-section-desc {
        font-size: 0.82rem;
        color: var(--color-admin-text-muted);
        margin-bottom: 20px;
        margin-top: -8px;
    }

    /* ─── Form Grid ─── */
    .settings-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .settings-full-row { grid-column: span 2; }

    @media (max-width: 700px) {
        .settings-form-grid { grid-template-columns: 1fr; }
        .settings-full-row  { grid-column: span 1; }
    }

    /* ─── Form Group ─── */
    .admin-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .admin-form-group label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: var(--color-admin-text-muted);
    }

    .admin-form-group .field-hint {
        font-size: 0.74rem;
        color: var(--color-admin-text-muted);
        margin-top: 2px;
    }

    /* ─── Input / Select ─── */
    .admin-input, .admin-select {
        font-family: var(--font-sans);
        padding: 10px 14px;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-input);
        font-size: 0.9rem;
        width: 100%;
        background: #fff;
        color: var(--color-admin-text-main);
        box-sizing: border-box;
        transition: all 0.2s;
    }

    .admin-input:focus, .admin-select:focus {
        border-color: var(--color-admin-accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(1,136,73,0.12);
    }

    /* ─── Save Button ─── */
    .btn-save-settings {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
        color: #fff;
        border: none;
        border-radius: var(--radius-admin-input);
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
    }

    .btn-save-settings:hover {
        background: linear-gradient(135deg, #b4956d 0%, #a08260 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(197,168,128,0.4);
    }

    /* ─── SMTP Password Toggle ─── */
    .input-group {
        display: flex;
        gap: 0;
    }

    .input-group .admin-input {
        border-radius: var(--radius-admin-input) 0 0 var(--radius-admin-input);
    }

    .input-group-btn {
        padding: 0 14px;
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        border-left: none;
        border-radius: 0 var(--radius-admin-input) var(--radius-admin-input) 0;
        cursor: pointer;
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        transition: background 0.2s;
        white-space: nowrap;
    }

    .input-group-btn:hover {
        background: var(--color-admin-border);
        color: var(--color-admin-text-main);
    }

    /* ─── Save Footer ─── */
    .settings-save-footer {
        background: var(--color-admin-border-light);
        border-top: 1px solid var(--color-admin-border);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        border-radius: 0 0 var(--radius-admin-card) var(--radius-admin-card);
        margin: 24px -24px -24px;
    }

    .settings-save-footer p {
        font-size: 0.82rem;
        color: var(--color-admin-text-muted);
        margin: 0;
    }
</style>
@endsection

@section('content')
@php
    function getVal($key, $default = '') {
        $item = \App\Models\Setting::where('key', $key)->first();
        return $item ? $item->value : $default;
    }
@endphp

{{-- ─── Page Hero ─── --}}
<div class="settings-hero">
    <div>
        <h2>Global Settings</h2>
        <p>Manage storefront configuration, payments, SEO, and communications.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" id="settings-form">
    @csrf

    <div class="settings-layout">

        {{-- ─── Left: Tab Navigation ─── --}}
        <div class="settings-tab-nav">
            <div class="settings-tab-nav-label">Settings Sections</div>
            <button type="button" class="settings-nav-btn active" onclick="switchTab(this, 'tab-site')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span> Site &amp; Branding
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-bank')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="21" x2="21" y2="21"></line><line x1="3" y1="10" x2="21" y2="10"></line><path d="M5 10V21"></path><path d="M12 10V21"></path><path d="M19 10V21"></path><path d="M3 10L12 3L21 10"></path></svg></span> Bank Details
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-contact')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></span> Contact &amp; Social
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-smtp')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span> SMTP Mailer
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-seo')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span> SEO Defaults
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-payment')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span> Payment Gateways
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-shipping')">
                <span class="nav-btn-icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg></span> Shipping &amp; Logistics
            </button>
        </div>

        {{-- ─── Right: Panels ─── --}}
        <div class="settings-content-area">

            {{-- TAB: Site & Branding --}}
            <div id="tab-site" class="settings-tab-pane active">
                <div class="admin-card">
                    <div class="settings-section-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Storefront Branding &amp; Rules
                    </div>
                    <p class="settings-section-desc">Configure your store name, logo, shipping rules, and regulatory identifiers.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="website_name">Website Name *</label>
                            <input type="text" id="website_name" name="website_name" class="admin-input"
                                value="{{ getVal('website_name', 'Al Barr | Khalis Wa Shifaf') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="website_logo">Logo Image Filepath *</label>
                            <input type="text" id="website_logo" name="website_logo" class="admin-input"
                                value="{{ getVal('website_logo', 'assets/img/logo.png') }}" required>
                            <div class="field-hint">Relative path from public root (e.g. assets/img/logo.png)</div>
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="announcement_text">Top Announcement Marquee *</label>
                            <input type="text" id="announcement_text" name="announcement_text" class="admin-input"
                                value="{{ getVal('announcement_text', '✨ FREE Express Delivery on Orders Above ₹999! | 🔒 FSSAI Verified | 📦 Cash on Delivery Available') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="free_shipping_threshold">Free Delivery Threshold (₹) *</label>
                            <input type="number" id="free_shipping_threshold" name="free_shipping_threshold" class="admin-input"
                                value="{{ getVal('free_shipping_threshold', '999') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="shipping_charge">Standard Flat Shipping Fee (₹) *</label>
                            <input type="number" id="shipping_charge" name="shipping_charge" class="admin-input"
                                value="{{ getVal('shipping_charge', '60') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="fssai_number">FSSAI Registration Number *</label>
                            <input type="text" id="fssai_number" name="fssai_number" class="admin-input"
                                value="{{ getVal('fssai_number', '11025430000232') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="gstin_number">GSTIN Business Reference *</label>
                            <input type="text" id="gstin_number" name="gstin_number" class="admin-input"
                                value="{{ getVal('gstin_number', '01ACFFM4729H1ZF') }}" required>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Changes take effect immediately on save.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB: Bank Details --}}
            <div id="tab-bank" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="21" x2="21" y2="21"></line><line x1="3" y1="10" x2="21" y2="10"></line><path d="M5 10V21"></path><path d="M12 10V21"></path><path d="M19 10V21"></path><path d="M3 10L12 3L21 10"></path></svg>
                        Bank Transfer Details
                    </div>
                    <p class="settings-section-desc">These details are shown to customers at checkout for bank transfer payments.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="bank_name">Bank Name *</label>
                            <input type="text" id="bank_name" name="bank_name" class="admin-input"
                                value="{{ getVal('bank_name', 'J&K Bank') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="bank_account_name">Account Holder Name *</label>
                            <input type="text" id="bank_account_name" name="bank_account_name" class="admin-input"
                                value="{{ getVal('bank_account_name', 'AL BARR') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="bank_account_number">Account Number *</label>
                            <input type="text" id="bank_account_number" name="bank_account_number" class="admin-input"
                                value="{{ getVal('bank_account_number', '0216010100002651') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="bank_ifsc">IFSC Code *</label>
                            <input type="text" id="bank_ifsc" name="bank_ifsc" class="admin-input"
                                value="{{ getVal('bank_ifsc', 'JAKA0GARDEN') }}" required>
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="bank_branch">Branch Location Address *</label>
                            <input type="text" id="bank_branch" name="bank_branch" class="admin-input"
                                value="{{ getVal('bank_branch', 'SMC Complex, Balgarden, Srinagar – 190010') }}" required>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Used for bank transfer payment instructions at checkout.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB: Contact & Social --}}
            <div id="tab-contact" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        Contact &amp; Social Media
                    </div>
                    <p class="settings-section-desc">Customer-facing contact details and social profile URLs displayed site-wide.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="phone_number">Customer Support Phone *</label>
                            <input type="text" id="phone_number" name="phone_number" class="admin-input"
                                value="{{ getVal('phone_number', '+91-9419000000') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="email_address">Support Email Address *</label>
                            <input type="email" id="email_address" name="email_address" class="admin-input"
                                value="{{ getVal('email_address', 'support@albarfoods.com') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="wholesale_email">Wholesale &amp; Trade Email *</label>
                            <input type="email" id="wholesale_email" name="wholesale_email" class="admin-input"
                                value="{{ getVal('wholesale_email', 'trade@albarfoods.com') }}" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="whatsapp_link">WhatsApp API Link *</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="whatsapp_link" name="whatsapp_link" class="admin-input"
                                    value="{{ getVal('whatsapp_link', 'https://wa.me/919419000000') }}" required>
                                <button type="button" class="btn-action-outline" style="padding: 10px 14px; border-radius: 8px; white-space: nowrap; display: inline-flex; align-items: center;" onclick="previewSocialLink('whatsapp_link')" title="Test / Preview WhatsApp Link">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    Test
                                </button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="instagram_link">Instagram Profile URL</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="instagram_link" name="instagram_link" class="admin-input"
                                    value="{{ getVal('instagram_link', '#') }}">
                                <button type="button" class="btn-action-outline" style="padding: 10px 14px; border-radius: 8px; white-space: nowrap; display: inline-flex; align-items: center;" onclick="previewSocialLink('instagram_link')" title="Test / Preview Instagram Link">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    Test
                                </button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="facebook_link">Facebook Page URL</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="facebook_link" name="facebook_link" class="admin-input"
                                    value="{{ getVal('facebook_link', '#') }}">
                                <button type="button" class="btn-action-outline" style="padding: 10px 14px; border-radius: 8px; white-space: nowrap; display: inline-flex; align-items: center;" onclick="previewSocialLink('facebook_link')" title="Test / Preview Facebook Link">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    Test
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Appears in footer, contact page, and WhatsApp widget.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB: SMTP --}}
            <div id="tab-smtp" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        SMTP Outgoing Mailer
                    </div>
                    <p class="settings-section-desc">Configure transactional email delivery for order confirmations, tickets, and notifications.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="smtp_host">SMTP Server Hostname</label>
                            <input type="text" id="smtp_host" name="smtp_host" class="admin-input"
                                value="{{ getVal('smtp_host', 'smtp.mailtrap.io') }}">
                        </div>
                        <div class="admin-form-group">
                            <label for="smtp_port">SMTP Port</label>
                            <input type="text" id="smtp_port" name="smtp_port" class="admin-input"
                                value="{{ getVal('smtp_port', '2525') }}">
                        </div>
                        <div class="admin-form-group">
                            <label for="smtp_username">SMTP Username</label>
                            <input type="text" id="smtp_username" name="smtp_username" class="admin-input"
                                value="{{ getVal('smtp_username', '') }}">
                        </div>
                        <div class="admin-form-group">
                            <label for="smtp_password">SMTP Password</label>
                            <div class="input-group">
                                <input type="password" id="smtp_password" name="smtp_password" class="admin-input"
                                    value="{{ getVal('smtp_password', '') }}" placeholder="••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('smtp_password')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="smtp_encryption">Encryption Protocol</label>
                            <select id="smtp_encryption" name="smtp_encryption" class="admin-select">
                                <option value="none" @selected(getVal('smtp_encryption', 'tls') === 'none')>None</option>
                                <option value="tls"  @selected(getVal('smtp_encryption', 'tls') === 'tls')>TLS</option>
                                <option value="ssl"  @selected(getVal('smtp_encryption', 'tls') === 'ssl')>SSL</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="smtp_from_name">From Name</label>
                            <input type="text" id="smtp_from_name" name="smtp_from_name" class="admin-input"
                                value="{{ getVal('smtp_from_name', 'Al Barr Foods') }}">
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Test your SMTP settings by sending a test email after saving.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB: SEO --}}
            <div id="tab-seo" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        SEO &amp; Search Engine Defaults
                    </div>
                    <p class="settings-section-desc">Global meta tags that serve as fallback defaults across all storefront pages.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group settings-full-row">
                            <label for="meta_title">Default Meta Title *</label>
                            <input type="text" id="meta_title" name="meta_title" class="admin-input"
                                value="{{ getVal('meta_title', 'Al Barr | Kashmiri Organic Staples Sourced Direct') }}" required>
                            <div class="field-hint">Recommended: 50–60 characters for optimal search display.</div>
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="meta_description">Default Meta Description *</label>
                            <textarea id="meta_description" name="meta_description" rows="3" class="admin-input"
                                style="resize: none;" required>{{ getVal('meta_description', 'Purchase double-sealed organic Kashmiri mamra almonds, grade A+ certified Mogra saffron, and raw acacia honey directly from organic local Srinagar orchards.') }}</textarea>
                            <div class="field-hint">Recommended: 150–160 characters. Appears in Google search results.</div>
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="meta_keywords">Default SEO Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" class="admin-input"
                                value="{{ getVal('meta_keywords', 'organic kashmir, saffron, mamra almonds, raw honey, walnuts, rajma') }}">
                            <div class="field-hint">Comma-separated values. Impact is minimal for modern search engines.</div>
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="og_image">Default Open Graph Image URL</label>
                            <input type="text" id="og_image" name="og_image" class="admin-input"
                                value="{{ getVal('og_image', '') }}" placeholder="https://yoursite.com/assets/og-image.jpg">
                            <div class="field-hint">Used for social media previews (Facebook, Twitter). Recommended: 1200×630px.</div>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Changes may take 24–48h to reflect in search engine results.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB: Payment Gateways --}}
            <div id="tab-payment" class="settings-tab-pane">
                <!-- Manual Payment Options (COD & Bank) -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>Manual Payment Options (COD & Bank)</div>
                    <p class="settings-section-desc">Toggle availability of Cash on Delivery (COD) and Direct Bank Transfer payments at checkout.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="payment_cod_status">Cash on Delivery (COD) Status</label>
                            <select id="payment_cod_status" name="payment_cod_status" class="admin-select">
                                <option value="disabled" @selected(getVal('payment_cod_status', 'enabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('payment_cod_status', 'enabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_bank_status">Direct Bank Transfer Status</label>
                            <select id="payment_bank_status" name="payment_bank_status" class="admin-select">
                                <option value="disabled" @selected(getVal('payment_bank_status', 'enabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('payment_bank_status', 'enabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Razorpay -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>Razorpay Integration</div>
                    <p class="settings-section-desc">Enable Razorpay to collect payments via UPI, Credit/Debit cards, Net Banking, and Wallets.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="payment_razorpay_status">Razorpay Gateway Status</label>
                            <select id="payment_razorpay_status" name="payment_razorpay_status" class="admin-select">
                                <option value="disabled" @selected(getVal('payment_razorpay_status', 'disabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('payment_razorpay_status', 'disabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_razorpay_key_id">Razorpay Key ID</label>
                            <input type="text" id="payment_razorpay_key_id" name="payment_razorpay_key_id" class="admin-input"
                                value="{{ getVal('payment_razorpay_key_id', '') }}" placeholder="rzp_test_...">
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_razorpay_key_secret">Razorpay Key Secret</label>
                            <div class="input-group">
                                <input type="password" id="payment_razorpay_key_secret" name="payment_razorpay_key_secret" class="admin-input"
                                    value="{{ getVal('payment_razorpay_key_secret', '') }}" placeholder="••••••••••••••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('payment_razorpay_key_secret')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_razorpay_webhook_secret">Razorpay Webhook Secret</label>
                            <div class="input-group">
                                <input type="password" id="payment_razorpay_webhook_secret" name="payment_razorpay_webhook_secret" class="admin-input"
                                    value="{{ getVal('payment_razorpay_webhook_secret', '') }}" placeholder="••••••••••••••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('payment_razorpay_webhook_secret')">Show</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cashfree -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>Cashfree Integration</div>
                    <p class="settings-section-desc">Configure Cashfree to accept instant settlements, cards, UPI, and Pay Later options.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="payment_cashfree_status">Cashfree Gateway Status</label>
                            <select id="payment_cashfree_status" name="payment_cashfree_status" class="admin-select">
                                <option value="disabled" @selected(getVal('payment_cashfree_status', 'disabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('payment_cashfree_status', 'disabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_cashfree_app_id">Cashfree App ID</label>
                            <input type="text" id="payment_cashfree_app_id" name="payment_cashfree_app_id" class="admin-input"
                                value="{{ getVal('payment_cashfree_app_id', '') }}" placeholder="CF123456...">
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_cashfree_secret_key">Cashfree Secret Key</label>
                            <div class="input-group">
                                <input type="password" id="payment_cashfree_secret_key" name="payment_cashfree_secret_key" class="admin-input"
                                    value="{{ getVal('payment_cashfree_secret_key', '') }}" placeholder="••••••••••••••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('payment_cashfree_secret_key')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_cashfree_mode">Integration Mode</label>
                            <select id="payment_cashfree_mode" name="payment_cashfree_mode" class="admin-select">
                                <option value="sandbox" @selected(getVal('payment_cashfree_mode', 'sandbox') === 'sandbox')>Sandbox (Test)</option>
                                <option value="production" @selected(getVal('payment_cashfree_mode', 'sandbox') === 'production')>Production (Live)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Paytm -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>Paytm Integration</div>
                    <p class="settings-section-desc">Accept mobile payments directly via Paytm Wallet, UPI, and Paytm Payments Bank.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="payment_paytm_status">Paytm Gateway Status</label>
                            <select id="payment_paytm_status" name="payment_paytm_status" class="admin-select">
                                <option value="disabled" @selected(getVal('payment_paytm_status', 'disabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('payment_paytm_status', 'disabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_paytm_merchant_id">Paytm Merchant ID</label>
                            <input type="text" id="payment_paytm_merchant_id" name="payment_paytm_merchant_id" class="admin-input"
                                value="{{ getVal('payment_paytm_merchant_id', '') }}" placeholder="PaytmMID123...">
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_paytm_merchant_key">Paytm Merchant Key</label>
                            <div class="input-group">
                                <input type="password" id="payment_paytm_merchant_key" name="payment_paytm_merchant_key" class="admin-input"
                                    value="{{ getVal('payment_paytm_merchant_key', '') }}" placeholder="••••••••••••••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('payment_paytm_merchant_key')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_paytm_website">Merchant Website Parameter</label>
                            <input type="text" id="payment_paytm_website" name="payment_paytm_website" class="admin-input"
                                value="{{ getVal('payment_paytm_website', 'WEBSTAGING') }}" placeholder="WEBSTAGING / DEFAULT">
                        </div>
                    </div>
                </div>

                <!-- PayPal -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>PayPal Integration (Global Payments)</div>
                    <p class="settings-section-desc">Allow international customers to complete checkouts in USD/EUR via credit card or PayPal accounts.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="payment_paypal_status">PayPal Gateway Status</label>
                            <select id="payment_paypal_status" name="payment_paypal_status" class="admin-select">
                                <option value="disabled" @selected(getVal('payment_paypal_status', 'disabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('payment_paypal_status', 'disabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_paypal_client_id">PayPal Client ID</label>
                            <input type="text" id="payment_paypal_client_id" name="payment_paypal_client_id" class="admin-input"
                                value="{{ getVal('payment_paypal_client_id', '') }}" placeholder="A1B2C3D4...">
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_paypal_secret">PayPal Secret Key</label>
                            <div class="input-group">
                                <input type="password" id="payment_paypal_secret" name="payment_paypal_secret" class="admin-input"
                                    value="{{ getVal('payment_paypal_secret', '') }}" placeholder="••••••••••••••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('payment_paypal_secret')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="payment_paypal_mode">PayPal Mode</label>
                            <select id="payment_paypal_mode" name="payment_paypal_mode" class="admin-select">
                                <option value="sandbox" @selected(getVal('payment_paypal_mode', 'sandbox') === 'sandbox')>Sandbox (Test)</option>
                                <option value="live" @selected(getVal('payment_paypal_mode', 'sandbox') === 'live')>Live (Production)</option>
                            </select>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Changes require saving before testing integration.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB: Shipping & Logistics --}}
            <div id="tab-shipping" class="settings-tab-pane">
                <!-- Shiprocket -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>Shiprocket Integration</div>
                    <p class="settings-section-desc">Connect with Shiprocket API to automate order fulfillment, generate shipping labels, and track shipments.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="shipping_shiprocket_status">Shiprocket Integration Status</label>
                            <select id="shipping_shiprocket_status" name="shipping_shiprocket_status" class="admin-select">
                                <option value="disabled" @selected(getVal('shipping_shiprocket_status', 'disabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('shipping_shiprocket_status', 'disabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="shipping_shiprocket_email">API login Email</label>
                            <input type="email" id="shipping_shiprocket_email" name="shipping_shiprocket_email" class="admin-input"
                                value="{{ getVal('shipping_shiprocket_email', '') }}" placeholder="developer@yoursite.com">
                        </div>
                        <div class="admin-form-group">
                            <label for="shipping_shiprocket_password">API login Password</label>
                            <div class="input-group">
                                <input type="password" id="shipping_shiprocket_password" name="shipping_shiprocket_password" class="admin-input"
                                    value="{{ getVal('shipping_shiprocket_password', '') }}" placeholder="••••••••">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('shipping_shiprocket_password')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="shipping_shiprocket_channel_id">Shiprocket Channel ID</label>
                            <input type="text" id="shipping_shiprocket_channel_id" name="shipping_shiprocket_channel_id" class="admin-input"
                                value="{{ getVal('shipping_shiprocket_channel_id', '') }}" placeholder="e.g. 123456">
                        </div>
                    </div>
                </div>

                <!-- Delhivery -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>Delhivery Integration</div>
                    <p class="settings-section-desc">Configure your direct Delhivery courier API credentials for customized regional shipping routes.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="shipping_delhivery_status">Delhivery Integration Status</label>
                            <select id="shipping_delhivery_status" name="shipping_delhivery_status" class="admin-select">
                                <option value="disabled" @selected(getVal('shipping_delhivery_status', 'disabled') === 'disabled')>Disabled</option>
                                <option value="enabled" @selected(getVal('shipping_delhivery_status', 'disabled') === 'enabled')>Enabled</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="shipping_delhivery_token">Delhivery API Client Token</label>
                            <div class="input-group">
                                <input type="password" id="shipping_delhivery_token" name="shipping_delhivery_token" class="admin-input"
                                    value="{{ getVal('shipping_delhivery_token', '') }}" placeholder="DelhiveryToken123...">
                                <button type="button" class="input-group-btn" onclick="togglePasswordVisibility('shipping_delhivery_token')">Show</button>
                            </div>
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="shipping_delhivery_warehouse">Warehouse Location Code Name</label>
                            <input type="text" id="shipping_delhivery_warehouse" name="shipping_delhivery_warehouse" class="admin-input"
                                value="{{ getVal('shipping_delhivery_warehouse', '') }}" placeholder="Srinagar_Main_Orchard_Warehouse">
                        </div>
                    </div>
                </div>

                <!-- General Logistics -->
                <div class="admin-card">
                    <div class="settings-section-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--color-admin-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>General Logistics &amp; Delivery Rules</div>
                    <p class="settings-section-desc">Set default shipping preferences, customer eligibility rules, and estimates shown on product pages.</p>
                    <div class="settings-form-grid">
                        <div class="admin-form-group">
                            <label for="shipping_cod_available">Cash on Delivery (COD) Availability</label>
                            <select id="shipping_cod_available" name="shipping_cod_available" class="admin-select">
                                <option value="available" @selected(getVal('shipping_cod_available', 'available') === 'available')>Available (All Pincodes)</option>
                                <option value="restricted" @selected(getVal('shipping_cod_available', 'available') === 'restricted')>Restricted (Serviceable Only)</option>
                                <option value="unavailable" @selected(getVal('shipping_cod_available', 'available') === 'unavailable')>Disabled completely</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label for="shipping_default_carrier">Fallback Logistics Partner Name</label>
                            <input type="text" id="shipping_default_carrier" name="shipping_default_carrier" class="admin-input"
                                value="{{ getVal('shipping_default_carrier', 'Delhivery Express') }}" placeholder="e.g. BlueDart, Delhivery, Speed Post">
                        </div>
                        <div class="admin-form-group settings-full-row">
                            <label for="shipping_est_delivery_days">Estimated Delivery Duration SLA (Days)</label>
                            <input type="number" id="shipping_est_delivery_days" name="shipping_est_delivery_days" class="admin-input"
                                value="{{ getVal('shipping_est_delivery_days', '5') }}" placeholder="e.g. 5">
                            <div class="field-hint">Average days for shipments to reach customers (displays on product details and checkout).</div>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Standard flat rates are managed under the Site &amp; Branding tab.</p>
                        <button type="submit" class="btn-save-settings">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>

        </div>{{-- end content area --}}
    </div>{{-- end layout --}}
</form>
@endsection

@section('scripts')
<script>
    let isFormDirty = false;
    const settingsForm = document.getElementById('settings-form');
    
    if (settingsForm) {
        settingsForm.addEventListener('change', () => {
            isFormDirty = true;
        });
        
        settingsForm.addEventListener('submit', () => {
            isFormDirty = false;
        });
    }

    window.addEventListener('beforeunload', (e) => {
        if (isFormDirty) {
            e.preventDefault();
            e.returnValue = 'You have unsaved settings changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });

    function switchTab(btn, tabId) {
        document.querySelectorAll('.settings-nav-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.settings-tab-pane').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    }

    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const btn   = event.currentTarget;
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Hide';
        } else {
            input.type = 'password';
            btn.textContent = 'Show';
        }
    }

    function previewSocialLink(inputId) {
        const val = document.getElementById(inputId).value;
        if (val && val !== '#' && val.trim() !== '') {
            window.open(val, '_blank');
        } else {
            alert('Please configure a valid URL to test.');
        }
    }
</script>
@endsection
