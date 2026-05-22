<!-- Cart Slide Drawer Backdrop -->
<div class="cart-backdrop" id="cart-backdrop"></div>

<!-- Cart Drawer -->
<div class="cart-sidebar-drawer" id="cart-sidebar">
    <div class="cart-drawer-header">
        <div class="cart-drawer-title">
            <!-- Cart Icon -->
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <span>My Shopping Cart</span>
            <span style="font-size: 0.85rem; color: var(--color-gold); font-weight: 700;" id="cart-item-count-badge">(0 Items)</span>
        </div>
        <button class="cart-close-btn" id="cart-close-trigger" aria-label="Close cart">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- Free Shipping Progress Tracker -->
    <div class="shipping-progress-banner" id="shipping-tracker-box">
        <div class="shipping-progress-text" id="shipping-tracker-text">
            Spend <span>₹999.00</span> more to unlock <strong>FREE Delivery</strong>!
        </div>
        <div class="shipping-bar">
            <div class="shipping-fill" id="shipping-progress-fill"></div>
        </div>
    </div>

    <!-- Cart Body -->
    <div class="cart-items-body" id="cart-drawer-items-list">
        <!-- Rendered Dynamically via JS -->
        
        <!-- Empty State (Fallback) -->
        <div class="cart-empty-state" id="cart-empty-view">
            <div class="cart-empty-icon">🛒</div>
            <h3 style="margin-bottom: 8px; color: var(--color-blue-dark);">Your cart is empty</h3>
            <p style="font-size: 0.85rem; margin-bottom: 20px;">Add pure organic specialties from Al barr to get started!</p>
            <button class="btn btn-primary" id="start-shopping-btn" style="font-size: 0.9rem; padding: 0.6rem 1.2rem;">Shop Our Products</button>
        </div>
    </div>

    <!-- Cart Footer Summary -->
    <div class="cart-drawer-footer" id="cart-summary-footer" style="display: none;">
        <!-- Coupon code -->
        <div class="promo-code-wrap">
            <input type="text" class="promo-input" id="cart-coupon-code" placeholder="Enter coupon code (e.g. KHALIS10)" uppercase>
            <button class="promo-btn" id="apply-coupon-btn">Apply</button>
        </div>

        <div class="cart-summary-row">
            <span>Subtotal</span>
            <span id="cart-calc-subtotal">₹0.00</span>
        </div>
        <div class="cart-summary-row" id="coupon-applied-row" style="display: none; color: var(--color-green-accent);">
            <span>Coupon Discount (10% Off)</span>
            <span id="cart-calc-coupon-discount">-₹0.00</span>
        </div>
        <div class="cart-summary-row">
            <span>Delivery Charge</span>
            <span id="cart-calc-delivery">₹60.00</span>
        </div>
        <div class="cart-summary-row total">
            <span>Grand Total</span>
            <span id="cart-calc-total">₹0.00</span>
        </div>

        <button class="btn btn-gold checkout-btn" id="drawer-checkout-btn">
            Proceed to Checkout
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
    </div>
</div>

<!-- Mobile Sticky Bottom Checkout Banner -->
<div class="mobile-sticky-cart-banner" id="mobile-sticky-cart-bar">
    <div class="sticky-cart-info">
        <span class="sticky-cart-count" id="mobile-sticky-count">2 Items in Cart</span>
        <span class="sticky-cart-total" id="mobile-sticky-total">₹1,200.00</span>
    </div>
    <button class="sticky-cart-btn" id="mobile-sticky-view-btn">
        View Cart
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
    </button>
</div>
