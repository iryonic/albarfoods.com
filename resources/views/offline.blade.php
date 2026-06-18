@extends('layouts.app')

@section('title', 'Offline | Al Barr (Khalis Wa Shifaf)')

@section('styles')
<style>
    .offline-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-xl);
        text-align: center;
        background-color: var(--color-cream);
    }
    .offline-card {
        background-color: #fff;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: var(--spacing-xxl) var(--spacing-xl);
        max-width: 600px;
        box-shadow: var(--shadow-lg);
    }
    .offline-icon {
        font-size: 3.5rem;
        color: var(--color-gold);
        margin-bottom: var(--spacing-md);
    }
    .jkb-box {
        background-color: var(--color-cream-dark);
        border: 1px dashed var(--color-gold);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin: var(--spacing-lg) 0;
        text-align: left;
    }
</style>
@endsection

@section('content')
<div class="offline-wrapper">
    <div class="offline-card">
        <div class="offline-icon">📶</div>
        <h1 style="font-size: 2rem; color: var(--color-blue-dark); margin-bottom: var(--spacing-sm);">Connection Interrupted</h1>
        <p style="color: var(--color-text-secondary); font-size: 1rem; line-height: 1.6;">
            You are currently browsing offline. However, the purity of **Al Barr** remains reachable! You can call us to place an order directly or execute a bank wire transfer to our verified Jammu & Kashmir Bank account.
        </p>
        
        <!-- Bank credentials offline display -->
        <div class="jkb-box">
            <h3 style="color: var(--color-blue-dark); font-size: 1rem; margin-bottom: 8px; text-transform: uppercase;">{{ $settings['bank_name'] ?? 'Jammu And Kashmir Bank Limited' }}</h3>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 4px;">
                <span>Account Number:</span>
                <strong>{{ $settings['bank_account_number'] ?? '0216010100002651' }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 4px;">
                <span>IFSC Code:</span>
                <strong>{{ $settings['bank_ifsc'] ?? 'JAKA0GARDEN' }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                <span>Branch SMC Balgarden:</span>
                <strong>Srinagar – 190010</strong>
            </div>
        </div>

        <div style="margin-bottom: var(--spacing-lg);">
            <p style="font-size: 0.9rem; color: var(--color-text-secondary);">
                📞 Call to place order: <strong>{{ $settings['phone_number'] ?? '+91-9419000000' }}</strong>
            </p>
            <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 4px;">
                🏠 Main Showroom: Zakura, Srinagar, J&K – 190006
            </p>
        </div>

        <button class="btn btn-gold" onclick="window.location.reload();" style="width: 100%;">
            🔄 Retry Connection
        </button>
    </div>
</div>
@endsection
