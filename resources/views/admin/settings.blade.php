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
        font-size: 1rem;
        width: 22px;
        text-align: center;
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
                <span class="nav-btn-icon">🌾</span> Site &amp; Branding
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-bank')">
                <span class="nav-btn-icon">🏛️</span> Bank Details
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-contact')">
                <span class="nav-btn-icon">📞</span> Contact &amp; Social
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-smtp')">
                <span class="nav-btn-icon">✉️</span> SMTP Mailer
            </button>
            <button type="button" class="settings-nav-btn" onclick="switchTab(this, 'tab-seo')">
                <span class="nav-btn-icon">🔍</span> SEO Defaults
            </button>
        </div>

        {{-- ─── Right: Panels ─── --}}
        <div class="settings-content-area">

            {{-- TAB: Site & Branding --}}
            <div id="tab-site" class="settings-tab-pane active">
                <div class="admin-card">
                    <div class="settings-section-title">🌾 Storefront Branding &amp; Rules</div>
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
                        <button type="submit" class="btn-save-settings">💾 Save Settings</button>
                    </div>
                </div>
            </div>

            {{-- TAB: Bank Details --}}
            <div id="tab-bank" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">🏛️ Bank Transfer Details</div>
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
                        <button type="submit" class="btn-save-settings">💾 Save Settings</button>
                    </div>
                </div>
            </div>

            {{-- TAB: Contact & Social --}}
            <div id="tab-contact" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">📞 Contact &amp; Social Media</div>
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
                                <button type="button" class="btn-action-outline" style="padding: 10px 14px; border-radius: 8px; white-space: nowrap;" onclick="previewSocialLink('whatsapp_link')" title="Test / Preview WhatsApp Link">🔗 Test</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="instagram_link">Instagram Profile URL</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="instagram_link" name="instagram_link" class="admin-input"
                                    value="{{ getVal('instagram_link', '#') }}">
                                <button type="button" class="btn-action-outline" style="padding: 10px 14px; border-radius: 8px; white-space: nowrap;" onclick="previewSocialLink('instagram_link')" title="Test / Preview Instagram Link">🔗 Test</button>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label for="facebook_link">Facebook Page URL</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="facebook_link" name="facebook_link" class="admin-input"
                                    value="{{ getVal('facebook_link', '#') }}">
                                <button type="button" class="btn-action-outline" style="padding: 10px 14px; border-radius: 8px; white-space: nowrap;" onclick="previewSocialLink('facebook_link')" title="Test / Preview Facebook Link">🔗 Test</button>
                            </div>
                        </div>
                    </div>
                    <div class="settings-save-footer">
                        <p>Appears in footer, contact page, and WhatsApp widget.</p>
                        <button type="submit" class="btn-save-settings">💾 Save Settings</button>
                    </div>
                </div>
            </div>

            {{-- TAB: SMTP --}}
            <div id="tab-smtp" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">✉️ SMTP Outgoing Mailer</div>
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
                                <button type="button" class="input-group-btn" onclick="toggleSmtpPassword()">👁️ Show</button>
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
                        <button type="submit" class="btn-save-settings">💾 Save Settings</button>
                    </div>
                </div>
            </div>

            {{-- TAB: SEO --}}
            <div id="tab-seo" class="settings-tab-pane">
                <div class="admin-card">
                    <div class="settings-section-title">🔍 SEO &amp; Search Engine Defaults</div>
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
                        <button type="submit" class="btn-save-settings">💾 Save Settings</button>
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

    function toggleSmtpPassword() {
        const input = document.getElementById('smtp_password');
        const btn   = event.currentTarget;
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🙈 Hide';
        } else {
            input.type = 'password';
            btn.textContent = '👁️ Show';
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
