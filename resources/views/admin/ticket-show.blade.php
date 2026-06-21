@extends('layouts.admin')

@section('title', 'Ticket #{{ $ticket->ticket_number }} — Al Barr Admin')
@section('header_title', 'Support Ticket Thread')

@section('styles')
<style>
    /* ─── Page Layout ─── */
    .ticket-detail-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: var(--spacing-xl);
        align-items: start;
    }

    @media (max-width: 991px) {
        .ticket-detail-grid { grid-template-columns: 1fr; }
    }

    /* ─── Back Link ─── */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-admin-text-muted);
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.2s;
        padding: 6px 0;
    }

    .back-link:hover { color: var(--color-admin-text-main); }

    /* ─── Info Panel (Left) ─── */
    .ticket-info-panel {
        position: sticky;
        top: 90px;
    }

    .admin-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-admin-sm);
        margin-bottom: var(--spacing-xl);
        overflow: hidden;
        transition: box-shadow 0.2s;
    }

    .admin-card:hover { box-shadow: var(--shadow-admin-md); }

    .admin-card-title {
        font-family: var(--font-secondary);
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0 0 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--color-admin-border);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ─── Detail Items ─── */
    .detail-rows {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-row-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .detail-row-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--color-admin-text-muted);
    }

    .detail-row-val {
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--color-admin-text-main);
    }

    /* ─── Priority Badges ─── */
    .priority-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .priority-badge.high   { background: #f8d7da; color: #842029; }
    .priority-badge.medium { background: #fff3cd; color: #7a5f00; }
    .priority-badge.low    { background: #d1e7dd; color: #0a5c36; }

    /* ─── Status Badges ─── */
    .ticket-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .ticket-status-badge.open        { background: #cfe2ff; color: #0a4b99; }
    .ticket-status-badge.in-progress { background: #e6d9ff; color: #4b1db5; }
    .ticket-status-badge.resolved    { background: #d1e7dd; color: #0a5c36; }
    .ticket-status-badge.closed      { background: #e2e3e5; color: #383d41; }

    /* ─── Divider ─── */
    .section-divider {
        border: none;
        border-top: 1px solid var(--color-admin-border);
        margin: 16px 0;
    }

    /* ─── Action Buttons ─── */
    .btn-gold {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
        color: #fff;
        border: none;
        border-radius: var(--radius-admin-input);
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-family: var(--font-sans);
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 8px;
    }

    .btn-gold:hover {
        background: linear-gradient(135deg, #b4956d 0%, #a08260 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(197,168,128,0.4);
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: var(--radius-admin-input);
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        box-sizing: border-box;
        font-family: var(--font-sans);
    }

    .btn-danger:hover {
        background: #b02a37;
        transform: translateY(-1px);
    }

    /* ─── Chat Thread (Right) ─── */
    .messages-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 520px;
        overflow-y: auto;
        padding: 4px 4px 4px 2px;
        margin-bottom: 20px;
        scrollbar-width: thin;
        scrollbar-color: var(--color-admin-border) transparent;
    }

    .messages-container::-webkit-scrollbar { width: 6px; }
    .messages-container::-webkit-scrollbar-thumb { background: var(--color-admin-border); border-radius: 99px; }

    /* ─── Message Bubbles ─── */
    .msg-wrap {
        display: flex;
        flex-direction: column;
        max-width: 75%;
        gap: 4px;
    }

    .msg-wrap.customer { align-self: flex-start; }
    .msg-wrap.agent    { align-self: flex-end; }

    .msg-bubble {
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 0.91rem;
        line-height: 1.55;
        word-break: break-word;
    }

    .msg-wrap.customer .msg-bubble {
        background: #f5f6f8;
        color: var(--color-admin-text-main);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--color-admin-border);
    }

    .msg-wrap.agent .msg-bubble {
        background: linear-gradient(135deg, var(--color-admin-sidebar) 0%, #1a2f4a 100%);
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    .msg-meta {
        font-size: 0.72rem;
        color: var(--color-admin-text-muted);
        padding: 0 4px;
    }

    .msg-wrap.agent .msg-meta { text-align: right; }

    .msg-meta strong { color: var(--color-admin-accent); }
    .msg-wrap.customer .msg-meta strong { color: var(--color-admin-text-muted); }

    /* ─── Reply Form ─── */
    .reply-form-panel {
        border-top: 1px solid var(--color-admin-border);
        padding-top: 20px;
    }

    .reply-form-title {
        font-family: var(--font-secondary);
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin-bottom: 14px;
    }

    .admin-input, .admin-select, .admin-textarea {
        font-family: var(--font-sans);
        padding: 10px 14px;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-input);
        font-size: 0.92rem;
        width: 100%;
        background: #fff;
        color: var(--color-admin-text-main);
        box-sizing: border-box;
        transition: all 0.2s;
    }

    .admin-input:focus, .admin-select:focus, .admin-textarea:focus {
        border-color: var(--color-admin-accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(1,136,73,0.12);
    }

    .admin-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
    }

    .admin-form-group label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: var(--color-admin-text-muted);
    }

    .reply-bottom-row {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 12px;
        align-items: end;
    }

    @media (max-width: 600px) {
        .reply-bottom-row { grid-template-columns: 1fr; }
    }

    /* ─── Ticket Number Header Pill ─── */
    .ticket-number-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        border-radius: 99px;
        padding: 4px 14px;
        font-family: var(--font-mono);
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        margin-bottom: 8px;
    }
</style>
@endsection

@section('content')
{{-- Back Navigation --}}
<a href="{{ route('admin.tickets') }}" class="back-link">
    ← Back to Ticket Registry
</a>

<div class="ticket-detail-grid">

    {{-- ─── Left Column: Ticket Info ─── --}}
    <div class="ticket-info-panel">
        <div class="admin-card">
            <div class="ticket-number-pill">
                🎟️ {{ $ticket->ticket_number }}
            </div>
            <div class="admin-card-title" style="margin-top: 12px;">
                Ticket Information
            </div>

            <div class="detail-rows">
                <div class="detail-row-item">
                    <div class="detail-row-label">Customer</div>
                    <div class="detail-row-val">{{ $ticket->user->name ?? 'Guest Patron' }}</div>
                    <div style="display: flex; flex-direction: column; gap: 2px; margin-top: 4px;">
                        @if($ticket->user?->phone)
                            <span style="font-size: 0.8rem; color: var(--color-admin-text-muted);">📞 {{ $ticket->user->phone }}</span>
                        @endif
                        @if($ticket->user?->email)
                            <span style="font-size: 0.8rem; color: var(--color-admin-text-muted);">✉️ {{ $ticket->user->email }}</span>
                        @endif
                    </div>
                </div>

                <div class="detail-row-item">
                    <div class="detail-row-label">Subject</div>
                    <div class="detail-row-val">{{ $ticket->subject }}</div>
                </div>

                <div class="detail-row-item">
                    <div class="detail-row-label">Category</div>
                    <div class="detail-row-val">{{ $ticket->category }}</div>
                </div>

                <div class="detail-row-item">
                    <div class="detail-row-label">Priority</div>
                    <div class="detail-row-val">
                        <span class="priority-badge {{ strtolower($ticket->priority) }}">{{ $ticket->priority }}</span>
                    </div>
                </div>

                <div class="detail-row-item">
                    <div class="detail-row-label">Current Status</div>
                    <div class="detail-row-val">
                        @php
                            $sc = match($ticket->status) {
                                'Open'        => 'open',
                                'In Progress' => 'in-progress',
                                'Resolved'    => 'resolved',
                                default       => 'closed'
                            };
                        @endphp
                        <span class="ticket-status-badge {{ $sc }}">{{ $ticket->status }}</span>
                    </div>
                </div>

                <div class="detail-row-item">
                    <div class="detail-row-label">Date Opened</div>
                    <div class="detail-row-val" style="font-size: 0.87rem;">{{ $ticket->created_at->format('d M Y, h:i A') }}</div>
                </div>

                <hr class="section-divider">

                <div class="detail-row-item">
                    <div class="detail-row-label">Assigned Support Agent</div>
                    @if($ticket->assignedAgent)
                        <div class="detail-row-val">👤 {{ $ticket->assignedAgent->name }}</div>
                    @else
                        <div style="font-size: 0.85rem; color: var(--color-admin-text-muted); font-style: italic; margin-bottom: 8px;">Unassigned</div>
                        <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-gold" style="margin-bottom: 0;">
                                🙋 Assign to Me
                            </button>
                        </form>
                    @endif
                </div>

                @if($ticket->status !== 'Closed')
                    <hr class="section-divider">
                    <form action="{{ route('admin.tickets.close', $ticket->id) }}" method="POST"
                          onsubmit="return confirm('Close this support ticket permanently?')">
                        @csrf
                        <button type="submit" class="btn-danger">
                            🔒 Close Support Ticket
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── Right Column: Thread + Reply ─── --}}
    <div>
        <div class="admin-card">
            <div class="admin-card-title">
                💬 Communication Thread
                <span style="font-size: 0.78rem; font-weight: 600; color: var(--color-admin-text-muted);">
                    {{ $ticket->replies->count() }} messages
                </span>
            </div>

            {{-- ─── Message Thread ─── --}}
            <div class="messages-container" id="messagesBox" style="display:flex; flex-direction:column; padding: 8px 4px;">
                @forelse($ticket->replies as $reply)
                    @php
                        $isAgent = $reply->user && in_array($reply->user->role_id, [1, 2, 3, 4]);
                    @endphp
                    <div class="msg-row" style="display:flex; gap:12px; margin-bottom:16px; align-self: {{ $isAgent ? 'flex-end' : 'flex-start' }}; flex-direction: {{ $isAgent ? 'row-reverse' : 'row' }}; max-width:75%;">
                        @php
                            $initials = '';
                            if ($reply->user?->name) {
                                $words = explode(' ', $reply->user->name);
                                $initials = strtoupper(substr($words[0], 0, 1));
                                if (count($words) > 1) {
                                    $initials .= strtoupper(substr($words[1], 0, 1));
                                }
                            } else {
                                $initials = $isAgent ? 'A' : 'C';
                            }
                            $avatarBg = $isAgent ? 'linear-gradient(135deg, var(--color-admin-sidebar) 0%, #1a2f4a 100%)' : 'linear-gradient(135deg, rgba(197, 168, 128, 0.15) 0%, rgba(197, 168, 128, 0.05) 100%)';
                            $avatarColor = $isAgent ? '#f7dfbe' : 'var(--color-admin-gold)';
                            $avatarBorder = $isAgent ? '1px solid rgba(255,255,255,0.1)' : '1px solid rgba(197, 168, 128, 0.25)';
                        @endphp
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $avatarBg }}; color: {{ $avatarColor }}; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.76rem; font-family: var(--font-secondary); flex-shrink: 0; border: {{ $avatarBorder }}; margin-top:4px;">
                            {{ $initials }}
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px; align-items: {{ $isAgent ? 'flex-end' : 'flex-start' }};">
                            <div class="msg-bubble" style="padding: 12px 16px; border-radius: 16px; font-size: 0.91rem; line-height: 1.55; word-break: break-word; {{ $isAgent ? 'background: linear-gradient(135deg, var(--color-admin-sidebar) 0%, #1a2f4a 100%); color:#fff; border-bottom-right-radius:4px;' : 'background:#f5f6f8; color:var(--color-admin-text-main); border-bottom-left-radius:4px; border:1px solid var(--color-admin-border);' }}">
                                {{ $reply->message }}
                            </div>
                            <div class="msg-meta" style="font-size: 0.72rem; color: var(--color-admin-text-muted); padding: 0 4px; text-align: {{ $isAgent ? 'right' : 'left' }};">
                                @if($isAgent)
                                    <strong>{{ $reply->user->name }}</strong> (Support Agent)
                                @else
                                    <strong style="color: var(--color-admin-text-main);">{{ $reply->user->name ?? 'Customer' }}</strong>
                                @endif
                                &bull; {{ $reply->created_at->format('d M, h:i A') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px 20px; color: var(--color-admin-text-muted); font-size: 0.88rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px; opacity: 0.4;">💬</div>
                        No messages in this thread yet. Start the conversation below.
                    </div>
                @endforelse
            </div>

            {{-- ─── Reply Form ─── --}}
            @if($ticket->status !== 'Closed')
                <div class="reply-form-panel">
                    <div class="reply-form-title">Post a Response</div>
                    <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="admin-form-group">
                            <label for="adminReplyMsg">Your Message</label>
                            <textarea name="message" id="adminReplyMsg" rows="4"
                                class="admin-input"
                                placeholder="Write your support response here…"
                                required minlength="2"
                                style="resize: vertical; min-height: 100px; border-radius: 10px;"></textarea>
                        </div>

                        <div class="reply-bottom-row">
                            <div class="admin-form-group" style="margin-bottom: 0;">
                                <label for="replyStatus">Update Status</label>
                                <select name="status" id="replyStatus" class="admin-input">
                                    <option value="In Progress" @selected($ticket->status === 'In Progress')>Keep In Progress</option>
                                    <option value="Resolved"    @selected($ticket->status === 'Resolved')>Mark as Resolved</option>
                                    <option value="Closed"      @selected($ticket->status === 'Closed')>Mark as Closed</option>
                                    <option value="Open"        @selected($ticket->status === 'Open')>Set to Open</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-gold" style="width: auto; padding: 10px 24px;">
                                ✉️ Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div style="text-align: center; padding: 24px; background: var(--color-admin-border-light); border-radius: 10px; color: var(--color-admin-text-muted); font-size: 0.88rem;">
                    🔒 This ticket has been <strong>closed</strong>. No further replies can be submitted.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const box = document.getElementById('messagesBox');
        if (box) box.scrollTop = box.scrollHeight;
    });
</script>
@endsection
