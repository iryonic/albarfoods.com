@extends('layouts.admin')

@section('title', 'Product Catalog - Al Barr')
@section('header_title', 'Product Catalog')

@section('styles')
<style>
    .catalog-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
    }

    /* Grid & List Layouts */
    .prod-grid {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xl);
    }

    .prod-grid.grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 20px;
    }

    .prod-grid.grid-layout .prod-row-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        margin-bottom: 0;
    }

    .prod-grid.grid-layout .prod-variants-table-wrap {
        display: none;
    }

    .prod-grid.grid-layout .prod-grid-variants-summary {
        display: block !important;
    }

    .prod-row-card {
        background-color: var(--color-admin-card-bg);
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        overflow: hidden;
        box-shadow: var(--shadow-admin-sm);
        transition: all 0.25s ease;
    }

    .prod-row-card:hover {
        box-shadow: var(--shadow-admin-lg);
        border-color: rgba(197, 168, 128, 0.4);
    }

    .prod-row-header {
        background-color: #fafbfc;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--color-admin-border);
        flex-wrap: wrap;
        gap: 12px;
    }

    .prod-header-info {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .prod-header-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: contain;
        background-color: #fff;
        border: 1px solid var(--color-admin-border);
        padding: 2px;
    }

    .prod-header-title {
        font-family: var(--font-secondary);
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0;
    }

    .prod-meta-badges {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .prod-header-actions-group {
        display: flex;
        gap: 8px;
    }

    .prod-variants-table {
        width: 100%;
        border-collapse: collapse;
    }

    .prod-variants-table th {
        padding: 12px 20px;
        background-color: #fafbfc;
        border-bottom: 1px solid var(--color-admin-border);
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--color-admin-text-muted);
        text-transform: uppercase;
    }

    .prod-variants-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--color-admin-border-light);
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .prod-variants-table tr:last-child td {
        border-bottom: none;
    }

    .badge-stock {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .badge-stock.in-stock {
        background-color: rgba(1, 136, 73, 0.1);
        color: var(--color-admin-accent);
    }

    .badge-stock.low-stock {
        background-color: rgba(255, 179, 0, 0.1);
        color: var(--color-admin-gold);
    }

    .badge-stock.out-of-stock {
        background-color: rgba(220, 53, 69, 0.1);
        color: #ba3c1c;
    }

    /* Modals Overlay */
    .admin-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(11, 25, 44, 0.45);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 200;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .admin-modal-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    .admin-modal-card {
        background-color: #fff;
        border-radius: var(--radius-admin-card);
        width: 90%;
        max-width: 600px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: var(--shadow-admin-lg);
        transform: translateY(-30px) scale(0.95);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .admin-modal-overlay.active .admin-modal-card {
        transform: translateY(0) scale(1);
    }

    .admin-modal-header {
        background-color: var(--color-admin-sidebar);
        color: #fff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .admin-modal-title {
        font-family: var(--font-secondary);
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-admin-gold);
        margin: 0;
    }

    .admin-modal-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.8rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: color 0.2s;
    }

    .admin-modal-close:hover {
        color: var(--color-admin-gold);
    }

    .admin-modal-body {
        padding: 24px;
    }

    .admin-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 18px;
    }

    .admin-form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
    }

    .admin-textarea {
        font-family: var(--font-sans);
        padding: 10px 14px;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-input);
        font-size: 0.92rem;
        width: 100%;
        min-height: 80px;
        resize: vertical;
        box-sizing: border-box;
    }

    .admin-textarea:focus {
        border-color: var(--color-admin-accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.15);
    }

    /* Media Chooser Selection Styles */
    .media-chooser-item {
        border: 1px solid var(--color-admin-border);
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        background-color: #fff;
        transition: all 0.2s;
        position: relative;
    }
    .media-chooser-item:hover {
        border-color: var(--color-admin-accent);
        transform: translateY(-2px);
        box-shadow: var(--shadow-admin-md);
    }
    .media-chooser-item.selected {
        border-color: var(--color-admin-accent) !important;
        box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.2) !important;
    }
    .media-chooser-item.selected::after {
        content: '✓';
        position: absolute;
        top: 8px;
        right: 8px;
        background-color: var(--color-admin-accent);
        color: #fff;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        z-index: 2;
    }

    /* Gallery Container Styles */
    .gallery-item {
        transition: all 0.2s ease;
    }
    .gallery-item:hover {
        transform: scale(1.03);
        box-shadow: var(--shadow-admin-md) !important;
    }
    .gallery-item button:hover {
        background-color: #ba3c1c !important;
    }
</style>
@endsection

