@extends('layouts.admin')

@section('title', 'Coupon Management - Al Barr')
@section('header_title', 'Coupon Management')

@section('styles')
<style>
    /* Coupon-specific badges - stat cards use global .stats-4-grid system */
    .coupon-code-badge {
        font-family: var(--font-mono); font-size: 0.88rem; font-weight: 700;
        color: #1a56d6; background: #e4f0ff; padding: 4px 12px;
        border-radius: 6px; letter-spacing: 1px; display: inline-block;
    }

    /* Table */
    .coupon-table-wrap { overflow-x: auto; }

    .coupon-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 860px;
    }

    .coupon-table thead th {
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

    .coupon-table tbody tr {
        border-bottom: 1px solid var(--color-admin-border-light);
        transition: background 0.15s;
    }

    .coupon-table tbody tr:hover { background: #fafbfc; }
    .coupon-table tbody tr:last-child { border-bottom: none; }

    .coupon-table tbody td {
        padding: 14px 16px;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .coupon-code-badge {
        font-family: var(--font-mono);
        font-size: 0.88rem;
        font-weight: 700;
        color: #1a56d6;
        background: #e4f0ff;
        padding: 4px 12px;
        border-radius: 6px;
        letter-spacing: 1px;
        display: inline-block;
    }

    .coupon-type-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .coupon-type-badge.percent { background: #f3e8ff; color: #7e22ce; }
    .coupon-type-badge.flat    { background: #fff8e1; color: #b56f00; }

    .coupon-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .coupon-status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .coupon-status-badge.active   { background: #e3fbeb; color: #008060; }
    .coupon-status-badge.inactive { background: #fbeae5; color: #ba3c1c; }
    .coupon-status-badge.expired  { background: #f1f2f4; color: #6d7175; }

    .usage-bar-wrap { display: flex; align-items: center; gap: 8px; }

    .usage-bar {
        flex: 1;
        height: 6px;
        background: var(--color-admin-border);
        border-radius: 3px;
        overflow: hidden;
        min-width: 60px;
    }

    .usage-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--color-admin-accent), #01a857);
        border-radius: 3px;
        transition: width 0.4s ease;
    }
</style>
@endsection

@section('content')

{{-- ─── Stats ─── --}}
<div class="stats-4-grid">
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $totalCoupons }}</div>
            <div class="stat-kpi-label">Total Coupons</div>
        </div>
    </div>
    <div class="stat-kpi-card green">
        <div class="stat-kpi-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $activeCoupons }}</div>
            <div class="stat-kpi-label">Active</div>
        </div>
    </div>
    <div class="stat-kpi-card red">
        <div class="stat-kpi-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $expiredCoupons }}</div>
            <div class="stat-kpi-label">Expired</div>
        </div>
    </div>
    <div class="stat-kpi-card amber">
        <div class="stat-kpi-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ number_format($totalRedemptions) }}</div>
            <div class="stat-kpi-label">Total Redemptions</div>
        </div>
    </div>
</div>

{{-- ─── Coupons Table ─── --}}
<div class="admin-card">
    <div class="admin-card-title">
        <span>All Coupons</span>
        <button class="btn-solid-accent" onclick="openModal('addCouponModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create Coupon
        </button>
    </div>

    <div class="coupon-table-wrap">
        <table class="coupon-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Min Order</th>
                    <th>Usage</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th style="text-align:right; padding-right:20px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                @php
                    $isExpired = $coupon->expires_at && $coupon->expires_at < now()->toDateString();
                    $usagePercent = $coupon->usage_limit ? min(100, ($coupon->used_count / $coupon->usage_limit) * 100) : 0;
                @endphp
                <tr>
                    <td>
                        <div style="display:inline-flex; align-items:center; gap:8px;">
                            <span class="coupon-code-badge">{{ $coupon->code }}</span>
                            <button class="btn-action-outline" style="padding: 4px 6px; border-radius: 4px;" onclick="copyCouponCode('{{ $coupon->code }}')" title="Copy Coupon Code">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                            </button>
                        </div>
                    </td>
                    <td>
                        <span class="coupon-type-badge {{ $coupon->type }}">
                            {{ $coupon->type === 'percent' ? 'Percentage' : 'Flat Discount' }}
                        </span>
                    </td>
                    <td style="font-weight:800; font-size:1rem; color:var(--color-admin-text-main);">
                        {{ $coupon->type === 'percent' ? $coupon->value . '%' : '₹' . number_format($coupon->value, 2) }}
                    </td>
                    <td style="color:var(--color-admin-text-muted);">
                        {{ $coupon->min_order_amount > 0 ? '₹' . number_format($coupon->min_order_amount) : 'No minimum' }}
                    </td>
                    <td>
                        <div class="usage-bar-wrap">
                            <div class="usage-bar">
                                <div class="usage-bar-fill" style="width:{{ $coupon->usage_limit ? $usagePercent : 0 }}%;"></div>
                            </div>
                            <span style="font-family:var(--font-mono); font-size:0.78rem; font-weight:700; white-space:nowrap;">
                                {{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.85rem; font-weight: 600; color:var(--color-admin-text-main);">
                            {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d M Y') : 'Never' }}
                        </div>
                        @if($isExpired)
                            <span class="status-badge cancelled" style="display:inline-flex; font-size:0.68rem; padding: 2px 8px; margin-top:4px;">Expired</span>
                        @elseif($coupon->expires_at)
                            @php
                                $daysLeft = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($coupon->expires_at), false);
                            @endphp
                            @if($daysLeft == 0)
                                <span class="status-badge pending" style="display:inline-flex; font-size:0.68rem; padding: 2px 8px; margin-top:4px;">Expires Today</span>
                            @elseif($daysLeft > 0)
                                <span class="status-badge processing" style="display:inline-flex; font-size:0.68rem; padding: 2px 8px; margin-top:4px; background-color:rgba(26,86,214,0.06); color:#1a56d6;">{{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left</span>
                            @endif
                        @else
                            <span class="status-badge delivered" style="display:inline-flex; font-size:0.68rem; padding: 2px 8px; margin-top:4px; background-color:rgba(1,136,73,0.06); color:#018849;">Infinite Validity</span>
                        @endif
                    </td>
                    <td>
                        @if($isExpired)
                            <span class="coupon-status-badge expired">Expired</span>
                        @elseif($coupon->is_active)
                            <span class="coupon-status-badge active">Active</span>
                        @else
                            <span class="coupon-status-badge inactive">Inactive</span>
                        @endif
                    </td>
                    <td style="text-align:right; padding-right:20px;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <button class="btn-action-outline"
                                onclick="openEditCoupon({{ json_encode($coupon->only('id','code','type','value','min_order_amount','usage_limit','expires_at','is_active')) }})">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </button>
                            <button class="btn-action-outline"
                                onclick="duplicateCoupon({{ json_encode($coupon->only('code','type','value','min_order_amount','usage_limit','expires_at','is_active')) }})">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                Duplicate
                            </button>
                            <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-action-outline">
                                    {{ $coupon->is_active ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" style="margin:0;"
                                onsubmit="return confirm('Delete coupon {{ $coupon->code }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-outline danger">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:50px; color:var(--color-admin-text-muted);">
                        <div style="font-size:2rem; margin-bottom:12px; opacity:0.3;">🏷️</div>
                        No coupons created yet. Click "Create Coupon" to add your first one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── Add Coupon Modal ─── --}}
<div class="admin-modal-overlay" id="addCouponModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Create New Coupon</h3>
            <button class="admin-modal-close" onclick="closeModal('addCouponModal')">&times;</button>
        </div>
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="admin-modal-body">
                <div class="admin-form-group">
                    <label for="addCode">Coupon Code *</label>
                    <input type="text" name="code" id="addCode" class="admin-input"
                        placeholder="e.g. SUMMER20" required style="text-transform:uppercase; letter-spacing:2px; font-family:var(--font-mono); font-size:1rem;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="admin-form-group">
                        <label for="addType">Discount Type *</label>
                        <select name="type" id="addType" class="admin-select" required>
                            <option value="percent">Percentage (%)</option>
                            <option value="flat">Flat Amount (₹)</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label for="addValue">Discount Value *</label>
                        <input type="number" step="0.01" name="value" id="addValue" class="admin-input" placeholder="e.g. 15 or 200" required min="0">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="admin-form-group">
                        <label for="addMinOrder">Minimum Order (₹)</label>
                        <input type="number" step="0.01" name="min_order_amount" id="addMinOrder" class="admin-input" placeholder="0 = no minimum">
                    </div>
                    <div class="admin-form-group">
                        <label for="addUsageLimit">Usage Limit</label>
                        <input type="number" name="usage_limit" id="addUsageLimit" class="admin-input" placeholder="Leave blank = unlimited">
                    </div>
                </div>
                <div class="admin-form-group">
                    <label for="addExpiry">Expiry Date</label>
                    <input type="date" name="expires_at" id="addExpiry" class="admin-input">
                </div>
                <div class="admin-form-group">
                    <label for="addCouponStatus">Status *</label>
                    <select name="is_active" id="addCouponStatus" class="admin-select" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive (draft)</option>
                    </select>
                </div>
                <button type="submit" class="btn-solid-accent" style="width:100%; padding:12px; justify-content:center; margin-top:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ─── Edit Coupon Modal ─── --}}
<div class="admin-modal-overlay" id="editCouponModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Edit Coupon</h3>
            <button class="admin-modal-close" onclick="closeModal('editCouponModal')">&times;</button>
        </div>
        <form id="editCouponForm" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-modal-body">
                <div class="admin-form-group">
                    <label for="editCode">Coupon Code *</label>
                    <input type="text" name="code" id="editCode" class="admin-input" required
                        style="text-transform:uppercase; letter-spacing:2px; font-family:var(--font-mono); font-size:1rem;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="admin-form-group">
                        <label for="editType">Discount Type *</label>
                        <select name="type" id="editType" class="admin-select" required>
                            <option value="percent">Percentage (%)</option>
                            <option value="flat">Flat Amount (₹)</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label for="editValue">Discount Value *</label>
                        <input type="number" step="0.01" name="value" id="editValue" class="admin-input" required min="0">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="admin-form-group">
                        <label for="editMinOrder">Minimum Order (₹)</label>
                        <input type="number" step="0.01" name="min_order_amount" id="editMinOrder" class="admin-input">
                    </div>
                    <div class="admin-form-group">
                        <label for="editUsageLimit">Usage Limit</label>
                        <input type="number" name="usage_limit" id="editUsageLimit" class="admin-input">
                    </div>
                </div>
                <div class="admin-form-group">
                    <label for="editExpiry">Expiry Date</label>
                    <input type="date" name="expires_at" id="editExpiry" class="admin-input">
                </div>
                <div class="admin-form-group">
                    <label for="editCouponStatus">Status *</label>
                    <select name="is_active" id="editCouponStatus" class="admin-select" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn-solid-accent" style="width:100%; padding:12px; justify-content:center; margin-top:8px;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openEditCoupon(c) {
        const form = document.getElementById('editCouponForm');
        form.action = `/admin/coupons/${c.id}`;
        document.getElementById('editCode').value         = c.code;
        document.getElementById('editType').value         = c.type;
        document.getElementById('editValue').value        = c.value;
        document.getElementById('editMinOrder').value     = c.min_order_amount || '';
        document.getElementById('editUsageLimit').value   = c.usage_limit || '';
        document.getElementById('editExpiry').value       = c.expires_at ? c.expires_at.substring(0, 10) : '';
        document.getElementById('editCouponStatus').value = c.is_active ? '1' : '0';
        openModal('editCouponModal');
    }

    function duplicateCoupon(c) {
        document.getElementById('addCode').value = c.code + '_COPY';
        document.getElementById('addType').value = c.type;
        document.getElementById('addValue').value = c.value;
        document.getElementById('addMinOrder').value = c.min_order_amount || '';
        document.getElementById('addUsageLimit').value = c.usage_limit || '';
        document.getElementById('addExpiry').value = c.expires_at ? c.expires_at.substring(0, 10) : '';
        document.getElementById('addCouponStatus').value = c.is_active ? '1' : '0';
        openModal('addCouponModal');
        
        // Focus the coupon code input so they can easily edit it
        setTimeout(() => {
            const input = document.getElementById('addCode');
            input.focus();
            input.setSelectionRange(input.value.length, input.value.length);
        }, 150);
    }

    function copyCouponCode(code) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(code).then(() => {
                if (typeof showToast === 'function') {
                    showToast(`Code "${code}" copied to clipboard!`, 'success');
                } else {
                    alert(`Code "${code}" copied to clipboard!`);
                }
            });
        } else {
            const el = document.createElement('textarea');
            el.value = code;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            if (typeof showToast === 'function') {
                showToast(`Code "${code}" copied to clipboard!`, 'success');
            } else {
                alert(`Code "${code}" copied to clipboard!`);
            }
        }
    }

    // Auto-uppercase coupon code input
    document.getElementById('addCode').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    document.getElementById('editCode').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
@endsection
