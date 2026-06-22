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
            --admin-sidebar-width: 272px;
            --admin-header-height: 68px;
            
            --color-admin-bg: #f4f7fb;
            --color-admin-card-bg: #ffffff;
            --color-admin-sidebar: #0a0f1e;
            --color-admin-sidebar-hover: rgba(255, 255, 255, 0.05);
            --color-admin-text-main: #0f172a;
            --color-admin-text-muted: #64748b;
            --color-admin-accent: #018849;
            --color-admin-accent-hover: #016a39;
            --color-admin-gold: #c5a880;
            --color-admin-gold-hover: #b4956d;
            --color-admin-border: #e2e8f0;
            --color-admin-border-light: #f1f5f9;
            
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --font-secondary: 'Outfit', sans-serif;
            --font-mono: 'Fira Code', monospace;
            
            --radius-admin-card: 14px;
            --radius-admin-input: 10px;
            --radius-admin-badge: 8px;
            
            --spacing-xs: 8px;
            --spacing-sm: 12px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;

            --shadow-admin-sm: 0px 1px 4px rgba(15, 23, 42, 0.04), 0px 1px 2px rgba(15, 23, 42, 0.02);
            --shadow-admin-md: 0px 8px 20px rgba(15, 23, 42, 0.06), 0px 2px 6px rgba(15, 23, 42, 0.03);
            --shadow-admin-lg: 0px 20px 40px rgba(15, 23, 42, 0.1), 0px 4px 16px rgba(15, 23, 42, 0.05);
            --shadow-admin-glow: 0px 0px 24px rgba(197, 168, 128, 0.25);
            --shadow-accent-glow: 0px 0px 20px rgba(1, 136, 73, 0.18);
            
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
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
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ─── Sidebar ─── */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background: linear-gradient(175deg, #080c18 0%, #0a1229 50%, #0d1530 100%);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
            transition: var(--transition-smooth);
            overflow: hidden;
        }

        /* ─── Mobile Sidebar Overlay ─── */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(9, 13, 22, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 199;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .admin-brand {
            padding: 24px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .admin-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #018849 0%, #014e28 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(1, 136, 73, 0.4);
            position: relative;
        }
        
        .admin-brand-icon::after {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            border-radius: 14px;
            background: linear-gradient(135deg, #c5a880, transparent);
            z-index: -1;
            opacity: 0.4;
        }

        .admin-brand-icon svg {
            width: 22px;
            height: 22px;
            color: #fff;
        }

        .admin-brand-name {
            font-family: var(--font-secondary);
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #f7dfbe 0%, #c5a880 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            line-height: 1.2;
        }

        .admin-brand-sub {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* ─── Scrollable Nav ─── */
        .admin-nav {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }

        .admin-nav::-webkit-scrollbar { width: 5px; }
        .admin-nav::-webkit-scrollbar-track { background: transparent; }
        .admin-nav::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.08); border-radius: 5px; }

        /* ─── Section Labels ─── */
        .nav-section-label {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.22);
            padding: 20px 24px 8px;
            display: block;
        }

        .nav-section-label:first-child { padding-top: 8px; }

        /* ─── Nav Items ─── */
        .admin-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-menu-item {
            margin: 3px 14px;
        }

        .admin-menu-item a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 16px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 12px;
            transition: var(--transition-fast);
            position: relative;
        }

        .admin-menu-item a:hover {
            background-color: var(--color-admin-sidebar-hover);
            color: #fff;
            padding-left: 18px;
        }

        .admin-menu-item.active a {
            background: linear-gradient(90deg, rgba(197, 168, 128, 0.15) 0%, rgba(197, 168, 128, 0.03) 100%);
            color: #f7dfbe;
            font-weight: 700;
            box-shadow: inset 3px 0 0 #c5a880;
        }
        
        .admin-menu-item.active a::after {
            content: '';
            position: absolute;
            right: 16px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #c5a880;
            box-shadow: 0 0 8px #c5a880;
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
            opacity: 0.85;
            transition: var(--transition-fast);
        }
        
        .admin-menu-item a:hover .sidebar-icon {
            opacity: 1;
            transform: scale(1.05);
        }

        .admin-sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.25);
            text-align: center;
            font-weight: 600;
            flex-shrink: 0;
        }

        /* ─── Main Area ─── */
        .admin-main {
            flex-grow: 1;
            margin-left: var(--admin-sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: var(--transition-smooth);
        }

        /* ─── Top Header ─── */
        .admin-header {
            height: var(--admin-header-height);
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: var(--shadow-admin-sm);
        }

        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .admin-toggle-sidebar {
            background: none;
            border: 1px solid var(--color-admin-border);
            color: var(--color-admin-text-main);
            cursor: pointer;
            display: none;
            padding: 8px;
            border-radius: 10px;
            transition: var(--transition-fast);
        }

        .admin-toggle-sidebar:hover { 
            background-color: var(--color-admin-border-light);
            border-color: var(--color-admin-text-muted);
        }
        
        .admin-toggle-sidebar svg { width: 20px; height: 20px; display: block; }

        .admin-header-title {
            font-family: var(--font-secondary);
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--color-admin-text-main);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .admin-profile-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            padding: 6px 16px 6px 6px;
            border-radius: 40px;
            border: 1px solid var(--color-admin-border);
            box-shadow: var(--shadow-admin-sm);
            cursor: pointer;
            transition: var(--transition-fast);
        }
        
        .admin-profile-badge:hover {
            border-color: var(--color-admin-gold);
            box-shadow: var(--shadow-admin-md);
            transform: translateY(-1px);
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-admin-accent) 0%, var(--color-admin-sidebar) 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9rem;
            border: 2px solid var(--color-admin-gold);
            flex-shrink: 0;
            font-family: var(--font-secondary);
        }

        /* ─── Content Area ─── */
        .admin-content {
            padding: 32px;
            flex-grow: 1;
            max-width: 1440px;
            width: 100%;
            box-sizing: border-box;
            margin: 0 auto;
        }

        /* ─── Cards ─── */
        .admin-card {
            background-color: var(--color-admin-card-bg);
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-card);
            padding: 24px;
            box-shadow: var(--shadow-admin-sm);
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .admin-card:hover { 
            box-shadow: var(--shadow-admin-lg); 
            border-color: rgba(197, 168, 128, 0.4);
            transform: translateY(-2px);
        }

        .admin-card-title {
            font-family: var(--font-secondary);
            font-size: 1.3rem;
            color: var(--color-admin-text-main);
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ─── Alert Boxes ─── */
        .alert-box {
            padding: 14px 20px;
            border-radius: var(--radius-admin-input);
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInDown 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInDown {
            0% { transform: translateY(-12px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .alert-box.success { background-color: #e6f6ee; border: 1px solid #a3e0c1; color: #007f4b; }
        .alert-box.error { background-color: #fdf2f0; border: 1px solid #f9d0c4; color: #ba3c1c; }

        /* ─── Form Elements ─── */
        .admin-input, .admin-select {
            font-family: var(--font-sans);
            padding: 12px 16px;
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-input);
            font-size: 0.92rem;
            width: 100%;
            background-color: #fff;
            color: var(--color-admin-text-main);
            box-sizing: border-box;
            transition: var(--transition-fast);
        }

        .admin-input:focus, .admin-select:focus {
            border-color: var(--color-admin-accent);
            outline: none;
            box-shadow: 0 0 0 4px rgba(1, 136, 73, 0.1);
            background-color: #fff;
        }

        .admin-form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .admin-form-group label {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--color-admin-text-main);
            letter-spacing: 0.2px;
        }

        .admin-textarea {
            font-family: var(--font-sans);
            padding: 12px 16px;
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-input);
            font-size: 0.92rem;
            width: 100%;
            min-height: 100px;
            resize: vertical;
            box-sizing: border-box;
            transition: var(--transition-fast);
        }

        .admin-textarea:focus {
            border-color: var(--color-admin-accent);
            outline: none;
            box-shadow: 0 0 0 4px rgba(1, 136, 73, 0.1);
        }

        /* ─── Buttons ─── */
        .btn-solid-accent {
            background-color: var(--color-admin-accent);
            color: #fff;
            border: 1px solid var(--color-admin-accent);
            padding: 12px 22px;
            font-size: 0.9rem;
            border-radius: var(--radius-admin-input);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: var(--shadow-accent-glow);
        }

        .btn-solid-accent:hover { 
            background-color: var(--color-admin-accent-hover); 
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(1, 136, 73, 0.25);
        }
        
        .btn-solid-accent:active {
            transform: translateY(1px);
        }

        .btn-solid-gold {
            background: linear-gradient(135deg, #c5a880 0%, #b4956d 100%);
            color: #fff;
            border: none;
            padding: 12px 22px;
            font-size: 0.9rem;
            border-radius: var(--radius-admin-input);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: var(--shadow-admin-glow);
        }

        .btn-solid-gold:hover { 
            filter: brightness(1.05); 
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(197, 168, 128, 0.35);
        }
        
        .btn-solid-gold:active {
            transform: translateY(1px);
        }

        .btn-action-outline {
            background: transparent;
            border: 1px solid var(--color-admin-border);
            color: var(--color-admin-text-muted);
            padding: 8px 14px;
            font-size: 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: var(--transition-fast);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-action-outline:hover { 
            border-color: var(--color-admin-text-main); 
            color: var(--color-admin-text-main); 
            background-color: var(--color-admin-border-light); 
        }
        
        .btn-action-outline.danger:hover { 
            border-color: #ba3c1c; 
            color: #ba3c1c; 
            background-color: #fdf2f0; 
        }

        .btn-danger {
            background-color: #ba3c1c;
            color: #fff;
            border: none;
            padding: 12px 22px;
            font-size: 0.9rem;
            border-radius: var(--radius-admin-input);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-danger:hover { 
            background-color: #9d3218; 
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(186, 60, 28, 0.2);
        }

        /* ─── Status Badges with Pulsing Dots ─── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-badge.pending { 
            background-color: rgba(217, 119, 6, 0.1); 
            color: #d97706; 
        }
        .status-badge.pending::before { 
            background-color: #d97706; 
            animation: pulse-dot-orange 1.8s infinite;
        }

        .status-badge.delivered, .status-badge.active { 
            background-color: rgba(1, 136, 73, 0.1); 
            color: #018849; 
        }
        .status-badge.delivered::before, .status-badge.active::before { 
            background-color: #018849; 
            animation: pulse-dot-green 1.8s infinite;
        }

        .status-badge.cancelled, .status-badge.returned, .status-badge.refunded { 
            background-color: rgba(186, 60, 28, 0.1); 
            color: #ba3c1c; 
        }
        .status-badge.cancelled::before, .status-badge.returned::before, .status-badge.refunded::before { 
            background-color: #ba3c1c; 
        }

        .status-badge.processing, .status-badge.confirmed, .status-badge.packed, .status-badge.shipped { 
            background-color: rgba(26, 86, 214, 0.1); 
            color: #1a56d6; 
        }
        .status-badge.processing::before, .status-badge.confirmed::before, .status-badge.packed::before, .status-badge.shipped::before { 
            background-color: #1a56d6; 
            animation: pulse-dot-blue 1.8s infinite;
        }
        
        @keyframes pulse-dot-green {
            0% { box-shadow: 0 0 0 0 rgba(1, 136, 73, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(1, 136, 73, 0); }
            100% { box-shadow: 0 0 0 0 rgba(1, 136, 73, 0); }
        }
        
        @keyframes pulse-dot-orange {
            0% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(217, 119, 6, 0); }
            100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
        }

        @keyframes pulse-dot-blue {
            0% { box-shadow: 0 0 0 0 rgba(26, 86, 214, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(26, 86, 214, 0); }
            100% { box-shadow: 0 0 0 0 rgba(26, 86, 214, 0); }
        }

        /* ─── Modal Overlays ─── */
        .admin-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transition: var(--transition-smooth);
        }

        .admin-modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .admin-modal-card {
            background-color: #fff;
            border-radius: var(--radius-admin-card);
            border: 1px solid var(--color-admin-border);
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: var(--shadow-admin-lg);
            transform: translateY(-24px) scale(0.97);
            transition: var(--transition-smooth);
        }

        .admin-modal-overlay.active .admin-modal-card {
            transform: translateY(0) scale(1);
        }

        .admin-modal-header {
            background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);
            color: #fff;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .admin-modal-title {
            font-family: var(--font-secondary);
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--color-admin-gold);
            margin: 0;
        }

        .admin-modal-close {
            background: none;
            border: none;
            color: rgba(255,255,255,0.8);
            font-size: 1.8rem;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            transition: var(--transition-fast);
        }

        .admin-modal-close:hover { 
            color: #fff; 
            background-color: rgba(255,255,255,0.08);
        }

        .admin-modal-body { padding: 24px; }

        /* ─── Responsive & Mobile App Enhancements ─── */
        @media (max-width: 1024px) {
            .admin-toggle-sidebar { display: flex; }
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.active { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            
            /* Reposition Bulk Action Floating Bars */
            #productBulkActionsBar,
            #bulkActionsBar,
            .ticket-bulk-bar,
            .review-bulk-bar,
            .cart-bulk-bar,
            #mediaBulkBar {
                left: 16px !important;
                right: 16px !important;
                width: auto !important;
            }
        }

        @media (max-width: 768px) {
            .admin-header { padding: 0 16px; gap: 12px; }
            .admin-content { padding: 16px 12px !important; }
            .admin-header-title { font-size: 1.15rem; }
            .admin-header-left { gap: 10px; }
            .admin-header-right { gap: 10px; }

            /* Ensure all tables are horizontally scrollable without squishing columns */
            .details-table-wrap,
            .prod-variants-table-wrap,
            .table-wrap,
            .orders-table-wrap,
            .coupon-table-wrap,
            .table-responsive {
                overflow-x: auto !important;
                width: 100% !important;
                -webkit-overflow-scrolling: touch;
            }
            .admin-table,
            .prod-variants-table,
            .inv-table,
            .cust-table,
            .coupon-table,
            .cart-tbl,
            .inv-items-table {
                display: table !important;
                min-width: 650px !important;
            }

            /* Make Inputs touch-friendly and prevent iOS zoom */
            .admin-input, .admin-select, .admin-textarea {
                font-size: 16px !important;
                padding: 10px 14px !important;
            }
        }

        @media (max-width: 640px) {
            /* Profile Badge reduction */
            .admin-profile-badge {
                padding: 0 !important;
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
            }
            .admin-header-right a, 
            .admin-header-right button,
            .admin-header-right form button {
                padding: 8px !important;
                gap: 0 !important;
            }

            /* Force grid columns to collapse to vertical stack */
            .text-grid,
            .admin-modal-body div[style*="grid-template-columns"],
            div[style*="grid-template-columns"]:not(#mediaChooserGrid):not(.media-grid) {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            /* Enable flex wrap on action headers/filters to prevent horizontal overflow */
            .catalog-header-actions,
            .prod-header-actions-group,
            .actions-bar-btns,
            .bar-actions,
            .admin-card-title,
            div[style*="display: flex"][style*="justify-content: space-between"]:not(.kpi-card-top),
            div[style*="display:flex"][style*="justify-content:space-between"]:not(.kpi-card-top) {
                flex-wrap: wrap !important;
                gap: 10px !important;
            }

            /* Floating bulk actions mobile stack sheet */
            #productBulkActionsBar,
            #bulkActionsBar,
            .ticket-bulk-bar,
            .review-bulk-bar,
            .cart-bulk-bar,
            #mediaBulkBar {
                bottom: 16px !important;
                padding: 12px 16px !important;
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
                border-radius: 12px !important;
                left: 16px !important;
                right: 16px !important;
                transform: none !important;
            }
            #productBulkActionsBar form,
            #bulkActionsBar form,
            .ticket-bulk-bar form,
            .review-bulk-bar form,
            .cart-bulk-bar div {
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 8px !important;
                width: 100% !important;
            }
            #productBulkActionsBar form > *,
            #bulkActionsBar form > * {
                width: 100% !important;
            }
            #mediaBulkBar > * {
                width: 100% !important;
                text-align: center !important;
                justify-content: center !important;
            }

            /* Make filter row inputs stretch on mobile */
            .filter-row, .order-filters {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .filter-row > *, .order-filters > * {
                max-width: 100% !important;
                width: 100% !important;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 480px) {
            .admin-header { padding: 0 12px; gap: 8px; }
            .admin-content { padding: 10px 8px !important; }
            .admin-header-left { gap: 8px; }
            .admin-header-right { gap: 6px; }
            .admin-header-title { font-size: 1rem; }
            
            /* Hide Storefront shortcut link (available in sidebar) */
            .admin-header-right a[title="View Storefront"] {
                display: none !important;
            }

            /* Compact Cards for mobile app feel */
            .admin-card {
                padding: 16px 12px !important;
                margin-bottom: 16px !important;
                border-radius: 10px !important;
            }
            .admin-card-title {
                font-size: 1.1rem !important;
                margin-bottom: 12px !important;
            }

            /* Make actions button containers full width */
            .catalog-header-actions > *,
            .catalog-header-actions > div > *,
            .prod-header-actions-group > * {
                width: 100% !important;
                justify-content: center !important;
            }
            
            /* KPI dashboard widgets stacking */
            .kpi-grid,
            .orders-stats-bar,
            .stats-4-grid,
            .media-stats-grid {
                gap: 12px !important;
                margin-bottom: 16px !important;
            }
        }

        @media (max-width: 380px) {
            /* Hide search on extremely narrow screens to avoid wrapping */
            .admin-header-right button[title*="Search"] {
                display: none !important;
            }
        }

        /* Swipeable scroll tabs for mobile */
        @media (max-width: 768px) {
            .status-tabs,
            .nav-tabs,
            .category-tabs,
            .media-tabs {
                display: flex !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 6px !important;
                margin-bottom: 16px !important;
                border-bottom: 1px solid var(--color-admin-border) !important;
                gap: 8px !important;
            }
            .status-tab-btn,
            .nav-tab-btn,
            .tab-btn {
                flex: 0 0 auto !important;
                white-space: nowrap !important;
                margin-bottom: 0 !important;
                padding: 10px 14px !important;
            }
            /* Adjust table wrappers styling as fallback */
            .table-responsive {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* ─── Premium Global Table System ─── */
        .admin-table,
        .prod-variants-table,
        .inv-table,
        .cust-table,
        .coupon-table,
        .cart-tbl {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
            border-radius: 10px;
            overflow: hidden;
        }

        .admin-table th,
        .prod-variants-table th,
        .inv-table th,
        .cust-table th,
        .coupon-table th,
        .cart-tbl th {
            padding: 13px 18px;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%) !important;
            border-bottom: 1px solid var(--color-admin-border) !important;
            font-size: 0.73rem;
            font-weight: 800;
            color: var(--color-admin-text-muted) !important;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-family: var(--font-secondary);
            white-space: nowrap;
        }

        .admin-table td,
        .prod-variants-table td,
        .inv-table td,
        .cust-table td,
        .coupon-table td,
        .cart-tbl td {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.7) !important;
            color: var(--color-admin-text-main) !important;
            font-size: 0.875rem;
            vertical-align: middle;
            background-color: #fff !important;
            transition: background-color 0.12s ease;
        }

        .admin-table tr:last-child td,
        .prod-variants-table tr:last-child td,
        .inv-table tr:last-child td,
        .cust-table tr:last-child td,
        .coupon-table tr:last-child td,
        .cart-tbl tr:last-child td {
            border-bottom: none !important;
        }

        .admin-table tr:hover td,
        .prod-variants-table tr:hover td,
        .inv-table tr:hover td,
        .cust-table tr:hover td,
        .coupon-table tr:hover td,
        .cart-tbl tr:hover td {
            background-color: rgba(241, 245, 249, 0.7) !important;
        }

        /* Table wrapper with border */
        .table-wrap {
            border: 1px solid var(--color-admin-border);
            border-radius: 12px;
            overflow: hidden;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ─── Global Empty State ─── */
        .empty-state-cell {
            text-align: center;
            padding: 60px 20px !important;
            color: var(--color-admin-text-muted);
        }

        .empty-state-cell .es-icon {
            font-size: 2.8rem;
            opacity: 0.3;
            margin-bottom: 14px;
            display: block;
        }

        .empty-state-cell .es-title {
            font-family: var(--font-secondary);
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-admin-text-main);
            margin-bottom: 6px;
        }

        .empty-state-cell .es-sub {
            font-size: 0.84rem;
            color: var(--color-admin-text-muted);
        }

        /* ─── Scrollbar Overhaul ─── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(15, 23, 42, 0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(1, 136, 73, 0.25); }

        /* ─── Card Hover Lift ─── */
        .kpi-card, .admin-card, .cat-stat-card, .prod-row-card,
        .coupon-stat-card, .cust-stat-card, .inv-stat-card, .orders-stat-card {
            border: 1px solid var(--color-admin-border) !important;
            background-color: var(--color-admin-card-bg);
            border-radius: var(--radius-admin-card) !important;
            box-shadow: var(--shadow-admin-sm);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .kpi-card:hover, .admin-card:hover, .cat-stat-card:hover, .prod-row-card:hover,
        .coupon-stat-card:hover, .cust-stat-card:hover, .inv-stat-card:hover, .orders-stat-card:hover {
            transform: translateY(-3px) !important;
            box-shadow: var(--shadow-admin-lg) !important;
            border-color: rgba(197, 168, 128, 0.35) !important;
        }

        /* ─── Input Focus Glow ─── */
        .admin-input:focus, .admin-select:focus, .admin-textarea:focus {
            border-color: var(--color-admin-accent) !important;
            box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.12) !important;
            outline: none;
        }

        /* ─── Page Fade In ─── */
        .admin-content {
            animation: fadeInPage 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInPage {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ─── Page Section Header ─── */
        .page-section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .page-section-header h2 {
            font-family: var(--font-secondary);
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--color-admin-text-main);
            margin: 0 0 4px;
            letter-spacing: -0.3px;
        }

        .page-section-header p {
            font-size: 0.84rem;
            color: var(--color-admin-text-muted);
            margin: 0;
        }

        .page-section-header .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        /* ─── Search + Filter Row ─── */
        .filter-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 18px;
        }

        .filter-row .admin-input,
        .filter-row .admin-select {
            flex: 1;
            min-width: 160px;
            max-width: 280px;
        }

        /* ─── Stat Cards Grid ─── */
        .stats-4-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        @media (max-width: 1024px) { .stats-4-grid { grid-template-columns: repeat(2, 1fr); } }
       

        .stat-kpi-card {
            background: #fff;
            border: 1px solid var(--color-admin-border);
            border-radius: var(--radius-admin-card);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-admin-sm);
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        .stat-kpi-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-kpi-card:hover::after { opacity: 1; }
        .stat-kpi-card.green::after { background: var(--color-admin-accent); }
        .stat-kpi-card.blue::after  { background: #1a56d6; }
        .stat-kpi-card.gold::after  { background: var(--color-admin-gold); }
        .stat-kpi-card.red::after   { background: #ba3c1c; }
        .stat-kpi-card.purple::after { background: #7e22ce; }
        .stat-kpi-card.amber::after  { background: #d97706; }

        .stat-kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-kpi-icon svg { width: 22px; height: 22px; }

        .stat-kpi-icon.green  { background: rgba(1, 136, 73, 0.1);   color: var(--color-admin-accent); }
        .stat-kpi-icon.blue   { background: rgba(26, 86, 214, 0.1);  color: #1a56d6; }
        .stat-kpi-icon.gold   { background: rgba(197, 168, 128, 0.12); color: var(--color-admin-gold); }
        .stat-kpi-icon.red    { background: rgba(186, 60, 28, 0.1);  color: #ba3c1c; }
        .stat-kpi-icon.purple { background: rgba(126, 34, 206, 0.1); color: #7e22ce; }
        .stat-kpi-icon.amber  { background: rgba(217, 119, 6, 0.1);  color: #d97706; }

        .stat-kpi-body { flex: 1; min-width: 0; }
        .stat-kpi-val  { font-family: var(--font-secondary); font-size: 1.8rem; font-weight: 900; color: var(--color-admin-text-main); line-height: 1; margin: 0; letter-spacing: -0.5px; }
        .stat-kpi-label { font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--color-admin-text-muted); margin-top: 5px; }

        /* ─── Responsive Utilities ─── */
        @media (max-width: 640px) {
            .hide-mobile { display: none !important; }
        }

        @media (min-width: 641px) {
            #adminClock { display: block !important; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
                    <li class="admin-menu-item @if(Route::is('admin.media')) active @endif">
                        <a href="{{ route('admin.media') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Media Library
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
                            <span class="sidebar-badge badge-orders" style="display: none; background: #ba3c1c; color: #fff; font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; font-weight: bold; margin-left: auto;"></span>
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.returns')) active @endif">
                        <a href="{{ route('admin.returns') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                            Returns & Refunds
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.abandoned-carts')) active @endif">
                        <a href="{{ route('admin.abandoned-carts') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6M10 11V6M14 11V6"/></svg>
                            Abandoned Carts
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
                            <span class="sidebar-badge badge-reviews" style="display: none; background: #ba3c1c; color: #fff; font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; font-weight: bold; margin-left: auto;"></span>
                        </a>
                    </li>
                    <li class="admin-menu-item @if(Route::is('admin.tickets*')) active @endif">
                        <a href="{{ route('admin.tickets') }}">
                            <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                            Support Tickets
                            <span class="sidebar-badge badge-tickets" style="display: none; background: #ba3c1c; color: #fff; font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; font-weight: bold; margin-left: auto;"></span>
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
        </aside>

        <div class="admin-main">
            <!-- Topbar Header -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <button class="admin-toggle-sidebar" id="sidebarToggle" title="Toggle Sidebar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                    
                    <div style="display: flex; flex-direction: column;">
                        {{-- Breadcrumbs --}}
                        <div class="hide-mobile" style="display: flex; align-items: center; gap: 6px; font-size: 0.7rem; font-weight: 700; color: var(--color-admin-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                            <a href="{{ route('admin.dashboard') }}" style="color: inherit; text-decoration: none; transition: color 0.15s;">Admin</a>
                            @php
                                $segments = request()->segments();
                                if (count($segments) > 0 && $segments[0] === 'admin') {
                                    array_shift($segments);
                                }
                            @endphp
                            @foreach($segments as $index => $segment)
                                <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;"><polyline points="9 18 15 12 9 6"/></svg>
                                @php
                                    $isLast = $index === count($segments) - 1;
                                    $cleanSegment = str_replace('-', ' ', $segment);
                                @endphp
                                @if($isLast)
                                    <span style="color: var(--color-admin-accent)">{{ $cleanSegment }}</span>
                                @else
                                    <span style="color: var(--color-admin-text-muted)">{{ $cleanSegment }}</span>
                                @endif
                            @endforeach
                        </div>
                        <h1 class="admin-header-title" style="margin: 0; line-height: 1.1;">@yield('header_title', 'Management Console')</h1>
                    </div>
                </div>
                
                <div class="admin-header-right">
                    {{-- Live Clock --}}
                    <div id="adminClock" style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-admin-text-muted); font-weight: 600; display: none; min-width: 85px; text-align: right;"></div>

                    {{-- Quick Search Palette Launcher --}}
                    <button onclick="openModal('commandPalette')" title="Search & Actions (Ctrl+K)" style="display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border: 1px solid var(--color-admin-border); border-radius: 8px; color: var(--color-admin-text-muted); cursor: pointer; transition: all 0.15s; background: #fff;" onmouseover="this.style.borderColor='var(--color-admin-gold)';" onmouseout="this.style.borderColor='var(--color-admin-border)';">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </button>

                    {{-- Storefront Link --}}
                    <a href="{{ route('home') }}" target="_blank" title="View Storefront" style="display: flex; align-items: center; gap: 6px; padding: 8px 12px; border: 1px solid var(--color-admin-border); border-radius: 8px; color: var(--color-admin-text-muted); font-size: 0.78rem; font-weight: 600; text-decoration: none; transition: all 0.15s; background: #fff;" onmouseover="this.style.borderColor='var(--color-admin-gold)';" onmouseout="this.style.borderColor='var(--color-admin-border)';">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        <span class="hide-mobile">Store</span>
                    </a>

                    {{-- Notifications Bell dropdown --}}
                    <div class="admin-bell-container" style="position: relative;">
                        <button id="adminBellButton" title="Notifications" style="position: relative; background: none; border: 1px solid var(--color-admin-border); color: var(--color-admin-text-muted); width: 34px; height: 34px; border-radius: 8px; cursor: pointer; transition: all 0.15s; display: flex; align-items: center; justify-content: center; background: #fff;" onmouseover="this.style.borderColor='var(--color-admin-gold)';" onmouseout="this.style.borderColor='var(--color-admin-border)';">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span id="bellBadge" style="display: none; position: absolute; top: -2px; right: -2px; background: #ba3c1c; border: 2px solid #fff; width: 10px; height: 10px; border-radius: 50%;"></span>
                        </button>
                        
                        <div id="adminBellDropdown" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; width: 320px; background: #fff; border: 1px solid var(--color-admin-border); border-radius: 12px; box-shadow: var(--shadow-admin-lg); z-index: 100; overflow: hidden; transform-origin: top right; transition: all 0.2s;">
                            <div style="padding: 12px 16px; border-bottom: 1px solid var(--color-admin-border-light); display: flex; align-items: center; justify-content: space-between; background: var(--color-admin-border-light);">
                                <strong style="font-size: 0.85rem; color: var(--color-admin-text-main);">System Alerts</strong>
                                <span id="bellNotificationCountText" style="font-size: 0.72rem; font-weight: bold; color: var(--color-admin-accent);">0 Pending</span>
                            </div>
                            <div id="bellDropdownList" style="max-height: 280px; overflow-y: auto;">
                                <div style="padding: 24px; text-align: center; color: var(--color-admin-text-muted); font-size: 0.8rem;">Loading system alerts...</div>
                            </div>
                        </div>
                    </div>

                    <div class="admin-profile-badge">
                        <div class="admin-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                        <div style="display: flex; flex-direction: column; line-height: 1.25;" class="hide-mobile">
                            <span style="font-size: 0.84rem; font-weight: 700; color: var(--color-admin-text-main);">{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <span style="font-size: 0.69rem; color: var(--color-admin-text-muted); font-weight: 500; letter-spacing: 0.3px;">Super Admin</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" title="Sign Out" style="display:inline-flex;align-items:center;gap:6px;background:none;border:1px solid var(--color-admin-border);color:var(--color-admin-text-muted);padding:8px 14px;border-radius:8px;cursor:pointer;font-size:0.78rem;font-weight:600;transition:all 0.2s;font-family:var(--font-sans);" onmouseover="this.style.background='#fbeae5';this.style.color='#ba3c1c';this.style.borderColor='#f9d0c4';" onmouseout="this.style.background='none';this.style.color='var(--color-admin-text-muted)';this.style.borderColor='var(--color-admin-border)';">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            <span class="hide-mobile">Sign Out</span>
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="admin-content">
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            if (typeof showToast === 'function') showToast("{{ session('success') }}", 'success');
                        });
                    </script>
                @endif

                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            if (typeof showToast === 'function') showToast("{{ session('error') }}", 'error');
                        });
                    </script>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            function openSidebar() {
                sidebar.classList.add('active');
                if (overlay) overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            if (toggle && sidebar) {
                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.contains('active') ? closeSidebar() : openSidebar();
                });
                
                if (overlay) overlay.addEventListener('click', closeSidebar);

                // Close on ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && sidebar.classList.contains('active')) closeSidebar();
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

        // Live clock
        (function() {
            const clock = document.getElementById('adminClock');
            if (!clock) return;
            function updateClock() {
                const now = new Date();
                const h = String(now.getHours()).padStart(2,'0');
                const m = String(now.getMinutes()).padStart(2,'0');
                const s = String(now.getSeconds()).padStart(2,'0');
                clock.textContent = h + ':' + m + ':' + s;
            }
            updateClock();
            setInterval(updateClock, 1000);
        })();

        // --- 1. Global Toast System ---
        function showToast(message, type = 'success') {
            const container = document.getElementById('adminToastContainer');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = 'admin-toast';
            toast.style.pointerEvents = 'auto';
            toast.style.minWidth = '300px';
            toast.style.maxWidth = '400px';
            toast.style.background = '#fff';
            toast.style.borderRadius = '12px';
            toast.style.boxShadow = 'var(--shadow-admin-lg)';
            toast.style.padding = '14px 18px';
            toast.style.display = 'flex';
            toast.style.alignItems = 'center';
            toast.style.gap = '12px';
            toast.style.transform = 'translateY(20px)';
            toast.style.opacity = '0';
            toast.style.transition = 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
            
            let icon = '';
            let borderColor = '';
            if (type === 'success') {
                icon = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#018849" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`;
                borderColor = '3px solid #018849';
            } else if (type === 'error') {
                icon = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ba3c1c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`;
                borderColor = '3px solid #ba3c1c';
            } else {
                icon = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`;
                borderColor = '3px solid #d97706';
            }
            toast.style.borderLeft = borderColor;
            
            toast.innerHTML = `
                <div style="flex-shrink:0;">${icon}</div>
                <div style="flex-grow:1; font-size:0.84rem; font-weight:700; color:var(--color-admin-text-main); line-height:1.4;">${message}</div>
                <button type="button" style="background:none; border:none; color:var(--color-admin-text-muted); cursor:pointer; font-size:1.1rem; padding:0; line-height:1;" onclick="this.closest('.admin-toast').remove()">&times;</button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateY(0)';
                toast.style.opacity = '1';
            }, 50);
            
            setTimeout(() => {
                toast.style.transform = 'translateY(-20px)';
                toast.style.opacity = '0';
                setTimeout(() => { toast.remove(); }, 300);
            }, 4500);
        }

        // --- 2. Notification Bell Dropdown & Polling ---
        document.addEventListener('DOMContentLoaded', () => {
            const bellButton = document.getElementById('adminBellButton');
            const bellDropdown = document.getElementById('adminBellDropdown');
            
            if (bellButton && bellDropdown) {
                bellButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isVisible = bellDropdown.style.display === 'block';
                    bellDropdown.style.display = isVisible ? 'none' : 'block';
                    if (!isVisible) {
                        bellDropdown.style.opacity = '0';
                        bellDropdown.style.transform = 'scale(0.95) translateY(-10px)';
                        setTimeout(() => {
                            bellDropdown.style.opacity = '1';
                            bellDropdown.style.transform = 'scale(1) translateY(0)';
                        }, 50);
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!bellDropdown.contains(e.target) && e.target !== bellButton) {
                        bellDropdown.style.display = 'none';
                    }
                });
            }

            function fetchAlerts() {
                fetch('{{ route("admin.notifications.api") }}')
                    .then(res => res.json())
                    .then(data => {
                        updateSidebarBadges(data.counts);
                        updateBellDropdown(data);
                    })
                    .catch(err => console.error("Failed to load notifications API", err));
            }

            function updateSidebarBadges(counts) {
                const map = {
                    'orders': '.badge-orders',
                    'reviews': '.badge-reviews',
                    'tickets': '.badge-tickets'
                };
                for (const [key, selector] of Object.entries(map)) {
                    const badge = document.querySelector(selector);
                    if (badge) {
                        if (counts[key] > 0) {
                            badge.innerText = counts[key];
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                }
            }

            function updateBellDropdown(data) {
                const countBadge = document.getElementById('bellBadge');
                const countText = document.getElementById('bellNotificationCountText');
                const list = document.getElementById('bellDropdownList');
                
                const total = data.counts.total;
                if (total > 0) {
                    countBadge.style.display = 'block';
                    countText.innerText = `${total} Pending Alerts`;
                } else {
                    countBadge.style.display = 'none';
                    countText.innerText = `0 Pending`;
                }

                if (data.notifications.length === 0) {
                    list.innerHTML = `<div style="padding: 24px; text-align: center; color: var(--color-admin-text-muted); font-size: 0.8rem;">All clear! No pending alerts.</div>`;
                    return;
                }

                list.innerHTML = '';
                data.notifications.forEach(item => {
                    const el = document.createElement('a');
                    el.href = item.link;
                    el.style.display = 'flex';
                    el.style.gap = '12px';
                    el.style.padding = '12px 16px';
                    el.style.borderBottom = '1px solid var(--color-admin-border-light)';
                    el.style.textDecoration = 'none';
                    el.style.transition = 'background 0.2s';
                    
                    el.onmouseover = () => { el.style.background = 'var(--color-admin-border-light)'; };
                    el.onmouseout = () => { el.style.background = 'transparent'; };

                    let badgeColor = '#018849';
                    if (item.type === 'order') badgeColor = '#1a56d6';
                    if (item.type === 'stock' || item.type === 'ticket') badgeColor = '#ba3c1c';

                    el.innerHTML = `
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: ${badgeColor}; margin-top: 5px; flex-shrink: 0;"></div>
                        <div style="flex-grow: 1;">
                            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-admin-text-main); margin-bottom: 2px;">${item.title}</div>
                            <div style="font-size: 0.72rem; color: var(--color-admin-text-muted); line-height: 1.35;">${item.message}</div>
                        </div>
                    `;
                    list.appendChild(el);
                });
            }

            fetchAlerts();
            setInterval(fetchAlerts, 30000); // Poll every 30 seconds
        });

        // --- 3. Command Palette (Ctrl+K) System ---
        const commandPaletteItems = [
            { name: "📊 Go to Dashboard", keywords: "dashboard stats analytics logs overview home", action: () => window.location.href = "{{ route('admin.dashboard') }}" },
            { name: "📦 Product Catalog", keywords: "products inventory items weights stock variants active draft shop catalog list add product edit details", action: () => window.location.href = "{{ route('admin.products') }}" },
            { name: "🛒 View Orders", keywords: "orders customer sales delivery status payments tracking code invoices returns refunds", action: () => window.location.href = "{{ route('admin.orders') }}" },
            { name: "👥 Customer Database", keywords: "customers active accounts contact details lifetime value spend directory", action: () => window.location.href = "{{ route('admin.customers') }}" },
            { name: "🎫 Support Tickets", keywords: "tickets help support user queries complaints resolved replies assignments agent", action: () => window.location.href = "{{ route('admin.tickets') }}" },
            { name: "⭐ Product Reviews", keywords: "reviews stars comments testimonials moderation rating status approval products", action: () => window.location.href = "{{ route('admin.reviews') }}" },
            { name: "📂 Categories Management", keywords: "categories sorting hierarchy names parent products counts", action: () => window.location.href = "{{ route('admin.categories') }}" },
            { name: "🖼️ Media Library Catalog", keywords: "media files images assets upload delete urls copy", action: () => window.location.href = "{{ route('admin.media') }}" },
            { name: "🎟️ Coupons & Discounts", keywords: "coupons codes sales percentage discounts limits progress usage countdown expiry duplicate", action: () => window.location.href = "{{ route('admin.coupons') }}" },
            { name: "🛒 Abandoned Cart Recovery", keywords: "abandoned carts whatsapp clients notifications email logs value value-heatmap urgency", action: () => window.location.href = "{{ route('admin.abandoned-carts') }}" },
            { name: "⚙️ System Configuration", keywords: "settings bank config site smtp bank social mail general logs site-setup", action: () => window.location.href = "{{ route('admin.settings') }}" },
            { name: "💾 Database Backups", keywords: "backups creation timeline logs restore download backup settings safety", action: () => window.location.href = "{{ route('admin.backups') }}" },
            { name: "➕ Quick Create Product", keywords: "new product catalog initial weight sku variant cost", action: () => { closeModal('commandPalette'); if (typeof openAddProductModal === 'function') { openAddProductModal(); } else { window.location.href = "{{ route('admin.products') }}?action=create"; } } },
            { name: "🚪 Sign Out Session", keywords: "logout session close signout leave exit", action: () => { const f = document.querySelector('header form'); if (f) f.submit(); } }
        ];

        let commandPaletteSelectedIndex = 0;

        function renderCommandPaletteItems(filterText = '') {
            const list = document.getElementById('commandList');
            if (!list) return;
            list.innerHTML = '';
            
            const words = filterText.toLowerCase().trim().split(/\s+/).filter(Boolean);
            const filtered = commandPaletteItems.filter(item => {
                if (words.length === 0) return true;
                const combined = (item.name + ' ' + item.keywords).toLowerCase();
                return words.every(word => combined.includes(word));
            });

            if (filtered.length === 0) {
                list.innerHTML = `<div style="padding: 16px; text-align: center; color: var(--color-admin-text-muted); font-size: 0.82rem;">No matching actions found</div>`;
                return;
            }

            if (commandPaletteSelectedIndex >= filtered.length) {
                commandPaletteSelectedIndex = 0;
            }

            filtered.forEach((item, index) => {
                const el = document.createElement('div');
                el.innerText = item.name;
                el.style.padding = '10px 18px';
                el.style.fontSize = '0.86rem';
                el.style.fontWeight = '600';
                el.style.cursor = 'pointer';
                el.style.borderRadius = '8px';
                el.style.margin = '2px 8px';
                el.style.transition = 'all 0.15s';
                
                const isSelected = index === commandPaletteSelectedIndex;
                if (isSelected) {
                    el.style.background = 'var(--color-admin-accent)';
                    el.style.color = '#fff';
                    el.style.paddingLeft = '22px';
                } else {
                    el.style.color = 'var(--color-admin-text-main)';
                    el.style.background = 'transparent';
                }

                el.onmouseover = () => {
                    commandPaletteSelectedIndex = index;
                    renderCommandPaletteItems(document.getElementById('commandInput').value);
                };

                el.onclick = () => {
                    item.action();
                };

                list.appendChild(el);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('commandInput');
            const palette = document.getElementById('commandPalette');
            
            if (input) {
                input.addEventListener('input', () => {
                    commandPaletteSelectedIndex = 0;
                    renderCommandPaletteItems(input.value);
                });

                input.addEventListener('keydown', (e) => {
                    const list = document.getElementById('commandList');
                    const items = list.querySelectorAll('div:not([style*="text-align"])');
                    if (items.length === 0) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        commandPaletteSelectedIndex = (commandPaletteSelectedIndex + 1) % items.length;
                        renderCommandPaletteItems(input.value);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        commandPaletteSelectedIndex = (commandPaletteSelectedIndex - 1 + items.length) % items.length;
                        renderCommandPaletteItems(input.value);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        
                        const words = input.value.toLowerCase().trim().split(/\s+/).filter(Boolean);
                        const filtered = commandPaletteItems.filter(item => {
                            if (words.length === 0) return true;
                            const combined = (item.name + ' ' + item.keywords).toLowerCase();
                            return words.every(word => combined.includes(word));
                        });
                        if (filtered[commandPaletteSelectedIndex]) {
                            filtered[commandPaletteSelectedIndex].action();
                        }
                    }
                });
            }

            // Open palette with Ctrl+K / Cmd+K
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (palette.classList.contains('active')) {
                        closeModal('commandPalette');
                    } else {
                        openModal('commandPalette');
                        setTimeout(() => {
                            input.value = '';
                            input.focus();
                            commandPaletteSelectedIndex = 0;
                            renderCommandPaletteItems('');
                        }, 50);
                    }
                }
            });

            // Single key shortcut transitions G + [char]
            let lastKeyTime = 0;
            let lastKey = '';
            document.addEventListener('keydown', (e) => {
                const active = document.activeElement;
                if (active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.tagName === 'SELECT')) {
                    return;
                }

                const now = Date.now();
                if (lastKey === 'g' && now - lastKeyTime < 1000) {
                    const redirects = {
                        'd': "{{ route('admin.dashboard') }}",
                        'p': "{{ route('admin.products') }}",
                        'o': "{{ route('admin.orders') }}",
                        'c': "{{ route('admin.customers') }}",
                        'i': "{{ route('admin.inventory') }}",
                        's': "{{ route('admin.settings') }}"
                    };
                    if (redirects[e.key.toLowerCase()]) {
                        e.preventDefault();
                        window.location.href = redirects[e.key.toLowerCase()];
                    }
                    lastKey = '';
                } else if (e.key.toLowerCase() === 'g') {
                    lastKey = 'g';
                    lastKeyTime = now;
                } else {
                    lastKey = '';
                }
            });
        });
    </script>
    @yield('scripts')

    <!-- Dynamic Toast Container -->
    <div id="adminToastContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

    <!-- Command Palette Modal -->
    <div id="commandPalette" class="admin-modal-overlay" style="z-index: 9999;">
        <div class="admin-modal-card" style="max-width: 550px; background: rgba(255,255,255,0.95); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: 16px; margin-top: 10vh; border: 1px solid rgba(197,168,128,0.2);">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--color-admin-border-light); display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-admin-text-muted)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="commandInput" placeholder="Search page or run command..." style="width: 100%; border: none; background: transparent; font-size: 1.05rem; font-weight: 600; color: var(--color-admin-text-main); outline: none;" autocomplete="off">
                <button onclick="closeModal('commandPalette')" style="background: none; border: 1px solid var(--color-admin-border); border-radius: 6px; padding: 4px 8px; font-size: 0.7rem; font-weight: 700; color: var(--color-admin-text-muted); cursor: pointer;">ESC</button>
            </div>
            <div id="commandList" style="max-height: 320px; overflow-y: auto; padding: 8px 0;">
                <!-- Commands populate here -->
            </div>
        </div>
    </div>
</body>
</html>
