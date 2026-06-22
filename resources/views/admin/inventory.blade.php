@extends('layouts.admin')

@section('title', 'Inventory Management - Al Barr')
@section('header_title', 'Inventory Control')

@section('styles')
<style>
    /* stock badges */
    .stock-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700;
    }
    .stock-badge.in-stock  { background: #e3fbeb; color: #008060; }
    .stock-badge.low-stock { background: #fff8e1; color: #b56f00; }
    .stock-badge.out       { background: #fbeae5; color: #ba3c1c; }
    .stock-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

    /* Stock Adjustment Modal info box */
    .adj-info-box { background: var(--color-admin-border-light); border-radius: 8px; padding: 14px 16px; margin-bottom: 16px; }

    /* Logs section */
    .log-row { display: flex; align-items: flex-start; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--color-admin-border-light); }
    .log-row:last-child { border-bottom: none; }
    .log-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .log-icon.in  { background: #e3fbeb; color: #018849; }
    .log-icon.out { background: #fbeae5; color: #ba3c1c; }
    .log-icon.adj { background: #e4f0ff; color: #1a56d6; }
    .log-icon svg { width: 16px; height: 16px; }
    .log-body { flex: 1; min-width: 0; }
    .log-title { font-size: 0.875rem; font-weight: 600; color: var(--color-admin-text-main); }
    .log-meta  { font-size: 0.75rem; color: var(--color-admin-text-muted); margin-top: 2px; }
    .log-qty { font-family: var(--font-mono); font-size: 0.88rem; font-weight: 700; flex-shrink: 0; }
    .log-qty.pos { color: #018849; }
    .log-qty.neg { color: #ba3c1c; }
</style>
@endsection

@section('content')

{{-- ─── Low Stock Alert Banner ─── --}}
@if($lowStockCount > 0 || $outOfStockCount > 0)
    <div style="background: rgba(220, 53, 69, 0.06); border-left: 4px solid #ba3c1c; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 1.5rem; line-height: 1;">⚠️</span>
            <div>
                <h4 style="margin: 0; color: #ba3c1c; font-weight: 800; font-family: var(--font-secondary);">Critical Inventory Alert</h4>
                <p style="margin: 3px 0 0; font-size: 0.82rem; color: var(--color-admin-text-muted);">There are {{ $outOfStockCount }} SKU(s) out of stock and {{ $lowStockCount }} SKU(s) running extremely low. Customers cannot purchase out-of-stock items.</p>
            </div>
        </div>
        <button class="btn btn-solid-accent" style="background: #ba3c1c; border-color: #ba3c1c; box-shadow: none; font-size: 0.8rem; padding: 8px 14px;" onclick="document.getElementById('stockFilter').value = 'out'; filterTable();">
            Show Out-of-Stock
        </button>
    </div>
@endif

{{-- ─── Stats Row ─── --}}
<div class="stats-4-grid">
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $totalSkus }}</div>
            <div class="stat-kpi-label">Total SKUs</div>
        </div>
    </div>
    <div class="stat-kpi-card green">
        <div class="stat-kpi-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ number_format($totalStock) }}</div>
            <div class="stat-kpi-label">Units In Stock</div>
        </div>
    </div>
    <div class="stat-kpi-card amber">
        <div class="stat-kpi-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $lowStockCount }}</div>
            <div class="stat-kpi-label">Low Stock SKUs</div>
        </div>
    </div>
    <div class="stat-kpi-card red">
        <div class="stat-kpi-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $outOfStockCount }}</div>
            <div class="stat-kpi-label">Out of Stock</div>
        </div>
    </div>
</div>

{{-- ─── Stock Distribution Chart ─── --}}
<div class="admin-card">
    <h2 class="admin-card-title"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px; display:inline-block; vertical-align:middle;"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>SKU Stock Level Distribution</h2>
    <div style="position: relative; height: 260px; width: 100%;">
        <canvas id="stockDistributionChart"></canvas>
    </div>
</div>

{{-- ─── Inventory Table ─── --}}
<div class="admin-card" style="padding: 0;">
    <div class="admin-card-title" style="padding: 24px 24px 0; margin: 0;">
        <span>SKU Registry</span>
        <div style="display: flex; gap: 8px;">
            <button class="btn-action-outline" onclick="openModal('bulkImportModal')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Bulk Import
            </button>
            <a href="{{ route('admin.products') }}" class="btn-action-outline">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                Manage Products
            </a>
        </div>
    </div>

    <div class="filter-row" style="padding: 16px 24px 18px;">
        <input type="text" id="invSearch" class="admin-input" placeholder="Search by product name or SKU…" style="flex:1; max-width:340px;">
        <select id="stockFilter" class="admin-select" style="width:180px;">
            <option value="all">All Stock Levels</option>
            <option value="in">In Stock (&gt;10)</option>
            <option value="low">Low Stock (1–10)</option>
            <option value="out">Out of Stock</option>
        </select>
        
        <button class="btn-action-outline" onclick="exportInventoryToCSV()" style="margin-left: auto; height: 42px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </button>
    </div>

    <div class="table-wrap">
        <table class="inv-table" id="invTable">
            <thead>
                <tr>
                    <th style="padding-left: 24px;">Product</th>
                    <th>SKU</th>
                    <th>Weight</th>
                    <th>Sale Price</th>
                    <th>Stock Qty</th>
                    <th>Status</th>
                    <th style="text-align:right; padding-right:24px;">Action</th>
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
                    <td style="padding-left: 24px;">
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
                    <td style="text-align:right; padding-right:24px;">
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

<!-- ==================== MODALS GROUP ==================== -->

<!-- 1. Stock Adjustment Modal -->
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

                <button type="submit" class="btn-solid-accent" style="width:100%; padding:12px; justify-content:center; margin-top:8px; border: none; font-weight: bold;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Confirm Stock Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Bulk Import Modal -->
<div class="admin-modal-overlay" id="bulkImportModal">
    <div class="admin-modal-card" style="max-width: 500px;">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Bulk Import Stock (CSV)</h3>
            <button class="admin-modal-close" onclick="closeModal('bulkImportModal')">&times;</button>
        </div>
        <form action="{{ route('admin.inventory.import-csv') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="admin-modal-body">
                <div style="background: var(--color-admin-border-light); border-radius: 8px; padding: 14px 16px; margin-bottom: 20px; font-size: 0.82rem; color: var(--color-admin-text-muted); line-height: 1.55;">
                    <strong>Required CSV File Structure:</strong>
                    <p style="margin: 6px 0 0; font-family: var(--font-mono); font-size: 0.76rem; background: #fff; padding: 6px 10px; border-radius: 4px; border: 1px solid var(--color-admin-border);">
                        sku,stock_change<br>
                        ALB-WAL-500G,50<br>
                        ALB-WAL-1KG,-10
                    </p>
                    <p style="margin: 8px 0 0;">Positive values add to current stock, negative values subtract.</p>
                </div>
                
                <div class="admin-form-group" style="margin-bottom: 20px;">
                    <label for="csvFileInput">Choose CSV File *</label>
                    <input type="file" name="csv_file" id="csvFileInput" accept=".csv" required class="admin-input">
                </div>
                
                <button type="submit" class="btn-solid-accent" style="width: 100%; padding: 12px; justify-content: center; border: none; font-weight: bold; display: inline-flex; align-items: center;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg> Upload and Process CSV
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Dynamic stock distribution chart
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('stockDistributionChart').getContext('2d');
        const variantsData = {!! json_encode($variants->take(12)->map(function($v) {
            return ['sku' => $v->sku, 'stock' => $v->stock];
        })) !!};

        const labels = variantsData.map(v => v.sku);
        const dataValues = variantsData.map(v => v.stock);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.length > 0 ? labels : ['No SKU'],
                datasets: [{
                    label: 'Stock Quantity',
                    data: dataValues.length > 0 ? dataValues : [0],
                    backgroundColor: dataValues.map(val => val <= 0 ? '#ba3c1c' : (val <= 10 ? '#c5a880' : '#018849')),
                    borderRadius: 6,
                    borderWidth: 0,
                    maxBarThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { family: 'Plus Jakarta Sans', weight: '700', size: 10 } }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: { color: '#64748b', font: { family: 'Plus Jakarta Sans', weight: '700' } }
                    }
                }
            }
        });
    });

    // CSV report downloader
    function exportInventoryToCSV() {
        const rows = document.querySelectorAll('#invTable tbody tr[data-sku]');
        let csv = ['Product Name,Category,SKU,Weight,Sale Price,Stock Quantity,Status'].join(',') + '\n';
        
        let count = 0;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const name = row.querySelector('td:nth-child(1) div:nth-child(1)').innerText.trim();
                const cat = row.querySelector('td:nth-child(1) div:nth-child(2)').innerText.trim();
                const sku = row.querySelector('td:nth-child(2) code').innerText.trim();
                const weight = row.querySelector('td:nth-child(3)').innerText.trim();
                const price = row.querySelector('td:nth-child(4)').innerText.trim().replace('₹', '').replace(/,/g, '');
                const stock = row.querySelector('td:nth-child(5) span').innerText.trim();
                const status = row.querySelector('td:nth-child(6) span').innerText.trim();
                
                csv += `"${name}","${cat}","${sku}","${weight}","${price}","${stock}","${status}"\n`;
                count++;
            }
        });
        
        if (count === 0) {
            showToast("No inventory items available to export.", "error");
            return;
        }

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", `inventory_report_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showToast(`Exported ${count} inventory items successfully!`, "success");
    }
</script>
@endsection
