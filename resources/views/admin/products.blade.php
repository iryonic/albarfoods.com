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

    .prod-grid {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xl);
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
        box-shadow: var(--shadow-admin-md);
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

    .btn-action-outline {
        background: transparent;
        border: 1px solid var(--color-admin-border);
        color: var(--color-admin-text-muted);
        padding: 6px 12px;
        font-size: 0.78rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-action-outline:hover {
        border-color: var(--color-admin-text-main);
        color: var(--color-admin-text-main);
        background-color: var(--color-admin-border-light);
    }

    .btn-action-outline.danger:hover {
        border-color: #ba3c1c;
        color: #ba3c1c;
        background-color: #fbeae5;
    }

    .btn-solid-accent {
        background-color: var(--color-admin-accent);
        color: #fff;
        border: 1px solid var(--color-admin-accent);
        padding: 10px 18px;
        font-size: 0.88rem;
        border-radius: var(--radius-admin-input);
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-solid-accent:hover {
        background-color: var(--color-admin-accent-hover);
        border-color: var(--color-admin-accent-hover);
    }
</style>
@endsection

@section('content')
<!-- Search & Filter bar -->
<div class="catalog-header-actions">
    <input type="text" id="productSearch" class="admin-input" placeholder="🔍 Search catalog by title or SKU..." style="flex: 1; min-width: 250px;">
    
    <div style="display:flex; gap:10px;">
        <a href="{{ route('admin.inventory') }}" class="btn-action-outline" style="padding: 11px 18px; font-size:0.85rem;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v4H3z"/><path d="M3 11h18v4H3z"/><path d="M3 19h18v2H3z"/></svg>
            Manage Inventory
        </a>
        <button class="btn btn-gold" style="border-radius: 8px; padding: 12px 20px; font-weight: bold;" onclick="openAddProductModal()">
            + Add New Product
        </button>
    </div>
</div>

<!-- Product list rows -->
<div class="prod-grid" id="productGrid">
    @forelse($products as $product)
        <div class="prod-row-card" data-title="{{ strtolower($product->title) }}">
            <!-- Row Header -->
            <div class="prod-row-header">
                <div class="prod-header-info">
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
                    <span class="status-badge {{ $product->is_active ? 'delivered' : 'cancelled' }}">
                        {{ $product->is_active ? 'Active' : 'Draft' }}
                    </span>
                </div>
                <div class="prod-header-actions-group">
                    <button class="btn-action-outline" onclick="openEditProductModal({{ json_encode($product->only('id', 'category_id', 'title', 'badge', 'description', 'origin', 'nutrition', 'storage', 'image', 'is_active')) }})">
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

            <!-- Variants table -->
            <div style="overflow-x: auto;">
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
                    <label for="addImage">Product Image Path</label>
                    <input type="text" name="image" id="addImage" class="admin-input" placeholder="assets/img/walnuts.png">
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
                    <label for="editImage">Product Image Path</label>
                    <input type="text" name="image" id="editImage" class="admin-input">
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

{{-- Stock adjustment has been moved to the dedicated Inventory Management page --}}
@endsection

@section('scripts')
<script>
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
                    if (sku.includes(query)) {
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

        openModal('editProductModal');
    }

    // Modal Add Variant
    function openAddVariantModal(productId, productTitle) {
        const form = document.getElementById('addVariantForm');
        form.action = `/admin/products/${productId}/variants`;
        document.getElementById('addVariantProductTitle').innerText = productTitle;
        
        // Reset inputs
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

    // Modal Adjust Stock (Original)
    function openStockModal(variantId, title, weight, currentStock) {
        document.getElementById('modalVariantId').value = variantId;
        document.getElementById('modalProductTitle').innerText = title;
        document.getElementById('modalVariantWeight').innerText = weight;
        document.getElementById('modalCurrentStock').innerText = currentStock;
        
        document.getElementById('stockChange').value = '';
        document.getElementById('stockType').value = 'Stock In';

        openModal('stockModal');
    }

    document.getElementById('stockType').addEventListener('change', function() {
        const qtyInput = document.getElementById('stockChange');
        if (this.value === 'Stock Out') {
            qtyInput.placeholder = 'e.g. -10 (negative value)';
        } else {
            qtyInput.placeholder = 'e.g. 50 (positive value)';
        }
    });
</script>
@endsection
