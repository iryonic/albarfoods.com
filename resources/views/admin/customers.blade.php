@extends('layouts.admin')

@section('title', 'Customer Management - Al Barr')
@section('header_title', 'Customer Directory')

@section('styles')
<style>
    .cust-avatar-circle {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, var(--color-admin-accent) 0%, #014e28 100%);
        color: #fff; display: inline-flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 0.9rem; flex-shrink: 0;
        border: 2px solid rgba(1,136,73,0.15);
        font-family: var(--font-secondary);
    }

    .cust-status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.71rem; font-weight: 700; }
    .cust-status-badge.active   { background: #e3fbeb; color: #008060; }
    .cust-status-badge.inactive { background: #fbeae5; color: #ba3c1c; }
    .cust-status-badge.default  { background: #f1f2f4; color: #6d7175; }

    .cust-detail-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--color-admin-border-light); font-size: 0.875rem; }
    .cust-detail-row:last-child { border-bottom: none; }
    .cust-detail-label { color: var(--color-admin-text-muted); font-weight: 600; }
    .cust-detail-val   { font-weight: 700; color: var(--color-admin-text-main); text-align: right; }

    /* Premium Drawer styling */
    .admin-drawer-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(15, 23, 42, 0.3);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 200;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .admin-drawer-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
    .admin-drawer-card {
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
    .admin-drawer-overlay.active .admin-drawer-card {
        transform: translateX(0);
    }
    .drawer-header {
        background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);
        color: #fff;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .drawer-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }
</style>
@endsection

@section('content')

{{-- ─── Stats ─── --}}
<div class="stats-4-grid">
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ number_format($totalCustomers) }}</div>
            <div class="stat-kpi-label">Total Customers</div>
        </div>
    </div>
    <div class="stat-kpi-card green">
        <div class="stat-kpi-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $newThisMonth }}</div>
            <div class="stat-kpi-label">New This Month</div>
        </div>
    </div>
    <div class="stat-kpi-card amber">
        <div class="stat-kpi-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $activeCustomers }}</div>
            <div class="stat-kpi-label">Active Accounts</div>
        </div>
    </div>
    <div class="stat-kpi-card purple">
        <div class="stat-kpi-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ number_format($totalOrdersAll) }}</div>
            <div class="stat-kpi-label">Total Orders</div>
        </div>
    </div>
</div>

