<?php
// Load products database
$db_file = __DIR__ . '/includes/products-db.php';
$products = file_exists($db_file) ? include($db_file) : [];

// Helper function to render product card
function renderProductCard($p) {
    $first_weight = array_key_first($p['variants']);
    $first_variant = $p['variants'][$first_weight];
    $discount_pct = 0;
    if ($first_variant['orig'] > $first_variant['price']) {
        $discount_pct = round((($first_variant['orig'] - $first_variant['price']) / $first_variant['orig']) * 100);
    }
    
    // Custom filter for dried figs styling
    $img_style = '';
    if ($p['id'] == 4) {
        $img_style = 'style="filter: hue-rotate(45deg);"';
    }
    
    ob_start();
    ?>
    <div class="product-card" data-product-id="<?php echo $p['id']; ?>">
        <div class="product-badge-wrap">
            <?php if ($discount_pct > 0): ?>
                <span class="badge badge-discount">-<?php echo $discount_pct; ?>%</span>
            <?php endif; ?>
            <?php if (!empty($p['badge'])): ?>
                <span class="badge badge-sale" style="background-color: var(--color-gold-light); color: var(--color-gold);"><?php echo htmlspecialchars($p['badge']); ?></span>
            <?php endif; ?>
        </div>
        <div class="product-image-wrapper">
            <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" class="product-image" <?php echo $img_style; ?>>
            <a href="#" class="product-quick-view-btn" data-product-id="<?php echo $p['id']; ?>">Quick View</a>
        </div>
        <div class="product-details">
            <span class="product-meta"><?php echo htmlspecialchars($p['meta']); ?></span>
            <h3 class="product-title"><a href="product.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['title']); ?></a></h3>
            <div class="product-rating">
                <?php 
                $rating = isset($p['rating']) ? intval($p['rating']) : 5;
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $rating ? '★' : '☆';
                }
                ?>
                <span class="product-rating-count">(<?php echo isset($p['reviews']) ? $p['reviews'] : 0; ?>)</span>
            </div>
            
            <div class="product-variant-selector">
                <select class="variant-dropdown" data-product-id="<?php echo $p['id']; ?>">
                    <?php foreach ($p['variants'] as $weight => $data): ?>
                        <option value="<?php echo htmlspecialchars($weight); ?>" data-price="<?php echo $data['price']; ?>" data-orig="<?php echo $data['orig']; ?>">
                            <?php echo htmlspecialchars($weight); ?> - ₹<?php echo number_format($data['price'], 2); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="product-purchase-footer">
                <div class="product-price-info">
                    <span class="price-current" id="price-current-<?php echo $p['id']; ?>">₹<?php echo number_format($first_variant['price'], 2); ?></span>
                    <span class="price-original" id="price-orig-<?php echo $p['id']; ?>">₹<?php echo number_format($first_variant['orig'], 2); ?></span>
                </div>
                
                <div class="cart-control-btn" data-product-id="<?php echo $p['id']; ?>">
                    <button class="add-btn-init">
                        <span>ADD</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="qty-counter-active">
                        <button class="qty-btn btn-minus">−</button>
                        <span class="qty-val">1</span>
                        <button class="qty-btn btn-plus">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Al Barr (Khalis Wa Shifaf) - Direct from Srinagar, J&K. Buy premium organic dry fruits, Kashmiri Mogra Saffron (Kesar), raw walnuts, organic pulses, dried seeds, and local spices.">
    <title>Al Barr | Khalis Wa Shifaf - Premium Kashmiri Dry Fruits & Saffron</title>
    
    <!-- PWA & Mobile Optimization -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <!-- CSS Foundations -->
    <link rel="stylesheet" href="assets/css/variables.css?v=20260522m">
    <link rel="stylesheet" href="assets/css/main.css?v=20260522m">
    <link rel="stylesheet" href="assets/css/components.css?v=20260522m">
