@php
    // Determine variants structure from array or Model relationship
    $variantsArray = [];
    if (is_array($product)) {
        $variantsArray = $product['variants'];
        $pid = $product['id'];
        $title = $product['title'];
        $image = $product['image'];
        $badge = $product['badge'];
        $meta = $product['meta'];
        $rating = $product['rating'] ?? 5;
        $reviews = $product['reviews'] ?? 0;
    } else {
        $pid = $product->id;
        $title = $product->title;
        $image = '/' . $product->image;
        $badge = $product->badge;
        $meta = $product->category->name ?? 'Organic';
        $rating = 5; // default
        
        $mock_reviews = [1 => 48, 2 => 94, 3 => 37, 4 => 22, 5 => 29, 6 => 41, 7 => 18, 8 => 34];
        $reviews = $mock_reviews[$product->id] ?? 15;

        foreach ($product->variants as $v) {
            $variantsArray[$v->weight] = [
                'price' => (float)$v->price,
                'orig' => (float)$v->orig_price
            ];
        }
    }

    $first_weight = array_key_first($variantsArray);
    $first_variant = $variantsArray[$first_weight];
    $discount_pct = 0;
    if ($first_variant['orig'] > $first_variant['price']) {
        $discount_pct = round((($first_variant['orig'] - $first_variant['price']) / $first_variant['orig']) * 100);
    }
    
    // Custom filter for dried figs styling (matching original frontend)
    $img_style = '';
    if ($pid == 4) {
        $img_style = 'style="filter: hue-rotate(45deg);"';
    }
@endphp

<div class="product-card" data-product-id="{{ $pid }}">
    <div class="product-badge-wrap">
        @if ($discount_pct > 0)
            <span class="badge badge-discount">-{{ $discount_pct }}%</span>
        @endif
        @if (!empty($badge))
            <span class="badge badge-sale" style="background-color: var(--color-gold-light); color: var(--color-gold);">{{ $badge }}</span>
        @endif
    </div>
    <div class="product-image-wrapper">
        <img src="{{ $image }}" alt="{{ $title }}" class="product-image" {!! $img_style !!}>
        <a href="#" class="product-quick-view-btn" data-product-id="{{ $pid }}">Quick View</a>
    </div>
    <div class="product-details">
        <span class="product-meta">{{ $meta }}</span>
        <h3 class="product-title"><a href="/product/{{ $pid }}">{{ $title }}</a></h3>
        <div class="product-rating">
            @for ($i = 1; $i <= 5; $i++)
                {!! $i <= $rating ? '★' : '☆' !!}
            @endfor
            <span class="product-rating-count">({{ $reviews }})</span>
        </div>
        
        <div class="product-variant-selector">
            <div class="variant-pill-wrapper">
                @php $idx = 0; @endphp
                @foreach ($variantsArray as $weight => $data)
                    @php $activeClass = ($idx === 0) ? 'active' : ''; @endphp
                    <button class="variant-pill {{ $activeClass }}" 
                            data-weight="{{ $weight }}" 
                            data-price="{{ $data['price'] }}" 
                            data-orig="{{ $data['orig'] }}">
                        <span class="pill-weight">{{ $weight }}</span>
                        <span class="pill-price">₹{{ number_format($data['price'], 0) }}</span>
                    </button>
                    @php $idx++; @endphp
                @endforeach
            </div>
        </div>
        
        <div class="product-purchase-footer">
            <div class="product-price-info">
                <span class="price-current" id="price-current-{{ $pid }}">₹{{ number_format($first_variant['price'], 2) }}</span>
                <span class="price-original" id="price-orig-{{ $pid }}">₹{{ number_format($first_variant['orig'], 2) }}</span>
            </div>
            
            <div class="cart-control-btn" data-product-id="{{ $pid }}">
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
