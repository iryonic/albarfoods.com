<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Securely complete your Al Barr order. Fill out shipping details and choose Direct Bank Transfer or COD.">
    <title>Secure Checkout - Al Barr | Kashmiri Organic Staples</title>
    
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <link rel="stylesheet" href="assets/css/variables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/components.css?v=<?php echo time(); ?>">

    <style>
        .checkout-page-wrap {
            padding: var(--spacing-xxl) 0;
            background-color: var(--color-cream);
        }

        /* Progress Steps Tracker */
        .checkout-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            gap: var(--spacing-md);
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            color: var(--color-text-muted);
            font-weight: 500;
        }

        .step-item.active {
            color: var(--color-blue-dark);
            font-weight: 700;
        }

        .step-item.active .step-num {
            background-color: var(--color-blue-dark);
            color: #fff;
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--color-border);
            color: var(--color-text-secondary);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .step-line {
            height: 2px;
            width: 50px;
            background-color: var(--color-border);
        }

        /* Two Column Layout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: var(--spacing-xl);
            align-items: start;
        }

        .checkout-card {
            background: var(--color-cream-card);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-md);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-sm);
            margin-bottom: var(--spacing-md);
        }

        .checkout-sec-title {
            font-family: var(--font-secondary);
            font-size: 1.4rem;
            color: var(--color-blue-dark);
            margin-bottom: var(--spacing-md);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkout-sec-icon {
            font-size: 1.3rem;
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
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-text-secondary);
        }

        .checkout-input,
        .checkout-textarea {
            width: 100%;
            padding: 12px 14px;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xs);
            font-size: 0.95rem;
            color: var(--color-text-primary);
            transition: var(--transition-fast);
        }

        .checkout-input:focus,
        .checkout-textarea:focus {
            border-color: var(--color-blue-medium);
            background-color: #fff;
            box-shadow: 0 0 0 3px var(--color-blue-light);
        }

        .checkout-textarea {
            resize: vertical;
            height: 80px;
        }

        /* Payment selection accordion */
        .payment-option-card {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-sm);
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .payment-option-card.active {
            border-color: var(--color-blue-medium);
            background-color: var(--color-blue-light);
        }

        .payment-option-header {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-family: var(--font-secondary);
            color: var(--color-blue-dark);
        }

        .payment-radio {
            accent-color: var(--color-blue-dark);
            width: 18px;
            height: 18px;
        }

        .payment-option-body {
            margin-top: var(--spacing-sm);
            padding-left: 30px;
            display: none;
            color: var(--color-text-secondary);
            font-size: 0.9rem;
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
            gap: 12px;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--color-border-light);
        }

        .summary-item-thumb {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-xs);
            object-fit: contain;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border-light);
        }

        .summary-item-info {
            flex-grow: 1;
        }

        .summary-item-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-blue-dark);
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .summary-item-weight {
            font-size: 0.75rem;
            color: var(--color-text-muted);
        }

        .summary-item-price-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .summary-item-qty {
            color: var(--color-text-muted);
        }

        .summary-item-price {
            font-weight: 600;
            color: var(--color-text-primary);
        }

        .summary-calc-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.95rem;
            color: var(--color-text-secondary);
            margin-bottom: 8px;
        }

        .summary-calc-row.total {
            border-top: 1px solid var(--color-border);
            padding-top: var(--spacing-sm);
            margin-top: var(--spacing-sm);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-blue-dark);
        }

        .place-order-btn {
            width: 100%;
            background: var(--color-saffron-gradient);
            color: #fff;
            padding: 14px;
            border-radius: var(--radius-xs);
            font-family: var(--font-secondary);
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            box-shadow: 0 8px 24px rgba(255, 85, 0, 0.2);
            transition: var(--transition-normal);
            margin-top: var(--spacing-md);
        }

        .place-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255, 85, 0, 0.3);
        }

        /* Direct Bank Card details inside Accordion */
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
        }

        /* Responsive layout */
        @media (max-width: 991px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
            .order-summary-sidebar {
                position: static;
                order: -1; /* Place summary at the top on mobile */
            }
        }
    </style>
