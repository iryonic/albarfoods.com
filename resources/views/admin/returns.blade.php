@extends('layouts.admin')

@section('title', 'Return Requests — Al Barr Admin')
@section('header_title', 'Return Requests')

@section('styles')
<style>
    /* ─── Page Hero ─── */
    .page-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: var(--spacing-xl);
    }

    .page-hero h2 {
        font-family: var(--font-secondary);
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0;
    }

    .page-hero p {
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        margin: 4px 0 0;
    }

    /* ─── Stats Bar ─── */
    .returns-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: var(--spacing-xl);
    }

    .returns-stat {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 16px 20px;
        box-shadow: var(--shadow-admin-sm);
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .returns-stat:hover {
        box-shadow: var(--shadow-admin-md);
        transform: translateY(-2px);
    }

    .rs-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--color-admin-text-muted);
        margin-bottom: 4px;
    }

    .rs-value {
        font-family: var(--font-secondary);
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
    }

    /* ─── Table ─── */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .admin-table thead th {
        background: var(--color-admin-border-light);
        padding: 12px 16px;
        text-align: left;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-admin-text-muted);
        border-bottom: 1px solid var(--color-admin-border);
        white-space: nowrap;
    }

    .admin-table tbody tr {
        border-bottom: 1px solid var(--color-admin-border);
        transition: background 0.15s;
    }

    .admin-table tbody tr:hover { background: #fafbfc; }

    .admin-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    /* ─── Status Badges ─── */
    .return-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.73rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .return-badge.requested { background: #fff3cd; color: #7a5f00; }
    .return-badge.approved  { background: #d1e7dd; color: #0a5c36; }
    .return-badge.rejected  { background: #f8d7da; color: #842029; }
    .return-badge.refunded  { background: #e2e3e5; color: #383d41; }

    /* ─── Evidence Gallery ─── */
    .evidence-gallery {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 6px;
    }

    .evidence-thumb {
        width: 52px;
        height: 52px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid var(--color-admin-border);
        transition: transform 0.2s, border-color 0.2s;
        cursor: pointer;
    }

    .evidence-thumb:hover {
        transform: scale(1.1);
        border-color: var(--color-admin-gold);
    }

    /* ─── Return Reason ─── */
    .reason-box {
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        max-width: 280px;
        line-height: 1.4;
    }

    /* ─── Action Buttons ─── */
    .action-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-approve {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        background: var(--color-admin-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
    }

    .btn-approve:hover {
        background: var(--color-admin-accent-hover);
        transform: translateY(-1px);
    }

    .btn-reject {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
    }

    .btn-reject:hover {
        background: #b02a37;
        transform: translateY(-1px);
    }

    /* ─── Refund Process Box ─── */
    .refund-box {
        background: #f0f7ff;
        border: 1px solid #bfd4e8;
        border-radius: 10px;
        padding: 12px 14px;
        min-width: 220px;
    }

    .refund-box-title {
        font-size: 0.74rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #0a4b99;
        margin-bottom: 8px;
    }

    .refund-input {
        font-family: var(--font-sans);
        padding: 8px 12px;
        border: 1px solid #bfd4e8;
        border-radius: 6px;
        font-size: 0.84rem;
        width: 100%;
        margin-bottom: 8px;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .refund-input:focus {
        outline: none;
        border-color: #0a4b99;
    }

    .btn-refund {
        width: 100%;
        padding: 8px;
        background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
    }

    .btn-refund:hover {
        background: linear-gradient(135deg, #b4956d 0%, #a08260 100%);
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

    .empty-state-icon { font-size: 3.5rem; margin-bottom: 14px; opacity: 0.4; }
    .empty-state h3   { font-family: var(--font-secondary); font-size: 1.15rem; font-weight: 700; color: var(--color-admin-text-main); margin: 0 0 6px; }
    .empty-state p    { font-size: 0.87rem; margin: 0; }

    /* Mobile app responsiveness overrides */
    @media (max-width: 768px) {
        .status-tabs {
            margin-bottom: 0 !important;
            border-bottom: none !important;
            padding: 12px 16px !important;
        }
    }

    @media (max-width: 640px) {
        .date-filter-container {
            width: 100% !important;
            margin-left: 0 !important;
            display: grid !important;
            grid-template-columns: auto 1fr auto 1fr !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .date-filter-container .btn-action-outline {
            grid-column: span 4 !important;
            width: 100% !important;
            margin-top: 4px !important;
        }
        .date-filter-container input {
            max-width: 100% !important;
            width: 100% !important;
        }
    }

    @media (max-width: 480px) {
        .date-filter-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
        }
        .date-filter-container label {
            margin-top: 4px;
            margin-bottom: 2px !important;
        }
    }
</style>
@endsection

@section('content')
@php
    $total     = $returns->count();
    $requested = $returns->where('status', 'Requested')->count();
    $approved  = $returns->where('status', 'Approved')->count();
    $rejected  = $returns->where('status', 'Rejected')->count();
    $refunded  = $returns->filter(fn($r) => $r->refund && $r->refund->status === 'Completed')->count();
@endphp

{{-- Page Hero --}}
<div class="page-hero" style="margin-bottom: 24px;">
    <div>
        <h2 style="font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 800; margin: 0;">Return Requests</h2>
        <p style="font-size: 0.84rem; color: var(--color-admin-text-muted); margin: 4px 0 0;">{{ $total }} total return requests · Review evidence and process refunds</p>
    </div>
</div>

{{-- Stats --}}
<div class="stats-4-grid">
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $total }}</div>
            <div class="stat-kpi-label">Total Returns</div>
        </div>
    </div>
    <div class="stat-kpi-card amber">
        <div class="stat-kpi-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $requested }}</div>
            <div class="stat-kpi-label">Pending Review</div>
        </div>
    </div>
    <div class="stat-kpi-card green">
        <div class="stat-kpi-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $approved }}</div>
            <div class="stat-kpi-label">Approved</div>
        </div>
    </div>
    <div class="stat-kpi-card purple">
        <div class="stat-kpi-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $refunded }}</div>
            <div class="stat-kpi-label">Refunded</div>
        </div>
    </div>
</div>

{{-- Returns Table --}}
<div class="admin-card" style="padding: 0;">
    {{-- Tabs filter --}}
    <div class="status-tabs" style="border-bottom:1px solid var(--color-admin-border); padding: 12px 20px; background:#fafbfc; display:flex; gap:8px; align-items:center; margin-bottom: 0;">
        <button class="btn-action-outline status-tab-btn active" onclick="filterByTab('all', this)" style="border-radius: 20px; padding: 6px 16px;">All ({{ $total }})</button>
        <button class="btn-action-outline status-tab-btn" onclick="filterByTab('requested', this)" style="border-radius: 20px; padding: 6px 16px;">Pending Review ({{ $requested }})</button>
        <button class="btn-action-outline status-tab-btn" onclick="filterByTab('approved', this)" style="border-radius: 20px; padding: 6px 16px;">Approved ({{ $approved }})</button>
        <button class="btn-action-outline status-tab-btn" onclick="filterByTab('rejected', this)" style="border-radius: 20px; padding: 6px 16px;">Rejected ({{ $rejected }})</button>
        <button class="btn-action-outline status-tab-btn" onclick="filterByTab('refunded', this)" style="border-radius: 20px; padding: 6px 16px;">Refunded ({{ $refunded }})</button>
    </div>

    {{-- Search + Date filter row --}}
    <div class="filter-row" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; padding:16px 24px; border-bottom:1px solid var(--color-admin-border); background:#fff;">
        <input type="text" id="returnSearch" class="admin-input" placeholder="Search Return ID, Customer, Order..." style="flex:1; min-width:240px; max-width:360px;">
        
        <div class="date-filter-container" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-left:auto;">
            <label style="font-size:0.75rem; font-weight:700; color:var(--color-admin-text-muted); text-transform:uppercase;">From:</label>
            <input type="date" id="startDate" class="admin-input" style="max-width:140px; padding:8px 12px; font-size:0.82rem;">
            
            <label style="font-size:0.75rem; font-weight:700; color:var(--color-admin-text-muted); text-transform:uppercase;">To:</label>
            <input type="date" id="endDate" class="admin-input" style="max-width:140px; padding:8px 12px; font-size:0.82rem;">
            
            <button class="btn-action-outline" onclick="clearDateFilter()" style="padding:8px 12px;">Clear Dates</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="padding-left: 24px;">Return ID</th>
                    <th>Order Info</th>
                    <th>Customer</th>
                    <th>Reason &amp; Evidence</th>
                    <th>Requested</th>
                    <th>Status</th>
                    <th>Refund</th>
                    <th style="text-align: right; padding-right: 24px; min-width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $return)
                    @php
                        $isCompletedRefund = $return->refund && $return->refund->status === 'Completed';
                        $searchTags = strtolower('RT-' . $return->id . ' ' . ($return->user->name ?? 'Guest User') . ' ' . $return->order->order_number);
                    @endphp
                    <tr data-status="{{ strtolower($return->status) }}" 
                        data-refunded="{{ $isCompletedRefund ? 'true' : 'false' }}"
                        data-search="{{ $searchTags }}"
                        data-date="{{ $return->created_at->format('Y-m-d') }}">
                        <td style="padding-left: 24px;">
                            <span style="font-family: var(--font-mono); font-weight: 700; font-size: 0.88rem; color: var(--color-admin-text-main);">#RT-{{ $return->id }}</span>
                        </td>
                        <td>
                            <div style="font-family: var(--font-mono); font-weight: 700; font-size: 0.85rem;">{{ $return->order->order_number }}</div>
                            <div style="font-size: 0.76rem; color: var(--color-admin-text-muted); margin-top: 2px;">
                                ₹{{ number_format($return->order->grand_total, 2) }} · {{ $return->order->payment_method }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $return->user->name ?? 'Guest User' }}</div>
                            @if($return->user?->phone)
                                <div style="font-size: 0.76rem; color: var(--color-admin-text-muted);">{{ $return->user->phone }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="reason-box" style="padding: 10px 14px; border-radius: 8px; font-size: 0.82rem; line-height: 1.4; color: var(--color-admin-text-main); background: #f8fafc; border: 1px solid var(--color-admin-border);">
                                {{ $return->reason }}
                            </div>
                            @if(!empty($return->evidence_images))
                                <div class="evidence-gallery" style="display:flex; gap:8px; margin-top:10px;">
                                    @foreach($return->evidence_images as $path)
                                        <img src="/{{ $path }}" class="evidence-thumb" style="width:52px; height:52px; border-radius:8px; object-fit:cover; border: 1px solid var(--color-admin-border); cursor:pointer; transition:transform 0.2s;" alt="Evidence" onclick="openLightbox('/{{ $path }}')">
                                    @endforeach
                                </div>
                            @else
                                <div style="font-size: 0.76rem; color: var(--color-admin-text-muted); margin-top: 6px; font-style: italic;">No evidence uploaded</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--color-admin-text-main);">
                                {{ $return->created_at->format('d M Y') }}
                            </div>
                            <div style="font-size: 0.76rem; color: var(--color-admin-text-muted); margin-top: 2px;">
                                {{ $return->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            @php
                                $rc = match($return->status) {
                                    'Requested' => 'requested',
                                    'Approved'  => 'approved',
                                    'Rejected'  => 'rejected',
                                    default     => 'refunded'
                                };
                            @endphp
                            <span class="return-badge {{ $rc }}">{{ $return->status }}</span>
                        </td>
                        <td>
                            @if($return->refund)
                                <div style="font-size: 0.85rem;">
                                    <div style="font-weight: 700; margin-bottom: 3px;">₹{{ number_format($return->refund->amount, 2) }}</div>
                                    <span class="return-badge {{ strtolower($return->refund->status) }}">{{ $return->refund->status }}</span>
                                    @if($return->refund->transaction_reference)
                                        <div style="font-size: 0.74rem; color: var(--color-admin-text-muted); font-family: var(--font-mono); margin-top: 4px;">
                                            Ref: {{ $return->refund->transaction_reference }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span style="font-size: 0.8rem; color: var(--color-admin-text-muted); font-style: italic;">No refund created</span>
                            @endif
                        </td>
                        <td style="text-align: right; padding-right: 24px;">
                            <div class="action-row" style="display:flex; gap:8px; justify-content:flex-end; align-items:center;">
                                @if($return->status === 'Requested')
                                    <form action="{{ route('admin.returns.approve', $return->id) }}" method="POST"
                                          onsubmit="return confirm('Approve this return request?')">
                                        @csrf
                                        <button type="submit" class="btn-approve" style="background:var(--color-admin-accent); color:#fff; border:none; padding:8px 14px; border-radius:8px; font-weight:700; cursor:pointer;">✓ Approve</button>
                                    </form>
                                    <form action="{{ route('admin.returns.reject', $return->id) }}" method="POST"
                                          onsubmit="return confirm('Reject this return request?')">
                                        @csrf
                                        <button type="submit" class="btn-reject" style="background:#ba3c1c; color:#fff; border:none; padding:8px 14px; border-radius:8px; font-weight:700; cursor:pointer;">✕ Reject</button>
                                    </form>

                                @elseif($return->status === 'Approved' && $return->refund && $return->refund->status === 'Pending')
                                    <button class="btn-solid-gold" style="padding:8px 14px; font-size:0.8rem; display: inline-flex; align-items: center;" onclick="openRefundModal({{ $return->id }}, '{{ $return->order->order_number }}', {{ $return->refund->amount }})">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg> Record Refund
                                    </button>

                                @else
                                    <span style="font-size: 0.8rem; color: var(--color-admin-text-muted); font-style: italic;">No action needed</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="8">
                             <div class="empty-state">
                                 <div class="empty-state-icon"><svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4;"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></div>
                                <h3>No Return Requests</h3>
                                <p>Customer return requests will appear here when submitted.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                {{-- Client-side empty row --}}
                <tr class="empty-row" style="display:none;">
                    <td colspan="8">
                         <div class="empty-state">
                             <div class="empty-state-icon"><svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4;"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></div>
                            <h3>No Matching Returns</h3>
                            <p>No return requests match this status filter.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ─── Record Refund Modal ─── --}}
<div class="admin-modal-overlay" id="recordRefundModal">
    <div class="admin-modal-card" style="max-width: 450px;">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Record Refund Settlement</h3>
            <button class="admin-modal-close" onclick="closeModal('recordRefundModal')">&times;</button>
        </div>
        <form id="recordRefundForm" method="POST">
            @csrf
            <div class="admin-modal-body">
                <div style="background: var(--color-admin-border-light); padding: 14px; border-radius: 10px; margin-bottom: 20px; border: 1px solid var(--color-admin-border);">
                    <div style="font-size: 0.82rem; color: var(--color-admin-text-muted); font-weight:600;">Refund Amount for Order <strong id="refundOrderNumber" style="color:var(--color-admin-text-main);"></strong>:</div>
                    <div style="font-size: 1.6rem; font-weight: 800; color: #ba3c1c; margin-top: 6px; font-family:var(--font-secondary);" id="refundAmountText"></div>
                </div>
                <div class="admin-form-group">
                    <label for="refundTxnRef">Transaction Reference *</label>
                    <input type="text" name="transaction_reference" id="refundTxnRef" class="admin-input" placeholder="Bank txn ref, UPI ID, or IMPS ID" required>
                </div>
                <button type="submit" class="btn-solid-accent" style="width: 100%; justify-content: center; padding: 12px;">
                    Confirm Refund &amp; Complete Return
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Lightbox Modal --}}
<div class="admin-modal-overlay" id="lightboxModal" style="background-color: rgba(0,0,0,0.85); z-index: 9999;">
    <div style="position: relative; max-width: 90%; max-height: 90%; display:flex; align-items:center; justify-content:center;">
        <button class="admin-modal-close" onclick="closeModal('lightboxModal')" style="position: absolute; top: -45px; right: 0; font-size: 2.2rem; color: #fff; background:none; border:none; cursor:pointer;">&times;</button>
        <img id="lightboxImage" src="" style="max-width: 100%; max-height: 80vh; border-radius: 8px; border: 2px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openLightbox(src) {
        document.getElementById('lightboxImage').src = src;
        openModal('lightboxModal');
    }

    function openRefundModal(returnId, orderNumber, amount) {
        const form = document.getElementById('recordRefundForm');
        form.action = `/admin/returns/${returnId}/refund`;
        document.getElementById('refundOrderNumber').innerText = orderNumber;
        document.getElementById('refundAmountText').innerText = '₹' + parseFloat(amount).toFixed(2);
        document.getElementById('refundTxnRef').value = '';
        openModal('recordRefundModal');
    }

    let currentTab = 'all';

    function filterByTab(status, btn) {
        currentTab = status;
        const container = btn.parentElement;
        container.querySelectorAll('button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        filterReturns();
    }

    function clearDateFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        filterReturns();
    }

    function filterReturns() {
        const q = document.getElementById('returnSearch').value.toLowerCase().trim();
        const startVal = document.getElementById('startDate').value;
        const endVal = document.getElementById('endDate').value;
        
        const rows = document.querySelectorAll('.admin-table tbody tr:not(.empty-row)');
        let count = 0;
        
        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const isRefunded = row.getAttribute('data-refunded') === 'true';
            const searchVal = row.getAttribute('data-search') || '';
            const dateVal = row.getAttribute('data-date') || '';
            
            // 1. Tab Filter
            let matchesTab = false;
            if (currentTab === 'all') {
                matchesTab = true;
            } else if (currentTab === 'refunded') {
                matchesTab = isRefunded;
            } else {
                matchesTab = (rowStatus === currentTab);
            }
            
            // 2. Search Filter
            const matchesSearch = !q || searchVal.includes(q);
            
            // 3. Date Filter
            let matchesDate = true;
            if (startVal && dateVal < startVal) matchesDate = false;
            if (endVal && dateVal > endVal) matchesDate = false;
            
            if (matchesTab && matchesSearch && matchesDate) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update empty states
        const emptyRows = document.querySelectorAll('.empty-row');
        if (emptyRows.length > 0) {
            if (count === 0) {
                emptyRows[0].style.display = 'none'; // hide main empty row
                emptyRows[1].style.display = '';     // show filter empty row
            } else {
                emptyRows[0].style.display = 'none';
                emptyRows[1].style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('returnSearch').addEventListener('input', filterReturns);
        document.getElementById('startDate').addEventListener('change', filterReturns);
        document.getElementById('endDate').addEventListener('change', filterReturns);
    });
</script>
@endsection