@section('content')
<!-- Search & Filter bar -->
<div class="catalog-header-actions">
    <input type="text" id="productSearch" class="admin-input" placeholder="🔍 Search catalog by title or SKU..." style="flex: 1; min-width: 250px;">
    
    <div style="display:flex; gap:10px; align-items: center;">
        {{-- List/Grid layout switcher --}}
        <div style="display: flex; background: var(--color-admin-border-light); border: 1px solid var(--color-admin-border); border-radius: 8px; overflow: hidden; padding: 2px;">
            <button id="layoutListBtn" title="List View" onclick="setCatalogLayout('list')" style="background: var(--color-admin-card-bg); border: none; color: var(--color-admin-text-main); cursor: pointer; padding: 8px 12px; border-radius: 6px; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: all 0.15s;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </button>
            <button id="layoutGridBtn" title="Grid View" onclick="setCatalogLayout('grid')" style="background: transparent; border: none; color: var(--color-admin-text-muted); cursor: pointer; padding: 8px 12px; border-radius: 6px; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: all 0.15s;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </button>
        </div>

        <a href="{{ route('admin.inventory') }}" class="btn-action-outline" style="padding: 11px 18px; font-size:0.85rem; height: 42px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v4H3z"/><path d="M3 11h18v4H3z"/><path d="M3 19h18v2H3z"/></svg>
            Manage Inventory
        </a>
        <button class="btn btn-gold" style="border-radius: 8px; padding: 12px 20px; font-weight: bold; height: 42px;" onclick="openAddProductModal()">
            + Add Product
        </button>
    </div>
</div>

<!-- Product list rows -->
<div class="prod-grid" id="productGrid">
    @forelse($products as $product)
        @php
            $totalStock = $product->variants->sum('stock');
            $outOfStockCount = $product->variants->where('stock', '<=', 0)->count();
            $lowStockCount = $product->variants->where('stock', '>', 0)->where('stock', '<=', 10)->count();
            $variantsCount = $product->variants->count();
            
            if ($variantsCount === 0) {
                $stockStatus = 'No Variants';
                $stockClass = 'pending';
            } elseif ($outOfStockCount === $variantsCount) {
                $stockStatus = 'Out of Stock';
                $stockClass = 'out-of-stock';
            } elseif ($outOfStockCount > 0) {
                $stockStatus = 'Partial Out';
                $stockClass = 'low-stock';
            } elseif ($lowStockCount > 0) {
                $stockStatus = 'Low Stock';
                $stockClass = 'low-stock';
            } else {
                $stockStatus = 'In Stock';
                $stockClass = 'in-stock';
            }
        @endphp
        <div class="prod-row-card" data-id="{{ $product->id }}" data-title="{{ strtolower($product->title) }}">
            <!-- Row Header -->
            <div class="prod-row-header">
                <div class="prod-header-info">
                    <input type="checkbox" class="product-select-checkbox" value="{{ $product->id }}" onclick="updateProductBulkBar()" style="margin-right: 6px; width: 16px; height: 16px; cursor: pointer;">
                    <img src="/{{ $product->image }}" alt="{{ $product->title }}" class="prod-header-thumb" {{ $product->id === 4 ? 'style=filter:hue-rotate(45deg);' : '' }}>
                    <div>
                        <h3 class="prod-header-title">{{ $product->title }}</h3>
                        <span style="font-size: 0.78rem; color: var(--color-admin-text-muted);">Origin: <strong>{{ $product->origin }}</strong></span>
                    </div>
                </div>
                <div class="prod-meta-badges">
                    <span class="status-badge" style="background-color: var(--color-admin-border-light); color: var(--color-admin-text-main); font-weight: 700;">
                        {{ $product->category->name ?? 'Staples' }}
                    </span>
                    <span class="badge-stock {{ $stockClass }}">
                        {{ $stockStatus }}
                    </span>
                    <span class="status-badge {{ $product->is_active ? 'delivered' : 'cancelled' }}">
                        {{ $product->is_active ? 'Active' : 'Draft' }}
                    </span>
                </div>
                <div class="prod-header-actions-group">
                    <button class="btn-action-outline" onclick="openEditProductModal({{ json_encode(array_merge($product->only('id', 'category_id', 'title', 'badge', 'description', 'origin', 'nutrition', 'storage', 'image', 'is_active'), ['gallery' => $product->images->pluck('image_path')->toArray()])) }})">
                        ✏️ Edit Details
                    </button>
                    <button class="btn-action-outline" onclick="openAddVariantModal({{ $product->id }}, '{{ $product->title }}')">
                        ➕ Add Variant
                    </button>
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this product and all its variants?');" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-outline danger">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summarized variants (only visible in Grid Layout) -->
            <div class="prod-grid-variants-summary" style="display: none; padding: 18px 20px; border-top: 1px solid var(--color-admin-border-light); background: #fafbfc; border-radius: 0 0 var(--radius-admin-card) var(--radius-admin-card);">
                <div style="font-weight: 700; color: var(--color-admin-text-muted); margin-bottom: 6px; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.4px;">Variants Summary</div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; color: var(--color-admin-accent); font-size: 0.86rem;">{{ $variantsCount }} weight options</span>
                    <span style="font-weight: 800; font-family: var(--font-secondary); font-size: 0.95rem;">Starts from ₹{{ number_format($product->variants->min('price'), 2) }}</span>
                </div>
            </div>

            <!-- Variants table -->
            <div class="prod-variants-table-wrap" style="overflow-x: auto;">
                <table class="prod-variants-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Weight Option</th>
                            <th>Sale Price</th>
                            <th>Compare Price (MRP)</th>
                            <th>Stock Qty</th>
                            <th>Status</th>
                            <th style="text-align: right; padding-right: 20px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->variants as $variant)
                            <tr data-sku="{{ strtolower($variant->sku) }}">
                                <td><strong style="font-family: var(--font-mono); font-size: 0.85rem; color: var(--color-admin-accent)">{{ $variant->sku }}</strong></td>
                                <td style="font-weight: 700; color: var(--color-admin-text-main);">{{ $variant->weight }}</td>
                                <td style="font-weight: 700;">₹{{ number_format($variant->price, 2) }}</td>
                                <td style="text-decoration: line-through; color: var(--color-admin-text-muted); font-size: 0.82rem;">₹{{ number_format($variant->orig_price, 2) }}</td>
                                <td><strong style="font-family: var(--font-mono); font-size: 0.95rem;">{{ $variant->stock }}</strong></td>
                                <td>
                                    @if($variant->stock > 20)
                                        <span class="badge-stock in-stock">In Stock</span>
                                    @elseif($variant->stock > 0)
                                        <span class="badge-stock low-stock">Low Stock</span>
                                    @else
                                        <span class="badge-stock out-of-stock">Out of Stock</span>
                                    @endif
                                </td>
                                <td style="text-align: right; padding-right: 20px; display: flex; justify-content: flex-end; gap: 6px;">
                                    <button class="btn-action-outline" onclick="openEditVariantModal({{ json_encode($variant->only('id', 'weight', 'price', 'orig_price', 'sku', 'stock')) }}, '{{ $product->title }}')">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.variants.delete', $variant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this weight variant?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-outline danger" style="padding: 6px 8px;">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="admin-card" style="text-align: center; color: var(--color-admin-text-muted); padding: var(--spacing-xl);">
            No products found in catalog.
        </div>
    @endforelse
