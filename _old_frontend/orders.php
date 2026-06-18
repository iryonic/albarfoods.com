<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View your order history, trace Srinagar orchard shipments, download invoices, and rate your organic staples delivery on Al Barr.">
    <title>My Orders - Al Barr | Kashmiri Organic Staples</title>
    
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <link rel="stylesheet" href="assets/css/variables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/components.css?v=<?php echo time(); ?>">

    <style>
        .profile-page-wrap {
            padding: var(--spacing-xxl) 0;
            background-color: var(--color-cream);
            min-height: 80vh;
            position: relative;
            overflow: hidden;
        }

        /* Ambient Glow Spheres */
        .profile-glow {
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.08;
            z-index: 1;
            pointer-events: none;
        }
        .profile-glow-green { background: var(--color-blue-dark); top: -5%; left: -5%; }
        .profile-glow-saffron { background: var(--color-saffron-orange); bottom: -5%; right: -5%; }

        .profile-container {
            max-width: 960px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 5;
            padding: 0 var(--spacing-md);
        }

        .profile-header {
            text-align: center;
            margin-bottom: var(--spacing-xl);
        }

        .profile-title {
            font-family: var(--font-secondary);
            font-size: 2.3rem;
            color: var(--color-blue-dark);
            font-weight: 800;
            margin-bottom: 8px;
        }

        .profile-subtitle {
            color: var(--color-text-secondary);
            font-size: 1.02rem;
        }

        /* Account Switch Tab Layout */
        .profile-grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: var(--spacing-xl);
            align-items: start;
        }

        /* Sidebar Navigation */
        .profile-sidebar {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
            text-align: center;
        }

        .profile-avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: var(--spacing-sm);
        }

        .profile-avatar-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: var(--color-blue-dark);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            font-family: var(--font-secondary);
            font-weight: 700;
            border: 4px solid #fff;
            box-shadow: var(--shadow-md);
            position: relative;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .profile-avatar-circle:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 24px rgba(1, 136, 73, 0.2);
        }

        .profile-avatar-edit-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--color-saffron-orange);
            color: #fff;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            border: 2px solid #fff;
        }

        .profile-user-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--color-text-primary);
            margin: 0;
        }

        .profile-user-role {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--color-saffron-orange);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: -6px;
        }

        .profile-side-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: left;
        }

        .profile-side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--color-text-secondary);
            font-weight: 600;
            font-size: 0.92rem;
            transition: var(--transition-fast);
            cursor: pointer;
        }

        .profile-side-link:hover {
            background-color: rgba(1, 136, 73, 0.05);
            color: var(--color-blue-dark);
        }

        .profile-side-link.active {
            background-color: var(--color-blue-dark);
            color: #fff;
        }

        /* Order Cards List */
        .orders-list-container {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
        }

        .order-history-card {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: transform var(--transition-fast), box-shadow var(--transition-fast);
        }

        .order-history-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(11, 19, 17, 0.06);
        }

        .order-card-header {
            background-color: var(--color-cream-light);
            border-bottom: 1px solid var(--color-border-light);
            padding: var(--spacing-md) var(--spacing-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .order-header-info {
            display: flex;
            gap: var(--spacing-lg);
            flex-wrap: wrap;
        }

        .order-header-meta {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .order-meta-lbl {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-meta-val {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--color-text-primary);
        }

        .order-id-val {
            font-family: monospace;
            font-size: 0.95rem;
            letter-spacing: 0.2px;
            color: var(--color-blue-dark);
        }

        .order-status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-placed { background: #E6F5EC; color: #018849; }
        .status-processed { background: #FFF8E1; color: #FF8F00; }
        .status-shipped { background: #FFF3E0; color: #FF5500; }
        .status-out { background: #E3F2FD; color: #0D47A1; }
        .status-delivered { background: #E8F5E9; color: #2E7D32; }
        .status-cancelled { background: #FFEBEE; color: #C62828; }

        .order-card-body {
            padding: var(--spacing-lg);
        }

        .order-items-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }

        .order-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--spacing-md);
            padding-bottom: var(--spacing-sm);
            border-bottom: 1px dashed var(--color-border-light);
        }

        .order-item-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .order-item-details {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .order-item-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: contain;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border-light);
        }

        .order-item-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--color-text-primary);
        }

        .order-item-meta {
            font-size: 0.78rem;
            color: var(--color-text-muted);
            margin-top: 1px;
        }

        .order-item-price {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--color-text-primary);
        }

        .order-card-footer {
            border-top: 1px solid var(--color-border-light);
            padding: var(--spacing-md) var(--spacing-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--spacing-md);
            background-color: #fafbfc;
        }

        .order-footer-total {
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-blue-dark);
        }

        .order-footer-total span {
            color: var(--color-text-secondary);
            font-weight: 500;
            font-size: 0.88rem;
            margin-right: 4px;
        }

        .order-actions-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-order-action {
            padding: 8px 16px;
            font-size: 0.82rem;
            font-weight: 700;
            border-radius: var(--radius-xs);
            cursor: pointer;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid transparent;
            font-family: var(--font-secondary);
        }

        .btn-action-primary {
            background: var(--color-saffron-gradient);
            color: #fff;
            box-shadow: 0 4px 10px rgba(255, 85, 0, 0.15);
        }

        .btn-action-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(255, 85, 0, 0.25);
        }

        .btn-action-secondary {
            background: #fff;
            border-color: var(--color-border);
            color: var(--color-text-primary);
        }

        .btn-action-secondary:hover {
            background-color: var(--color-cream);
            border-color: var(--color-text-secondary);
        }

        .btn-action-danger {
            background: #fff;
            border-color: #ffcdd2;
            color: #c62828;
        }

        .btn-action-danger:hover {
            background-color: #ffebee;
            border-color: #e57373;
        }

        /* Delivered Ratings Panel */
        .rating-feedback-row {
            margin-top: var(--spacing-sm);
            padding: 10px var(--spacing-md);
            background-color: #f7f9f6;
            border-radius: var(--radius-xs);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            border: 1px solid rgba(1, 136, 73, 0.08);
        }

        .rating-feedback-lbl {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--color-blue-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-stars-interactive {
            display: flex;
            gap: 4px;
        }

        .star-item {
            font-size: 1.2rem;
            color: var(--color-border);
            cursor: pointer;
            transition: transform 0.15s ease, color 0.15s ease;
        }

        .star-item:hover {
            transform: scale(1.15);
        }

        .star-item.selected {
            color: #FFB300;
        }

        /* Empty State */
        .orders-empty-state {
            text-align: center;
            padding: var(--spacing-xxl) var(--spacing-md);
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 24px;
            box-shadow: var(--shadow-md);
        }

        .empty-state-icon {
            font-size: 3.5rem;
            margin-bottom: var(--spacing-md);
        }

        .empty-state-title {
            font-family: var(--font-secondary);
            font-size: 1.4rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .empty-state-text {
            color: var(--color-text-secondary);
            font-size: 0.95rem;
            max-width: 400px;
            margin: 0 auto var(--spacing-lg) auto;
            line-height: 1.45;
        }

        .btn-empty-shop {
            display: inline-flex;
            padding: 12px 28px;
            background: var(--color-saffron-gradient);
            color: #fff;
            border-radius: var(--radius-xs);
            font-weight: 700;
            font-family: var(--font-secondary);
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
            transition: var(--transition-fast);
        }

        .btn-empty-shop:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
        }

        /* Modal Overlay for cancel order */
        .cancel-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(11, 25, 44, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-md);
        }

        .cancel-modal-card {
            background-color: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--color-border);
            overflow: hidden;
            animation: modalScaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes modalScaleUp {
            from { opacity: 0; transform: scale(0.92); }
            to { opacity: 1; transform: scale(1); }
        }

        .cancel-modal-header {
            padding: var(--spacing-lg) var(--spacing-lg) 10px var(--spacing-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cancel-modal-title {
            font-family: var(--font-secondary);
            font-size: 1.25rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin: 0;
        }

        .cancel-modal-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--color-text-muted);
        }

        .cancel-modal-body {
            padding: 0 var(--spacing-lg) var(--spacing-lg) var(--spacing-lg);
        }

        .cancel-modal-text {
            font-size: 0.92rem;
            color: var(--color-text-secondary);
            line-height: 1.5;
            margin-bottom: var(--spacing-md);
        }

        .cancel-reason-input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-xs);
            font-size: 0.9rem;
            color: var(--color-text-primary);
            margin-bottom: var(--spacing-md);
            resize: none;
        }

        .cancel-reason-input:focus {
            border-color: var(--color-blue-medium);
            outline: none;
        }

        .cancel-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: var(--spacing-md) var(--spacing-lg);
            background-color: var(--color-cream-light);
            border-top: 1px solid var(--color-border-light);
        }

        .btn-modal-cancel {
            padding: 9px 18px;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: var(--radius-xs);
            cursor: pointer;
            border: 1.5px solid var(--color-border);
            background-color: #fff;
            color: var(--color-text-primary);
        }

        .btn-modal-confirm {
            padding: 9px 18px;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: var(--radius-xs);
            cursor: pointer;
            border: none;
            background-color: #c62828;
            color: #fff;
            box-shadow: 0 4px 10px rgba(198, 40, 40, 0.2);
        }

        /* Invoice Iframe Container (Hidden) */
        #invoice-print-frame {
            display: none;
        }

        /* Guest State / Logged-out Card */
        .profile-guest-card {
            max-width: 500px;
            margin: var(--spacing-xxl) auto;
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 24px;
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .guest-icon {
            font-size: 3.5rem;
            margin-bottom: var(--spacing-md);
        }

        .guest-title {
            font-family: var(--font-secondary);
            font-size: 1.5rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .guest-text {
            color: var(--color-text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: var(--spacing-lg);
        }

        .guest-buttons {
            display: flex;
            gap: var(--spacing-md);
            justify-content: center;
        }

        .btn-guest-signin {
            padding: 12px 28px;
            background-color: var(--color-blue-dark);
            color: #fff;
            border-radius: var(--radius-xs);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .btn-guest-signin:hover {
            background-color: var(--color-blue-medium);
        }

        .btn-guest-signup {
            padding: 12px 28px;
            border: 1.5px solid var(--color-border);
            color: var(--color-blue-dark);
            border-radius: var(--radius-xs);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .btn-guest-signup:hover {
            background-color: var(--color-cream);
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
            .order-card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .order-card-footer {
                flex-direction: column;
                align-items: flex-start;
            }
            .order-actions-group {
                width: 100%;
            }
            .btn-order-action {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

    <main class="profile-page-wrap">
        <!-- Floating spheres -->
        <div class="profile-glow profile-glow-green"></div>
        <div class="profile-glow profile-glow-saffron"></div>

        <div class="profile-container">
            
            <!-- Guest View (shown if no session) -->
            <div class="profile-guest-card" id="profile-guest-view" style="display: none;">
                <div class="guest-icon">🔒</div>
                <h2 class="guest-title">Secure Portal Area</h2>
                <p class="guest-text">Please sign in or create an Al Barr organic family account to review preferences, manage shipping locations, and trace your orchard deliveries.</p>
                <div class="guest-buttons">
                    <a href="signin.php?redirect=orders.php" class="btn-guest-signin">Sign In</a>
                    <a href="signup.php?redirect=orders.php" class="btn-guest-signup">Sign Up</a>
                </div>
            </div>

            <!-- Logged-in Dashboard View -->
            <div id="profile-dashboard-view" style="display: none;">
                <div class="profile-header">
                    <h1 class="profile-title">My Orders</h1>
                    <p class="profile-subtitle">Track shipment checkpoints, cancel active packages, download itemized tax receipts, and leave feedback.</p>
                </div>

                <div class="profile-grid">
                    
                    <!-- Left: Navigation Sidebar -->
                    <aside class="profile-sidebar">
                        <div class="profile-avatar-section">
                            <div class="profile-avatar-circle" id="profile-avatar-img" onclick="triggerAvatarRegen()">
                                K
                                <div class="profile-avatar-edit-badge" title="Regenerate theme background">♻️</div>
                            </div>
                            <h3 class="profile-user-name" id="profile-display-name">Kashmiri Patron</h3>
                            <span class="profile-user-role">Al Barr Patron</span>
                        </div>

                        <ul class="profile-side-menu">
                            <li><a href="profile.php" class="profile-side-link">👤 Personal Profile</a></li>
                            <li><a href="orders.php" class="profile-side-link active">📦 My Orders</a></li>
                            <li><a href="wishlist.php" class="profile-side-link">❤️ My Wishlist</a></li>
                            <li><a href="track-order.php" class="profile-side-link">📍 Track Shipment</a></li>
                            <li><a href="#" onclick="handleHeaderSignOut(event)" class="profile-side-link" style="color: var(--color-red);">🚪 Sign Out</a></li>
                        </ul>
                    </aside>

                    <!-- Right: Orders History list -->
                    <div class="orders-list-container" id="orders-list-container">
                        <!-- Dynamic Order Cards Go Here -->
                    </div>

                </div>

            </div>

        </div>
    </main>

    <!-- Cancel Order Confirmation Modal -->
    <div class="cancel-modal-overlay" id="cancel-modal">
        <div class="cancel-modal-card">
            <div class="cancel-modal-header">
                <h3 class="cancel-modal-title">Confirm Order Cancellation</h3>
                <button class="cancel-modal-close" onclick="closeCancelModal()">×</button>
            </div>
            <div class="cancel-modal-body">
                <p class="cancel-modal-text">Are you sure you want to cancel this order? Once cancelled, the orchard dispatch pipeline is halted immediately.</p>
                <label for="cancel-reason" class="order-meta-lbl" style="display:block; margin-bottom: 6px;">Reason for Cancellation (Optional)</label>
                <textarea id="cancel-reason" rows="3" class="cancel-reason-input" placeholder="e.g. Ordered incorrect weight / Changed mind"></textarea>
            </div>
            <div class="cancel-modal-footer">
                <button class="btn-modal-cancel" onclick="closeCancelModal()">Keep Order</button>
                <button class="btn-modal-confirm" id="btn-confirm-cancel-action">Cancel Order</button>
            </div>
        </div>
    </div>

    <!-- Hidden iframe for silent printing of invoice -->
    <iframe id="invoice-print-frame"></iframe>

    <!-- Sidebar Cart, Toasters, and Footer -->
    <?php include 'includes/sidebar-cart.php'; ?>
    <div class="toast-container" id="toast-container"></div>
    <?php include 'includes/footer.php'; ?>

    <script>
        let currentCancelOrderId = null;
        const AVATAR_PALETTES = [
            { bg: '#018849', color: '#ffffff' },
            { bg: '#FF5500', color: '#ffffff' },
            { bg: '#FFB300', color: '#000000' },
            { bg: '#0b192c', color: '#ffffff' },
            { bg: '#4a3f35', color: '#ffffff' }
        ];

        document.addEventListener('DOMContentLoaded', () => {
            const userJson = localStorage.getItem('al_barr_user');
            
            if (!userJson) {
                document.getElementById('profile-guest-view').style.display = 'block';
                return;
            }

            let userData;
            try {
                userData = JSON.parse(userJson);
                if (!userData || !userData.loggedIn) {
                    document.getElementById('profile-guest-view').style.display = 'block';
                    return;
                }
            } catch(e) {
                console.error("Failed to parse user details", e);
                document.getElementById('profile-guest-view').style.display = 'block';
                return;
            }

            // Show active profile
            document.getElementById('profile-dashboard-view').style.display = 'block';

            // Display metadata
            document.getElementById('profile-display-name').innerText = userData.name || 'Al Barr Patron';
            
            // Generate letter avatar
            const firstLetter = (userData.name || 'A').charAt(0).toUpperCase();
            const avatarDiv = document.getElementById('profile-avatar-img');
            avatarDiv.innerHTML = `${firstLetter}<div class="profile-avatar-edit-badge" title="Regenerate theme background">♻️</div>`;
            
            // Restore avatar color choice if saved
            const savedColorIdx = localStorage.getItem('al_barr_avatar_color_idx') || 0;
            applyAvatarPalette(savedColorIdx);

            // Load and render orders list
            loadAndRenderOrders(userData);
        });

        function applyAvatarPalette(idx) {
            const palette = AVATAR_PALETTES[idx] || AVATAR_PALETTES[0];
            const avatarDiv = document.getElementById('profile-avatar-img');
            if (avatarDiv) {
                avatarDiv.style.backgroundColor = palette.bg;
                avatarDiv.style.color = palette.color;
            }
        }

        // Letter avatar color randomiser
        function triggerAvatarRegen() {
            const currentIdx = parseInt(localStorage.getItem('al_barr_avatar_color_idx') || 0);
            const nextIdx = (currentIdx + 1) % AVATAR_PALETTES.length;
            localStorage.setItem('al_barr_avatar_color_idx', nextIdx);
            applyAvatarPalette(nextIdx);
            
            if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                AlBarrCart.showToast('Profile theme accent updated!');
            }
        }

        // Fetch orders, seed if empty, and render
        function loadAndRenderOrders(userData) {
            let orders = [];
            const savedOrders = localStorage.getItem('al_barr_orders');
            
            if (savedOrders) {
                try {
                    orders = JSON.parse(savedOrders);
                } catch(e) {
                    console.error("Failed to parse orders list from localStorage", e);
                }
            }

            // Seed mock orders if empty to make the page look premium and active immediately
            if (orders.length === 0) {
                const userAddressCombined = `${userData.address || 'Zakura'}, ${userData.city || 'Srinagar'}, J&K - ${userData.pincode || '190006'}`;
                orders = [
                    {
                        orderId: 'ALB-9831-KASH',
                        date: 'May 20, 2026',
                        status: 'Shipped',
                        estDelivery: 'May 23, 2026',
                        partner: 'Al Barr Express Logistics',
                        consignment: 'ABE-839210-KASH',
                        paymentMethod: 'Direct J&K Bank Transfer',
                        shippingName: userData.name || 'Al Barr Patron',
                        shippingPhone: userData.phone || '9419012345',
                        shippingAddress: userAddressCombined,
                        subtotal: 2600.00,
                        discount: 0.00,
                        delivery: 60.00,
                        grandTotal: 2660.00,
                        items: [
                            { image: 'assets/img/products/product2.png', title: 'Kashmiri Mogra Saffron', weight: '1g', qty: 2, price: 350.00 },
                            { image: 'assets/img/products/product1.png', title: 'Premium Mamra Almonds', weight: '500g', qty: 1, price: 1450.00 },
                            { image: 'assets/img/products/product3.png', title: 'Pure Organic White Honey', weight: '250g', qty: 1, price: 450.00 }
                        ],
                        route: [
                            { location: 'Near Pampore Toll Plaza', time: 'May 21, 2026, 02:40 PM', desc: 'Consignment in transit via local highway carrier. Heading towards Pampore bypass point.', completed: true, active: true },
                            { location: 'Srinagar Central Sorting Hub', time: 'May 21, 2026, 09:00 AM', desc: 'Consignment departed from central hub. Dispatched via Express truck.', completed: true, active: false },
                            { location: 'Processed Hub, Srinagar', time: 'May 20, 2026, 04:15 PM', desc: 'Hygiene checks cleared. Custom saffron seal applied to box.', completed: true, active: false },
                            { location: 'Orchard Processing Center, Srinagar', time: 'May 20, 2026, 10:30 AM', desc: 'Order received and verification completed.', completed: true, active: false }
                        ]
                    },
                    {
                        orderId: 'ALB-1045-KASH',
                        date: 'May 18, 2026',
                        status: 'Delivered',
                        estDelivery: 'May 20, 2026 (Delivered)',
                        partner: 'Delhivery J&K',
                        consignment: 'DEL-9201928-KASH',
                        paymentMethod: 'Cash on Delivery (COD)',
                        shippingName: userData.name || 'Al Barr Patron',
                        shippingPhone: userData.phone || '9419012345',
                        shippingAddress: userAddressCombined,
                        subtotal: 1420.00,
                        discount: 0.00,
                        delivery: 60.00,
                        grandTotal: 1480.00,
                        items: [
                            { image: 'assets/img/products/product5.png', title: 'Kashmiri Walnuts Shell-less', weight: '500g', qty: 2, price: 550.00 },
                            { image: 'assets/img/products/product6.png', title: 'Organic Kesar Kehwa Tea', weight: '250g', qty: 1, price: 320.00 }
                        ],
                        rating: 5, // pre-rated
                        route: [
                            { location: 'Delivered Gateway (Delivered)', time: 'May 20, 2026, 03:40 PM', desc: 'Order successfully delivered to customer. Payment collected via UPI.', completed: true, active: true },
                            { location: 'Out for Delivery - Srinagar Hub', time: 'May 20, 2026, 10:15 AM', desc: 'Order assigned to local delivery courier for doorstep dispatch.', completed: true, active: false },
                            { location: 'Srinagar Sorting Hub', time: 'May 19, 2026, 11:30 AM', desc: 'Consignment received at regional sorting hub.', completed: true, active: false },
                            { location: 'Orchard Processing Center, Srinagar', time: 'May 18, 2026, 11:00 AM', desc: 'Order received and packaged.', completed: true, active: false }
                        ]
                    }
                ];
                localStorage.setItem('al_barr_orders', JSON.stringify(orders));
            }

            renderOrders(orders, userData.phone || '9419012345');
        }

        // Render orders array to DOM
        function renderOrders(orders, userPhone) {
            const container = document.getElementById('orders-list-container');
            container.innerHTML = '';

            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="orders-empty-state">
                        <div class="empty-state-icon">📦</div>
                        <h3 class="empty-state-title">No Orders Placed Yet</h3>
                        <p class="empty-state-text">Your kitchen shelves are waiting for Al Barr organic staples! Visit our shop to get fresh Mamra almonds, saffron, and kehwa.</p>
                        <a href="shop.php" class="btn-empty-shop">Browse Products</a>
                    </div>
                `;
                return;
            }

            orders.forEach((order, idx) => {
                const card = document.createElement('div');
                card.className = 'order-history-card';
                card.setAttribute('data-order-id', order.orderId);

                // Build status class & badge icon
                let statusClass = 'status-placed';
                let statusIcon = '📥';
                if (order.status === 'Processed') { statusClass = 'status-processed'; statusIcon = '⚙️'; }
                else if (order.status === 'Shipped') { statusClass = 'status-shipped'; statusIcon = '🚚'; }
                else if (order.status === 'Out for Delivery') { statusClass = 'status-out'; statusIcon = '🏍️'; }
                else if (order.status === 'Delivered') { statusClass = 'status-delivered'; statusIcon = '🎁'; }
                else if (order.status === 'Cancelled') { statusClass = 'status-cancelled'; statusIcon = '❌'; }

                // Build items rows HTML
                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <div class="order-item-row">
                            <div class="order-item-details">
                                <img src="${item.image}" alt="${item.title}" class="order-item-thumb">
                                <div>
                                    <div class="order-item-name">${item.title}</div>
                                    <div class="order-item-meta">Weight: ${item.weight} | Qty: ${item.qty}</div>
                                </div>
                            </div>
                            <span class="order-item-price">₹${(item.price * item.qty).toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                        </div>
                    `;
                });

                // Action buttons based on status
                let actionsHtml = '';
                
                // Invoice button is always available unless cancelled before processing
                actionsHtml += `<button class="btn-order-action btn-action-secondary" onclick="printInvoice('${order.orderId}')">📄 Invoice</button>`;
                
                // Track button is available unless cancelled
                if (order.status !== 'Cancelled') {
                    actionsHtml += `<a href="track-order.php?id=${order.orderId}&contact=${userPhone}" class="btn-order-action btn-action-primary">📍 Track Order</a>`;
                }

                // Cancel button only for Placed or Processed status
                if (order.status === 'Placed' || order.status === 'Processed') {
                    actionsHtml += `<button class="btn-order-action btn-action-danger" onclick="triggerCancelModal('${order.orderId}')">❌ Cancel</button>`;
                }

                // Rating Panel for delivered items
                let ratingFeedbackPanelHtml = '';
                if (order.status === 'Delivered') {
                    const savedRating = order.rating || 0;
                    ratingFeedbackPanelHtml = `
                        <div class="rating-feedback-row">
                            <span class="rating-feedback-lbl">🌟 ${savedRating > 0 ? 'Your quality rating:' : 'Rate food freshness & delivery:'}</span>
                            <div class="rating-stars-interactive" data-order-id="${order.orderId}">
                                ${[1, 2, 3, 4, 5].map(starNum => `
                                    <span class="star-item ${starNum <= savedRating ? 'selected' : ''}" 
                                          onclick="saveOrderRating('${order.orderId}', ${starNum})" 
                                          title="Rate ${starNum} Stars">★</span>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                card.innerHTML = `
                    <div class="order-card-header">
                        <div class="order-header-info">
                            <div class="order-header-meta">
                                <span class="order-meta-lbl">Order Placed</span>
                                <span class="order-meta-val">${order.date}</span>
                            </div>
                            <div class="order-header-meta">
                                <span class="order-meta-lbl">Total Price</span>
                                <span class="order-meta-val">₹${order.grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                            </div>
                            <div class="order-header-meta">
                                <span class="order-meta-lbl">Order ID</span>
                                <span class="order-meta-val order-id-val">${order.orderId}</span>
                            </div>
                        </div>
                        <span class="order-status-badge ${statusClass}">
                            ${statusIcon} ${order.status}
                        </span>
                    </div>
                    <div class="order-card-body">
                        <div class="order-items-list">
                            ${itemsHtml}
                        </div>
                        ${ratingFeedbackPanelHtml}
                    </div>
                    <div class="order-card-footer">
                        <div class="order-footer-total">
                            <span>Paid via:</span> ${order.paymentMethod}
                        </div>
                        <div class="order-actions-group">
                            ${actionsHtml}
                        </div>
                    </div>
                `;

                container.appendChild(card);
            });
        }

        // Cancel order modal handlers
        function triggerCancelModal(orderId) {
            currentCancelOrderId = orderId;
            document.getElementById('cancel-reason').value = '';
            document.getElementById('cancel-modal').style.display = 'flex';
        }

        function closeCancelModal() {
            document.getElementById('cancel-modal').style.display = 'none';
            currentCancelOrderId = null;
        }

        // Action cancellation handler
        document.getElementById('btn-confirm-cancel-action').addEventListener('click', () => {
            if (!currentCancelOrderId) return;
            
            const savedOrders = localStorage.getItem('al_barr_orders');
            if (savedOrders) {
                try {
                    let orders = JSON.parse(savedOrders);
                    const idx = orders.findIndex(o => o.orderId === currentCancelOrderId);
                    if (idx !== -1) {
                        orders[idx].status = 'Cancelled';
                        orders[idx].route.unshift({
                            location: 'Orchard Processing Center, Srinagar',
                            time: new Date().toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }),
                            desc: `Order cancelled by customer. Reason: ${document.getElementById('cancel-reason').value.trim() || 'No reason provided'}.`,
                            completed: true,
                            active: true
                        });
                        localStorage.setItem('al_barr_orders', JSON.stringify(orders));
                        
                        // Re-render
                        const userJson = localStorage.getItem('al_barr_user');
                        if (userJson) {
                            const userData = JSON.parse(userJson);
                            loadAndRenderOrders(userData);
                        }

                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast(`Order ${currentCancelOrderId} cancelled successfully.`, 'error');
                        } else {
                            alert(`Order ${currentCancelOrderId} cancelled successfully.`);
                        }
                    }
                } catch(e) {
                    console.error("Failed to cancel order", e);
                }
            }
            closeCancelModal();
        });

        // Save rating feedback
        function saveOrderRating(orderId, ratingVal) {
            const savedOrders = localStorage.getItem('al_barr_orders');
            if (savedOrders) {
                try {
                    let orders = JSON.parse(savedOrders);
                    const idx = orders.findIndex(o => o.orderId === orderId);
                    if (idx !== -1) {
                        orders[idx].rating = ratingVal;
                        localStorage.setItem('al_barr_orders', JSON.stringify(orders));
                        
                        // Show toast feedback
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast(`Thank you for rating 5/5 stars for freshness!`, 'success');
                        } else {
                            alert(`Thank you for rating this order ${ratingVal}/5 stars!`);
                        }

                        // Re-render
                        const userJson = localStorage.getItem('al_barr_user');
                        if (userJson) {
                            const userData = JSON.parse(userJson);
                            loadAndRenderOrders(userData);
                        }
                    }
                } catch(e) {
                    console.error("Failed to save rating", e);
                }
            }
        }

        // Print Invoice Simulation
        function printInvoice(orderId) {
            let orders = [];
            const savedOrders = localStorage.getItem('al_barr_orders');
            if (savedOrders) {
                try {
                    orders = JSON.parse(savedOrders);
                } catch(e) {}
            }

            const order = orders.find(o => o.orderId === orderId);
            if (!order) {
                alert("Order details not found to generate receipt.");
                return;
            }

            const invoiceHtml = `
            <html>
            <head>
                <title>Invoice - ${order.orderId}</title>
                <style>
                    body { font-family: 'Segoe UI', Arial, sans-serif; padding: 30px; color: #333; line-height: 1.5; }
                    .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #018849; padding-bottom: 20px; margin-bottom: 30px; }
                    .brand-name { font-size: 24px; font-weight: bold; color: #018849; }
                    .brand-tagline { font-size: 12px; color: #666; display: block; }
                    .invoice-title { font-size: 28px; font-weight: bold; text-align: right; color: #FF5500; }
                    .metadata { margin-bottom: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
                    .metadata h4 { margin: 0 0 8px 0; color: #018849; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
                    .table-items { width: 100%; border-collapse: collapse; margin-bottom: 35px; }
                    .table-items th { background-color: #f2f6f3; text-align: left; padding: 12px; font-size: 13px; font-weight: 700; color: #333; border-bottom: 2px solid #018849; }
                    .table-items td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
                    .financial-summary { display: flex; justify-content: flex-end; margin-top: 20px; }
                    .summary-box { width: 300px; background-color: #fafbfc; border: 1px solid #e1e8e4; padding: 15px; border-radius: 8px; }
                    .summary-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
                    .summary-row.total { border-top: 1px solid #ccc; padding-top: 8px; font-size: 18px; font-weight: bold; color: #018849; }
                    .footer-regulatory { border-top: 1px solid #ddd; margin-top: 40px; padding-top: 15px; font-size: 11px; color: #777; text-align: center; }
                    .verified-stamp { border: 2px solid #018849; color: #018849; padding: 5px 10px; font-weight: bold; border-radius: 5px; transform: rotate(-5deg); display: inline-block; font-size: 12px; margin-top: 10px; }
                </style>
            </head>
            <body>
                <div class="invoice-header">
                    <div>
                        <div class="brand-name">AL BARR</div>
                        <span class="brand-tagline">Khalis Wa Shifaf • Kashmiri Organic Staples</span>
                        <div class="verified-stamp">ORIGIN ASSURED</div>
                    </div>
                    <div>
                        <div class="invoice-title">TAX INVOICE</div>
                        <div style="font-size: 13px; text-align: right; margin-top: 5px;">
                            <strong>Invoice No:</strong> INV-${order.orderId.replace('ALB-', '')}<br>
                            <strong>Date:</strong> ${order.date}<br>
                            <strong>Status:</strong> ${order.status.toUpperCase()}
                        </div>
                    </div>
                </div>

                <div class="metadata">
                    <div>
                        <h4>Seller Address</h4>
                        <strong>Al Barr Staples Private Ltd.</strong><br>
                        Orchard Processing Center, Ganderbal Bypass,<br>
                        Srinagar, Jammu & Kashmir - 190006<br>
                        GSTIN: 01ACFFM4729H1ZF • FSSAI: 11025430000232
                    </div>
                    <div>
                        <h4>Shipping Address</h4>
                        <strong>${order.shippingName}</strong><br>
                        Phone: ${order.shippingPhone}<br>
                        ${order.shippingAddress}<br>
                        Payment Preference: ${order.paymentMethod}
                    </div>
                </div>

                <table class="table-items">
                    <thead>
                        <tr>
                            <th>Product Description</th>
                            <th>Weight</th>
                            <th style="text-align: right;">Unit Price</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${order.items.map(item => `
                            <tr>
                                <td><strong>${item.title}</strong></td>
                                <td>${item.weight}</td>
                                <td style="text-align: right;">₹${item.price.toFixed(2)}</td>
                                <td style="text-align: center;">${item.qty}</td>
                                <td style="text-align: right;">₹${(item.price * item.qty).toFixed(2)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>

                <div class="financial-summary">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>₹${order.subtotal.toFixed(2)}</span>
                        </div>
                        ${order.discount > 0 ? `
                        <div class="summary-row" style="color: #018849;">
                            <span>Promo Discount:</span>
                            <span>-₹${order.discount.toFixed(2)}</span>
                        </div>` : ''}
                        <div class="summary-row">
                            <span>Delivery Fee:</span>
                            <span>${order.delivery === 0 ? 'FREE' : '₹' + order.delivery.toFixed(2)}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Grand Total:</span>
                            <span>₹${order.grandTotal.toFixed(2)}</span>
                        </div>
                    </div>
                </div>

                <div class="footer-regulatory">
                    This is an electronically generated invoice and does not require physical signature. Raw materials sourced from organic farms of Srinagar, Pampore, and Ganderbal valleys.<br>
                    <strong>Thank you for choosing local organic agriculture!</strong>
                </div>
            </body>
            </html>
            `;

            const iframe = document.getElementById('invoice-print-frame');
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            iframeDoc.open();
            iframeDoc.write(invoiceHtml);
            iframeDoc.close();

            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 500);
        }
    </script>
</body>
</html>
