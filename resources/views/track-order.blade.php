@extends('layouts.app')

@section('title', 'Track Shipment - Al Barr | Kashmiri Organic Staples')

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

    .track-container {
        max-width: 900px;
        margin: 0 auto;
        width: 100%;
        position: relative;
        z-index: 5;
        padding: 0 var(--spacing-md);
    }

    .track-header {
        text-align: center;
        margin-bottom: var(--spacing-xl);
    }

    .track-title {
        font-family: var(--font-secondary);
        font-size: 2.4rem;
        color: var(--color-blue-dark);
        font-weight: 800;
        margin-bottom: 8px;
    }

    .track-subtitle {
        color: var(--color-text-secondary);
        font-size: 1.05rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* Lookup Glassmorphic Card */
    .track-search-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        padding: var(--spacing-xl) var(--spacing-lg);
        box-shadow: 0 20px 45px rgba(11, 19, 17, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.6);
        margin-bottom: var(--spacing-xl);
    }

    .track-search-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: var(--spacing-md);
        align-items: flex-end;
    }

    .track-input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        text-align: left;
    }

    .track-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .track-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .track-input-icon {
        position: absolute;
        left: 14px;
        color: var(--color-text-muted);
        pointer-events: none;
        display: flex;
        align-items: center;
    }

    .track-input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        background-color: rgba(255, 255, 255, 0.9);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-size: 0.95rem;
        color: var(--color-text-primary);
        transition: var(--transition-fast);
    }

    .track-input:focus {
        border-color: var(--color-blue-medium);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(2, 154, 77, 0.1);
        outline: none;
    }

    .btn-track-submit {
        height: 48px;
        padding: 0 28px;
        background: var(--color-saffron-gradient);
        color: #fff;
        border: none;
        border-radius: var(--radius-xs);
        font-weight: 700;
        font-family: var(--font-secondary);
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition-fast);
        box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-track-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
    }

    /* Results Wrap */
    .track-results-wrap {
        margin-top: var(--spacing-xl);
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .results-summary-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        text-align: left;
        position: relative;
        overflow: hidden;
    }

    .results-summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--color-gold-gradient);
    }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    .summary-title-block {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .summary-order-id {
        font-family: monospace;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-blue-dark);
        letter-spacing: 0.5px;
    }

    .summary-order-date {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
    }

    .summary-status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-placed { background: #E6F5EC; color: #018849; }
    .status-processed { background: #FFF8E1; color: #FF8F00; }
    .status-shipped { background: #FFF3E0; color: #FF5500; }
    .status-out { background: #E3F2FD; color: #0D47A1; }
    .status-delivered { background: #E8F5E9; color: #2E7D32; }
    .status-cancelled { background: #FFEBEE; color: #C62828; }

    .summary-details-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }

    .summary-grid-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .grid-item-lbl {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .grid-item-val {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    /* Stepper Widget */
    .stepper-container {
        position: relative;
        padding: var(--spacing-md) 0 var(--spacing-lg) 0;
        margin-bottom: var(--spacing-lg);
    }

    .stepper-progress-bar {
        position: absolute;
        top: 28px;
        left: 5%;
        width: 90%;
        height: 5px;
        background-color: var(--color-border-light);
        z-index: 1;
        border-radius: 3px;
    }

    .stepper-progress-fill {
        height: 100%;
        background: var(--color-gold-gradient);
        border-radius: 3px;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stepper-nodes {
        position: relative;
        display: flex;
        justify-content: space-between;
        z-index: 2;
    }

    .stepper-node {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 18%;
    }

    .stepper-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #fff;
        border: 3.5px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: var(--color-text-muted);
        transition: var(--transition-normal);
        box-shadow: var(--shadow-sm);
    }

    .stepper-node.active .stepper-circle {
        border-color: var(--color-blue-medium);
        color: var(--color-blue-dark);
        background-color: var(--color-blue-light);
        box-shadow: 0 0 0 6px rgba(2, 154, 77, 0.15);
    }

    .stepper-node.completed .stepper-circle {
        border-color: var(--color-blue-dark);
        background-color: var(--color-blue-dark);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .stepper-node.completed .stepper-circle svg {
        stroke: #fff;
    }

    .stepper-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-text-secondary);
        margin-top: 10px;
        transition: var(--transition-fast);
    }

    .stepper-node.active .stepper-label {
        color: var(--color-blue-dark);
        font-weight: 800;
    }

    .stepper-node.completed .stepper-label {
        color: var(--color-text-primary);
    }

    .stepper-date {
        font-size: 0.72rem;
        color: var(--color-text-muted);
        margin-top: 3px;
    }

    /* Route Timeline Section */
    .route-tracking-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        text-align: left;
    }

    .route-title {
        font-family: var(--font-secondary);
        font-size: 1.25rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .route-timeline {
        position: relative;
        padding-left: 28px;
        margin-left: 10px;
        border-left: 2px dashed var(--color-border);
    }

    .route-checkpoint {
        position: relative;
        margin-bottom: var(--spacing-lg);
    }

    .route-checkpoint:last-child {
        margin-bottom: 0;
    }

    .checkpoint-dot {
        position: absolute;
        left: -39px;
        top: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #fff;
        border: 3.5px solid var(--color-border);
        transition: var(--transition-fast);
    }

    .route-checkpoint.active .checkpoint-dot {
        border-color: var(--color-saffron-orange);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(255, 85, 0, 0.2);
        animation: checkpointPulse 1.5s infinite;
    }

    .route-checkpoint.completed .checkpoint-dot {
        border-color: var(--color-blue-dark);
        background-color: var(--color-blue-dark);
    }

    @keyframes checkpointPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }

    .checkpoint-meta {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 4px;
        flex-wrap: wrap;
        gap: 6px;
    }

    .checkpoint-location {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    .route-checkpoint.active .checkpoint-location {
        color: var(--color-saffron-orange);
    }

    .checkpoint-time {
        font-size: 0.78rem;
        color: var(--color-text-muted);
    }

    .checkpoint-desc {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
        line-height: 1.4;
    }

    /* Order Items & Receipt Section */
    .track-details-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: var(--spacing-lg);
    }

    .items-receipt-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        text-align: left;
    }

    .receipt-title {
        font-family: var(--font-secondary);
        font-size: 1.25rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .receipt-items-list {
        margin-bottom: var(--spacing-md);
    }

    .receipt-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed var(--color-border-light);
    }

    .receipt-item-row:last-child {
        border-bottom: none;
    }

    .receipt-item-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .receipt-item-thumb {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-xs);
        object-fit: contain;
        background-color: var(--color-cream);
        border: 1px solid var(--color-border-light);
    }

    .receipt-item-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--color-text-primary);
    }

    .receipt-item-qty {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        margin-top: 1px;
    }

    .receipt-item-price {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--color-text-primary);
    }

    .receipt-breakdown {
        background-color: var(--color-cream);
        border-radius: var(--radius-xs);
        padding: var(--spacing-md);
    }

    .receipt-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        color: var(--color-text-secondary);
        margin-bottom: 6px;
    }

    .receipt-row:last-child {
        margin-bottom: 0;
    }

    .receipt-row.discount {
        color: var(--color-blue-medium);
        font-weight: 500;
    }

    .receipt-row.total {
        border-top: 1px solid var(--color-border);
        padding-top: 8px;
        margin-top: 8px;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-blue-dark);
    }

    .customer-shipping-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        text-align: left;
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .customer-card-title {
        font-family: var(--font-secondary);
        font-size: 1.25rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .customer-info-section {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .customer-info-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .customer-info-val {
        font-size: 0.95rem;
        color: var(--color-text-primary);
        line-height: 1.45;
    }

    /* Empty / Initial State */
    .track-initial-state {
        padding: var(--spacing-xl) 0;
        text-align: center;
    }

    .track-initial-icon {
        font-size: 3.5rem;
        margin-bottom: var(--spacing-sm);
    }

    .track-initial-title {
        font-family: var(--font-secondary);
        font-size: 1.4rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .track-initial-text {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        max-width: 420px;
        margin: 0 auto;
        line-height: 1.45;
    }

    .track-demo-tags {
        margin-top: var(--spacing-md);
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .demo-tag {
        background-color: #fff;
        border: 1px solid var(--color-border);
        color: var(--color-blue-dark);
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-fast);
    }

    .demo-tag:hover {
        border-color: var(--color-blue-medium);
        background-color: var(--color-blue-light);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .track-search-form {
            grid-template-columns: 1fr;
            gap: var(--spacing-sm);
        }
        
        .btn-track-submit {
            width: 100%;
            margin-top: 6px;
        }

        .summary-details-grid {
            grid-template-columns: 1fr;
            gap: var(--spacing-sm);
        }

        .stepper-container {
            overflow-x: auto;
            padding-bottom: var(--spacing-md);
        }

        .stepper-progress-bar {
            width: 650px;
            left: 20px;
        }

        .stepper-nodes {
            width: 700px;
            padding: 0 10px;
        }

        .track-details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<main class="profile-page-wrap">
    <!-- Ambient backgrounds -->
    <div class="profile-glow profile-glow-green"></div>
    <div class="profile-glow profile-glow-saffron"></div>

    <div class="track-container">
        
        <div class="track-header">
            <h1 class="track-title">Track Shipment</h1>
            <p class="track-subtitle">Trace your freshly sealed Kashmiri dry fruits, organic white honey, and premium saffron direct from our Srinagar orchards to your kitchen shelves.</p>
        </div>

        <!-- Lookup form -->
        <div class="track-search-card">
            <form action="/track-order" method="GET" class="track-search-form">
                <div class="track-input-group">
                    <label for="track-order-id" class="track-label">Order Reference ID *</label>
                    <div class="track-input-wrapper">
                        <span class="track-input-icon">📦</span>
                        <input type="text" name="order_number" id="track-order-id" class="track-input" placeholder="e.g. ALB-20260618-1234" value="{{ request('order_number') }}" required>
                    </div>
                </div>
                <div class="track-input-group">
                    <label for="track-phone" class="track-label">Recipient Phone (Optional)</label>
                    <div class="track-input-wrapper">
                        <span class="track-input-icon">📞</span>
                        <input type="tel" name="phone" id="track-phone" class="track-input" placeholder="e.g. 9419012345" value="{{ request('phone') }}">
                    </div>
                </div>
                <button type="submit" class="btn-track-submit">
                    🔍 Track Order
                </button>
            </form>
        </div>

        @if (!$searched)
            <!-- Initial State -->
            <div class="track-initial-state">
                <div class="track-initial-icon">📍</div>
                <h3 class="track-initial-title">Awaiting Search Input</h3>
                <p class="track-initial-text">Enter your Al Barr order reference ID printed on your SMS confirmation or checkout receipt to track your valley delivery status.</p>
                
                <!-- If the user has orders in their session/history, we can suggest it -->
                <div class="track-demo-tags">
                    <span class="demo-tag" onclick="prefillSearch('ALB-9831-KASH')">💡 Suggested: ALB-9831-KASH</span>
                    <span class="demo-tag" onclick="prefillSearch('ALB-1045-KASH')">💡 Suggested: ALB-1045-KASH</span>
                </div>
            </div>
        @else
            @if (!$order)
                <!-- Not Found state -->
                <div class="track-initial-state">
                    <div class="track-initial-icon">⚠️</div>
                    <h3 class="track-initial-title" style="color: #c62828;">Order Not Found</h3>
                    <p class="track-initial-text">We couldn't locate any orchard shipment matching the reference code <strong>{{ request('order_number') }}</strong>. Please check the spelling or contact support.</p>
                </div>
            @else
                <!-- Tracking Results -->
                <div class="track-results-wrap">
                    
                    <!-- 1. Summary Card -->
                    <div class="results-summary-card">
                        <div class="summary-header">
                            <div class="summary-title-block">
                                <span class="summary-order-id">{{ $order->order_number }}</span>
                                <span class="summary-order-date">Placed on: {{ $order->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            @php
                                $status = strtolower($order->status);
                                $statusClass = 'status-placed';
                                if ($status === 'processed' || $status === 'processing') { $statusClass = 'status-processed'; }
                                elseif ($status === 'shipped') { $statusClass = 'status-shipped'; }
                                elseif ($status === 'delivered') { $statusClass = 'status-delivered'; }
                                elseif ($status === 'cancelled') { $statusClass = 'status-cancelled'; }
                            @endphp
                            <span class="summary-status-badge {{ $statusClass }}">
                                {{ $order->status }}
                            </span>
                        </div>

                        <!-- 2. Stepper Widget -->
                        <div class="stepper-container">
                            <div class="stepper-progress-bar">
                                @php
                                    $fillPct = 0;
                                    if ($status === 'cancelled') { $fillPct = 0; }
                                    elseif ($status === 'pending') { $fillPct = 12.5; }
                                    elseif ($status === 'processed' || $status === 'processing') { $fillPct = 37.5; }
                                    elseif ($status === 'shipped') { $fillPct = 62.5; }
                                    elseif ($status === 'delivered') { $fillPct = 100; }
                                @endphp
                                <div class="stepper-progress-fill" style="width: {{ $fillPct }}%;"></div>
                            </div>
                            <div class="stepper-nodes">
                                <div class="stepper-node {{ $status === 'cancelled' ? 'cancelled' : (($fillPct >= 12.5) ? ($fillPct == 12.5 ? 'active' : 'completed') : '') }}">
                                    <div class="stepper-circle">📥</div>
                                    <span class="stepper-label">Placed</span>
                                </div>
                                <div class="stepper-node {{ $status === 'cancelled' ? 'cancelled' : (($fillPct >= 37.5) ? ($fillPct == 37.5 ? 'active' : 'completed') : '') }}">
                                    <div class="stepper-circle">⚙️</div>
                                    <span class="stepper-label">Processed</span>
                                </div>
                                <div class="stepper-node {{ $status === 'cancelled' ? 'cancelled' : (($fillPct >= 62.5) ? ($fillPct == 62.5 ? 'active' : 'completed') : '') }}">
                                    <div class="stepper-circle">📦</div>
                                    <span class="stepper-label">Packed</span>
                                </div>
                                <div class="stepper-node {{ $status === 'cancelled' ? 'cancelled' : (($fillPct >= 87.5) ? ($fillPct == 87.5 ? 'active' : 'completed') : '') }}">
                                    <div class="stepper-circle">🚚</div>
                                    <span class="stepper-label">Shipped</span>
                                </div>
                                <div class="stepper-node {{ $status === 'cancelled' ? 'cancelled' : (($status === 'delivered') ? 'completed' : '') }}">
                                    <div class="stepper-circle">🎁</div>
                                    <span class="stepper-label">Delivered</span>
                                </div>
                            </div>
                        </div>

                        <div class="summary-details-grid">
                            <div class="summary-grid-item">
                                <span class="grid-item-lbl">Estimated Delivery</span>
                                <span class="grid-item-val">
                                    @if ($status === 'delivered')
                                        Delivered
                                    @elseif ($status === 'cancelled')
                                        N/A (Cancelled)
                                    @else
                                        {{ $order->created_at->addDays(3)->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                            <div class="summary-grid-item">
                                <span class="grid-item-lbl">Shipping Method</span>
                                <span class="grid-item-val">Al Barr Express Logistics</span>
                            </div>
                            <div class="summary-grid-item">
                                <span class="grid-item-lbl">Consignment Ref</span>
                                <span class="grid-item-val" style="font-family: monospace;">ABE-{{ substr($order->order_number, 4) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Tracking Checkpoints Timeline -->
                    <div class="route-tracking-card">
                        <h3 class="route-title">📍 Valley Dispatch Route checkpoints</h3>
                        <div class="route-timeline">
                            @if ($status === 'cancelled')
                                <div class="route-checkpoint active">
                                    <div class="checkpoint-dot"></div>
                                    <div class="checkpoint-meta">
                                        <span class="checkpoint-location">Dispatch Haltered (Order Cancelled)</span>
                                        <span class="checkpoint-time">Now</span>
                                    </div>
                                    <p class="checkpoint-desc">This order has been cancelled. Dispatch pipeline stopped.</p>
                                </div>
                            @endif

                            @if ($status === 'delivered')
                                <div class="route-checkpoint completed">
                                    <div class="checkpoint-dot"></div>
                                    <div class="checkpoint-meta">
                                        <span class="checkpoint-location">Delivered Gateway (Delivered)</span>
                                        <span class="checkpoint-time">{{ $order->updated_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                    <p class="checkpoint-desc">Order successfully delivered to customer. Saffron seal intact.</p>
                                </div>
                                <div class="route-checkpoint completed">
                                    <div class="checkpoint-dot"></div>
                                    <div class="checkpoint-meta">
                                        <span class="checkpoint-location">Out for Doorstep Delivery</span>
                                        <span class="checkpoint-time">{{ $order->created_at->addDays(2)->format('d M Y') }}, 09:30 AM</span>
                                    </div>
                                    <p class="checkpoint-desc">Order assigned to regional valley courier for doorstep drop-off.</p>
                                </div>
                            @endif

                            @if ($status === 'shipped' || $status === 'delivered')
                                <div class="route-checkpoint {{ $status === 'shipped' ? 'active' : 'completed' }}">
                                    <div class="checkpoint-dot"></div>
                                    <div class="checkpoint-meta">
                                        <span class="checkpoint-location">Srinagar Sorting Hub</span>
                                        <span class="checkpoint-time">{{ $order->created_at->addDays(1)->format('d M Y') }}, 02:30 PM</span>
                                    </div>
                                    <p class="checkpoint-desc">Consignment departed from regional sorting hub. Dispatched in Ganderbal highway carrier.</p>
                                </div>
                            @endif

                            @if ($status === 'processed' || $status === 'processing' || $status === 'packed' || $status === 'shipped' || $status === 'delivered')
                                <div class="route-checkpoint {{ $status === 'processed' || $status === 'processing' || $status === 'packed' ? 'active' : 'completed' }}">
                                    <div class="checkpoint-dot"></div>
                                    <div class="checkpoint-meta">
                                        <span class="checkpoint-location">Hygiene Checks Cleared (Processed Hub)</span>
                                        <span class="checkpoint-time">{{ $order->created_at->format('d M Y') }}, 03:00 PM</span>
                                    </div>
                                    <p class="checkpoint-desc">Hygiene screening cleared. Saffron validation completed, packaging custom seal applied.</p>
                                </div>
                            @endif

                            <div class="route-checkpoint {{ $status === 'pending' ? 'active' : 'completed' }}">
                                <div class="checkpoint-dot"></div>
                                <div class="checkpoint-meta">
                                    <span class="checkpoint-location">Orchard Processing Center, Srinagar</span>
                                    <span class="checkpoint-time">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                                <p class="checkpoint-desc">Order received at central processing hub. Verification checks passed.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Items List & Shipping Details Grid -->
                    <div class="track-details-grid">
                        
                        <!-- Items & receipt -->
                        <div class="items-receipt-card">
                            <h3 class="receipt-title">📦 Shipment Items</h3>
                            <div class="receipt-items-list">
                                @foreach ($order->items as $item)
                                    <div class="receipt-item-row">
                                        <div class="receipt-item-info">
                                            <img src="/{{ $item->variant->product->image ?? 'assets/img/almonds.png' }}" alt="{{ $item->title }}" class="receipt-item-thumb">
                                            <div>
                                                <div class="receipt-item-name">{{ $item->title }}</div>
                                                <div class="receipt-item-qty">Variant: {{ $item->weight }} | Qty: {{ $item->quantity }}</div>
                                            </div>
                                        </div>
                                        <span class="receipt-item-price">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="receipt-breakdown">
                                <div class="receipt-row">
                                    <span>Subtotal</span>
                                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                @if ($order->discount > 0)
                                    <div class="receipt-row discount">
                                        <span>Promo Discount</span>
                                        <span>-₹{{ number_format($order->discount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="receipt-row">
                                    <span>Express Delivery</span>
                                    <span>{{ $order->delivery_charge == 0 ? 'FREE' : '₹' . number_format($order->delivery_charge, 2) }}</span>
                                </div>
                                <div class="receipt-row total">
                                    <span>Total Amount Paid</span>
                                    <span>₹{{ number_format($order->grand_total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="customer-shipping-card">
                            <h3 class="customer-card-title">📍 Destination Details</h3>
                            <div class="customer-info-section">
                                <span class="customer-info-label">Recipient Name</span>
                                <span class="customer-info-val">{{ $order->shipping_name }}</span>
                            </div>
                            <div class="customer-info-section">
                                <span class="customer-info-label">Contact Number</span>
                                <span class="customer-info-val">+91-{{ $order->shipping_phone }}</span>
                            </div>
                            <div class="customer-info-section">
                                <span class="customer-info-label">Shipping Destination</span>
                                <span class="customer-info-val">
                                    {{ $order->shipping_address }}, {{ $order->shipping_city }}, J&K - {{ $order->shipping_pincode }}
                                    @if ($order->shipping_landmark)
                                        <br><span style="font-size:0.82rem; color:var(--color-text-muted);">Landmark: {{ $order->shipping_landmark }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="customer-info-section">
                                <span class="customer-info-label">Payment Preference</span>
                                <span class="customer-info-val">{{ $order->payment_method }}</span>
                            </div>
                        </div>

                    </div>

                </div>
            @endif
        @endif

    </div>
</main>
@endsection

@section('scripts')
<script>
    function prefillSearch(orderId) {
        document.getElementById('track-order-id').value = orderId;
        document.querySelector('.track-search-form').submit();
    }
</script>
@endsection
