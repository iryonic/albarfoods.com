@extends('layouts.app')

@section('title', 'My Wishlist - Al Barr | Kashmiri Organic Staples')

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

    /* Wishlist Grid Content */
    .wishlist-grid-wrap {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--spacing-md);
    }

    .wishlist-product-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 20px;
        padding: var(--spacing-md);
        box-shadow: var(--shadow-sm);
        position: relative;
        display: flex;
        flex-direction: column;
        transition: transform var(--transition-fast), box-shadow var(--transition-fast);
    }

    .wishlist-product-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .wishlist-remove-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--color-border);
        color: var(--color-red);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition-fast);
        z-index: 10;
        font-size: 1.25rem;
        font-weight: bold;
        line-height: 1;
    }

    .wishlist-remove-btn:hover {
        background-color: var(--color-red);
        color: #fff;
        transform: scale(1.08);
    }

    .wishlist-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background-color: var(--color-blue-light);
        color: var(--color-blue-dark);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(1, 136, 73, 0.1);
    }

    .wishlist-img-box {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: var(--spacing-sm);
        background-color: var(--color-cream-light);
        border-radius: 12px;
        overflow: hidden;
        padding: 10px;
    }

    .wishlist-product-img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .wishlist-product-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0 0 6px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.8em;
    }

    .wishlist-product-meta {
        font-size: 0.78rem;
        color: var(--color-text-muted);
        margin-bottom: var(--spacing-sm);
    }

    .wishlist-variant-picker {
        margin-bottom: var(--spacing-sm);
    }

    .wishlist-select-input {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-size: 0.85rem;
        background-color: var(--color-cream);
        color: var(--color-text-primary);
        cursor: pointer;
    }

    .wishlist-price-block {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: var(--spacing-md);
    }

    .wishlist-price-sale {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-saffron-orange);
    }

    .wishlist-price-orig {
        font-size: 0.88rem;
        color: var(--color-text-muted);
        text-decoration: line-through;
    }

    .btn-wishlist-cart {
        width: 100%;
        padding: 10px;
        background-color: var(--color-blue-dark);
        color: #fff;
        border: none;
        border-radius: var(--radius-xs);
        font-weight: 700;
        font-family: var(--font-secondary);
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: auto;
    }

    .btn-wishlist-cart:hover {
        background-color: var(--color-blue-medium);
    }

    /* Empty State */
    .wishlist-empty-wrap {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 24px;
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--spacing-xl);
        text-align: left;
    }

    .wishlist-empty-state {
        text-align: center;
        padding: var(--spacing-lg) 0;
    }

    .empty-state-icon {
        font-size: 3.5rem;
        margin-bottom: var(--spacing-md);
        animation: heartbeat 1.5s infinite;
    }

    @keyframes heartbeat {
        0% { transform: scale(1); }
        14% { transform: scale(1.1); }
        28% { transform: scale(1); }
        42% { transform: scale(1.1); }
        70% { transform: scale(1); }
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
        max-width: 420px;
        margin: 0 auto var(--spacing-lg) auto;
        line-height: 1.45;
    }

    /* Recommendations Section */
    .recs-title {
        font-family: var(--font-secondary);
        font-size: 1.3rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-md);
        text-align: left;
        border-bottom: 1.5px solid var(--color-border-light);
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .recs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--spacing-md);
    }

    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .wishlist-grid-wrap, .recs-grid {
            grid-template-columns: 1fr;
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
                <h1 class="profile-title">My Wishlist</h1>
                <p class="profile-subtitle">Keep track of your favorite organic staples. Move them directly to the cart whenever you are ready to restock.</p>
            </div>

            <div class="profile-grid">
                
                <!-- Left: Navigation Sidebar -->
                <aside class="profile-sidebar">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar-circle" id="profile-avatar-img" onclick="triggerAvatarRegen()">
                            A
                            <div class="profile-avatar-edit-badge" title="Regenerate theme background">♻️</div>
                        </div>
                        <h3 class="profile-user-name" id="profile-display-name">Patron</h3>
                        <span class="profile-user-role">Al Barr Patron</span>
                    </div>

                    <ul class="profile-side-menu">
                        <li><a href="/profile" class="profile-side-link">👤 Personal Profile</a></li>
                        <li><a href="/orders" class="profile-side-link">📦 My Orders</a></li>
                        <li><a href="/wishlist" class="profile-side-link active">❤️ My Wishlist</a></li>
                        <li><a href="/tickets" class="profile-side-link">🎟️ Support Tickets</a></li>
                        <li><a href="/track-order" class="profile-side-link">📍 Track Shipment</a></li>
                        <li><a href="#" onclick="handleHeaderSignOut(event)" class="profile-side-link" style="color: var(--color-red);">🚪 Sign Out</a></li>
                    </ul>
                </aside>

                <!-- Right: Wishlist grid or Empty Recommendations -->
                <div style="width: 100%;">
                    
                    <!-- Wishlist Grid view -->
                    <div class="wishlist-grid-wrap" id="wishlist-grid-container">
                        <!-- Populated dynamically via JS -->
                    </div>

                    <!-- Wishlist Empty View -->
                    <div class="wishlist-empty-wrap" id="wishlist-empty-view" style="display: none;">
                        <div class="wishlist-empty-state">
                            <div class="empty-state-icon">❤️</div>
                            <h3 class="empty-state-title">Your Wishlist is Empty</h3>
                            <p class="empty-state-text">Explore our collection of authentic Kashmiri dry fruits, organic honey, and aromatic mountain spices to save items here.</p>
                        </div>
                        
                        <!-- Recommendations block -->
                        <h3 class="recs-title">⭐ Kashmiri Best-Sellers</h3>
                        <div class="recs-grid" id="recs-grid-container">
                            <!-- Populated dynamically with static best-sellers -->
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
    const AVATAR_PALETTES = [
        { bg: '#018849', color: '#ffffff' },
        { bg: '#FF5500', color: '#ffffff' },
        { bg: '#FFB300', color: '#000000' },
        { bg: '#0b192c', color: '#ffffff' },
        { bg: '#4a3f35', color: '#ffffff' }
    ];

    // Best seller products list for recommendation fallback
    const RECOMMENDATION_PRODUCTS = [
        {
            id: 1,
            title: 'Premium Kashmiri Mamra Almonds (Raw)',
            meta: 'Dry Fruits',
            badge: 'Valley Sourced',
            image: "{{ asset('assets/img/almonds.png') }}",
            variants: {
                '250g': { price: 850, orig: 990 },
                '500g': { price: 1650, orig: 1900 },
                '1kg': { price: 3200, orig: 3700 }
            }
        },
        {
            id: 2,
            title: 'Kashmiri Kesar (Pure Mogra Saffron)',
            meta: 'Spices',
            badge: 'Grade A+ Certified',
            image: "{{ asset('assets/img/saffron.png') }}",
            variants: {
                '1g': { price: 350, orig: 400 },
                '2g': { price: 680, orig: 800 },
                '5g': { price: 1650, orig: 2000 }
            }
        },
        {
            id: 5,
            title: 'Pure Kashmiri Acacia Honey (Raw & Unfiltered)',
            meta: 'Honey',
            badge: '100% Natural',
            image: "{{ asset('assets/img/honey.png') }}",
            variants: {
                '250g': { price: 380, orig: 450 },
                '500g': { price: 720, orig: 850 },
                '1kg': { price: 1350, orig: 1600 }
            }
        },
        {
            id: 3,
            title: 'Premium Kashmiri Shelled Walnuts (Light Kernels)',
            meta: 'Dry Fruits',
            badge: '100% Organic',
            image: "{{ asset('assets/img/walnuts.png') }}",
            variants: {
                '250g': { price: 420, orig: 510 },
                '500g': { price: 810, orig: 1000 },
                '1kg': { price: 1580, orig: 1950 }
            }
        }
    ];

    const AlBarrWishlist = {
        get() {
            try {
                const data = localStorage.getItem('al_barr_wishlist');
                return data ? JSON.parse(data) : [];
            } catch(e) {
                console.error("Corrupt wishlist state, resetting", e);
                return [];
            }
        },

        save(list) {
            localStorage.setItem('al_barr_wishlist', JSON.stringify(list));
            this.render();
        },

        toggle(productObj) {
            let list = this.get();
            const idx = list.findIndex(item => item.id === productObj.id);

            if (idx !== -1) {
                list.splice(idx, 1);
                this.save(list);
                this.showToast(`Removed ${productObj.title} from wishlist.`);
            } else {
                list.push(productObj);
                this.save(list);
                this.showToast(`Added ${productObj.title} to wishlist!`);
            }
        },

        remove(productId) {
            let list = this.get();
            const filtered = list.filter(item => item.id !== productId);
            this.save(filtered);
            this.showToast("Removed item from wishlist.");
        },

        moveToCart(productId, title, weight, price, orig, image) {
            if (typeof AlBarrCart !== 'undefined') {
                AlBarrCart.add(productId, title, weight, parseFloat(price), parseFloat(orig), image);
                this.remove(productId);
            } else {
                console.error("Cart Engine not loaded");
            }
        },

        showToast(msg, type = 'success') {
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast(msg, type);
            } else {
                alert(msg);
            }
        },

        render() {
            const list = this.get();
            const gridContainer = document.getElementById('wishlist-grid-container');
            const emptyView = document.getElementById('wishlist-empty-view');

            if (list.length === 0) {
                gridContainer.style.display = 'none';
                emptyView.style.display = 'block';
                this.renderRecommendations();
            } else {
                emptyView.style.display = 'none';
                gridContainer.style.display = 'grid';
                gridContainer.innerHTML = '';

                list.forEach(product => {
                    const defaultWeight = Object.keys(product.variants)[0];
                    const defaultPrice = product.variants[defaultWeight].price;
                    const defaultOrig = product.variants[defaultWeight].orig;

                    const card = document.createElement('div');
                    card.className = 'wishlist-product-card';
                    card.setAttribute('data-id', product.id);

                    let selectHtml = '';
                    Object.keys(product.variants).forEach(w => {
                        selectHtml += `<option value="${w}">${w} - ₹${product.variants[w].price}</option>`;
                    });

                    card.innerHTML = `
                        <button class="wishlist-remove-btn" onclick="AlBarrWishlist.remove(${product.id})" title="Remove from wishlist">×</button>
                        <span class="wishlist-badge">${product.badge}</span>
                        
                        <div class="wishlist-img-box">
                            <img src="${product.image}" alt="${product.title}" class="wishlist-product-img" ${product.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                        </div>
                        
                        <h3 class="wishlist-product-title">${product.title}</h3>
                        <div class="wishlist-product-meta">${product.meta} • Fresh from Orchards</div>
                        
                        <div class="wishlist-variant-picker">
                            <select class="wishlist-select-input" onchange="updateCardPrice(this, ${product.id})">
                                ${selectHtml}
                            </select>
                        </div>
                        
                        <div class="wishlist-price-block">
                            <span class="wishlist-price-sale" id="sale-price-${product.id}">₹${defaultPrice.toFixed(2)}</span>
                            <span class="wishlist-price-orig" id="orig-price-${product.id}">₹${defaultOrig.toFixed(2)}</span>
                        </div>
                        
                        <button class="btn-wishlist-cart" onclick="addSelectedToCart(${product.id})">
                            🛒 Add to Cart
                        </button>
                    `;

                    gridContainer.appendChild(card);
                });
            }
        },

        renderRecommendations() {
            const recsContainer = document.getElementById('recs-grid-container');
            recsContainer.innerHTML = '';

            RECOMMENDATION_PRODUCTS.forEach(product => {
                const defaultWeight = Object.keys(product.variants)[0];
                const defaultPrice = product.variants[defaultWeight].price;
                const defaultOrig = product.variants[defaultWeight].orig;

                const card = document.createElement('div');
                card.className = 'wishlist-product-card';

                let selectHtml = '';
                Object.keys(product.variants).forEach(w => {
                    selectHtml += `<option value="${w}">${w} - ₹${product.variants[w].price}</option>`;
                });

                card.innerHTML = `
                    <span class="wishlist-badge">${product.badge}</span>
                    
                    <div class="wishlist-img-box">
                        <img src="${product.image}" alt="${product.title}" class="wishlist-product-img" ${product.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                    </div>
                    
                    <h3 class="wishlist-product-title">${product.title}</h3>
                    <div class="wishlist-product-meta">${product.meta} • Best Seller</div>
                    
                    <div class="wishlist-variant-picker">
                        <select class="wishlist-select-input" onchange="updateCardPrice(this, ${product.id}, true)">
                            ${selectHtml}
                        </select>
                    </div>
                    
                    <div class="wishlist-price-block">
                        <span class="wishlist-price-sale" id="rec-sale-price-${product.id}">₹${defaultPrice.toFixed(2)}</span>
                        <span class="wishlist-price-orig" id="rec-orig-price-${product.id}">₹${defaultOrig.toFixed(2)}</span>
                    </div>
                    
                    <button class="btn-wishlist-cart" onclick="addSelectedRecToCart(${JSON.stringify(product).replace(/"/g, '&quot;')})">
                        ❤️ Save & Add to Cart
                    </button>
                `;

                recsContainer.appendChild(card);
            });
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        const userJson = localStorage.getItem('al_barr_user');
        if (userJson) {
            try {
                const userData = JSON.parse(userJson);
                document.getElementById('profile-display-name').innerText = userData.name || 'Al Barr Patron';
                const firstLetter = (userData.name || 'A').charAt(0).toUpperCase();
                document.getElementById('profile-avatar-img').innerHTML = `${firstLetter}<div class="profile-avatar-edit-badge" title="Regenerate theme background">♻️</div>`;
            } catch(e) {}
        }

        const savedColorIdx = localStorage.getItem('al_barr_avatar_color_idx') || 0;
        applyAvatarPalette(savedColorIdx);

        AlBarrWishlist.render();
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

    function updateCardPrice(selectEl, productId, isRec = false) {
        const weight = selectEl.value;
        let product = null;

        if (isRec) {
            product = RECOMMENDATION_PRODUCTS.find(p => p.id === productId);
        } else {
            product = AlBarrWishlist.get().find(p => p.id === productId);
        }

        if (product && product.variants[weight]) {
            const salePriceSpan = document.getElementById(isRec ? `rec-sale-price-${productId}` : `sale-price-${productId}`);
            const origPriceSpan = document.getElementById(isRec ? `rec-orig-price-${productId}` : `orig-price-${productId}`);
            
            salePriceSpan.innerText = `₹${product.variants[weight].price.toFixed(2)}`;
            origPriceSpan.innerText = `₹${product.variants[weight].orig.toFixed(2)}`;
        }
    }

    function addSelectedToCart(productId) {
        const product = AlBarrWishlist.get().find(p => p.id === productId);
        if (!product) return;

        const card = document.querySelector(`.wishlist-product-card[data-id="${productId}"]`);
        const select = card.querySelector('.wishlist-select-input');
        const weight = select.value;
        const variant = product.variants[weight];

        AlBarrWishlist.moveToCart(productId, product.title, weight, variant.price, variant.orig, product.image);
    }

    function addSelectedRecToCart(product) {
        // Find selected weight
        const grid = document.getElementById('recs-grid-container');
        // Find card matching product title or construct from parameter
        const defaultWeight = Object.keys(product.variants)[0];
        
        AlBarrWishlist.toggle(product);
        if (typeof AlBarrCart !== 'undefined') {
            const variant = product.variants[defaultWeight];
            AlBarrCart.add(product.id, product.title, defaultWeight, variant.price, variant.orig, product.image);
        }
    }
</script>
@endsection
