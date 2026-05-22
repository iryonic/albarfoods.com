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
    
    // Normalize metadata category for JS filtering
    $cat_slug = strtolower(str_replace(' ', '-', $p['meta']));
    if ($cat_slug === 'dried-fruits') {
        $cat_slug = 'dry-fruits'; // Merge dried figs under dry-fruits category
    }
    
    ob_start();
    ?>
    <div class="product-card" 
         data-product-id="<?php echo $p['id']; ?>" 
         data-category="<?php echo $cat_slug; ?>" 
         data-price="<?php echo $first_variant['price']; ?>" 
         data-rating="<?php echo $p['rating']; ?>"
         data-title="<?php echo htmlspecialchars(strtolower($p['title'])); ?>">
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
    <meta name="description" content="Browse Al Barr's collection of organic Kashmiri products. Pure almonds, Grade A+ Mogra Saffron, raw honey, walnuts, organic pulses, and black cumin.">
    <title>Shop Online - Al Barr | Premium Organic Kashmiri Harvest</title>
    
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <link rel="stylesheet" href="assets/css/variables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/components.css?v=<?php echo time(); ?>">

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
</head>
<body>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

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
                            <input type="text" id="shop-search" class="filter-search-input" placeholder="Type to filter...">
                        </div>
                    </div>

                    <!-- Category filter -->
                    <div class="filter-group">
                        <h3 class="filter-group-title">Categories</h3>
                        <ul class="filter-categories-list">
                            <li>
                                <button class="category-filter-btn active" data-category="all">
                                    <span>All Specialties</span>
                                    <span class="category-count"><?php echo count($products); ?></span>
                                </button>
                            </li>
                            <li>
                                <button class="category-filter-btn" data-category="dry-fruits">
                                    <span>Dry Fruits & Figs</span>
                                    <span class="category-count">
                                        <?php 
                                        echo count(array_filter($products, function($p) {
                                            return $p['meta'] === 'Dry Fruits' || $p['meta'] === 'Dried Fruits';
                                        }));
                                        ?>
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="category-filter-btn" data-category="spices">
                                    <span>Saffron & Spices</span>
                                    <span class="category-count">
                                        <?php 
                                        echo count(array_filter($products, function($p) {
                                            return $p['meta'] === 'Spices';
                                        }));
                                        ?>
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="category-filter-btn" data-category="honey">
                                    <span>Acacia Honey</span>
                                    <span class="category-count">
                                        <?php 
                                        echo count(array_filter($products, function($p) {
                                            return $p['meta'] === 'Honey';
                                        }));
                                        ?>
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="category-filter-btn" data-category="seeds">
                                    <span>Dried Seeds</span>
                                    <span class="category-count">
                                        <?php 
                                        echo count(array_filter($products, function($p) {
                                            return $p['meta'] === 'Dried Seeds';
                                        }));
                                        ?>
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="category-filter-btn" data-category="pulses">
                                    <span>Kashmiri Pulses</span>
                                    <span class="category-count">
                                        <?php 
                                        echo count(array_filter($products, function($p) {
                                            return $p['meta'] === 'Pulses';
                                        }));
                                        ?>
                                    </span>
                                </button>
                            </li>
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
                        <?php 
                        if (!empty($products)) {
                            foreach ($products as $p) {
                                echo renderProductCard($p);
                            }
                        }
                        ?>

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

    <!-- Side Cart, Quick View, and Toasters -->
    <?php include 'includes/sidebar-cart.php'; ?>
    <?php include 'includes/quick-view.php'; ?>
    <div class="toast-container" id="toast-container"></div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Interactive Filtering Javascript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const grid = document.getElementById('shop-products-grid');
            const searchInput = document.getElementById('shop-search');
            const sortSelect = document.getElementById('shop-sort');
            const catButtons = document.querySelectorAll('.category-filter-btn');
            const noResultsCard = document.getElementById('shop-no-results');
            
            // Extract items as elements
            const cards = Array.from(grid.querySelectorAll('.product-card'));
            
            let activeCategory = 'all';
            let searchQuery = '';
            
            // Helper to get selected category from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const initialCategory = urlParams.get('category');
            if (initialCategory) {
                const btn = Array.from(catButtons).find(b => b.getAttribute('data-category') === initialCategory);
                if (btn) {
                    catButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    activeCategory = initialCategory;
                }
            }

            // Function to filter cards
            function filterProducts() {
                let visibleCount = 0;
                
                cards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    const cardTitle = card.getAttribute('data-title');
                    
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
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    const ratingA = parseInt(a.getAttribute('data-rating'));
                    const ratingB = parseInt(b.getAttribute('data-rating'));
                    const idA = parseInt(a.getAttribute('data-product-id'));
                    const idB = parseInt(b.getAttribute('data-product-id'));

                    if (sortBy === 'price-asc') {
                        return priceA - priceB;
                    } else if (sortBy === 'price-desc') {
                        return priceB - priceA;
                    } else if (sortBy === 'rating') {
                        return ratingB - ratingA;
                    } else {
                        // default: popularity / id order
                        return idA - idB;
                    }
                });

                // Clear layout except the no results card
                cards.forEach(c => c.remove());
                
                // Append sorted cards back
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
                        newUrl.searchParams.set('category', activeCategory);
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
</body>
</html>