</div>

<!-- Bulk Actions Floating Bar -->
<div id="productBulkActionsBar" style="display: none; position: fixed; bottom: 24px; left: calc(var(--admin-sidebar-width) + 24px); right: 24px; background: rgba(10, 15, 30, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; box-shadow: var(--shadow-admin-lg); z-index: 150; padding: 16px 24px; align-items: center; justify-content: space-between; gap: 16px; color: #fff; animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
    <div style="display: flex; align-items: center; gap: 12px;">
        <span style="background: var(--color-admin-accent); color: #fff; font-size: 0.72rem; padding: 3px 8px; border-radius: 6px; font-weight: bold;" id="productSelectedCountBadge">0</span>
        <span style="font-size: 0.85rem; font-weight: 600;">Products selected for batch updates</span>
    </div>
    <form action="{{ route('admin.products.bulk-status') }}" method="POST" style="margin: 0; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;" onsubmit="return confirm('Are you sure you want to update all selected products?');">
        @csrf
        <div id="productBulkFormIdsContainer"></div>
        
        <div style="display: flex; align-items: center; gap: 8px;">
            <label style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8;">Active Status:</label>
            <select name="is_active" class="admin-select" style="padding: 8px 12px; font-size: 0.8rem; background: #182235; color: #fff; border-color: rgba(255,255,255,0.15); width: auto; font-weight: bold; border-radius: 8px;">
                <option value="1">Active (Publish)</option>
                <option value="0">Draft (Unpublish)</option>
            </select>
        </div>

        <button type="submit" class="btn-solid-gold" style="padding: 8px 16px; font-size: 0.82rem; border-radius: 8px; border: none;">
            ⚡ Apply Changes
        </button>
        <button type="button" onclick="cancelProductBulkSelection()" style="background: none; border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.7); font-size: 0.82rem; padding: 8px 14px; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#fff';this.style.color='#fff';" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)';this.style.color='rgba(255,255,255,0.7)';">
            Cancel
        </button>
    </form>
