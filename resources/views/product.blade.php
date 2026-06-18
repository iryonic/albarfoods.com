@extends('layouts.app')

@php
    $meta = $product->category->name ?? 'Organic';
    $variantsArray = [];
    foreach ($product->variants as $v) {
        $variantsArray[$v->weight] = [
            'price' => (float)$v->price,
            'orig' => (float)$v->orig_price
        ];
    }
    $first_weight = array_key_first($variantsArray);
    $first_variant = $variantsArray[$first_weight] ?? ['price' => 0, 'orig' => 0];
    
    $mock_reviews = [1 => 48, 2 => 94, 3 => 37, 4 => 22, 5 => 29, 6 => 41, 7 => 18, 8 => 34];
    $reviews = $mock_reviews[$product->id] ?? 15;
@endphp

@section('title', htmlspecialchars($product->title) . ' | Al Barr (Khalis Wa Shifaf)')

@section('content')
    <div class="product-detail-container container">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs-row">
            <a href="/">Home</a>
            <span class="divider">/</span>
            <a href="/shop?category={{ $product->category->slug ?? '' }}">{{ $meta }}</a>
            <span class="divider">/</span>
            <span class="current-page">{{ $product->title }}</span>
        </div>

        <!-- Main Product Columns -->
        <div class="product-page-columns" data-product-id="{{ $product->id }}">
            <!-- Left Side: Image Showcase -->
            <div class="product-gallery-box">
                <div class="gallery-badge-overlay">
                    <span class="premium-badge-tag {{ ($product->id === 2 || $product->id === 6) ? 'orange' : '' }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        {{ $product->badge }}
                    </span>
                </div>
                <div class="product-gallery-main">
                    <img id="main-product-img" src="/{{ $product->image }}" alt="{{ $product->title }}" @if ($product->id === 4) style="filter: hue-rotate(45deg);" @endif>
                </div>
                <div class="product-gallery-thumbs">
                    <div class="gallery-thumb active" onclick="document.getElementById('main-product-img').src='/{{ $product->image }}'; document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('active')); this.classList.add('active');">
                        <img src="/{{ $product->image }}" alt="Preview" @if ($product->id === 4) style="filter: hue-rotate(45deg);" @endif>
                    </div>
                    <div class="gallery-thumb" onclick="document.getElementById('main-product-img').src='/assets/img/logo.png'; document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('active')); this.classList.add('active');">
                        <img src="/assets/img/logo.png" alt="Brand Logo Seal">
                    </div>
                </div>
            </div>

            <!-- Right Side: Purchasing Center -->
            <div class="product-info-column">
                <div>
                    <h1 class="product-title-main">{{ $product->title }}</h1>
                    
                    <div class="premium-rating-row">
                        <div class="premium-stars">
                            ★★★★★
                        </div>
                        <span class="premium-rating-count">({{ $reviews }} Customer Reviews)</span>
                        <span class="verified-buyer-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Verified Kashmiri Harvest
                        </span>
                    </div>

                    <p class="product-description-text">
                        {{ $product->description }}
                    </p>

                    <!-- Weight variant selection (Refactored Cards style) -->
                    <div class="variant-selection-section">
                        <label class="variant-section-label">Available Package Weights:</label>
                        <div class="variant-pill-wrapper">
                            @php $idx = 0; @endphp
                            @foreach ($variantsArray as $weight => $pricing)
                                @php $activeClass = ($idx === 0) ? 'active' : ''; @endphp
                                <button class="variant-pill {{ $activeClass }}" data-weight="{{ $weight }}" data-price="{{ $pricing['price'] }}" data-orig="{{ $pricing['orig'] }}">
                                  <span class="pill-weight">{{ $weight }}</span>
                                  <span class="pill-price">₹{{ number_format($pricing['price'], 0) }}</span>
                                </button>
                                @php $idx++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Price and Checkout triggers -->
                <div class="purchasing-action-card">
                    <div class="card-pricing-row">
                        <div class="card-price-block">
                            <span class="card-price-main" id="detail-current-price">₹{{ number_format($first_variant['price'], 2) }}</span>
                            <div class="card-price-original-wrap">
                                <span class="card-price-original" id="detail-original-price">₹{{ number_format($first_variant['orig'], 2) }}</span>
                            </div>
                        </div>
                        @php
                            $savings = $first_variant['orig'] - $first_variant['price'];
                            $percentage = $first_variant['orig'] > 0 ? round(($savings / $first_variant['orig']) * 100) : 0;
                        @endphp
                        <span class="card-discount-tag" id="detail-discount-tag">SAVE {{ $percentage }}%</span>
                    </div>

                    <div class="card-actions-row">
                        <!-- Blinkit Style Cart Controls -->
                        <div class="cart-control-btn" style="width: 140px; height: 48px;" data-product-id="{{ $product->id }}">
                            <button class="add-btn-init" style="font-size: 1rem;">
                                <span>ADD TO CART</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                            <div class="qty-counter-active">
                                <button class="qty-btn btn-minus">−</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn btn-plus">+</button>
                            </div>
                        </div>

                        <!-- Buy Now (Instant Direct Checkout link) -->
                        <button class="btn btn-gold" id="detail-buy-now-btn">
                            <span>BUY NOW</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </button>
                    </div>

                    <!-- Secure Checkout Trust Note -->
                    <div class="secure-checkout-note">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Secure SSL Encrypted Checkout & Quick Shipping
                    </div>
                </div>

                <!-- Trust Guarantees -->
                <div class="trust-badges-grid">
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a15 15 0 0 0-10 10v9a1 1 0 0 0 1 1h9a15 15 0 0 0 10-10V3a1 1 0 0 0-1-1h-9z"></path><path d="M2 22l10-10"></path></svg>
                        </div>
                        <span class="trust-badge-text">100% Pure, Valley Sourced</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 11 11 13 15 9"></polyline></svg>
                        </div>
                        <span class="trust-badge-text">FSSAI Certified Quality</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <span class="trust-badge-text">Safe Bank Transfers & COD</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><polygon points="12 22.08 12 12 3 6.92 3 17.08 12 22.08"></polygon><polygon points="12 22.08 21 17.08 21 6.92 12 12 12 22.08"></polygon><polygon points="12 12 21 6.92 12 1.84 3 6.92 12 12"></polygon></svg>
                        </div>
                        <span class="trust-badge-text">Hermetically Sealed Freshness</span>
                    </div>
                </div>

                <!-- Accordions -->
                <div class="spec-accordion">
                    <!-- Item 1: Sourcing Details -->
                    <div class="accordion-item active">
                        <button class="accordion-header">
                            <span class="accordion-header-title">
                                <svg class="header-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                Sourcing & Cultivation
                            </span>
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p><strong>Orchard Sourcing Location:</strong> {{ $product->origin }}</p>
                                <p>All Al Barr products are harvested by hand using traditional, eco-friendly techniques which ensure the surrounding ecosystems in Jammu and Kashmir are preserved. Certified raw, chemical-free, and clean.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Item 2: Nutrition Facts -->
                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span class="accordion-header-title">
                                <svg class="header-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                Nutritional Values & Health
                            </span>
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>{{ $product->nutrition }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Item 3: Storage Guidelines -->
                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span class="accordion-header-title">
                                <svg class="header-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                Storage & Lifespan
                            </span>
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>{{ $product->storage }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <section class="section-padding" style="border-top: 1px solid var(--color-border); margin-top: var(--spacing-xxl);">
            <h2 style="font-size: 1.8rem; color: var(--color-blue-dark); text-align: center; margin-bottom: var(--spacing-xs); font-family: var(--font-secondary);">More Kashmiri Specialties</h2>
            <p style="text-align: center; color: var(--color-gold); font-size: 0.9rem; font-weight: 500; margin-bottom: var(--spacing-xl); text-transform: uppercase; letter-spacing: 1px;">Sourced under FSSAI regulations</p>
            
            <div class="products-grid">
                @foreach ($relatedProducts as $item)
                    @include('partials.product-card', ['product' => $item])
                @endforeach
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        // Tab Accordion Specific Logic
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const isActive = item.classList.contains('active');
                
                // Close all
                document.querySelectorAll('.accordion-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                // Open clicked
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
        
        // Variant Pills Price Sync
        document.querySelectorAll('.variant-pill').forEach(pill => {
            pill.addEventListener('click', () => {
                // Ensure only pills within the variant selector change
                const container = pill.parentElement;
                container.querySelectorAll('.variant-pill').forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                
                const price = parseFloat(pill.getAttribute('data-price'));
                const orig = parseFloat(pill.getAttribute('data-orig'));
                
                // Update text
                document.getElementById('detail-current-price').innerText = '₹' + price.toFixed(2);
                document.getElementById('detail-original-price').innerText = '₹' + orig.toFixed(2);
                
                // Calculate discount tag
                const savings = orig - price;
                const percentage = Math.round((savings / orig) * 100);
                document.getElementById('detail-discount-tag').innerText = 'SAVE ' + percentage + '%';
            });
        });

        // Buy Now Button handler (redirect directly to checkout after adding active variant to cart)
        document.getElementById('detail-buy-now-btn').addEventListener('click', () => {
            const activePill = document.querySelector('.variant-pill.active');
            if (activePill) {
                const weight = activePill.getAttribute('data-weight');
                const price = parseFloat(activePill.getAttribute('data-price'));
                const orig = parseFloat(activePill.getAttribute('data-orig'));
                
                // Add to cart
                if (typeof AlBarrCart !== 'undefined') {
                    AlBarrCart.add(
                        {{ $product->id }}, 
                        "{{ $product->title }}", 
                        weight, 
                        price, 
                        orig, 
                        "/{{ $product->image }}"
                    );
                    
                    setTimeout(() => {
                        window.location.href = '/checkout';
                    }, 300);
                } else {
                    window.location.href = '/checkout';
                }
            }
        });
    </script>
@endsection
