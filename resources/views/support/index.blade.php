@extends('layouts.app')

@section('title', 'Customer Support Tickets - Al Barr')

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

    .profile-header {
        text-align: center;
        margin-bottom: var(--spacing-xl);
    }

    .profile-title {
        font-family: var(--font-secondary);
        font-size: 2.3rem;
        color: var(--color-blue-dark);
        font-weight: 800;
        margin-bottom: 8px;
    }

    .profile-subtitle {
        color: var(--color-text-secondary);
        font-size: 1.02rem;
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

    /* Support Tickets Content list styling */
    .tickets-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-lg);
    }

    .tickets-card-container {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .ticket-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.25s ease;
        text-decoration: none;
        color: inherit;
    }

    .ticket-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-brand-green-medium);
    }

    .ticket-main-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .ticket-title {
        font-family: var(--font-secondary);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        margin: 0;
    }

    .ticket-meta {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        display: flex;
        gap: 12px;
    }

    .priority-indicator {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .priority-high { color: #dc3545; }
    .priority-medium { color: var(--color-gold-hover); }
    .priority-low { color: var(--color-brand-green); }

    /* Modals elements */
    .cancel-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(11, 25, 44, 0.6);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-md);
    }

    .cancel-modal-card {
        background-color: #fff;
        border-radius: 24px;
        width: 100%;
        max-width: 500px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--color-border);
        overflow: hidden;
        animation: modalScaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    @keyframes modalScaleUp {
        from { opacity: 0; transform: scale(0.92); }
        to { opacity: 1; transform: scale(1); }
    }

    .cancel-modal-header {
        padding: var(--spacing-lg) var(--spacing-lg) 10px var(--spacing-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cancel-modal-title {
        font-family: var(--font-secondary);
        font-size: 1.25rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin: 0;
    }

    .cancel-modal-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--color-text-muted);
    }

    .cancel-modal-body {
        padding: 0 var(--spacing-lg) var(--spacing-lg) var(--spacing-lg);
    }

    .admin-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: var(--spacing-md);
    }

    .admin-form-group label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-text-secondary);
    }

    .admin-select, .admin-input {
        padding: 10px 14px;
        border: 1.5px solid var(--color-border);
        border-radius: 10px;
        font-size: 0.92rem;
        background-color: var(--color-cream);
        color: var(--color-text-primary);
        transition: all 0.3s ease;
    }

    .admin-select:focus, .admin-input:focus {
        border-color: var(--color-brand-green);
        background-color: #fff;
        outline: none;
    }

    .cancel-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: var(--spacing-md) var(--spacing-lg);
        background-color: var(--color-cream-light);
        border-top: 1px solid var(--color-border-light);
    }

    .btn-modal-cancel {
        padding: 9px 18px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: var(--radius-xs);
        cursor: pointer;
        border: 1.5px solid var(--color-border);
        background-color: #fff;
        color: var(--color-text-primary);
    }

    .btn-modal-confirm {
        padding: 9px 18px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: var(--radius-xs);
        cursor: pointer;
        border: none;
        background-color: var(--color-brand-green);
        color: #fff;
        box-shadow: 0 4px 10px rgba(1, 136, 73, 0.2);
    }
</style>
@endsection

