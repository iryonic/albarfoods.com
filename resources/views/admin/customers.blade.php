@extends('layouts.admin')

@section('title', 'Customer Management - Al Barr')
@section('header_title', 'Customer Management')

@section('styles')
<style>
    .cust-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media(max-width: 900px) { .cust-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width: 540px) { .cust-stats-grid { grid-template-columns: 1fr; } }

    .cust-stat-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-admin-sm);
    }

    .cust-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cust-stat-icon svg { width: 22px; height: 22px; }
    .cust-stat-icon.blue   { background: #e4f0ff; color: #1a56d6; }
    .cust-stat-icon.green  { background: #e3fbeb; color: #018849; }
    .cust-stat-icon.amber  { background: #fff8e1; color: #b56f00; }
    .cust-stat-icon.purple { background: #f3e8ff; color: #7e22ce; }

    .cust-stat-val   { font-family: var(--font-secondary); font-size: 1.85rem; font-weight: 800; color: var(--color-admin-text-main); line-height: 1; }
    .cust-stat-label { font-size: 0.78rem; color: var(--color-admin-text-muted); font-weight: 600; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.4px; }

    /* Table */
    .cust-table-wrap { overflow-x: auto; }

    .cust-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .cust-table thead th {
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

    .cust-table tbody tr {
        border-bottom: 1px solid var(--color-admin-border-light);
        transition: background 0.15s;
    }

    .cust-table tbody tr:hover { background: #fafbfc; }
    .cust-table tbody tr:last-child { border-bottom: none; }

    .cust-table tbody td {
        padding: 14px 16px;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .cust-avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-admin-accent) 0%, #014e28 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        flex-shrink: 0;
        border: 2px solid rgba(1,136,73,0.2);
    }

    .search-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        align-items: center;
    }

    .cust-status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .cust-status-badge.active   { background: #e3fbeb; color: #008060; }
    .cust-status-badge.inactive { background: #fbeae5; color: #ba3c1c; }
    .cust-status-badge.default  { background: #f1f2f4; color: #6d7175; }

    /* Detail modal */
    .cust-detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--color-admin-border-light);
        font-size: 0.875rem;
    }

    .cust-detail-row:last-child { border-bottom: none; }
    .cust-detail-label { color: var(--color-admin-text-muted); font-weight: 600; }
    .cust-detail-val   { font-weight: 700; color: var(--color-admin-text-main); text-align: right; }
</style>
@endsection

@section('content')

{{-- ─── Stats ─── --}}
<div class="cust-stats-grid">
    <div class="cust-stat-card">
        <div class="cust-stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
        </div>
        <div>
            <div class="cust-stat-val">{{ number_format($totalCustomers) }}</div>
            <div class="cust-stat-label">Total Customers</div>
        </div>
    </div>
    <div class="cust-stat-card">
        <div class="cust-stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <div class="cust-stat-val">{{ $newThisMonth }}</div>
            <div class="cust-stat-label">New This Month</div>
        </div>
    </div>
    <div class="cust-stat-card">
        <div class="cust-stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div>
            <div class="cust-stat-val">{{ $activeCustomers }}</div>
            <div class="cust-stat-label">Active Accounts</div>
        </div>
    </div>
    <div class="cust-stat-card">
        <div class="cust-stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
            </svg>
        </div>
        <div>
            <div class="cust-stat-val">{{ number_format($totalOrdersAll) }}</div>
            <div class="cust-stat-label">Total Orders Placed</div>
        </div>
    </div>
</div>

{{-- ─── Customer Table ─── --}}
<div class="admin-card">
    <div class="admin-card-title">
        <span>Registered Customers</span>
        <span style="font-size:0.78rem; color:var(--color-admin-text-muted); font-weight:500;">{{ $totalCustomers }} total</span>
    </div>

    <div class="search-row">
        <input type="text" id="custSearch" class="admin-input" placeholder="Search by name, email, or phone…" style="flex:1; max-width:360px;">
    </div>

    <div class="cust-table-wrap">
        <table class="cust-table" id="custTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Status</th>
                    <th style="text-align:right; padding-right:20px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr data-search="{{ strtolower($customer->name . ' ' . $customer->email . ' ' . $customer->phone) }}">
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="cust-avatar-circle">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:700; color:var(--color-admin-text-main);">{{ $customer->name }}</div>
                                <div style="font-size:0.72rem; color:var(--color-admin-text-muted);">#{{ $customer->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--color-admin-text-muted);">{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '—' }}</td>
                    <td style="font-size:0.82rem; color:var(--color-admin-text-muted);">{{ $customer->created_at->format('d M Y') }}</td>
                    <td>
                        <span style="font-family:var(--font-mono); font-weight:700; font-size:0.95rem;">{{ $customer->orders_count }}</span>
                    </td>
                    <td style="font-weight:700;">₹{{ number_format($customer->orders_sum_grand_total ?? 0, 2) }}</td>
                    <td>
                        @php $st = $customer->status ?? 'active'; @endphp
                        <span class="cust-status-badge {{ $st === 'active' ? 'active' : ($st === 'inactive' ? 'inactive' : 'default') }}">
                            {{ ucfirst($st) }}
                        </span>
                    </td>
                    <td style="text-align:right; padding-right:20px;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <button class="btn-action-outline"
                                onclick="openCustModal({{ json_encode([
                                    'id' => $customer->id,
                                    'name' => $customer->name,
                                    'email' => $customer->email,
                                    'phone' => $customer->phone ?? '—',
                                    'joined' => $customer->created_at->format('d M Y'),
                                    'orders_count' => $customer->orders_count,
                                    'total_spent' => number_format($customer->orders_sum_grand_total ?? 0, 2),
                                    'status' => $customer->status ?? 'active',
                                ]) }})">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                View
                            </button>
                            <form action="{{ route('admin.customers.toggle-status', $customer->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-action-outline {{ ($customer->status ?? 'active') === 'active' ? 'danger' : '' }}"
                                    onclick="return confirm('Toggle account status for {{ addslashes($customer->name) }}?')">
                                    {{ ($customer->status ?? 'active') === 'active' ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:40px; color:var(--color-admin-text-muted);">
                        No customers registered yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── Customer Detail Modal ─── --}}
