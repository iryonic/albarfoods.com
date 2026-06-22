@extends('layouts.admin')

@section('title', 'Review Moderation — Al Barr Admin')
@section('header_title', 'Review Moderation')

@section('styles')
<style>
    /* ─── Stars ─── */
    .star-rating {
        display: flex;
        align-items: center;
        gap: 2px;
        font-size: 1.05rem;
    }

    .star-filled { color: #FFB300; }
    .star-empty  { color: #ddd; }

    /* ─── Comment Box ─── */
    .review-comment {
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--color-admin-text-main);
        max-width: 320px;
        line-height: 1.45;
        white-space: pre-wrap;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ─── Status Badges ─── */
    .review-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.73rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .review-badge.pending  { background: #fff3cd; color: #7a5f00; }
    .review-badge.approved { background: #d1e7dd; color: #0a5c36; }
    .review-badge.rejected { background: #f8d7da; color: #842029; }

    /* ─── Action Buttons ─── */
    .action-row {
        display: flex;
        gap: 6px;
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

    .btn-delete-sm {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 7px 10px;
        background: transparent;
        color: #ba3c1c;
        border: 1px solid rgba(186, 60, 28, 0.25);
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
    }

    .btn-delete-sm:hover {
        background: #fbeae5;
        border-color: #ba3c1c;
        transform: translateY(-1px);
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

    .empty-state h3   { font-family: var(--font-secondary); font-size: 1.15rem; font-weight: 700; color: var(--color-admin-text-main); margin: 0 0 6px; }
    .empty-state p    { font-size: 0.87rem; margin: 0; }

    /* ─── Layout ─── */
    .reviews-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .reviews-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ─── Drawer ─── */
    .review-drawer-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.3);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 200;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .review-drawer-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    .review-drawer-card {
        position: fixed;
        top: 0; right: 0; bottom: 0;
        width: 460px;
        max-width: 95%;
        background: #fff;
        box-shadow: var(--shadow-admin-lg);
        z-index: 201;
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }

    .review-drawer-overlay.active .review-drawer-card {
        transform: translateX(0);
    }

    .review-drawer-header {
        background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);
        color: #fff;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }

    .review-drawer-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }

    .review-detail-section {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--color-admin-border);
    }

    .review-detail-section:last-child {
        border-bottom: none;
    }

    .review-detail-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-admin-text-muted);
        margin-bottom: 8px;
    }

    .review-full-comment {
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        padding: 16px;
        border-radius: 10px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: var(--color-admin-text-main);
        white-space: pre-wrap;
    }

    /* ─── Bulk Action Floating Bar ─── */
    .review-bulk-bar {
        display: none;
        position: fixed;
        bottom: 24px;
        left: calc(var(--admin-sidebar-width, 260px) + 24px);
        right: 24px;
        background: rgba(10, 15, 30, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 14px;
        padding: 14px 24px;
        z-index: 150;
        align-items: center;
        gap: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        border: 1px solid rgba(197, 168, 128, 0.2);
        animation: bulkBarSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        flex-wrap: wrap;
    }

    @keyframes bulkBarSlideUp {
        from { transform: translateY(20px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }

    .review-bulk-bar .bar-count {
        font-weight: 700;
        color: #fff;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .review-bulk-bar .bar-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .review-bulk-bar .bar-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: var(--font-sans);
    }

    .review-bulk-bar .bar-btn.approve { background: var(--color-admin-accent); color: #fff; }
    .review-bulk-bar .bar-btn.approve:hover { background: var(--color-admin-accent-hover); }
    .review-bulk-bar .bar-btn.reject  { background: #ba3c1c; color: #fff; }
    .review-bulk-bar .bar-btn.reject:hover  { background: #9a2d14; }
    .review-bulk-bar .bar-btn.delete  { background: transparent; color: #ff6b6b; border: 1px solid rgba(255, 107, 107, 0.3); }
    .review-bulk-bar .bar-btn.delete:hover  { background: rgba(255, 107, 107, 0.1); }
    .review-bulk-bar .bar-btn.cancel  { background: transparent; color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.15); }
    .review-bulk-bar .bar-btn.cancel:hover  { color: #fff; border-color: rgba(255,255,255,0.3); }

    @media (max-width: 768px) {
        .review-bulk-bar {
            left: 16px;
            right: 16px;
            flex-direction: column;
            align-items: stretch;
        }
        .review-bulk-bar .bar-actions {
            margin-left: 0;
        }
    }
</style>
@endsection

@section('content')
@php
    $total     = $reviews->count();
    $pending   = $reviews->where('status', 'Pending')->count();
    $approved  = $reviews->where('status', 'Approved')->count();
    $rejected  = $reviews->where('status', 'Rejected')->count();
    $avgRating = $reviews->where('status', 'Approved')->avg('rating');

    // Star Distribution Calculation
    $starsCount = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach($reviews as $rev) {
        if(isset($starsCount[$rev->rating])) {
            $starsCount[$rev->rating]++;
        }
    }
@endphp

{{-- Page Hero --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h2 style="font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 800; margin: 0;">Review Moderation</h2>
        <p style="font-size: 0.84rem; color: var(--color-admin-text-muted); margin: 4px 0 0;">{{ $total }} reviews submitted · Approve or reject before they appear on the storefront</p>
    </div>
</div>

{{-- Stats --}}
<div class="stats-4-grid" style="grid-template-columns: repeat(5, 1fr); margin-bottom: 24px;">
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $total }}</div>
            <div class="stat-kpi-label">Total Reviews</div>
        </div>
    </div>
    <div class="stat-kpi-card amber">
        <div class="stat-kpi-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $pending }}</div>
            <div class="stat-kpi-label">Pending</div>
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
    <div class="stat-kpi-card red">
        <div class="stat-kpi-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $rejected }}</div>
            <div class="stat-kpi-label">Rejected</div>
        </div>
    </div>
    <div class="stat-kpi-card gold">
        <div class="stat-kpi-icon gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="color: #FFB300;">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
            <div class="stat-kpi-label">Avg Rating</div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 1200px) {
        .stats-4-grid { grid-template-columns: repeat(3, 1fr) !important; }
    }
    @media (max-width: 768px) {
        .stats-4-grid { grid-template-columns: repeat(2, 1fr) !important; }
    }
    @media (max-width: 480px) {
        .stats-4-grid { grid-template-columns: 1fr !important; }
    }
</style>

{{-- Main Content Section --}}
<div class="reviews-layout">
    
    {{-- Star Rating Distribution Side Panel --}}
    <div class="admin-card" style="position: sticky; top: 90px; padding: 20px;">
        <h3 style="font-family: var(--font-secondary); font-size: 1.05rem; font-weight: 800; margin: 0 0 16px;">Rating Breakdown</h3>
        <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 20px;">
            <span style="font-size: 2.4rem; font-weight: 900; font-family: var(--font-secondary); color: var(--color-admin-text-main); line-height: 1;">{{ $avgRating ? number_format($avgRating, 1) : '0.0' }}</span>
            <div style="display: flex; flex-direction: column;">
                <div class="star-rating" style="font-size: 0.88rem;">
                    @php $rounded = round($avgRating); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $rounded ? 'star-filled' : 'star-empty' }}">★</span>
                    @endfor
                </div>
                <span style="font-size: 0.69rem; color: var(--color-admin-text-muted); font-weight: 600; margin-top: 2px;">Out of 5 stars</span>
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @for($rating = 5; $rating >= 1; $rating--)
                @php
                    $count = $starsCount[$rating];
                    $percent = $total > 0 ? ($count / $total) * 100 : 0;
                @endphp
                <div style="display: flex; align-items: center; gap: 10px; font-size: 0.78rem;">
                    <span style="width: 10px; font-weight: 800; color: var(--color-admin-text-main);">{{ $rating }}</span>
                    <span style="color: #FFB300; font-size: 0.82rem;">★</span>
                    <div style="flex: 1; height: 8px; background: var(--color-admin-border-light); border-radius: 4px; overflow: hidden; border: 1px solid var(--color-admin-border-light);">
                        <div style="width: {{ $percent }}%; height: 100%; background: #FFB300; border-radius: 4px; transition: width 0.5s ease;"></div>
                    </div>
                    <span style="width: 28px; text-align: right; color: var(--color-admin-text-muted); font-weight: 700; font-family: var(--font-mono);">{{ $count }}</span>
                </div>
            @endfor
        </div>

        {{-- Quick Stats --}}
        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--color-admin-border);">
            <h4 style="font-family: var(--font-secondary); font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: var(--color-admin-text-muted); letter-spacing: 0.4px; margin: 0 0 12px;">Quick Stats</h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.82rem;">
                    <span style="color: var(--color-admin-text-muted);">Approval Rate</span>
                    <span style="font-weight: 700; color: var(--color-admin-accent);">{{ $total > 0 ? round(($approved / $total) * 100) : 0 }}%</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.82rem;">
                    <span style="color: var(--color-admin-text-muted);">Rejection Rate</span>
                    <span style="font-weight: 700; color: #ba3c1c;">{{ $total > 0 ? round(($rejected / $total) * 100) : 0 }}%</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.82rem;">
                    <span style="color: var(--color-admin-text-muted);">5★ Reviews</span>
                    <span style="font-weight: 700; color: #FFB300;">{{ $starsCount[5] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Panel --}}
    <div class="admin-card" style="padding: 0;">
        {{-- Filter --}}
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; padding: 20px 24px; border-bottom: 1px solid var(--color-admin-border);">
            <input type="text" id="reviewSearch" class="admin-input" placeholder="Search product or customer…" style="flex: 1; min-width: 180px; max-width: 320px;">
            <select id="statusFilter" class="admin-input" style="max-width: 160px; min-width: 130px;">
                <option value="all">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <select id="ratingFilter" class="admin-input" style="max-width: 150px; min-width: 120px;">
                <option value="all">All Ratings</option>
                <option value="5">★★★★★ (5)</option>
                <option value="4">★★★★ (4)</option>
                <option value="3">★★★ (3)</option>
                <option value="2">★★ (2)</option>
                <option value="1">★ (1)</option>
            </select>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="padding-left: 24px; width: 40px;">
                            <input type="checkbox" id="selectAllReviews" onchange="toggleAllReviews(this)" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--color-admin-accent);">
                        </th>
                        <th style="width: 80px;">ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th style="width: 120px;">Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="text-align: right; padding-right: 24px; min-width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="reviewTableBody">
                    @forelse($reviews as $review)
                        <tr class="review-row"
                            data-product="{{ strtolower($review->product->title ?? '') }}"
                            data-customer="{{ strtolower($review->user->name ?? '') }}"
                            data-status="{{ strtolower($review->status) }}"
                            data-rating="{{ $review->rating }}"
                            data-id="{{ $review->id }}"
                            data-product-title="{{ $review->product->title ?? 'Deleted Product' }}"
                            data-product-origin="{{ $review->product->origin ?? '' }}"
                            data-customer-name="{{ $review->user->name ?? 'Guest User' }}"
                            data-customer-email="{{ $review->user->email ?? '' }}"
                            data-comment="{{ $review->comment ?? 'No written feedback provided.' }}"
                            data-date="{{ $review->created_at->format('d M Y, h:i A') }}"
                            style="cursor: pointer;"
                            onclick="openReviewDrawer(this)">

                            <td style="padding-left: 24px;" onclick="event.stopPropagation();">
                                <input type="checkbox" class="review-checkbox" data-id="{{ $review->id }}" onchange="updateReviewSelection()" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--color-admin-accent);">
                            </td>
                            <td>
                                <span style="font-weight: 700; color: var(--color-admin-text-muted); font-size: 0.82rem; font-family: var(--font-mono);">#RV-{{ $review->id }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--color-admin-text-main);">{{ $review->product->title ?? 'Deleted Product' }}</div>
                                @if($review->product?->origin)
                                    <div style="font-size: 0.74rem; color: var(--color-admin-text-muted);">{{ $review->product->origin }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @php
                                        $initials = '';
                                        if ($review->user?->name) {
                                            $words = explode(' ', $review->user->name);
                                            $initials = strtoupper(substr($words[0], 0, 1));
                                            if (count($words) > 1) {
                                                $initials .= strtoupper(substr($words[1], 0, 1));
                                            }
                                        } else {
                                            $initials = 'G';
                                        }
                                    @endphp
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, rgba(197, 168, 128, 0.15) 0%, rgba(197, 168, 128, 0.05) 100%); color: var(--color-admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; font-family: var(--font-secondary); flex-shrink: 0; border: 1px solid rgba(197, 168, 128, 0.25);">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--color-admin-text-main);">{{ $review->user->name ?? 'Guest User' }}</div>
                                        <div style="font-size: 0.74rem; color: var(--color-admin-text-muted);">{{ $review->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">★</span>
                                    @endfor
                                </div>
                                <div style="font-size: 0.74rem; font-weight: 700; color: var(--color-admin-text-muted); margin-top: 2px; font-family: var(--font-mono);">{{ $review->rating }}/5</div>
                            </td>
                            <td>
                                <div class="review-comment">
                                    {{ $review->comment ?: 'No written feedback provided.' }}
                                </div>
                            </td>
                            <td>
                                <span class="review-badge {{ strtolower($review->status) }}">{{ $review->status }}</span>
                            </td>
                            <td style="font-size: 0.82rem; color: var(--color-admin-text-muted); white-space: nowrap;">
                                {{ $review->created_at->format('d M Y') }}
                            </td>
                            <td style="padding-right: 24px; text-align: right;" onclick="event.stopPropagation();">
                                <div class="action-row" style="display:flex; gap:6px; justify-content:flex-end;">
                                    @if($review->status === 'Pending')
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-approve">✓ Approve</button>
                                        </form>
                                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-reject">✕ Reject</button>
                                        </form>
                                    @elseif($review->status === 'Approved')
                                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-reject">✕ Reject</button>
                                        </form>
                                    @elseif($review->status === 'Rejected')
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-approve">✓ Approve</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Permanently delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-sm" title="Delete Review">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3; margin-bottom: 16px;">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    <h3>No Reviews Moderated</h3>
                                    <p>Customer reviews will appear here when submitted.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Bulk Action Floating Bar --}}
<div class="review-bulk-bar" id="reviewBulkBar">
    <span class="bar-count" id="reviewBulkCount">0 reviews selected</span>
    <div class="bar-actions">
        <form id="bulkApproveForm" action="{{ route('admin.reviews.bulk-action') }}" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="action" value="approve">
            <input type="hidden" name="review_ids" id="bulkApproveIds">
            <button type="submit" class="bar-btn approve">✓ Approve All</button>
        </form>
        <form id="bulkRejectForm" action="{{ route('admin.reviews.bulk-action') }}" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="action" value="reject">
            <input type="hidden" name="review_ids" id="bulkRejectIds">
            <button type="submit" class="bar-btn reject">✕ Reject All</button>
        </form>
        <form id="bulkDeleteForm" action="{{ route('admin.reviews.bulk-action') }}" method="POST" style="margin:0;" onsubmit="return confirm('Permanently delete selected reviews?');">
            @csrf
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="review_ids" id="bulkDeleteIds">
            <button type="submit" class="bar-btn delete" style="display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Delete</button>
        </form>
        <button class="bar-btn cancel" onclick="clearReviewSelection()">Cancel</button>
    </div>
</div>

{{-- Review Detail Drawer --}}
<div class="review-drawer-overlay" id="reviewDrawerOverlay" onclick="closeReviewDrawer()">
    <div class="review-drawer-card" onclick="event.stopPropagation();">
        <div class="review-drawer-header">
            <div>
                <h3 style="font-family: var(--font-secondary); font-size: 1.1rem; font-weight: 800; margin: 0;" id="drawerReviewId">Review Details</h3>
                <div style="font-size: 0.78rem; opacity: 0.7; margin-top: 3px;" id="drawerReviewDate"></div>
            </div>
            <button style="background: none; border: none; color: #fff; font-size: 1.6rem; cursor: pointer; padding: 0 4px;" onclick="closeReviewDrawer()">&times;</button>
        </div>
        <div class="review-drawer-body">
            {{-- Product Info --}}
            <div class="review-detail-section">
                <div class="review-detail-label">Product</div>
                <div style="font-weight: 700; font-size: 1rem; color: var(--color-admin-text-main);" id="drawerProductTitle"></div>
                <div style="font-size: 0.82rem; color: var(--color-admin-text-muted); margin-top: 2px;" id="drawerProductOrigin"></div>
            </div>

            {{-- Customer Info --}}
            <div class="review-detail-section">
                <div class="review-detail-label">Customer</div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, rgba(197, 168, 128, 0.15) 0%, rgba(197, 168, 128, 0.05) 100%); color: var(--color-admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; font-family: var(--font-secondary); flex-shrink: 0; border: 1px solid rgba(197, 168, 128, 0.25);" id="drawerCustomerAvatar"></div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem;" id="drawerCustomerName"></div>
                        <div style="font-size: 0.8rem; color: var(--color-admin-text-muted);" id="drawerCustomerEmail"></div>
                    </div>
                </div>
            </div>

            {{-- Rating --}}
            <div class="review-detail-section">
                <div class="review-detail-label">Rating</div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="star-rating" style="font-size: 1.4rem;" id="drawerStars"></div>
                    <span style="font-family: var(--font-mono); font-weight: 800; font-size: 1.1rem; color: var(--color-admin-text-main);" id="drawerRatingText"></span>
                </div>
            </div>

            {{-- Status --}}
            <div class="review-detail-section">
                <div class="review-detail-label">Status</div>
                <span id="drawerStatus" class="review-badge"></span>
            </div>

            {{-- Full Comment --}}
            <div class="review-detail-section">
                <div class="review-detail-label">Full Review</div>
                <div class="review-full-comment" id="drawerComment"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const reviewSearch = document.getElementById('reviewSearch');
    const statusFilter = document.getElementById('statusFilter');
    const ratingFilter = document.getElementById('ratingFilter');

    function filterReviews() {
        const query  = reviewSearch.value.toLowerCase().trim();
        const status = statusFilter.value;
        const rating = ratingFilter.value;

        document.querySelectorAll('.review-row').forEach(row => {
            const matchSearch = !query || row.dataset.product.includes(query) || row.dataset.customer.includes(query);
            const matchStatus = status === 'all' || row.dataset.status === status;
            const matchRating = rating === 'all' || row.dataset.rating === rating;

            row.style.display = (matchSearch && matchStatus && matchRating) ? 'table-row' : 'none';
        });
    }

    reviewSearch.addEventListener('input', filterReviews);
    statusFilter.addEventListener('change', filterReviews);
    ratingFilter.addEventListener('change', filterReviews);

    /* ── Checkbox / Bulk Actions ── */
    function toggleAllReviews(master) {
        document.querySelectorAll('.review-checkbox').forEach(cb => {
            cb.checked = master.checked;
        });
        updateReviewSelection();
    }

    function updateReviewSelection() {
        const checked = document.querySelectorAll('.review-checkbox:checked');
        const total = document.querySelectorAll('.review-checkbox');
        const master = document.getElementById('selectAllReviews');
        const bar = document.getElementById('reviewBulkBar');

        if (master) {
            master.checked = checked.length === total.length && total.length > 0;
            master.indeterminate = checked.length > 0 && checked.length < total.length;
        }

        const ids = Array.from(checked).map(cb => cb.dataset.id);
        const idsStr = JSON.stringify(ids);

        document.getElementById('bulkApproveIds').value = idsStr;
        document.getElementById('bulkRejectIds').value = idsStr;
        document.getElementById('bulkDeleteIds').value = idsStr;
        document.getElementById('reviewBulkCount').textContent = `${ids.length} review${ids.length !== 1 ? 's' : ''} selected`;

        bar.style.display = ids.length > 0 ? 'flex' : 'none';
    }

    function clearReviewSelection() {
        document.querySelectorAll('.review-checkbox').forEach(cb => cb.checked = false);
        const master = document.getElementById('selectAllReviews');
        if (master) { master.checked = false; master.indeterminate = false; }
        updateReviewSelection();
    }

    /* ── Review Detail Drawer ── */
    function openReviewDrawer(row) {
        const d = row.dataset;
        document.getElementById('drawerReviewId').textContent = `Review #RV-${d.id}`;
        document.getElementById('drawerReviewDate').textContent = d.date;
        document.getElementById('drawerProductTitle').textContent = d.productTitle;
        document.getElementById('drawerProductOrigin').textContent = d.productOrigin;

        const name = d.customerName;
        const initials = name.split(' ').map(w => w.charAt(0).toUpperCase()).join('').substring(0, 2) || 'G';
        document.getElementById('drawerCustomerAvatar').textContent = initials;
        document.getElementById('drawerCustomerName').textContent = name;
        document.getElementById('drawerCustomerEmail').textContent = d.customerEmail;

        const rating = parseInt(d.rating);
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += `<span class="${i <= rating ? 'star-filled' : 'star-empty'}">★</span>`;
        }
        document.getElementById('drawerStars').innerHTML = starsHtml;
        document.getElementById('drawerRatingText').textContent = `${rating}/5`;

        const status = d.status;
        const statusEl = document.getElementById('drawerStatus');
        statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusEl.className = `review-badge ${status}`;

        document.getElementById('drawerComment').textContent = d.comment;

        document.getElementById('reviewDrawerOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewDrawer() {
        document.getElementById('reviewDrawerOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    // ESC key to close drawer
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeReviewDrawer();
    });
</script>
@endsection
