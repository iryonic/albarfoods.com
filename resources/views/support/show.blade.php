@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number . ' - Al Barr')

@section('styles')
<style>
    .profile-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        min-height: 80vh;
        position: relative;
        overflow: hidden;
    }

    .profile-glow {
        position: absolute;
        width: 450px;
        height: 450px;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.08;
        z-index: 1;
        pointer-events: none;
    }
    .profile-glow-green { background: var(--color-blue-dark); top: -5%; left: -5%; }
    .profile-glow-saffron { background: var(--color-saffron-orange); bottom: -5%; right: -5%; }

    .profile-container {
        max-width: 960px;
        margin: 0 auto;
        width: 100%;
        position: relative;
        z-index: 5;
        padding: 0 var(--spacing-md);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: var(--spacing-xl);
        align-items: start;
    }

    .profile-sidebar {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
        text-align: center;
    }

    .profile-avatar-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-bottom: var(--spacing-sm);
    }

    .profile-avatar-circle {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--color-blue-dark);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-family: var(--font-secondary);
        font-weight: 700;
        border: 4px solid #fff;
        box-shadow: var(--shadow-md);
    }

    .profile-user-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0;
    }

    .profile-user-role {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--color-saffron-orange);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: -6px;
    }

    .profile-side-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
    }

    .profile-side-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--color-text-secondary);
        font-weight: 600;
        font-size: 0.92rem;
        transition: var(--transition-fast);
        cursor: pointer;
        text-decoration: none;
    }

    .profile-side-link:hover {
        background-color: rgba(1, 136, 73, 0.05);
        color: var(--color-blue-dark);
    }

    .profile-side-link.active {
        background-color: var(--color-blue-dark);
        color: #fff;
    }

    /* Ticket Thread Styling */
    .ticket-thread-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 24px;
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
    }

    .ticket-details-header {
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    .ticket-details-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ticket-details-subject {
        font-family: var(--font-secondary);
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0;
    }

    .ticket-details-meta {
        display: flex;
        gap: 15px;
        font-size: 0.82rem;
        color: var(--color-text-muted);
        margin-top: 6px;
        flex-wrap: wrap;
    }

    /* Message Bubbles */
    .messages-container {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-xl);
        max-height: 400px;
        overflow-y: auto;
        padding-right: 6px;
    }

    .message-bubble-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 80%;
    }

    .message-bubble-wrapper.customer-msg {
        align-self: flex-end;
    }

    .message-bubble-wrapper.agent-msg {
        align-self: flex-start;
    }

    .message-bubble {
        padding: 14px 18px;
        border-radius: 18px;
        font-size: 0.92rem;
        line-height: 1.5;
        position: relative;
    }

    .customer-msg .message-bubble {
        background-color: var(--color-blue-dark);
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    .agent-msg .message-bubble {
        background-color: var(--color-cream-dark);
        color: var(--color-blue-dark);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--color-border-light);
    }

    .message-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        color: var(--color-text-muted);
        margin-top: 4px;
        padding: 0 4px;
    }

    .agent-msg .message-info {
        justify-content: flex-start;
        gap: 8px;
    }

    .agent-badge-name {
        color: var(--color-brand-green-medium);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .reply-form-box {
        border-top: 1px solid var(--color-border-light);
        padding-top: var(--spacing-lg);
    }
</style>
@endsection

@section('content')
<main class="profile-page-wrap">
    <div class="profile-glow profile-glow-green"></div>
    <div class="profile-glow profile-glow-saffron"></div>

    <div class="profile-container">
        
        <div class="profile-grid">
            
            <!-- Sidebar Navigation -->
            <aside class="profile-sidebar">
                <div class="profile-avatar-section">
                    <div class="profile-avatar-circle">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h3 class="profile-user-name">{{ Auth::user()->name }}</h3>
                    <span class="profile-user-role">Al Barr Patron</span>
                </div>

                <ul class="profile-side-menu">
                    <li><a href="/profile" class="profile-side-link">👤 Personal Profile</a></li>
                    <li><a href="/orders" class="profile-side-link">📦 My Orders</a></li>
                    <li><a href="/wishlist" class="profile-side-link">❤️ My Wishlist</a></li>
                    <li><a href="/tickets" class="profile-side-link active">🎟️ Support Tickets</a></li>
                    <li><a href="/track-order" class="profile-side-link">📍 Track Shipment</a></li>
                    <li><a href="#" onclick="handleHeaderSignOut(event)" class="profile-side-link" style="color: var(--color-red);">🚪 Sign Out</a></li>
                </ul>
            </aside>

            <!-- Ticket Detail Column -->
            <div class="ticket-thread-card">
                
                <!-- Header details -->
                <div class="ticket-details-header">
                    <div class="ticket-details-title-row">
                        <h2 class="ticket-details-subject">{{ $ticket->subject }}</h2>
                        <span class="status-badge @if($ticket->status == 'Open') pending @elseif($ticket->status == 'In Progress') status-placed @elseif($ticket->status == 'Resolved') delivered @else status-cancelled @endif">
                            {{ $ticket->status }}
                        </span>
                    </div>
                    <div class="ticket-details-meta">
                        <span>Ticket: <strong style="font-family: monospace;">{{ $ticket->ticket_number }}</strong></span>
                        <span>Category: <strong>{{ $ticket->category }}</strong></span>
                        <span>Priority: <strong class="priority-indicator @if($ticket->priority == 'High') priority-high @elseif($ticket->priority == 'Medium') priority-medium @else priority-low @endif">{{ $ticket->priority }}</strong></span>
                        @if($ticket->assignedAgent)
                            <span>Assigned Agent: <strong>{{ $ticket->assignedAgent->name }}</strong></span>
                        @endif
                    </div>
                </div>

                <!-- Messages container -->
                <div class="messages-container" id="messagesBox">
                    @foreach($ticket->replies as $reply)
                        @php
                            $isAgent = $reply->user->role_id !== null && in_array($reply->user->role_id, [1, 2, 3, 4]);
                        @endphp
                        <div class="message-bubble-wrapper @if($isAgent) agent-msg @else customer-msg @endif">
                            <div class="message-bubble">
                                {{ $reply->message }}
                            </div>
                            <div class="message-info">
                                @if($isAgent)
                                    <span class="agent-badge-name">🌾 Support Desk Agent</span>
                                @endif
                                <span>{{ $reply->created_at->format('M d, h:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Reply Form -->
                <div class="reply-form-box">
                    @if($ticket->status == 'Closed')
                        <div style="background-color: var(--color-cream-dark); padding: 12px; border-radius: 8px; text-align: center; font-size: 0.9rem; color: var(--color-text-secondary);">
                            🔒 This support ticket has been closed. Sending a reply will automatically reopen this ticket.
                        </div>
                    @endif

                    <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <div class="admin-form-group">
                            <textarea name="message" rows="3" class="admin-input" placeholder="Type your response reply message here..." required minlength="2" style="border-radius: 12px; resize: none;"></textarea>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                            <a href="{{ route('tickets') }}" style="color: var(--color-text-muted); font-size: 0.9rem; text-decoration: underline;">&larr; Back to Tickets</a>
                            <button type="submit" class="btn btn-gold" style="padding: 10px 24px; border-radius: 12px;">
                                ✉️ Send Reply
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Auto scroll messages to the bottom
        const box = document.getElementById('messagesBox');
        if (box) {
            box.scrollTop = box.scrollHeight;
        }
    });
</script>
@endsection
