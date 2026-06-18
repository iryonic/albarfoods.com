<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Al Barr')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/variables.css?v={{ time() }}">
    <link rel="stylesheet" href="/assets/css/main.css?v={{ time() }}">
    <link rel="stylesheet" href="/assets/css/components.css?v={{ time() }}">

    <style>
        :root {
            --admin-sidebar-width: 268px;
            --admin-header-height: 70px;
            
            --color-admin-bg: #f5f6f8;
            --color-admin-card-bg: #ffffff;
            --color-admin-sidebar: #0b192c;
            --color-admin-sidebar-hover: rgba(255,255,255,0.05);
            --color-admin-text-main: #202223;
            --color-admin-text-muted: #6d7175;
            --color-admin-accent: #018849;
            --color-admin-accent-hover: #016a39;
            --color-admin-gold: #c5a880;
            --color-admin-gold-hover: #b4956d;
            --color-admin-border: #e1e3e5;
            --color-admin-border-light: #f1f2f4;
            
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --font-secondary: 'Outfit', sans-serif;
            --font-mono: 'Fira Code', monospace;
            
            --radius-admin-card: 12px;
            --radius-admin-input: 8px;
            --radius-admin-badge: 6px;
            
            --shadow-admin-sm: 0px 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-admin-md: 0px 4px 16px rgba(11, 25, 44, 0.05);
            --shadow-admin-lg: 0px 12px 36px rgba(11, 25, 44, 0.08);
        }

        body {
            background-color: var(--color-admin-bg);
            color: var(--color-admin-text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ─── Sidebar ─── */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background-color: var(--color-admin-sidebar);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(11, 25, 44, 0.18);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
        }

        .admin-brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .admin-brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #018849 0%, #014e28 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(1,136,73,0.35);
        }

        .admin-brand-icon svg {
            width: 20px;
            height: 20px;
            color: #fff;
        }

        .admin-brand-text {}

        .admin-brand-name {
            font-family: var(--font-secondary);
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.2px;
            background: linear-gradient(135deg, #e5c090 0%, #c5a880 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            line-height: 1.2;
        }

        .admin-brand-sub {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* ─── Scrollable Nav ─── */
        .admin-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 0 20px;
        }

        .admin-nav::-webkit-scrollbar { width: 4px; }
        .admin-nav::-webkit-scrollbar-track { background: transparent; }
        .admin-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        /* ─── Section Labels ─── */
        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.28);
            padding: 16px 20px 6px;
            display: block;
        }

        .nav-section-label:first-child { padding-top: 6px; }

        /* ─── Nav Items ─── */
        .admin-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-menu-item {
            margin: 1px 10px;
        }

        .admin-menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .admin-menu-item a:hover {
            background-color: var(--color-admin-sidebar-hover);
            color: rgba(255,255,255,0.95);
        }

        .admin-menu-item.active a {
            background: linear-gradient(135deg, rgba(197,168,128,0.16) 0%, rgba(197,168,128,0.06) 100%);
            color: #f7dfbe;
            font-weight: 700;
            box-shadow: inset 3px 0 0 #c5a880;
        }

        .sidebar-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0.9;
        }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.05);
            margin: 10px 16px;
        }

        /* ─── Sidebar Footer ─── */
        .admin-sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.3);
            text-align: center;
            font-weight: 500;
            flex-shrink: 0;
        }

        /* ─── Main Area ─── */
        .admin-main {
            flex-grow: 1;
            margin-left: var(--admin-sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ─── Top Header ─── */
        .admin-header {
            height: var(--admin-header-height);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--color-admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: var(--shadow-admin-sm);
        }

        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-toggle-sidebar {
            background: none;
            border: none;
            color: var(--color-admin-text-main);
            cursor: pointer;
            display: none;
            padding: 6px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .admin-toggle-sidebar:hover { background-color: var(--color-admin-border-light); }
        .admin-toggle-sidebar svg { width: 22px; height: 22px; display: block; }

        .admin-header-title {
            font-family: var(--font-secondary);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--color-admin-text-main);
            margin: 0;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-profile-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            padding: 6px 14px 6px 6px;
            border-radius: 30px;
            border: 1px solid var(--color-admin-border);
            box-shadow: var(--shadow-admin-sm);
            cursor: pointer;
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-admin-accent) 0%, var(--color-admin-sidebar) 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.8rem;
            border: 2px solid var(--color-admin-gold);
            flex-shrink: 0;
        }

        /* ─── Content Area ─── */
        .admin-content {
            padding: 28px;
            flex-grow: 1;
            max-width: 1400px;
            width: 100%;
            box-sizing: border-box;
            margin: 0 auto;
        }

        /* ─── Cards ─── */
        .admin-card {
            background-color: var(--color-admin-card-bg);
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-card);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-admin-sm);
            margin-bottom: var(--spacing-xl);
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.25s ease;
        }

        .admin-card:hover { box-shadow: var(--shadow-admin-md); }

        .admin-card-title {
            font-family: var(--font-secondary);
            font-size: 1.2rem;
            color: var(--color-admin-text-main);
            margin-top: 0;
            margin-bottom: var(--spacing-lg);
            font-weight: 800;
            letter-spacing: -0.2px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ─── Alert Boxes ─── */
        .alert-box {
            padding: 13px 18px;
            border-radius: var(--radius-admin-input);
            margin-bottom: var(--spacing-lg);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInDown {
            0% { transform: translateY(-10px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .alert-box.success { background-color: #e3fbeb; border: 1px solid #aee9c5; color: #008060; }
        .alert-box.error { background-color: #fbeae5; border: 1px solid #f9d0c4; color: #ba3c1c; }

        /* ─── Form Elements ─── */
        .admin-input, .admin-select {
            font-family: var(--font-sans);
            padding: 10px 14px;
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-input);
            font-size: 0.9rem;
            width: 100%;
            background-color: #fff;
            color: var(--color-admin-text-main);
            box-sizing: border-box;
            transition: all 0.2s;
        }

        .admin-input:focus, .admin-select:focus {
            border-color: var(--color-admin-accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.12);
        }

        .admin-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .admin-form-group label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--color-admin-text-main);
        }

        .admin-textarea {
            font-family: var(--font-sans);
            padding: 10px 14px;
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-input);
            font-size: 0.9rem;
            width: 100%;
            min-height: 80px;
            resize: vertical;
            box-sizing: border-box;
        }

        .admin-textarea:focus {
            border-color: var(--color-admin-accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.12);
        }

        /* ─── Buttons ─── */
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
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
        }

        .btn-solid-accent:hover { background-color: var(--color-admin-accent-hover); }

        .btn-solid-gold {
            background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
            color: #fff;
            border: none;
            padding: 10px 18px;
            font-size: 0.88rem;
            border-radius: var(--radius-admin-input);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
        }

        .btn-solid-gold:hover { filter: brightness(1.06); }

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
            gap: 5px;
        }

        .btn-action-outline:hover { border-color: var(--color-admin-text-main); color: var(--color-admin-text-main); background-color: var(--color-admin-border-light); }
        .btn-action-outline.danger:hover { border-color: #ba3c1c; color: #ba3c1c; background-color: #fbeae5; }

        .btn-danger {
            background-color: #ba3c1c;
            color: #fff;
            border: none;
            padding: 10px 18px;
            font-size: 0.88rem;
            border-radius: var(--radius-admin-input);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-danger:hover { background-color: #9d3218; }

        /* ─── Status Badges ─── */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .status-badge.pending { background-color: #fff8e1; color: #b56f00; }
        .status-badge.delivered, .status-badge.active { background-color: #e3fbeb; color: #008060; }
        .status-badge.cancelled { background-color: #fbeae5; color: #ba3c1c; }
        .status-badge.processing { background-color: #e4f0ff; color: #1a56d6; }

        /* ─── Modal Overlays ─── */
        .admin-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
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
            max-width: 580px;
            max-height: 88vh;
            overflow-y: auto;
            box-shadow: var(--shadow-admin-lg);
            transform: translateY(-30px) scale(0.96);
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
            border-radius: var(--radius-admin-card) var(--radius-admin-card) 0 0;
        }

        .admin-modal-title {
            font-family: var(--font-secondary);
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--color-admin-gold);
            margin: 0;
        }

        .admin-modal-close {
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 1.6rem;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.2s;
        }

        .admin-modal-close:hover { color: var(--color-admin-gold); }

        .admin-modal-body { padding: 24px; }

        /* ─── Responsive ─── */
        @media (max-width: 991px) {
            .admin-toggle-sidebar { display: flex; }
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.active { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .admin-content { padding: 20px 16px; }
        }

        @media (max-width: 640px) {
            .admin-header { padding: 0 16px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="admin-layout">
        
        <!-- ─── Sidebar ─── -->
        <aside class="admin-sidebar" id="adminSidebar">
            
            <div class="admin-brand">
                <div class="admin-brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <div class="admin-brand-text">
                    <span class="admin-brand-name">Al Barr Admin</span>
                    <span class="admin-brand-sub">Management Console</span>
                </div>
            </div>

            <nav class="admin-nav">

                {{-- OVERVIEW --}}
                <span class="nav-section-label">Overview</span>
                <ul class="admin-menu">
                    <li class="admin-menu-item @if(Route::is('admin.dashboard')) active @endif">
                        <a href="{{ route('admin.dashboard') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            Dashboard
                        </a>
                    </li>
                </ul>

                {{-- CATALOG --}}
                <span class="nav-section-label">Catalog</span>
                <ul class="admin-menu">
                    <li class="admin-menu-item @if(Route::is('admin.products')) active @endif">
                        <a href="{{ route('admin.products') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                            Products
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.categories')) active @endif">
                        <a href="{{ route('admin.categories') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            Categories
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.inventory')) active @endif">
                        <a href="{{ route('admin.inventory') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M3 3h18v4H3z"/><path d="M3 11h18v4H3z"/><path d="M3 19h18v2H3z"/><path d="M7 7h.01"/><path d="M7 15h.01"/></svg>
                            Inventory
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.coupons')) active @endif">
                        <a href="{{ route('admin.coupons') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            Coupons
                        </a>
                    </li>
                </ul>

                {{-- SALES --}}
                <span class="nav-section-label">Sales</span>
                <ul class="admin-menu">
                    <li class="admin-menu-item @if(Route::is('admin.orders')) active @endif">
                        <a href="{{ route('admin.orders') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                            Orders
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.returns')) active @endif">
                        <a href="{{ route('admin.returns') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                            Returns & Refunds
                        </a>
                    </li>
                </ul>

                {{-- CUSTOMERS --}}
                <span class="nav-section-label">Customers</span>
                <ul class="admin-menu">
                    <li class="admin-menu-item @if(Route::is('admin.customers')) active @endif">
                        <a href="{{ route('admin.customers') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            Customers
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.reviews')) active @endif">
                        <a href="{{ route('admin.reviews') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Reviews
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.tickets*')) active @endif">
                        <a href="{{ route('admin.tickets') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                            Support Tickets
                        </a>
                    </li>
                </ul>

                {{-- SYSTEM --}}
                <span class="nav-section-label">System</span>
                <ul class="admin-menu">
                    <li class="admin-menu-item @if(Route::is('admin.settings')) active @endif">
                        <a href="{{ route('admin.settings') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                            Settings
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.backups')) active @endif">
                        <a href="{{ route('admin.backups') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                            Backups
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="{{ route('home') }}" target="_blank">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Storefront
                        </a>
                    </li>
                </ul>

            </nav>
            
            <div class="admin-sidebar-footer">
                &copy; {{ date('Y') }} Al Barr Foods &mdash; CMS v2.0
            </div>
        </aside>

        <!-- ─── Main Body ─── -->
        <div class="admin-main">
            
            <!-- Topbar Header -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <button class="admin-toggle-sidebar" id="sidebarToggle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                    <h1 class="admin-header-title">@yield('header_title', 'Management Console')</h1>
                </div>
                
                <div class="admin-header-right">
                    <div class="admin-profile-badge">
                        <div class="admin-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                        <div style="display: flex; flex-direction: column; line-height: 1.2;">
                            <span style="font-size: 0.85rem; font-weight: 700;">{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <span style="font-size: 0.7rem; color: var(--color-admin-text-muted); font-weight: 500;">Super Admin</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" style="background:none;border:1px solid var(--color-admin-border);color:var(--color-admin-text-muted);padding:7px 14px;border-radius:8px;cursor:pointer;font-size:0.8rem;font-weight:600;transition:all 0.2s;font-family:var(--font-sans);" onmouseover="this.style.background='#fbeae5';this.style.color='#ba3c1c';this.style.borderColor='#f9d0c4';" onmouseout="this.style.background='none';this.style.color='var(--color-admin-text-muted)';this.style.borderColor='var(--color-admin-border)';">
                            Sign Out
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="admin-content">
                @if(session('success'))
                    <div class="alert-box success">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-box error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('adminSidebar');
            
            if (toggle && sidebar) {
                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('active');
                });
                
                document.addEventListener('click', (e) => {
                    if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && e.target !== toggle) {
                        sidebar.classList.remove('active');
                    }
                });
            }
        });

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
    @yield('scripts')
</body>
</html>
