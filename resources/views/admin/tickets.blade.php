@extends('layouts.admin')

@section('title', 'Support Tickets — Al Barr Admin')
@section('header_title', 'Support Tickets')

@section('styles')
<style>
    /* ─── Page Header ─── */
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
    .ticket-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 14px;
        margin-bottom: var(--spacing-xl);
    }

    .ticket-stat {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 16px 20px;
        box-shadow: var(--shadow-admin-sm);
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .ticket-stat:hover {
        box-shadow: var(--shadow-admin-md);
        transform: translateY(-2px);
    }

    .ts-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--color-admin-text-muted);
        margin-bottom: 4px;
    }

    .ts-value {
        font-family: var(--font-secondary);
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
    }

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

    .admin-table tbody tr td {
        padding: 14px 16px;
        vertical-align: middle;
    }

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
<div class="page-hero">
    <div>
        <h2>Support Tickets</h2>
        <p>{{ $total }} total tickets · Monitor, respond, and resolve customer issues</p>
    </div>
</div>

{{-- ─── Stats ─── --}}
<div class="ticket-stats">
    <div class="ticket-stat">
        <div class="ts-label">Total Tickets</div>
        <div class="ts-value">{{ $total }}</div>
    </div>
    <div class="ticket-stat">
        <div class="ts-label">Open</div>
        <div class="ts-value" style="color: #0a4b99;">{{ $open }}</div>
    </div>
    <div class="ticket-stat">
        <div class="ts-label">In Progress</div>
        <div class="ts-value" style="color: #4b1db5;">{{ $inProg }}</div>
    </div>
    <div class="ticket-stat">
        <div class="ts-label">Resolved</div>
        <div class="ts-value" style="color: var(--color-admin-accent);">{{ $resolved }}</div>
    </div>
    <div class="ticket-stat">
        <div class="ts-label">Closed</div>
        <div class="ts-value" style="color: var(--color-admin-text-muted);">{{ $closed }}</div>
    </div>
    <div class="ticket-stat">
        <div class="ts-label">High Priority</div>
        <div class="ts-value" style="color: #842029;">{{ $highPrio }}</div>
    </div>
</div>

{{-- ─── Table Card ─── --}}
<div class="admin-card" style="padding: 0;">

    {{-- Filters --}}
    <div class="ticket-filters">
        <input type="text" id="ticketSearch" class="admin-input" placeholder="🔍 Search by ticket number or subject…" style="max-width: 320px;">
        <select id="priorityFilter" class="admin-input" style="max-width: 180px;">
            <option value="all">All Priorities</option>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>
        <select id="statusFilter" class="admin-input" style="max-width: 180px;">
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
                    <th style="padding-left: 24px;">Ticket No.</th>
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
                        data-status="{{ strtolower($ticket->status) }}">

                        <td style="padding-left: 24px;">
                            @if($ticket->status === 'Open')
                                <span class="unread-dot"></span>
                            @endif
                            <span style="font-family: var(--font-mono); font-size: 0.82rem; font-weight: 700;">{{ $ticket->ticket_number }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $ticket->user->name ?? 'Guest User' }}</div>
                            <div style="font-size: 0.74rem; color: var(--color-admin-text-muted); margin-top: 1px;">{{ $ticket->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: var(--color-admin-text-main); max-width: 220px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $ticket->subject }}">
                                {{ $ticket->subject }}
                            </span>
                        </td>
                        <td style="font-size: 0.84rem; color: var(--color-admin-text-muted);">{{ $ticket->category }}</td>
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
                        <td style="font-size: 0.82rem; color: var(--color-admin-text-muted);">{{ $ticket->created_at->format('d M Y') }}</td>
                        <td style="text-align: right; padding-right: 24px;">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn-view-thread">
                                💬 View Thread
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
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
</script>
@endsection
