/* Global App Controller - Autocomplete, Modal, Countdown & Add-to-Cart Hooks */

// Copy to Clipboard helper function
window.copyToClipboard = function(text, label) {
    navigator.clipboard.writeText(text).then(() => {
        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
            AlBarrCart.showToast(`${label} copied to clipboard!`);
        } else {
            alert(`${label} copied to clipboard!`);
        }
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
};

// Shared Product Mock Database for Quick View (window.AlBarrProductsDb will take precedence if loaded)
const appProductsDb = window.AlBarrProductsDb || {
    1: {
        id: 1,
        title: 'Premium Kashmiri Mamra Almonds (Raw)',
        desc: 'Kashmiri Mamra Almonds are highly prized for their high oil content and rich nutrient profile. Grown organically in local orchards, they are unpolished and 100% raw.',
        image: 'assets/img/almonds.png',
        badge: 'Valley Sourced',
        discount: '-15%',
        variants: [
            { weight: '250g', price: 850, orig: 990 },
            { weight: '500g', price: 1650, orig: 1900 },
            { weight: '1kg', price: 3200, orig: 3700 }
        ]
    },
    2: {
        id: 2,
        title: 'Kashmiri Kesar (Pure Mogra Saffron)',
        desc: 'Genuine Kashmiri Mogra Kesar representing the highest grade (A+) of flower stigma threads. Sourced directly from local farmers in Pampore. Lab certified Grade 1 quality.',
        image: 'assets/img/saffron.png',
        badge: 'Grade A+ Certified',
        discount: '-12%',
        variants: [
            { weight: '1g', price: 350, orig: 400 },
            { weight: '2g', price: 680, orig: 800 },
            { weight: '5g', price: 1650, orig: 2000 }
        ]
    },
    3: {
        id: 3,
        title: 'Premium Kashmiri Shelled Walnuts (Light Kernels)',
        desc: 'Premium grade shelled walnuts Kernels (Akhrot Giri) known for their extra light color, sweet taste, and high concentrations of Omega-3 fatty acids. Shelled carefully.',
        image: 'assets/img/walnuts.png',
        badge: '100% Organic',
        discount: '-18%',
        variants: [
            { weight: '250g', price: 420, orig: 510 },
            { weight: '500g', price: 810, orig: 1000 },
            { weight: '1kg', price: 1580, orig: 1950 }
        ]
    },
    4: {
        id: 4,
        title: 'Organic Dried Kashmiri Figs (Anjeer Garland)',
        desc: 'Rich, chewy, and naturally sweet Kashmiri Figs (Anjeer) hand-threaded into traditional garlands. Naturally sun-dried without sugar syrup, preservatives, or color treatments.',
        image: 'assets/img/figs.png',
        badge: 'High Fiber',
        discount: '-10%',
        variants: [
            { weight: '250g', price: 490, orig: 550 },
            { weight: '500g', price: 950, orig: 1080 },
            { weight: '1kg', price: 1850, orig: 2100 }
        ]
    },
    5: {
        id: 5,
        title: 'Pure Kashmiri Acacia Honey (Raw & Unfiltered)',
        desc: 'Direct from the Acacia flower valleys of J&K. This honey is light-colored, mild, and slow to crystallize. Pure, organic, cold-extracted, and unheated to preserve natural enzymes.',
        image: 'assets/img/honey.png',
        badge: '100% Natural',
        discount: '-15%',
        variants: [
            { weight: '250g', price: 380, orig: 450 },
            { weight: '500g', price: 720, orig: 850 },
            { weight: '1kg', price: 1350, orig: 1600 }
        ]
    },
    6: {
        id: 6,
        title: 'Kashmiri Shahi Zeera (Organic Black Cumin)',
        desc: 'Rare, wild black cumin harvested from the high-altitude mountain fields of Kashmir. It has a rich, earthy, aromatic flavor profiles that is far superior to standard black cumin.',
        image: 'assets/img/zeera.png',
        badge: 'Mountain Sourced',
        discount: '-17%',
        variants: [
            { weight: '100g', price: 290, orig: 350 },
            { weight: '250g', price: 680, orig: 800 },
            { weight: '500g', price: 1250, orig: 1500 }
        ]
    },
    7: {
        id: 7,
        title: 'Premium Kashmiri Pumpkin Seeds (Raw & Shelled)',
        desc: 'Raw shelled green pumpkin seeds sourced from local organic squash growers in Kashmir. Rich in zinc, magnesium, and plant-based protein. Ideal for snacking or baking.',
        image: 'assets/img/pumpkin-seeds.png',
        badge: 'Superfood Grade',
        discount: '-21%',
        variants: [
            { weight: '200g', price: 220, orig: 280 },
            { weight: '500g', price: 490, orig: 600 },
            { weight: '1kg', price: 920, orig: 1150 }
        ]
    },
    8: {
        id: 8,
        title: 'Bhaderwah Kashmiri Rajma (Premium Red Beans)',
        desc: 'World-famous small red kidney beans harvested from the pristine high valleys of Bhaderwah, J&K. Known for their distinct deep red color, sweet aroma, and soft melting textures upon cooking.',
        image: 'assets/img/rajma.png',
        badge: 'GI Tag Sourced',
        discount: '-18%',
        variants: [
            { weight: '500g', price: 180, orig: 220 },
            { weight: '1kg', price: 340, orig: 420 },
            { weight: '2kg', price: 650, orig: 800 }
        ]
    }
};

document.addEventListener('DOMContentLoaded', () => {

    // 1. Sticky Header Scroll Effect
    const header = document.querySelector('.main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            header.classList.add('scroll-scrolled');
        } else {
            header.classList.remove('scroll-scrolled');
        }
    });

    // 2. Search Autocomplete suggestions popover & filtering logic
    const productsDb = window.AlBarrProductsDb || appProductsDb;

    function renderSuggestions(query, panelId, containerId) {
        const panel = document.getElementById(panelId);
        const container = document.getElementById(containerId);
        if (!panel || !container) return;

        const filtered = Object.values(productsDb).filter(p => {
            const term = query.toLowerCase().trim();
            return p.title.toLowerCase().includes(term) || p.description.toLowerCase().includes(term);
        });

        container.innerHTML = '';
        if (filtered.length > 0) {
            filtered.forEach(p => {
                let firstPrice = 0;
                let firstWeight = '';
                if (p.variants) {
                    if (Array.isArray(p.variants) && p.variants.length > 0) {
                        firstPrice = p.variants[0].price;
                        firstWeight = p.variants[0].weight;
                    } else {
                        const keys = Object.keys(p.variants);
                        if (keys.length > 0) {
                            firstWeight = keys[0];
                            firstPrice = p.variants[firstWeight].price;
                        }
                    }
                }
                const item = document.createElement('a');
                item.href = `product.php?id=${p.id}`;
                item.className = 'prod-suggest-item';
                item.innerHTML = `
                    <img src="${p.image}" alt="${p.title}" class="prod-suggest-thumb" ${p.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                    <div class="prod-suggest-info">
                        <span class="prod-suggest-title">${p.title}</span>
                        <span class="prod-suggest-price">₹${firstPrice.toLocaleString('en-IN', { minimumFractionDigits: 2 })} - ${firstWeight}</span>
                    </div>
                `;
                container.appendChild(item);
            });
            panel.classList.add('active');
        } else {
            container.innerHTML = '<div style="padding: 10px; color: var(--color-text-secondary); font-size: 0.9rem; text-align: center;">No products found matching your search.</div>';
            panel.classList.add('active');
        }
    }

    // Dedicated Search Modal Overlay Logic
    const searchModal = document.getElementById('search-modal');
    const searchModalInput = document.getElementById('search-modal-input');
    const searchModalClose = document.getElementById('search-modal-close');
    const searchModalBackdrop = document.getElementById('search-modal-backdrop');
    const searchModalProducts = document.getElementById('search-modal-products');

    const searchInput = document.getElementById('header-search');
    const mobileSearchInput = document.getElementById('mobile-search-input');

    let initialModalProductsHtml = '';
    if (searchModalProducts) {
        initialModalProductsHtml = searchModalProducts.innerHTML;
    }

    function escapeHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function filterModalSearch(query) {
        if (!searchModalProducts) return;
        
        const term = query.toLowerCase().trim();
        if (term.length === 0) {
            searchModalProducts.innerHTML = initialModalProductsHtml;
            return;
        }

        const filtered = Object.values(productsDb).filter(p => {
            return p.title.toLowerCase().includes(term) || p.description.toLowerCase().includes(term);
        });

        searchModalProducts.innerHTML = '';
        if (filtered.length > 0) {
            filtered.forEach(p => {
                let firstPrice = 0;
                let firstWeight = '';
                if (p.variants) {
                    if (Array.isArray(p.variants) && p.variants.length > 0) {
                        firstPrice = p.variants[0].price;
                        firstWeight = p.variants[0].weight;
                    } else {
                        const keys = Object.keys(p.variants);
                        if (keys.length > 0) {
                            firstWeight = keys[0];
                            firstPrice = p.variants[firstWeight].price;
                        }
                    }
                }
                const card = document.createElement('a');
                card.href = `product.php?id=${p.id}`;
                card.className = 'search-modal-product-card';
                card.innerHTML = `
                    <img src="${p.image}" alt="${p.title}" class="search-modal-prod-img" ${p.id === 4 ? 'style="filter: hue-rotate(45deg);"' : ''}>
                    <div class="search-modal-prod-info">
                        <span class="search-modal-prod-name">${p.title}</span>
                        <span class="search-modal-prod-price">₹${firstPrice.toLocaleString('en-IN', { minimumFractionDigits: 2 })} - ${firstWeight}</span>
                    </div>
                `;
                searchModalProducts.appendChild(card);
            });
        } else {
            searchModalProducts.innerHTML = `
                <div class="search-modal-no-results">
                    <div class="no-results-icon">🔍</div>
                    <div class="no-results-text">No products found matching "<strong>${escapeHtml(query)}</strong>"</div>
                    <div class="no-results-sub">Try searching for almonds, saffron, honey, or spices.</div>
                </div>
            `;
        }
    }

    function openSearchModal(initialQuery = '') {
        if (!searchModal) return;
        searchModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        if (searchModalInput) {
            searchModalInput.value = initialQuery;
            setTimeout(() => {
                searchModalInput.focus();
            }, 50);
            filterModalSearch(initialQuery);
        }
    }

    function closeSearchModal() {
        if (!searchModal) return;
        searchModal.classList.remove('active');
        document.body.style.overflow = '';
        
        if (searchInput) searchInput.value = '';
        if (mobileSearchInput) mobileSearchInput.value = '';
        if (searchModalInput) searchModalInput.value = '';
    }

    if (searchInput) {
        searchInput.addEventListener('focus', (e) => {
            e.preventDefault();
            searchInput.blur();
            openSearchModal(searchInput.value);
        });
        searchInput.addEventListener('click', (e) => {
            e.preventDefault();
            openSearchModal(searchInput.value);
        });
    }

    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('focus', (e) => {
            e.preventDefault();
            mobileSearchInput.blur();
            openSearchModal(mobileSearchInput.value);
        });
        mobileSearchInput.addEventListener('click', (e) => {
            e.preventDefault();
            openSearchModal(mobileSearchInput.value);
        });
    }

    if (searchModalClose) {
        searchModalClose.addEventListener('click', closeSearchModal);
    }
    if (searchModalBackdrop) {
        searchModalBackdrop.addEventListener('click', closeSearchModal);
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeSearchModal();
        }
    });

    if (searchModalInput) {
        searchModalInput.addEventListener('input', (e) => {
            filterModalSearch(e.target.value);
        });
    }


    // 3. Slide Drawer Cart Panel Toggle triggers
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartBackdrop = document.getElementById('cart-backdrop');
    const cartTriggers = document.querySelectorAll('.cart-trigger');
    const cartCloseTrigger = document.getElementById('cart-close-trigger');
    const startShoppingBtn = document.getElementById('start-shopping-btn');

    function toggleCart(show = true) {
        if (!cartSidebar || !cartBackdrop) return;
        if (show) {
            cartSidebar.classList.add('active');
            cartBackdrop.classList.add('active');
        } else {
            cartSidebar.classList.remove('active');
            cartBackdrop.classList.remove('active');
        }
    }

    cartTriggers.forEach(t => t.addEventListener('click', (e) => {
        e.preventDefault();
        toggleCart(true);
    }));

    if (cartCloseTrigger) cartCloseTrigger.addEventListener('click', () => toggleCart(false));
    if (cartBackdrop) cartBackdrop.addEventListener('click', () => toggleCart(false));
    if (startShoppingBtn) startShoppingBtn.addEventListener('click', () => toggleCart(false));

    // Handle mobile sticky checkout button view click
    const mobileStickyBtn = document.getElementById('mobile-sticky-view-btn');
    if (mobileStickyBtn) {
        mobileStickyBtn.addEventListener('click', () => toggleCart(true));
    }

    // Mobile Navigation Drawer Toggle Handler
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileDrawerClose = document.getElementById('mobile-drawer-close');
    const mobileDrawerOverlay = document.getElementById('mobile-drawer-overlay');
    const drawerNavLinks = document.querySelectorAll('.drawer-nav-links li a, .mobile-bottom-link:not(.cart-trigger)');

    if (mobileMenuToggle && mobileMenuDrawer) {
        mobileMenuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            mobileMenuDrawer.classList.add('active');
        });
    }

    function closeMobileDrawer() {
        if (mobileMenuDrawer) {
            mobileMenuDrawer.classList.remove('active');
        }
    }

    if (mobileDrawerClose) {
        mobileDrawerClose.addEventListener('click', closeMobileDrawer);
    }
    if (mobileDrawerOverlay) {
        mobileDrawerOverlay.addEventListener('click', closeMobileDrawer);
    }
    drawerNavLinks.forEach(link => {
        link.addEventListener('click', closeMobileDrawer);
    });

    // Mobile Search Bar Toggle Handler
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileSearchBar = document.getElementById('mobile-search-bar');
    
    if (mobileSearchToggle && mobileSearchBar) {
        mobileSearchToggle.addEventListener('click', (e) => {
            e.preventDefault();
            mobileSearchBar.classList.toggle('active');
            if (mobileSearchBar.classList.contains('active')) {
                const input = document.getElementById('mobile-search-input');
                if (input) input.focus();
            }
        });

        // Close search bar on click outside
        document.addEventListener('click', (e) => {
            if (mobileSearchBar.classList.contains('active') &&
                !mobileSearchBar.contains(e.target) &&
                !mobileSearchToggle.contains(e.target)) {
                mobileSearchBar.classList.remove('active');
            }
        });
    }

    // 4. Flash Sale Countdown Timer
    const clock = document.getElementById('deal-countdown');
    if (clock) {
        let totalSeconds = parseFloat(clock.getAttribute('data-hours')) * 60 * 60;
        
        const timer = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(timer);
                return;
            }
            totalSeconds--;

            const days = Math.floor(totalSeconds / (24 * 3600));
            const hours = Math.floor((totalSeconds % (24 * 3600)) / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);

            const dEl = document.getElementById('cd-days');
            const hEl = document.getElementById('cd-hours');
            const mEl = document.getElementById('cd-mins');
            const sEl = document.getElementById('cd-secs');

            if (dEl) dEl.innerText = days.toString().padStart(2, '0');
            if (hEl) hEl.innerText = hours.toString().padStart(2, '0');
            if (mEl) mEl.innerText = minutes.toString().padStart(2, '0');
            if (sEl) sEl.innerText = seconds.toString().padStart(2, '0');
        }, 1000);
    }

    // 5. Variant Pills and Dropdowns Selection Handler
    document.addEventListener('click', (e) => {
        const pill = e.target.closest('.variant-pill');
        if (!pill) return;

        // Find parent container (card, page column, or quick view modal)
        const container = pill.closest('.product-card, .product-page-columns, .modal-content-box');
        if (!container) return;

        // Toggle active classes on pills
        container.querySelectorAll('.variant-pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');

        // Extract values
        const pid = parseInt(container.getAttribute('data-product-id'));
        const price = parseFloat(pill.getAttribute('data-price'));
        const orig = parseFloat(pill.getAttribute('data-orig'));

        // Update price labels in the container
        const currentPriceLabel = container.querySelector('.price-current, #detail-current-price, #qv-current-price, #price-current-' + pid);
        const originalPriceLabel = container.querySelector('.price-original, #detail-original-price, #qv-original-price, #price-orig-' + pid);
        const discountTag = container.querySelector('#detail-discount-tag');

        if (currentPriceLabel) {
            currentPriceLabel.innerText = `₹${price.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
        }
        if (originalPriceLabel) {
            originalPriceLabel.innerText = `₹${orig.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
        }
        if (discountTag && orig > price) {
            const savings = orig - price;
            const percentage = Math.round((savings / orig) * 100);
            discountTag.innerText = `SAVE ${percentage}%`;
        }

        // Sync visual counter buttons state
        if (window.AlBarrCart) {
            window.AlBarrCart.syncUI();
        }
    });

    document.querySelectorAll('select.variant-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', (e) => {
            const pid = parseInt(dropdown.getAttribute('data-product-id'));
            const option = dropdown.options[dropdown.selectedIndex];
            const price = parseFloat(option.getAttribute('data-price'));
            const orig = parseFloat(option.getAttribute('data-orig'));

            const priceLabel = document.getElementById(`price-current-${pid}`);
            const origLabel = document.getElementById(`price-orig-${pid}`);

            if (priceLabel) priceLabel.innerText = `₹${price.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
            if (origLabel) origLabel.innerText = `₹${orig.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

            // Sync with global cart counter states
            AlBarrCart.syncUI();
        });
    });

    // 6. Blinkit Add Button Listeners (Product listings)
    document.querySelectorAll('.product-card, .product-page-columns').forEach(card => {
        const pid = parseInt(card.getAttribute('data-product-id'));
        if (!pid) return;

        const addBtn = card.querySelector('.add-btn-init');
        const plusBtn = card.querySelector('.btn-plus');
        const minusBtn = card.querySelector('.btn-minus');

        if (addBtn) {
            addBtn.addEventListener('click', (e) => {
                e.preventDefault();
                triggerAddToCart(pid, card);
            });
        }

        if (plusBtn) {
            plusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                adjustQuantity(pid, card, 1);
            });
        }

        if (minusBtn) {
            minusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                adjustQuantity(pid, card, -1);
            });
        }
    });

    // Central function to trigger add
    function triggerAddToCart(pid, container) {
        // Find product specs
        const title = container.querySelector('.product-title a, h1')?.innerText || "Kashmiri Harvest Item";
        const img = container.querySelector('.product-image, #main-product-img')?.getAttribute('src') || "assets/img/almonds.png";
        
        let selectedWeight = '250g';
        let price = 0;
        let orig = 0;

        // Check if page has variant pills
        const activePill = container.querySelector('.variant-pill.active');
        const dropdown = container.querySelector('select.variant-dropdown');

        if (activePill) {
            selectedWeight = activePill.getAttribute('data-weight');
            price = parseFloat(activePill.getAttribute('data-price'));
            orig = parseFloat(activePill.getAttribute('data-orig'));
        } else if (dropdown) {
            const option = dropdown.options[dropdown.selectedIndex];
            selectedWeight = dropdown.value;
            price = parseFloat(option.getAttribute('data-price'));
            orig = parseFloat(option.getAttribute('data-orig'));
        } else if (pid === 2) {
            selectedWeight = '1g'; // Default Saffron
            price = 350;
            orig = 400;
        }

        AlBarrCart.add(pid, title, selectedWeight, price, orig, img);
    }

    // Central quantity adjuster
    function adjustQuantity(pid, container, offset) {
        let selectedWeight = '250g';
        const activePill = container.querySelector('.variant-pill.active');
        const dropdown = container.querySelector('select.variant-dropdown');

        if (activePill) {
            selectedWeight = activePill.getAttribute('data-weight');
        } else if (dropdown) {
            selectedWeight = dropdown.value;
        } else if (pid === 2) {
            selectedWeight = '1g';
        }

        const cart = AlBarrCart.get();
        const item = cart.find(x => x.id === pid && x.weight === selectedWeight);
        if (item) {
            AlBarrCart.updateQty(pid, selectedWeight, item.qty + offset);
        }
    }

    // 7. Quick View Modal Trigger details
    const qvModal = document.getElementById('quick-view-modal');
    const qvCloseBtn = document.getElementById('qv-close-btn');
    const qvTriggers = document.querySelectorAll('.product-quick-view-btn');

    function openQuickView(pid) {
        const item = appProductsDb[pid];
        if (!item || !qvModal) return;

        // Populate fields
        document.getElementById('qv-product-title').innerText = item.title;
        document.getElementById('qv-product-description').innerText = item.desc || item.description || "";
        
        const qvImg = document.getElementById('qv-product-image');
        qvImg.setAttribute('src', item.image);
        if (pid === 4) {
            qvImg.style.filter = 'hue-rotate(45deg)';
        } else {
            qvImg.style.filter = 'none';
        }

        document.getElementById('qv-badge-label').innerText = item.badge || "";

        // Normalize variants (handles both sequential array and key-value associative object)
        let variantsArray = [];
        if (Array.isArray(item.variants)) {
            variantsArray = item.variants;
        } else if (item.variants && typeof item.variants === 'object') {
            variantsArray = Object.entries(item.variants).map(([weight, data]) => {
                return {
                    weight: weight,
                    price: data.price,
                    orig: data.orig
                };
            });
        }

        // Compute discount percentage dynamically if missing
        let discountPct = item.discount;
        if (!discountPct && variantsArray.length > 0) {
            const first = variantsArray[0];
            if (first.orig > first.price) {
                const pct = Math.round(((first.orig - first.price) / first.orig) * 100);
                discountPct = `-${pct}%`;
            } else {
                discountPct = '';
            }
        }
        document.getElementById('qv-discount-badge').innerText = discountPct || '';
        if (discountPct) {
            document.getElementById('qv-discount-badge').style.display = 'inline-block';
        } else {
            document.getElementById('qv-discount-badge').style.display = 'none';
        }

        // Set cart buttons reference attributes
        const modalContainer = qvModal.querySelector('.modal-content-box');
        modalContainer.setAttribute('data-product-id', pid);

        const cartBtnBox = document.getElementById('qv-cart-control-btn');
        if (cartBtnBox) cartBtnBox.setAttribute('data-product-id', pid);

        // Populate variants pills
        const pillsContainer = document.getElementById('qv-variant-pills-container');
        if (pillsContainer) {
            pillsContainer.innerHTML = '';
            variantsArray.forEach((v, idx) => {
                const btn = document.createElement('button');
                btn.className = `variant-pill ${idx === 0 ? 'active' : ''}`;
                btn.setAttribute('data-weight', v.weight);
                btn.setAttribute('data-price', v.price);
                btn.setAttribute('data-orig', v.orig);
                btn.innerHTML = `
                    <span class="pill-weight">${v.weight}</span>
                    <span class="pill-price">₹${v.price}</span>
                `;
                pillsContainer.appendChild(btn);
            });
        }

        // Set initial pricing
        if (variantsArray.length > 0) {
            const firstVariant = variantsArray[0];
            document.getElementById('qv-current-price').innerText = `₹${firstVariant.price.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
            document.getElementById('qv-original-price').innerText = `₹${firstVariant.orig.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
        }

        // Open modal
        qvModal.classList.add('active');
        
        // Sync button layouts inside modal
        AlBarrCart.syncUI();
    }

    qvTriggers.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const pid = parseInt(btn.getAttribute('data-product-id'));
            openQuickView(pid);
        });
    });

    if (qvCloseBtn) {
        qvCloseBtn.addEventListener('click', () => qvModal.classList.remove('active'));
    }

    if (qvModal) {
        qvModal.addEventListener('click', (e) => {
            if (e.target === qvModal) qvModal.classList.remove('active');
        });
    }

    // Modal variant dropdown selection change (Handled via generic .variant-pill listener)

    // Modal Blinkit Add triggers
    const qvAdd = document.getElementById('qv-add-btn');
    const qvPlus = document.getElementById('qv-qty-plus');
    const qvMinus = document.getElementById('qv-qty-minus');

    if (qvAdd) {
        qvAdd.addEventListener('click', (e) => {
            const modalContainer = qvModal.querySelector('.modal-content-box');
            const pid = parseInt(modalContainer.getAttribute('data-product-id'));
            triggerAddToCart(pid, modalContainer);
        });
    }

    if (qvPlus) {
        qvPlus.addEventListener('click', () => {
            const modalContainer = qvModal.querySelector('.modal-content-box');
            const pid = parseInt(modalContainer.getAttribute('data-product-id'));
            adjustQuantity(pid, modalContainer, 1);
        });
    }

    if (qvMinus) {
        qvMinus.addEventListener('click', () => {
            const modalContainer = qvModal.querySelector('.modal-content-box');
            const pid = parseInt(modalContainer.getAttribute('data-product-id'));
            adjustQuantity(pid, modalContainer, -1);
        });
    }

    // 8. Promo Code coupon logic ("KHALIS10" matches 10% discount)
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const couponInput = document.getElementById('cart-coupon-code');

    if (applyCouponBtn && couponInput) {
        applyCouponBtn.addEventListener('click', () => {
            const code = couponInput.value.trim().toUpperCase();
            if (code === 'KHALIS10') {
                sessionStorage.setItem('al_barr_coupon_applied', 'true');
                AlBarrCart.syncUI();
                AlBarrCart.showToast("Coupon 'KHALIS10' applied! 10% Discount added.");
            } else {
                AlBarrCart.showToast("Invalid promo code! Try 'KHALIS10'.");
            }
        });
    }

    // Direct Buy Now button on Product Page
    const buyNowBtn = document.getElementById('detail-buy-now-btn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', () => {
            const pageContainer = document.querySelector('.product-page-columns');
            const pid = parseInt(pageContainer.getAttribute('data-product-id'));
            
            // Trigger cart addition first
            triggerAddToCart(pid, pageContainer);
            
            // Redirect or trigger cart drawer
            toggleCart(true);
        });
    }

    // 9. Carousel Scroll Arrows & Drag-to-Scroll Support
    document.querySelectorAll('.carousel-outer-wrap').forEach(wrap => {
        const container = wrap.querySelector('.carousel-container-scroll');
        const prevBtn = wrap.querySelector('.carousel-arrow-btn.prev');
        const nextBtn = wrap.querySelector('.carousel-arrow-btn.next');

        if (!container) return;

        // Arrow Scroll Controls
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                const scrollAmount = container.clientWidth * 0.75;
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                const scrollAmount = container.clientWidth * 0.75;
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }

        // Mouse Drag to Scroll
        let isDown = false;
        let startX;
        let scrollLeft;

        container.addEventListener('mousedown', (e) => {
            isDown = true;
            container.classList.add('active-dragging');
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });

        container.addEventListener('mouseleave', () => {
            isDown = false;
            container.classList.remove('active-dragging');
        });

        container.addEventListener('mouseup', () => {
            isDown = false;
            container.classList.remove('active-dragging');
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 1.5; // scroll speed multiplier
            container.scrollLeft = scrollLeft - walk;
        });
    });

    // User Dropdown Interaction Handler (Accessibility & Mobile Touch support)
    const userDropdownWrapper = document.getElementById('user-dropdown-wrapper');
    if (userDropdownWrapper) {
        const trigger = userDropdownWrapper.querySelector('.user-action-badge');
        
        if (trigger) {
            // Toggle on click/tap
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const isActive = userDropdownWrapper.classList.contains('active');
                
                // Toggle active state
                if (isActive) {
                    userDropdownWrapper.classList.remove('active');
                    trigger.setAttribute('aria-expanded', 'false');
                } else {
                    userDropdownWrapper.classList.add('active');
                    trigger.setAttribute('aria-expanded', 'true');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userDropdownWrapper.contains(e.target)) {
                    userDropdownWrapper.classList.remove('active');
                    trigger.setAttribute('aria-expanded', 'false');
                }
            });

            // Close dropdown when pressing Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    userDropdownWrapper.classList.remove('active');
                    trigger.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    // 7. Redirect to checkout page on Proceed to Checkout click
    const checkoutBtn = document.getElementById('drawer-checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const cart = (typeof AlBarrCart !== 'undefined') ? AlBarrCart.get() : [];
            if (cart.length === 0) {
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast("Your cart is empty! Add products to proceed.", "error");
                } else {
                    alert("Your cart is empty!");
                }
                return;
            }
            window.location.href = 'checkout.php';
        });
    }
});
