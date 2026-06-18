@extends('layouts.app')

@section('title', 'My Orders - Al Barr | Kashmiri Organic Staples')

@section('styles')
<style>
    .profile-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        min-height: 80vh;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Glow Spheres */
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

    /* Account Switch Tab Layout */
    .profile-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: var(--spacing-xl);
        align-items: start;
    }

    /* Sidebar Navigation */
    .profile-sidebar {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
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
        position: relative;
        cursor: pointer;
        transition: var(--transition-fast);
    }

    .profile-avatar-circle:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(1, 136, 73, 0.2);
    }

    .profile-avatar-edit-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--color-saffron-orange);
        color: #fff;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        border: 2px solid #fff;
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

    /* Order Cards List */
    .orders-list-container {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .order-history-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: transform var(--transition-fast), box-shadow var(--transition-fast);
    }

    .order-history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(11, 19, 17, 0.06);
    }

    .order-card-header {
        background-color: var(--color-cream-light);
        border-bottom: 1px solid var(--color-border-light);
        padding: var(--spacing-md) var(--spacing-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-header-info {
        display: flex;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .order-header-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .order-meta-lbl {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-meta-val {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    .order-id-val {
        font-family: monospace;
        font-size: 0.95rem;
        letter-spacing: 0.2px;
        color: var(--color-blue-dark);
    }

    .order-status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-placed { background: #E6F5EC; color: #018849; }
    .status-processed { background: #FFF8E1; color: #FF8F00; }
    .status-shipped { background: #FFF3E0; color: #FF5500; }
    .status-out { background: #E3F2FD; color: #0D47A1; }
    .status-delivered { background: #E8F5E9; color: #2E7D32; }
    .status-cancelled { background: #FFEBEE; color: #C62828; }

    .order-card-body {
        padding: var(--spacing-lg);
    }

    .order-items-list {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .order-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--spacing-md);
        padding-bottom: var(--spacing-sm);
        border-bottom: 1px dashed var(--color-border-light);
    }

    .order-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .order-item-details {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .order-item-thumb {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: contain;
        background-color: var(--color-cream);
        border: 1px solid var(--color-border-light);
    }

    .order-item-name {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    .order-item-meta {
        font-size: 0.78rem;
        color: var(--color-text-muted);
        margin-top: 1px;
    }

    .order-item-price {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    .order-card-footer {
        border-top: 1px solid var(--color-border-light);
        padding: var(--spacing-md) var(--spacing-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-md);
        background-color: #fafbfc;
    }

    .order-footer-total {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-blue-dark);
    }

    .order-footer-total span {
        color: var(--color-text-secondary);
        font-weight: 500;
        font-size: 0.88rem;
        margin-right: 4px;
    }

    .order-actions-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-order-action {
        padding: 8px 16px;
        font-size: 0.82rem;
        font-weight: 700;
        border-radius: var(--radius-xs);
        cursor: pointer;
        transition: var(--transition-fast);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1.5px solid transparent;
        font-family: var(--font-secondary);
        text-decoration: none;
    }

    .btn-action-primary {
        background: var(--color-saffron-gradient);
        color: #fff;
        box-shadow: 0 4px 10px rgba(255, 85, 0, 0.15);
    }

    .btn-action-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(255, 85, 0, 0.25);
    }

    .btn-action-secondary {
        background: #fff;
        border-color: var(--color-border);
        color: var(--color-text-primary);
    }

    .btn-action-secondary:hover {
        background-color: var(--color-cream);
        border-color: var(--color-text-secondary);
    }

    .btn-action-danger {
        background: #fff;
        border-color: #ffcdd2;
        color: #c62828;
    }

    .btn-action-danger:hover {
        background-color: #ffebee;
        border-color: #e57373;
    }

    /* Delivered Ratings Panel */
    .rating-feedback-row {
        margin-top: var(--spacing-sm);
        padding: 10px var(--spacing-md);
        background-color: #f7f9f6;
        border-radius: var(--radius-xs);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        border: 1px solid rgba(1, 136, 73, 0.08);
    }

    .rating-feedback-lbl {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--color-blue-dark);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rating-stars-interactive {
        display: flex;
        gap: 4px;
    }

    .star-item {
        font-size: 1.2rem;
        color: var(--color-border);
        cursor: pointer;
        transition: transform 0.15s ease, color 0.15s ease;
    }

    .star-item:hover {
        transform: scale(1.15);
    }

    .star-item.selected {
        color: #FFB300;
    }

    /* Empty State */
    .orders-empty-state {
        text-align: center;
        padding: var(--spacing-xxl) var(--spacing-md);
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 24px;
        box-shadow: var(--shadow-md);
    }

    .empty-state-icon {
        font-size: 3.5rem;
        margin-bottom: var(--spacing-md);
    }

    .empty-state-title {
        font-family: var(--font-secondary);
        font-size: 1.4rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-state-text {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        max-width: 400px;
        margin: 0 auto var(--spacing-lg) auto;
        line-height: 1.45;
    }

    .btn-empty-shop {
        display: inline-flex;
        padding: 12px 28px;
        background: var(--color-saffron-gradient);
        color: #fff;
        border-radius: var(--radius-xs);
        font-weight: 700;
        font-family: var(--font-secondary);
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
        transition: var(--transition-fast);
        text-decoration: none;
    }

    .btn-empty-shop:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
    }

    /* Modal Overlay for cancel order */
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
        max-width: 440px;
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

    .cancel-modal-text {
        font-size: 0.92rem;
        color: var(--color-text-secondary);
        line-height: 1.5;
        margin-bottom: var(--spacing-md);
    }

    .cancel-reason-input {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-size: 0.9rem;
        color: var(--color-text-primary);
        margin-bottom: var(--spacing-md);
        resize: none;
    }

    .cancel-reason-input:focus {
        border-color: var(--color-blue-medium);
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
        background-color: #c62828;
        color: #fff;
        box-shadow: 0 4px 10px rgba(198, 40, 40, 0.2);
    }

    #invoice-print-frame {
        display: none;
    }

    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .order-card-footer {
            flex-direction: column;
            align-items: flex-start;
        }
        .order-actions-group {
            width: 100%;
        }
        .btn-order-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<main class="profile-page-wrap">
    <!-- Floating spheres -->
    <div class="profile-glow profile-glow-green"></div>
    <div class="profile-glow profile-glow-saffron"></div>

    <div class="profile-container">
        
        <!-- Logged-in Dashboard View -->
        <div id="profile-dashboard-view">
            <div class="profile-header">
                <h1 class="profile-title">My Orders</h1>
                <p class="profile-subtitle">Track shipment checkpoints, cancel active packages, download itemized tax receipts, and leave feedback.</p>
            </div>

            <div class="profile-grid">
                
                <!-- Left: Navigation Sidebar -->
                <aside class="profile-sidebar">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar-circle" id="profile-avatar-img" onclick="triggerAvatarRegen()">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            <div class="profile-avatar-edit-badge" title="Regenerate theme background">♻️</div>
                        </div>
                        <h3 class="profile-user-name" id="profile-display-name">{{ Auth::user()->name }}</h3>
                        <span class="profile-user-role">Al Barr Patron</span>
                    </div>

                    <ul class="profile-side-menu">
                        <li><a href="/profile" class="profile-side-link">👤 Personal Profile</a></li>
                        <li><a href="/orders" class="profile-side-link active">📦 My Orders</a></li>
                        <li><a href="/wishlist" class="profile-side-link">❤️ My Wishlist</a></li>
                        <li><a href="/tickets" class="profile-side-link">🎟️ Support Tickets</a></li>
                        <li><a href="/track-order" class="profile-side-link">📍 Track Shipment</a></li>
                        <li><a href="#" onclick="handleHeaderSignOut(event)" class="profile-side-link" style="color: var(--color-red);">🚪 Sign Out</a></li>
                    </ul>
                </aside>

                <!-- Right: Orders History list -->
                <div class="orders-list-container" id="orders-list-container">
                    @if ($orders->isEmpty())
                        <div class="orders-empty-state">
                            <div class="empty-state-icon">📦</div>
                            <h3 class="empty-state-title">No Orders Placed Yet</h3>
                            <p class="empty-state-text">Your kitchen shelves are waiting for Al Barr organic staples! Visit our shop to get fresh Mamra almonds, saffron, and kehwa.</p>
                            <a href="/shop" class="btn-empty-shop">Browse Products</a>
                        </div>
                    @else
                        @foreach ($orders as $order)
                            @php
                                $status = strtolower($order->status);
                                $statusClass = 'status-placed';
                                $statusIcon = '📥';
                                if ($status === 'processed' || $status === 'processing') { $statusClass = 'status-processed'; $statusIcon = '⚙️'; }
                                elseif ($status === 'shipped') { $statusClass = 'status-shipped'; $statusIcon = '🚚'; }
                                elseif ($status === 'delivered') { $statusClass = 'status-delivered'; $statusIcon = '🎁'; }
                                elseif ($status === 'cancelled') { $statusClass = 'status-cancelled'; $statusIcon = '❌'; }
                            @endphp
                            <div class="order-history-card" data-order-id="{{ $order->order_number }}">
                                <div class="order-card-header">
                                    <div class="order-header-info">
                                        <div class="order-header-meta">
                                            <span class="order-meta-lbl">Order Placed</span>
                                            <span class="order-meta-val">{{ $order->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="order-header-meta">
                                            <span class="order-meta-lbl">Total Price</span>
                                            <span class="order-meta-val">₹{{ number_format($order->grand_total, 2) }}</span>
                                        </div>
                                        <div class="order-header-meta">
                                            <span class="order-meta-lbl">Order ID</span>
                                            <span class="order-meta-val order-id-val">{{ $order->order_number }}</span>
                                        </div>
                                    </div>
                                    <span class="order-status-badge {{ $statusClass }}">
                                        {{ $statusIcon }} {{ $order->status }}
                                    </span>
                                </div>
                                <div class="order-card-body">
                                    <div class="order-items-list">
                                        @foreach ($order->items as $item)
                                            <div class="order-item-row">
                                                <div class="order-item-details">
                                                    <img src="/{{ $item->variant->product->image ?? 'assets/img/almonds.png' }}" alt="{{ $item->title }}" class="order-item-thumb" @if (($item->variant->product->id ?? 0) === 4) style="filter: hue-rotate(45deg);" @endif>
                                                    <div>
                                                        <div class="order-item-name">{{ $item->title }}</div>
                                                        <div class="order-item-meta">Weight: {{ $item->weight }} | Qty: {{ $item->quantity }}</div>
                                                    </div>
                                                </div>
                                                <span class="order-item-price">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if ($status === 'delivered')
                                        <div class="rating-feedback-row">
                                            <span class="rating-feedback-lbl">Rate freshness & delivery:</span>
                                            <div class="rating-stars-interactive" data-order-id="{{ $order->order_number }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star-item" onclick="saveOrderRating('{{ $order->order_number }}', {{ $i }}, {{ $order->items->first()->variant->product->id ?? 1 }})" title="Rate {{ $i }} Stars">★</span>
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="order-card-footer">
                                    <div class="order-footer-total">
                                        <span>Paid via:</span> {{ $order->payment_method }}
                                    </div>
                                    <div class="order-actions-group">
                                        <button class="btn-order-action btn-action-secondary" onclick="printInvoice('{{ $order->order_number }}')">📄 Invoice</button>
                                        
                                        @if ($status !== 'cancelled')
                                            <a href="/track-order?order_number={{ $order->order_number }}" class="btn-order-action btn-action-primary">📍 Track Order</a>
                                        @endif

                                        @if (in_array($status, ['pending', 'confirmed', 'processing']))
                                            <button class="btn-order-action btn-action-danger" onclick="triggerCancelModal('{{ $order->order_number }}')">❌ Cancel</button>
                                        @endif

                                        @if ($status === 'delivered')
                                            <button class="btn-order-action btn-action-danger" onclick="triggerReturnModal('{{ $order->order_number }}')">🔄 Request Return</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

        </div>

    </div>
</main>

<!-- Cancel Order Confirmation Modal -->
<div class="cancel-modal-overlay" id="cancel-modal">
    <div class="cancel-modal-card">
        <div class="cancel-modal-header">
            <h3 class="cancel-modal-title">Confirm Order Cancellation</h3>
            <button class="cancel-modal-close" onclick="closeCancelModal()">×</button>
        </div>
        <div class="cancel-modal-body">
            <p class="cancel-modal-text">Are you sure you want to cancel this order? Once cancelled, the orchard dispatch pipeline is halted immediately.</p>
            <label for="cancel-reason" class="order-meta-lbl" style="display:block; margin-bottom: 6px;">Reason for Cancellation (Optional)</label>
            <textarea id="cancel-reason" rows="3" class="cancel-reason-input" placeholder="e.g. Ordered incorrect weight / Changed mind"></textarea>
        </div>
        <div class="cancel-modal-footer">
            <button class="btn-modal-cancel" onclick="closeCancelModal()">Keep Order</button>
            <button class="btn-modal-confirm" id="btn-confirm-cancel-action">Cancel Order</button>
        </div>
    </div>
</div>

<!-- Return Order Confirmation Modal -->
<div class="cancel-modal-overlay" id="return-modal">
    <div class="cancel-modal-card">
        <div class="cancel-modal-header">
            <h3 class="cancel-modal-title">Request Return &amp; Refund</h3>
            <button class="cancel-modal-close" onclick="closeReturnModal()">×</button>
        </div>
        <form id="return-submit-form" onsubmit="submitReturnRequest(event)" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="return-order-number" name="order_number">
            <div class="cancel-modal-body" style="max-height: 400px; overflow-y: auto;">
                <p class="cancel-modal-text">To process your return, please select a reason and upload photos showing damaged items or seals.</p>
                
                <div class="admin-form-group" style="margin-bottom: 12px; display: flex; flex-direction: column; gap: 4px;">
                    <label for="return-reason-select" class="order-meta-lbl">Reason for Return *</label>
                    <select id="return-reason-select" name="reason_select" class="admin-select" style="padding: 10px; border-radius: 8px; border: 1.5px solid var(--color-border);" required>
                        <option value="Damaged products on arrival">Damaged products on arrival</option>
                        <option value="Wrong item variant received">Wrong item variant received</option>
                        <option value="Broken seals / opened package">Broken seals / opened package</option>
                        <option value="Item not fresh / quality issue">Item not fresh / quality issue</option>
                        <option value="Other">Other (Please describe below)</option>
                    </select>
                </div>

                <div class="admin-form-group" style="margin-bottom: 12px; display: flex; flex-direction: column; gap: 4px;">
                    <label for="return-explanation" class="order-meta-lbl">Detailed Explanation *</label>
                    <textarea id="return-explanation" name="explanation" rows="3" class="cancel-reason-input" placeholder="Explain the defect/damage in detail..." style="margin-bottom: 0;" required></textarea>
                </div>

                <div class="admin-form-group" style="margin-bottom: 0; display: flex; flex-direction: column; gap: 4px;">
                    <label for="return-evidence" class="order-meta-lbl">Upload Evidence Photos (Max 3, max 2MB each)</label>
                    <input type="file" id="return-evidence" name="evidence[]" class="admin-input" accept="image/*" multiple style="padding: 8px; border-radius: 8px; border: 1.5px solid var(--color-border);">
                </div>
            </div>
            <div class="cancel-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeReturnModal()">Cancel</button>
                <button type="submit" class="btn-modal-confirm" id="btn-confirm-return-action" style="background-color: var(--color-brand-green); box-shadow: 0 4px 10px rgba(1, 136, 73, 0.2);">Submit Request</button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden iframe for silent printing of invoice -->
<iframe id="invoice-print-frame"></iframe>
@endsection

@section('scripts')
<script>
    let currentCancelOrderId = null;
    const AVATAR_PALETTES = [
        { bg: '#018849', color: '#ffffff' },
        { bg: '#FF5500', color: '#ffffff' },
        { bg: '#FFB300', color: '#000000' },
        { bg: '#0b192c', color: '#ffffff' },
        { bg: '#4a3f35', color: '#ffffff' }
    ];

    document.addEventListener('DOMContentLoaded', () => {
        // Restore avatar color choice if saved
        const savedColorIdx = localStorage.getItem('al_barr_avatar_color_idx') || 0;
        applyAvatarPalette(savedColorIdx);
    });

    function applyAvatarPalette(idx) {
        const palette = AVATAR_PALETTES[idx] || AVATAR_PALETTES[0];
        const avatarDiv = document.getElementById('profile-avatar-img');
        if (avatarDiv) {
            avatarDiv.style.backgroundColor = palette.bg;
            avatarDiv.style.color = palette.color;
        }
    }

    function triggerAvatarRegen() {
        const currentIdx = parseInt(localStorage.getItem('al_barr_avatar_color_idx') || 0);
        const nextIdx = (currentIdx + 1) % AVATAR_PALETTES.length;
        localStorage.setItem('al_barr_avatar_color_idx', nextIdx);
        applyAvatarPalette(nextIdx);
        
        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
            AlBarrCart.showToast('Profile theme accent updated!');
        }
    }

    // Cancel order modal triggers
    function triggerCancelModal(orderId) {
        currentCancelOrderId = orderId;
        document.getElementById('cancel-reason').value = '';
        document.getElementById('cancel-modal').style.display = 'flex';
    }

    function closeCancelModal() {
        document.getElementById('cancel-modal').style.display = 'none';
        currentCancelOrderId = null;
    }

    // Action cancellation handler making post call to Laravel
    document.getElementById('btn-confirm-cancel-action').addEventListener('click', () => {
        if (!currentCancelOrderId) return;
        
        const btn = document.getElementById('btn-confirm-cancel-action');
        btn.disabled = true;
        btn.innerText = 'Cancelling...';

        fetch('/orders/cancel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                order_id: currentCancelOrderId,
                reason: document.getElementById('cancel-reason').value.trim()
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(`Order ${currentCancelOrderId} cancelled successfully.`, 'error');
                } else {
                    alert(`Order ${currentCancelOrderId} cancelled successfully.`);
                }
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert(body.error || 'Failed to cancel order.');
                window.location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong. Please try again.');
            window.location.reload();
        });
    });

    // Save rating feedback simulation (or review submission)
    function saveOrderRating(orderId, ratingVal, productId) {
        const comment = prompt("Optional: Leave a brief comment about the product freshness or delivery:");
        if (comment === null) return; // User clicked Cancel

        // UI rating response
        const starsContainer = document.querySelector(`.rating-stars-interactive[data-order-id="${orderId}"]`);
        if (starsContainer) {
            const stars = starsContainer.querySelectorAll('.star-item');
            stars.forEach((star, idx) => {
                if (idx < ratingVal) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        fetch('/reviews', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                rating: ratingVal,
                comment: comment
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(body.message, 'success');
                } else {
                    alert(body.message);
                }
            } else {
                alert(body.error || 'Failed to submit review.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong. Please try again.');
        });
    }

    // Print Invoice fetching values directly from database or dynamically computed
    function printInvoice(orderId) {
        // Redirect to print invoice layout or trigger standard print layout
        // We will generate the invoice content dynamically
        alert("Generating dynamic tax invoice PDF...");
        window.open(`/checkout?print=1&order=${orderId}`, '_blank');
    }

    // Return request modal triggers
    function triggerReturnModal(orderId) {
        document.getElementById('return-order-number').value = orderId;
        document.getElementById('return-explanation').value = '';
        document.getElementById('return-evidence').value = '';
        document.getElementById('return-reason-select').value = 'Damaged products on arrival';
        document.getElementById('return-modal').style.display = 'flex';
    }

    function closeReturnModal() {
        document.getElementById('return-modal').style.display = 'none';
    }

    function submitReturnRequest(event) {
        event.preventDefault();
        
        const btn = document.getElementById('btn-confirm-return-action');
        btn.disabled = true;
        btn.innerText = 'Submitting...';

        const form = document.getElementById('return-submit-form');
        const formData = new FormData(form);
        
        // Append reason compiled
        const reasonSelect = document.getElementById('return-reason-select').value;
        const explanation = document.getElementById('return-explanation').value.trim();
        formData.set('reason', `${reasonSelect}: ${explanation}`);

        fetch('/orders/return', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
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
                alert(body.error || 'Failed to submit return request.');
                btn.disabled = false;
                btn.innerText = 'Submit Request';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.innerText = 'Submit Request';
        });
    }
</script>
@endsection
