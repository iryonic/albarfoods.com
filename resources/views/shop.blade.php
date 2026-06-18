@extends('layouts.app')

@section('title', 'Shop Online - Al Barr | Premium Organic Kashmiri Harvest')

@section('styles')
    <style>
        /* Shop Layout CSS Override */
        .shop-page-wrapper {
            padding: var(--spacing-xl) 0;
            background-color: var(--color-cream);
        }

        .shop-header {
            text-align: center;
            margin-bottom: var(--spacing-xl);
        }

        .shop-title {
            font-family: var(--font-secondary);
            font-size: 2.8rem;
            color: var(--color-blue-dark);
            margin-bottom: var(--spacing-xs);
            font-weight: 700;
        }

        .shop-subtitle {
            font-size: 1.1rem;
            color: var(--color-text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .shop-grid-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: var(--spacing-xl);
            align-items: start;
        }

        /* Filter Sidebar Card */
        .filter-sidebar {
            background: var(--color-cream-card);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-md);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 100px;
        }

        .filter-group {
            margin-bottom: var(--spacing-lg);
        }

        .filter-group-title {
            font-family: var(--font-secondary);
            font-size: 1.1rem;
            color: var(--color-blue-dark);
            font-weight: 600;
            margin-bottom: var(--spacing-md);
            border-bottom: 2px solid var(--color-blue-light);
            padding-bottom: var(--spacing-xs);
        }

        /* Search input styled */
        .filter-search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .filter-search-input {
            width: 100%;
            padding: 10px 14px 10px 36px;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xs);
            font-size: 0.9rem;
            color: var(--color-text-primary);
            transition: var(--transition-fast);
        }

        .filter-search-input:focus {
            border-color: var(--color-blue-medium);
            background-color: #fff;
            box-shadow: 0 0 0 3px var(--color-blue-light);
        }

        .filter-search-icon {
            position: absolute;
            left: 12px;
            color: var(--color-text-muted);
            pointer-events: none;
        }

        /* Category list buttons */
        .filter-categories-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .category-filter-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 10px var(--spacing-sm);
            text-align: left;
            border-radius: var(--radius-xs);
            font-weight: 500;
            color: var(--color-text-secondary);
            font-size: 0.95rem;
            transition: var(--transition-fast);
        }

        .category-filter-btn:hover,
        .category-filter-btn.active {
            background-color: var(--color-blue-light);
            color: var(--color-blue-dark);
        }

        .category-filter-btn.active {
            font-weight: 600;
        }

        .category-count {
            font-size: 0.8rem;
            background: #fff;
            padding: 2px 8px;
            border-radius: 20px;
            border: 1px solid var(--color-border);
            color: var(--color-text-muted);
        }

        /* Sort dropdown styled */
        .sort-select {
            width: 100%;
            padding: 10px 14px;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xs);
            font-size: 0.9rem;
            color: var(--color-text-secondary);
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .sort-select:focus {
            border-color: var(--color-blue-medium);
            background-color: #fff;
        }

        /* Responsive modifications */
        @media (max-width: 991px) {
            .shop-grid-layout {
                grid-template-columns: 1fr;
            }
            .filter-sidebar {
                position: static;
                margin-bottom: var(--spacing-md);
            }
        }

        .no-results-card {
            grid-column: 1 / -1;
            background-color: var(--color-cream-card);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-md);
            padding: var(--spacing-xl) var(--spacing-lg);
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .no-results-icon {
            font-size: 3rem;
            margin-bottom: var(--spacing-md);
        }
    </style>
@endsection