{{-- ─── Customer Table ─── --}}
<div class="admin-card" style="padding: 0;">
    <div class="admin-card-title" style="padding: 24px 24px 0;">
        <span>Customer Directory</span>
    </div>

    <div class="filter-row" style="padding: 0 24px 18px;">
        <input type="text" id="custSearch" class="admin-input" placeholder="Search by name, email, or phone…" style="flex:1; max-width:360px;">
        
        <button class="btn-action-outline" onclick="exportCustomersToCSV()" style="margin-left: auto; height: 42px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </button>
    </div>

    <div class="table-wrap">
        <table class="cust-table" id="custTable">
            <thead>
                <tr>
                    <th style="padding-left: 24px;">Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th>Orders</th>
                    <th>Lifetime Value (LTV)</th>
                    <th>Last Active</th>
                    <th>Status</th>
                    <th style="text-align:right; padding-right:24px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                @php
                    $latestOrder = $customer->orders->first();
                    $lastActiveDate = $latestOrder ? $latestOrder->created_at->format('d M Y') : 'Never';
                    $lastActiveTimestamp = $latestOrder ? $latestOrder->created_at->timestamp : 0;
                @endphp
                <tr data-search="{{ strtolower($customer->name . ' ' . $customer->email . ' ' . $customer->phone) }}"
                    data-name="{{ $customer->name }}"
                    data-id="{{ $customer->id }}"
                    data-email="{{ $customer->email }}"
                    data-phone="{{ $customer->phone ?? '—' }}"
                    data-joined="{{ $customer->created_at->format('d M Y') }}"
                    data-orders="{{ $customer->orders_count }}"
                    data-ltv="₹{{ number_format($customer->orders_sum_grand_total ?? 0, 2) }}"
                    data-lastactive="{{ $lastActiveDate }}"
                    data-status="{{ $customer->status ?? 'active' }}">
                    <td style="padding-left: 24px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div class="cust-avatar-circle">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:700; color:var(--color-admin-text-main);">{{ $customer->name }}</div>
                                <div style="font-size:0.72rem; color:var(--color-admin-text-muted);">#{{ $customer->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--color-admin-text-muted); font-weight: 500;">{{ $customer->email }}</td>
                    <td style="font-family: var(--font-mono); font-size: 0.84rem;">{{ $customer->phone ?? '—' }}</td>
                    <td style="font-size:0.82rem; color:var(--color-admin-text-muted);">{{ $customer->created_at->format('d M Y') }}</td>
                    <td>
                        <span style="font-family:var(--font-mono); font-weight:700; font-size:0.95rem;">{{ $customer->orders_count }}</span>
                    </td>
                    <td style="font-weight:700; color: var(--color-admin-text-main);">₹{{ number_format($customer->orders_sum_grand_total ?? 0, 2) }}</td>
                    <td style="font-size:0.82rem; color:var(--color-admin-text-muted);">{{ $lastActiveDate }}</td>
                    <td>
                        @php $st = $customer->status ?? 'active'; @endphp
                        <span class="cust-status-badge {{ $st === 'active' ? 'active' : ($st === 'inactive' ? 'inactive' : 'default') }}">
                            {{ ucfirst($st) }}
                        </span>
                    </td>
                    <td style="text-align:right; padding-right:24px;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <button class="btn-action-outline" onclick="openCustDrawer(this.closest('tr'))">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                Details
                            </button>
                            <form action="{{ route('admin.customers.toggle-status', $customer->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-action-outline {{ ($customer->status ?? 'active') === 'active' ? 'danger' : '' }}"
                                    onclick="return confirm('Are you sure you want to {{ ($customer->status ?? 'active') === 'active' ? 'Disable' : 'Enable' }} the account for {{ addslashes($customer->name) }}?')">
                                    {{ ($customer->status ?? 'active') === 'active' ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:40px; color:var(--color-admin-text-muted);">
                        No customers registered yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── Customer Detail Slide-out Drawer ─── --}}
