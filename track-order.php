<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Track your Al Barr organic staples order. Enter your Order ID to view real-time delivery status and route checkpoints from our Srinagar hub.">
    <title>Track Order - Al Barr | Kashmiri Organic Staples</title>
    
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <link rel="stylesheet" href="assets/css/variables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/components.css?v=<?php echo time(); ?>">

    <style>
        .track-page-wrap {
            padding: var(--spacing-xxl) 0;
            background-color: var(--color-cream);
            min-height: 80vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        /* Ambient Glowing Blobs */
        .track-glow-bg {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(130px);
            opacity: 0.1;
            z-index: 1;
            pointer-events: none;
        }
        .track-glow-green {
            background: var(--color-blue-dark);
            top: -10%;
            left: -10%;
            animation: trackGlowPulse 14s ease-in-out infinite alternate;
        }
        .track-glow-saffron {
            background: var(--color-saffron-orange);
            bottom: -10%;
            right: -10%;
            animation: trackGlowPulse 16s ease-in-out infinite alternate-reverse;
        }

        @keyframes trackGlowPulse {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.15) translate(40px, -30px); }
        }

        .track-container {
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 5;
            padding: 0 var(--spacing-md);
        }

        .track-header {
            text-align: center;
            margin-bottom: var(--spacing-xl);
            animation: trackFadeIn 0.6s ease-out both;
        }

        .track-title {
            font-family: var(--font-secondary);
            font-size: 2.4rem;
            color: var(--color-blue-dark);
            font-weight: 800;
            margin-bottom: 8px;
        }

        .track-subtitle {
            color: var(--color-text-secondary);
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Lookup Glassmorphic Card */
        .track-search-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: var(--spacing-xl) var(--spacing-lg);
            box-shadow: 0 20px 45px rgba(11, 19, 17, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.6);
            margin-bottom: var(--spacing-xl);
            animation: trackFadeIn 0.8s ease-out both;
        }

        .track-search-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: var(--spacing-md);
            align-items: flex-end;
        }

        .track-input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            text-align: left;
        }

        .track-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .track-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .track-input-icon {
            position: absolute;
            left: 14px;
            color: var(--color-text-muted);
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .track-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-xs);
            font-size: 0.95rem;
            color: var(--color-text-primary);
            transition: var(--transition-fast);
        }

        .track-input:focus {
            border-color: var(--color-blue-medium);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(2, 154, 77, 0.1);
            outline: none;
        }

        .btn-track-submit {
            height: 48px;
            padding: 0 28px;
            background: var(--color-saffron-gradient);
            color: #fff;
            border: none;
            border-radius: var(--radius-xs);
            font-weight: 700;
            font-family: var(--font-secondary);
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition-fast);
            box-shadow: 0 4px 14px rgba(255, 85, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-track-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 85, 0, 0.3);
        }

        .btn-track-submit:active {
            transform: translateY(1px);
        }

        /* Results Card */
        .track-results-wrap {
            margin-top: var(--spacing-xl);
            display: none;
            flex-direction: column;
            gap: var(--spacing-lg);
            animation: trackFadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .results-summary-card {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 20px;
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .results-summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--color-gold-gradient);
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid var(--color-border-light);
            padding-bottom: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
            flex-wrap: wrap;
            gap: var(--spacing-md);
        }

        .summary-title-block {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .summary-order-id {
            font-family: monospace;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-blue-dark);
            letter-spacing: 0.5px;
        }

        .summary-order-date {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
        }

        .summary-status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-placed { background: #E6F5EC; color: #018849; }
        .status-processed { background: #FFF8E1; color: #FF8F00; }
        .status-shipped { background: #FFF3E0; color: #FF5500; }
        .status-out { background: #E3F2FD; color: #0D47A1; }
        .status-delivered { background: #E8F5E9; color: #2E7D32; }

        .summary-details-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
        }

        .summary-grid-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .grid-item-lbl {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .grid-item-val {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--color-text-primary);
        }

        /* Stepper Widget */
        .stepper-container {
            position: relative;
            padding: var(--spacing-md) 0 var(--spacing-lg) 0;
            margin-bottom: var(--spacing-lg);
        }

        .stepper-progress-bar {
            position: absolute;
            top: 28px;
            left: 5%;
            width: 90%;
            height: 5px;
            background-color: var(--color-border-light);
            z-index: 1;
            border-radius: 3px;
        }

        .stepper-progress-fill {
            height: 100%;
            background: var(--color-gold-gradient);
            width: 0%;
            border-radius: 3px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stepper-nodes {
            position: relative;
            display: flex;
            justify-content: space-between;
            z-index: 2;
        }

        .stepper-node {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 18%;
        }

        .stepper-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #fff;
            border: 3.5px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--color-text-muted);
            transition: var(--transition-normal);
            box-shadow: var(--shadow-sm);
        }

        .stepper-node.active .stepper-circle {
            border-color: var(--color-blue-medium);
            color: var(--color-blue-dark);
            background-color: var(--color-blue-light);
            box-shadow: 0 0 0 6px rgba(2, 154, 77, 0.15);
        }

        .stepper-node.completed .stepper-circle {
            border-color: var(--color-blue-dark);
            background-color: var(--color-blue-dark);
            color: #fff;
            box-shadow: var(--shadow-sm);
        }

        .stepper-node.completed .stepper-circle svg {
            stroke: #fff;
        }

        .stepper-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--color-text-secondary);
            margin-top: 10px;
            transition: var(--transition-fast);
        }

        .stepper-node.active .stepper-label {
            color: var(--color-blue-dark);
            font-weight: 800;
        }

        .stepper-node.completed .stepper-label {
            color: var(--color-text-primary);
        }

        .stepper-date {
            font-size: 0.72rem;
            color: var(--color-text-muted);
            margin-top: 3px;
        }

        /* Kashmiri Delivery Route Section */
        .route-tracking-card {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 20px;
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            text-align: left;
        }

        .route-title {
            font-family: var(--font-secondary);
            font-size: 1.25rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--color-border-light);
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .route-timeline {
            position: relative;
            padding-left: 28px;
            margin-left: 10px;
            border-left: 2px dashed var(--color-border);
        }

        .route-checkpoint {
            position: relative;
            margin-bottom: var(--spacing-lg);
        }

        .route-checkpoint:last-child {
            margin-bottom: 0;
        }

        .checkpoint-dot {
            position: absolute;
            left: -39px;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #fff;
            border: 3.5px solid var(--color-border);
            transition: var(--transition-fast);
        }

        .route-checkpoint.active .checkpoint-dot {
            border-color: var(--color-saffron-orange);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(255, 85, 0, 0.2);
            animation: checkpointPulse 1.5s infinite;
        }

        .route-checkpoint.completed .checkpoint-dot {
            border-color: var(--color-blue-dark);
            background-color: var(--color-blue-dark);
        }

        @keyframes checkpointPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        .checkpoint-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px;
            flex-wrap: wrap;
            gap: 6px;
        }

        .checkpoint-location {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--color-text-primary);
        }

        .route-checkpoint.active .checkpoint-location {
            color: var(--color-saffron-orange);
        }

        .checkpoint-time {
            font-size: 0.78rem;
            color: var(--color-text-muted);
        }

        .checkpoint-desc {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            line-height: 1.4;
        }

        /* Order Items & Receipt Section */
        .track-details-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: var(--spacing-lg);
        }

        .items-receipt-card {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 20px;
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            text-align: left;
        }

        .receipt-title {
            font-family: var(--font-secondary);
            font-size: 1.25rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--color-border-light);
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .receipt-items-list {
            margin-bottom: var(--spacing-md);
        }

        .receipt-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--color-border-light);
        }

        .receipt-item-row:last-child {
            border-bottom: none;
        }

        .receipt-item-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .receipt-item-thumb {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-xs);
            object-fit: contain;
            background-color: var(--color-cream);
            border: 1px solid var(--color-border-light);
        }

        .receipt-item-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text-primary);
        }

        .receipt-item-qty {
            font-size: 0.8rem;
            color: var(--color-text-muted);
            margin-top: 1px;
        }

        .receipt-item-price {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text-primary);
        }

        .receipt-breakdown {
            background-color: var(--color-cream);
            border-radius: var(--radius-xs);
            padding: var(--spacing-md);
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.88rem;
            color: var(--color-text-secondary);
            margin-bottom: 6px;
        }

        .receipt-row:last-child {
            margin-bottom: 0;
        }

        .receipt-row.discount {
            color: var(--color-blue-medium);
            font-weight: 500;
        }

        .receipt-row.total {
            border-top: 1px solid var(--color-border);
            padding-top: 8px;
            margin-top: 8px;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--color-blue-dark);
        }

        .customer-shipping-card {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 20px;
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
        }

        .customer-card-title {
            font-family: var(--font-secondary);
            font-size: 1.25rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            border-bottom: 1px solid var(--color-border-light);
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .customer-info-section {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .customer-info-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .customer-info-val {
            font-size: 0.95rem;
            color: var(--color-text-primary);
            line-height: 1.45;
        }

        /* Empty / Initial State */
        .track-initial-state {
            padding: var(--spacing-xl) 0;
            text-align: center;
            animation: trackFadeIn 0.6s ease-out both;
        }

        .track-initial-icon {
            font-size: 3.5rem;
            margin-bottom: var(--spacing-sm);
        }

        .track-initial-title {
            font-family: var(--font-secondary);
            font-size: 1.4rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin-bottom: 6px;
        }

        .track-initial-text {
            color: var(--color-text-secondary);
            font-size: 0.95rem;
            max-width: 420px;
            margin: 0 auto;
            line-height: 1.45;
        }

        .track-demo-tags {
            margin-top: var(--spacing-md);
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .demo-tag {
            background-color: #fff;
            border: 1px solid var(--color-border);
            color: var(--color-blue-dark);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .demo-tag:hover {
            border-color: var(--color-blue-medium);
            background-color: var(--color-blue-light);
            transform: translateY(-1px);
        }

        /* Animations */
        @keyframes trackFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes trackFadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .track-search-form {
                grid-template-columns: 1fr;
                gap: var(--spacing-sm);
            }
            
            .btn-track-submit {
                width: 100%;
                margin-top: 6px;
            }

            .summary-details-grid {
                grid-template-columns: 1fr;
                gap: var(--spacing-sm);
            }

            .stepper-container {
                overflow-x: auto;
                padding-bottom: var(--spacing-md);
            }

            .stepper-progress-bar {
                width: 650px;
                left: 20px;
            }

            .stepper-nodes {
                width: 700px;
                padding: 0 10px;
            }

            .track-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

    <main class="track-page-wrap">
        <!-- Floating Ambient Background elements -->
        <div class="track-glow-bg track-glow-green"></div>
        <div class="track-glow-bg track-glow-saffron"></div>

        <div class="track-container">
            
            <!-- Header section -->
            <div class="track-header">
                <h1 class="track-title">Track Your Order</h1>
                <p class="track-subtitle">Monitor the journey of your handpicked Kashmiri organic staples from our central orchards hub in Srinagar straight to your doorstep.</p>
            </div>

            <!-- Lookup Form Card -->
            <div class="track-search-card">
                <form class="track-search-form" onsubmit="handleTrackFormSubmit(event)">
                    
                    <!-- Order ID -->
                    <div class="track-input-group">
                        <label for="track-order-id" class="track-label">Order ID *</label>
                        <div class="track-input-wrapper">
                            <span class="track-input-icon">📦</span>
                            <input type="text" id="track-order-id" class="track-input" placeholder="e.g. ALB-9831-KASH" required>
                        </div>
                    </div>

                    <!-- Phone/Email -->
                    <div class="track-input-group">
                        <label for="track-contact" class="track-label">Phone Number or Email *</label>
                        <div class="track-input-wrapper">
                            <span class="track-input-icon">📞</span>
                            <input type="text" id="track-contact" class="track-input" placeholder="e.g. 9419012345" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-track-submit" id="btn-track-submit">
                        <span>🔍</span> Track Order
                    </button>
                    
                </form>
            </div>

            <!-- Initial State Block -->
            <div class="track-initial-state" id="track-initial-view">
                <div class="track-initial-icon">🗺️</div>
                <h3 class="track-initial-title">Real-Time Orchard Tracking</h3>
                <p class="track-initial-text">Enter your order references above to load the live delivery map, route checkpoints, and estimated arrival window. Try one of our demo orders:</p>
                <div class="track-demo-tags">
                    <button class="demo-tag" onclick="useDemoOrder('ALB-2051-KASH', '9419012345')">ALB-2051-KASH (Placed)</button>
                    <button class="demo-tag" onclick="useDemoOrder('ALB-9831-KASH', '9419012345')">ALB-9831-KASH (Shipped)</button>
                    <button class="demo-tag" onclick="useDemoOrder('ALB-1045-KASH', '9419012345')">ALB-1045-KASH (Delivered)</button>
                </div>
            </div>

            <!-- Results Section (Initially Hidden) -->
            <div class="track-results-wrap" id="track-results-view">
                
                <!-- 1. Order summary details -->
                <div class="results-summary-card">
                    <div class="summary-header">
                        <div class="summary-title-block">
                            <span class="summary-order-id" id="res-order-id">ALB-9831-KASH</span>
                            <span class="summary-order-date" id="res-order-date">Ordered on: May 20, 2026</span>
                        </div>
                        <span class="summary-status-badge status-shipped" id="res-status-badge">
                            <span>🚚</span> Shipped
                        </span>
                    </div>

                    <div class="summary-details-grid">
                        <div class="summary-grid-item">
                            <span class="grid-item-lbl">Estimated Delivery</span>
                            <span class="grid-item-val" id="res-est-delivery">May 23, 2026</span>
                        </div>
                        <div class="summary-grid-item">
                            <span class="grid-item-lbl">Shipping Partner</span>
                            <span class="grid-item-val" id="res-partner">Al Barr Express</span>
                        </div>
                        <div class="summary-grid-item">
                            <span class="grid-item-lbl">Consignment Ref</span>
                            <span class="grid-item-val" id="res-consignment" style="font-family: monospace;">ABE-839210-KASH</span>
                        </div>
                    </div>

                    <!-- Stepper Progress Bar widget -->
                    <div class="stepper-container">
                        <div class="stepper-progress-bar">
                            <div class="stepper-progress-fill" id="stepper-fill" style="width: 50%;"></div>
                        </div>
                        <div class="stepper-nodes">
                            <!-- Node 1: Placed -->
                            <div class="stepper-node completed" id="step-node-1">
                                <div class="stepper-circle">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span class="stepper-label">Placed</span>
                                <span class="stepper-date" id="step-date-1">May 20</span>
                            </div>
                            <!-- Node 2: Processed -->
                            <div class="stepper-node completed" id="step-node-2">
                                <div class="stepper-circle">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span class="stepper-label">Processed</span>
                                <span class="stepper-date" id="step-date-2">May 20</span>
                            </div>
                            <!-- Node 3: Shipped -->
                            <div class="stepper-node active" id="step-node-3">
                                <div class="stepper-circle">🚚</div>
                                <span class="stepper-label">Shipped</span>
                                <span class="stepper-date" id="step-date-3">May 21</span>
                            </div>
                            <!-- Node 4: Out for Delivery -->
                            <div class="stepper-node" id="step-node-4">
                                <div class="stepper-circle">🏍️</div>
                                <span class="stepper-label">Out for Delivery</span>
                                <span class="stepper-date" id="step-date-4">-</span>
                            </div>
                            <!-- Node 5: Delivered -->
                            <div class="stepper-node" id="step-node-5">
                                <div class="stepper-circle">🎁</div>
                                <span class="stepper-label">Delivered</span>
                                <span class="stepper-date" id="step-date-5">-</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 2. Detailed route logs and map representation -->
                <div class="route-tracking-card">
                    <h3 class="route-title">
                        <span>📍</span> Kashmiri Route Logs
                    </h3>
                    
                    <div class="route-timeline" id="route-timeline-container">
                        <!-- Checkpoints populated dynamically -->
                    </div>
                </div>

                <!-- 3. Bottom Grid: Items ordered & Customer details -->
                <div class="track-details-grid">
                    
                    <!-- Left: Items Breakdown -->
                    <div class="items-receipt-card">
                        <h3 class="receipt-title">
                            <span>🛍️</span> Itemized Invoice
                        </h3>
                        <div class="receipt-items-list" id="track-items-container">
                            <!-- Populated dynamically -->
                        </div>
                        <div class="receipt-breakdown">
                            <div class="receipt-row">
                                <span>Subtotal</span>
                                <span id="res-subtotal">₹0.00</span>
                            </div>
                            <div class="receipt-row discount" id="res-row-discount" style="display: none;">
                                <span>Promo Discount</span>
                                <span id="res-discount">-₹0.00</span>
                            </div>
                            <div class="receipt-row">
                                <span>Delivery Fee</span>
                                <span id="res-delivery">₹60.00</span>
                            </div>
                            <div class="receipt-row total">
                                <span>Total Paid</span>
                                <span id="res-total">₹0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Customer Shipping address -->
                    <div class="customer-shipping-card">
                        <h3 class="customer-card-title">
                            <span>👤</span> Delivery Credentials
                        </h3>
                        <div class="customer-info-section">
                            <span class="customer-info-label">Recipient</span>
                            <span class="customer-info-val" id="res-shipping-name">Irfan Manzoor</span>
                        </div>
                        <div class="customer-info-section">
                            <span class="customer-info-label">Contact Phone</span>
                            <span class="customer-info-val" id="res-shipping-phone">9419012345</span>
                        </div>
                        <div class="customer-info-section">
                            <span class="customer-info-label">Shipping Address</span>
                            <span class="customer-info-val" id="res-shipping-address">Zakura, Near Kashmir University Campus, Srinagar, J&K - 190006</span>
                        </div>
                        <div class="customer-info-section">
                            <span class="customer-info-label">Payment Mode</span>
                            <span class="customer-info-val" id="res-payment-method">Cash on Delivery (COD)</span>
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

    <!-- Footer Include -->
    <?php include 'includes/footer.php'; ?>

    <script>
        // Database of Pre-baked orders
        const PRE_BAKED_ORDERS = {
            'ALB-2051-KASH': {
                orderId: 'ALB-2051-KASH',
                date: 'May 22, 2026',
                status: 'Placed',
                estDelivery: 'May 25, 2026',
                partner: 'Al Barr Courier Service',
                consignment: 'ABE-109283-KASH',
                paymentMethod: 'Cash on Delivery (COD)',
                shippingName: 'Kashmiri Guest',
                shippingPhone: '9419012345',
                shippingAddress: 'Residency Road, Lal Chowk, Srinagar, Jammu & Kashmir - 190001',
                subtotal: 3040.00,
                discount: 0.00,
                delivery: 0.00,
                grandTotal: 3040.00,
                items: [
                    { image: 'assets/img/products/product1.png', title: 'Premium Mamra Almonds', weight: '1kg', qty: 1, price: 2800.00 },
                    { image: 'assets/img/products/product4.png', title: 'Organic Flax Seeds', weight: '200g', qty: 2, price: 120.00 }
                ],
                route: [
                    { location: 'Orchard Processing Center, Srinagar', time: 'May 22, 2026, 02:30 PM', desc: 'Order received and registered in Al Barr system. Preparing packaging material with hygiene protocol.', completed: true, active: true }
                ]
            },
            'ALB-9831-KASH': {
                orderId: 'ALB-9831-KASH',
                date: 'May 20, 2026',
                status: 'Shipped',
                estDelivery: 'May 23, 2026',
                partner: 'Al Barr Courier Service',
                consignment: 'ABE-839210-KASH',
                paymentMethod: 'Direct Bank Transfer',
                shippingName: 'Irfan Manzoor',
                shippingPhone: '9419012345',
                shippingAddress: 'Zakura, Near Kashmir University Campus, Srinagar, Jammu & Kashmir - 190006',
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
            'ALB-1045-KASH': {
                orderId: 'ALB-1045-KASH',
                date: 'May 18, 2026',
                status: 'Delivered',
                estDelivery: 'May 20, 2026 (Delivered)',
                partner: 'Delhivery J&K',
                consignment: 'DEL-9201928-KASH',
                paymentMethod: 'Cash on Delivery (COD)',
                shippingName: 'Ruqaiya Jan',
                shippingPhone: '9419012345',
                shippingAddress: 'Ganderbal Town Center, Ganderbal, Jammu & Kashmir - 191201',
                subtotal: 1420.00,
                discount: 0.00,
                delivery: 60.00,
                grandTotal: 1480.00,
                items: [
                    { image: 'assets/img/products/product5.png', title: 'Kashmiri Walnuts Shell-less', weight: '500g', qty: 2, price: 550.00 },
                    { image: 'assets/img/products/product6.png', title: 'Organic Kesar Kehwa Tea', weight: '250g', qty: 1, price: 320.00 }
                ],
                route: [
                    { location: 'Ganderbal Town Center (Delivered)', time: 'May 20, 2026, 03:40 PM', desc: 'Order successfully delivered to customer. Payment collected via UPI.', completed: true, active: true },
                    { location: 'Out for Delivery - Ganderbal Hub', time: 'May 20, 2026, 10:15 AM', desc: 'Order assigned to local delivery courier for doorstep dispatch.', completed: true, active: false },
                    { location: 'Srinagar Sorting Hub', time: 'May 19, 2026, 11:30 AM', desc: 'Consignment received at regional sorting hub.', completed: true, active: false },
                    { location: 'Orchard Processing Center, Srinagar', time: 'May 18, 2026, 11:00 AM', desc: 'Order received and packaged.', completed: true, active: false }
                ]
            }
        };

        // Deterministic generator based on input string hash
        function generateCustomTrackOrder(orderId, contact) {
            // Get simple hash code
            let hash = 0;
            const fullStr = orderId + contact;
            for (let i = 0; i < fullStr.length; i++) {
                hash = fullStr.charCodeAt(i) + ((hash << 5) - hash);
            }
            hash = Math.abs(hash);

            // Determine status
            const statuses = ['Placed', 'Processed', 'Shipped', 'Out for Delivery'];
            const statusIdx = hash % 4;
            const status = statuses[statusIdx];

            // Setup date references relative to current local time (May 22, 2026)
            const orderDateStr = 'May 21, 2026';
            const estDateStr = 'May 24, 2026';

            // Setup items list based on hash
            const possibleItems = [
                { image: 'assets/img/products/product1.png', title: 'Premium Mamra Almonds', weight: '500g', price: 1450.00 },
                { image: 'assets/img/products/product2.png', title: 'Kashmiri Mogra Saffron', weight: '1g', price: 350.00 },
                { image: 'assets/img/products/product3.png', title: 'Pure Organic White Honey', weight: '250g', price: 450.00 },
                { image: 'assets/img/products/product4.png', title: 'Organic Flax Seeds', weight: '200g', price: 120.00 },
                { image: 'assets/img/products/product5.png', title: 'Kashmiri Walnuts Shell-less', weight: '500g', price: 550.00 }
            ];

            const item1 = possibleItems[hash % possibleItems.length];
            const item2 = possibleItems[(hash + 1) % possibleItems.length];
            
            const selectedItems = [
                { ...item1, qty: 1 },
                { ...item2, qty: 2 }
            ];

            const subtotal = item1.price + (item2.price * 2);
            const delivery = subtotal >= 2000 ? 0.00 : 60.00;
            const grandTotal = subtotal + delivery;

            // Generate delivery address
            const cities = ['Srinagar', 'Anantnag', 'Baramulla', 'Sopore', 'Pulwama', 'Budgam'];
            const chosenCity = cities[hash % cities.length];
            const address = `Main Bazaar Ward ${hash % 10 + 1}, ${chosenCity}, Jammu & Kashmir - ${190001 + (hash % 200)}`;

            // Extract contact
            const displayPhone = contact.includes('@') ? '94190XXXXX' : contact;
            const displayName = contact.includes('@') ? contact.split('@')[0] : 'Al Barr Patron';

            // Setup tracking route checkpoints
            const route = [];
            const r_date = 'May 21, 2026';
            const r_time_base = '11:00 AM';

            if (status === 'Placed') {
                route.push({
                    location: 'Orchard Processing Center, Srinagar',
                    time: `${r_date}, 02:40 PM`,
                    desc: 'Order successfully logged. Direct Farm check initiated.',
                    completed: true,
                    active: true
                });
            } else if (status === 'Processed') {
                route.push({
                    location: 'Packaging Station, Srinagar Hub',
                    time: `${r_date}, 07:15 PM`,
                    desc: 'Order double-wrapped in airtight hygienic seals and ready for dispatch.',
                    completed: true,
                    active: true
                });
                route.push({
                    location: 'Orchard Processing Center, Srinagar',
                    time: `${r_date}, 11:30 AM`,
                    desc: 'Order received and verified.',
                    completed: true,
                    active: false
                });
            } else if (status === 'Shipped') {
                route.push({
                    location: `${chosenCity} Regional Gateway`,
                    time: `May 22, 2026, 09:30 AM`,
                    desc: 'Consignment departed regional Srinagar sorting point. En route to local destination.',
                    completed: true,
                    active: true
                });
                route.push({
                    location: 'Packaging Station, Srinagar Hub',
                    time: `${r_date}, 07:15 PM`,
                    desc: 'Order processed and seal validated.',
                    completed: true,
                    active: false
                });
                route.push({
                    location: 'Orchard Processing Center, Srinagar',
                    time: `${r_date}, 11:30 AM`,
                    desc: 'Order received.',
                    completed: true,
                    active: false
                });
            } else if (status === 'Out for Delivery') {
                route.push({
                    location: `${chosenCity} Delivery Office`,
                    time: `May 22, 2026, 02:10 PM`,
                    desc: 'Consignment out for delivery with local courier agent. Doorstep handover pending.',
                    completed: true,
                    active: true
                });
                route.push({
                    location: `${chosenCity} Regional Gateway`,
                    time: `May 22, 2026, 08:30 AM`,
                    desc: 'Consignment received at sorting station.',
                    completed: true,
                    active: false
                });
                route.push({
                    location: 'Packaging Station, Srinagar Hub',
                    time: `${r_date}, 07:15 PM`,
                    desc: 'Shipped from orchards hub.',
                    completed: true,
                    active: false
                });
                route.push({
                    location: 'Orchard Processing Center, Srinagar',
                    time: `${r_date}, 11:30 AM`,
                    desc: 'Order verified.',
                    completed: true,
                    active: false
                });
            }

            return {
                orderId: orderId,
                date: orderDateStr,
                status: status,
                estDelivery: estDateStr,
                partner: 'Al Barr Express Logistics',
                consignment: `ABE-${100000 + (hash % 899999)}-KASH`,
                paymentMethod: 'Cash on Delivery (COD)',
                shippingName: displayName.charAt(0).toUpperCase() + displayName.slice(1),
                shippingPhone: displayPhone,
                shippingAddress: address,
                subtotal: subtotal,
                discount: 0.00,
                delivery: delivery,
                grandTotal: grandTotal,
                items: selectedItems,
                route: route
            };
        }

        // On Load Check URL Parameters
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const urlId = params.get('id');
            const urlContact = params.get('contact');

            if (urlId && urlContact) {
                document.getElementById('track-order-id').value = urlId;
                document.getElementById('track-contact').value = urlContact;
                loadTrackingDetails(urlId, urlContact);
            }
        });

        // Use Demo Tags triggers
        function useDemoOrder(orderId, phone) {
            document.getElementById('track-order-id').value = orderId;
            document.getElementById('track-contact').value = phone;
            loadTrackingDetails(orderId, phone);
        }

        // Form submit handler
        function handleTrackFormSubmit(e) {
            e.preventDefault();
            const orderId = document.getElementById('track-order-id').value.trim();
            const contact = document.getElementById('track-contact').value.trim();

            if (!orderId || !contact) {
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast('Please fill in both lookup fields.', 'error');
                }
                return;
            }

            loadTrackingDetails(orderId, contact);
        }

        // Main Tracking Loader
        function loadTrackingDetails(orderId, contact) {
            const btn = document.getElementById('btn-track-submit');
            btn.innerHTML = `<span class="spinner-loader" style="display:inline-block; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 8px; vertical-align: middle;"></span> Tracking...`;
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = `<span>🔍</span> Track Order`;
                btn.disabled = false;

                // 1. Look up Order details
                let order = null;
                
                // Format input to uppercase for consistency
                const lookupId = orderId.toUpperCase();
                
                if (PRE_BAKED_ORDERS[lookupId]) {
                    order = PRE_BAKED_ORDERS[lookupId];
                } else if (/^ALB-\d+-KASH$/i.test(lookupId) || lookupId.startsWith('ALB-')) {
                    // Generate logical dynamic tracking if formatted correctly
                    order = generateCustomTrackOrder(lookupId, contact);
                } else {
                    // Fallback to custom generator for any lookup string
                    order = generateCustomTrackOrder(lookupId, contact);
                }

                if (!order) {
                    if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                        AlBarrCart.showToast('Order not found. Please verify Order ID format.', 'error');
                    }
                    return;
                }

                // 2. Hide Initial Screen & Show results
                document.getElementById('track-initial-view').style.display = 'none';
                const resultsWrap = document.getElementById('track-results-view');
                resultsWrap.style.display = 'flex';

                // Scroll to results
                resultsWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });

                // Populate Summary Card
                document.getElementById('res-order-id').innerText = order.orderId;
                document.getElementById('res-order-date').innerText = `Ordered on: ${order.date}`;
                document.getElementById('res-est-delivery').innerText = order.estDelivery;
                document.getElementById('res-partner').innerText = order.partner;
                document.getElementById('res-consignment').innerText = order.consignment;

                // Status Badge styling
                const badge = document.getElementById('res-status-badge');
                badge.className = 'summary-status-badge';
                
                let stepperPercent = 0;
                let activeNodeIndex = 1;

                if (order.status === 'Placed') {
                    badge.classList.add('status-placed');
                    badge.innerHTML = `<span>📥</span> Placed`;
                    stepperPercent = 0;
                    activeNodeIndex = 1;
                } else if (order.status === 'Processed') {
                    badge.classList.add('status-processed');
                    badge.innerHTML = `<span>⚙️</span> Processed`;
                    stepperPercent = 25;
                    activeNodeIndex = 2;
                } else if (order.status === 'Shipped') {
                    badge.classList.add('status-shipped');
                    badge.innerHTML = `<span>🚚</span> Shipped`;
                    stepperPercent = 50;
                    activeNodeIndex = 3;
                } else if (order.status === 'Out for Delivery') {
                    badge.classList.add('status-out');
                    badge.innerHTML = `<span>🏍️</span> Out for Delivery`;
                    stepperPercent = 75;
                    activeNodeIndex = 4;
                } else if (order.status === 'Delivered') {
                    badge.classList.add('status-delivered');
                    badge.innerHTML = `<span>🎁</span> Delivered`;
                    stepperPercent = 100;
                    activeNodeIndex = 5;
                }

                // Update Stepper fill width
                document.getElementById('stepper-fill').style.width = `${stepperPercent}%`;

                // Update Stepper Nodes styles
                for (let i = 1; i <= 5; i++) {
                    const node = document.getElementById(`step-node-${i}`);
                    node.classList.remove('completed', 'active');
                    
                    const circle = node.querySelector('.stepper-circle');
                    const dateLbl = document.getElementById(`step-date-${i}`);
                    
                    // Reset icon contents based on step number
                    if (i === 1) circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    if (i === 2) circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    if (i === 3) circle.innerHTML = '🚚';
                    if (i === 4) circle.innerHTML = '🏍️';
                    if (i === 5) circle.innerHTML = '🎁';

                    if (i < activeNodeIndex) {
                        node.classList.add('completed');
                        // Ensure checkmark SVG is displayed inside completed circles
                        circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    } else if (i === activeNodeIndex) {
                        if (order.status === 'Delivered') {
                            node.classList.add('completed');
                            circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                        } else {
                            node.classList.add('active');
                        }
                    }

                    // Setup step dates
                    if (i === 1) dateLbl.innerText = order.date.split(',')[0];
                    else if (i === 2 && activeNodeIndex >= 2) dateLbl.innerText = order.date.split(',')[0];
                    else if (i === 3 && activeNodeIndex >= 3) {
                        // calculate relative dates
                        dateLbl.innerText = 'May 21';
                    }
                    else if (i === 4 && activeNodeIndex >= 4) dateLbl.innerText = 'May 22';
                    else if (i === 5 && activeNodeIndex >= 5) dateLbl.innerText = 'May 22';
                    else dateLbl.innerText = '-';
                }

                // Render Route logs timeline
                const timelineContainer = document.getElementById('route-timeline-container');
                timelineContainer.innerHTML = '';

                order.route.forEach(checkpoint => {
                    const chkNode = document.createElement('div');
                    chkNode.className = 'route-checkpoint';
                    if (checkpoint.active) chkNode.classList.add('active');
                    if (checkpoint.completed) chkNode.classList.add('completed');

                    chkNode.innerHTML = `
                        <div class="checkpoint-dot"></div>
                        <div class="checkpoint-meta">
                            <span class="checkpoint-location">${checkpoint.location}</span>
                            <span class="checkpoint-time">${checkpoint.time}</span>
                        </div>
                        <p class="checkpoint-desc">${checkpoint.desc}</p>
                    `;
                    timelineContainer.appendChild(chkNode);
                });

                // Populate itemized invoice
                const itemsContainer = document.getElementById('track-items-container');
                itemsContainer.innerHTML = '';

                order.items.forEach(item => {
                    const row = document.createElement('div');
                    row.className = 'receipt-item-row';
                    row.innerHTML = `
                        <div class="receipt-item-info">
                            <img src="${item.image}" alt="${item.title}" class="receipt-item-thumb">
                            <div>
                                <span class="receipt-item-name">${item.title}</span>
                                <div class="receipt-item-qty">Qty: ${item.qty} | Weight: ${item.weight}</div>
                            </div>
                        </div>
                        <span class="receipt-item-price">₹${(item.price * item.qty).toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                    `;
                    itemsContainer.appendChild(row);
                });

                // Financial details
                document.getElementById('res-subtotal').innerText = `₹${order.subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
                if (order.discount > 0) {
                    document.getElementById('res-row-discount').style.display = 'flex';
                    document.getElementById('res-discount').innerText = `-₹${order.discount.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
                } else {
                    document.getElementById('res-row-discount').style.display = 'none';
                }
                document.getElementById('res-delivery').innerText = order.delivery === 0 ? 'FREE' : `₹${order.delivery.toFixed(2)}`;
                document.getElementById('res-total').innerText = `₹${order.grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

                // Shipping details
                document.getElementById('res-shipping-name').innerText = order.shippingName;
                document.getElementById('res-shipping-phone').innerText = order.shippingPhone;
                document.getElementById('res-shipping-address').innerText = order.shippingAddress;
                document.getElementById('res-payment-method').innerText = order.paymentMethod;

                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(`Order details loaded for ${orderId}`);
                }

            }, 1000);
        }
    </script>
</body>
</html>
