@extends('layouts.app')

@section('title', 'About Us - Al Barr | Purity Sourcing from Kashmir')

@section('styles')
<style>
    .about-hero {
        background-color: var(--color-blue-light);
        padding: var(--spacing-xxl) 0 var(--spacing-xl);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .about-hero-title {
        font-family: var(--font-secondary);
        font-size: 3rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-sm);
    }

    .about-hero-tagline {
        font-size: 1.25rem;
        color: var(--color-blue-medium);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: var(--spacing-md);
    }

    .about-hero-desc {
        font-size: 1.1rem;
        color: var(--color-text-secondary);
        max-width: 700px;
        margin: 0 auto;
    }

    .story-section {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
    }

    .story-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-xxl);
        align-items: center;
    }

    .story-img-wrap {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 2px solid var(--color-card-border-gold);
    }

    .story-img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        filter: brightness(0.95);
    }

    .story-content {
        padding-right: var(--spacing-lg);
        text-align: left;
    }

    .story-eyebrow {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--color-gold);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: var(--spacing-xs);
        display: inline-block;
    }

    .story-heading {
        font-family: var(--font-secondary);
        font-size: 2.2rem;
        color: var(--color-blue-dark);
        margin-bottom: var(--spacing-md);
        line-height: 1.3;
    }

    .story-text {
        color: var(--color-text-secondary);
        margin-bottom: var(--spacing-md);
        font-size: 1.05rem;
    }

    .values-section {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream-dark);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--spacing-xl);
    }

    .value-card {
        background: var(--color-cream-card);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-md);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        text-align: center;
    }

    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-card-border-gold);
    }

    .value-icon {
        font-size: 2.5rem;
        margin-bottom: var(--spacing-md);
        display: inline-block;
    }

    .value-title {
        font-family: var(--font-secondary);
        font-size: 1.3rem;
        color: var(--color-blue-dark);
        margin-bottom: var(--spacing-sm);
        font-weight: 600;
    }

    .value-desc {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
    }

    .sourcing-map-section {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
        text-align: center;
    }

    .sourcing-regions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--spacing-md);
        margin-top: var(--spacing-xl);
    }

    .region-card {
        background: var(--color-cream-card);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-sm);
        padding: var(--spacing-md);
        box-shadow: var(--shadow-sm);
        text-align: left;
        transition: var(--transition-fast);
    }

    .region-card:hover {
        border-color: var(--color-brand-green);
    }

    .region-header {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        font-weight: 600;
        color: var(--color-blue-dark);
        margin-bottom: 6px;
        font-family: var(--font-secondary);
    }

    .region-pin {
        color: var(--color-saffron-orange);
    }

    .region-crop {
        font-size: 0.85rem;
        color: var(--color-gold);
        font-weight: 700;
        margin-bottom: var(--spacing-xs);
    }

    .region-desc {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
    }

    @media (max-width: 991px) {
        .story-grid {
            grid-template-columns: 1fr;
        }
        .values-grid {
            grid-template-columns: 1fr;
        }
        .sourcing-regions-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 575px) {
        .sourcing-regions-grid {
            grid-template-columns: 1fr;
        }
        .about-hero-title {
            font-size: 2.2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Area -->
<section class="about-hero">
    <div class="container">
        <span class="about-hero-tagline">Khalis Wa Shifaf</span>
        <h1 class="about-hero-title">Our Pledge of Purity</h1>
        <p class="about-hero-desc">Connecting you directly to the finest, unadulterated harvests of the Kashmir Valley. No middlemen, no preservatives—just 100% pure organic quality.</p>
    </div>
</section>

<!-- Story Area -->
<section class="story-section">
    <div class="container">
        <div class="story-grid">
            
            <!-- Left: content -->
            <div class="story-content">
                <span class="story-eyebrow">The Al Barr Heritage</span>
                <h2 class="story-heading">Rooted in the Pristine Soil of Kashmir</h2>
                <p class="story-text">
                    @if ($page)
                        {{ $page->content }}
                    @else
                        The name <strong>Al Barr</strong> translates to "The Beneficent" or "The Land of Abundance," which is exactly what the valleys of Jammu and Kashmir represent. Founded with the mission to build an direct bridge between passionate local farmers and customers seeking clean nutrition, we specialize in sourcing authentic, premium, and raw staples.
                    @endif
                </p>
                <p class="story-text">
                    Kashmir's microclimate, rich glacial waters, and mineral-laden mountain soils create the perfect environment for slow-growing crops. This slow growth locks in higher concentrations of essential oils and nutrients, yielding almonds with richer oils, saffron with higher crocin density, and wild honey packed with natural floral enzymes.
                </p>
                <p class="story-text">
                    We reject the chemical polishing, artificial sulfur washes, and color enhancers that dominate modern commercial farming. With Al Barr, what you get is raw, clean, and completely pure—<strong>Khalis Wa Shifaf</strong>.
                </p>
            </div>

            <!-- Right: Image -->
            <div class="story-img-wrap">
                <img src="/assets/img/figs.png" alt="Pure Kashmiri harvest" class="story-img" style="object-position: center; filter: hue-rotate(45deg); scale: 1.1;">
            </div>

        </div>
    </div>
</section>

<!-- Values / Trust Pillars -->
<section class="values-section">
    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: var(--spacing-xl);">Our Sourcing Pillars</h2>
        
        <div class="values-grid">
            <!-- Card 1 -->
            <div class="value-card">
                <span class="value-icon">🧑‍🌾</span>
                <h3 class="value-title">Fair Farm Trade</h3>
                <p class="value-desc">We collaborate directly with local orchards and farmers in Ganderbal, Pulwama, and Shopian, ensuring they earn premium prices for their hard-earned harvests.</p>
            </div>

            <!-- Card 2 -->
            <div class="value-card">
                <span class="value-icon">🔬</span>
                <h3 class="value-title">FSSAI Certified Safety</h3>
                <p class="value-desc">Every batch is verified under FSSAI license criteria. Our processes ensure strict hand-sorting, physical-cleaning, and hygienic sealing of all items.</p>
            </div>

            <!-- Card 3 -->
            <div class="value-card">
                <span class="value-icon">🛡️</span>
                <h3 class="value-title">Zero Preservatives</h3>
                <p class="value-desc">No sugar syrup is added to our honey, no artificial coloring is added to our saffron threads, and no sulfur dioxide fumigation is used to whiten our dry fruits.</p>
            </div>
        </div>
    </div>
</section>

<!-- Sourcing Regions list -->
<section class="sourcing-map-section">
    <div class="container">
        <h2 class="section-title">Where Our Harvest Comes From</h2>
        <p style="color: var(--color-text-secondary); max-width: 600px; margin: 0 auto;">Each product is sourced from the specific Kashmiri micro-valley that historically yields the highest grade of that crop.</p>
        
        <div class="sourcing-regions-grid">
            <!-- Region 1 -->
            <div class="region-card">
                <div class="region-header">
                    <span class="region-pin">📍</span>
                    <span>Zakura, Srinagar</span>
                </div>
                <div class="region-crop">Almonds & Walnuts</div>
                <p class="region-desc">Orchards fed by high-altitude spring water, yielding high-oil Mamra almonds and thin-shell walnuts.</p>
            </div>

            <!-- Region 2 -->
            <div class="region-card">
                <div class="region-header">
                    <span class="region-pin">📍</span>
                    <span>Pampore, Pulwama</span>
                </div>
                <div class="region-crop">Mogra Kesar (Saffron)</div>
                <p class="region-desc">The saffron capital of India. Sourced from organic fields yielding Grade A+ Crocin rich stigmas.</p>
            </div>

            <!-- Region 3 -->
            <div class="region-card">
                <div class="region-header">
                    <span class="region-pin">📍</span>
                    <span>Ganderbal Forests</span>
                </div>
                <div class="region-crop">Acacia Honey</div>
                <p class="region-desc">Apiaries placed inside pure Acacia forest reserve valleys during spring bloom, cold-extracted and unfiltered.</p>
            </div>

            <!-- Region 4 -->
            <div class="region-card">
                <div class="region-header">
                    <span class="region-pin">📍</span>
                    <span>Bhaderwah, Doda</span>
                </div>
                <div class="region-crop">Bhaderwahi Rajma</div>
                <p class="region-desc">Cultivated in terraced mountain slopes, yielding the famous small-grain, sweet-melting red beans.</p>
            </div>
        </div>
    </div>
</section>
@endsection
