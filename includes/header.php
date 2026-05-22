<?php
// Load products database
$db_file = __DIR__ . '/products-db.php';
$hdr_products = file_exists($db_file) ? include($db_file) : [];
?>
<script>
window.AlBarrProductsDb = <?php echo json_encode($hdr_products); ?>;
</script>

<!-- Top Utility / Announcement Bar -->
<div class="announcement-bar">
    <div class="container announcement-container">
        <div class="announcement-left">
            <span class="location-widget">
                <svg class="icon-pin" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span class="location-pulse"></span>
                <strong>Deliver to J&K</strong> <span class="loc-sep">•</span> <span class="loc-sub">Srinagar & Jammu Valleys</span>
            </span>
        </div>
        <div class="announcement-center">
            <div class="announcement-marquee-track">
                <span class="announcement-promo">
                    ✨ FREE Express Delivery on Orders Above ₹999! &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 🔒 FSSAI Verified &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 📦 Cash on Delivery Available &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; ⭐ 500+ Happy Customers &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                </span>
                <span class="announcement-promo">
                    ✨ FREE Express Delivery on Orders Above ₹999! &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 🔒 FSSAI Verified &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 📦 Cash on Delivery Available &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; ⭐ 500+ Happy Customers &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                </span>
            </div>
        </div>
        <div class="announcement-right">
            <a href="tel:+919419000000" class="announcement-link">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                Support: +91-9419000000
            </a>
            <a href="#footer-bank-details" class="announcement-link nav-bank-link">
                💳 Direct Bank Details
            </a>
        </div>
    </div>
</div>