</head>
<body>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

    <main class="checkout-page-wrap">
        <div class="container">
            
            <!-- Steps Progress -->
            <div class="checkout-steps">
                <div class="step-item">
                    <span class="step-num">✓</span>
                    <span>Shopping Cart</span>
                </div>
                <div class="step-line"></div>
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
                                    <input type="text" id="ch-name" class="checkout-input" placeholder="e.g. Irfan Manzoor" required>
                                </div>
                                <div class="form-group">
                                    <label for="ch-phone" class="form-lbl">Primary Contact Number *</label>
                                    <input type="tel" id="ch-phone" class="checkout-input" placeholder="e.g. 9419012345" required pattern="[0-9]{10}">
                                </div>
                            </div>

                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="ch-phone-alt" class="form-lbl">Alternate Phone (Recommended)</label>
                                    <input type="tel" id="ch-phone-alt" class="checkout-input" placeholder="e.g. 7006123456" pattern="[0-9]{10}">
                                </div>
                                <div class="form-group">
                                    <label for="ch-pincode" class="form-lbl">Pin Code *</label>
                                    <input type="text" id="ch-pincode" class="checkout-input" placeholder="e.g. 190006" required pattern="[0-9]{6}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ch-city" class="form-lbl">District / City *</label>
                                <input type="text" id="ch-city" class="checkout-input" placeholder="e.g. Srinagar" required>
                            </div>

                            <div class="form-group">
                                <label for="ch-address" class="form-lbl">Complete Delivery Address *</label>
                                <textarea id="ch-address" class="checkout-textarea" placeholder="Flat No., House Name, Street Details, Village/Colony Name" required></textarea>
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
                                Transfer payment in advance to Al Barr's official corporate bank account. Share transaction receipt on WhatsApp (+91-9419000000) for instant order verification.
                                
                                <div class="bank-details-card-checkout">
                                    <div class="checkout-bank-row">
                                        <span class="checkout-bank-lbl">Bank Name:</span>
                                        <span class="checkout-bank-val" style="font-family: inherit;">J&amp;K Bank</span>
                                    </div>
                                    <div class="checkout-bank-row">
                                        <span class="checkout-bank-lbl">Account Name:</span>
                                        <span class="checkout-bank-val" style="font-family: inherit;">AL BARR</span>
                                    </div>
                                    <div class="checkout-bank-row">
                                        <span class="checkout-bank-lbl">Account Number:</span>
                                        <span>
                                            <span class="checkout-bank-val" id="ch-acc-num">0216010100002651</span>
                                            <button class="bank-btn-copy-checkout" onclick="event.stopPropagation(); copyToClipboard('0216010100002651', 'Account Number')">Copy</button>
                                        </span>
                                    </div>
                                    <div class="checkout-bank-row" style="margin-bottom: 0;">
                                        <span class="checkout-bank-lbl">IFSC Code:</span>
                                        <span>
                                            <span class="checkout-bank-val" id="ch-ifsc">JAKA0GARDEN</span>
                                            <button class="bank-btn-copy-checkout" onclick="event.stopPropagation(); copyToClipboard('JAKA0GARDEN', 'IFSC Code')">Copy</button>
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

    <!-- Side Cart, Quick View, and Toasters -->
    <?php include 'includes/sidebar-cart.php'; ?>
    <?php include 'includes/quick-view.php'; ?>
    <div class="toast-container" id="toast-container"></div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Interactive script logic -->
    <script>
        let selectedPaymentMethod = 'cod';

        function selectPayment(method) {
            selectedPaymentMethod = method;
            document.querySelectorAll('.payment-option-card').forEach(card => card.classList.remove('active'));
            document.getElementById(`radio-cod`).checked = (method === 'cod');
            document.getElementById(`radio-bank`).checked = (method === 'bank');
            document.getElementById(`payment-card-${method}`).classList.add('active');
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
                // If cart is empty, redirect back to index
                window.location.href = 'index.php';
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
                    <img src="${item.image}" alt="${item.title}" class="summary-item-thumb" ${item.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                    <div class="summary-item-info">
                        <h4 class="summary-item-name">${item.title}</h4>
                        <div class="summary-item-weight">Weight: ${item.weight}</div>
                        <div class="summary-item-price-row">
                            <span class="summary-item-qty">Qty: ${item.qty} × ₹${item.price.toFixed(2)}</span>
                            <span class="summary-item-price">₹${itemTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                        </div>
                    </div>
                `;
                listContainer.appendChild(row);
            });

            // Calculate values
            const isCouponApplied = sessionStorage.getItem('al_barr_coupon_applied') === 'true';
            let discount = 0;
            
            subtotalText.innerText = `₹${subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

            if (isCouponApplied) {
                discount = subtotal * 0.10;
                discountRow.style.display = 'flex';
                discountText.innerText = `-₹${discount.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
            } else {
                discountRow.style.display = 'none';
            }

            const delivery = (subtotal >= 999) ? 0 : 60;
            deliveryText.innerText = delivery === 0 ? 'FREE' : `₹${delivery.toFixed(2)}`;

            const grandTotal = subtotal - discount + delivery;
            totalText.innerText = `₹${grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

            // 3. Place Order trigger
            placeOrderBtn.addEventListener('click', () => {
                // Trigger form check
                if (!addressForm.checkValidity()) {
                    addressForm.reportValidity();
                    return;
                }

                // Gather details
                const orderData = {
                    orderId: 'ALB-' + new Date().getFullYear() + String(new Date().getMonth() + 1).padStart(2, '0') + String(new Date().getDate()).padStart(2, '0') + '-' + Math.floor(1000 + Math.random() * 9000),
                    items: cart,
                    subtotal: subtotal,
                    discount: discount,
                    delivery: delivery,
                    grandTotal: grandTotal,
                    paymentMethod: selectedPaymentMethod === 'cod' ? 'Cash on Delivery (COD)' : 'Direct Bank Transfer (J&K Bank)',
                    shippingName: document.getElementById('ch-name').value,
                    shippingPhone: document.getElementById('ch-phone').value,
                    shippingAddress: document.getElementById('ch-address').value + ', ' + document.getElementById('ch-city').value + ' - ' + document.getElementById('ch-pincode').value + (document.getElementById('ch-landmark').value ? ' (Landmark: ' + document.getElementById('ch-landmark').value + ')' : '')
                };

                // Save details in sessionStorage for order-success.php
                sessionStorage.setItem('al_barr_latest_order', JSON.stringify(orderData));

                // Clear coupon and Cart
                sessionStorage.removeItem('al_barr_coupon_applied');
                if (typeof AlBarrCart !== 'undefined') {
                    AlBarrCart.clear();
                } else {
                    localStorage.removeItem('al_barr_cart');
                }

                // Redirect to success page
                window.location.href = 'order-success.php';
            });
        });
    </script>
</body>
</html>
