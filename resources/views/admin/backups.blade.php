@extends('layouts.admin')

@section('title', 'Database Backups — Al Barr Admin')
@section('header_title', 'Database Backups')

@section('styles')
<style>
    /* ─── Page Hero ─── */
    .page-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: var(--spacing-xl);
    }

    .page-hero h2 {
        font-family: var(--font-secondary);
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--color-admin-text-main);
        margin: 0;
    }

    .page-hero p {
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        margin: 4px 0 0;
    }

    /* ─── Warning Banner ─── */
    .backup-warning-banner {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        background: linear-gradient(135deg, #fff8f0 0%, #fff4e6 100%);
        border: 1px solid #ffe0b2;
        border-left: 4px solid #ff9800;
        border-radius: var(--radius-admin-card);
        padding: 18px 22px;
        margin-bottom: var(--spacing-xl);
    }

    .backup-warning-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .backup-warning-title {
        font-weight: 800;
        color: #7a4500;
        font-size: 0.92rem;
        margin-bottom: 4px;
    }

    .backup-warning-text {
        font-size: 0.85rem;
        color: #a05a00;
        line-height: 1.5;
    }

    /* ─── Create Backup Hero Card ─── */
    .create-backup-card {
        background: linear-gradient(135deg, #0b192c 0%, #1a2f4a 100%);
        border-radius: var(--radius-admin-card);
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: var(--spacing-xl);
        box-shadow: var(--shadow-admin-md);
        position: relative;
        overflow: hidden;
    }

    .create-backup-card::before {
        content: '💾';
        position: absolute;
        right: 24px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 6rem;
        opacity: 0.06;
        pointer-events: none;
    }

    .create-backup-card-text h3 {
        font-family: var(--font-secondary);
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 6px;
    }

    .create-backup-card-text p {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.6);
        margin: 0;
    }

    .btn-create-backup {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-create-backup:hover {
        background: linear-gradient(135deg, #b4956d 0%, #a08260 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(197,168,128,0.4);
    }

    /* ─── Table ─── */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .admin-table thead th {
        background: var(--color-admin-border-light);
        padding: 12px 16px;
        text-align: left;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-admin-text-muted);
        border-bottom: 1px solid var(--color-admin-border);
        white-space: nowrap;
    }

    .admin-table tbody tr {
        border-bottom: 1px solid var(--color-admin-border);
        transition: background 0.15s;
    }

    .admin-table tbody tr:hover { background: #fafbfc; }

    .admin-table tbody td {
        padding: 16px 16px;
        vertical-align: middle;
    }

    /* ─── Filename Cell ─── */
    .backup-filename {
        font-family: var(--font-mono);
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .backup-filename-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        border-radius: 8px;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* ─── File Size Badge ─── */
    .size-badge {
        display: inline-flex;
        align-items: center;
        background: var(--color-admin-border-light);
        border: 1px solid var(--color-admin-border);
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--color-admin-text-main);
    }

    /* ─── Action Buttons ─── */
    .backup-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--color-admin-text-main);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-download:hover {
        background: #3a3b3d;
        transform: translateY(-1px);
    }

    .btn-restore {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--color-admin-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
        white-space: nowrap;
    }

    .btn-restore:hover {
        background: var(--color-admin-accent-hover);
        transform: translateY(-1px);
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: #fff;
        color: #842029;
        border: 1px solid #f8d7da;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-sans);
        white-space: nowrap;
    }

    .btn-delete:hover {
        background: #f8d7da;
        border-color: #dc3545;
        transform: translateY(-1px);
    }

    /* ─── Empty State ─── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        text-align: center;
        color: var(--color-admin-text-muted);
    }

    .empty-state-icon { font-size: 3.5rem; margin-bottom: 14px; opacity: 0.4; }
    .empty-state h3   { font-family: var(--font-secondary); font-size: 1.15rem; font-weight: 700; color: var(--color-admin-text-main); margin: 0 0 6px; }
    .empty-state p    { font-size: 0.87rem; margin: 0; }

    /* ─── Latest Backup Highlight ─── */
    .latest-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        background: #d1e7dd;
        color: #0a5c36;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-left: 8px;
    }
</style>
@endsection

@section('content')
{{-- Page Hero --}}
<div class="page-hero">
    <div>
        <h2>Database Backups</h2>
        <p>{{ count($backups) }} backup{{ count($backups) !== 1 ? 's' : '' }} available · Snapshot and restore your entire database</p>
    </div>
</div>

{{-- Warning Banner --}}
<div class="backup-warning-banner">
    <div class="backup-warning-icon">⚠️</div>
    <div>
        <div class="backup-warning-title">Important: Read Before Restoring</div>
        <div class="backup-warning-text">
            Backups compile all products, orders, variants, users, coupons, tickets, returns, and configuration into a portable SQL dump.
            <strong>Restoring will immediately overwrite all current data.</strong> Download a local copy before performing any restore operation.
            Scheduled backups are recommended at least once per week for production data safety.
        </div>
    </div>
</div>

{{-- Create Backup CTA --}}
<div class="create-backup-card">
    <div class="create-backup-card-text">
        <h3>Create New Database Snapshot</h3>
        <p>Compiles all tables, schema structures, values, and settings into a timestamped SQL dump file stored on the server.</p>
    </div>
    <form action="{{ route('admin.backups.create') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="btn-create-backup">
            ⚡ Trigger New Backup
        </button>
    </form>
</div>

{{-- Backups Table --}}
<div class="admin-card" style="padding: 0;">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="padding-left: 24px; width: 45%;">Backup File</th>
                    <th>Size</th>
                    <th>Created At</th>
                    <th style="text-align: right; padding-right: 24px; min-width: 240px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $index => $backup)
                    @php
                        $sizeKb   = $backup['size'] / 1024;
                        $sizeText = $sizeKb > 1024
                            ? number_format($sizeKb / 1024, 2) . ' MB'
                            : number_format($sizeKb, 2) . ' KB';
                    @endphp
                    <tr>
                        <td style="padding-left: 24px; position: relative;">
                            {{-- Vertical timeline line --}}
                            <div style="position: absolute; left: 16px; top: 0; bottom: 0; width: 2px; background: var(--color-admin-border); opacity: 0.7;"></div>
                            {{-- Timeline node dot --}}
                            <div style="position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 12px; height: 12px; border-radius: 50%; background: {{ $index === 0 ? 'var(--color-admin-accent)' : 'var(--color-admin-text-muted)' }}; border: 2px solid #fff; z-index: 2; box-shadow: {{ $index === 0 ? '0 0 0 3px rgba(1, 136, 73, 0.15)' : 'none' }};"></div>
                            
                            <div class="backup-filename" style="padding-left: 12px;">
                                <span class="backup-filename-icon">💾</span>
                                <div>
                                    <div style="font-weight: 700; color:var(--color-admin-text-main);">{{ $backup['filename'] }}</div>
                                    @if($index === 0)
                                        <span class="latest-badge" style="background:#e3fbeb; color:#018849; font-size:0.65rem; padding: 1px 6px; border-radius: 4px; font-weight: 700; text-transform: uppercase;">Latest</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="size-badge">{{ $sizeText }}</span>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; font-weight: 600; color: var(--color-admin-text-main);">
                                {{ date('d M Y, h:i A', strtotime($backup['created_at'])) }}
                            </div>
                            <div style="font-size: 0.74rem; color: var(--color-admin-text-muted); margin-top: 2px; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($backup['created_at'])->diffForHumans() }}
                            </div>
                        </td>
                        <td style="padding-right: 24px;">
                            <div class="backup-actions">
                                {{-- Download --}}
                                <a href="{{ route('admin.backups.download', $backup['filename']) }}" class="btn-download">
                                    ⬇️ Download
                                </a>

                                {{-- Restore Trigger --}}
                                <button type="button" class="btn-restore" onclick="triggerRestore('{{ $backup['filename'] }}')">
                                    🔄 Restore
                                </button>

                                {{-- Delete --}}
                                <form action="{{ route('admin.backups.delete', $backup['filename']) }}" method="POST"
                                      onsubmit="return confirm('Permanently delete this backup file? This cannot be undone.')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">🗑️ Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon">💾</div>
                                <h3>No Backups Yet</h3>
                                <p>Click "Trigger New Backup" above to create your first database snapshot.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── Safety Restore Confirmation Modal ─── --}}