<!-- Main Sticky Header -->
<header class="main-header">
    <div class="container header-grid-container">
        
        <!-- Hamburger Menu Button (Mobile) -->
        <button class="mobile-menu-toggle-btn" id="mobile-menu-toggle" aria-label="Open Menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <!-- Brand Logo Area & Desktop Location Quick-Selector -->
        <div class="brand-group">
            <div class="logo-area">
                <a href="index.php" class="logo-link">
                    <div class="logo-badge-container">
                        <img src="assets/img/logo.png" alt="Al barr logo" class="logo-image">
                    </div>
                    <div class="logo-text">
                        <span class="brand-name">Al barr</span>
                        <span class="brand-tagline">Khalis Wa Shifaf</span>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Location Quick-Selector -->
            <div class="desktop-location-selector">
                <svg class="loc-pin-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <div class="loc-info">
                    <span class="loc-deliver">Deliver to Srinagar</span>
                    <span class="loc-region">Jammu & Kashmir Valleys</span>
                </div>
            </div>
        </div>

        <!-- Search Bar (Desktop / Center Hub) -->
        <div class="search-wrapper">
            <div class="search-form">
                <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="header-search" class="search-input" placeholder="Search premium almonds, Mogra saffron, wild honey..." autocomplete="off">
                <span class="search-accent-pill">100% Organic</span>
            </div>
            
            <!-- Autocomplete suggestions panel -->
            <div class="search-results-panel" id="search-panel">
                <div class="results-grid">
                    <div class="results-column suggestions-col">
                        <div class="results-title">🔥 Trending Searches</div>
                        <ul class="suggestions-list">
                            <?php if (!empty($hdr_products)): ?>
                                <?php foreach (array_slice($hdr_products, 0, 3) as $p): ?>
                                    <li><a href="product.php?id=<?php echo $p['id']; ?>"><span style="color: var(--color-gold);">★</span> <?php echo htmlspecialchars($p['title']); ?></a></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><a href="product.php?id=1"><span style="color: var(--color-gold);">★</span> Kashmiri Mamra Almonds</a></li>
                                <li><a href="product.php?id=2"><span style="color: var(--color-gold);">★</span> Mogra Saffron</a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="results-title" style="margin-top: var(--spacing-md);">🛍️ Popular Categories</div>
                        <ul class="suggestions-list">
                            <li><a href="index.php#categories-section">Dry Fruits</a></li>
                            <li><a href="index.php#categories-section">Spices & Saffron</a></li>
                            <li><a href="index.php#categories-section">Honey & Seeds</a></li>
                        </ul>
                    </div>
                    <div class="results-column products-col">
                        <div class="results-title">📦 Matching Products</div>
                        <div class="products-suggestions" id="search-suggestions-container">
                            <?php if (!empty($hdr_products)): ?>
                                <?php foreach (array_slice($hdr_products, 0, 3) as $p): ?>
                                    <a href="product.php?id=<?php echo $p['id']; ?>" class="prod-suggest-item">
                                        <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" class="prod-suggest-thumb" <?php if ($p['id'] === 4) echo 'style="filter: hue-rotate(45deg);"'; ?>>
                                        <div class="prod-suggest-info">
                                            <span class="prod-suggest-title"><?php echo htmlspecialchars($p['title']); ?></span>
                                            <span class="prod-suggest-price">₹<?php echo number_format($p['variants'][array_key_first($p['variants'])]['price'], 2); ?> - <?php echo array_key_first($p['variants']); ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilities / Actions -->
        <div class="header-actions">
            <!-- Mobile Search Icon Trigger (Dummy button to satisfy JS events but hidden in desktop CSS) -->
            <button class="mobile-search-toggle-btn" id="mobile-search-toggle" aria-label="Toggle Search" style="display: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>

            <!-- Support Action Badge -->
            <a href="https://wa.me/919419000000?text=Hello%20Al%20barr%20Team" target="_blank" class="header-action-badge whatsapp-action">
                <div class="badge-icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </div>
                <div class="badge-texts">
                    <span class="badge-lbl">Need Help?</span>
                    <span class="badge-val">Chat Support</span>
                </div>
            </a>

            <!-- User Account Mock Badge Dropdown -->
            <div class="user-dropdown-wrapper" id="user-dropdown-wrapper">
                <div class="header-action-badge user-action-badge" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <div class="badge-icon-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="badge-texts">
                        <span class="badge-lbl">Welcome</span>
                        <span class="badge-val" style="display: flex; align-items: center; gap: 4px;">Sign In <svg class="badge-arrow-down" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 2px; transition: transform var(--transition-fast);"><polyline points="6 9 12 15 18 9"></polyline></svg></span>
                    </div>
                </div>
                <div class="user-dropdown-menu" id="user-dropdown-menu">
                    <div class="dropdown-header">
                        <p class="dropdown-welcome">Welcome to Al Barr</p>
                        <p class="dropdown-subtext">Access your account & orders</p>
                        <div class="dropdown-actions-row">
                            <a href="#signin-modal" class="dropdown-btn btn-signin">Sign In</a>
                            <a href="#signup-modal" class="dropdown-btn btn-signup">Sign Up</a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="dropdown-menu-list">
                        <li>
                            <a href="#" class="dropdown-menu-item">
                                <span class="item-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </span>
                                <span class="item-label">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-menu-item">
                                <span class="item-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                </span>
                                <span class="item-label">My Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-menu-item">
                                <span class="item-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </span>
                                <span class="item-label">Wishlist</span>
                            </a>
                        </li>
                        <li>
                            <a href="#footer-bank-details" class="dropdown-menu-item nav-bank-link">
                                <span class="item-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </span>
                                <span class="item-label">Bank Details</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/919419000000?text=Hello%20Al%20barr%20Team" target="_blank" class="dropdown-menu-item">
                                <span class="item-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                </span>
                                <span class="item-label">Chat Support</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Luxury Cart Pill Button -->
            <a href="#" class="header-cart-pill cart-trigger" id="header-cart-btn">
                <div class="cart-pill-left">
                    <div class="cart-pill-icon-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="cart-badge" id="cart-global-badge">0</span>
                    </div>
                    <div class="cart-pill-details">
                        <span class="cart-pill-title">My Cart</span>
                    </div>
                </div>
                <div class="cart-pill-right">
                    <span class="cart-pill-total" id="cart-global-total">₹0.00</span>
                    <svg class="cart-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Mobile Integrated Search Bar (Always visible below logo row on mobile, matching modern app layouts) -->
    <div class="mobile-search-bar-wrapper active" id="mobile-search-bar">
        <div class="container">
            <div class="search-form">
                <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="mobile-search-input" class="search-input" placeholder="Search almonds, saffron, honey, seeds..." autocomplete="off">
            </div>
            <!-- Mobile autocomplete suggestions panel -->
            <div class="search-results-panel" id="mobile-search-panel">
                <div class="results-section">
                    <div class="results-title">🔥 Trending Searches</div>
                    <ul class="suggestions-list">
                        <?php if (!empty($hdr_products)): ?>
                            <?php foreach (array_slice($hdr_products, 0, 3) as $p): ?>
                                <li><a href="product.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['title']); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="results-section">
                    <div class="results-title">📦 Products Found</div>
                    <div class="products-suggestions" id="mobile-search-suggestions-container">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Category Navigation Bar (Desktop Only) -->
    <nav class="header-nav-bar">
        <div class="container nav-container">
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop All</a></li>
                <li><a href="shop.php?category=dry-fruits">Dry Fruits & Nuts</a></li>
                <li><a href="shop.php?category=spices">Saffron & Spices</a></li>
                <li><a href="shop.php?category=honey">Pure Honey</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php#offers-section" class="nav-highlight">Special Offers <span class="hot-badge">HOT</span></a></li>
            </ul>
        </div>
    </nav>
