@extends('layouts.admin')

@section('title', 'Review Moderation — Al Barr Admin')
@section('header_title', 'Review Moderation')

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

    /* ─── Stats ─── */
    .review-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: var(--spacing-xl);
    }

    .review-stat {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 16px 20px;
        box-shadow: var(--shadow-admin-sm);
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .review-stat:hover {
        box-shadow: var(--shadow-admin-md);
        transform: translateY(-2px);
    }

    .rvs-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--color-admin-text-muted);
        margin-bottom: 4px;
    }

    .rvs-value {
        font-family: var(--font-secondary);
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
    }

    /* ─── Filter Row ─── */
    .review-filter-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--color-admin-border);
    }

    .admin-input {
        font-family: var(--font-sans);
        padding: 10px 14px;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-input);
        font-size: 0.9rem;
        background: #fff;
        color: var(--color-admin-text-main);
        box-sizing: border-box;
        transition: all 0.2s;
    }

    .admin-input:focus {
        border-color: var(--color-admin-accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(1,136,73,0.12);
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
        color: var(--color-admin-text-muted);
        max-width: 280px;
        line-height: 1.45;
        white-space: pre-wrap;
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
    $total     = $reviews->count();
    $pending   = $reviews->where('status', 'Pending')->count();
    $approved  = $reviews->where('status', 'Approved')->count();
    $rejected  = $reviews->where('status', 'Rejected')->count();
    $avgRating = $reviews->where('status', 'Approved')->avg('rating');
@endphp

{{-- Page Hero --}}
<div class="page-hero">
    <div>
        <h2>Review Moderation</h2>
        <p>{{ $total }} reviews submitted · Approve or reject before they appear on the storefront</p>
    </div>
</div>

{{-- Stats --}}
<div class="review-stats">
    <div class="review-stat">
        <div class="rvs-label">Total Reviews</div>
        <div class="rvs-value">{{ $total }}</div>
    </div>
    <div class="review-stat">
        <div class="rvs-label">Pending</div>
        <div class="rvs-value" style="color: #7a5f00;">{{ $pending }}</div>
    </div>
    <div class="review-stat">
        <div class="rvs-label">Approved</div>
        <div class="rvs-value" style="color: var(--color-admin-accent);">{{ $approved }}</div>
    </div>
    <div class="review-stat">
        <div class="rvs-label">Rejected</div>
        <div class="rvs-value" style="color: #842029;">{{ $rejected }}</div>
    </div>
    <div class="review-stat">
        <div class="rvs-label">Avg. Rating</div>
        <div class="rvs-value" style="color: #FFB300;">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
    </div>
</div>

{{-- Table Card --}}
<div class="admin-card" style="padding: 0;">

    {{-- Filter --}}
    <div class="review-filter-bar">
        <input type="text" id="reviewSearch" class="admin-input" placeholder="🔍 Search by product or customer…" style="flex: 1; max-width: 320px;">
        <select id="statusFilter" class="admin-input" style="max-width: 180px;">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <select id="ratingFilter" class="admin-input" style="max-width: 160px;">
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
                    <th style="padding-left: 24px;">#</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align: right; padding-right: 24px;">Actions</th>
                </tr>
            </thead>
            <tbody id="reviewTableBody">
                @forelse($reviews as $review)
                    <tr class="review-row"
                        data-product="{{ strtolower($review->product->title ?? '') }}"
                        data-customer="{{ strtolower($review->user->name ?? '') }}"
                        data-status="{{ strtolower($review->status) }}"
                        data-rating="{{ $review->rating }}">

                        <td style="padding-left: 24px;">
                            <span style="font-weight: 700; color: var(--color-admin-text-muted); font-size: 0.84rem;">#RV-{{ $review->id }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--color-admin-text-main);">{{ $review->product->title ?? 'Deleted Product' }}</div>
                            @if($review->product?->origin)
                                <div style="font-size: 0.74rem; color: var(--color-admin-text-muted);">{{ $review->product->origin }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $review->user->name ?? 'Guest User' }}</div>
                            <div style="font-size: 0.74rem; color: var(--color-admin-text-muted);">{{ $review->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">★</span>
                                @endfor
                            </div>
                            <div style="font-size: 0.78rem; font-weight: 700; color: var(--color-admin-text-muted); margin-top: 2px;">{{ $review->rating }}/5</div>
                        </td>
                        <td>
                            <div class="review-comment">
                                {{ $review->comment ?: 'No written feedback provided.' }}
                            </div>
                        </td>
                        <td>
                            <span class="review-badge {{ strtolower($review->status) }}">{{ $review->status }}</span>
                        </td>
                        <td style="font-size: 0.82rem; color: var(--color-admin-text-muted);">
                            {{ $review->created_at->format('d M Y') }}
                        </td>
                        <td style="padding-right: 24px;">
                            <div class="action-row">
                                @if($review->status === 'Pending')
                                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-approve">✓ Approve</button>
                                    </form>
                                    <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-reject">✕ Reject</button>
                                    </form>
                                @else
                                    <span style="font-size: 0.8rem; color: var(--color-admin-text-muted); font-style: italic;">No action needed</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">⭐</div>
                                <h3>No Reviews Yet</h3>
                                <p>Customer product reviews will appear here for moderation.</p>
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
</script>
@endsection