<div class="admin-modal-overlay" id="custDetailModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title" id="custModalName">Customer Details</h3>
            <button class="admin-modal-close" onclick="closeModal('custDetailModal')">&times;</button>
        </div>
        <div class="admin-modal-body">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--color-admin-border);">
                <div class="cust-avatar-circle" style="width:52px; height:52px; font-size:1.2rem;" id="custModalAvatar">A</div>
                <div>
                    <div style="font-family:var(--font-secondary); font-size:1.15rem; font-weight:800;" id="custModalNameLarge">—</div>
                    <div style="font-size:0.78rem; color:var(--color-admin-text-muted);" id="custModalStatus">—</div>
                </div>
            </div>
            <div class="cust-detail-row">
                <span class="cust-detail-label">Email Address</span>
                <span class="cust-detail-val" id="custModalEmail">—</span>
            </div>
            <div class="cust-detail-row">
                <span class="cust-detail-label">Phone Number</span>
                <span class="cust-detail-val" id="custModalPhone">—</span>
            </div>
            <div class="cust-detail-row">
                <span class="cust-detail-label">Registration Date</span>
                <span class="cust-detail-val" id="custModalJoined">—</span>
            </div>
            <div class="cust-detail-row">
                <span class="cust-detail-label">Total Orders</span>
                <span class="cust-detail-val" id="custModalOrders">—</span>
            </div>
            <div class="cust-detail-row">
                <span class="cust-detail-label">Total Spent</span>
                <span class="cust-detail-val" id="custModalSpent">—</span>
            </div>

            <a id="custModalOrdersLink" href="#" class="btn-solid-accent" style="width:100%; justify-content:center; margin-top:20px; box-sizing:border-box; text-align:center;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                View All Orders
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openCustModal(c) {
        document.getElementById('custModalName').textContent      = c.name;
        document.getElementById('custModalAvatar').textContent    = c.name.charAt(0).toUpperCase();
        document.getElementById('custModalNameLarge').textContent = c.name;
        document.getElementById('custModalStatus').textContent    = 'Status: ' + c.status;
        document.getElementById('custModalEmail').textContent     = c.email;
        document.getElementById('custModalPhone').textContent     = c.phone;
        document.getElementById('custModalJoined').textContent    = c.joined;
        document.getElementById('custModalOrders').textContent    = c.orders_count + ' orders';
        document.getElementById('custModalSpent').textContent     = '₹' + c.total_spent;
        openModal('custDetailModal');
    }

    document.getElementById('custSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('#custTable tbody tr[data-search]').forEach(row => {
            row.style.display = !q || row.dataset.search.includes(q) ? '' : 'none';
        });
    });
</script>
@endsection
