@extends('layouts.app')

@section('title', 'Order Confirmed - Al Barr | Kashmiri Organic Staples')

@section('styles')
<style>
    .success-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        min-height: 70vh;
        display: flex;
        align-items: center;
    }

    .success-container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        width: 100%;
        animation: fadeUp 0.6s ease-out forwards;
    }

    .success-header {
        margin-bottom: var(--spacing-xl);
    }

    /* Success Checkmark Animation */
    .success-checkmark-box {
        display: flex;
        justify-content: center;
        margin-bottom: var(--spacing-md);
    }

    .success-checkmark-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        stroke: var(--color-blue-dark);
        stroke-width: 3;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px var(--color-blue-light);
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    .checkmark-circle-path {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: var(--color-blue-dark);
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark-kick-path {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: #fff;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 40px var(--color-blue-dark);
        }
    }

    .success-title {
        font-family: var(--font-secondary);
        font-size: 2.2rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-xs);
    }

    .success-subtitle {
        color: var(--color-text-secondary);
        font-size: 1.1rem;
        max-width: 550px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* Order Details Card */
    .order-success-card {
        background: var(--color-cream-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        text-align: left;
        margin-bottom: var(--spacing-lg);
        position: relative;
        overflow: hidden;
        animation: fadeUp 0.5s ease-out 0.2s forwards;
    }

    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .order-success-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--color-gold-gradient);
    }

    .receipt-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-sm) 0;
        border-bottom: 1px dashed var(--color-border-light);
    }

    .receipt-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .receipt-lbl {
        font-size: 0.9rem;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .receipt-val {
        font-size: 1.05rem;
        color: var(--color-blue-dark);
        font-weight: 700;
    }

    .receipt-val.order-id {
        font-family: monospace;
        font-size: 1.15rem;
        letter-spacing: 0.5px;
    }

    .receipt-total {
        margin-top: var(--spacing-sm);
        border-top: 1px solid var(--color-border) !important;
        padding-top: var(--spacing-md);
    }

    .receipt-total .receipt-lbl {
        font-size: 1rem;
        color: var(--color-text-primary);
    }

    .receipt-total .receipt-val {
        font-size: 1.4rem;
        color: var(--color-gold);
    }

    .order-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: var(--spacing-md);
    }

    .meta-item {
        display: flex;
        flex-direction: column;
    }

    .meta-item-label {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .meta-item-value {
        font-size: 1rem;
        color: var(--color-blue-dark);
        font-weight: 700;
    }

    .order-success-section {
        margin-bottom: var(--spacing-lg);
    }

    .order-success-section:last-child {
        margin-bottom: 0;
    }

    .order-success-sec-title {
        font-family: var(--font-secondary);
        font-size: 1.2rem;
        color: var(--color-blue-dark);
        margin-bottom: var(--spacing-sm);
        font-weight: 600;
        border-bottom: 1px solid var(--color-border-light);
        padding-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Items list */
    .success-items-list {
        margin-bottom: var(--spacing-md);
    }

    .success-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: var(--spacing-sm) 0;
        border-bottom: 1px dashed var(--color-border-light);
    }

    .success-item-row:last-child {
        border-bottom: none;
    }

    .success-item-details {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .success-item-thumb {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-xs);
        object-fit: contain;
        background-color: var(--color-cream);
        border: 1px solid var(--color-border-light);
    }

    .success-item-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--color-text-primary);
    }

    .success-item-qty {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        margin-top: 2px;
    }

    .success-item-price {
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 0.95rem;
    }

    /* Financials table */
    .success-financials {
        background-color: var(--color-cream);
        border-radius: var(--radius-xs);
        padding: var(--spacing-md);
        margin-top: var(--spacing-md);
    }

    .financial-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--color-text-secondary);
        margin-bottom: 6px;
    }

    .financial-row:last-child {
        margin-bottom: 0;
    }

    .financial-row.discount {
        color: var(--color-blue-medium);
        font-weight: 500;
    }

    .financial-row.total {
        border-top: 1px solid var(--color-border);
        padding-top: var(--spacing-sm);
        margin-top: var(--spacing-sm);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-blue-dark);
    }

    /* Shipping Address Card */
    .shipping-address-summary {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Instructions / Next Steps Alert */
    .success-instruction-alert {
        background: var(--color-blue-light);
        border: 1px solid var(--color-blue-medium);
        border-radius: var(--radius-sm);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        display: flex;
        gap: var(--spacing-md);
        align-items: flex-start;
        text-align: left;
    }

    .instruction-icon {
        font-size: 1.5rem;
        line-height: 1;
    }

    .instruction-text h4 {
        font-size: 1rem;
        color: var(--color-blue-dark);
        margin-bottom: 4px;
        font-family: var(--font-secondary);
        font-weight: 600;
    }

    .instruction-text p {
        font-size: 0.9rem;
        color: var(--color-text-secondary);
        line-height: 1.4;
    }

    .success-actions {
        display: flex;
        justify-content: center;
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    .btn-success-action {
        padding: 12px 24px;
        border-radius: var(--radius-xs);
        font-weight: 600;
        font-family: var(--font-secondary);
        text-decoration: none;
        transition: var(--transition-fast);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
    }

    .btn-success-action.primary {
        background: var(--color-saffron-gradient);
        color: #fff;
        box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
    }

    .btn-success-action.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
    }

    .btn-success-action.secondary {
        background-color: #fff;
        color: var(--color-blue-dark);
        border: 1px solid var(--color-border);
    }

    .btn-success-action.secondary:hover {
        background-color: var(--color-cream);
        border-color: var(--color-text-muted);
    }

    .btn-success-action.whatsapp-confirm {
        background-color: #25D366;
        color: white;
        box-shadow: 0 4px 14px rgba(37, 211, 102, 0.2);
    }

    .btn-success-action.whatsapp-confirm:hover {
        background-color: #128C7E;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
    }

    /* Error / Empty State Screen */
    .empty-success-state {
        padding: var(--spacing-xxl) 0;
        text-align: center;
    }

    .empty-success-icon {
        font-size: 4rem;
        margin-bottom: var(--spacing-md);
    }

    .empty-success-title {
        font-family: var(--font-secondary);
        font-size: 1.8rem;
        color: var(--color-blue-dark);
        margin-bottom: var(--spacing-xs);
    }

    .empty-success-text {
        color: var(--color-text-secondary);
        margin-bottom: var(--spacing-md);
    }

    /* Bank details wrapper styled same as checkout */
    .bank-details-card-checkout {
        margin-top: var(--spacing-sm);
        background: var(--color-cream);
        border: 1px dashed var(--color-gold);
        border-radius: var(--radius-sm);
        padding: var(--spacing-md);
    }

    .checkout-bank-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        margin-bottom: var(--spacing-xs);
    }

    .checkout-bank-lbl {
        font-weight: 600;
        color: var(--color-text-secondary);
    }

    .checkout-bank-val {
        font-family: monospace;
        font-weight: 700;
        color: var(--color-blue-dark);
    }

    .bank-btn-copy-checkout {
        background-color: var(--color-gold-light);
        border: 1px solid var(--color-gold);
        color: var(--color-gold-hover);
        padding: 2px 6px;
        font-size: 0.7rem;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        margin-left: 6px;
        transition: var(--transition-fast);
    }

    .bank-btn-copy-checkout:hover {
        background-color: var(--color-gold);
        color: #fff;
    }

    @media print {
        .announcement-bar,
        .main-header,
        .mobile-bottom-nav,
        .floating-widget-container,
        .success-actions,
        .success-checkmark-box,
        .success-subtitle,
        .success-instruction-alert,
        .main-footer,
        #toast-container {
            display: none !important;
        }

        body, .success-page-wrap {
            background: #fff !important;
            padding: 0 !important;
            color: #000 !important;
        }

        .order-success-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .order-success-card::before {
            display: none !important;
        }

        .success-container {
            max-width: 100% !important;
        }

        .success-title {
            font-size: 1.8rem !important;
            margin-top: 20px !important;
        }
        
        .success-financials {
            background: #f9f9f9 !important;
            border: 1px solid #ccc !important;
        }
    }

    @media (max-width: 768px) {
        .order-meta-grid {
            grid-template-columns: 1fr;
            gap: var(--spacing-sm);
        }
        .success-title {
            font-size: 1.8rem;
        }
    }
