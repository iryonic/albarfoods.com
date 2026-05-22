<!-- Quick View Modal Overlay -->
<div class="modal-overlay" id="quick-view-modal">
    <div class="modal-content-box">
        <button class="modal-close-btn" id="qv-close-btn" aria-label="Close modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        
        <div class="modal-body-scroll">
            <div class="modal-columns">
                <!-- Column 1: Image Showcase -->
                <div style="position: relative;">
                    <span class="badge badge-discount" id="qv-discount-badge" style="position: absolute; top: 10px; left: 10px; z-index: 5;">-15%</span>
                    <div style="background-color: var(--color-cream); border-radius: var(--radius-md); padding: var(--spacing-md); border: 1px solid var(--color-border-light);">
                        <img src="assets/img/almonds.png" alt="Product Image" id="qv-product-image" style="width: 100%; height: auto; object-fit: cover; border-radius: var(--radius-md);">
                    </div>
                    <p style="text-align: center; font-size: 0.8rem; color: var(--color-text-muted); margin-top: var(--spacing-sm);">
                        📷 Actual premium packaging shown. Pure & Raw.
                    </p>
                </div>

                <!-- Column 2: Selection & Purchase Center -->
                <div style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span class="badge badge-sale" id="qv-badge-label" style="margin-bottom: var(--spacing-sm); font-size: 0.7rem; border-radius: var(--radius-xs);">Organic Certified</span>
                        <h2 id="qv-product-title" style="font-size: 1.8rem; color: var(--color-blue-dark); margin-bottom: var(--spacing-xs);">Kashmiri Mamra Almonds</h2>
                        
                        <!-- Ratings -->
                        <div class="product-rating" style="margin-bottom: var(--spacing-md);">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            <span class="product-rating-count" id="qv-product-rating-count">(48 Verified Reviews)</span>
                        </div>

                        <!-- Description -->
                        <p id="qv-product-description" style="font-size: 0.95rem; color: var(--color-text-secondary); margin-bottom: var(--spacing-lg);">
                            Kashmiri Mamra Almonds are rich in nutrients, oils, and minerals. Handpicked from local Kashmiri orchards, they represent the absolute height of premium dry fruit luxury.
                        </p>

                        <!-- Variant Picker -->
                        <div class="product-variant-selector">
                            <label style="font-size: 0.85rem; font-weight: 700; color: var(--color-blue-dark); display: block; margin-bottom: var(--spacing-xs);">Select Weight Variant:</label>
                            <select class="variant-dropdown" id="qv-variant-select">
                                <option value="250g" data-price="850" data-orig="990">250g - Pack of 1 (₹850.00)</option>
                                <option value="500g" data-price="1650" data-orig="1900">500g - Pack of 1 (₹1,650.00)</option>
                                <option value="1kg" data-price="3200" data-orig="3700">1kg - Pack of 1 (₹3,200.00)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer / Price & Add Actions -->
                    <div style="border-top: 1px solid var(--color-border-light); padding-top: var(--spacing-lg); margin-top: var(--spacing-md); display: flex; align-items: center; justify-content: space-between;">
                        <div class="product-price-info">
                            <span class="price-current" id="qv-current-price" style="font-size: 1.6rem;">₹850.00</span>
                            <span class="price-original" id="qv-original-price" style="font-size: 1.1rem;">₹990.00</span>
                        </div>

                        <!-- Add Button wrapper (Blinkit style dynamic button) -->
                        <div class="cart-control-btn" style="width: 120px; height: 42px;" id="qv-cart-control-btn">
                            <button class="add-btn-init" id="qv-add-btn" style="font-size: 0.95rem;">
                                <span>ADD</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                            <div class="qty-counter-active" id="qv-qty-counter">
                                <button class="qty-btn" id="qv-qty-minus">−</button>
                                <span class="qty-val" id="qv-qty-val">1</span>
                                <button class="qty-btn" id="qv-qty-plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
