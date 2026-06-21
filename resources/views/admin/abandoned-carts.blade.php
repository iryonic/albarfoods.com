@extends('layouts.admin')

@section('title', 'Abandoned Carts - Al Barr Admin')
@section('header_title', 'Abandoned Carts Recovery')

@section('styles')
<style>
    .cart-tbl-card {
        background-color: var(--color-admin-card-bg);
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        box-shadow: var(--shadow-admin-sm);
        overflow: hidden;
    }

    .cart-tbl { width: 100%; border-collapse: collapse; text-align: left; }

    .cart-tbl th {
        padding: 13px 20px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid var(--color-admin-border);
        font-size: 0.73rem; font-weight: 800;
        color: var(--color-admin-text-muted);
        text-transform: uppercase; letter-spacing: 0.7px;
        white-space: nowrap;
    }

    .cart-tbl td {
        padding: 18px 20px;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        font-size: 0.875rem; vertical-align: top;
        background: #fff;
        transition: background 0.12s ease;
    }

    .cart-tbl tr:hover td { background: rgba(241, 245, 249, 0.7); }
    .cart-tbl tr:last-child td { border-bottom: none; }

    .cust-info-card { display: flex; flex-direction: column; gap: 4px; }
    .cust-name  { font-weight: 700; color: var(--color-admin-text-main); font-size: 0.9rem; }
    .cust-phone { font-size: 0.82rem; color: var(--color-admin-accent); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
    .cust-email { font-size: 0.78rem; color: var(--color-admin-text-muted); }

    .address-badge {
        background-color: var(--color-admin-border-light);
        border-radius: 8px; padding: 10px 14px;
        font-size: 0.78rem; max-width: 240px; line-height: 1.5;
    }

    .cart-item-row {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 8px; padding-bottom: 8px;
        border-bottom: 1px dashed var(--color-admin-border-light);
    }
    .cart-item-row:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }

    .cart-item-img {
        width: 34px; height: 34px; border-radius: 6px;
        object-fit: cover; background-color: #fff;
        border: 1px solid var(--color-admin-border); flex-shrink: 0;
    }

    .cart-item-details { display: flex; flex-direction: column; font-size: 0.78rem; }
    .cart-item-title { font-weight: 700; color: var(--color-admin-text-main); }
    .cart-item-meta  { color: var(--color-admin-text-muted); }

    .btn-whatsapp {
        background-color: #25d366; color: #fff; border: none;
        padding: 8px 12px; font-size: 0.78rem; border-radius: 8px;
        font-weight: 700; cursor: pointer; display: inline-flex;
        align-items: center; gap: 6px; text-decoration: none;
        transition: all 0.2s; white-space: nowrap;
    }
    .btn-whatsapp:hover { background-color: #1db954; transform: translateY(-1px); }

    /* Heatmap Badge Styling */
    .heatmap-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-family: var(--font-secondary);
        font-size: 0.85rem;
        font-weight: 700;
        text-align: center;
        box-shadow: var(--shadow-admin-sm);
    }
    .heatmap-high {
        background: linear-gradient(135deg, #e3fbeb 0%, #d1f7df 100%);
        color: #018849;
        border: 1px solid rgba(1, 136, 73, 0.15);
    }
    .heatmap-medium {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
        border: 1px solid rgba(180, 83, 9, 0.15);
    }
    .heatmap-low {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        border: 1px solid rgba(71, 85, 105, 0.1);
    }

    /* Urgency Badge Styling */
    .urgency-container {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        width: fit-content;
    }
    .urgency-warm {
        background-color: rgba(227, 251, 235, 0.8);
        color: #018849;
    }
    .urgency-medium {
        background-color: rgba(254, 243, 199, 0.8);
        color: #d97706;
    }
    .urgency-cold {
        background-color: rgba(241, 245, 249, 0.8);
        color: #64748b;
    }
    .urgency-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .urgency-dot-warm {
        background-color: #018849;
        box-shadow: 0 0 0 2px rgba(1, 136, 73, 0.25);
        animation: pulseWarm 1.5s infinite;
    }
    .urgency-dot-medium {
        background-color: #d97706;
    }
    .urgency-dot-cold {
        background-color: #64748b;
    }

    @keyframes pulseWarm {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(1, 136, 73, 0.4); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 5px rgba(1, 136, 73, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(1, 136, 73, 0); }
    }

    /* Modern Empty State */
    .empty-abandoned {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        text-align: center;
    }
    .empty-icon-wrap {
        position: relative;
        margin-bottom: 24px;
        color: var(--color-admin-gold);
    }
    .empty-icon-wrap svg {
        opacity: 0.8;
        filter: drop-shadow(0 4px 10px rgba(197, 168, 128, 0.2));
    }
    .sparkle {
        position: absolute;
        font-size: 1.2rem;
        animation: floatSparkle 3s infinite ease-in-out;
    }
    .sparkle-1 {
        top: -10px;
        right: -10px;
        animation-delay: 0.5s;
    }
    .sparkle-2 {
        bottom: 5px;
        left: -15px;
        animation-delay: 1.5s;
    }
    @keyframes floatSparkle {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
        50% { transform: translateY(-8px) scale(1.2); opacity: 1; }
    }

    .empty-abandoned h3 { font-family: var(--font-secondary); font-size: 1.2rem; font-weight: 800; color: var(--color-admin-text-main); margin: 0 0 8px; }
    .empty-abandoned p  { font-size: 0.85rem; color: var(--color-admin-text-muted); margin: 0; max-width: 380px; }

    /* ─── Bulk Action Bar ─── */
    .cart-bulk-bar {
        display: none;
        position: fixed;
        bottom: 24px;
        left: calc(var(--admin-sidebar-width, 272px) + 24px);
        right: 24px;
        background: rgba(10, 15, 30, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 14px;
        padding: 14px 24px;
        z-index: 1000;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        border: 1px solid rgba(197, 168, 128, 0.2);
        animation: slideUpCarts 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUpCarts {
        from { transform: translateY(20px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }

    .cart-bulk-bar .bar-count {
        font-weight: 700;
        color: #fff;
        font-size: 0.9rem;
    }

    @media (max-width: 1024px) {
        .cart-bulk-bar {
            left: 24px;
        }
    }
</style>
@endsection

@section('content')

{{-- ─── Stats Grid ─── --}}
<div class="stats-4-grid">
    <div class="stat-kpi-card gold">
        <div class="stat-kpi-icon gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $totalAbandoned }}</div>
            <div class="stat-kpi-label">Abandoned Carts</div>
        </div>
    </div>
    <div class="stat-kpi-card green">
        <div class="stat-kpi-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="font-size: 1.4rem;">&#8377;{{ number_format($totalValue, 0) }}</div>
            <div class="stat-kpi-label">Recoverable Value</div>
        </div>
    </div>
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $guestCount }}</div>
            <div class="stat-kpi-label">Guest Customers</div>
        </div>
    </div>
    <div class="stat-kpi-card purple">
        <div class="stat-kpi-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $registeredCount }}</div>
            <div class="stat-kpi-label">Registered Users</div>
        </div>
    </div>
</div>

{{-- ─── Filter Row ─── --}}
<div class="admin-card" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; padding: 20px 24px; margin-bottom: 24px;">
    <input type="text" id="cartSearch" class="admin-input" placeholder="🔍 Search customer name, phone, email or item..." style="flex: 1; min-width: 240px; max-width: 360px;">
    
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-left: auto;">
        <label style="font-size: 0.75rem; font-weight: 700; color: var(--color-admin-text-muted); text-transform: uppercase;">Activity Date:</label>
        <input type="date" id="startDate" class="admin-input" style="max-width: 140px; padding: 8px 12px; font-size: 0.82rem;">
        
        <label style="font-size: 0.75rem; font-weight: 700; color: var(--color-admin-text-muted); text-transform: uppercase;">To:</label>
        <input type="date" id="endDate" class="admin-input" style="max-width: 140px; padding: 8px 12px; font-size: 0.82rem;">
        
        <button class="btn-action-outline" onclick="clearDateFilter()" style="padding: 8px 12px;">Clear Dates</button>
    </div>
</div>

{{-- ─── Cart Table Card ─── --}}
<div class="cart-tbl-card">
    @if($abandonedCarts->count() > 0)
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="cart-tbl" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th style="width: 40px; padding-left: 20px; vertical-align: middle;">
                            <input type="checkbox" id="selectAllCarts" onclick="toggleSelectAll(this)" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--color-admin-accent);">
                        </th>
                        <th>Customer Details</th>
                        <th>Shipping Address</th>
                        <th>Cart Items</th>
                        <th>Cart Subtotal</th>
                        <th>Last Seen</th>
                        <th style="text-align: right; padding-right: 20px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($abandonedCarts as $cart)
                        @php
                            $whatsappText = "Hello " . ($cart->name ?? 'there') . ",\n\nWe noticed you left some premium Kashmiri organic items in your cart at Al Barr:\n";
                            $itemsString = '';
                            if (is_array($cart->cart_data)) {
                                foreach ($cart->cart_data as $item) {
                                    $whatsappText .= "- " . ($item['title'] ?? 'Item') . " (" . ($item['weight'] ?? '250g') . ") x " . ($item['qty'] ?? 1) . "\n";
                                    $itemsString .= ' ' . ($item['title'] ?? '') . ' ' . ($item['sku'] ?? '');
                                }
                            }
                            $whatsappText .= "\nWould you like us to help you place this order? Complete checkout here: " . url('/checkout') . "\n\nRegards,\nAl Barr Foods Srinagar";
                            $whatsappUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $cart->phone) . "?text=" . rawurlencode($whatsappText);
                            $searchVal = strtolower(($cart->name ?? 'Anonymous Guest') . ' ' . $cart->phone . ' ' . $cart->email . ' ' . $itemsString);
                        @endphp
                        <tr id="cartRow-{{ $cart->id }}" 
                            data-search="{{ $searchVal }}"
                            data-date="{{ $cart->last_activity_at->format('Y-m-d') }}">
                            {{-- Checkbox --}}
                            <td style="vertical-align: middle; width: 40px; padding-left: 20px;">
                                <input type="checkbox" class="cart-select-checkbox" data-id="{{ $cart->id }}" onchange="updateCartSelection()" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--color-admin-accent);">
                            </td>

                            {{-- Customer Info --}}
                            <td>
                                <div class="cust-info-card">
                                    <span class="cust-name">{{ $cart->name ?? 'Anonymous Guest' }}</span>
                                    @if($cart->phone)
                                        <a href="tel:{{ $cart->phone }}" class="cust-phone">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.79 19.79 19.79 0 01.14 1.2a2 2 0 011.95-2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.5a15.91 15.91 0 006.59 6.59l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                                            {{ $cart->phone }}
                                        </a>
                                    @else
                                        <span class="cust-email" style="font-style: italic;">No phone captured</span>
                                    @endif
                                    @if($cart->email)
                                        <span class="cust-email">{{ $cart->email }}</span>
                                    @endif
                                    <span style="font-size: 0.7rem; margin-top: 4px;" class="status-badge @if($cart->user_id) delivered @else pending @endif">
                                        @if($cart->user_id) Registered @else Guest Session @endif
                                    </span>
                                </div>
                            </td>

                            {{-- Address Info --}}
                            <td>
                                @if($cart->shipping_address || $cart->shipping_city || $cart->shipping_pincode)
                                    <div class="address-badge">
                                        <strong>Address:</strong> {{ $cart->shipping_address ?? 'Not specified' }}<br>
                                        <strong>City:</strong> {{ $cart->shipping_city ?? 'J&K' }}<br>
                                        <strong>Pin:</strong> {{ $cart->shipping_pincode ?? '190001' }}
                                        @if($cart->shipping_landmark)
                                            <br><strong>Landmark:</strong> {{ $cart->shipping_landmark }}
                                        @endif
                                    </div>
                                @else
                                    <span style="font-style: italic; color: var(--color-admin-text-muted); font-size: 0.78rem;">No address yet</span>
                                @endif
                            </td>

                            {{-- Cart Items --}}
                            <td>
                                <div style="max-height: 170px; overflow-y: auto; min-width: 230px;">
                                    @if(is_array($cart->cart_data))
                                        @foreach($cart->cart_data as $item)
                                            <div class="cart-item-row">
                                                <img src="/{{ $item['image'] ?? 'assets/img/logoalbar.png' }}" class="cart-item-img" alt="product">
                                                <div class="cart-item-details">
                                                    <span class="cart-item-title">{{ $item['title'] ?? 'Product' }}</span>
                                                    <span class="cart-item-meta">{{ $item['weight'] ?? '250g' }} &bull; &#8377;{{ number_format($item['price'] ?? 0, 0) }} &times; {{ $item['qty'] ?? 1 }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <span style="color: var(--color-admin-text-muted); font-size: 0.78rem;">Empty cart data</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Total Heatmap Badge --}}
                            <td style="vertical-align: middle;">
                                @php
                                    $subtotal = $cart->subtotal;
                                    if ($subtotal > 2000) {
                                        $heatmapClass = 'heatmap-high';
                                    } elseif ($subtotal >= 800) {
                                        $heatmapClass = 'heatmap-medium';
                                    } else {
                                        $heatmapClass = 'heatmap-low';
                                    }
                                @endphp
                                <span class="heatmap-badge {{ $heatmapClass }}">
                                    &#8377;{{ number_format($subtotal, 0) }}
                                </span>
                            </td>

                            {{-- Activity Time Urgency Badge --}}
                            <td style="vertical-align: middle;">
                                @php
                                    $hoursAgo = $cart->last_activity_at->diffInHours();
                                    if ($hoursAgo < 2) {
                                        $urgencyClass = 'urgency-warm';
                                        $urgencyDot = 'urgency-dot-warm';
                                        $urgencyText = 'Warm';
                                    } elseif ($hoursAgo < 24) {
                                        $urgencyClass = 'urgency-medium';
                                        $urgencyDot = 'urgency-dot-medium';
                                        $urgencyText = 'Follow Up';
                                    } else {
                                        $urgencyClass = 'urgency-cold';
                                        $urgencyDot = 'urgency-dot-cold';
                                        $urgencyText = 'Cold';
                                    }
                                @endphp
                                <div class="urgency-container {{ $urgencyClass }}">
                                    <span class="urgency-dot {{ $urgencyDot }}"></span>
                                    <span>{{ $urgencyText }}</span>
                                </div>
                                <div style="font-weight: 700; font-size: 0.86rem; color: var(--color-admin-text-main); margin-top: 6px;">
                                    {{ $cart->last_activity_at->diffForHumans() }}
                                </div>
                                <div style="font-size: 0.72rem; color: var(--color-admin-text-muted); margin-top: 2px;">
                                    {{ $cart->last_activity_at->format('M d, g:i a') }}
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td style="vertical-align: middle;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center; flex-wrap: wrap;">
                                    @if($cart->phone)
                                        <a href="{{ $whatsappUrl }}" target="_blank" class="btn-whatsapp">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                                            Remind
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('admin.abandoned-carts.delete', $cart->id) }}" method="POST" onsubmit="return confirm('Delete this abandoned cart log?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-outline danger" title="Delete" style="padding: 8px 12px;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    {{-- Client-side empty row --}}
                    <tr class="empty-row" style="display: none;">
                        <td colspan="7">
                            <div class="empty-abandoned" style="padding: 40px 20px;">
                                <h3>No Matching Abandoned Carts</h3>
                                <p>No carts match your search or date criteria.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-abandoned">
            <div class="empty-icon-wrap">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1"/>
                    <circle cx="19" cy="21" r="1"/>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                </svg>
                <div class="sparkle sparkle-1">✨</div>
                <div class="sparkle sparkle-2">✨</div>
            </div>
            <h3>No Abandoned Carts Found</h3>
            <p>All customers are completing their checkouts smoothly. No active recovery actions required!</p>
        </div>
    @endif
</div>

{{-- Bulk Action Bar --}}
<div class="cart-bulk-bar" id="cartBulkBar">
    <span class="bar-count" id="cartSelectionCountText">0 carts selected</span>
    <div style="display:flex; gap:10px; align-items:center;">
        <button class="btn-solid-gold" style="background:#ba3c1c; border-color:#ba3c1c; box-shadow:none; cursor: pointer; border-radius: 8px; font-weight: 700; color: #fff; padding: 8px 16px; font-size: 0.8rem; display:inline-flex; align-items:center; gap:6px;" onclick="bulkDeleteCarts()">
            🗑️ Delete Selected
        </button>
        <button class="btn-action-outline" style="padding: 8px 16px; font-size: 0.8rem; color: #fff; border-color: rgba(255,255,255,0.2); background: transparent; cursor: pointer; border-radius: 8px;" onclick="clearCartSelection()">
            Cancel
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleSelectAll(masterCb) {
        const checkboxes = document.querySelectorAll('.cart-select-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            if (row && row.style.display !== 'none') {
                cb.checked = masterCb.checked;
            }
        });
        updateCartSelection();
    }

    function updateCartSelection() {
        const checked = document.querySelectorAll('.cart-select-checkbox:checked');
        const total = document.querySelectorAll('.cart-select-checkbox');
        const master = document.getElementById('selectAllCarts');
        
        if (master) {
            const visibleCbs = Array.from(total).filter(cb => cb.closest('tr').style.display !== 'none');
            const visibleChecked = visibleCbs.filter(cb => cb.checked);
            master.checked = visibleChecked.length === visibleCbs.length && visibleCbs.length > 0;
            master.indeterminate = visibleChecked.length > 0 && visibleChecked.length < visibleCbs.length;
        }
        
        const count = checked.length;
        const bar = document.getElementById('cartBulkBar');
        const text = document.getElementById('cartSelectionCountText');
        
        if (count > 0) {
            if (bar) bar.style.display = 'flex';
            if (text) text.innerText = `${count} ${count === 1 ? 'cart' : 'carts'} selected`;
        } else {
            if (bar) bar.style.display = 'none';
        }
    }

    function clearCartSelection() {
        document.querySelectorAll('.cart-select-checkbox').forEach(cb => cb.checked = false);
        const master = document.getElementById('selectAllCarts');
        if (master) {
            master.checked = false;
            master.indeterminate = false;
        }
        updateCartSelection();
    }

    function bulkDeleteCarts() {
        const checked = document.querySelectorAll('.cart-select-checkbox:checked');
        if (checked.length === 0) return;
        
        if (!confirm(`Are you sure you want to permanently delete these ${checked.length} selected abandoned carts?`)) {
            return;
        }
        
        const ids = Array.from(checked).map(cb => parseInt(cb.dataset.id));
        
        fetch('{{ route("admin.abandoned-carts.bulk-delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'success');
                } else {
                    alert(data.message);
                }
                window.location.reload();
            } else {
                alert('Bulk delete failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('An error occurred during bulk deletion.');
            console.error(err);
        });
    }

    function clearDateFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        filterCarts();
    }

    function filterCarts() {
        const q = document.getElementById('cartSearch').value.toLowerCase().trim();
        const startVal = document.getElementById('startDate').value;
        const endVal = document.getElementById('endDate').value;
        
        const rows = document.querySelectorAll('.cart-tbl tbody tr:not(.empty-row)');
        let count = 0;
        
        rows.forEach(row => {
            const searchVal = row.getAttribute('data-search') || '';
            const dateVal = row.getAttribute('data-date') || '';
            
            // Search filter
            const matchesSearch = !q || searchVal.includes(q);
            
            // Date filter
            let matchesDate = true;
            if (startVal && dateVal < startVal) matchesDate = false;
            if (endVal && dateVal > endVal) matchesDate = false;
            
            if (matchesSearch && matchesDate) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
                const cb = row.querySelector('.cart-select-checkbox');
                if (cb) cb.checked = false;
            }
        });
        
        updateCartSelection();
        
        const emptyRow = document.querySelector('.cart-tbl tbody tr.empty-row');
        if (emptyRow) {
            emptyRow.style.display = (count === 0) ? '' : 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('cartSearch').addEventListener('input', filterCarts);
        document.getElementById('startDate').addEventListener('change', filterCarts);
        document.getElementById('endDate').addEventListener('change', filterCarts);
    });
</script>
@endsection
