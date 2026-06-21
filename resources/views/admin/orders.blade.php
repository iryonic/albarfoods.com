@extends('layouts.admin')

@section('title', 'Order Management — Al Barr Admin')
@section('header_title', 'Order Registry')

@section('styles')
<style>
    /* ─── KPI Stats Bar ─── */
    .orders-stats-bar {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
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
        transition: all 0.2s ease;
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

    .order-filters .admin-input,
    .order-filters .admin-select {
        flex: 1;
        min-width: 180px;
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

    /* ─── Collapsible Row ─── */
    .order-collapsible-row {
        cursor: pointer;
        transition: background 0.15s;
    }

    .order-collapsible-row:hover {
        background: #fafbfc;
    }

    .order-collapsible-row.expanded {
        background: #f5f8ff !important;
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
        .orders-stats-bar { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .orders-stats-bar { grid-template-columns: 1fr; }
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

    /* ─── Tracking Badge ─── */
    .tracking-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.68rem;
        font-weight: 700;
        font-family: var(--font-mono);
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .tracking-chip.has-tracking {
        background: #e6f5ec;
        color: #018849;
    }
    .tracking-chip.no-tracking {
        background: #f1f5f9;
        color: #94a3b8;
    }

    /* ─── Document Action Buttons ─── */
    .doc-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 8px;
    }

    .btn-doc-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-input);
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-family: var(--font-sans);
    }

    .btn-doc-action:hover {
        background: var(--color-admin-border-light);
        border-color: var(--color-admin-text-main);
        transform: translateY(-1px);
    }

    .btn-doc-action.invoice-btn {
        border-color: #0a4b99;
        color: #0a4b99;
    }
    .btn-doc-action.invoice-btn:hover {
        background: #cfe2ff;
    }

    .btn-doc-action.label-btn {
        border-color: #018849;
        color: #018849;
    }
    .btn-doc-action.label-btn:hover {
        background: #e6f5ec;
    }

    /* ─── Tracking Form ─── */
    .tracking-form-section {
        background: var(--color-admin-border-light);
        border-radius: 10px;
        padding: 14px 16px;
        border: 1px dashed var(--color-admin-border);
    }

    .tracking-form-section .form-title {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-admin-text-muted);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tracking-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 8px;
    }

    .tracking-form-row .admin-input,
    .tracking-form-row select {
        padding: 8px 10px;
        font-size: 0.82rem;
        border: 1px solid var(--color-admin-border);
        border-radius: 8px;
        background: #fff;
        font-family: inherit;
        font-weight: 600;
    }

    .btn-save-tracking {
        width: 100%;
        padding: 8px 14px;
        background: #018849;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }
    .btn-save-tracking:hover {
        background: #016a39;
        transform: translateY(-1px);
    }

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
            <input type="text" id="orderSearch" class="admin-input" placeholder="🔍 Search by order number or customer name…">
            
            <select id="paymentFilter" class="admin-select" style="max-width: 180px;">
                <option value="all">All Payments</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
                <option value="refunded">Refunded</option>
            </select>

            <select id="dateFilter" class="admin-select" style="max-width: 180px;">
                <option value="all">All Dates</option>
                <option value="today">Today</option>
                <option value="7days">Last 7 Days</option>
                <option value="30days">Last 30 Days</option>
            </select>

            <button class="btn-action-outline" onclick="exportFilteredOrdersToCSV()" style="margin-left: auto; height: 42px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </button>
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
                    <th style="padding-left: 24px; width: 40px;">
                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)">
                    </th>
                    <th style="width: 140px;">Order ID</th>
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
                        data-payment="{{ strtolower($order->payment_status) }}"
                        data-created-date="{{ $order->created_at->format('Y-m-d') }}"
                        data-timestamp="{{ $order->created_at->timestamp }}">

                        <td style="padding-left: 24px;" onclick="event.stopPropagation()">
                            <input type="checkbox" class="order-select-checkbox" value="{{ $order->id }}" onclick="updateBulkBar()">
                        </td>
                        <td>
                            <span style="font-family: var(--font-mono); font-size: 0.82rem; font-weight: 700; color: var(--color-admin-accent);">
                                {{ $order->order_number }}
                            </span>
                            @if($order->tracking_number)
                                <div style="margin-top: 3px;">
                                    <span class="tracking-chip has-tracking">📦 {{ $order->tracking_number }}</span>
                                </div>
                            @endif
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
                        <td colspan="9">
                            <div class="drawer-inner print-invoice" id="printInvoice-{{ $order->id }}">

                                {{-- Left: Info + Items --}}
                                <div>
                                    {{-- Visual Fulfilment Timeline --}}
                                    <div class="drawer-section-title">
                                        📌 Fulfilment Timeline
                                    </div>
                                    <div class="visual-timeline" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; position: relative; padding: 10px 0;">
                                        @php
                                            $stages = ['Pending', 'Confirmed', 'Processing', 'Packed', 'Shipped', 'Delivered'];
                                            $currentStageIndex = array_search($order->status, $stages);
                                            if ($currentStageIndex === false) {
                                                $stages = ['Pending', $order->status];
                                                $currentStageIndex = 1;
                                            }
                                        @endphp
                                        <div style="position: absolute; top: 18px; left: 0; right: 0; height: 3px; background: var(--color-admin-border); z-index: 1;"></div>
                                        <div style="position: absolute; top: 18px; left: 0; width: {{ count($stages) > 1 ? ($currentStageIndex / (count($stages) - 1)) * 100 : 0 }}%; height: 3px; background: var(--color-admin-accent); z-index: 2; transition: width 0.3s ease;"></div>
                                        
                                        @foreach($stages as $index => $stage)
                                            @php
                                                $isCompleted = $index <= $currentStageIndex;
                                                $isActive = $index === $currentStageIndex;
                                                
                                                $color = 'var(--color-admin-text-muted)';
                                                $borderColor = 'var(--color-admin-border)';
                                                $bgColor = '#fff';
                                                
                                                if ($isCompleted) {
                                                    $color = 'var(--color-admin-text-main)';
                                                    $borderColor = 'var(--color-admin-accent)';
                                                    $bgColor = 'var(--color-admin-accent)';
                                                }
                                                if ($order->status === 'Cancelled' || $order->status === 'Returned' || $order->status === 'Refunded') {
                                                    if ($isCompleted) {
                                                        $borderColor = '#ba3c1c';
                                                        $bgColor = '#ba3c1c';
                                                    }
                                                }
                                            @endphp
                                            <div style="display: flex; flex-direction: column; align-items: center; position: relative; z-index: 3; flex: 1;">
                                                <div style="width: 18px; height: 18px; border-radius: 50%; border: 3px solid {{ $borderColor }}; background: {{ $isActive ? '#fff' : $bgColor }}; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-admin-sm); transition: all 0.3s;">
                                                    @if($isCompleted && !$isActive)
                                                        <span style="color: #fff; font-size: 9px; font-weight: bold;">✓</span>
                                                    @endif
                                                </div>
                                                <span style="font-size: 0.68rem; font-weight: 700; margin-top: 6px; color: {{ $color }};">{{ $stage }}</span>
                                            </div>
                                        @endforeach
                                    </div>

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

                                    {{-- Tracking Management Section --}}
                                    <div class="tracking-form-section">
                                        <div class="form-title">📦 Tracking / Shipment Info</div>
                                        <form action="{{ route('admin.orders.tracking', $order->id) }}" method="POST">
                                            @csrf
                                            <div class="tracking-form-row">
                                                <input type="text" name="tracking_number" class="admin-input" placeholder="AWB / Tracking #" value="{{ $order->tracking_number }}">
                                                <select name="carrier_name">
                                                    <option value="">Select Carrier</option>
                                                    @foreach(['India Post', 'Delhivery', 'BlueDart', 'DTDC', 'Ecom Express', 'Shadowfax', 'Xpressbees', 'Professional Couriers', 'Other'] as $carrier)
                                                        <option value="{{ $carrier }}" @selected($order->carrier_name === $carrier)>{{ $carrier }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn-save-tracking">💾 Save Tracking</button>
                                        </form>
                                        @if($order->shipped_at)
                                            <div style="margin-top: 8px; font-size: 0.75rem; color: var(--color-admin-text-muted);">
                                                Shipped: {{ $order->shipped_at->format('d M Y, h:i A') }}
                                                @if($order->delivered_at) · Delivered: {{ $order->delivered_at->format('d M Y, h:i A') }}@endif
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Document Actions: Invoice & Label --}}
                                    <div class="doc-actions-grid">
                                        <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn-doc-action invoice-btn">
                                            📄 Invoice
                                        </a>
                                        <a href="{{ route('admin.orders.label', $order->id) }}" target="_blank" class="btn-doc-action label-btn">
                                            🏷️ Label
                                        </a>
                                    </div>

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
                                            @if($order->carrier_name)
                                            <div style="display: flex; justify-content: space-between;">
                                                <span style="color: var(--color-admin-text-muted);">Carrier</span>
                                                <span style="font-weight: 700;">{{ $order->carrier_name }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
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

<!-- Bulk Actions Floating Bar -->
<div id="bulkActionsBar" style="display: none; position: fixed; bottom: 24px; left: calc(var(--admin-sidebar-width) + 24px); right: 24px; background: rgba(10, 15, 30, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; box-shadow: var(--shadow-admin-lg); z-index: 150; padding: 16px 24px; color: #fff; animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
    
    {{-- Top Row: Count + Document Buttons --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 12px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="background: var(--color-admin-accent); color: #fff; font-size: 0.72rem; padding: 3px 8px; border-radius: 6px; font-weight: bold;" id="selectedCountBadge">0</span>
            <span style="font-size: 0.85rem; font-weight: 600;">Orders selected</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" onclick="bulkGenerateInvoices()" style="padding: 7px 14px; background: rgba(10, 75, 153, 0.2); border: 1px solid rgba(10, 75, 153, 0.4); color: #7bb8ff; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; transition: all 0.2s; font-family: inherit;" onmouseover="this.style.background='rgba(10,75,153,0.35)'" onmouseout="this.style.background='rgba(10,75,153,0.2)'">
                📄 Bulk Invoices
            </button>
            <button type="button" onclick="bulkGenerateLabels()" style="padding: 7px 14px; background: rgba(1, 136, 73, 0.2); border: 1px solid rgba(1, 136, 73, 0.4); color: #6ee7a8; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; transition: all 0.2s; font-family: inherit;" onmouseover="this.style.background='rgba(1,136,73,0.35)'" onmouseout="this.style.background='rgba(1,136,73,0.2)'">
                🏷️ Bulk Labels
            </button>
        </div>
    </div>

    {{-- Bottom Row: Status Update Form --}}
    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <form action="{{ route('admin.orders.bulk-status') }}" method="POST" style="margin: 0; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; flex: 1;" onsubmit="return confirm('Are you sure you want to update all selected orders?');">
            @csrf
            <div id="bulkFormIdsContainer"></div>
            
            <div style="display: flex; align-items: center; gap: 8px;">
                <label style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8;">Order Status:</label>
                <select name="status" class="admin-select" style="padding: 8px 12px; font-size: 0.8rem; background: #182235; color: #fff; border-color: rgba(255,255,255,0.15); width: auto; font-weight: bold; border-radius: 8px;">
                    @foreach(['Pending','Confirmed','Processing','Packed','Shipped','Delivered','Cancelled','Returned','Refunded'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: flex; align-items: center; gap: 8px;">
                <label style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8;">Payment Status:</label>
                <select name="payment_status" class="admin-select" style="padding: 8px 12px; font-size: 0.8rem; background: #182235; color: #fff; border-color: rgba(255,255,255,0.15); width: auto; font-weight: bold; border-radius: 8px;">
                    <option value="Keep">Keep Current</option>
                    @foreach(['Pending','Completed','Failed','Refunded'] as $ps)
                        <option value="{{ $ps }}">{{ $ps }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-solid-gold" style="padding: 8px 16px; font-size: 0.82rem; border-radius: 8px; border: none;">
                ⚡ Apply Changes
            </button>
        </form>
        <button type="button" onclick="cancelBulkSelection()" style="background: none; border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.7); font-size: 0.82rem; padding: 8px 14px; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#fff';this.style.color='#fff';" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)';this.style.color='rgba(255,255,255,0.7)';">
            Cancel
        </button>
    </div>
</div>

{{-- Hidden forms for bulk invoice/label generation --}}
<form id="bulkInvoiceForm" action="{{ route('admin.orders.bulk-invoices') }}" method="POST" target="_blank" style="display: none;">
    @csrf
    <div id="bulkInvoiceIdsContainer"></div>
</form>
<form id="bulkLabelForm" action="{{ route('admin.orders.bulk-labels') }}" method="POST" target="_blank" style="display: none;">
    @csrf
    <div id="bulkLabelIdsContainer"></div>
</form>


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



    /* ── Status Tab Filter ── */
    let activeStatus = 'all';
    function setStatusTab(btn) {
        document.querySelectorAll('.status-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeStatus = btn.getAttribute('data-status');
        applyFilters();
    }

    /* ── Search, Date, and Payment Filters ── */
    const searchInput   = document.getElementById('orderSearch');
    const paymentSelect = document.getElementById('paymentFilter');
    const dateSelect    = document.getElementById('dateFilter');

    function applyFilters() {
        const query   = searchInput.value.toLowerCase().trim();
        const payment = paymentSelect.value;
        const dateVal = dateSelect.value;
        const now = Date.now();

        document.querySelectorAll('.order-collapsible-row').forEach(row => {
            const id      = row.id.replace('orderRow-', '');
            const drawer  = document.getElementById(`orderDrawer-${id}`);
            const num     = row.dataset.number;
            const name    = row.dataset.name;
            const status  = row.dataset.status;
            const pmt     = row.dataset.payment;
            
            const rowDateStr = row.dataset.createdDate;
            const rowTimestamp = parseInt(row.dataset.timestamp) * 1000;

            const matchSearch  = !query  || num.includes(query) || name.includes(query);
            const matchStatus  = activeStatus === 'all' || status === activeStatus;
            const matchPayment = payment === 'all' || pmt === payment;

            let matchDate = true;
            if (dateVal === 'today') {
                const todayStr = new Date().toISOString().slice(0,10);
                matchDate = rowDateStr === todayStr;
            } else if (dateVal === '7days') {
                matchDate = (now - rowTimestamp) <= (7 * 24 * 60 * 60 * 1000);
            } else if (dateVal === '30days') {
                matchDate = (now - rowTimestamp) <= (30 * 24 * 60 * 60 * 1000);
            }

            if (matchSearch && matchStatus && matchPayment && matchDate) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
                row.classList.remove('expanded');
                drawer.classList.remove('active');
            }
        });
        updateBulkBar();
    }

    searchInput.addEventListener('input', applyFilters);
    paymentSelect.addEventListener('change', applyFilters);
    dateSelect.addEventListener('change', applyFilters);

    /* ─── Bulk Select Logic ─── */
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.order-select-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            // Only select visible rows
            if (row && row.style.display !== 'none') {
                cb.checked = masterCheckbox.checked;
            } else {
                cb.checked = false;
            }
        });
        updateBulkBar();
    }

    function updateBulkBar() {
        const checkboxes = document.querySelectorAll('.order-select-checkbox:checked');
        const bar = document.getElementById('bulkActionsBar');
        const badge = document.getElementById('selectedCountBadge');
        const container = document.getElementById('bulkFormIdsContainer');

        if (checkboxes.length > 0) {
            badge.innerText = checkboxes.length;
            bar.style.display = 'flex';
            
            // Populate form ids inputs
            container.innerHTML = '';
            checkboxes.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        } else {
            bar.style.display = 'none';
            container.innerHTML = '';
            document.getElementById('selectAllCheckbox').checked = false;
        }
    }

    function cancelBulkSelection() {
        document.querySelectorAll('.order-select-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAllCheckbox').checked = false;
        updateBulkBar();
    }

    /* ─── CSV Export Function ─── */
    function exportFilteredOrdersToCSV() {
        const rows = document.querySelectorAll('.order-collapsible-row');
        let csv = ['Order ID,Customer Name,Phone,Method,Total,Payment Status,Order Status,Date'].join(',') + '\n';
        
        let count = 0;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const num = row.querySelector('td:nth-child(2) span').innerText.trim();
                const name = row.querySelector('td:nth-child(3) div:nth-child(1)').innerText.trim();
                const phone = row.querySelector('td:nth-child(3) div:nth-child(2)').innerText.trim();
                const method = row.querySelector('td:nth-child(4)').innerText.trim();
                const total = row.querySelector('td:nth-child(5)').innerText.trim().replace('₹', '').replace(/,/g, '');
                const payment = row.querySelector('td:nth-child(6) span').innerText.trim();
                const status = row.querySelector('td:nth-child(7) span').innerText.trim();
                const date = row.querySelector('td:nth-child(8)').innerText.trim().replace(/\n/g, ' ');
                
                csv += `"${num}","${name}","${phone}","${method}","${total}","${payment}","${status}","${date}"\n`;
                count++;
            }
        });
        
        if (count === 0) {
            showToast("No orders available to export.", "error");
            return;
        }

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", `orders_export_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showToast(`Exported ${count} orders successfully!`, "success");
    }

    /* ─── Replaced printInvoice function ─── */

    /* ─── Bulk Invoice / Label Generation ─── */
    function getSelectedOrderIds() {
        return Array.from(document.querySelectorAll('.order-select-checkbox:checked')).map(cb => cb.value);
    }

    function populateHiddenIds(containerId, ids) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_ids[]';
            input.value = id;
            container.appendChild(input);
        });
    }

    function bulkGenerateInvoices() {
        const ids = getSelectedOrderIds();
        if (ids.length === 0) { showToast('No orders selected.', 'error'); return; }
        populateHiddenIds('bulkInvoiceIdsContainer', ids);
        document.getElementById('bulkInvoiceForm').submit();
        showToast(`Generating ${ids.length} invoice(s)...`, 'success');
    }

    function bulkGenerateLabels() {
        const ids = getSelectedOrderIds();
        if (ids.length === 0) { showToast('No orders selected.', 'error'); return; }
        populateHiddenIds('bulkLabelIdsContainer', ids);
        document.getElementById('bulkLabelForm').submit();
        showToast(`Generating ${ids.length} label(s)...`, 'success');
    }

</script>
@endsection
