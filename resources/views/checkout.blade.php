@extends('layouts.app')

@section('title', 'Secure Checkout - Al Barr | Kashmiri Organic Staples')

@section('styles')
    <style>
        .checkout-page-wrap {
            padding: var(--spacing-xl) 0 var(--spacing-xxl);
            background-color: var(--color-cream);
        }

        /* Progress Steps Tracker */
        .checkout-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            gap: var(--spacing-sm);
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--color-text-muted);
            font-weight: 500;
            font-family: var(--font-secondary);
        }

        .step-item.active {
            color: var(--color-brand-green);
            font-weight: 700;
        }

        .step-item.active .step-num {
            background-color: var(--color-brand-green);
            border-color: var(--color-brand-green);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(1, 136, 73, 0.15);
        }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: var(--color-cream-card);
            border: 2px solid var(--color-border);
            color: var(--color-text-secondary);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .step-line {
            height: 2px;
            width: 60px;
            background-color: var(--color-border);
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .step-line.active {
            background-color: var(--color-brand-green);
        }

        /* Two Column Layout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: var(--spacing-xl);
            align-items: start;
        }

        .checkout-card {
            background: var(--color-cream-card);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-sm);
            padding: var(--spacing-xl);
            box-shadow: 0 4px 25px rgba(11, 19, 17, 0.02);
            margin-bottom: var(--spacing-md);
        }

        .checkout-sec-title {
            font-family: var(--font-secondary);
            font-size: 1.25rem;
            color: var(--color-brand-green);
            margin-bottom: var(--spacing-lg);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkout-sec-icon {
            font-size: 1.25rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.06));
        }

        /* Form Details */
        .checkout-form {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-md);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-lbl {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--color-text-secondary);
        }

        .checkout-input,
        .checkout-textarea {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            font-size: 0.92rem;
            color: var(--color-text-primary);
            transition: all 0.3s ease;
        }

        .checkout-input:focus,
        .checkout-textarea:focus {
            border-color: var(--color-brand-green);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.12);
            outline: none;
        }

        .checkout-textarea {
            resize: vertical;
            height: 90px;
        }

        /* Payment selection accordion */
        .payment-option-card {
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-sm);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .payment-option-card:hover {
            border-color: var(--color-brand-green-medium);
            background-color: rgba(1, 136, 73, 0.01);
        }

        .payment-option-card.active {
            border-color: var(--color-brand-green);
            background-color: var(--color-brand-green-light);
            box-shadow: 0 4px 15px rgba(1, 136, 73, 0.04);
        }

        .payment-option-header {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-family: var(--font-secondary);
            color: var(--color-brand-green);
            font-size: 0.95rem;
        }

        .payment-radio {
            accent-color: var(--color-brand-green);
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .payment-option-body {
            margin-top: 10px;
            padding-left: 30px;
            display: none;
            color: var(--color-text-secondary);
            font-size: 0.88rem;
            line-height: 1.5;
        }

        .payment-option-card.active .payment-option-body {
            display: block;
        }

        /* Right column items checkout card */
        .order-summary-sidebar {
            position: sticky;
            top: 100px;
        }

        .summary-items-list {
            max-height: 250px;
            overflow-y: auto;
            margin-bottom: var(--spacing-md);
            padding-right: 6px;
        }

        .summary-item-card {
            display: flex;
            gap: var(--spacing-md);
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--color-border-light);
        }

        .summary-item-thumb-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .summary-item-thumb {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            object-fit: contain;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border-light);
            display: block;
        }

        .summary-item-qty-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: var(--color-brand-green);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            z-index: 2;
        }

        .summary-item-info {
            flex-grow: 1;
            min-width: 0;
        }

        .summary-item-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--color-brand-green);
            margin-bottom: 2px;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .summary-item-meta {
            font-size: 0.76rem;
            color: var(--color-text-muted);
            margin-top: 1px;
        }

        .summary-item-price-col {
            flex-shrink: 0;
            text-align: right;
        }

        .summary-item-price {
            font-weight: 700;
            color: var(--color-text-primary);
            font-size: 0.88rem;
        }

        .summary-calc-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--color-text-secondary);
            margin-bottom: 8px;
        }

        .summary-calc-row.total {
            border-top: 1px solid var(--color-border);
            padding-top: var(--spacing-md);
            margin-top: var(--spacing-md);
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--color-brand-green);
        }

        .place-order-btn {
            width: 100%;
            background: var(--color-saffron-gradient);
            color: #fff;
            padding: 13px 20px;
            border-radius: 50px;
            font-family: var(--font-secondary);
            font-weight: 700;
            font-size: 1rem;
            text-align: center;
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(255, 85, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: var(--spacing-md);
        }

        .place-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 85, 0, 0.35);
        }

        /* Direct Bank Card details inside Accordion */
        .bank-details-card-checkout {
            margin-top: 12px;
            background: var(--color-cream-card);
            border: 1px dashed var(--color-gold);
            border-radius: var(--radius-sm);
            padding: var(--spacing-md);
            box-shadow: 0 2px 8px rgba(255, 179, 0, 0.05);
        }

        .checkout-bank-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: var(--spacing-xs);
        }

        .checkout-bank-lbl {
            font-weight: 600;
            color: var(--color-text-secondary);
        }

        .checkout-bank-val {
            font-family: monospace;
            font-weight: 700;
            color: var(--color-brand-green);
        }

        .bank-btn-copy-checkout {
            background-color: var(--color-gold-light);
            border: 1px solid rgba(255, 179, 0, 0.4);
            color: var(--color-gold-hover);
            padding: 2px 8px;
            font-size: 0.68rem;
            border-radius: 20px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .bank-btn-copy-checkout:hover {
            background-color: var(--color-gold);
            color: #fff;
            border-color: var(--color-gold);
        }

        .bank-btn-copy-checkout.copied {
            background-color: var(--color-brand-green);
            color: #fff;
            border-color: var(--color-brand-green);
        }

        /* Coupon Code Styling */
        .checkout-coupon-section {
            margin-bottom: var(--spacing-md);
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--color-border-light);
        }

        .coupon-input-group {
            display: flex;
            gap: 8px;
            width: 100%;
        }

        .coupon-input-group .checkout-input {
            flex: 1;
            min-width: 0;
        }

        .coupon-apply-btn {
            background-color: var(--color-brand-green-light);
            border: 1.5px solid rgba(1, 136, 73, 0.15);
            color: var(--color-brand-green);
            padding: 10px 18px;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .coupon-apply-btn:hover {
            background-color: var(--color-brand-green);
            color: #fff;
            border-color: var(--color-brand-green);
        }

        .coupon-feedback {
            font-size: 0.76rem;
            margin-top: 6px;
            font-weight: 600;
            display: none;
        }

        .coupon-feedback.success {
            color: var(--color-brand-green-medium);
            display: block;
        }

        .coupon-feedback.error {
            color: var(--color-red);
            display: block;
        }
        
        .coupon-remove-link {
            color: var(--color-red);
            text-decoration: underline;
            margin-left: 6px;
            cursor: pointer;
            font-size: 0.72rem;
            font-weight: normal;
        }

        /* Responsive layout */
        @media (max-width: 991px) {
            .checkout-page-wrap {
                padding: var(--spacing-lg) 0;
                overflow-x: hidden;
                width: 100%;
            }
            .checkout-grid {
                display: flex;
                flex-direction: column;
                gap: var(--spacing-md);
                width: 100%;
            }
            .order-summary-sidebar {
                position: static;
                order: -1;
                width: 100%;
            }
            .checkout-forms-column {
                width: 100%;
            }
            .checkout-card {
                padding: var(--spacing-md) var(--spacing-lg);
            }
            .container {
                padding: 0 16px;
            }
        }

        @media (max-width: 600px) {
            .step-item span:not(.step-num) {
                display: none;
            }
            .step-line {
                width: 30px;
            }
            .checkout-steps {
                gap: 8px;
            }
            .form-row-2 {
                grid-template-columns: 1fr;
                gap: var(--spacing-md);
            }
            .checkout-card {
                padding: 20px 15px;
            }
        }

        @media (max-width: 480px) {
            .checkout-card {
                padding: 16px 12px;
            }
            .step-line {
                width: 20px;
            }
            .checkout-steps {
                gap: 6px;
            }
            .payment-option-body {
                padding-left: 10px;
            }
            .checkout-bank-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                border-bottom: 1px solid var(--color-border-light);
                padding-bottom: 8px;
                margin-bottom: 8px;
            }
            .checkout-bank-row:last-child {
                border-bottom: none;
                padding-bottom: 0;
                margin-bottom: 0;
            }
            .checkout-bank-row > span {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                margin-top: 2px;
            }
        }

        #mobile-sticky-cart-bar,
        .mobile-sticky-cart-banner {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <main class="checkout-page-wrap">
        <div class="container">
            
            <!-- Steps Progress -->
            <div class="checkout-steps">
                <div class="step-item">
                    <span class="step-num">✓</span>
                    <span>Shopping Cart</span>
                </div>
                <div class="step-line active"></div>
                <div class="step-item active">
                    <span class="step-num">2</span>
                    <span>Shipping &amp; Payment</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <span class="step-num">3</span>
                    <span>Order Confirmation</span>
                </div>
            </div>

            <!-- Page Grid Layout -->
            <div class="checkout-grid">
                
                <!-- Left column: Address & Payment -->
                <div class="checkout-forms-column">
                    
                    <!-- shipping details card -->
                    <div class="checkout-card">
                        <h2 class="checkout-sec-title">
                            <span class="checkout-sec-icon">🚚</span>
                            <span>Shipping Address Details</span>
                        </h2>
                        
                        <form class="checkout-form" id="checkout-address-form" onsubmit="event.preventDefault();">
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="ch-name" class="form-lbl">Full Name *</label>
                                    <input type="text" id="ch-name" class="checkout-input" placeholder="e.g. Irfan Manzoor" required autocomplete="name">
                                </div>
                                <div class="form-group">
                                    <label for="ch-phone" class="form-lbl">Primary Contact Number *</label>
                                    <input type="tel" id="ch-phone" class="checkout-input" placeholder="e.g. 9419012345" required pattern="[0-9]{10}" autocomplete="tel">
                                </div>
                            </div>

                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="ch-phone-alt" class="form-lbl">Alternate Phone (Recommended)</label>
                                    <input type="tel" id="ch-phone-alt" class="checkout-input" placeholder="e.g. 7006123456" pattern="[0-9]{10}" autocomplete="tel">
                                </div>
                                <div class="form-group">
                                    <label for="ch-pincode" class="form-lbl">Pin Code *</label>
                                    <input type="text" id="ch-pincode" class="checkout-input" placeholder="e.g. 190006" required pattern="[0-9]{6}" autocomplete="postal-code">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ch-city" class="form-lbl">District / City *</label>
                                <input type="text" id="ch-city" class="checkout-input" placeholder="e.g. Srinagar" required autocomplete="address-level2">
                            </div>

                            <div class="form-group">
                                <label for="ch-address" class="form-lbl">Complete Delivery Address *</label>
                                <textarea id="ch-address" class="checkout-textarea" placeholder="Flat No., House Name, Street Details, Village/Colony Name" required autocomplete="street-address"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="ch-landmark" class="form-lbl">Landmark (Optional)</label>
                                <input type="text" id="ch-landmark" class="checkout-input" placeholder="e.g. Opposite J&K Bank Branch">
                            </div>
                        </form>
                    </div>

                    <!-- payment options card -->
                    <div class="checkout-card">
                        <h2 class="checkout-sec-title">
                            <span class="checkout-sec-icon">💳</span>
                            <span>Choose Payment Method</span>
                        </h2>

                        <!-- Option 1: COD -->
                        <div class="payment-option-card active" id="payment-card-cod" onclick="selectPayment('cod')">
                            <div class="payment-option-header">
                                <input type="radio" name="payment_method" value="cod" class="payment-radio" checked id="radio-cod">
                                <span>Cash on Delivery (COD)</span>
                            </div>
                            <div class="payment-option-body">
                                Pay with cash or local UPI QR scanner upon physical delivery at your doorstep. Safe &amp; convenient.
                            </div>
                        </div>

                        <!-- Option 2: Bank Transfer -->
                        <div class="payment-option-card" id="payment-card-bank" onclick="selectPayment('bank')">
                            <div class="payment-option-header">
                                <input type="radio" name="payment_method" value="bank" class="payment-radio" id="radio-bank">
                                <span>Direct Bank Transfer (Advance)</span>
                            </div>
                            <div class="payment-option-body">
                                Transfer payment in advance to Al Barr's official corporate bank account. Share transaction receipt on WhatsApp ({{ $settings['phone_number'] ?? '+91-9419000000' }}) for instant order verification.
                                
                                <div class="bank-details-card-checkout">
                                    <div class="checkout-bank-row">
                                        <span class="checkout-bank-lbl">Bank Name:</span>
                                        <span class="checkout-bank-val" style="font-family: inherit;">{{ $settings['bank_name'] ?? 'J&amp;K Bank' }}</span>
                                    </div>
                                    <div class="checkout-bank-row">
                                        <span class="checkout-bank-lbl">Account Name:</span>
                                        <span class="checkout-bank-val" style="font-family: inherit;">{{ $settings['bank_account_name'] ?? 'AL BARR' }}</span>
                                    </div>
                                    <div class="checkout-bank-row">
                                        <span class="checkout-bank-lbl">Account Number:</span>
                                        <span>
                                            <span class="checkout-bank-val" id="ch-acc-num">{{ $settings['bank_account_number'] ?? '0216010100002651' }}</span>
                                            <button class="bank-btn-copy-checkout" onclick="event.stopPropagation(); copyTextLocal('{{ $settings['bank_account_number'] ?? '0216010100002651' }}', this)">Copy</button>
                                        </span>
                                    </div>
                                    <div class="checkout-bank-row" style="margin-bottom: 0;">
                                        <span class="checkout-bank-lbl">IFSC Code:</span>
                                        <span>
                                            <span class="checkout-bank-val" id="ch-ifsc">{{ $settings['bank_ifsc'] ?? 'JAKA0GARDEN' }}</span>
                                            <button class="bank-btn-copy-checkout" onclick="event.stopPropagation(); copyTextLocal('{{ $settings['bank_ifsc'] ?? 'JAKA0GARDEN' }}', this)">Copy</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Right column: summary sidebar -->
                <aside class="order-summary-sidebar">
                    <div class="checkout-card">
                        <h2 class="checkout-sec-title">
                            <span class="checkout-sec-icon">📦</span>
                            <span>Order Summary</span>
                        </h2>

                        <!-- Dynamic Items list -->
                        <div class="summary-items-list" id="checkout-items-list">
                            <!-- Populated by JS -->
                        </div>

                        <!-- Coupon Code Section -->
                        <div class="checkout-coupon-section">
                            <label class="form-lbl" style="display: block; margin-bottom: 8px;">Promo Code</label>
                            <div class="coupon-input-group">
                                <input type="text" id="coupon-code-input" class="checkout-input" placeholder="e.g. ALBARR10" style="padding: 10px 14px;">
                                <button type="button" id="btn-apply-promo" class="coupon-apply-btn">Apply</button>
                            </div>
                            <div id="coupon-msg" class="coupon-feedback"></div>
                        </div>

                        <!-- Calculations summary -->
                        <div class="summary-calc-row">
                            <span>Subtotal</span>
                            <span id="ch-subtotal">₹0.00</span>
                        </div>
                        <div class="summary-calc-row" id="ch-discount-row" style="display: none; color: var(--color-green-accent);">
                            <span>Discount (10% Off)</span>
                            <span id="ch-discount">-₹0.00</span>
                        </div>
                        <div class="summary-calc-row">
                            <span>Delivery Charges</span>
                            <span id="ch-delivery">₹60.00</span>
                        </div>
                        <div class="summary-calc-row total">
                            <span>Grand Total</span>
                            <span id="ch-total">₹0.00</span>
                        </div>

                        <button class="place-order-btn" id="btn-submit-order">
                            Confirm &amp; Place Order
                        </button>
                    </div>
                </aside>

            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script>
        let selectedPaymentMethod = 'cod';

        function selectPayment(method) {
            selectedPaymentMethod = method;
            document.querySelectorAll('.payment-option-card').forEach(card => card.classList.remove('active'));
            document.getElementById(`radio-cod`).checked = (method === 'cod');
            document.getElementById(`radio-bank`).checked = (method === 'bank');
            document.getElementById(`payment-card-${method}`).classList.add('active');
        }

        function copyTextLocal(text, buttonEl) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = buttonEl.innerText;
                buttonEl.innerText = 'Copied! ✓';
                buttonEl.classList.add('copied');
                
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast('Copied to clipboard!');
                }
                
                setTimeout(() => {
                    buttonEl.innerText = originalText;
                    buttonEl.classList.remove('copied');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const listContainer = document.getElementById('checkout-items-list');
            const subtotalText = document.getElementById('ch-subtotal');
            const discountRow = document.getElementById('ch-discount-row');
            const discountText = document.getElementById('ch-discount');
            const deliveryText = document.getElementById('ch-delivery');
            const totalText = document.getElementById('ch-total');
            const placeOrderBtn = document.getElementById('btn-submit-order');
            const addressForm = document.getElementById('checkout-address-form');

            // 1. Fetch Cart from LocalStorage
            const cart = (typeof AlBarrCart !== 'undefined') ? AlBarrCart.get() : [];
            
            if (cart.length === 0) {
                window.location.href = '/';
                return;
            }

            // 2. Render summary items
            let subtotal = 0;
            listContainer.innerHTML = '';
            
            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                const row = document.createElement('div');
                row.className = 'summary-item-card';
                row.innerHTML = `
                    <div class="summary-item-thumb-wrap">
                        <img src="${item.image}" alt="${item.title}" class="summary-item-thumb" ${item.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                        <span class="summary-item-qty-badge">${item.qty}</span>
                    </div>
                    <div class="summary-item-info">
                        <h4 class="summary-item-name">${item.title}</h4>
                        <div class="summary-item-meta">${item.weight} &bull; ₹${item.price.toFixed(2)}</div>
                    </div>
                    <div class="summary-item-price-col">
                        <span class="summary-item-price">₹${itemTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                    </div>
                `;
                listContainer.appendChild(row);
            });

            // Calculate values
            let discount = 0;
            let delivery = 0;
            let grandTotal = 0;

            function calculateTotals() {
                const isCouponApplied = sessionStorage.getItem('al_barr_coupon_applied') === 'true';
                
                subtotalText.innerText = `₹${subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

                if (isCouponApplied) {
                    discount = subtotal * 0.10;
                    discountRow.style.display = 'flex';
                    discountText.innerText = `-₹${discount.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
                } else {
                    discount = 0;
                    discountRow.style.display = 'none';
                }

                delivery = (subtotal >= 999) ? 0 : 60;
                deliveryText.innerText = delivery === 0 ? 'FREE' : `₹${delivery.toFixed(2)}`;

                grandTotal = subtotal - discount + delivery;
                totalText.innerText = `₹${grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
            }

            // Coupon Code input handling
            const couponInput = document.getElementById('coupon-code-input');
            const applyPromoBtn = document.getElementById('btn-apply-promo');
            const couponMsg = document.getElementById('coupon-msg');

            if (sessionStorage.getItem('al_barr_coupon_applied') === 'true') {
                if (couponInput) couponInput.value = 'ALBARR10';
                if (couponMsg) {
                    couponMsg.className = 'coupon-feedback success';
                    couponMsg.innerHTML = 'Coupon <strong>ALBARR10</strong> applied! (10% off) <span class="coupon-remove-link" onclick="removeCoupon()">Remove</span>';
                }
            }

            window.removeCoupon = function() {
                sessionStorage.removeItem('al_barr_coupon_applied');
                if (couponInput) couponInput.value = '';
                if (couponMsg) {
                    couponMsg.style.display = 'none';
                    couponMsg.innerHTML = '';
                }
                calculateTotals();
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast('Coupon removed.');
                }
            };

            if (applyPromoBtn) {
                applyPromoBtn.addEventListener('click', () => {
                    const code = couponInput.value.trim().toUpperCase();
                    if (code === 'ALBARR10') {
                        sessionStorage.setItem('al_barr_coupon_applied', 'true');
                        calculateTotals();
                        if (couponMsg) {
                            couponMsg.className = 'coupon-feedback success';
                            couponMsg.innerHTML = 'Coupon <strong>ALBARR10</strong> applied! (10% off) <span class="coupon-remove-link" onclick="removeCoupon()">Remove</span>';
                        }
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast("Coupon 'ALBARR10' applied! 10% Discount added.");
                        }
                    } else if (code === '') {
                        if (couponMsg) {
                            couponMsg.className = 'coupon-feedback error';
                            couponMsg.innerText = 'Please enter a coupon code.';
                        }
                    } else {
                        if (couponMsg) {
                            couponMsg.className = 'coupon-feedback error';
                            couponMsg.innerText = "Invalid promo code! Try 'ALBARR10'.";
                        }
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast("Invalid promo code! Try 'ALBARR10'.");
                        }
                    }
                });
            }

            calculateTotals();

            // 3. Address Caching: Load from localStorage or profile
            const savedAddress = localStorage.getItem('al_barr_saved_address');
            if (savedAddress) {
                try {
                    const parsed = JSON.parse(savedAddress);
                    if (parsed.name) document.getElementById('ch-name').value = parsed.name;
                    if (parsed.phone) document.getElementById('ch-phone').value = parsed.phone;
                    if (parsed.altPhone) document.getElementById('ch-phone-alt').value = parsed.altPhone;
                    if (parsed.pincode) document.getElementById('ch-pincode').value = parsed.pincode;
                    if (parsed.city) document.getElementById('ch-city').value = parsed.city;
                    if (parsed.address) document.getElementById('ch-address').value = parsed.address;
                    if (parsed.landmark) document.getElementById('ch-landmark').value = parsed.landmark;
                } catch(e) {}
            }

            // 4. Pincode Auto-fetch
            const pincodeInput = document.getElementById('ch-pincode');
            const cityInput = document.getElementById('ch-city');
            pincodeInput.addEventListener('input', function() {
                const pin = this.value.trim();
                if (pin.length === 6 && /^\d+$/.test(pin)) {
                    fetch(`https://api.postalpincode.in/pincode/${pin}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data[0] && data[0].Status === 'Success') {
                                const postOffice = data[0].PostOffice[0];
                                if (postOffice && postOffice.District) {
                                    cityInput.value = postOffice.District;
                                    cityInput.style.transition = 'box-shadow 0.3s ease';
                                    cityInput.style.boxShadow = '0 0 0 3px rgba(1, 136, 73, 0.2)';
                                    setTimeout(() => cityInput.style.boxShadow = '', 1000);
                                }
                            }
                        })
                        .catch(err => console.error('Pincode fetch error:', err));
                }
            });

            // 5. Place Order trigger (POST using Laravel endpoint with CSRF protection)
            placeOrderBtn.addEventListener('click', () => {
                if (!addressForm.checkValidity()) {
                    addressForm.reportValidity();
                    return;
                }

                // Add loading indicator
                placeOrderBtn.innerText = 'Processing Order...';
                placeOrderBtn.disabled = true;

                // Gather details
                const payload = {
                    name: document.getElementById('ch-name').value,
                    phone: document.getElementById('ch-phone').value,
                    alt_phone: document.getElementById('ch-phone-alt').value,
                    pincode: document.getElementById('ch-pincode').value,
                    city: document.getElementById('ch-city').value,
                    address: document.getElementById('ch-address').value,
                    landmark: document.getElementById('ch-landmark').value,
                    payment_method: selectedPaymentMethod,
                    cart: cart,
                    coupon_code: sessionStorage.getItem('al_barr_coupon_applied') === 'true' ? 'ALBARR10' : null,
                    session_token: (typeof AlBarrCart !== 'undefined') ? AlBarrCart.getSessionToken() : null
                };

                // Post to Laravel checkout
                fetch('/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Save address locally
                        const addressDataToSave = {
                            name: payload.name,
                            phone: payload.phone,
                            altPhone: payload.alt_phone,
                            pincode: payload.pincode,
                            city: payload.city,
                            address: payload.address,
                            landmark: payload.landmark
                        };
                        localStorage.setItem('al_barr_saved_address', JSON.stringify(addressDataToSave));

                        // Clear coupon and Cart on success
                        sessionStorage.removeItem('al_barr_coupon_applied');
                        if (typeof AlBarrCart !== 'undefined') {
                            AlBarrCart.clear();
                        } else {
                            localStorage.removeItem('al_barr_cart');
                        }

                        // Redirect to success route
                        window.location.href = data.redirect_url;
                    } else {
                        // Display error
                        alert(data.error || 'Failed to place order. Please check item stocks.');
                        placeOrderBtn.innerText = 'Confirm & Place Order';
                        placeOrderBtn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error('Order submission error:', err);
                    alert('An error occurred. Please try again.');
                    placeOrderBtn.innerText = 'Confirm & Place Order';
                    placeOrderBtn.disabled = false;
                });
            });

            // Debounced Abandoned Carts input sync
            const checkoutInputs = ['ch-name', 'ch-phone', 'ch-phone-alt', 'ch-pincode', 'ch-city', 'ch-address', 'ch-landmark'];
            let syncTimeout;
            checkoutInputs.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', () => {
                        clearTimeout(syncTimeout);
                        syncTimeout = setTimeout(() => {
                            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.syncWithServer) {
                                AlBarrCart.syncWithServer(AlBarrCart.get());
                            }
                        }, 2000);
                    });
                }
            });
        });
    </script>
@endsection
