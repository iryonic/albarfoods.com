@extends('layouts.admin')

@section('title', 'Support Tickets — Al Barr Admin')
@section('header_title', 'Support Tickets')

@section('styles')
<style>
    /* ─── Filter Row ─── */
    .ticket-filters {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--color-admin-border);
    }

    .ticket-filters .admin-input {
        flex: 1;
        min-width: 220px;
    }

    /* ─── Priority Badges ─── */
    .priority-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .priority-badge::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.8;
    }

    .priority-badge.high   { background: #f8d7da; color: #842029; }
    .priority-badge.medium { background: #fff3cd; color: #7a5f00; }
    .priority-badge.low    { background: #d1e7dd; color: #0a5c36; }

    /* ─── Status Badges ─── */
    .ticket-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .ticket-status-badge.open        { background: #cfe2ff; color: #0a4b99; }
    .ticket-status-badge.in-progress { background: #e6d9ff; color: #4b1db5; }
    .ticket-status-badge.resolved    { background: #d1e7dd; color: #0a5c36; }
    .ticket-status-badge.closed      { background: #e2e3e5; color: #383d41; }

    /* ─── Action Button ─── */
    .btn-view-thread {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: var(--color-admin-text-main);
        color: #fff;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-view-thread:hover {
        background: #3a3b3d;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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

    /* ─── Unread indicator ─── */
    .unread-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--color-admin-accent);
        margin-right: 6px;
        vertical-align: middle;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0.4; }
    }

    /* ─── Bulk Action Bar ─── */
    .ticket-bulk-bar {
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
        animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        flex-wrap: wrap;
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }

    .ticket-bulk-bar .bar-count {
        font-weight: 700;
        color: #fff;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .ticket-bulk-bar .bar-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .ticket-bulk-bar select,
    .ticket-bulk-bar button {
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--font-sans);
        transition: all 0.2s;
    }

    .ticket-bulk-bar select {
        background: rgba(255,255,255,0.1);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .ticket-bulk-bar .bar-btn-apply {
        background: var(--color-admin-accent);
        color: #fff;
        border: none;
    }
    .ticket-bulk-bar .bar-btn-apply:hover {
        background: var(--color-admin-accent-hover);
    }

    .ticket-bulk-bar .bar-btn-close {
        background: transparent;
        color: rgba(255,255,255,0.7);
        border: 1px solid rgba(255,255,255,0.15);
    }
    .ticket-bulk-bar .bar-btn-close:hover {
        color: #fff;
        border-color: rgba(255,255,255,0.3);
    }

    /* ─── Time ago badge ─── */
    .time-ago {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--color-admin-text-muted);
        background: var(--color-admin-border-light);
    }

    @media (max-width: 768px) {
        .ticket-bulk-bar {
            left: 16px;
            right: 16px;
            flex-direction: column;
            align-items: stretch;
        }
        .ticket-bulk-bar .bar-actions {
            margin-left: 0;
        }
    }
</style>
@endsection

@section('content')
@php
    $total     = $tickets->count();
    $open      = $tickets->where('status', 'Open')->count();
    $inProg    = $tickets->where('status', 'In Progress')->count();
    $resolved  = $tickets->where('status', 'Resolved')->count();
    $closed    = $tickets->where('status', 'Closed')->count();
    $highPrio  = $tickets->where('priority', 'High')->count();
@endphp

{{-- ─── Page Hero ─── --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h2 style="font-family: var(--font-secondary); font-size: 1.4rem; font-weight: 800; margin: 0;">Support Tickets</h2>
        <p style="font-size: 0.84rem; color: var(--color-admin-text-muted); margin: 4px 0 0;">{{ $total }} total tickets · Monitor, respond, and resolve customer issues</p>
    </div>
</div>

{{-- ─── Stats ─── --}}
<div class="stats-4-grid" style="grid-template-columns: repeat(6, 1fr); margin-bottom: 24px;">
    <div class="stat-kpi-card blue">
        <div class="stat-kpi-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="2" ry="2"/><line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val">{{ $total }}</div>
            <div class="stat-kpi-label">Total Tickets</div>
        </div>
    </div>
    <div class="stat-kpi-card amber">
        <div class="stat-kpi-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="color: #0a4b99;">{{ $open }}</div>
            <div class="stat-kpi-label">Open</div>
        </div>
    </div>
    <div class="stat-kpi-card purple">
        <div class="stat-kpi-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="color: #4b1db5;">{{ $inProg }}</div>
            <div class="stat-kpi-label">In Progress</div>
        </div>
    </div>
    <div class="stat-kpi-card green">
        <div class="stat-kpi-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="color: var(--color-admin-accent);">{{ $resolved }}</div>
            <div class="stat-kpi-label">Resolved</div>
        </div>
    </div>
    <div class="stat-kpi-card grey" style="background:#f8fafc; border-color:var(--color-admin-border);">
        <div class="stat-kpi-icon grey" style="background:var(--color-admin-border-light); color:var(--color-admin-text-muted);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M22 2L2 22"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="color: var(--color-admin-text-muted);">{{ $closed }}</div>
            <div class="stat-kpi-label">Closed</div>
        </div>
    </div>
    <div class="stat-kpi-card red">
        <div class="stat-kpi-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="stat-kpi-body">
            <div class="stat-kpi-val" style="color: #842029;">{{ $highPrio }}</div>
            <div class="stat-kpi-label">High Priority</div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 1400px) {
        .stats-4-grid { grid-template-columns: repeat(3, 1fr) !important; }
    }
    @media (max-width: 768px) {
        .stats-4-grid { grid-template-columns: repeat(2, 1fr) !important; }
    }
    @media (max-width: 480px) {
        .stats-4-grid { grid-template-columns: 1fr !important; }
    }
</style>

{{-- ─── Table Card ─── --}}
<div class="admin-card" style="padding: 0;">

    {{-- Filters --}}
    <div class="ticket-filters">
        <input type="text" id="ticketSearch" class="admin-input" placeholder="🔍 Search by ticket number or subject…" style="max-width: 320px;">
        <select id="priorityFilter" class="admin-input" style="max-width: 180px; flex: 0;">
            <option value="all">All Priorities</option>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>
        <select id="statusFilter" class="admin-input" style="max-width: 180px; flex: 0;">
            <option value="all">All Statuses</option>
            <option value="open">Open</option>
            <option value="in progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
        </select>
    </div>

    {{-- Table --}}
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="padding-left: 24px; width: 40px;">
                        <input type="checkbox" id="selectAllTickets" onchange="toggleAllTickets(this)" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--color-admin-accent);">
                    </th>
                    <th>Ticket No.</th>
                    <th>Customer</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Agent</th>
                    <th>Opened</th>
                    <th style="text-align: right; padding-right: 24px;">Action</th>
                </tr>
            </thead>
            <tbody id="ticketTableBody">
                @forelse($tickets as $ticket)
                    <tr class="ticket-row"
                        data-number="{{ strtolower($ticket->ticket_number) }}"
                        data-subject="{{ strtolower($ticket->subject) }}"
                        data-priority="{{ strtolower($ticket->priority) }}"
                        data-status="{{ strtolower($ticket->status) }}"
                        data-id="{{ $ticket->id }}">

                        <td style="padding-left: 24px;" onclick="event.stopPropagation();">
                            <input type="checkbox" class="ticket-checkbox" data-id="{{ $ticket->id }}" onchange="updateTicketSelection()" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--color-admin-accent);">
                        </td>
                        <td>
                            @if($ticket->status === 'Open')
                                <span class="unread-dot"></span>
                            @endif
                            <span style="font-family: var(--font-mono); font-size: 0.82rem; font-weight: 700;">{{ $ticket->ticket_number }}</span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, rgba(197, 168, 128, 0.15), rgba(197, 168, 128, 0.05)); color: var(--color-admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; font-family: var(--font-secondary); flex-shrink: 0; border: 1px solid rgba(197, 168, 128, 0.25);">
                                    {{ strtoupper(substr($ticket->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700;">{{ $ticket->user->name ?? 'Guest User' }}</div>
                                    <div style="font-size: 0.74rem; color: var(--color-admin-text-muted); margin-top: 1px;">{{ $ticket->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: var(--color-admin-text-main); max-width: 220px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $ticket->subject }}">
                                {{ $ticket->subject }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 0.84rem; color: var(--color-admin-text-muted); background: var(--color-admin-border-light); padding: 3px 8px; border-radius: 6px;">{{ $ticket->category }}</span>
                        </td>
                        <td>
                            <span class="priority-badge {{ strtolower($ticket->priority) }}">{{ $ticket->priority }}</span>
                        </td>
                        <td>
                            @php
                                $statusClass = match($ticket->status) {
                                    'Open'        => 'open',
                                    'In Progress' => 'in-progress',
                                    'Resolved'    => 'resolved',
                                    'Closed'      => 'closed',
                                    default       => 'closed'
                                };
                            @endphp
                            <span class="ticket-status-badge {{ $statusClass }}">{{ $ticket->status }}</span>
                        </td>
                        <td>
                            @if($ticket->assignedAgent)
                                <span style="font-weight: 600; font-size: 0.85rem;">{{ $ticket->assignedAgent->name }}</span>
                            @else
                                <span style="font-size: 0.8rem; color: var(--color-admin-text-muted); font-style: italic;">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.84rem; font-weight: 600; color: var(--color-admin-text-main);">{{ $ticket->created_at->format('d M Y') }}</div>
                            <span class="time-ago">{{ $ticket->created_at->diffForHumans() }}</span>
                        </td>
                        <td style="text-align: right; padding-right: 24px;">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn-view-thread">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                View Thread
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-state-icon">🎟️</div>
                                <h3>No Support Tickets Yet</h3>
                                <p>Customer support requests will appear here once submitted.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Bulk Action Floating Bar --}}
<div class="ticket-bulk-bar" id="ticketBulkBar">
    <span class="bar-count" id="ticketBulkCount">0 tickets selected</span>
    <div class="bar-actions">
        <form id="ticketBulkForm" action="{{ route('admin.tickets.bulk-status') }}" method="POST" style="display: flex; gap: 8px; align-items: center; margin: 0;">
            @csrf
            <input type="hidden" name="ticket_ids" id="ticketBulkIds">
            <select name="status" style="padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; font-family: var(--font-sans); background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                <option value="Open" style="color: #000;">Open</option>
                <option value="In Progress" style="color: #000;">In Progress</option>
                <option value="Resolved" style="color: #000;">Resolved</option>
                <option value="Closed" style="color: #000;">Closed</option>
            </select>
            <button type="submit" class="bar-btn-apply" style="padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; font-family: var(--font-sans); background: var(--color-admin-accent); color: #fff; border: none;">Apply Status</button>
        </form>
        <button class="bar-btn-close" onclick="clearTicketSelection()" style="padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; font-family: var(--font-sans); background: transparent; color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.15);">Cancel</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ticketSearch   = document.getElementById('ticketSearch');
    const prioritySelect = document.getElementById('priorityFilter');
    const statusSelect   = document.getElementById('statusFilter');

    function filterTickets() {
        const query    = ticketSearch.value.toLowerCase().trim();
        const priority = prioritySelect.value;
        const status   = statusSelect.value;

        document.querySelectorAll('.ticket-row').forEach(row => {
            const matchSearch   = !query || row.dataset.number.includes(query) || row.dataset.subject.includes(query);
            const matchPriority = priority === 'all' || row.dataset.priority === priority;
            const matchStatus   = status   === 'all' || row.dataset.status   === status;

            row.style.display = (matchSearch && matchPriority && matchStatus) ? 'table-row' : 'none';
        });
    }

    ticketSearch.addEventListener('input', filterTickets);
    prioritySelect.addEventListener('change', filterTickets);
    statusSelect.addEventListener('change', filterTickets);

    /* ── Checkbox / Bulk Actions ── */
    function toggleAllTickets(master) {
        document.querySelectorAll('.ticket-checkbox').forEach(cb => {
            cb.checked = master.checked;
        });
        updateTicketSelection();
    }

    function updateTicketSelection() {
        const checked = document.querySelectorAll('.ticket-checkbox:checked');
        const total = document.querySelectorAll('.ticket-checkbox');
        const master = document.getElementById('selectAllTickets');
        const bar = document.getElementById('ticketBulkBar');

        if (master) {
            master.checked = checked.length === total.length && total.length > 0;
            master.indeterminate = checked.length > 0 && checked.length < total.length;
        }

        const ids = Array.from(checked).map(cb => cb.dataset.id);
        document.getElementById('ticketBulkIds').value = JSON.stringify(ids);
        document.getElementById('ticketBulkCount').textContent = `${ids.length} ticket${ids.length !== 1 ? 's' : ''} selected`;

        bar.style.display = ids.length > 0 ? 'flex' : 'none';
    }

    function clearTicketSelection() {
        document.querySelectorAll('.ticket-checkbox').forEach(cb => cb.checked = false);
        const master = document.getElementById('selectAllTickets');
        if (master) { master.checked = false; master.indeterminate = false; }
        updateTicketSelection();
    }
</script>
@endsection