<div class="admin-modal-overlay" id="confirmRestoreModal" style="z-index: 9999;">
    <div class="admin-modal-card" style="max-width: 460px; border-top: 5px solid #ba3c1c;">
        <div class="admin-modal-header" style="background:#fff; color:var(--color-admin-text-main); border-bottom:1px solid var(--color-admin-border); padding: 16px 20px;">
            <h3 class="admin-modal-title" style="color:#ba3c1c; font-family:var(--font-secondary); font-weight:800;">⚠️ Critical Action</h3>
            <button class="admin-modal-close" onclick="closeModal('confirmRestoreModal')" style="color:var(--color-admin-text-muted);">&times;</button>
        </div>
        <form action="{{ route('admin.backups.restore') }}" method="POST" id="restoreConfirmForm">
            @csrf
            <input type="hidden" name="filename" id="restoreFilenameInput">
            <div class="admin-modal-body" style="padding: 20px;">
                <p style="font-size: 0.88rem; color: var(--color-admin-text-main); line-height: 1.5; margin: 0 0 16px;">
                    You are about to restore the database snapshot: <strong id="restoreFilenameDisplay" style="font-family: var(--font-mono); color: #ba3c1c; word-break: break-all;"></strong>.
                </p>
                <div style="background: #fdf2f0; border: 1px solid #f9d0c4; padding: 12px 14px; border-radius: 8px; font-size: 0.82rem; color: #ba3c1c; line-height: 1.45; margin-bottom: 20px;">
                    <strong>Warning:</strong> This will completely overwrite all current database tables, orders, products, and configurations. <strong>This action cannot be undone.</strong>
                </div>
                <div class="admin-form-group">
                    <label for="restoreConfirmCode" style="font-weight:700; font-size:0.75rem; text-transform:uppercase; color:var(--color-admin-text-muted);">Type <strong style="color:#ba3c1c;">RESTORE</strong> to confirm:</label>
                    <input type="text" id="restoreConfirmCode" class="admin-input" placeholder="Type RESTORE here" required oninput="validateRestoreCode(this)" style="margin-top:6px;">
                </div>
                <button type="submit" class="btn-danger" id="restoreConfirmBtn" style="width: 100%; justify-content: center; padding: 12px; margin-top: 16px; border-radius:10px; display:inline-flex; align-items:center; gap:8px;" disabled>
                    🔥 Overwrite Database &amp; Restore
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function triggerRestore(filename) {
        document.getElementById('restoreFilenameInput').value = filename;
        document.getElementById('restoreFilenameDisplay').innerText = filename;
        document.getElementById('restoreConfirmCode').value = '';
        document.getElementById('restoreConfirmBtn').disabled = true;
        openModal('confirmRestoreModal');
    }

    function validateRestoreCode(input) {
        const btn = document.getElementById('restoreConfirmBtn');
        btn.disabled = (input.value.trim() !== 'RESTORE');
    }
</script>
@endsection
