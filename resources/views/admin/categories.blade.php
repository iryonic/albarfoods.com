@extends('layouts.admin')

@section('title', 'Category Management - Al Barr')
@section('header_title', 'Category Management')

@section('styles')
<style>
    .cat-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media(max-width: 640px) { .cat-stats-grid { grid-template-columns: 1fr; } }

    .cat-stat-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-admin-sm);
    }

    .cat-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cat-stat-icon svg { width: 22px; height: 22px; }
    .cat-stat-icon.blue   { background: #e4f0ff; color: #1a56d6; }
    .cat-stat-icon.green  { background: #e3fbeb; color: #018849; }
    .cat-stat-icon.amber  { background: #fff8e1; color: #b56f00; }

    .cat-stat-val   { font-family: var(--font-secondary); font-size: 1.85rem; font-weight: 800; color: var(--color-admin-text-main); line-height: 1; }
    .cat-stat-label { font-size: 0.78rem; color: var(--color-admin-text-muted); font-weight: 600; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.4px; }

    /* Category Cards Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .cat-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        overflow: hidden;
        box-shadow: var(--shadow-admin-sm);
        transition: box-shadow 0.2s, transform 0.2s;
        display: flex;
        flex-direction: column;
    }

    .cat-card:hover { box-shadow: var(--shadow-admin-md); transform: translateY(-2px); }

    .cat-card-header {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        background: linear-gradient(135deg, #f5f6f8 0%, #ebedf0 100%);
        position: relative;
    }

    .cat-card-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
    }

    .cat-card-status.active   { background: #e3fbeb; color: #008060; }
    .cat-card-status.inactive { background: #fbeae5; color: #ba3c1c; }

    .cat-card-body {
        padding: 16px;
        flex: 1;
    }

    .cat-card-name {
        font-family: var(--font-secondary);
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0 0 4px;
    }

    .cat-card-slug {
        font-family: var(--font-mono);
        font-size: 0.72rem;
        color: var(--color-admin-accent);
        background: rgba(1,136,73,0.07);
        padding: 1px 6px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .cat-card-meta {
        font-size: 0.78rem;
        color: var(--color-admin-text-muted);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cat-card-footer {
        padding: 12px 16px;
        border-top: 1px solid var(--color-admin-border-light);
        display: flex;
        gap: 8px;
    }

    .cat-product-count {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        background: #f1f2f4;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--color-admin-text-muted);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--color-admin-text-muted);
    }

    .empty-state svg { width: 52px; height: 52px; margin-bottom: 16px; opacity: 0.25; }
</style>
@endsection

@section('content')

{{-- ─── Stats ─── --}}
<div class="cat-stats-grid">
    <div class="cat-stat-card">
        <div class="cat-stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
            </svg>
        </div>
        <div>
            <div class="cat-stat-val">{{ $totalCategories }}</div>
            <div class="cat-stat-label">Total Categories</div>
        </div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div>
            <div class="cat-stat-val">{{ $activeCategories }}</div>
            <div class="cat-stat-label">Active</div>
        </div>
    </div>
    <div class="cat-stat-card">
        <div class="cat-stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
            </svg>
        </div>
        <div>
            <div class="cat-stat-val">{{ $totalProducts }}</div>
            <div class="cat-stat-label">Total Products</div>
        </div>
    </div>
</div>

{{-- ─── Add Category Button ─── --}}
<div class="admin-card">
    <div class="admin-card-title">
        <span>All Categories</span>
        <button class="btn-solid-accent" onclick="openModal('addCatModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Category
        </button>
    </div>

    @if($categories->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
            </svg>
            <p style="font-size:1rem; font-weight:600; margin:0 0 6px;">No categories yet</p>
            <p style="font-size:0.85rem; margin:0;">Click "Add Category" to create your first one.</p>
        </div>
    @else
        <div class="categories-grid">
            @foreach($categories as $cat)
            <div class="cat-card">
                <div class="cat-card-header">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#b4956d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                        <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                    <span class="cat-card-status {{ $cat->is_active ? 'active' : 'inactive' }}">
                        {{ $cat->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="cat-card-body">
                    <h3 class="cat-card-name">{{ $cat->name }}</h3>
                    <span class="cat-card-slug">/{{ $cat->slug }}</span>
                    <div class="cat-card-meta">
                        @if($cat->parent)
                            <span>Sub-category of <strong>{{ $cat->parent->name }}</strong></span>
                        @else
                            <span>Root Category</span>
                        @endif
                    </div>
                    @if($cat->description)
                        <p style="font-size:0.78rem; color:var(--color-admin-text-muted); margin:8px 0 0; line-height:1.5;">
                            {{ Str::limit($cat->description, 80) }}
                        </p>
                    @endif
                </div>
                <div class="cat-card-footer">
                    <span class="cat-product-count">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                        {{ $cat->products_count }} products
                    </span>
                    <div style="margin-left:auto; display:flex; gap:6px;">
                        <button class="btn-action-outline"
                            onclick="openEditModal({{ json_encode(['id'=>$cat->id,'name'=>$cat->name,'slug'=>$cat->slug,'description'=>$cat->description,'is_active'=>$cat->is_active,'parent_id'=>$cat->parent_id]) }})">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </button>
                        <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" style="margin:0;"
                            onsubmit="return confirm('Delete {{ addslashes($cat->name) }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-outline danger">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ─── Add Category Modal ─── --}}
<div class="admin-modal-overlay" id="addCatModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Add New Category</h3>
            <button class="admin-modal-close" onclick="closeModal('addCatModal')">&times;</button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="admin-modal-body">
                <div class="admin-form-group">
                    <label for="addCatName">Category Name *</label>
                    <input type="text" name="name" id="addCatName" class="admin-input" placeholder="e.g. Dry Fruits" required>
                </div>
                <div class="admin-form-group">
                    <label for="addCatDesc">Description</label>
                    <textarea name="description" id="addCatDesc" class="admin-textarea" placeholder="Brief description of this category…"></textarea>
                </div>
                <div class="admin-form-group">
                    <label for="addCatParent">Parent Category (optional)</label>
                    <select name="parent_id" id="addCatParent" class="admin-select">
                        <option value="">— Root Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="addCatImage">Image Path</label>
                    <input type="text" name="image" id="addCatImage" class="admin-input" placeholder="assets/img/category.png">
                </div>
                <div class="admin-form-group">
                    <label for="addCatStatus">Status *</label>
                    <select name="is_active" id="addCatStatus" class="admin-select" required>
                        <option value="1">Active (visible on store)</option>
                        <option value="0">Inactive (hidden)</option>
                    </select>
                </div>
                <button type="submit" class="btn-solid-accent" style="width:100%; padding:12px; justify-content:center; margin-top:8px;">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ─── Edit Category Modal ─── --}}
<div class="admin-modal-overlay" id="editCatModal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">Edit Category</h3>
            <button class="admin-modal-close" onclick="closeModal('editCatModal')">&times;</button>
        </div>
        <form id="editCatForm" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-modal-body">
                <div class="admin-form-group">
                    <label for="editCatName">Category Name *</label>
                    <input type="text" name="name" id="editCatName" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="editCatDesc">Description</label>
                    <textarea name="description" id="editCatDesc" class="admin-textarea"></textarea>
                </div>
                <div class="admin-form-group">
                    <label for="editCatParent">Parent Category</label>
                    <select name="parent_id" id="editCatParent" class="admin-select">
                        <option value="">— Root Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="editCatImage">Image Path</label>
                    <input type="text" name="image" id="editCatImage" class="admin-input">
                </div>
                <div class="admin-form-group">
                    <label for="editCatStatus">Status *</label>
                    <select name="is_active" id="editCatStatus" class="admin-select" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn-solid-accent" style="width:100%; padding:12px; justify-content:center; margin-top:8px;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openEditModal(cat) {
        const form = document.getElementById('editCatForm');
        form.action = `/admin/categories/${cat.id}`;
        document.getElementById('editCatName').value    = cat.name;
        document.getElementById('editCatDesc').value    = cat.description || '';
        document.getElementById('editCatParent').value  = cat.parent_id || '';
        document.getElementById('editCatImage').value   = '';
        document.getElementById('editCatStatus').value  = cat.is_active ? '1' : '0';
        openModal('editCatModal');
    }
</script>
@endsection
