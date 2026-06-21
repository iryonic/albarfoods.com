/* Cart Engine - LocalStorage State and UI Synchronizer */

const AlBarrCart = {
    // Read cart state from storage
    get() {
        try {
            const data = localStorage.getItem('al_barr_cart');
            return data ? JSON.parse(data) : [];
        } catch (e) {
            console.error("Cart corrupt, resetting", e);
            return [];
        }
    },

    // Save cart state
    save(cart) {
        localStorage.setItem('al_barr_cart', JSON.stringify(cart));
        this.syncUI();
        this.syncWithServer(cart);
    },

    getSessionToken() {
        let token = localStorage.getItem('al_barr_cart_session_token');
        if (!token) {
            token = 'session_' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
            localStorage.setItem('al_barr_cart_session_token', token);
        }
        return token;
    },

    syncWithServer(cart, details = {}) {
        const token = this.getSessionToken();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Auto-extract checkout fields if they are on the page
        const nameInput = document.getElementById('ch-name');
        const phoneInput = document.getElementById('ch-phone');
        const altPhoneInput = document.getElementById('ch-phone-alt');
        const pincodeInput = document.getElementById('ch-pincode');
        const cityInput = document.getElementById('ch-city');
        const addressInput = document.getElementById('ch-address');
        const landmarkInput = document.getElementById('ch-landmark');

        const payload = {
            session_token: token,
            cart_data: cart,
            name: details.name || nameInput?.value || null,
            phone: details.phone || phoneInput?.value || null,
            alt_phone: details.alt_phone || altPhoneInput?.value || null,
            pincode: details.pincode || pincodeInput?.value || null,
            city: details.city || cityInput?.value || null,
            address: details.address || addressInput?.value || null,
            landmark: details.landmark || landmarkInput?.value || null,
        };

        fetch('/cart/sync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            // Synced successfully
        })
        .catch(err => {
            console.error("Cart sync failed", err);
        });
    },

    // Add item to cart
    add(id, title, weight, price, orig, image) {
        let cart = this.get();
        const existing = cart.find(item => item.id === id && item.weight === weight);

        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id, title, weight, price: parseFloat(price), orig: parseFloat(orig), qty: 1, image });
        }

        this.save(cart);
        this.showToast(`Added ${title} (${weight}) to cart!`);
    },

    // Remove item completely
    remove(id, weight) {
        let cart = this.get();
        cart = cart.filter(item => !(item.id === id && item.weight === weight));
        this.save(cart);
    },

    // Update quantity
    updateQty(id, weight, newQty) {
        if (newQty <= 0) {
            this.remove(id, weight);
            return;
        }

        let cart = this.get();
        const item = cart.find(item => item.id === id && item.weight === weight);
        if (item) {
            item.qty = parseInt(newQty);
            this.save(cart);
        }
    },

    // Clear cart
    clear() {
        this.save([]);
    },

    // Calculate subtotal
    calculateSubtotal(cart) {
        return cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    },

    // Synchronize UI elements across the page
    syncUI() {
        const cart = this.get();
        const subtotal = this.calculateSubtotal(cart);
        const itemCount = cart.reduce((count, item) => count + item.qty, 0);

        // 1. Update Global Header Badges
        const headerBadge = document.getElementById('cart-global-badge');
        const mobileBadge = document.getElementById('cart-mobile-badge');
        const sidebarBadge = document.getElementById('cart-item-count-badge');
        
        if (headerBadge) headerBadge.innerText = itemCount;
        if (mobileBadge) mobileBadge.innerText = itemCount;
        if (sidebarBadge) sidebarBadge.innerText = `(${itemCount} Item${itemCount !== 1 ? 's' : ''})`;

        // 2. Update Header Total display
        const headerTotal = document.getElementById('cart-global-total');
        if (headerTotal) {
            headerTotal.innerText = `₹${subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
        }

        // 3. Update Cart Sidebar Drawers & Empty states
        const itemsListContainer = document.getElementById('cart-drawer-items-list');
        const emptyView = document.getElementById('cart-empty-view');
        const summaryFooter = document.getElementById('cart-summary-footer');

        if (cart.length === 0) {
            if (emptyView) emptyView.style.display = 'flex';
            if (summaryFooter) summaryFooter.style.display = 'none';
            if (itemsListContainer) {
                // Keep only the empty view child
                Array.from(itemsListContainer.children).forEach(child => {
                    if (child.id !== 'cart-empty-view') child.remove();
                });
            }
        } else {
            if (emptyView) emptyView.style.display = 'none';
            if (summaryFooter) summaryFooter.style.display = 'block';

            if (itemsListContainer) {
                // Clear dynamic list items first (excluding empty view container)
                Array.from(itemsListContainer.children).forEach(child => {
                    if (child.id !== 'cart-empty-view') child.remove();
                });

                // Render each cart item
                cart.forEach(item => {
                    const card = document.createElement('div');
                    card.className = 'cart-item-card';
                    card.innerHTML = `
                        <img src="${item.image}" alt="${item.title}" class="cart-item-image" ${item.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                        <div class="cart-item-detail">
                            <h4 class="cart-item-title">${item.title}</h4>
                            <span class="cart-item-variant">Weight: ${item.weight}</span>
                            <div class="cart-item-controls">
                                <div class="cart-item-qty-selector">
                                    <button onclick="AlBarrCart.updateQty(${item.id}, '${item.weight}', ${item.qty - 1})">−</button>
                                    <span class="cart-item-qty-val">${item.qty}</span>
                                    <button onclick="AlBarrCart.updateQty(${item.id}, '${item.weight}', ${item.qty + 1})">+</button>
                                </div>
                                <span class="cart-item-price-calc">₹${(item.price * item.qty).toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                                <span class="cart-item-remove" onclick="AlBarrCart.remove(${item.id}, '${item.weight}')">Remove</span>
                            </div>
                        </div>
                    `;
                    itemsListContainer.appendChild(card);
                });
            }
        }

        // 4. Update Free Shipping Tracker (threshold is ₹999)
        const trackerBox = document.getElementById('shipping-tracker-box');
        const trackerText = document.getElementById('shipping-tracker-text');
        const progressFill = document.getElementById('shipping-progress-fill');
        
        if (trackerBox && trackerText && progressFill) {
            if (itemCount === 0) {
                trackerBox.style.display = 'none';
            } else {
                trackerBox.style.display = 'block';
                const threshold = 999;
                if (subtotal >= threshold) {
                    trackerText.innerHTML = '🎉 You qualify for <strong>FREE Delivery</strong>!';
                    progressFill.style.width = '100%';
                } else {
                    const short = threshold - subtotal;
                    trackerText.innerHTML = `Spend <strong>₹${short.toFixed(2)}</strong> more to unlock <strong>FREE Delivery</strong>!`;
                    progressFill.style.width = `${Math.min((subtotal / threshold) * 100, 100)}%`;
                }
            }
        }

        // 5. Update Sums (Promo calculations)
        const isCouponApplied = sessionStorage.getItem('al_barr_coupon_applied') === 'true';
        const calcSubtotal = document.getElementById('cart-calc-subtotal');
        const calcDiscountRow = document.getElementById('coupon-applied-row');
        const calcDiscountAmount = document.getElementById('cart-calc-coupon-discount');
        const calcDelivery = document.getElementById('cart-calc-delivery');
        const calcTotal = document.getElementById('cart-calc-total');

        if (calcSubtotal) calcSubtotal.innerText = `₹${subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

        let discount = 0;
        if (isCouponApplied && calcDiscountRow && calcDiscountAmount) {
            discount = subtotal * 0.10; // 10% discount
            calcDiscountRow.style.display = 'flex';
            calcDiscountAmount.innerText = `-₹${discount.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
        } else if (calcDiscountRow) {
            calcDiscountRow.style.display = 'none';
        }

        const deliveryCharge = (subtotal >= 999 || subtotal === 0) ? 0 : 60;
        if (calcDelivery) calcDelivery.innerText = deliveryCharge === 0 ? 'FREE' : `₹${deliveryCharge.toFixed(2)}`;

        const grandTotal = subtotal - discount + deliveryCharge;
        if (calcTotal) calcTotal.innerText = `₹${grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

        // 6. Sticky Mobile Checkout Bar
        const mobileSticky = document.getElementById('mobile-sticky-cart-bar');
        const stickyCountText = document.getElementById('mobile-sticky-count');
        const stickyTotalText = document.getElementById('mobile-sticky-total');

        if (mobileSticky && stickyCountText && stickyTotalText) {
            if (itemCount > 0 && window.innerWidth <= 768) {
                mobileSticky.classList.add('active');
                stickyCountText.innerText = `${itemCount} Item${itemCount !== 1 ? 's' : ''} in Cart`;
                stickyTotalText.innerText = `₹${grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
            } else {
                mobileSticky.classList.remove('active');
            }
        }

        // 7. Update Add/Remove triggers on main product cards
        document.querySelectorAll('.product-card, .product-page-columns').forEach(card => {
            const pid = parseInt(card.getAttribute('data-product-id'));
            if (!pid) return;

            // Find selected variant weight
            let selectedWeight = '250g';
            const dropdown = card.querySelector('select.variant-dropdown');
            const activePill = card.querySelector('.variant-pill.active');
            
            if (activePill) {
                selectedWeight = activePill.getAttribute('data-weight');
            } else if (dropdown) {
                selectedWeight = dropdown.value;
            } else if (pid === 2) {
                selectedWeight = '1g'; // Saffron default weight
            }

            const item = cart.find(x => x.id === pid && x.weight === selectedWeight);
            const buttonBox = card.querySelector(`.cart-control-btn[data-product-id="${pid}"], .qty-counter-active[id="qv-qty-counter"]`);
            
            const initBtn = card.querySelector(`.add-btn-init`);
            const counterDiv = card.querySelector(`.qty-counter-active`);
            const qtyValLabel = card.querySelector(`.qty-val`);

            if (initBtn && counterDiv && qtyValLabel) {
                if (item) {
                    initBtn.style.display = 'none';
                    counterDiv.classList.add('active');
                    qtyValLabel.innerText = item.qty;
                } else {
                    initBtn.style.display = 'flex';
                    counterDiv.classList.remove('active');
                }
            }
        });
    },

    // Trigger Notification popup
    showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const isError = type === 'error' || message.toLowerCase().includes('invalid');

        const toast = document.createElement('div');
        toast.className = `toast-item toast-${isError ? 'error' : 'success'}`;
        toast.innerHTML = `
            <div class="toast-icon-wrap">
                ${isError
                    ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`
                    : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`
                }
            </div>
            <span class="toast-message">${message}</span>
            <button class="toast-close" aria-label="Close">&times;</button>
            <div class="toast-progress-bar"></div>
        `;

        // Close button
        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 350);
        });

        container.appendChild(toast);

        // Auto-dismiss after 3.5s
        const timer = setTimeout(() => {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 350);
        }, 3500);

        // Cancel dismiss if user hovers
        toast.addEventListener('mouseenter', () => clearTimeout(timer));
    }
};

// Initial sync
document.addEventListener('DOMContentLoaded', () => {
    AlBarrCart.syncUI();
});