</head>
<body>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

    <!-- Main Hero Slider -->
    <section class="hero-slider" aria-label="Hero Showcase" id="hero-showcase-section">
        <!-- Prev Arrow -->
        <button class="hero-arrow hero-arrow-prev" aria-label="Previous Slide" id="hero-prev-btn">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <div class="slide-list" id="hero-slider-list">
            <!-- Slide 1: Dry Fruits -->
            <div class="slide-item active" id="hero-slide-1">
                <a href="#featured-section" class="slide-banner-link" aria-label="Explore Dry Fruits Collection">
                    <picture>
                        <!-- Mobile Banner (Square 1:1) -->
                        <source media="(max-width: 768px)" srcset="assets/img/banner-dryfruits-mobile.png 1x, assets/img/banner-dryfruits-mobile-2x.png 2x">
                        <!-- Desktop Banner (Wide) -->
                        <img src="assets/img/banner-dryfruits-desktop.png" srcset="assets/img/banner-dryfruits-desktop-2x.png 2x" alt="Premium Kashmiri Dry Fruits - Sourced direct from Zakura orchards. 100% Organic & Hand-picked." class="hero-banner-img">
                    </picture>
                </a>
            </div>
            
            <!-- Slide 2: Saffron -->
            <div class="slide-item" id="hero-slide-2">
                <a href="product.php?id=2" class="slide-banner-link" aria-label="Shop Pure Mogra Saffron">
                    <picture>
                        <!-- Mobile Banner (Square 1:1) -->
                        <source media="(max-width: 768px)" srcset="assets/img/banner-saffron-mobile.png 1x, assets/img/banner-saffron-mobile-2x.png 2x">
                        <!-- Desktop Banner (Wide) -->
                        <img src="assets/img/banner-saffron-desktop.png" srcset="assets/img/banner-saffron-desktop-2x.png 2x" alt="Pure Mogra Saffron - Grade A+ Certified, Highest Crocin Concentration." class="hero-banner-img">
                    </picture>
                </a>
            </div>
        </div>

        <!-- Next Arrow -->
        <button class="hero-arrow hero-arrow-next" aria-label="Next Slide" id="hero-next-btn">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        <!-- Slider Navigation Dots -->
        <div class="slider-controls" id="hero-slider-dots">
            <span class="slider-dot active" data-slide="0"></span>
            <span class="slider-dot" data-slide="1"></span>
        </div>
    </section>

    <!-- Trust Badges Bar (Premium) -->
    <section class="trust-bar-section" id="trust-bar-section">
        <div class="container">
            <div class="trust-badges-row" id="trust-badges-grid">

                <!-- Badge 1 -->
                <div class="trust-badge-card">
                    <div class="trust-icon-wrap trust-icon-green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div class="trust-text-wrap">
                        <strong class="trust-title">FSSAI Verified Purity</strong>
                        <span class="trust-sub">Lic: 11025430000232</span>
                    </div>
                </div>

                <div class="trust-badge-divider"></div>

                <!-- Badge 2 -->
                <div class="trust-badge-card">
                    <div class="trust-icon-wrap trust-icon-gold">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7l9-4 9 4M3 17l9 4 9-4M3 12l9 4 9-4"/></svg>
                    </div>
                    <div class="trust-text-wrap">
                        <strong class="trust-title">Kashmiri Heritage Sourced</strong>
                        <span class="trust-sub">Direct from Zakura &amp; Raj Bagh</span>
                    </div>
                </div>

                <div class="trust-badge-divider"></div>

                <!-- Badge 3 -->
                <div class="trust-badge-card">
                    <div class="trust-icon-wrap trust-icon-blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <div class="trust-text-wrap">
                        <strong class="trust-title">Secure Bank Settlement</strong>
                        <span class="trust-sub">J&amp;K Bank — JAKA0GARDEN</span>
                    </div>
                </div>

                <div class="trust-badge-divider"></div>

                <!-- Badge 4 -->
                <div class="trust-badge-card">
                    <div class="trust-icon-wrap trust-icon-saffron">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12H19M12 5l7 7-7 7"/></svg>
                    </div>
                    <div class="trust-text-wrap">
                        <strong class="trust-title">Doorstep Delivery</strong>
                        <span class="trust-sub">Cash on Delivery Available</span>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- Upgraded Circular Category Section -->
    <section class="section-padding" id="categories-section">
        <div class="container">
            <h2 class="section-title">Our Categories</h2>
           
            
            <div class="categories-circle-flex" id="categories-circles-wrapper">
                <!-- Dry Fruits -->
                <div class="category-circle-card" onclick="location.href='#featured-section'">
                    <div class="category-circle-visual">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10H2C2 17.523 6.477 22 12 22z"></path><path d="M12 2a5 5 0 0 1 5 5v5H7V7a5 5 0 0 1 5-5z"></path></svg>
                    </div>
                    <span class="category-circle-name">Dry Fruits</span>
                </div>
                <!-- Spices & Saffron -->
                <div class="category-circle-card" onclick="location.href='#featured-section'">
                    <div class="category-circle-visual">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <span class="category-circle-name">Spices</span>
                </div>
                <!-- Dried Fruits -->
                <div class="category-circle-card" onclick="location.href='#featured-section'">
                    <div class="category-circle-visual">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 3.5 0 8.5C17 15 15 17 11 20z"></path><path d="M19 2c-2.26 4.33-5.27 7.14-8 8"></path></svg>
                    </div>
                    <span class="category-circle-name">Dried Fruits</span>
                </div>
                <!-- Dried Seeds -->
                <div class="category-circle-card" onclick="location.href='#featured-section'">
                    <div class="category-circle-visual">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m11.314 11.314l.707.707M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"></path></svg>
                    </div>
                    <span class="category-circle-name">Dried Seeds</span>
                </div>
                <!-- Pulses -->
                <div class="category-circle-card" onclick="location.href='#featured-section'">
                    <div class="category-circle-visual">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 22h18M6 18V6c0-1 1-2 2-2h8c1 0 2 1 2 2v12"></path><circle cx="12" cy="11" r="2"></circle></svg>
                    </div>
                    <span class="category-circle-name">Pulses</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Sale & Countdown Section -->
    <section class="sale-section-wrapper" id="offers-section">
        <div class="container">
            <div class="sale-countdown-card" id="sale-countdown-box">

                <!-- Left: Copy + Stock -->
                <div class="sale-left-col">
                    <!-- Live indicator -->
                    <div class="sale-live-badge">
                        <span class="sale-live-dot"></span>
                        <span>FLASH SALE — LIVE NOW</span>
                    </div>

                    <h2 class="sale-headline">Kashmiri Purity Week</h2>

                    <p class="sale-desc">Premium discounts on certified pure collections. Bank orders get priority dispatch.</p>



     
                 

                    <a href="#featured-section" class="sale-cta-btn">Shop the Sale &rarr;</a>
                </div>

                <!-- Right: Countdown clock -->
                <div class="sale-right-col">
                    <p class="sale-clock-label">⏱ Offer ends in</p>
                    <div class="countdown-clock" id="deal-countdown" data-hours="36">
                        <div class="countdown-time-box">
                            <span class="countdown-num" id="cd-days">01</span>
                            <span class="countdown-lbl">Days</span>
                        </div>
                        <div class="countdown-time-box">
                            <span class="countdown-num" id="cd-hours">12</span>
                            <span class="countdown-lbl">Hours</span>
                        </div>
                        <div class="countdown-time-box">
                            <span class="countdown-num" id="cd-mins">44</span>
                            <span class="countdown-lbl">Mins</span>
                        </div>
                        <div class="countdown-time-box">
                            <span class="countdown-num" id="cd-secs">59</span>
                            <span class="countdown-lbl">Secs</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Product Carousel 1: Wholesome Valley Harvest (Products 1-4) -->
    <section class="section-padding" id="featured-section">
        <div class="container">
            <h2 class="section-title">Wholesome Valley Harvest</h2>
            
            
            <div class="carousel-outer-wrap" id="carousel-wrap-featured">
                <!-- Navigation Arrows -->
                <button class="carousel-arrow-btn prev" aria-label="Previous Products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                
                <div class="carousel-container-scroll" id="carousel-scroll-featured">
                    <?php
                    // Render Products 1, 2, 3, 4
                    for ($id = 1; $id <= 4; $id++) {
                        if (isset($products[$id])) {
                            echo renderProductCard($products[$id]);
                        }
                    }
                    ?>
                </div>
                
                <button class="carousel-arrow-btn next" aria-label="Next Products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Saffron Spotlight (Nutrikorner Content-Commerce style) -->
    <section class="saffron-spotlight-section" id="spotlight-kesar-section">
        <div class="container">
            <div class="saffron-spotlight-box">
                <!-- Content info -->
                <div class="saffron-spotlight-content">
                    <span class="spotlight-eyebrow">The Purity Standard</span>
                    <h2 class="spotlight-title">How to Identify 100% Pure Saffron</h2>
                    <p class="spotlight-desc">
                        Genuine Kashmiri Saffron is famous globally for its deep red coloring strength and distinctive warm aroma. Unlike artificial alternatives, raw Kesar releases its rich golden hue slowly, keeping its crimson threads perfectly intact.
                    </p>
                    
                    <div class="spotlight-highlights-grid">
                        <div class="spotlight-highlight-card">
                            <span class="highlight-icon">⏱️</span>
                            <div class="highlight-info">
                                <strong class="highlight-label">Gradual Infusion</strong>
                                <span class="highlight-text">Releases golden color slowly, never bleaches instantly.</span>
                            </div>
                        </div>
                        <div class="spotlight-highlight-card">
                            <span class="highlight-icon">🔬</span>
                            <div class="highlight-info">
                                <strong class="highlight-label">Grade A+ Certified</strong>
                                <span class="highlight-text">FSSAI licensed, highest Crocin density for wellness.</span>
                            </div>
                        </div>
                        <div class="spotlight-highlight-card">
                            <span class="highlight-icon">🔒</span>
                            <div class="highlight-info">
                                <strong class="highlight-label">Zakura Double Sealed</strong>
                                <span class="highlight-text">Packed in glass jars with gold lids directly at source.</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="spotlight-action-row">
                        <a href="product.php?id=2" class="btn btn-gold spotlight-cta-btn">
                            <span>Shop Certified Pure Kesar</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>
                <!-- Graphic image -->
                <div class="saffron-spotlight-img" style="background-image: url('assets/img/hero-saffron.png');" aria-label="Pure Kashmiri Saffron close-up"></div>
            </div>
        </div>
    </section>

    <!-- Product Carousel 2: Rare Herbs & Superfood Seeds (Products 5-8) -->
    <section class="section-padding" id="seeds-section" style="background-color: var(--color-cream-dark); border-top: 1px solid var(--color-border-light); border-bottom: 1px solid var(--color-border-light);">
        <div class="container">
            <h2 class="section-title">Trending Seeds & Rare Harvests</h2>
         
            
            <div class="carousel-outer-wrap" id="carousel-wrap-seeds">
                <!-- Navigation Arrows -->
                <button class="carousel-arrow-btn prev" aria-label="Previous Products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                
                <div class="carousel-container-scroll" id="carousel-scroll-seeds">
                    <?php
                    // Render Products 5, 6, 7, 8
                    for ($id = 5; $id <= 8; $id++) {
                        if (isset($products[$id])) {
                            echo renderProductCard($products[$id]);
                        }
                    }
                    ?>
                </div>
                
                <button class="carousel-arrow-btn next" aria-label="Next Products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Sourced Premium Combo Offers Section -->
    <section class="section-padding premium-combos-section" id="premium-combos-section">
        <div class="container">
            <h2 class="section-title">Sourced Premium Combo Offers</h2>
            
            <div class="combos-grid" id="combos-wrapper-grid">
                <!-- Combo 1: Shahi Purity Combo -->
                <div class="combo-card combo-shahi">
                    <!-- SVG Luxury Graphics -->
                    <svg class="combo-card-graphic" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-50,150 C50,100 100,250 250,150 C300,120 350,220 400,180" fill="none" stroke="rgba(184, 144, 71, 0.25)" stroke-width="1.5" />
                        <path d="M-50,170 C40,130 90,270 240,170 C290,140 340,240 390,200" fill="none" stroke="rgba(184, 144, 71, 0.18)" stroke-width="1.2" />
                        <path d="M-50,190 C30,160 80,290 230,190 C280,160 330,260 380,220" fill="none" stroke="rgba(184, 144, 71, 0.12)" stroke-width="0.8" />
                        <circle cx="200" cy="100" r="80" fill="none" stroke="rgba(184, 144, 71, 0.12)" stroke-width="1" stroke-dasharray="4 4" />
                        <circle cx="200" cy="100" r="110" fill="none" stroke="rgba(184, 144, 71, 0.08)" stroke-width="1" />
                    </svg>
                    
                    <!-- Save Badge -->
                    <span class="combo-save-badge">Save ₹190</span>
                    
                    <div class="combo-body">
                        <!-- Overlapping Thumbnails -->
                        <div class="combo-visual-connect">
                            <div class="combo-thumb-wrapper">
                                <img src="assets/img/almonds.png" alt="Mamra Almonds" class="combo-thumb-img">
                            </div>
                            <div class="combo-connect-plus">
                                <span>+</span>
                            </div>
                            <div class="combo-thumb-wrapper">
                                <img src="assets/img/saffron.png" alt="Mogra Saffron" class="combo-thumb-img">
                            </div>
                        </div>
                        
                        <div class="combo-tag-badge">Bestseller</div>
                        <h3 class="combo-title">Shahi Purity Combo</h3>
                        <p class="combo-desc">
                            Premium <strong>Mamra Almonds</strong> paired with Grade A+ <strong>Mogra Saffron</strong>.
                        </p>
                        
                        <div class="combo-spec-row">
                            <div class="combo-spec-tag">
                                <span class="combo-spec-label">Mamra Almonds</span>
                                <strong class="combo-spec-value">250g Pack</strong>
                            </div>
                            <div class="combo-spec-tag">
                                <span class="combo-spec-label">Mogra Saffron</span>
                                <strong class="combo-spec-value">1g Bottle</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="combo-footer-row">
                        <div class="combo-price-group">
                            <span class="combo-price-label">Special Combo Price</span>
                            <span class="combo-price-current">₹1,010.00</span>
                            <div class="combo-price-original-row">
                                <span class="combo-price-original">₹1,200</span>
                                <span class="combo-discount-badge">15% OFF</span>
                            </div>
                        </div>
                        <button onclick="addComboToCart('shahi')" class="btn btn-gold combo-btn" id="add-combo-shahi-btn">
                            <span>Add Combo</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Combo 2: Spices & Honey Combo -->
                <div class="combo-card combo-spices-honey">
                    <!-- SVG Honeycomb & Starburst Graphics -->
                    <svg class="combo-card-graphic" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="150,50 236,100 236,200 150,250 64,200 64,100" fill="none" stroke="rgba(184, 144, 71, 0.22)" stroke-width="1.2" />
                        <polygon points="150,70 219,110 219,190 150,230 81,190 81,110" fill="none" stroke="rgba(184, 144, 71, 0.15)" stroke-width="1" />
                        <path d="M0,150 L300,150 M150,0 L150,300" fill="none" stroke="rgba(184, 144, 71, 0.08)" stroke-width="0.8" stroke-dasharray="5 5" />
                        <circle cx="150" cy="150" r="120" fill="none" stroke="rgba(184, 144, 71, 0.12)" stroke-width="1" />
                    </svg>
                    
                    <!-- Save Badge -->
                    <span class="combo-save-badge">Save ₹130</span>
                    
                    <div class="combo-body">
                        <!-- Overlapping Thumbnails -->
                        <div class="combo-visual-connect">
                            <div class="combo-thumb-wrapper">
                                <img src="assets/img/honey.png" alt="Acacia Honey" class="combo-thumb-img">
                            </div>
                            <div class="combo-connect-plus">
                                <span>+</span>
                            </div>
                            <div class="combo-thumb-wrapper">
                                <img src="assets/img/zeera.png" alt="Shahi Zeera" class="combo-thumb-img">
                            </div>
                        </div>
                        
                        <div class="combo-tag-badge">Organic Pick</div>
                        <h3 class="combo-title">Spices & Honey Combo</h3>
                        <p class="combo-desc">
                            Pure raw <strong>Acacia Honey</strong> paired with organic <strong>Shahi Zeera</strong>.
                        </p>
                        
                        <div class="combo-spec-row">
                            <div class="combo-spec-tag">
                                <span class="combo-spec-label">Acacia Honey</span>
                                <strong class="combo-spec-value">250g Bottle</strong>
                            </div>
                            <div class="combo-spec-tag">
                                <span class="combo-spec-label">Shahi Zeera</span>
                                <strong class="combo-spec-value">100g Pack</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="combo-footer-row">
                        <div class="combo-price-group">
                            <span class="combo-price-label">Special Combo Price</span>
                            <span class="combo-price-current">₹540.00</span>
                            <div class="combo-price-original-row">
                                <span class="combo-price-original">₹670</span>
                                <span class="combo-discount-badge">19% OFF</span>
                            </div>
                        </div>
                        <button onclick="addComboToCart('spices_honey')" class="btn btn-gold combo-btn" id="add-combo-spices-btn">
                            <span>Add Combo</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- The Al Barr Pledge (USP Grid Section) -->
    <section class="section-padding" style="background-color: #fff;" id="pledge-usp-section">
        <div class="container">
            <h2 class="section-title">The Al Barr Pledge</h2>
            
            <div class="sourcing-pledge-grid" id="pledge-grid-box">
                <!-- Promise 1 -->
                <div class="pledge-card" style="background-color: var(--color-cream-card); border: 1px solid var(--color-border-light); padding: var(--spacing-lg); border-radius: var(--radius-md); text-align: center; transition: var(--transition-normal); border-bottom: 3px solid var(--color-gold);">
                    <div style="font-size: 2.5rem; margin-bottom: var(--spacing-sm);">⛰️</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: var(--spacing-xs); font-family: var(--font-secondary);">Purity Sourced</h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-secondary); line-height: 1.5;">Direct from pristine orchards in Zakura and valleys of Jammu & Kashmir. No middle-agents, no diluted products.</p>
                </div>
                <!-- Promise 2 -->
                <div class="pledge-card" style="background-color: var(--color-cream-card); border: 1px solid var(--color-border-light); padding: var(--spacing-lg); border-radius: var(--radius-md); text-align: center; transition: var(--transition-normal); border-bottom: 3px solid var(--color-gold);">
                    <div style="font-size: 2.5rem; margin-bottom: var(--spacing-sm);">🔬</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: var(--spacing-xs); font-family: var(--font-secondary);">Lab Certified</h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-secondary); line-height: 1.5;">Grade A+ certification for our Mogra Kesar (Saffron). Tested coloring indices and moisture safety.</p>
                </div>
                <!-- Promise 3 -->
                <div class="pledge-card" style="background-color: var(--color-cream-card); border: 1px solid var(--color-border-light); padding: var(--spacing-lg); border-radius: var(--radius-md); text-align: center; transition: var(--transition-normal); border-bottom: 3px solid var(--color-gold);">
                    <div style="font-size: 2.5rem; margin-bottom: var(--spacing-sm);">📦</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: var(--spacing-xs); font-family: var(--font-secondary);">Fresh Double Sealing</h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-secondary); line-height: 1.5;">Hermetically sealed packaging with gold lids to lock in the natural oils, crisp crunch, and fragrance.</p>
                </div>
                <!-- Promise 4 -->
                <div class="pledge-card" style="background-color: var(--color-cream-card); border: 1px solid var(--color-border-light); padding: var(--spacing-lg); border-radius: var(--radius-md); text-align: center; transition: var(--transition-normal); border-bottom: 3px solid var(--color-gold);">
                    <div style="font-size: 2.5rem; margin-bottom: var(--spacing-sm);">🌱</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: var(--spacing-xs); font-family: var(--font-secondary);">Raw & Organic</h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-secondary); line-height: 1.5;">Unpolished almonds, raw shelled walnut halves, and natural cumin seeds. Free from additives or dyes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Customized Wellness Banner Section -->
    <section class="wellness-banner-section" id="custom-wellness-banner">
        <div class="container">
            <div class="wellness-banner-card">
                <!-- Decorative SVG background elements (Looping curves) -->
                <div class="banner-decor-bg">
                    <svg viewBox="0 0 1200 420" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <!-- Left concentric circles -->
                        <circle cx="50" cy="210" r="160" stroke="#018849" stroke-width="24" opacity="0.12"/>
                        <circle cx="50" cy="210" r="260" stroke="#018849" stroke-width="24" opacity="0.12"/>
                        
                        <!-- Right looping shape that wraps around the image -->
                        <path d="M 750 310 C 600 310, 520 160, 680 80 C 840 0, 1050 70, 1050 210 C 1050 330, 850 420, 680 350" 
                              stroke="#018849" stroke-width="28" stroke-linecap="round" stroke-linejoin="round" opacity="0.15"/>
                    </svg>
                </div>
                
                <div class="wellness-banner-grid">
                    <!-- Left Column: Content & Seal & Arrow -->
                    <div class="banner-content-col">
                        <h2 class="banner-main-title">
                            Create your <br>
                            Personalized <br>
                            <span class="highlight-text">Kashmiri Wellness Box</span>
                        </h2>
                        
                        <div class="banner-cta-row">
                            <!-- Circular rotating badge / seal -->
                            <div class="wellness-seal-badge" title="100% Organic & Certified Pure">
                                <svg viewBox="0 0 100 100" class="seal-svg">
                                    <path id="seal-text-path" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" fill="none" />
                                    <text font-family="var(--font-secondary)" font-size="7.5" font-weight="900" fill="var(--color-blue-dark)" letter-spacing="1">
                                        <textPath href="#seal-text-path" startOffset="0%">
                                            • 100% PURE & ORGANIC • KASHMIRI HARVEST •
                                        </textPath>
                                    </text>
                                </svg>
                                <div class="seal-inner-heart">💚</div>
                            </div>
                            
                            <!-- Bouncing down arrow -->
                            <div class="wellness-banner-arrow" title="Scroll down to explore benefits">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <polyline points="19 12 12 19 5 12"></polyline>
                                </svg>
                            </div>
                        </div>

                        <div class="banner-action-buttons">
                            <a href="#premium-combos-section" class="btn btn-primary-green">Customize Box Now</a>
                        </div>
                    </div>

                    <!-- Right Column: Banner Image (Hands holding the wellness box) -->
                    <div class="banner-image-col">
                        <div class="banner-image-wrapper">
                            <img src="assets/img/wellness-combo-banner.png" alt="Custom Kashmiri Wellness Box" class="banner-main-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop By Benefit Section -->
    <section class="section-padding" style="background-color: var(--color-cream-dark); border-top: 1px solid var(--color-border-light); border-bottom: 1px solid var(--color-border-light);" id="benefits-section">
        <div class="container">
            <h2 class="section-title">Shop by Health Benefit</h2>
            <p class="section-subtitle">Harvest selected to target specific wellness requirements</p>
            
            <div class="benefits-grid" id="benefits-grid-box">
                <!-- Benefit 1 -->
                <div class="benefit-card" onclick="location.href='product.php?id=1'" style="cursor: pointer; background: #fff; padding: var(--spacing-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light); text-align: center; transition: var(--transition-normal);">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: rgba(166, 28, 28, 0.05); color: var(--color-saffron-crimson); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--spacing-md) auto; font-size: 1.5rem; font-weight: bold;">🧠</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: 8px; font-family: var(--font-secondary);">Memory Care</h3>
                    <p style="font-size: 0.8rem; color: var(--color-text-secondary); line-height: 1.4; margin-bottom: var(--spacing-md);">Rich in organic lipids and vitamin E. Mamra almonds are perfect for cognitive development.</p>
                    <span style="font-size: 0.8rem; color: var(--color-gold); font-weight: 700; text-transform: uppercase;">Explore Almonds →</span>
                </div>
                <!-- Benefit 2 -->
                <div class="benefit-card" onclick="location.href='product.php?id=3'" style="cursor: pointer; background: #fff; padding: var(--spacing-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light); text-align: center; transition: var(--transition-normal);">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: rgba(166, 28, 28, 0.05); color: var(--color-saffron-crimson); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--spacing-md) auto; font-size: 1.5rem; font-weight: bold;">❤️</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: 8px; font-family: var(--font-secondary);">Heart Wellness</h3>
                    <p style="font-size: 0.8rem; color: var(--color-text-secondary); line-height: 1.4; margin-bottom: var(--spacing-md);">Light kernel walnut halves packed with Omega-3. Reduces cholesterol naturally.</p>
                    <span style="font-size: 0.8rem; color: var(--color-gold); font-weight: 700; text-transform: uppercase;">Explore Walnuts →</span>
                </div>
                <!-- Benefit 3 -->
                <div class="benefit-card" onclick="location.href='product.php?id=2'" style="cursor: pointer; background: #fff; padding: var(--spacing-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light); text-align: center; transition: var(--transition-normal);">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: rgba(166, 28, 28, 0.05); color: var(--color-saffron-crimson); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--spacing-md) auto; font-size: 1.5rem; font-weight: bold;">✨</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: 8px; font-family: var(--font-secondary);">Immunity & Skin</h3>
                    <p style="font-size: 0.8rem; color: var(--color-text-secondary); line-height: 1.4; margin-bottom: var(--spacing-md);">Mogra Saffron threads containing high crocin concentration for natural skin glow & immunity.</p>
                    <span style="font-size: 0.8rem; color: var(--color-gold); font-weight: 700; text-transform: uppercase;">Explore Saffron →</span>
                </div>
                <!-- Benefit 4 -->
                <div class="benefit-card" onclick="location.href='product.php?id=7'" style="cursor: pointer; background: #fff; padding: var(--spacing-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light); text-align: center; transition: var(--transition-normal);">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: rgba(166, 28, 28, 0.05); color: var(--color-saffron-crimson); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--spacing-md) auto; font-size: 1.5rem; font-weight: bold;">🤰</div>
                    <h3 style="font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: 8px; font-family: var(--font-secondary);">Pregnancy Care</h3>
                    <p style="font-size: 0.8rem; color: var(--color-text-secondary); line-height: 1.4; margin-bottom: var(--spacing-md);">Nutrient-dense raw seeds and organic figs. Sourced with highest cleanliness levels.</p>
                    <span style="font-size: 0.8rem; color: var(--color-gold); font-weight: 700; text-transform: uppercase;">Explore Seeds →</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials-reviews-section">
        <div class="container">
            <!-- Section header -->
            <div class="testimonials-header">
                <span class="testimonials-eyebrow">★ Customer Love</span>
                <h2 class="testimonials-title">Trusted by 500+ Organic Buyers</h2>
                <p class="testimonials-subtitle">Real feedback from verified customers across India</p>
            </div>

            <!-- Carousel wrapper -->
            <div class="testimonials-carousel" id="testimonials-showcase-slider">
                <!-- Prev Arrow -->
                <button class="testi-arrow testi-arrow-prev" aria-label="Previous Review" id="testi-prev-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>

                <!-- Track -->
                <div class="testimonial-track" id="testimonial-track">

                    <!-- Card 1 -->
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testi-quote-watermark">&ldquo;</div>
                            <div class="testi-top-row">
                                <div class="testimonial-avatar-box">AA</div>
                                <div class="testi-meta">
                                    <h4 class="testimonial-author">Dr. Aasif Amin</h4>
                                    <span class="testimonial-author-title">Srinagar, Kashmir</span>
                                </div>
                                <div class="testimonial-verified-badge">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Verified
                                </div>
                            </div>
                            <p class="testimonial-text">The Mogra Saffron is incredibly aromatic. I have tried many brands from standard retail markets, but the slow color release and robust aroma of Al barr Saffron is truly outstanding. FSSAI registration gave me peace of mind.</p>
                            <div class="testi-bottom-row">
                                <div class="testimonial-rating">★★★★★</div>
                                <span class="testi-product-tag">Purchased: Mogra Saffron 1g</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testi-quote-watermark">&ldquo;</div>
                            <div class="testi-top-row">
                                <div class="testimonial-avatar-box">MS</div>
                                <div class="testi-meta">
                                    <h4 class="testimonial-author">Meenakshi Sharma</h4>
                                    <span class="testimonial-author-title">New Delhi</span>
                                </div>
                                <div class="testimonial-verified-badge">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Verified
                                </div>
                            </div>
                            <p class="testimonial-text">I ordered Kashmiri Mamra almonds and shelled walnuts. Outstanding crunch and richness. They packed it with double sealing. Safe payment via bank transfer to J&amp;K bank account was smooth. Highly recommend!</p>
                            <div class="testi-bottom-row">
                                <div class="testimonial-rating">★★★★★</div>
                                <span class="testi-product-tag">Purchased: Almonds 250g + Walnuts 250g</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testi-quote-watermark">&ldquo;</div>
                            <div class="testi-top-row">
                                <div class="testimonial-avatar-box">RK</div>
                                <div class="testi-meta">
                                    <h4 class="testimonial-author">Rohit Kapoor</h4>
                                    <span class="testimonial-author-title">Jammu</span>
                                </div>
                                <div class="testimonial-verified-badge">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Verified
                                </div>
                            </div>
                            <p class="testimonial-text">Ordered pure Acacia honey and Kashmiri Zeera. The honey is raw and unfiltered — you can taste the difference. Great packaging and prompt delivery to Jammu within 2 days.</p>
                            <div class="testi-bottom-row">
                                <div class="testimonial-rating">★★★★★</div>
                                <span class="testi-product-tag">Purchased: Honey 250g + Zeera 100g</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testi-quote-watermark">&ldquo;</div>
                            <div class="testi-top-row">
                                <div class="testimonial-avatar-box">FZ</div>
                                <div class="testi-meta">
                                    <h4 class="testimonial-author">Farah Zargar</h4>
                                    <span class="testimonial-author-title">Bangalore</span>
                                </div>
                                <div class="testimonial-verified-badge">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Verified
                                </div>
                            </div>
                            <p class="testimonial-text">As a Kashmiri living in Bangalore, finding authentic dry fruits was impossible. Al Barr's Rajma and dried figs remind me of home. The quality is genuinely what you'd get from a local Srinagar market.</p>
                            <div class="testi-bottom-row">
                                <div class="testimonial-rating">★★★★★</div>
                                <span class="testi-product-tag">Purchased: Rajma 500g + Dried Figs 250g</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Next Arrow -->
                <button class="testi-arrow testi-arrow-next" aria-label="Next Review" id="testi-next-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

            <!-- Dots -->
            <div class="testi-dots" id="testi-dots">
                <span class="testi-dot active" data-slide="0"></span>
                <span class="testi-dot" data-slide="1"></span>
                <span class="testi-dot" data-slide="2"></span>
                <span class="testi-dot" data-slide="3"></span>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section" id="newsletter-subscription-section">
        <!-- Decorative orbs -->
        <div class="newsletter-orb newsletter-orb-1"></div>
        <div class="newsletter-orb newsletter-orb-2"></div>

        <div class="container">
            <div class="newsletter-inner">
                <!-- Left: Content -->
                <div class="newsletter-content">
                    <span class="newsletter-eyebrow">📬 Stay in the Loop</span>
                    <h2 class="newsletter-title">Get Harvest Alerts &amp; Flash Sale Drops</h2>
                    <p class="newsletter-desc">Be the first to know when fresh Kashmir harvests land — from limited Mogra Saffron batches to seasonal honey drops and exclusive flash deals.</p>

                    <div class="newsletter-perks">
                        <span class="newsletter-perk">✓ New harvest alerts</span>
                        <span class="newsletter-perk">✓ Flash sale early access</span>
                        <span class="newsletter-perk">✓ No spam, ever</span>
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="newsletter-form-wrap">
                    <form class="newsletter-form" id="newsletter-form" onsubmit="event.preventDefault(); this.querySelector('.newsletter-btn').textContent='Subscribed ✓'; this.querySelector('.newsletter-btn').disabled=true; AlBarrCart.showToast('Thank you for subscribing to Al barr newsletter!');">
                        <div class="newsletter-input-row">
                            <input type="email" class="newsletter-input" placeholder="Your email address" required id="newsletter-email-input" autocomplete="email">
                            <button type="submit" class="newsletter-btn" id="newsletter-submit-btn">Subscribe</button>
                        </div>
                    </form>
                    <p class="newsletter-privacy">We respect your privacy. Unsubscribe anytime.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Drawer, Modals & Toast Containers -->
    <?php include 'includes/sidebar-cart.php'; ?>
    <?php include 'includes/quick-view.php'; ?>
    
    <div class="toast-container" id="toast-container"></div>

    <!-- Footer Include -->
    <?php include 'includes/footer.php'; ?>

    <!-- Combo Add-to-Cart Custom script logic -->
    <script>
    window.addComboToCart = function(comboType) {
        if (comboType === 'shahi') {
            AlBarrCart.add(1, 'Premium Kashmiri Mamra Almonds (Raw)', '250g', 850, 990, 'assets/img/almonds.png');
            setTimeout(() => {
                AlBarrCart.add(2, 'Kashmiri Kesar (Pure Mogra Saffron)', '1g', 350, 400, 'assets/img/saffron.png');
                AlBarrCart.showToast("Shahi Purity Combo Added to Cart!");
            }, 150);
        } else if (comboType === 'spices_honey') {
            AlBarrCart.add(5, 'Pure Kashmiri Acacia Honey (Raw & Unfiltered)', '250g', 380, 450, 'assets/img/honey.png');
            setTimeout(() => {
                AlBarrCart.add(6, 'Kashmiri Shahi Zeera (Organic Black Cumin)', '100g', 290, 350, 'assets/img/zeera.png');
                AlBarrCart.showToast("Spices & Honey Combo Added to Cart!");
            }, 150);
        }
    };
    </script>



</body>
</html>