</div>

<!-- ==================== MODALS GROUP ==================== -->

<!-- 1. Add Product Modal -->
<div class="admin-modal-overlay" id="addProductModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Add New Storefront Product</h3>
            <button class="admin-modal-close" onclick="closeModal('addProductModal')">&times;</button>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="admin-modal-body">
                <div class="admin-form-group">
                    <label for="addCategory">Product Category *</label>
                    <select name="category_id" id="addCategory" class="admin-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="addTitle">Product Title *</label>
                    <input type="text" name="title" id="addTitle" class="admin-input" placeholder="e.g. Organic Kashmiri Walnuts" required>
                </div>
                <div class="admin-form-group">
                    <label for="addBadge">Store Badge (Promo tag)</label>
                    <input type="text" name="badge" id="addBadge" class="admin-input" placeholder="e.g. Valley Sourced, Organic Grade">
                </div>
                <div class="admin-form-group">
                    <label for="addDescription">Product Description *</label>
                    <textarea name="description" id="addDescription" class="admin-textarea" placeholder="Detail description of product..." required></textarea>
                </div>
                <div class="admin-form-group">
                    <label for="addOrigin">Product Origin *</label>
                    <input type="text" name="origin" id="addOrigin" class="admin-input" placeholder="e.g. Zakura Orchards, Srinagar, J&K" required>
                </div>
                <div class="admin-form-group text-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="admin-form-group">
                        <label for="addNutrition">Nutrition Facts</label>
                        <input type="text" name="nutrition" id="addNutrition" class="admin-input" placeholder="e.g. Calories: 579kcal, Protein: 21g">
                    </div>
                    <div class="admin-form-group">
                        <label for="addStorage">Storage Instructions</label>
                        <input type="text" name="storage" id="addStorage" class="admin-input" placeholder="e.g. Keep airtight, store in a cool dry place">
                    </div>
                </div>
                <div class="admin-form-group">
                    <label for="addImage">Product Cover Image</label>
                    <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                        <input type="text" name="image" id="addImage" class="admin-input" placeholder="assets/img/walnuts.png">
                        <button type="button" class="btn-solid-gold" style="white-space: nowrap; padding: 10px 14px; font-size: 0.8rem; border-radius: 8px; border: none;" onclick="openMediaChooser('addImage')">🖼️ Choose</button>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label style="margin-bottom: 6px;">Product Gallery (Multiple Images)</label>
                    <div id="addGalleryContainer" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
                        <!-- Gallery thumbnails -->
                    </div>
                    <button type="button" class="btn-action-outline" style="align-self: flex-start;" onclick="openMediaChooserForGallery('addGalleryContainer')">
                        🖼️ Add / Manage Gallery Images
                    </button>
                </div>
                <div class="admin-form-group">
                    <label for="addStatus">Publish Status *</label>
                    <select name="is_active" id="addStatus" class="admin-select" required>
                        <option value="1">Active (Visible on storefront)</option>
                        <option value="0">Draft (Hidden)</option>
                    </select>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--color-admin-border); margin: 20px 0;">
                <h4 style="font-family: var(--font-secondary); margin-bottom: 12px; color: var(--color-admin-text-main)">➕ Add Initial Variant</h4>
                <div style="display: grid; grid-template-columns: 1.2fr 1fr 1.2fr; gap: 10px; margin-bottom: 10px;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: bold;">Weight Label *</label>
                        <input type="text" name="variants[0][weight]" class="admin-input" placeholder="e.g. 500g" required>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: bold;">SKU *</label>
                        <input type="text" name="variants[0][sku]" class="admin-input" placeholder="ALB-WAL-500G" required>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: bold;">Stock Qty *</label>
                        <input type="number" name="variants[0][stock]" class="admin-input" placeholder="100" required>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: bold;">Sale Price (₹) *</label>
                        <input type="number" step="0.01" name="variants[0][price]" class="admin-input" placeholder="850.00" required>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: bold;">Compare Price (₹) *</label>
                        <input type="number" step="0.01" name="variants[0][orig_price]" class="admin-input" placeholder="990.00" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold" style="width: 100%; padding: 12px; font-weight: bold; margin-top: 24px;">
                    Save and Publish Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Edit Product Modal -->