</style>
@endsection

@section('content')
<main class="success-page-wrap">
    <div class="container">
        @if (isset($order))
            <div class="success-container" id="success-view">
                
                <!-- 1. Checkmark Icon -->
                <div class="success-checkmark-box">
                    <div class="success-checkmark-circle">
                        <svg class="checkmark-svg" viewBox="0 0 52 52" style="width: 80px; height: 80px;">
                            <circle class="checkmark-circle-path" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark-kick-path" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>
                </div>

                <!-- 2. Header Text -->
                <div class="success-header">
                    <h1 class="success-title">Order Confirmed!</h1>
                    <p class="success-subtitle">Thank you for choosing Al Barr.</p>
                </div>

                <!-- 3. Minimal Receipt Snippet -->
                <div class="order-success-card">
                    <div class="receipt-row">
                        <span class="receipt-lbl">Order Reference</span>
                        <span class="receipt-val order-id">{{ $order->order_number }}</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-lbl">Payment Method</span>
                        <span class="receipt-val">{{ $order->payment_method }}</span>
                    </div>

                    <!-- Items summary breakdown -->
                    <div style="margin-top: var(--spacing-md);">
                        <h3 class="order-success-sec-title">
                            <span>📦</span> Items Ordered
                        </h3>
                        <div class="success-items-list">
                            @foreach ($order->items as $item)
                                <div class="success-item-row">
                                    <div class="success-item-details">
                                        <span class="success-item-name">{{ $item->title }} ({{ $item->weight }})</span>
                                        <span class="success-item-qty">x{{ $item->quantity }}</span>
                                    </div>
                                    <span class="success-item-price">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pricing calculations -->
                    <div class="success-financials">
                        <div class="financial-row">
                            <span>Subtotal:</span>
                            <span>₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="financial-row discount">
                                <span>Promo Discount Applied:</span>
                                <span>-₹{{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="financial-row">
                            <span>Delivery Charges:</span>
                            <span>{{ $order->delivery_charge == 0 ? 'FREE' : '₹' . number_format($order->delivery_charge, 2) }}</span>
                        </div>
                        <div class="financial-row total">
                            <span>Grand Total:</span>
                            <span>₹{{ number_format($order->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Next Steps Alert -->
                <div class="success-instruction-alert" id="instruction-card">
                    <span class="instruction-icon">🔔</span>
                    <div class="instruction-text">
                        <h4>
                            @if (str_contains(strtolower($order->payment_method), 'bank'))
                                Payment Receipt Pending
                            @else
                                What happens next?
                            @endif
                        </h4>
                        <p>
                            @if (str_contains(strtolower($order->payment_method), 'bank'))
                                Please transfer the amount below to our J&K bank account and share the receipt via WhatsApp. Your order will be validated and shipped upon receipt confirmation.
                            @else
                                Your order is registered. We will send you dispatch updates via SMS or contact you directly on your primary telephone number to coordinate local doorstep delivery. Thank you!
                            @endif
                        </p>
                        
                        <!-- J&K Bank details card -->
                        @if (str_contains(strtolower($order->payment_method), 'bank'))
                            <div class="bank-details-card-checkout" id="success-bank-section" style="margin-top: var(--spacing-md);">
                                <div class="checkout-bank-row">
                                    <span class="checkout-bank-lbl">Bank Name:</span>
                                    <span class="checkout-bank-val" style="font-family: inherit;">{{ $settings['bank_name'] ?? 'J&K Bank' }}</span>
                                </div>
                                <div class="checkout-bank-row">
                                    <span class="checkout-bank-lbl">Account Name:</span>
                                    <span class="checkout-bank-val" style="font-family: inherit;">{{ $settings['bank_account_name'] ?? 'AL BARR' }}</span>
                                </div>
                                <div class="checkout-bank-row">
                                    <span class="checkout-bank-lbl">Account Number:</span>
                                    <span>
                                        <span class="checkout-bank-val" id="success-acc-num">{{ $settings['bank_account_number'] ?? '0216010100002651' }}</span>
                                        <button class="bank-btn-copy-checkout" onclick="event.stopPropagation(); copyToClipboard('{{ $settings['bank_account_number'] ?? '0216010100002651' }}', 'Account Number')">Copy</button>
                                    </span>
                                </div>
                                <div class="checkout-bank-row" style="margin-bottom: 0;">
                                    <span class="checkout-bank-lbl">IFSC Code:</span>
                                    <span>
                                        <span class="checkout-bank-val" id="success-ifsc">{{ $settings['bank_ifsc'] ?? 'JAKA0GARDEN' }}</span>
                                        <button class="bank-btn-copy-checkout" onclick="event.stopPropagation(); copyToClipboard('{{ $settings['bank_ifsc'] ?? 'JAKA0GARDEN' }}', 'IFSC Code')">Copy</button>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 5. Actions / CTAs -->
                <div class="success-actions">
                    <a href="{{ route('home') }}" class="btn-success-action secondary" onclick="clearSuccessSession();">
                         Back to Home
                    </a>
                    
                    @php
                        if (str_contains(strtolower($order->payment_method), 'bank')) {
                            $messageText = "Hello Al Barr Team, I have placed order *{$order->order_number}* for *₹" . number_format($order->grand_total, 2) . "* using Direct Bank Transfer. Here is my transaction receipt.";
                        } else {
                            $messageText = "Hello Al Barr Team, I have placed COD order *{$order->order_number}* for *₹" . number_format($order->grand_total, 2) . "*. Please confirm dispatch!";
                        }
                        $whatsappLink = "https://wa.me/919419000000?text=" . urlencode($messageText);
                    @endphp
                    <a href="{{ $whatsappLink }}" target="_blank" class="btn-success-action whatsapp-confirm" id="btn-whatsapp-confirm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 18px; height: 18px;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        Confirm on WhatsApp
                    </a>
                </div>

            </div>
        @else
            <!-- Empty / fallback view -->
            <div class="empty-success-state" id="fallback-view">
                <div class="empty-success-icon">🍃</div>
                <h2 class="empty-success-title">No Active Order Found</h2>
                <p class="empty-success-text">It seems you have visited this page directly or your session has expired.</p>
                <a href="{{ route('shop') }}" class="btn-success-action primary">
                    <span>🛍️</span> Shop Our Products
                </a>
            </div>
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
    function clearSuccessSession() {
        sessionStorage.removeItem('al_barr_latest_order');
    }

    function copyToClipboard(text, label) {
        navigator.clipboard.writeText(text).then(() => {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast(`${label} copied to clipboard!`);
            } else {
                alert(`${label} copied!`);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Automatically clear client cart if order successfully placed
        @if (isset($order))
            if (typeof AlBarrCart !== 'undefined') {
                AlBarrCart.clear();
            } else {
                localStorage.removeItem('al_barr_cart');
            }
            // Add order reference to local storage orders history for client-side tracking
            try {
                let localOrders = JSON.parse(localStorage.getItem('al_barr_orders')) || [];
                const exists = localOrders.some(o => o.orderId === '{{ $order->order_number }}');
                if (!exists) {
                    const fullOrder = {
                        orderId: '{{ $order->order_number }}',
                        date: '{{ $order->created_at->format("M d, Y") }}',
                        status: 'Placed',
                        estDelivery: '{{ $order->created_at->addDays(3)->format("M d, Y") }}',
                        partner: 'Al Barr Express Logistics',
                        consignment: 'ABE-' + Math.floor(100000 + Math.random() * 899999) + '-KASH',
                        paymentMethod: '{{ $order->payment_method }}',
                        shippingName: '{{ $order->shipping_name }}',
                        shippingPhone: '{{ $order->shipping_phone }}',
                        shippingAddress: '{{ $order->shipping_address }}',
                        subtotal: {{ $order->subtotal }},
                        discount: {{ $order->discount }},
                        delivery: {{ $order->delivery_charge }},
                        grandTotal: {{ $order->grand_total }},
                        items: [
                            @foreach ($order->items as $item)
                                {
                                    title: '{{ $item->title }}',
                                    weight: '{{ $item->weight }}',
                                    price: {{ $item->price }},
                                    qty: {{ $item->quantity }}
                                },
                            @endforeach
                        ],
                        route: [
                            {
                                location: 'Orchard Processing Center, Srinagar',
                                time: '{{ $order->created_at->format("M d, Y, h:i A") }}',
                                desc: 'Order received and registered in Al Barr system. Preparing packaging material with hygiene protocol.',
                                completed: true,
                                active: true
                            }
                        ]
                    };
                    localOrders.unshift(fullOrder);
                    localStorage.setItem('al_barr_orders', JSON.stringify(localOrders));
                }
            } catch (err) {
                console.error("Error writing local orders history", err);
            }
        @endif
    });
</script>
@endsection
