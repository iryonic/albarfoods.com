<!-- Cart Slide Drawer Backdrop -->
<div class="cart-backdrop" id="cart-backdrop"></div>

<!-- Cart Drawer -->
<div class="cart-sidebar-drawer" id="cart-sidebar">

    <!-- Header -->
    <div class="cart-drawer-header">
        <div class="cart-drawer-title">
            <div class="cart-header-icon-wrap">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            </div>
            <div class="cart-header-text-wrap">
                <span class="cart-header-title">My Cart</span>
                <span class="cart-header-count" id="cart-item-count-badge">0 Items</span>
            </div>
        </div>
        <button class="cart-close-btn" id="cart-close-trigger" aria-label="Close cart">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- Free Shipping Progress Tracker -->
    <div class="shipping-progress-banner" id="shipping-tracker-box" style="display:none;">
        <div class="shipping-progress-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span id="shipping-tracker-text">Add ₹999 more to unlock <strong>FREE Delivery</strong>!</span>
        </div>
        <div class="shipping-bar">
            <div class="shipping-fill" id="shipping-progress-fill"></div>
        </div>
    </div>

    <!-- Cart Body -->
    <div class="cart-items-body" id="cart-drawer-items-list">

        <!-- Empty State -->
        <div class="cart-empty-state" id="cart-empty-view">
            <div class="cart-empty-illustration">
                <svg width="80" height="80" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="45" fill="rgba(1,136,73,0.06)"/>
                    <path d="M20 30h4l8 36a4 4 0 0 0 4 3.2h28a4 4 0 0 0 4-3.2L72 46H28" stroke="var(--color-brand-green)" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <circle cx="38" cy="76" r="4" fill="var(--color-brand-green)"/>
                    <circle cx="62" cy="76" r="4" fill="var(--color-brand-green)"/>
                    <path d="M46 58 l4 4 l8-10" stroke="var(--color-saffron-orange)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="cart-empty-title">Your cart is empty</h3>
            <p class="cart-empty-subtitle">Add pure organic specialties from Al Barr to get started!</p>
            <button class="cart-empty-cta" id="start-shopping-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                Explore Products
            </button>
        </div>

    </div>

    <!-- Smart Recommendations (Cross-sell) -->
    <div class="cart-recommendations-wrapper" id="cart-cross-sell" style="display: none;">
        <h4 class="recommendations-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Frequently Added Together
        </h4>
        <div class="recommendations-list">
            <div class="rec-item-card">
                <img src="{{ asset('assets/img/almonds.png') }}" alt="Kashmiri Mamra Almonds" class="rec-item-img" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
                <div class="rec-item-info">
                    <span class="rec-item-name">Kashmiri Mamra Almonds</span>
                    <span class="rec-item-price">₹280 <del style="font-size:0.72rem;opacity:0.5;font-weight:400;">₹320</del></span>
                </div>
                <button class="rec-add-btn" onclick="AlBarrCart.add(1, 'Kashmiri Mamra Almonds', '250g', 280, 320, '{{ asset('assets/img/almonds.png') }}')">+ Add</button>
            </div>
            <div class="rec-item-card">
                <img src="{{ asset('assets/img/saffron.png') }}" alt="Mogra Saffron" class="rec-item-img" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
                <div class="rec-item-info">
                    <span class="rec-item-name">Mogra Saffron</span>
                    <span class="rec-item-price">₹350 <del style="font-size:0.72rem;opacity:0.5;font-weight:400;">₹420</del></span>
                </div>
                <button class="rec-add-btn" onclick="AlBarrCart.add(2, 'Mogra Saffron', '0.5g', 350, 420, '{{ asset('assets/img/saffron.png') }}')">+ Add</button>
            </div>
        </div>
    </div>

    <!-- Cart Footer Summary -->
    <div class="cart-drawer-footer" id="cart-summary-footer" style="display: none;">

        <!-- Coupon Input -->
        <div class="promo-code-wrap">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;color:var(--color-brand-green);"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            <input type="text" class="promo-input" id="cart-coupon-code" placeholder="Coupon code (e.g. ALBARR10)">
            <button class="promo-btn" id="apply-coupon-btn">Apply</button>
        </div>

        <!-- Order Summary -->
        <div class="cart-order-summary">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span id="cart-calc-subtotal">₹0.00</span>
            </div>
            <div class="cart-summary-row" id="coupon-applied-row" style="display: none;">
                <span class="summary-discount-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Coupon Discount (10%)
                </span>
                <span id="cart-calc-coupon-discount" style="color:var(--color-brand-green);font-weight:700;">-₹0.00</span>
            </div>
            <div class="cart-summary-row">
                <span>Delivery</span>
                <span id="cart-calc-delivery">₹60.00</span>
            </div>
            <div class="cart-summary-divider"></div>
            <div class="cart-summary-row total">
                <span>Grand Total</span>
                <span id="cart-calc-total">₹0.00</span>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="cart-trust-badges">
            <div class="trust-badge-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Secure Checkout</span>
            </div>
            <div class="trust-badge-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                <span>Easy Returns</span>
            </div>
            <div class="trust-badge-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <span>Free on ₹999+</span>
            </div>
        </div>

        <!-- Checkout Button -->
        <button class="btn btn-gold checkout-btn" id="drawer-checkout-btn">
            <span>Proceed to Checkout</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>

    </div>
</div>

<!-- Mobile Sticky Bottom Checkout Banner -->
<div class="mobile-sticky-cart-banner" id="mobile-sticky-cart-bar">
    <div class="sticky-cart-info">
        <span class="sticky-cart-count" id="mobile-sticky-count">0 Items in Cart</span>
        <span class="sticky-cart-total" id="mobile-sticky-total">₹0.00</span>
    </div>
    <button class="sticky-cart-btn" id="mobile-sticky-view-btn">
        View Cart
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
    </button>
</div>
