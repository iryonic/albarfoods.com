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
<div class="page-hero">
    <div>
        <h2>Return Requests</h2>
        <p>{{ $total }} total return requests · Review evidence and process refunds</p>
    </div>
</div>

{{-- Stats --}}
<div class="returns-stats">
    <div class="returns-stat">
        <div class="rs-label">Total Returns</div>
        <div class="rs-value">{{ $total }}</div>
    </div>
    <div class="returns-stat">
        <div class="rs-label">Pending Review</div>
        <div class="rs-value" style="color: #7a5f00;">{{ $requested }}</div>
    </div>
    <div class="returns-stat">
        <div class="rs-label">Approved</div>
        <div class="rs-value" style="color: var(--color-admin-accent);">{{ $approved }}</div>
    </div>
    <div class="returns-stat">
        <div class="rs-label">Rejected</div>
        <div class="rs-value" style="color: #842029;">{{ $rejected }}</div>
    </div>
    <div class="returns-stat">
        <div class="rs-label">Refunded</div>
        <div class="rs-value" style="color: var(--color-admin-text-muted);">{{ $refunded }}</div>
    </div>
</div>

{{-- Returns Table --}}
<div class="admin-card" style="padding: 0;">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="padding-left: 24px;">Return ID</th>
                    <th>Order Info</th>
                    <th>Customer</th>
                    <th>Reason &amp; Evidence</th>
                    <th>Status</th>
                    <th>Refund</th>
                    <th style="text-align: right; padding-right: 24px; min-width: 220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $return)
                    <tr>
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
                            <div class="reason-box">{{ $return->reason }}</div>
                            @if(!empty($return->evidence_images))
                                <div class="evidence-gallery">
                                    @foreach($return->evidence_images as $path)
                                        <a href="/{{ $path }}" target="_blank">
                                            <img src="/{{ $path }}" class="evidence-thumb" alt="Evidence">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div style="font-size: 0.76rem; color: var(--color-admin-text-muted); margin-top: 4px; font-style: italic;">No evidence uploaded</div>
                            @endif
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
                            <div class="action-row">
                                @if($return->status === 'Requested')
                                    <form action="{{ route('admin.returns.approve', $return->id) }}" method="POST"
                                          onsubmit="return confirm('Approve this return request?')">
                                        @csrf
                                        <button type="submit" class="btn-approve">✓ Approve</button>
                                    </form>
                                    <form action="{{ route('admin.returns.reject', $return->id) }}" method="POST"
                                          onsubmit="return confirm('Reject this return request?')">
                                        @csrf
                                        <button type="submit" class="btn-reject">✕ Reject</button>
                                    </form>

                                @elseif($return->status === 'Approved' && $return->refund && $return->refund->status === 'Pending')
                                    <div class="refund-box">
                                        <div class="refund-box-title">Record Refund Settlement</div>
                                        <form action="{{ route('admin.returns.refund', $return->id) }}" method="POST">
                                            @csrf
                                            <input type="text" name="transaction_reference" class="refund-input"
                                                placeholder="Bank txn ref or UPI ID" required>
                                            <button type="submit" class="btn-refund">✓ Mark as Refunded</button>
                                        </form>
                                    </div>

                                @else
                                    <span style="font-size: 0.8rem; color: var(--color-admin-text-muted); font-style: italic;">No action needed</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">🔄</div>
                                <h3>No Return Requests</h3>
                                <p>Customer return requests will appear here when submitted.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