@section('content')
<main class="profile-page-wrap">
    <!-- Floating spheres -->
    <div class="profile-glow profile-glow-green"></div>
    <div class="profile-glow profile-glow-saffron"></div>

    <div class="profile-container">
        
        <div class="profile-header">
            <h1 class="profile-title">Support Tickets</h1>
            <p class="profile-subtitle">Open tickets, review updates from agents, and send replies directly to customer support.</p>
        </div>

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

            <!-- Support Tickets List Column -->
            <div>
                <div class="tickets-header-bar">
                    <h2 style="font-family: var(--font-secondary); font-size: 1.4rem; color: var(--color-blue-dark); font-weight: 700;">Support History</h2>
                    <button class="btn btn-gold" onclick="triggerTicketModal()" style="border-radius: 12px; padding: 10px 20px;">
                        ➕ Open Support Ticket
                    </button>
                </div>

                <div class="tickets-card-container">
                    @forelse($tickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="ticket-card">
                            <div class="ticket-main-info">
                                <h3 class="ticket-title">{{ $ticket->subject }}</h3>
                                <div class="ticket-meta">
                                    <span style="font-family: monospace; font-weight: bold; color: var(--color-blue-dark);">{{ $ticket->ticket_number }}</span>
                                    <span>Category: <strong>{{ $ticket->category }}</strong></span>
                                    <span>Priority: <strong class="priority-indicator @if($ticket->priority == 'High') priority-high @elseif($ticket->priority == 'Medium') priority-medium @else priority-low @endif">{{ $ticket->priority }}</strong></span>
                                    <span>Last Updated: {{ $ticket->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div>
                                <span class="status-badge @if($ticket->status == 'Open') pending @elseif($ticket->status == 'In Progress') status-placed @elseif($ticket->status == 'Resolved') delivered @else status-cancelled @endif" style="font-size: 0.8rem;">
                                    {{ $ticket->status }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="orders-empty-state" style="padding: var(--spacing-xl) var(--spacing-md);">
                            <div class="empty-state-icon">🎟️</div>
                            <h3 class="empty-state-title">No Support Tickets Found</h3>
                            <p class="empty-state-text">If you have any issues with orders, payments, packaging, or product details, open a support ticket here. We are happy to assist you!</p>
                            <button class="btn btn-gold" onclick="triggerTicketModal()" style="border-radius: 12px;">Open New Support Ticket</button>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</main>

<!-- Create Ticket Form Modal -->
<div class="cancel-modal-overlay" id="ticket-modal">
    <div class="cancel-modal-card">
        <div class="cancel-modal-header">
            <h3 class="cancel-modal-title">Open Support Ticket</h3>
            <button class="cancel-modal-close" onclick="closeTicketModal()">×</button>
        </div>
        <form id="ticket-submit-form" onsubmit="submitSupportTicket(event)">
            @csrf
            <div class="cancel-modal-body">
                <p class="cancel-modal-text" style="font-size: 0.88rem; line-height: 1.5; color: var(--color-text-secondary); margin-bottom: var(--spacing-md);">
                    Please describe your concern, and our executive support desk will coordinate feedback.
                </p>

                <!-- Subject -->
                <div class="admin-form-group">
                    <label for="tk-subject">Ticket Subject *</label>
                    <input type="text" id="tk-subject" name="subject" class="admin-input" placeholder="e.g. Broken saffron container seal" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                    <!-- Category -->
                    <div class="admin-form-group">
                        <label for="tk-category">Category *</label>
                        <select id="tk-category" name="category" class="admin-select" required>
                            <option value="Order Issue">Order Issue</option>
                            <option value="Product Query">Product Query</option>
                            <option value="Payment Help">Payment Help</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div class="admin-form-group">
                        <label for="tk-priority">Priority *</label>
                        <select id="tk-priority" name="priority" class="admin-select" required>
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                </div>

                <!-- Message -->
                <div class="admin-form-group" style="margin-bottom: 0;">
                    <label for="tk-message">Detailed Message *</label>
                    <textarea id="tk-message" name="message" rows="4" class="admin-input" placeholder="Describe your issue or request in detail..." style="resize: none;" required minlength="10"></textarea>
                </div>
            </div>
            
            <div class="cancel-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeTicketModal()">Cancel</button>
                <button type="submit" class="btn-modal-confirm" id="btn-submit-ticket-action">Open Ticket</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function triggerTicketModal() {
        document.getElementById('tk-subject').value = '';
        document.getElementById('tk-message').value = '';
        document.getElementById('tk-category').value = 'Order Issue';
        document.getElementById('tk-priority').value = 'Medium';
        document.getElementById('ticket-modal').style.display = 'flex';
    }

    function closeTicketModal() {
        document.getElementById('ticket-modal').style.display = 'none';
    }

    function submitSupportTicket(event) {
        event.preventDefault();
        
        const btn = document.getElementById('btn-submit-ticket-action');
        btn.disabled = true;
        btn.innerText = 'Creating...';

        const form = document.getElementById('ticket-submit-form');
        const formData = new FormData(form);

        const payload = {
            subject: formData.get('subject'),
            category: formData.get('category'),
            priority: formData.get('priority'),
            message: formData.get('message')
        };

        fetch('/tickets', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(body.message, 'success');
                } else {
                    alert(body.message);
                }
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                alert(body.error || 'Failed to open support ticket.');
                btn.disabled = false;
                btn.innerText = 'Open Ticket';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.innerText = 'Open Ticket';
        });
    }
</script>
@endsection