<div class="admin-modal-overlay" id="editProductModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Edit Product Metadata</h3>
            <button class="admin-modal-close" onclick="closeModal('editProductModal')">&times;</button>
        </div>
        <form id="editProductForm" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-modal-body">
                <div class="admin-form-group">
                    <label for="editCategory">Product Category *</label>
                    <select name="category_id" id="editCategory" class="admin-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="editTitle">Product Title *</label>
                    <input type="text" name="title" id="editTitle" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="editBadge">Store Badge (Promo tag)</label>
                    <input type="text" name="badge" id="editBadge" class="admin-input">
                </div>
                <div class="admin-form-group">
                    <label for="editDescription">Product Description *</label>
                    <textarea name="description" id="editDescription" class="admin-textarea" required></textarea>
                </div>
                <div class="admin-form-group">
                    <label for="editOrigin">Product Origin *</label>
                    <input type="text" name="origin" id="editOrigin" class="admin-input" required>
                </div>
                <div class="admin-form-group text-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="admin-form-group">
                        <label for="editNutrition">Nutrition Facts</label>
                        <input type="text" name="nutrition" id="editNutrition" class="admin-input">
                    </div>
                    <div class="admin-form-group">
                        <label for="editStorage">Storage Instructions</label>
                        <input type="text" name="storage" id="editStorage" class="admin-input">
                    </div>
                </div>
                <div class="admin-form-group">
                    <label for="editImage">Product Cover Image</label>
                    <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                        <input type="text" name="image" id="editImage" class="admin-input">
                        <button type="button" class="btn-solid-gold" style="white-space: nowrap; padding: 10px 14px; font-size: 0.8rem; border-radius: 8px; border: none;" onclick="openMediaChooser('editImage')">🖼️ Choose</button>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label style="margin-bottom: 6px;">Product Gallery (Multiple Images)</label>
                    <div id="editGalleryContainer" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
                        <!-- Gallery thumbnails -->
                    </div>
                    <button type="button" class="btn-action-outline" style="align-self: flex-start;" onclick="openMediaChooserForGallery('editGalleryContainer')">
                        🖼️ Add / Manage Gallery Images
                    </button>
                </div>
                <div class="admin-form-group">
                    <label for="editStatus">Publish Status *</label>
                    <select name="is_active" id="editStatus" class="admin-select" required>
                        <option value="1">Active</option>
                        <option value="0">Draft</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-gold" style="width: 100%; padding: 12px; font-weight: bold; margin-top: 15px;">
                    Update Product Details
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Add Variant Modal -->
<div class="admin-modal-overlay" id="addVariantModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Add Product Variant</h3>
            <button class="admin-modal-close" onclick="closeModal('addVariantModal')">&times;</button>
        </div>
        <form id="addVariantForm" method="POST">
            @csrf
            <div class="admin-modal-body">
                <div style="background-color: var(--color-admin-border-light); padding: 10px; border-radius: 6px; font-weight: bold; font-size: 0.85rem; margin-bottom: 15px;" id="addVariantProductTitle">Product Title</div>
                
                <div class="admin-form-group">
                    <label for="vWeight">Weight Label *</label>
                    <input type="text" name="weight" id="vWeight" class="admin-input" placeholder="e.g. 1kg or 500g" required>
                </div>
                <div class="admin-form-group">
                    <label for="vSku">SKU (Stock Keeping Unit) *</label>
                    <input type="text" name="sku" id="vSku" class="admin-input" placeholder="e.g. ALB-SAF-500G" required>
                </div>
                <div class="admin-form-group">
                    <label for="vPrice">Sale Price (₹) *</label>
                    <input type="number" step="0.01" name="price" id="vPrice" class="admin-input" placeholder="0.00" required>
                </div>
                <div class="admin-form-group">
                    <label for="vOrigPrice">Compare Price (₹ MRP) *</label>
                    <input type="number" step="0.01" name="orig_price" id="vOrigPrice" class="admin-input" placeholder="0.00" required>
                </div>
                <div class="admin-form-group">
                    <label for="vStock">Initial Stock Qty *</label>
                    <input type="number" name="stock" id="vStock" class="admin-input" placeholder="0" required>
                </div>

                <button type="submit" class="btn btn-gold" style="width: 100%; padding: 12px; font-weight: bold; margin-top: 15px;">
                    Save and Insert Variant
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Edit Variant Modal -->
<div class="admin-modal-overlay" id="editVariantModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Edit Weight Variant</h3>
            <button class="admin-modal-close" onclick="closeModal('editVariantModal')">&times;</button>
        </div>
        <form id="editVariantForm" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-modal-body">
                <div style="background-color: var(--color-admin-border-light); padding: 10px; border-radius: 6px; font-weight: bold; font-size: 0.85rem; margin-bottom: 15px;" id="editVariantProductTitle">Product Title</div>
                
                <div class="admin-form-group">
                    <label for="editvWeight">Weight Label *</label>
                    <input type="text" name="weight" id="editvWeight" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="editvSku">SKU (Stock Keeping Unit) *</label>
                    <input type="text" name="sku" id="editvSku" class="admin-input" required>
                </div>
                <div class="admin-form-group text-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="admin-form-group">
                        <label for="editvPrice">Sale Price (₹) *</label>
                        <input type="number" step="0.01" name="price" id="editvPrice" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="editvOrigPrice">Compare Price (₹ MRP) *</label>
                        <input type="number" step="0.01" name="orig_price" id="editvOrigPrice" class="admin-input" required>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label for="editvStock">Stock Quantity *</label>
                    <input type="number" name="stock" id="editvStock" class="admin-input" required>
                </div>

                <button type="submit" class="btn btn-gold" style="width: 100%; padding: 12px; font-weight: bold; margin-top: 15px;">
                    Update Variant Details
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Media Library Chooser Modal Component --}}
<div class="admin-modal-overlay" id="mediaChooserModal" style="z-index: 300;">
    <div class="admin-modal-card" style="max-width: 800px; width: 90%;">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Select Image from Media Library</h3>
            <button type="button" class="admin-modal-close" onclick="closeModal('mediaChooserModal')">&times;</button>
        </div>
        <div class="admin-modal-body" style="padding: 20px;">
            <div style="margin-bottom: 20px; padding: 15px; border: 2px dashed var(--color-admin-border); border-radius: 12px; display: flex; align-items: center; justify-content: space-between; gap: 15px; background: var(--color-admin-border-light);">
                <div>
                    <h5 style="margin: 0 0 4px; font-family: var(--font-secondary); color: var(--color-admin-text-main);">Upload New File</h5>
                    <p style="margin: 0; font-size: 0.75rem; color: var(--color-admin-text-muted);">Instantly upload and use an image.</p>
                </div>
                <div>
                    <input type="file" id="chooserUploadInput" accept="image/*" style="display: none;" onchange="uploadChooserFile()">
                    <button type="button" class="btn-solid-accent" style="padding: 8px 14px; font-size: 0.8rem; border-radius: 8px;" onclick="document.getElementById('chooserUploadInput').click()">
                        📤 Upload Image
                    </button>
                </div>
            </div>
            
            <div style="margin-bottom: 15px; display: flex; gap: 10px;">
                <input type="text" id="mediaChooserSearch" class="admin-input" placeholder="🔍 Search media library by name..." oninput="loadChooserMedia()">
            </div>
            
            <div style="max-height: 380px; overflow-y: auto; padding-right: 5px;">
                <div id="mediaChooserGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 14px;">
                    <!-- Loaded dynamically -->
                </div>
            </div>

            <div id="mediaChooserFooter" style="display: none; justify-content: flex-end; padding-top: 15px; border-top: 1px solid var(--color-admin-border-light); margin-top: 15px;">
                <button type="button" class="btn btn-gold" id="btnConfirmMediaSelection" onclick="confirmMediaSelection()" style="padding: 10px 20px; font-weight: bold; border-radius: 8px; border: none;">
                    Confirm Selection (0)
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Grid/List Layout Mode Toggle
    function setCatalogLayout(mode) {
        const grid = document.getElementById('productGrid');
        const listBtn = document.getElementById('layoutListBtn');
        const gridBtn = document.getElementById('layoutGridBtn');
        
        if (mode === 'grid') {
            grid.classList.add('grid-layout');
            gridBtn.style.background = 'var(--color-admin-card-bg)';
            gridBtn.style.color = 'var(--color-admin-text-main)';
            listBtn.style.background = 'transparent';
            listBtn.style.color = 'var(--color-admin-text-muted)';
            localStorage.setItem('admin-catalog-layout', 'grid');
        } else {
            grid.classList.remove('grid-layout');
            listBtn.style.background = 'var(--color-admin-card-bg)';
            listBtn.style.color = 'var(--color-admin-text-main)';
            gridBtn.style.background = 'transparent';
            gridBtn.style.color = 'var(--color-admin-text-muted)';
            localStorage.setItem('admin-catalog-layout', 'list');
        }
    }

    // Restore layout preference on load
    document.addEventListener('DOMContentLoaded', () => {
        const savedLayout = localStorage.getItem('admin-catalog-layout') || 'list';
        setCatalogLayout(savedLayout);
    });

    // Search filter logic
    document.getElementById('productSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.prod-row-card');
        
        rows.forEach(row => {
            const title = row.getAttribute('data-title');
            let matched = title.includes(query);
            
            if (!matched) {
                // Check variant SKUs
                const skus = row.querySelectorAll('tbody tr');
                skus.forEach(tr => {
                    const sku = tr.getAttribute('data-sku');
                    if (sku && sku.includes(query)) {
                        matched = true;
                    }
                });
            }
            
            if (matched) {
                row.style.display = 'block';
            } else {
                row.style.display = 'none';
            }
        });
        updateProductBulkBar();
    });

    // Universal Modal triggers
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = '';
    }

    // Modal Add Product
    function openAddProductModal() {
        const form = document.querySelector('#addProductModal form');
        form.reset();
        document.getElementById('addGalleryContainer').innerHTML = '';
        openModal('addProductModal');
    }

    // Modal Edit Product Details
    function openEditProductModal(product) {
        const form = document.getElementById('editProductForm');
        form.action = `/admin/products/${product.id}`;
        
        document.getElementById('editCategory').value = product.category_id;
        document.getElementById('editTitle').value = product.title;
        document.getElementById('editBadge').value = product.badge || '';
        document.getElementById('editDescription').value = product.description;
        document.getElementById('editOrigin').value = product.origin;
        document.getElementById('editNutrition').value = product.nutrition || '';
        document.getElementById('editStorage').value = product.storage || '';
        document.getElementById('editImage').value = product.image || '';
        document.getElementById('editStatus').value = product.is_active;

        const container = document.getElementById('editGalleryContainer');
        container.innerHTML = '';
        if (product.gallery && product.gallery.length > 0) {
            product.gallery.forEach(path => {
                addGalleryItemMarkup(container, path);
            });
        }

        openModal('editProductModal');
    }

    // Modal Add Variant
    function openAddVariantModal(productId, productTitle) {
        const form = document.getElementById('addVariantForm');
        form.action = `/admin/products/${productId}/variants`;
        document.getElementById('addVariantProductTitle').innerText = productTitle;
        
        document.getElementById('vWeight').value = '';
        document.getElementById('vSku').value = '';
        document.getElementById('vPrice').value = '';
        document.getElementById('vOrigPrice').value = '';
        document.getElementById('vStock').value = '';

        openModal('addVariantModal');
    }

    // Modal Edit Variant Details
    function openEditVariantModal(variant, productTitle) {
        const form = document.getElementById('editVariantForm');
        form.action = `/admin/products/variants/${variant.id}`;
        document.getElementById('editVariantProductTitle').innerText = productTitle;

        document.getElementById('editvWeight').value = variant.weight;
        document.getElementById('editvSku').value = variant.sku;
        document.getElementById('editvPrice').value = variant.price;
        document.getElementById('editvOrigPrice').value = variant.orig_price;
        document.getElementById('editvStock').value = variant.stock;

        openModal('editVariantModal');
    }

    // Media library selection state
    let currentTargetInputId = '';
    let selectedChooserMediaPaths = new Set();
    let isMultipleSelectionMode = false;
    let currentTargetGalleryContainerId = '';

    function openMediaChooser(targetInputId) {
        currentTargetInputId = targetInputId;
        isMultipleSelectionMode = false;
        document.getElementById('mediaChooserFooter').style.display = 'none';
        document.querySelector('#mediaChooserModal .admin-modal-title').innerText = 'Select Image from Media Library';
        openModal('mediaChooserModal');
        loadChooserMedia();
    }

    function openMediaChooserForGallery(containerId) {
        currentTargetGalleryContainerId = containerId;
        isMultipleSelectionMode = true;
        
        selectedChooserMediaPaths.clear();
        const container = document.getElementById(containerId);
        const currentInputs = container.querySelectorAll('input[type="hidden"]');
        currentInputs.forEach(input => {
            selectedChooserMediaPaths.add(input.value);
        });
        
        document.getElementById('btnConfirmMediaSelection').innerText = `Confirm Selection (${selectedChooserMediaPaths.size})`;
        document.getElementById('mediaChooserFooter').style.display = 'flex';
        document.querySelector('#mediaChooserModal .admin-modal-title').innerText = 'Select Images for Product Gallery';
        
        openModal('mediaChooserModal');
        loadChooserMedia();
    }

    function loadChooserMedia() {
        const searchVal = document.getElementById('mediaChooserSearch').value;
        const grid = document.getElementById('mediaChooserGrid');
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: var(--color-admin-text-muted); padding: 40px;">Loading gallery...</div>';
        
        fetch(`/admin/api/media?search=${encodeURIComponent(searchVal)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: var(--color-admin-text-muted); padding: 40px;">No media found.</div>';
                    return;
                }
                grid.innerHTML = '';
                data.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'media-chooser-item' + (selectedChooserMediaPaths.has(item.file_path) ? ' selected' : '');
                    itemDiv.onclick = () => selectChooserMedia(item.file_path, itemDiv);
                    
                    itemDiv.innerHTML = `
                        <div style="position: relative; padding-top: 90%; background: #f8fafc; border-bottom: 1px solid var(--color-admin-border-light);">
                            <img src="/${item.file_path}" style="position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div style="padding: 6px 8px; font-size: 0.7rem; font-weight: 700; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--color-admin-text-main);" title="${item.file_name}">
                            ${item.file_name}
                        </div>
                    `;
                    grid.appendChild(itemDiv);
                });
            })
            .catch(err => {
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: #ba3c1c; padding: 40px;">Failed to load media catalog.</div>';
                console.error(err);
            });
    }

    function selectChooserMedia(filePath, element) {
        if (isMultipleSelectionMode) {
            if (selectedChooserMediaPaths.has(filePath)) {
                selectedChooserMediaPaths.delete(filePath);
                if (element) element.classList.remove('selected');
            } else {
                selectedChooserMediaPaths.add(filePath);
                if (element) element.classList.add('selected');
            }
            document.getElementById('btnConfirmMediaSelection').innerText = `Confirm Selection (${selectedChooserMediaPaths.size})`;
        } else {
            if (currentTargetInputId) {
                document.getElementById(currentTargetInputId).value = filePath;
            }
            closeModal('mediaChooserModal');
        }
    }

    function confirmMediaSelection() {
        const container = document.getElementById(currentTargetGalleryContainerId);
        container.innerHTML = '';
        
        selectedChooserMediaPaths.forEach(path => {
            addGalleryItemMarkup(container, path);
        });
        
        closeModal('mediaChooserModal');
    }

    function addGalleryItemMarkup(container, path) {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'gallery-item';
        itemDiv.dataset.path = path;
        itemDiv.style.position = 'relative';
        itemDiv.style.width = '80px';
        itemDiv.style.height = '80px';
        itemDiv.style.border = '1px solid var(--color-admin-border)';
        itemDiv.style.borderRadius = '8px';
        itemDiv.style.overflow = 'hidden';
        itemDiv.style.backgroundColor = '#fff';
        itemDiv.style.boxShadow = 'var(--shadow-admin-sm)';
        
        itemDiv.innerHTML = `
            <img src="/${path}" style="width: 100%; height: 100%; object-fit: cover;">
            <input type="hidden" name="gallery_images[]" value="${path}">
            <button type="button" onclick="removeGalleryItem(this)" style="position: absolute; top: 4px; right: 4px; background: rgba(220, 53, 69, 0.85); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px; cursor: pointer; padding: 0; transition: background 0.2s;">&times;</button>
        `;
        
        container.appendChild(itemDiv);
    }

    function removeGalleryItem(button) {
        const itemDiv = button.closest('.gallery-item');
        if (itemDiv) {
            itemDiv.remove();
        }
    }

    function uploadChooserFile() {
        const input = document.getElementById('chooserUploadInput');
        if (input.files.length === 0) return;
        
        const file = input.files[0];
        const formData = new FormData();
        formData.append('file', file);
        
        const uploadBtn = document.querySelector('#mediaChooserModal .btn-solid-accent');
        const originalText = uploadBtn.innerHTML;
        uploadBtn.innerHTML = '⏳ Uploading...';
        uploadBtn.disabled = true;
        
        fetch('{{ route("admin.media.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            uploadBtn.innerHTML = originalText;
            uploadBtn.disabled = false;
            input.value = '';
            
            if (data.success) {
                if (isMultipleSelectionMode) {
                    selectedChooserMediaPaths.add(data.media.file_path);
                    loadChooserMedia();
                } else {
                    loadChooserMedia();
                    selectChooserMedia(data.media.file_path);
                }
            } else {
                alert('Upload failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            uploadBtn.innerHTML = originalText;
            uploadBtn.disabled = false;
            input.value = '';
            alert('Upload failed. Please check file formats and size.');
            console.error(err);
        });
    }

    /* ─── Bulk Product Actions Logic ─── */
    function updateProductBulkBar() {
        const checkboxes = document.querySelectorAll('.product-select-checkbox:checked');
        const bar = document.getElementById('productBulkActionsBar');
        const badge = document.getElementById('productSelectedCountBadge');
        const container = document.getElementById('productBulkFormIdsContainer');

        if (checkboxes.length > 0) {
            badge.innerText = checkboxes.length;
            bar.style.display = 'flex';
            
            container.innerHTML = '';
            checkboxes.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'product_ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        } else {
            bar.style.display = 'none';
            container.innerHTML = '';
        }
    }

    function cancelProductBulkSelection() {
        document.querySelectorAll('.product-select-checkbox').forEach(cb => cb.checked = false);
        updateProductBulkBar();
    }
</script>
@endsection