</header>

<!-- Mobile Navigation Drawer -->
<div class="mobile-menu-drawer" id="mobile-menu-drawer">
    <div class="drawer-overlay" id="mobile-drawer-overlay"></div>
    <div class="drawer-content">
        <div class="drawer-header">
            <div class="drawer-logo">
                <img src="assets/img/logo.png" alt="Al barr logo" class="logo-image">
                <div class="logo-text">
                    <span class="brand-name">Al barr</span>
                    <span class="brand-tagline">Khalis Wa Shifaf</span>
                </div>
            </div>
            <button class="drawer-close-btn" id="mobile-drawer-close" aria-label="Close menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="drawer-body">
            <!-- Mobile User Panel -->
            <div class="drawer-user-panel">
                <div class="drawer-user-info">
                    <div class="drawer-user-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="drawer-user-texts">
                        <span class="drawer-user-welcome">Welcome, Guest</span>
                        <span class="drawer-user-sub">Access account & orders</span>
                    </div>
                </div>
                <div class="drawer-user-actions">
                    <a href="#signin-modal" class="drawer-user-btn btn-signin">Sign In</a>
                    <a href="#signup-modal" class="drawer-user-btn btn-signup">Sign Up</a>
                </div>
            </div>
            <div class="drawer-divider-line"></div>

            <ul class="drawer-nav-links">
                <li><a href="index.php"><span class="drawer-icon">🏠</span> Home</a></li>
                <li><a href="shop.php"><span class="drawer-icon">🛍️</span> Shop All</a></li>
                <li><a href="shop.php?category=dry-fruits"><span class="drawer-icon">🥜</span> Dry Fruits & Nuts</a></li>
                <li><a href="shop.php?category=spices"><span class="drawer-icon">🌸</span> Mogra Saffron</a></li>
                <li><a href="shop.php?category=honey"><span class="drawer-icon">🍯</span> Pure Honey</a></li>
                <li><a href="about.php"><span class="drawer-icon">🌿</span> About Us</a></li>
                <li><a href="contact.php"><span class="drawer-icon">📞</span> Contact Us</a></li>
                <li><a href="index.php#offers-section" class="nav-highlight"><span class="drawer-icon">🎁</span> Special Offers</a></li>
            </ul>
            
            <div class="drawer-contact-info">
                <h4>Customer Support</h4>
                <a href="tel:+919419000000" class="drawer-contact-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    Call Support (+91-9419000000)
                </a>
                <a href="https://wa.me/919419000000?text=Hello%20Al%20barr%20Team" class="drawer-contact-btn whatsapp-btn" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    Chat on WhatsApp
                </a>
            </div>
            
            <div class="drawer-regulatory-badges">
                <div class="reg-badge-mini">🛡️ FSSAI: 11025430000232</div>
                <div class="reg-badge-mini">💼 GSTIN: 01ACFFM4729H1ZF</div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Mobile Bottom Navigation Bar (Frosted glass capsule) -->
