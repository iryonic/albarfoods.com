@extends('layouts.admin')

@section('title', 'Media Library - Al Barr')
@section('header_title', 'Media Library')

@section('styles')
<style>
    /* ─── Page Headers & Stats ─── */
    .media-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    @media (max-width: 768px) {
        .media-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .media-stat-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-admin-sm);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .media-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-admin-md);
    }

    .media-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .media-stat-icon.green  { background: #e3fbeb; color: #018849; }
    .media-stat-icon.blue   { background: #e4f0ff; color: #1a56d6; }
    .media-stat-icon.gold   { background: #fbf3e5; color: #b4956d; }

    .media-stat-icon svg {
        width: 22px;
        height: 22px;
        stroke-width: 2;
    }

    .media-stat-val {
        font-family: var(--font-secondary);
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        line-height: 1.1;
    }

    .media-stat-label {
        font-size: 0.75rem;
        color: var(--color-admin-text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    /* ─── Drag & Drop Upload Zone ─── */
    .upload-zone {
        border: 2px dashed #c5a880;
        background: linear-gradient(135deg, rgba(247, 243, 237, 0.4) 0%, rgba(255, 255, 255, 0.8) 100%);
        border-radius: var(--radius-admin-card);
        padding: 40px 20px;
        text-align: center;
        margin-bottom: 28px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .upload-zone:hover, .upload-zone.dragover {
        border-color: var(--color-admin-accent);
        background: linear-gradient(135deg, rgba(227, 251, 235, 0.4) 0%, rgba(255, 255, 255, 0.9) 100%);
        box-shadow: var(--shadow-admin-md);
    }

    .upload-zone-icon {
        width: 64px;
        height: 64px;
        background: #fdfaf5;
        border: 1px solid rgba(197, 168, 128, 0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        color: #c5a880;
        transition: all 0.25s ease;
    }

    .upload-zone:hover .upload-zone-icon, .upload-zone.dragover .upload-zone-icon {
        background: #e3fbeb;
        color: var(--color-admin-accent);
        transform: scale(1.1);
    }

    .upload-zone-icon svg {
        width: 32px;
        height: 32px;
    }

    .upload-zone-title {
        font-family: var(--font-secondary);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        margin: 0 0 6px;
    }

    .upload-zone-desc {
        font-size: 0.82rem;
        color: var(--color-admin-text-muted);
        margin: 0;
    }

    /* ─── Media Library Grid ─── */
    .media-grid-container {
        margin-top: 20px;
    }

    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .media-card {
        background: #fff;
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        overflow: hidden;
        box-shadow: var(--shadow-admin-sm);
        transition: all 0.22s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .media-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-admin-md);
    }

    .media-thumb-wrapper {
        position: relative;
        padding-top: 85%; /* Aspect ratio aspect 4:3ish */
        background-color: #fafbfc;
        border-bottom: 1px solid var(--color-admin-border-light);
        overflow: hidden;
        cursor: pointer;
    }

    .media-thumb {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .media-card:hover .media-thumb {
        transform: scale(1.05);
    }

    /* Hover overlay */
    .media-hover-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: opacity 0.2s ease;
        backdrop-filter: blur(2px);
    }

    .media-card:hover .media-hover-overlay {
        opacity: 1;
    }

    .media-details {
        padding: 12px 14px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .media-filename {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        word-break: break-all;
        margin: 0 0 6px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .media-meta-row {
        font-size: 0.72rem;
        color: var(--color-admin-text-muted);
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .media-actions {
        display: flex;
        gap: 6px;
        margin-top: auto;
    }

    .media-btn {
        flex: 1;
        padding: 6px 8px;
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .media-btn-copy {
        background-color: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        color: var(--color-admin-text-main);
    }

    .media-btn-copy:hover {
        background-color: #fff;
        border-color: var(--color-admin-accent);
        color: var(--color-admin-accent);
    }

    .media-btn-delete {
        background-color: #fbeae5;
        border: 1px solid #f9d0c4;
        color: #ba3c1c;
    }

    .media-btn-delete:hover {
        background-color: #ba3c1c;
        border-color: #ba3c1c;
        color: #fff;
    }

    /* ─── Uploading Progress Modal ─── */
    .progress-bar-container {
        height: 6px;
        width: 100%;
        background-color: var(--color-admin-border-light);
        border-radius: 3px;
        overflow: hidden;
        margin-top: 12px;
        display: none;
    }

    .progress-bar {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--color-admin-accent) 0%, var(--color-admin-gold) 100%);
        transition: width 0.2s ease;
    }

    /* ─── Standalone Details Modal ─── */
    .media-details-modal-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 20px;
    }
    @media (max-width: 640px) {
        .media-details-modal-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

{{-- ─── Media Library Statistics ─── --}}
<div class="media-stats-grid">
    <div class="media-stat-card">
        <div class="media-stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <div>
            <div class="media-stat-val">{{ $media->total() }}</div>
            <div class="media-stat-label">Total Files</div>
        </div>
    </div>
    <div class="media-stat-card">
        <div class="media-stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <div>
            <div class="media-stat-val">
                @php
                    $totalSize = \App\Models\MediaLibrary::sum('file_size');
                    if ($totalSize >= 1073741824) {
                        echo number_format($totalSize / 1073741824, 2) . ' GB';
                    } elseif ($totalSize >= 1048576) {
                        echo number_format($totalSize / 1048576, 2) . ' MB';
                    } else {
                        echo number_format($totalSize / 1024, 2) . ' KB';
                    }
                @endphp
            </div>
            <div class="media-stat-label">Disk Storage Used</div>
        </div>
    </div>
    <div class="media-stat-card">
        <div class="media-stat-icon gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
            <div class="media-stat-val">
                @php
                    $latest = \App\Models\MediaLibrary::orderBy('created_at', 'desc')->first();
                    echo $latest ? $latest->created_at->diffForHumans(null, true) : 'Never';
                @endphp
            </div>
            <div class="media-stat-label">Last Uploaded</div>
        </div>
    </div>
</div>

{{-- ─── Drag & Drop Upload Zone ─── --}}
<div class="admin-card" style="padding: 20px;">
    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
        <input type="file" id="fileInput" name="file" accept="image/*" style="display:none;" multiple>
        <div class="upload-zone-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <h4 class="upload-zone-title">Drag & drop files here, or click to browse</h4>
        <p class="upload-zone-desc">Supports JPEG, PNG, JPG, GIF, WEBP and SVG (Max 10MB per file)</p>
        
        <div class="progress-bar-container" id="progressBarContainer">
            <div class="progress-bar" id="progressBar"></div>
        </div>
    </div>
</div>

{{-- ─── Media Library Assets Grid ─── --}}
<div class="admin-card">
    <div class="admin-card-title" style="margin-bottom: 16px;">
        <span>Media Gallery</span>
    </div>

    {{-- Filter bar --}}
    <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--color-admin-border-light);">
        <input type="text" id="gallerySearch" class="admin-input" placeholder="Search files..." style="max-width:320px; flex:1;" oninput="filterGallery()">
        
        <select id="typeFilter" class="admin-select" style="max-width:180px;" onchange="filterGallery()">
            <option value="all">All File Formats</option>
            <option value="png">PNG Images</option>
            <option value="jpg">JPG/JPEG Images</option>
            <option value="webp">WEBP Images</option>
            <option value="svg">SVG Graphics</option>
            <option value="gif">GIF Animations</option>
        </select>

        <select id="tagFilter" class="admin-select" style="max-width:180px;" onchange="filterGallery()">
            <option value="all">All Folders/Tags</option>
            <option value="product">Products</option>
            <option value="category">Categories</option>
            <option value="branding">Branding &amp; Banners</option>
            <option value="unassigned">Unassigned</option>
        </select>
    </div>

    @if($media->isEmpty())
        <div style="text-align: center; color: var(--color-admin-text-muted); padding: 50px 20px;" id="emptyMediaState">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3; margin-bottom:12px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <p style="font-weight:700; margin:0 0 4px;">No files uploaded yet</p>
            <p style="font-size:0.8rem; margin:0;">Upload your first product or category image above!</p>
        </div>
    @endif

    {{-- Filtered empty state --}}
    <div style="display: none; text-align: center; color: var(--color-admin-text-muted); padding: 50px 20px;" id="emptyFilterState">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3; margin-bottom:12px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <p style="font-weight:700; margin:0 0 4px;">No files match your search criteria</p>
        <p style="font-size:0.8rem; margin:0;">Try resetting your filters or search keywords.</p>
    </div>

    <div class="media-grid-container">
        <div class="media-grid" id="mediaGrid">
            @foreach($media as $item)
                @php
                    $tag = 'Unassigned';
                    $lowerName = strtolower($item->file_name);
                    if (strpos($lowerName, 'product') !== false || strpos($lowerName, 'item') !== false || strpos($lowerName, 'seed') !== false || strpos($lowerName, 'almond') !== false || strpos($lowerName, 'honey') !== false) {
                        $tag = 'Product';
                    } elseif (strpos($lowerName, 'category') !== false || strpos($lowerName, 'cat_') !== false) {
                        $tag = 'Category';
                    } elseif (strpos($lowerName, 'logo') !== false || strpos($lowerName, 'banner') !== false || strpos($lowerName, 'hero') !== false) {
                        $tag = 'Branding';
                    }
                    
                    $tagStyle = match($tag) {
                        'Product' => 'background:#e4f0ff; color:#1a56d6;',
                        'Category' => 'background:#e3fbeb; color:#018849;',
                        'Branding' => 'background:#fff8e1; color:#b56f00;',
                        default => 'background:#f1f2f4; color:#6d7175;'
                    };
                @endphp
                <div class="media-card" id="mediaCard-{{ $item->id }}" data-tag="{{ strtolower($tag) }}">
                    {{-- Selection Checkbox --}}
                    <div style="position:absolute; top:10px; left:10px; z-index:10; background:#fff; border-radius:6px; padding:3px; box-shadow:var(--shadow-admin-sm); border: 1px solid var(--color-admin-border); display:flex; align-items:center; justify-content:center;">
                        <input type="checkbox" class="media-select-checkbox" data-id="{{ $item->id }}" onchange="updateMediaSelection()" style="width:16px; height:16px; cursor:pointer; accent-color:var(--color-admin-accent); display:block; margin:0;">
                    </div>
                    
                    <div class="media-thumb-wrapper">
                        <img src="/{{ $item->file_path }}" alt="{{ $item->file_name }}" class="media-thumb" onerror="this.src='/assets/img/logoalbar.png'">
                        <div class="media-hover-overlay">
                            <button type="button" class="btn-solid-gold" style="padding:6px 12px; font-size:0.75rem; border-radius:6px; box-shadow:none; filter:none;" onclick="copyPath('{{ $item->file_path }}', this)"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>Copy Path</button>
                            <button type="button" class="btn-solid-accent" style="padding:6px 12px; font-size:0.75rem; border-radius:6px; box-shadow:none;" onclick="showMediaDetails({{ json_encode($item) }})"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>Details</button>
                        </div>
                    </div>
                    
                    <div class="media-details">
                        <div style="margin-bottom: 6px;">
                            <span style="font-size:0.64rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; padding:2px 8px; border-radius:4px; display:inline-block; margin-bottom:4px; {{ $tagStyle }}">
                                {{ $tag }}
                            </span>
                            <h5 class="media-filename" title="{{ $item->file_name }}">{{ $item->file_name }}</h5>
                        </div>
                        <div class="media-meta-row">
                            <span>
                                @if($item->file_size >= 1048576)
                                    {{ number_format($item->file_size / 1048576, 2) . ' MB' }}
                                @else
                                    {{ number_format($item->file_size / 1024, 0) . ' KB' }}
                                @endif
                            </span>
                            <span>{{ strtoupper(explode('/', $item->file_type)[1] ?? 'IMG') }}</span>
                        </div>
                        <div class="media-actions">
                            <button class="media-btn media-btn-copy" onclick="copyPath('{{ $item->file_path }}', this)">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>Copy Path
                            </button>
                            <form action="{{ route('admin.media.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this media file?');" style="margin: 0; flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="media-btn media-btn-delete">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 30px;">
            {{ $media->links() }}
        </div>
    </div>
</div>

{{-- ─── Media Details Modal ─── --}}
<div class="admin-modal-overlay" id="mediaDetailsModal">
    <div class="admin-modal-card" style="max-width: 700px;">
        <div class="admin-modal-header">
            <h3 class="admin-modal-title">File Details</h3>
            <button class="admin-modal-close" onclick="closeModal('mediaDetailsModal')">&times;</button>
        </div>
        <div class="admin-modal-body">
            <div class="media-details-modal-grid">
                <div style="background-color:#fafbfc; border: 1px solid var(--color-admin-border); border-radius:8px; display:flex; align-items:center; justify-content:center; padding:10px; overflow:hidden;">
                    <img id="detailPreview" src="" alt="Preview" style="max-width:100%; max-height:280px; object-fit:contain; border-radius:4px;">
                </div>
                <div>
                    <h4 id="detailFilename" style="margin-top:0; font-family:var(--font-secondary); word-break:break-all; font-size:1.1rem; color:var(--color-admin-text-main);">File Name</h4>
                    <hr style="border:0; border-top: 1px solid var(--color-admin-border-light); margin:15px 0;">
                    
                    <div style="display:flex; flex-direction:column; gap:10px; font-size:0.85rem;">
                        <div>
                            <strong style="color:var(--color-admin-text-muted);">Relative Path:</strong>
                            <div style="font-family:var(--font-mono); font-size:0.75rem; background:#f4f5f7; padding:8px; border-radius:4px; margin-top:4px; word-break:break-all; display:flex; justify-content:between; align-items:center;">
                                <span id="detailPath">uploads/media/file.jpg</span>
                            </div>
                        </div>
                        <div>
                            <strong style="color:var(--color-admin-text-muted);">File Type:</strong>
                            <span id="detailType" style="margin-left:8px; font-weight:600;">image/jpeg</span>
                        </div>
                        <div>
                            <strong style="color:var(--color-admin-text-muted);">File Size:</strong>
                            <span id="detailSize" style="margin-left:8px; font-weight:600;">125 KB</span>
                        </div>
                        <div>
                            <strong style="color:var(--color-admin-text-muted);">Uploaded At:</strong>
                            <span id="detailUploaded" style="margin-left:8px; font-weight:600;">2026-06-18 10:00:00</span>
                        </div>
                    </div>

                    <button class="btn-solid-accent" id="detailCopyBtn" style="width:100%; margin-top:20px; justify-content:center;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>Copy Path to Clipboard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Drag & Drop event bindings
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const progressBarContainer = document.getElementById('progressBarContainer');
    const progressBar = document.getElementById('progressBar');

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
        }, false);
    });

    uploadZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }, false);

    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if (files.length === 0) return;
        
        progressBarContainer.style.display = 'block';
        progressBar.style.width = '0%';
        
        let filesUploaded = 0;
        const totalFiles = files.length;
        
        Array.from(files).forEach((file, index) => {
            const formData = new FormData();
            formData.append('file', file);
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("admin.media.store") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('Accept', 'application/json');
            
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    // Average out the progress
                    const totalPercent = Math.round(((filesUploaded * 100) + percentComplete) / totalFiles);
                    progressBar.style.width = totalPercent + '%';
                }
            });
            
            xhr.onload = function() {
                filesUploaded++;
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        appendMediaCard(response.media);
                    }
                }
                
                if (filesUploaded === totalFiles) {
                    progressBar.style.width = '100%';
                    setTimeout(() => {
                        progressBarContainer.style.display = 'none';
                        // Flash message or reload
                        window.location.reload();
                    }, 500);
                }
            };
            
            xhr.send(formData);
        });
    }

    function appendMediaCard(media) {
        // Remove empty state if visible
        const emptyState = document.getElementById('emptyMediaState');
        if (emptyState) emptyState.remove();

        const grid = document.getElementById('mediaGrid');
        const sizeInKB = media.file_size >= 1048576 ? 
            (media.file_size / 1048576).toFixed(2) + ' MB' : 
            (media.file_size / 1024).toFixed(0) + ' KB';
        
        const type = media.file_type.split('/')[1]?.toUpperCase() || 'IMG';

        const card = document.createElement('div');
        card.className = 'media-card';
        card.id = `mediaCard-${media.id}`;
        card.innerHTML = `
            <div class="media-thumb-wrapper" onclick='showMediaDetails(${JSON.stringify(media)})'>
                <img src="/${media.file_path}" alt="${media.file_name}" class="media-thumb" onerror="this.src='/assets/img/logoalbar.png'">
            </div>
            <div class="media-details">
                <h5 class="media-filename" title="${media.file_name}">${media.file_name}</h5>
                <div class="media-meta-row">
                    <span>${sizeInKB}</span>
                    <span>${type}</span>
                </div>
                <div class="media-actions">
                    <button class="media-btn media-btn-copy" onclick="copyPath('${media.file_path}', this)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>Copy Path
                    </button>
                    <form action="/admin/media/${media.id}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this media file?');" style="margin: 0; flex: 1;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="media-btn media-btn-delete">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>Delete
                        </button>
                    </form>
                </div>
            </div>
        `;
        // Insert at the beginning of grid
        grid.insertBefore(card, grid.firstChild);
    }

    // Helper functions for clipboard copy
    function copyPath(path, btn) {
        navigator.clipboard.writeText(path).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><polyline points="20 6 9 17 4 12"></polyline></svg>Copied!';
            
            // Apply feedback styling if it's an action button
            if (btn.classList.contains('media-btn-copy')) {
                btn.style.borderColor = 'var(--color-admin-accent)';
                btn.style.color = 'var(--color-admin-accent)';
            }
            
            // Fire global toast notification if available
            if (typeof showToast === 'function') {
                showToast(`Path "${path}" copied!`, 'success');
            }
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.borderColor = '';
                btn.style.color = '';
            }, 1500);
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }

    // Modal detailed preview trigger
    function showMediaDetails(media) {
        document.getElementById('detailPreview').src = '/' + media.file_path;
        document.getElementById('detailFilename').innerText = media.file_name;
        document.getElementById('detailPath').innerText = media.file_path;
        document.getElementById('detailType').innerText = media.file_type;
        
        const sizeInKB = media.file_size >= 1048576 ? 
            (media.file_size / 1048576).toFixed(2) + ' MB' : 
            (media.file_size / 1024).toFixed(1) + ' KB';
        document.getElementById('detailSize').innerText = sizeInKB;
        
        const dateObj = new Date(media.created_at);
        document.getElementById('detailUploaded').innerText = dateObj.toLocaleString();

        const copyBtn = document.getElementById('detailCopyBtn');
        copyBtn.onclick = function() {
            copyPath(media.file_path, copyBtn);
        };

        openModal('mediaDetailsModal');
    }

    // Filter gallery items by search query, extension, and tag
    function filterGallery() {
        const query = document.getElementById('gallerySearch').value.toLowerCase().trim();
        const type = document.getElementById('typeFilter').value;
        const selectedTag = document.getElementById('tagFilter').value;
        
        const cards = document.querySelectorAll('.media-grid .media-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const name = card.querySelector('.media-filename').innerText.toLowerCase();
            const ext = name.split('.').pop();
            const tag = card.getAttribute('data-tag').toLowerCase();
            
            const matchSearch = !query || name.includes(query);
            const matchType = type === 'all' || (type === 'jpg' && (ext === 'jpg' || ext === 'jpeg')) || ext === type;
            const matchTag = selectedTag === 'all' || tag === selectedTag;
            
            if (matchSearch && matchType && matchTag) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        const emptyState = document.getElementById('emptyMediaState');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        const emptyFilter = document.getElementById('emptyFilterState');
        if (emptyFilter) {
            emptyFilter.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    // Media Bulk Selection logic
    function updateMediaSelection() {
        const checked = document.querySelectorAll('.media-select-checkbox:checked');
        const count = checked.length;
        const bar = document.getElementById('mediaBulkBar');
        const text = document.getElementById('mediaSelectionCountText');
        
        if (count > 0) {
            if (!bar) {
                // Create bar dynamically if it doesn't exist
                const newBar = document.createElement('div');
                newBar.id = 'mediaBulkBar';
                newBar.style.position = 'fixed';
                newBar.style.bottom = '24px';
                newBar.style.left = '50%';
                newBar.style.transform = 'translateX(-50%)';
                newBar.style.background = 'var(--color-admin-sidebar)';
                newBar.style.color = '#fff';
                newBar.style.padding = '12px 24px';
                newBar.style.borderRadius = '12px';
                newBar.style.boxShadow = 'var(--shadow-admin-lg)';
                newBar.style.zIndex = '1000';
                newBar.style.display = 'flex';
                newBar.style.alignItems = 'center';
                newBar.style.gap = '16px';
                newBar.style.border = '1px solid rgba(197, 168, 128, 0.3)';
                newBar.style.animation = 'slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
                
                newBar.innerHTML = `
                    <span style="font-weight: 700; font-size: 0.9rem;" id="mediaSelectionCountText">${count} files selected</span>
                    <button class="btn-solid-gold" style="padding: 8px 16px; font-size: 0.8rem; background:#ba3c1c; border-color:#ba3c1c; box-shadow:none;" onclick="bulkDeleteMedia()">
                        🗑️ Delete Selected
                    </button>
                    <button class="btn-action-outline" style="padding: 8px 16px; font-size: 0.8rem; color: #fff; border-color: rgba(255,255,255,0.2);" onclick="clearMediaSelection()">
                        Cancel
                    </button>
                `;
                document.body.appendChild(newBar);
                
                // Add keyframe style
                const style = document.createElement('style');
                style.innerText = `
                    @keyframes slideUp {
                        from { transform: translate(-50%, 20px); opacity: 0; }
                        to { transform: translate(-50%, 0); opacity: 1; }
                    }
                `;
                document.head.appendChild(style);
            } else {
                bar.style.display = 'flex';
                text.innerText = `${count} files selected`;
            }
        } else {
            if (bar) bar.style.display = 'none';
        }
    }

    function clearMediaSelection() {
        document.querySelectorAll('.media-select-checkbox').forEach(cb => cb.checked = false);
        updateMediaSelection();
    }

    function bulkDeleteMedia() {
        const checked = document.querySelectorAll('.media-select-checkbox:checked');
        if (checked.length === 0) return;
        
        if (!confirm(`Are you sure you want to permanently delete these ${checked.length} selected files?`)) {
            return;
        }
        
        const ids = Array.from(checked).map(cb => parseInt(cb.dataset.id));
        
        fetch('{{ route("admin.media.bulk-delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'success');
                } else {
                    alert(data.message);
                }
                ids.forEach(id => {
                    const card = document.getElementById(`mediaCard-${id}`);
                    if (card) card.remove();
                });
                clearMediaSelection();
                
                if (document.querySelectorAll('.media-grid .media-card').length === 0) {
                    window.location.reload();
                }
            } else {
                alert('Bulk delete failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('An error occurred during bulk deletion.');
            console.error(err);
        });
    }
</script>
@endsection
