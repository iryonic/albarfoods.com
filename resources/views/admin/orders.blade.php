@extends('layouts.admin')

@section('title', 'Order Management — Al Barr Admin')
@section('header_title', 'Order Registry')

@section('styles')
<style>
    /* ─── Page Header Row ─── */
    .orders-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: var(--spacing-xl);
    }

    .orders-page-header h2 {
        font-family: var(--font-secondary);
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0;
    }

    .orders-page-header p {
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        margin: 4px 0 0;
    }

    /* ─── KPI Stats Bar ─── */
    .orders-stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
        margin-bottom: var(--spacing-xl);
    }

    .orders-stat-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 18px 20px;
        box-shadow: var(--shadow-admin-sm);
        display: flex;
        flex-direction: column;
        gap: 4px;
        transition: box-shadow 0.2s, transform 0.2s;
        cursor: default;
    }

    .orders-stat-card:hover {
        box-shadow: var(--shadow-admin-md);
        transform: translateY(-2px);
    }

    .stat-card-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--color-admin-text-muted);
    }

    .stat-card-value {
        font-family: var(--font-secondary);
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        letter-spacing: -0.5px;
    }

    .stat-card-sub {
        font-size: 0.78rem;
        color: var(--color-admin-text-muted);
    }

    /* ─── Filters Row ─── */
    .order-filters {
        display: flex;
        gap: 12px;
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
        align-items: center;
    }

    .order-filters .admin-input {
        flex: 1;
        min-width: 220px;
    }

    /* ─── Status Tabs ─── */
    .status-tabs {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
        margin-bottom: var(--spacing-lg);
        border-bottom: 2px solid var(--color-admin-border);
        padding-bottom: 0;
    }

    .status-tab-btn {
        padding: 10px 18px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .status-tab-btn:hover {
        color: var(--color-admin-text-main);
    }

    .status-tab-btn.active {
        color: var(--color-admin-text-main);
        border-bottom-color: var(--color-admin-text-main);
    }

    .status-tab-btn .tab-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--color-admin-border);
        color: var(--color-admin-text-muted);
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        margin-left: 6px;
    }

    .status-tab-btn.active .tab-count {
        background: var(--color-admin-text-main);
        color: #fff;
    }

    /* ─── Table ─── */
    .orders-table-wrap {
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .admin-table thead th {
        background: var(--color-admin-border-light);
        padding: 12px 16px;
        text-align: left;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-admin-text-muted);
        border-bottom: 1px solid var(--color-admin-border);
        white-space: nowrap;
    }

    .admin-table tbody tr {
        border-bottom: 1px solid var(--color-admin-border);
    }

    .admin-table tbody tr td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    /* ─── Collapsible Row ─── */
    .order-collapsible-row {
        cursor: pointer;
        transition: background 0.15s;
    }

    .order-collapsible-row:hover {
        background: #fafbfc;
    }

    .order-collapsible-row.expanded {
        background: #f5f8ff;
    }

    /* ─── Expanded Drawer ─── */
    .order-details-drawer {
        display: none;
        background: #fafbfc;
    }

    .order-details-drawer.active {
        display: table-row;
        animation: drawerOpen 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes drawerOpen {
        from { opacity: 0; transform: scaleY(0.97); }
        to   { opacity: 1; transform: scaleY(1); }
    }

    .drawer-inner {
        padding: 28px 32px;
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 40px;
    }

    @media (max-width: 900px) {
        .drawer-inner { grid-template-columns: 1fr; gap: 24px; }
    }

    /* Drawer sections */
    .drawer-section-title {
        font-family: var(--font-secondary);
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        padding-bottom: 8px;
        margin-bottom: 14px;
        border-bottom: 2px solid var(--color-admin-border);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 16px;
        margin-bottom: 16px;
    }

    .detail-item-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-admin-text-muted);
        margin-bottom: 2px;
    }

    .detail-item-val {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--color-admin-text-main);
    }

    .order-notes-box {
        background: #fff8f6;
        border-left: 3px solid #e8826a;
        padding: 10px 14px;
        border-radius: 6px;
        font-size: 0.87rem;
        color: #7a3825;
        font-style: italic;
        margin-top: 6px;
    }

    /* Items list in drawer */
    .order-items-list {
        border: 1px solid var(--color-admin-border);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        font-size: 0.86rem;
        border-bottom: 1px dashed var(--color-admin-border);
        gap: 12px;
    }

    .order-item-row:last-child {
        border-bottom: none;
    }

    .order-item-name {
        font-weight: 600;
        color: var(--color-admin-text-main);
    }

    .order-item-qty {
        color: var(--color-admin-text-muted);
        font-size: 0.8rem;
    }

    .order-item-price {
        font-weight: 700;
        white-space: nowrap;
    }

    .order-financials {
        background: var(--color-admin-border-light);
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 0.86rem;
    }

    .order-financial-row {
        display: flex;
        justify-content: space-between;
        color: var(--color-admin-text-muted);
    }

    .order-financial-row.total {
        font-size: 1rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        padding-top: 8px;
        border-top: 1px solid var(--color-admin-border);
        margin-top: 4px;
    }

    .order-financial-row.discount {
        color: var(--color-admin-accent);
    }

    /* ─── Status update form (right panel) ─── */
    .order-update-panel {
        border-left: 1px solid var(--color-admin-border);
        padding-left: 32px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    @media (max-width: 900px) {
        .order-update-panel {
            border-left: none;
            border-top: 1px solid var(--color-admin-border);
            padding-left: 0;
            padding-top: 24px;
        }
    }

    /* ─── Status Badges ─── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.73rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .status-badge::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.7;
    }

    .status-badge.pending    { background: #fff3cd; color: #7a5f00; }
    .status-badge.confirmed  { background: #cfe2ff; color: #0a4b99; }
    .status-badge.processing { background: #e6d9ff; color: #4b1db5; }
    .status-badge.packed     { background: #d0f0fd; color: #065077; }
    .status-badge.shipped    { background: #d1ecf1; color: #0c5460; }
    .status-badge.delivered  { background: #d1e7dd; color: #0a5c36; }
    .status-badge.cancelled  { background: #f8d7da; color: #842029; }
    .status-badge.returned   { background: #fce5e5; color: #9b2335; }
    .status-badge.refunded   { background: #e2e3e5; color: #383d41; }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.73rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .payment-badge.pending   { background: #fff3cd; color: #7a5f00; }
    .payment-badge.completed { background: #d1e7dd; color: #0a5c36; }
    .payment-badge.failed    { background: #f8d7da; color: #842029; }
    .payment-badge.refunded  { background: #e2e3e5; color: #383d41; }

    /* ─── Expand Arrow ─── */
    .expand-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: var(--color-admin-text-muted);
        transition: all 0.2s;
    }

    .order-collapsible-row.expanded .expand-icon {
        background: var(--color-admin-text-main);
        color: #fff;
        border-color: var(--color-admin-text-main);
        transform: rotate(180deg);
    }

    /* ─── Print Styles ─── */
    @media print {
        body * { visibility: hidden; }
        .print-invoice, .print-invoice * { visibility: visible; }
        .print-invoice {
            position: absolute;
            left: 0; top: 0;
            width: 100%;
            padding: 40px;
        }
    }

    /* ─── Invoice Print Button ─── */
    .btn-print-invoice {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-input);
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        justify-content: center;
        margin-top: 4px;
    }

    .btn-print-invoice:hover {
        background: var(--color-admin-border-light);
        border-color: var(--color-admin-text-main);
    }

    /* ─── Admin Form Group ─── */
    .admin-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .admin-form-group label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--color-admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    /* ─── Btn Gold ─── */
    .btn-gold {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
        color: #fff;
        border: none;
        border-radius: var(--radius-admin-input);
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-family: var(--font-sans);
    }

    .btn-gold:hover {
        background: linear-gradient(135deg, #b4956d 0%, #a08260 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(197, 168, 128, 0.35);
    }

    /* ─── Empty State ─── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        text-align: center;
        color: var(--color-admin-text-muted);
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-family: var(--font-secondary);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        margin: 0 0 8px;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }
</style>
@endsection

@section('content')
@php
    $statusGroups = ['all' => $orders->count()];
    foreach ($orders as $o) {
        $s = strtolower($o->status);
        $statusGroups[$s] = ($statusGroups[$s] ?? 0) + 1;
    }
    $totalRevenue  = $orders->where('payment_status', 'Completed')->sum('grand_total');
    $pendingCount  = $orders->whereIn('status', ['Pending', 'Confirmed', 'Processing'])->count();
    $deliveredCount = $orders->where('status', 'Delivered')->count();
    $cancelledCount = $orders->whereIn('status', ['Cancelled', 'Returned', 'Refunded'])->count();
@endphp

{{-- ─── Page Header ─── --}}
<div class="orders-page-header">
    <div>
        <h2>Order Registry</h2>
        <p>{{ $orders->count() }} total orders · Manage fulfilment, payments and statuses</p>
    </div>
</div>

{{-- ─── KPI Stats Bar ─── --}}
<div class="orders-stats-bar">
    <div class="orders-stat-card">
        <div class="stat-card-label">Total Orders</div>
        <div class="stat-card-value">{{ $orders->count() }}</div>
        <div class="stat-card-sub">All time placements</div>
    </div>
    <div class="orders-stat-card">
        <div class="stat-card-label">Revenue Collected</div>
        <div class="stat-card-value" style="font-size: 1.25rem;">₹{{ number_format($totalRevenue, 0) }}</div>
        <div class="stat-card-sub">Completed payments only</div>
    </div>
    <div class="orders-stat-card">
        <div class="stat-card-label">Active / Pending</div>
        <div class="stat-card-value" style="color: #b36200;">{{ $pendingCount }}</div>
        <div class="stat-card-sub">Awaiting processing</div>
    </div>
    <div class="orders-stat-card">
        <div class="stat-card-label">Delivered</div>
        <div class="stat-card-value" style="color: var(--color-admin-accent);">{{ $deliveredCount }}</div>
        <div class="stat-card-sub">Successfully fulfilled</div>
    </div>
    <div class="orders-stat-card">
        <div class="stat-card-label">Cancelled / Returns</div>
        <div class="stat-card-value" style="color: #842029;">{{ $cancelledCount }}</div>
        <div class="stat-card-sub">Refunds / reversals</div>
    </div>
</div>

{{-- ─── Table Card ─── --}}
<div class="admin-card" style="padding: 0;">

    {{-- Filter Bar --}}
    <div style="padding: 20px 24px 0;">
        <div class="order-filters">
            <input type="text" id="orderSearch" class="admin-input" placeholder="🔍 Search by order number or customer name…" style="max-width: 360px;">
            <select id="paymentFilter" class="admin-input" style="max-width: 200px;">
                <option value="all">All Payments</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
                <option value="refunded">Refunded</option>
            </select>
        </div>

        {{-- Status Tabs --}}
        <div class="status-tabs" id="statusTabs">
            <button class="status-tab-btn active" data-status="all" onclick="setStatusTab(this)">
                All <span class="tab-count">{{ $orders->count() }}</span>
            </button>
            @foreach(['Pending','Confirmed','Processing','Packed','Shipped','Delivered','Cancelled','Returned','Refunded'] as $s)
                @php $cnt = $orders->where('status', $s)->count(); @endphp
                @if($cnt > 0 || in_array($s, ['Pending','Delivered','Cancelled']))
                <button class="status-tab-btn" data-status="{{ strtolower($s) }}" onclick="setStatusTab(this)">
                    {{ $s }} <span class="tab-count">{{ $cnt }}</span>
                </button>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Table --}}
    <div class="orders-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="padding-left: 24px; width: 150px;">Order ID</th>
                    <th>Customer</th>
                    <th>Method</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align: center; width: 60px;"></th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                @forelse($orders as $order)
                    {{-- ─── Collapsible Row ─── --}}
                    <tr class="order-collapsible-row"
                        id="orderRow-{{ $order->id }}"
                        onclick="toggleOrderDetails({{ $order->id }})"
                        data-number="{{ strtolower($order->order_number) }}"
                        data-name="{{ strtolower($order->shipping_name) }}"
                        data-status="{{ strtolower($order->status) }}"
                        data-payment="{{ strtolower($order->payment_status) }}">

                        <td style="padding-left: 24px;">
                            <span style="font-family: var(--font-mono); font-size: 0.82rem; font-weight: 700; color: var(--color-admin-accent);">
                                {{ $order->order_number }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--color-admin-text-main);">{{ $order->shipping_name }}</div>
                            <div style="font-size: 0.76rem; color: var(--color-admin-text-muted); margin-top: 1px;">{{ $order->shipping_phone }}</div>
                        </td>
                        <td style="font-size: 0.82rem; color: var(--color-admin-text-muted); font-weight: 600;">{{ $order->payment_method }}</td>
                        <td style="font-weight: 800; font-size: 0.95rem;">₹{{ number_format($order->grand_total, 2) }}</td>
                        <td>
                            <span class="payment-badge {{ strtolower($order->payment_status) }}">
                                {{ $order->payment_status }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ strtolower($order->status) }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td style="font-size: 0.82rem; color: var(--color-admin-text-muted);">
                            {{ $order->created_at->format('d M Y') }}<br>
                            <span style="font-size: 0.72rem;">{{ $order->created_at->format('h:i A') }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="expand-icon" id="expandIcon-{{ $order->id }}">▼</span>
                        </td>
                    </tr>

                    {{-- ─── Drawer ─── --}}
                    <tr class="order-details-drawer" id="orderDrawer-{{ $order->id }}" onclick="event.stopPropagation()">
                        <td colspan="8">
                            <div class="drawer-inner print-invoice" id="printInvoice-{{ $order->id }}">

                                {{-- Left: Info + Items --}}
                                <div>
                                    <div class="drawer-section-title">
                                        🚚 Shipping &amp; Customer Information
                                    </div>

                                    <div class="detail-grid">
                                        <div>
                                            <div class="detail-item-label">Customer Name</div>
                                            <div class="detail-item-val">{{ $order->shipping_name }}</div>
                                        </div>
                                        <div>
                                            <div class="detail-item-label">Order Placed</div>
                                            <div class="detail-item-val">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                        </div>
                                        <div>
                                            <div class="detail-item-label">Phone</div>
                                            <div class="detail-item-val">{{ $order->shipping_phone }}</div>
                                        </div>
                                        <div>
                                            <div class="detail-item-label">Alt Phone</div>
                                            <div class="detail-item-val">{{ $order->shipping_alt_phone ?? '—' }}</div>
                                        </div>
                                        <div style="grid-column: span 2;">
                                            <div class="detail-item-label">Shipping Address</div>
                                            <div class="detail-item-val">
                                                {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_pincode }}
                                                @if($order->shipping_landmark)
                                                    <span style="font-size: 0.8rem; color: var(--color-admin-text-muted);"> · Landmark: {{ $order->shipping_landmark }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($order->order_notes)
                                        <div class="order-notes-box">
                                            📝 Customer Note: "{{ $order->order_notes }}"
                                        </div>
                                    @endif

                                    <div class="drawer-section-title" style="margin-top: 20px;">
                                        🛒 Items Ordered
                                    </div>
                                    <div class="order-items-list">
                                        @foreach($order->items as $item)
                                            <div class="order-item-row">
                                                <div>
                                                    <div class="order-item-name">{{ $item->title }}</div>
                                                    <div class="order-item-qty">{{ $item->weight }} · Qty: {{ $item->quantity }}</div>
                                                </div>
                                                <div class="order-item-price">₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="order-financials">
                                        <div class="order-financial-row">
                                            <span>Subtotal</span>
                                            <span>₹{{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        @if($order->discount > 0)
                                            <div class="order-financial-row discount">
                                                <span>Discount Applied</span>
                                                <span>− ₹{{ number_format($order->discount, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="order-financial-row">
                                            <span>Delivery Charge</span>
                                            <span>₹{{ number_format($order->delivery_charge, 2) }}</span>
                                        </div>
                                        <div class="order-financial-row total">
                                            <span>Grand Total</span>
                                            <span>₹{{ number_format($order->grand_total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right: Status Update --}}
                                <div class="order-update-panel">
                                    <div class="drawer-section-title">⚙️ Process &amp; Update Order</div>

                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf

                                        <div class="admin-form-group" style="margin-bottom: 14px;">
                                            <label for="orderStatus-{{ $order->id }}">Order Dispatch Status</label>
                                            <select name="status" id="orderStatus-{{ $order->id }}" class="admin-input" style="font-weight: 700;">
                                                @foreach(['Pending','Confirmed','Processing','Packed','Shipped','Delivered','Cancelled','Returned','Refunded'] as $status)
                                                    <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="admin-form-group" style="margin-bottom: 18px;">
                                            <label for="paymentStatus-{{ $order->id }}">Payment Settlement Status</label>
                                            <select name="payment_status" id="paymentStatus-{{ $order->id }}" class="admin-input" style="font-weight: 700;">
                                                @foreach(['Pending','Completed','Failed','Refunded'] as $ps)
                                                    <option value="{{ $ps }}" @selected($order->payment_status === $ps)>{{ $ps }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn-gold" style="width: 100%; border-radius: 8px;">
                                            💾 Save Changes
                                        </button>
                                    </form>

                                    <button class="btn-print-invoice" onclick="printInvoice({{ $order->id }})">
                                        🖨️ Print Packing Slip / Invoice
                                    </button>

                                    {{-- Quick Info Panel --}}
                                    <div style="background: var(--color-admin-border-light); border-radius: 8px; padding: 14px 16px; margin-top: 8px;">
                                        <div style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; color: var(--color-admin-text-muted); margin-bottom: 8px;">Quick Info</div>
                                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 0.84rem;">
                                            <div style="display: flex; justify-content: space-between;">
                                                <span style="color: var(--color-admin-text-muted);">Order #</span>
                                                <span style="font-family: var(--font-mono); font-weight: 700;">{{ $order->order_number }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between;">
                                                <span style="color: var(--color-admin-text-muted);">Payment Method</span>
                                                <span style="font-weight: 700;">{{ $order->payment_method }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between;">
                                                <span style="color: var(--color-admin-text-muted);">Items Count</span>
                                                <span style="font-weight: 700;">{{ $order->items->sum('quantity') }} items</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">📦</div>
                                <h3>No Orders Found</h3>
                                <p>Orders from your storefront will appear here once customers start placing them.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /* ── Toggle Drawer ── */
    function toggleOrderDetails(id) {
        const row    = document.getElementById(`orderRow-${id}`);
        const drawer = document.getElementById(`orderDrawer-${id}`);
        const icon   = document.getElementById(`expandIcon-${id}`);
        const isOpen = drawer.classList.contains('active');

        // Close all
        document.querySelectorAll('.order-details-drawer').forEach(d => d.classList.remove('active'));
        document.querySelectorAll('.order-collapsible-row').forEach(r => r.classList.remove('expanded'));

        if (!isOpen) {
            drawer.classList.add('active');
            row.classList.add('expanded');
            drawer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    /* ── Print Invoice ── */
    function printInvoice(id) {
        // Hide everything except the target invoice box
        document.querySelectorAll('.print-invoice').forEach(el => {
            el.style.display = 'none';
        });
        const inv = document.getElementById(`printInvoice-${id}`);
        if (inv) inv.style.display = 'grid';
        window.print();
        // Restore
        document.querySelectorAll('.print-invoice').forEach(el => {
            el.style.display = '';
        });
    }

    /* ── Status Tab Filter ── */
    let activeStatus = 'all';
    function setStatusTab(btn) {
        document.querySelectorAll('.status-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeStatus = btn.getAttribute('data-status');
        applyFilters();
    }

    /* ── Search & Payment Filter ── */
    const searchInput   = document.getElementById('orderSearch');
    const paymentSelect = document.getElementById('paymentFilter');

    function applyFilters() {
        const query   = searchInput.value.toLowerCase().trim();
        const payment = paymentSelect.value;

        document.querySelectorAll('.order-collapsible-row').forEach(row => {
            const id      = row.id.replace('orderRow-', '');
            const drawer  = document.getElementById(`orderDrawer-${id}`);
            const num     = row.dataset.number;
            const name    = row.dataset.name;
            const status  = row.dataset.status;
            const pmt     = row.dataset.payment;

            const matchSearch  = !query  || num.includes(query) || name.includes(query);
            const matchStatus  = activeStatus === 'all' || status === activeStatus;
            const matchPayment = payment === 'all' || pmt === payment;

            if (matchSearch && matchStatus && matchPayment) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
                row.classList.remove('expanded');
                drawer.classList.remove('active');
            }
        });
    }

    searchInput.addEventListener('input', applyFilters);
    paymentSelect.addEventListener('change', applyFilters);
</script>
@endsection