<nav class="mobile-bottom-nav">
    <ul class="mobile-bottom-nav-list">
        <li class="mobile-bottom-item">
            <a href="index.php" class="mobile-bottom-link active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Home</span>
            </a>
        </li>
        <li class="mobile-bottom-item">
            <a href="index.php#categories-section" class="mobile-bottom-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                <span>Categories</span>
            </a>
        </li>
        <li class="mobile-bottom-item">
            <a href="index.php#offers-section" class="mobile-bottom-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                <span>Offers</span>
            </a>
        </li>
        <li class="mobile-bottom-item">
            <a href="#" class="mobile-bottom-link cart-trigger" id="mobile-cart-trigger-btn">
                <div style="position: relative; display: inline-block;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span class="cart-badge" id="cart-mobile-badge">0</span>
                </div>
                <span>Cart</span>
            </a>
        </li>
        <li class="mobile-bottom-item">
            <a href="#footer-bank-details" class="mobile-bottom-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <span>Payment</span>
            </a>
        </li>
    </ul>
</nav>

<!-- Search Modal Overlay -->
<div class="search-modal-overlay" id="search-modal">
    <div class="search-modal-backdrop" id="search-modal-backdrop"></div>
    <div class="search-modal-body">
        <!-- Close -->
        <button class="search-modal-close" id="search-modal-close" aria-label="Close search">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>

        <!-- Search input -->
        <div class="search-modal-input-wrap">
            <svg class="search-modal-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" class="search-modal-input" id="search-modal-input" placeholder="Search almonds, saffron, honey, spices..." autocomplete="off" autofocus>
        </div>

        <!-- Results area -->
        <div class="search-modal-results" id="search-modal-results">
            <div class="search-modal-grid">
                <!-- Left: Trending + Categories -->
                <div class="search-modal-col">
                    <div class="search-modal-section-title">🔥 Trending Searches</div>
                    <ul class="search-modal-list" id="search-modal-trending">
                        <?php if (!empty($hdr_products)): ?>
                            <?php foreach (array_slice($hdr_products, 0, 4) as $p): ?>
                                <li><a href="product.php?id=<?php echo $p['id']; ?>" class="search-modal-link"><span class="search-modal-star">★</span> <?php echo htmlspecialchars($p['title']); ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="product.php?id=1" class="search-modal-link"><span class="search-modal-star">★</span> Kashmiri Mamra Almonds</a></li>
                            <li><a href="product.php?id=2" class="search-modal-link"><span class="search-modal-star">★</span> Mogra Saffron</a></li>
                        <?php endif; ?>
                    </ul>

                    <div class="search-modal-section-title" style="margin-top: 20px;">🛍️ Popular Categories</div>
                    <ul class="search-modal-list">
                        <li><a href="index.php#categories-section" class="search-modal-link">Dry Fruits</a></li>
                        <li><a href="index.php#categories-section" class="search-modal-link">Spices & Saffron</a></li>
                        <li><a href="index.php#categories-section" class="search-modal-link">Honey & Seeds</a></li>
                        <li><a href="index.php#categories-section" class="search-modal-link">Kashmiri Pulses</a></li>
                    </ul>
                </div>

                <!-- Right: Product matches -->
                <div class="search-modal-col">
                    <div class="search-modal-section-title">📦 Products</div>
                    <div class="search-modal-products" id="search-modal-products">
                        <?php if (!empty($hdr_products)): ?>
                            <?php foreach (array_slice($hdr_products, 0, 4) as $p): ?>
                                <a href="product.php?id=<?php echo $p['id']; ?>" class="search-modal-product-card">
                                    <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" class="search-modal-prod-img">
                                    <div class="search-modal-prod-info">
                                        <span class="search-modal-prod-name"><?php echo htmlspecialchars($p['title']); ?></span>
                                        <span class="search-modal-prod-price">₹<?php echo number_format($p['variants'][array_key_first($p['variants'])]['price'], 2); ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