<div class="admin-drawer-overlay" id="custDrawerOverlay" onclick="closeCustDrawer()">
    <div class="admin-drawer-card" onclick="event.stopPropagation()">
        <div class="drawer-header">
            <h3 class="admin-modal-title" style="color: #fff; font-size: 1.15rem;">Customer Profile Overview</h3>
            <button class="admin-modal-close" style="font-size: 1.6rem; color: #fff;" onclick="closeCustDrawer()">&times;</button>
        </div>
        <div class="drawer-body">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid var(--color-admin-border);">
                <div class="cust-avatar-circle" style="width:52px; height:52px; font-size:1.25rem;" id="custDrawerAvatar">A</div>
                <div>
                    <div style="font-family:var(--font-secondary); font-size:1.2rem; font-weight:800;" id="custDrawerNameLarge">—</div>
                    <div style="font-size:0.75rem; color:var(--color-admin-text-muted); font-weight: 700; margin-top: 2px;" id="custDrawerStatusBadge">—</div>
                </div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <h4 style="font-family: var(--font-secondary); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; color: var(--color-admin-text-muted); margin-bottom: 12px; letter-spacing: 0.4px;">Contact Details</h4>
                <div class="cust-detail-row">
                    <span class="cust-detail-label">Email Address</span>
                    <span class="cust-detail-val" id="custDrawerEmail">—</span>
                </div>
                <div class="cust-detail-row">
                    <span class="cust-detail-label">Phone Number</span>
                    <span class="cust-detail-val" id="custDrawerPhone">—</span>
                </div>
                <div class="cust-detail-row">
                    <span class="cust-detail-label">Registration Date</span>
                    <span class="cust-detail-val" id="custDrawerJoined">—</span>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <h4 style="font-family: var(--font-secondary); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; color: var(--color-admin-text-muted); margin-bottom: 12px; letter-spacing: 0.4px;">Purchase Activity</h4>
                <div class="cust-detail-row">
                    <span class="cust-detail-label">Total Orders Placed</span>
                    <span class="cust-detail-val" id="custDrawerOrders">—</span>
                </div>
                <div class="cust-detail-row">
                    <span class="cust-detail-label">Lifetime Value (LTV)</span>
                    <span class="cust-detail-val" id="custDrawerSpent" style="color: var(--color-admin-accent);">—</span>
                </div>
                <div class="cust-detail-row">
                    <span class="cust-detail-label">Last Active Date</span>
                    <span class="cust-detail-val" id="custDrawerLastActive">—</span>
                </div>
            </div>

            <a id="custDrawerOrdersLink" href="{{ route('admin.orders') }}" class="btn-solid-accent" style="width:100%; justify-content:center; box-sizing:border-box; text-align:center; border: none; font-weight: bold; margin-top: 10px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                View Customer Orders
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openCustDrawer(row) {
        const d = row.dataset;
        document.getElementById('custDrawerAvatar').textContent    = d.name.charAt(0).toUpperCase();
        document.getElementById('custDrawerNameLarge').textContent = d.name;
        
        // Setup status badge style in drawer
        const badge = document.getElementById('custDrawerStatusBadge');
        badge.innerHTML = `<span class="cust-status-badge ${d.status === 'active' ? 'active' : 'inactive'}">${d.status.toUpperCase()}</span>`;

        document.getElementById('custDrawerEmail').textContent     = d.email;
        document.getElementById('custDrawerPhone').textContent     = d.phone;
        document.getElementById('custDrawerJoined').textContent    = d.joined;
        document.getElementById('custDrawerOrders').textContent    = d.orders + ' orders';
        document.getElementById('custDrawerSpent').textContent     = d.ltv;
        document.getElementById('custDrawerLastActive').textContent = d.lastactive;
        
        // Update order filter search parameter on link click
        document.getElementById('custDrawerOrdersLink').href = `{{ route('admin.orders') }}?search=${encodeURIComponent(d.name)}`;
        
        document.getElementById('custDrawerOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCustDrawer() {
        document.getElementById('custDrawerOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Live search filter
    document.getElementById('custSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('#custTable tbody tr[data-search]').forEach(row => {
            row.style.display = !q || row.dataset.search.includes(q) ? '' : 'none';
        });
    });

    // CSV export for customers
    function exportCustomersToCSV() {
        const rows = document.querySelectorAll('#custTable tbody tr[data-search]');
        let csv = ['Customer ID,Customer Name,Email,Phone,Joined Date,Orders Count,Lifetime Value (LTV),Last Active,Status'].join(',') + '\n';
        
        let count = 0;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const id = row.dataset.id;
                const name = row.dataset.name;
                const email = row.dataset.email;
                const phone = row.dataset.phone;
                const joined = row.dataset.joined;
                const orders = row.dataset.orders;
                const ltv = row.dataset.ltv.replace('₹', '').replace(/,/g, '');
                const lastactive = row.dataset.lastactive;
                const status = row.dataset.status;
                
                csv += `"${id}","${name}","${email}","${phone}","${joined}","${orders}","${ltv}","${lastactive}","${status}"\n`;
                count++;
            }
        });
        
        if (count === 0) {
            showToast("No customers available to export.", "error");
            return;
        }

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", `customers_export_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showToast(`Exported ${count} customers successfully!`, "success");
    }
</script>
@endsection