@section('content')
    <main class="shop-page-wrapper">
        <div class="container">
            
            <!-- Shop Banner Header -->
            <div class="shop-header">
                <h1 class="shop-title">Kashmiri Harvest Catalog</h1>
                <p class="shop-subtitle">Khalis Wa Shifaf premium dry fruits, organic honey, and Himalayan spices directly from local farmers.</p>
            </div>

            <!-- Page Grid -->
            <div class="shop-grid-layout">
                
                <!-- Left Sidebar Filters -->
                <aside class="filter-sidebar">
                    
                    <!-- Search group -->
                    <div class="filter-group">
                        <h3 class="filter-group-title">Search</h3>
                        <div class="filter-search-box">
                            <svg class="filter-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="shop-search" class="filter-search-input" placeholder="Type to filter..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Category filter -->
                    <div class="filter-group">
                        <h3 class="filter-group-title">Categories</h3>
                        <ul class="filter-categories-list">
                            <li>
                                <button class="category-filter-btn {{ !request('category') ? 'active' : '' }}" data-category="all">
                                    <span>All Specialties</span>
                                    <span class="category-count">{{ DB::table('products')->where('is_active', true)->count() }}</span>
                                </button>
                            </li>
                            @foreach ($categories as $cat)
                                @php
                                    $count = DB::table('products')->where('category_id', $cat->id)->where('is_active', true)->count();
                                    // Merge dried-fruits count under dry-fruits to preserve original JS mapping if needed, or render dynamically
                                    $slugAttr = $cat->slug;
                                    if ($slugAttr === 'dried-fruits') {
                                        $slugAttr = 'dry-fruits'; // merge under dry-fruits to keep JS behavior
                                    }
                                @endphp
                                <li>
                                    <button class="category-filter-btn {{ request('category') === $cat->slug ? 'active' : '' }}" data-category="{{ $slugAttr }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="category-count">{{ $count }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Sorting -->
                    <div class="filter-group" style="margin-bottom: 0;">
                        <h3 class="filter-group-title">Sort By</h3>
                        <select id="shop-sort" class="sort-select">
                            <option value="popularity">Popularity (Default)</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="rating">Average Rating</option>
                        </select>
                    </div>

                </aside>

                <!-- Right grid of products -->
                <div class="shop-products-column">
                    <div class="products-grid" id="shop-products-grid">
                        @if ($products->isNotEmpty())
                            @foreach ($products as $p)
                                @php
                                    // Normalize metadata category for JS filtering (merging dried fruits under dry fruits)
                                    $cat_slug = strtolower(str_replace(' ', '-', $p->category->name ?? ''));
                                    if ($cat_slug === 'dried-fruits') {
                                        $cat_slug = 'dry-fruits';
                                    }
                                    
                                    $first_weight = array_key_first($p->variants->pluck('price', 'weight')->toArray() ?? ['250g' => 0]);
                                    $first_price = $p->variants->first()->price ?? 0;
                                @endphp
                                <div class="product-card-wrapper-item" 
                                     data-category-filter="{{ $cat_slug }}" 
                                     data-price-filter="{{ $first_price }}" 
                                     data-rating-filter="5"
                                     data-title-filter="{{ strtolower($p->title) }}">
                                     @include('partials.product-card', ['product' => $p])
                                </div>
                            @endforeach
                        @endif

                        <!-- Empty State results -->
                        <div class="no-results-card" id="shop-no-results" style="display: none;">
                            <div class="no-results-icon">🌾</div>
                            <h3 style="color: var(--color-blue-dark); margin-bottom: 8px;">No specialties found</h3>
                            <p style="color: var(--color-text-secondary); font-size: 0.95rem;">Try adjusting your keyword filter or switching category tabs.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <!-- Interactive Filtering Javascript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const grid = document.getElementById('shop-products-grid');
            const searchInput = document.getElementById('shop-search');
            const sortSelect = document.getElementById('shop-sort');
            const catButtons = document.querySelectorAll('.category-filter-btn');
            const noResultsCard = document.getElementById('shop-no-results');
            
            // Extract items as elements
            const cards = Array.from(grid.querySelectorAll('.product-card-wrapper-item'));
            
            let activeCategory = 'all';
            let searchQuery = searchInput.value || '';
            
            // Helper to get selected category from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const initialCategory = urlParams.get('category');
            if (initialCategory) {
                let checkCat = initialCategory === 'dried-fruits' ? 'dry-fruits' : initialCategory;
                const btn = Array.from(catButtons).find(b => b.getAttribute('data-category') === checkCat);
                if (btn) {
                    catButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    activeCategory = checkCat;
                }
            }

            // Function to filter cards
            function filterProducts() {
                let visibleCount = 0;
                
                cards.forEach(card => {
                    const cardCat = card.getAttribute('data-category-filter');
                    const cardTitle = card.getAttribute('data-title-filter');
                    
                    const matchesCategory = (activeCategory === 'all' || cardCat === activeCategory);
                    const matchesSearch = (searchQuery === '' || cardTitle.includes(searchQuery.toLowerCase().trim()));
                    
                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCount === 0) {
                    noResultsCard.style.display = 'block';
                } else {
                    noResultsCard.style.display = 'none';
                }
            }

            // Sort products functionality
            function sortProducts() {
                const sortBy = sortSelect.value;
                const sorted = cards.slice().sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute('data-price-filter'));
                    const priceB = parseFloat(b.getAttribute('data-price-filter'));
                    const ratingA = parseInt(a.getAttribute('data-rating-filter'));
                    const ratingB = parseInt(b.getAttribute('data-rating-filter'));

                    if (sortBy === 'price-asc') {
                        return priceA - priceB;
                    } else if (sortBy === 'price-desc') {
                        return priceB - priceA;
                    } else if (sortBy === 'rating') {
                        return ratingB - ratingA;
                    } else {
                        return 0; // default order
                    }
                });

                cards.forEach(c => c.remove());
                sorted.forEach(c => {
                    grid.insertBefore(c, noResultsCard);
                });
            }

            // Bind Event Listeners
            searchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value;
                filterProducts();
            });

            sortSelect.addEventListener('change', () => {
                sortProducts();
            });

            catButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    catButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    activeCategory = btn.getAttribute('data-category');
                    
                    // Update URL search query without reloading
                    const newUrl = new URL(window.location);
                    if (activeCategory === 'all') {
                        newUrl.searchParams.delete('category');
                    } else {
                        let finalCat = activeCategory === 'dry-fruits' ? 'dry-fruits' : activeCategory;
                        newUrl.searchParams.set('category', finalCat);
                    }
                    window.history.pushState({}, '', newUrl);

                    filterProducts();
                });
            });

            // Initial trigger
            filterProducts();
            sortProducts();
        });
    </script>
@endsection
