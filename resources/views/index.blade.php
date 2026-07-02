@extends('layouts.app')

@section('title', 'Al Barr | Khalis Wa Shifaf - Premium Kashmiri Dry Fruits & Saffron')

@section('content')
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
                        <source media="(max-width: 768px)" srcset="{{ asset('assets/img/banner-dryfruits-mobile.png') }} 1x, {{ asset('assets/img/banner-dryfruits-mobile-2x.png') }} 2x">
                        <!-- Desktop Banner (Wide) -->
                        <img src="{{ asset('assets/img/banner-dryfruits-desktop.png') }}" srcset="{{ asset('assets/img/banner-dryfruits-desktop-2x.png') }} 2x" alt="Premium Kashmiri Dry Fruits - Sourced direct from Zakura orchards. 100% Organic & Hand-picked." class="hero-banner-img">
                    </picture>
                </a>
            </div>
            
            <!-- Slide 2: Saffron -->
            <div class="slide-item" id="hero-slide-2">
                <a href="/product/2" class="slide-banner-link" aria-label="Shop Pure Mogra Saffron">
                    <picture>
                        <!-- Mobile Banner (Square 1:1) -->
                        <source media="(max-width: 768px)" srcset="{{ asset('assets/img/banner-saffron-mobile.png') }} 1x, {{ asset('assets/img/banner-saffron-mobile-2x.png') }} 2x">
                        <!-- Desktop Banner (Wide) -->
                        <img src="{{ asset('assets/img/banner-saffron-desktop.png') }}" srcset="{{ asset('assets/img/banner-saffron-desktop-2x.png') }} 2x" alt="Pure Mogra Saffron - Grade A+ Certified, Highest Crocin Concentration." class="hero-banner-img">
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

    <!-- Upgraded Circular Category Section -->
    <section class="section-padding" id="categories-section">
        <div class="container">
            <h2 class="section-title">Our Categories</h2>
            
            <div class="categories-circle-flex" id="categories-circles-wrapper">
                <!-- Dry Fruits -->
                <a class="category-circle-card" href="/shop?category=dry-fruits">
                    <div class="category-circle-visual" style="--cat-bg: var(--color-brand-green-light);">
                        <img src="{{ asset('assets/img/cat-dry-fruits.png') }}" alt="Dry Fruits" class="category-circle-img">
                    </div>
                    <span class="category-circle-name">Dry Fruits</span>
                </a>
                <!-- Spices & Saffron -->
                <a class="category-circle-card" href="/shop?category=spices">
                    <div class="category-circle-visual" style="--cat-bg: var(--color-saffron-light);">
                        <img src="{{ asset('assets/img/cat-spices.png') }}" alt="Spices & Saffron" class="category-circle-img">
                    </div>
                    <span class="category-circle-name">Spices</span>
                </a>
                <!-- Dried Fruits -->
                <a class="category-circle-card" href="/shop?category=dried-fruits">
                    <div class="category-circle-visual" style="--cat-bg: var(--color-gold-light);">
                        <img src="{{ asset('assets/img/cat-dried-fruits.png') }}" alt="Dried Fruits" class="category-circle-img">
                    </div>
                    <span class="category-circle-name">Dried Fruits</span>
                </a>
                <!-- Honey -->
                <a class="category-circle-card" href="/shop?category=honey">
                    <div class="category-circle-visual" style="--cat-bg: #FFF8E1;">
                        <img src="{{ asset('assets/img/cat-honey.png') }}" alt="Pure Honey" class="category-circle-img">
                    </div>
                    <span class="category-circle-name">Honey</span>
                </a>
                <!-- Dried Seeds -->
                <a class="category-circle-card" href="/shop?category=seeds">
                    <div class="category-circle-visual" style="--cat-bg: var(--color-saffron-light);">
                        <img src="{{ asset('assets/img/cat-seeds.png') }}" alt="Dried Seeds" class="category-circle-img">
                    </div>
                    <span class="category-circle-name">Dried Seeds</span>
                </a>
                <!-- Pulses -->
                <a class="category-circle-card" href="/shop?category=pulses">
                    <div class="category-circle-visual" style="--cat-bg: var(--color-brand-green-light);">
                        <img src="{{ asset('assets/img/cat-pulses.png') }}" alt="Pulses" class="category-circle-img">
                    </div>
                    <span class="category-circle-name">Pulses</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Flash Sale & Countdown Section -->
    @if (($settings['flash_sale_status'] ?? 'enabled') === 'enabled')
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

                    <h2 class="sale-headline">{{ $settings['flash_sale_title'] ?? 'Kashmiri Purity Week' }}</h2>
                    <p class="sale-desc">{{ $settings['flash_sale_subtitle'] ?? 'Premium discounts on certified pure collections. Bank orders get priority dispatch.' }}</p>
                    <a href="/shop" class="sale-cta-btn">Shop the Sale &rarr;</a>
                </div>

                <!-- Right: Countdown clock -->
                <div class="sale-right-col">
                    <p class="sale-clock-label">⏱ Offer ends in</p>
                    <div class="countdown-clock" id="deal-countdown" data-end-time="{{ $settings['flash_sale_end_time'] ?? '' }}">
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
    @endif

    <!-- Product Carousel 1: Wholesome Valley Harvest (Products 1-4) -->
    <section class="section-padding" id="featured-section">
        <div class="container">
            <div class="section-header-row">
                <h2 class="section-title">Wholesome Valley Harvest</h2>
                <a href="/shop" class="section-see-all-link">See All <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></a>
            </div>
            
            <div class="carousel-outer-wrap" id="carousel-wrap-featured">
                <!-- Navigation Arrows -->
                <button class="carousel-arrow-btn prev" aria-label="Previous Products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                
                <div class="carousel-container-scroll" id="carousel-scroll-featured">
                    @foreach ($products->take(4) as $p)
                        @include('partials.product-card', ['product' => $p])
                    @endforeach
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
            <div class="section-header-row">
                <h2 class="section-title">Sourced Premium Combo Offers</h2>
                <a href="/shop" class="section-see-all-link">See All <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></a>
            </div>
            
            <div class="combos-grid" id="combos-wrapper-grid">
                <!-- Combo 1: Shahi Purity Combo -->
                <div class="combo-card combo-shahi">
                    <svg class="combo-card-graphic" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-50,150 C50,100 100,250 250,150 C300,120 350,220 400,180" fill="none" stroke="rgba(184, 144, 71, 0.25)" stroke-width="1.5" />
                        <path d="M-50,170 C40,130 90,270 240,170 C290,140 340,240 390,200" fill="none" stroke="rgba(184, 144, 71, 0.18)" stroke-width="1.2" />
                        <path d="M-50,190 C30,160 80,290 230,190 C280,160 330,260 380,220" fill="none" stroke="rgba(184, 144, 71, 0.12)" stroke-width="0.8" />
                        <circle cx="200" cy="100" r="80" fill="none" stroke="rgba(184, 144, 71, 0.12)" stroke-width="1" stroke-dasharray="4 4" />
                        <circle cx="200" cy="100" r="110" fill="none" stroke="rgba(184, 144, 71, 0.08)" stroke-width="1" />
                    </svg>
                    
                    <span class="combo-save-badge">Save ₹190</span>
                    
                    <div class="combo-body">
                        <div class="combo-visual-connect">
                            <div class="combo-thumb-wrapper">
                                <img src="{{ asset('assets/img/almonds.png') }}" alt="Mamra Almonds" class="combo-thumb-img">
                            </div>
                            <div class="combo-connect-plus">
                                <span>+</span>
                            </div>
                            <div class="combo-thumb-wrapper">
                                <img src="{{ asset('assets/img/saffron.png') }}" alt="Mogra Saffron" class="combo-thumb-img">
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
                    <svg class="combo-card-graphic" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="150,50 236,100 236,200 150,250 64,200 64,100" fill="none" stroke="rgba(184, 144, 71, 0.22)" stroke-width="1.2" />
                        <polygon points="150,70 219,110 219,190 150,230 81,190 81,110" fill="none" stroke="rgba(184, 144, 71, 0.15)" stroke-width="1" />
                        <path d="M0,150 L300,150 M150,0 L150,300" fill="none" stroke="rgba(184, 144, 71, 0.08)" stroke-width="0.8" stroke-dasharray="5 5" />
                        <circle cx="150" cy="150" r="120" fill="none" stroke="rgba(184, 144, 71, 0.12)" stroke-width="1" />
                    </svg>
                    
                    <span class="combo-save-badge">Save ₹130</span>
                    
                    <div class="combo-body">
                        <div class="combo-visual-connect">
                            <div class="combo-thumb-wrapper">
                                <img src="{{ asset('assets/img/honey.png') }}" alt="Acacia Honey" class="combo-thumb-img">
                            </div>
                            <div class="combo-connect-plus">
                                <span>+</span>
                            </div>
                            <div class="combo-thumb-wrapper">
                                <img src="{{ asset('assets/img/zeera.png') }}" alt="Shahi Zeera" class="combo-thumb-img">
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
    <section class="pledge-usp-section" id="pledge-usp-section">
        <div class="container">
            <h2 class="section-title">The Al Barr Pledge</h2>
            
            <div class="sourcing-pledge-grid" id="pledge-grid-box">
                <!-- Promise 1 -->
                <div class="pledge-card">
                    <div class="pledge-icon-box">⛰️</div>
                    <h3 class="pledge-title">Purity Sourced</h3>
                    <p class="pledge-desc">Direct from pristine orchards in Zakura and valleys of Jammu & Kashmir. No middle-agents, no diluted products.</p>
                </div>
                <!-- Promise 2 -->
                <div class="pledge-card">
                    <div class="pledge-icon-box">🔬</div>
                    <h3 class="pledge-title">Lab Certified</h3>
                    <p class="pledge-desc">Grade A+ certification for our Mogra Kesar (Saffron). Tested coloring indices and moisture safety.</p>
                </div>
                <!-- Promise 3 -->
                <div class="pledge-card">
                    <div class="pledge-icon-box">📦</div>
                    <h3 class="pledge-title">Fresh Double Sealing</h3>
                    <p class="pledge-desc">Hermetically sealed packaging with gold lids to lock in the natural oils, crisp crunch, and fragrance.</p>
                </div>
                <!-- Promise 4 -->
                <div class="pledge-card">
                    <div class="pledge-icon-box">🌱</div>
                    <h3 class="pledge-title">Raw & Organic</h3>
                    <p class="pledge-desc">Unpolished almonds, raw shelled walnut halves, and natural cumin seeds. Free from additives or dyes.</p>
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
                            <img src="{{ asset('assets/img/wellness-combo-banner.png') }}" alt="Custom Kashmiri Wellness Box" class="banner-main-image">
                        </div>
                    </div>
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
        
        <!-- Wavy divider separating testimonials and newsletter sections -->
        <div class="testimonials-wave-divider">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,40 C320,100 480,20 800,80 C1120,140 1280,40 1440,80 L1440,120 L0,120 Z" fill="#070D0C"></path>
            </svg>
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
@endsection

@section('scripts')
    <!-- Combo Add-to-Cart Custom script logic -->
    <script>
    window.addComboToCart = function(comboType) {
        if (comboType === 'shahi') {
            AlBarrCart.add(1, 'Premium Kashmiri Mamra Almonds (Raw)', '250g', 850, 990, "{{ asset('assets/img/almonds.png') }}");
            setTimeout(() => {
                AlBarrCart.add(2, 'Kashmiri Kesar (Pure Mogra Saffron)', '1g', 350, 400, "{{ asset('assets/img/saffron.png') }}");
                AlBarrCart.showToast("Shahi Purity Combo Added to Cart!");
            }, 150);
        } else if (comboType === 'spices_honey') {
            AlBarrCart.add(5, 'Pure Kashmiri Acacia Honey (Raw & Unfiltered)', '250g', 380, 450, "{{ asset('assets/img/honey.png') }}");
            setTimeout(() => {
                AlBarrCart.add(6, 'Kashmiri Shahi Zeera (Organic Black Cumin)', '100g', 290, 350, "{{ asset('assets/img/zeera.png') }}");
                AlBarrCart.showToast("Spices & Honey Combo Added to Cart!");
            }, 150);
        }
    };
    </script>
@endsection
