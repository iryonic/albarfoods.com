@extends('layouts.admin')

@section('title', 'Inventory Management - Al Barr')
@section('header_title', 'Inventory Management')

@section('styles')
<style>
    .inv-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media(max-width: 900px) { .inv-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width: 540px) { .inv-stats-grid { grid-template-columns: 1fr; } }

    .inv-stat-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-admin-sm);
        transition: box-shadow 0.2s;
    }

    .inv-stat-card:hover { box-shadow: var(--shadow-admin-md); }

    .inv-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .inv-stat-icon svg { width: 22px; height: 22px; }

    .inv-stat-icon.green { background: #e3fbeb; color: #018849; }
    .inv-stat-icon.blue  { background: #e4f0ff; color: #1a56d6; }
    .inv-stat-icon.amber { background: #fff8e1; color: #b56f00; }
    .inv-stat-icon.red   { background: #fbeae5; color: #ba3c1c; }

    .inv-stat-val {
        font-family: var(--font-secondary);
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        line-height: 1;
    }

    .inv-stat-label {
        font-size: 0.78rem;
        color: var(--color-admin-text-muted);
        font-weight: 600;
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    /* Table */
    .inv-table-wrap { overflow-x: auto; }

    .inv-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 780px;
    }

    .inv-table thead th {
        background: #fafbfc;
        padding: 12px 16px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--color-admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--color-admin-border);
    }

    .inv-table tbody tr {
        border-bottom: 1px solid var(--color-admin-border-light);
        transition: background 0.15s;
    }

    .inv-table tbody tr:hover { background: #fafbfc; }
    .inv-table tbody tr:last-child { border-bottom: none; }

    .inv-table tbody td {
        padding: 14px 16px;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 700;
    }

    .stock-badge.in-stock   { background: #e3fbeb; color: #008060; }
    .stock-badge.low-stock  { background: #fff8e1; color: #b56f00; }
    .stock-badge.out        { background: #fbeae5; color: #ba3c1c; }

    .stock-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
    }

    /* Search bar */
    .inv-search-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        align-items: center;
    }

    .inv-search-row .admin-input { max-width: 320px; }

    /* Adjust Stock Modal */
    .adj-info-box {
        background: var(--color-admin-border-light);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    /* Logs section */
    .log-row {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid var(--color-admin-border-light);
    }

    .log-row:last-child { border-bottom: none; }

    .log-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .log-icon.in  { background: #e3fbeb; color: #018849; }
    .log-icon.out { background: #fbeae5; color: #ba3c1c; }
    .log-icon.adj { background: #e4f0ff; color: #1a56d6; }

    .log-icon svg { width: 16px; height: 16px; }

    .log-body { flex: 1; min-width: 0; }
    .log-title { font-size: 0.875rem; font-weight: 600; color: var(--color-admin-text-main); }
    .log-meta  { font-size: 0.75rem; color: var(--color-admin-text-muted); margin-top: 2px; }

    .log-qty {
        font-family: var(--font-mono);
        font-size: 0.88rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .log-qty.pos { color: #018849; }
    .log-qty.neg { color: #ba3c1c; }
</style>
@endsection

@section('content')

{{-- ─── Stats Row ─── --}}
<div class="inv-stats-grid">
    <div class="inv-stat-card">
        <div class="inv-stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
            </svg>
        </div>
        <div>
            <div class="inv-stat-val">{{ $totalSkus }}</div>
            <div class="inv-stat-label">Total SKUs</div>
        </div>
    </div>
    <div class="inv-stat-card">
        <div class="inv-stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6"/>
            </svg>
        </div>
        <div>
            <div class="inv-stat-val">{{ number_format($totalStock) }}</div>
            <div class="inv-stat-label">Units In Stock</div>
        </div>
    </div>
    <div class="inv-stat-card">
        <div class="inv-stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div>
            <div class="inv-stat-val">{{ $lowStockCount }}</div>
            <div class="inv-stat-label">Low Stock SKUs</div>
        </div>
    </div>
    <div class="inv-stat-card">
        <div class="inv-stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
            </svg>
        </div>
        <div>
            <div class="inv-stat-val">{{ $outOfStockCount }}</div>
            <div class="inv-stat-label">Out of Stock</div>
        </div>
    </div>
</div>

{{-- ─── Inventory Table ─── --}}
<div class="admin-card">
    <div class="admin-card-title">
        <span>All SKUs &amp; Stock Levels</span>
        <a href="{{ route('admin.products') }}" class="btn-action-outline" style="font-size:0.8rem;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            Manage Products
        </a>
    </div>

    <div class="inv-search-row">
        <input type="text" id="invSearch" class="admin-input" placeholder="Search by product name or SKU…" style="flex:1; max-width:360px;">
        <select id="stockFilter" class="admin-select" style="width:180px;">
            <option value="all">All Stock Levels</option>
            <option value="in">In Stock (&gt;10)</option>
            <option value="low">Low Stock (1–10)</option>
            <option value="out">Out of Stock</option>
        </select>
    </div>

    <div class="inv-table-wrap">
        <table class="inv-table" id="invTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Weight</th>
                    <th>Sale Price</th>
                    <th>Stock Qty</th>
                    <th>Status</th>
                    <th style="text-align:right; padding-right:20px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($variants as $variant)
                @php
                    $stockLevel = $variant->stock > 10 ? 'in' : ($variant->stock > 0 ? 'low' : 'out');
                @endphp
                <tr data-sku="{{ strtolower($variant->sku) }}"
                    data-name="{{ strtolower($variant->product->title ?? '') }}"
                    data-stock="{{ $stockLevel }}">
                    <td>
                        <div style="font-weight:700; color:var(--color-admin-text-main);">{{ $variant->product->title ?? '—' }}</div>
                        <div style="font-size:0.72rem; color:var(--color-admin-text-muted);">{{ $variant->product->category->name ?? 'Uncategorized' }}</div>
                    </td>
                    <td><code style="font-family:var(--font-mono); font-size:0.82rem; color:var(--color-admin-accent); background:rgba(1,136,73,0.06); padding:2px 7px; border-radius:4px;">{{ $variant->sku }}</code></td>
                    <td style="font-weight:600;">{{ $variant->weight }}</td>
                    <td style="font-weight:700;">₹{{ number_format($variant->price, 2) }}</td>
                    <td>
                        <span style="font-family:var(--font-mono); font-size:1.1rem; font-weight:800; color:{{ $variant->stock <= 0 ? '#ba3c1c' : ($variant->stock <= 10 ? '#b56f00' : 'var(--color-admin-text-main)') }};">
                            {{ $variant->stock }}
                        </span>
                    </td>
                    <td>
                        @if($variant->stock > 10)
                            <span class="stock-badge in-stock">In Stock</span>
                        @elseif($variant->stock > 0)
                            <span class="stock-badge low-stock">Low Stock</span>
                        @else
                            <span class="stock-badge out">Out of Stock</span>
                        @endif
                    </td>
                    <td style="text-align:right; padding-right:20px;">
                        <button class="btn-solid-accent" style="padding:6px 14px; font-size:0.78rem;"
                            onclick="openAdjModal({{ $variant->id }}, '{{ addslashes($variant->product->title ?? '') }}', '{{ $variant->weight }}', {{ $variant->stock }})">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Adjust
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:var(--color-admin-text-muted);">
                        No SKUs found. Add products first.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── Inventory Activity Log ─── --}}
<div class="admin-card">
    <div class="admin-card-title">
        <span>Recent Inventory Activity</span>
        <span style="font-size:0.78rem; color:var(--color-admin-text-muted); font-weight:500;">Last 50 transactions</span>
    </div>

    @forelse($recentLogs as $log)
    @php
        $isIn  = $log->quantity_change > 0;
        $isAdj = $log->type === 'Adjustment';
        $iconClass = $isAdj ? 'adj' : ($isIn ? 'in' : 'out');
    @endphp
    <div class="log-row">
        <div class="log-icon {{ $iconClass }}">
            @if($isAdj)
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            @elseif($isIn)
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
            @endif
        </div>
        <div class="log-body">
            <div class="log-title">
                <strong>{{ $log->type }}</strong> — {{ $log->variant->product->title ?? 'Deleted Product' }} ({{ $log->variant->weight ?? 'N/A' }})
            </div>
            <div class="log-meta">
                SKU: {{ $log->variant->sku ?? '—' }} &bull; {{ $log->log_message }}
                &bull; {{ $log->created_at ? $log->created_at->format('d M Y, h:i A') : '—' }}
            </div>
        </div>
        <div class="log-qty {{ $log->quantity_change > 0 ? 'pos' : 'neg' }}">
            {{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }}
        </div>
    </div>
    @empty
    <div style="text-align:center; padding:40px; color:var(--color-admin-text-muted); font-size:0.88rem;">
        No inventory activity recorded yet.
    </div>
    @endforelse
</div>

{{-- ─── Stock Adjustment Modal ─── --}}
<div class="admin-modal-overlay" id="adjModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Adjust Stock</h3>
            <button class="admin-modal-close" onclick="closeModal('adjModal')">&times;</button>
        </div>
        <form action="{{ route('admin.products.stock') }}" method="POST">
            @csrf
            <input type="hidden" name="variant_id" id="adjVariantId">
            <div class="admin-modal-body">
                <div class="adj-info-box">
                    <div style="font-weight:700; font-size:0.92rem;" id="adjProductTitle">—</div>
                    <div style="font-size:0.78rem; color:var(--color-admin-text-muted); margin-top:4px;">
                        Variant: <strong id="adjWeight">—</strong> &bull;
                        Current Stock: <strong id="adjCurrent">0</strong> units
                    </div>
                </div>

                <div class="admin-form-group">
                    <label for="adjType">Adjustment Type *</label>
                    <select name="type" id="adjType" class="admin-select" required>
                        <option value="Stock In">Stock In — Add inventory</option>
                        <option value="Stock Out">Stock Out — Deduct inventory</option>
                        <option value="Adjustment">Manual Adjustment / Correction</option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label for="adjQty">Quantity Change *</label>
                    <input type="number" name="stock_change" id="adjQty" class="admin-input"
                        placeholder="e.g. 50 or -10" required>
                    <span style="font-size:0.72rem; color:var(--color-admin-text-muted);">
                        Use positive values to add stock, negative to deduct.
                    </span>
                </div>

                <button type="submit" class="btn-solid-accent" style="width:100%; padding:12px; justify-content:center; margin-top:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Confirm Stock Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openAdjModal(variantId, productTitle, weight, currentStock) {
        document.getElementById('adjVariantId').value = variantId;
        document.getElementById('adjProductTitle').textContent = productTitle;
        document.getElementById('adjWeight').textContent = weight;
        document.getElementById('adjCurrent').textContent = currentStock;
        document.getElementById('adjQty').value = '';
        document.getElementById('adjType').value = 'Stock In';
        openModal('adjModal');
    }

    // Search + filter
    function filterTable() {
        const q = document.getElementById('invSearch').value.toLowerCase().trim();
        const statusFilter = document.getElementById('stockFilter').value;
        document.querySelectorAll('#invTable tbody tr[data-sku]').forEach(row => {
            const name   = row.dataset.name || '';
            const sku    = row.dataset.sku  || '';
            const stock  = row.dataset.stock || '';
            const matchQ = !q || name.includes(q) || sku.includes(q);
            const matchS = statusFilter === 'all' || stock === statusFilter;
            row.style.display = (matchQ && matchS) ? '' : 'none';
        });
    }

    document.getElementById('invSearch').addEventListener('input', filterTable);
    document.getElementById('stockFilter').addEventListener('change', filterTable);
</script>
@endsection
