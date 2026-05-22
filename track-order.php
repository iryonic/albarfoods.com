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

        /* -----------------------------------------
           NEW ENHANCEMENTS: Visual Roadmap, Ratings, Actions & Cancel Modal
           ----------------------------------------- */
        
        /* Status Cancelled style for badge */
        .status-cancelled {
            background-color: #ffebee !important;
            color: #c62828 !important;
        }

        /* Visual Roadmap Card */
        .roadmap-container {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: 20px;
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            margin-bottom: var(--spacing-lg);
            position: relative;
        }

        .roadmap-graphic-wrap {
            position: relative;
            width: 100%;
            overflow-x: auto;
            padding: 15px 0 35px 0;
            -webkit-overflow-scrolling: touch;
        }

        .roadmap-svg {
            min-width: 780px;
            display: block;
            margin: 0 auto;
        }

        /* Roadmap Nodes styling */
        .roadmap-node circle {
            fill: #ffffff;
            stroke: #e1e8e4;
            stroke-width: 4px;
            transition: all 0.4s ease;
        }

        .roadmap-node text {
            transition: all 0.4s ease;
        }

        /* Node States */
        .roadmap-node.completed circle {
            fill: #018849 !important;
            stroke: #018849 !important;
        }

        .roadmap-node.completed text.node-icon {
            fill: #ffffff !important;
        }

        .roadmap-node.active circle {
            stroke: #FF5500 !important;
            stroke-width: 5px !important;
            animation: nodePulse 2s infinite;
        }

        @keyframes nodePulse {
            0% { stroke-width: 4px; }
            50% { stroke-width: 8px; }
            100% { stroke-width: 4px; }
        }

        .roadmap-node.active text.node-icon {
            fill: #FF5500 !important;
            font-weight: bold;
        }

        .roadmap-node.cancelled circle {
            fill: #eceff1 !important;
            stroke: #b0bec5 !important;
            stroke-width: 4px !important;
        }

        .roadmap-node.cancelled text {
            fill: #b0bec5 !important;
        }

        /* Node Labels */
        .roadmap-node-label {
            font-size: 0.78rem;
            font-weight: 700;
            fill: var(--color-text-primary);
            text-anchor: middle;
            font-family: var(--font-secondary);
        }

        .roadmap-node-sublabel {
            font-size: 0.62rem;
            fill: var(--color-text-muted);
            text-anchor: middle;
        }

        .roadmap-node.active .roadmap-node-label {
            fill: #FF5500;
            font-weight: 800;
        }

        .roadmap-node.completed .roadmap-node-label {
            fill: #018849;
        }

        /* Action Buttons */
        .btn-track-action {
            padding: 10px 20px;
            font-size: 0.88rem;
            font-weight: 700;
            border-radius: var(--radius-xs);
            cursor: pointer;
            transition: var(--transition-fast);
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-secondary);
        }

        .btn-track-secondary {
            border: 1.5px solid var(--color-border);
            background-color: #fff;
            color: var(--color-blue-dark);
        }

        .btn-track-secondary:hover {
            background-color: var(--color-cream);
            transform: translateY(-1px);
        }

        .btn-track-danger {
            border: none;
            background-color: #c62828;
            color: #fff;
            box-shadow: 0 4px 10px rgba(198, 40, 40, 0.15);
        }

        .btn-track-danger:hover {
            background-color: #b71c1c;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(198, 40, 40, 0.25);
        }

        .btn-track-danger:active, .btn-track-secondary:active {
            transform: translateY(1px);
        }

        /* Rating Panel */
        .rating-stars-interactive {
            display: flex;
            gap: 6px;
        }

        .rating-stars-interactive .star-item {
            font-size: 1.8rem;
            color: var(--color-border);
            cursor: pointer;
            transition: color 0.15s, transform 0.15s;
        }

        .rating-stars-interactive .star-item:hover,
        .rating-stars-interactive .star-item.selected {
            color: #FFB300;
            transform: scale(1.15);
        }

        /* Cancellation Modal Overlay */
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
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--color-text-muted);
            line-height: 1;
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
        
        .verified-stamp {
            border: 2px solid #018849;
            color: #018849;
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 5px;
            transform: rotate(-5deg);
            display: inline-block;
            font-size: 12px;
            margin-top: 10px;
        }
        
        #invoice-print-frame {
            display: none;
        }
            
        @media (max-width: 768px) {
            .roadmap-graphic-wrap {
                justify-content: flex-start;
            }
        }
        
        /* ----------------------------------------- */
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

                    <!-- Rating Card (shown only when Delivered) -->
                    <div class="track-rating-card" id="track-rating-card" style="display: none; background-color: var(--color-cream-light); border: 1.5px dashed var(--color-blue-medium); border-radius: 16px; padding: var(--spacing-md); margin-top: var(--spacing-md); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                        <div>
                            <h4 style="margin: 0 0 4px 0; color: var(--color-blue-dark); font-family: var(--font-secondary); font-size: 1.05rem;">🌟 Rate Freshness & Delivery</h4>
                            <p style="margin: 0; font-size: 0.82rem; color: var(--color-text-secondary);">Your feedback helps us sustain traditional organic agriculture.</p>
                        </div>
                        <div class="rating-stars-interactive" id="track-rating-stars">
                            <!-- Populated dynamically -->
                        </div>
                    </div>

                    <!-- Actions Bar (Cancel and Invoice) -->
                    <div class="track-actions-bar" id="track-actions-bar" style="display: flex; gap: 12px; margin-top: var(--spacing-md); border-top: 1px solid var(--color-border-light); padding-top: var(--spacing-md); justify-content: flex-end; flex-wrap: wrap;">
                        <button class="btn-track-action btn-track-danger" id="btn-cancel-order" style="display: none;" onclick="triggerCancelModal()">❌ Cancel Order</button>
                        <button class="btn-track-action btn-track-secondary" id="btn-print-invoice" onclick="printInvoice()">📄 Download Tax Invoice</button>
                    </div>

                </div>

                <!-- Visual Wavy Roadmap journey -->
                <div class="roadmap-container" id="visual-roadmap-card">
                    <h3 class="route-title" style="margin-bottom: 0;">
                        <span>🗺️</span> Orchard-to-Doorstep Journey Map
                    </h3>
                    <div class="roadmap-graphic-wrap">
                        <svg viewBox="0 0 800 160" width="100%" height="auto" class="roadmap-svg" style="display: block;">
                            <defs>
                                <linearGradient id="road-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#e1e8e4" />
                                    <stop offset="100%" stop-color="#e1e8e4" />
                                </linearGradient>
                                <linearGradient id="road-active-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#018849" />
                                    <stop offset="100%" stop-color="#FF5500" />
                                </linearGradient>
                                <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                    <feGaussianBlur stdDeviation="4" result="blur" />
                                    <feComposite in="SourceGraphic" in2="blur" operator="over" />
                                </filter>
                            </defs>

                            <!-- Background wavy road line -->
                            <path id="road-bg-path" d="M 60 80 C 200 20, 250 140, 400 80 C 550 20, 600 140, 740 80" fill="none" stroke="#e1e8e4" stroke-width="8" stroke-linecap="round" />
                            
                            <!-- Active/Completed road line -->
                            <path id="road-active-path" d="M 60 80 C 200 20, 250 140, 400 80 C 550 20, 600 140, 740 80" fill="none" stroke="url(#road-active-grad)" stroke-width="8" stroke-linecap="round" stroke-dasharray="800" stroke-dashoffset="800" style="transition: stroke-dashoffset 1s ease-in-out;" />

                            <!-- Path Landmarks/Nodes -->
                            <!-- Node 1: Srinagar Orchard -->
                            <g class="roadmap-node" id="roadmap-node-1" transform="translate(60, 80)">
                                <circle r="22" />
                                <text y="5" font-size="16" text-anchor="middle" class="node-icon">🌳</text>
                                <text y="38" class="roadmap-node-label">Srinagar Orchard</text>
                                <text y="50" class="roadmap-node-sublabel">Valley Sourcing</text>
                            </g>

                            <!-- Node 2: Srinagar Central Hub -->
                            <g class="roadmap-node" id="roadmap-node-2" transform="translate(210, 56)">
                                <circle r="22" />
                                <text y="5" font-size="16" text-anchor="middle" class="node-icon">⚙️</text>
                                <text y="38" class="roadmap-node-label">Processing Hub</text>
                                <text y="50" class="roadmap-node-sublabel">Hygiene Seal</text>
                            </g>

                            <!-- Node 3: Highway Transit -->
                            <g class="roadmap-node" id="roadmap-node-3" transform="translate(390, 84)">
                                <circle r="22" />
                                <text y="5" font-size="16" text-anchor="middle" class="node-icon">🚚</text>
                                <text y="38" class="roadmap-node-label">Pampore Bypass</text>
                                <text y="50" class="roadmap-node-sublabel">Valley Express</text>
                            </g>

                            <!-- Node 4: Regional Gateway -->
                            <g class="roadmap-node" id="roadmap-node-4" transform="translate(570, 56)">
                                <circle r="22" />
                                <text y="5" font-size="16" text-anchor="middle" class="node-icon">🏍️</text>
                                <text y="38" class="roadmap-node-label">Local Hub</text>
                                <text y="50" class="roadmap-node-sublabel">Sorting Gate</text>
                            </g>

                            <!-- Node 5: Destination -->
                            <g class="roadmap-node" id="roadmap-node-5" transform="translate(740, 80)">
                                <circle r="22" />
                                <text y="5" font-size="16" text-anchor="middle" class="node-icon">🏠</text>
                                <text y="38" class="roadmap-node-label">Your Home</text>
                                <text y="50" class="roadmap-node-sublabel">Doorstep Delivery</text>
                            </g>

                            <!-- Animated Delivery Vehicle (Truck/Scooter) -->
                            <g id="roadmap-vehicle" transform="translate(-50, -50)" style="display: none; transition: transform 1s ease-in-out;">
                                <circle r="15" fill="#FF5500" filter="url(#glow)" />
                                <text y="5" font-size="14" text-anchor="middle" id="vehicle-emoji" fill="#fff">🚚</text>
                            </g>
                        </svg>
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

    <!-- Cancellation Dialog Modal -->
    <div class="cancel-modal-overlay" id="cancel-order-modal">
        <div class="cancel-modal-card">
            <div class="cancel-modal-header">
                <h3 class="cancel-modal-title">Cancel Order</h3>
                <button class="cancel-modal-close" onclick="closeCancelModal()">&times;</button>
            </div>
            <div class="cancel-modal-body">
                <p class="cancel-modal-text">We are sorry to hear you want to cancel your order. Please let us know the reason to help us improve our service:</p>
                <textarea id="cancel-reason" class="cancel-reason-input" rows="3" placeholder="e.g. Changed my mind, found another product, incorrect details..."></textarea>
                <p class="cancel-modal-text" style="color: #c62828; font-weight: bold; font-size: 0.85rem;">⚠️ Warning: This action is permanent and cannot be undone.</p>
            </div>
            <div class="cancel-modal-footer">
                <button class="btn-modal-cancel" onclick="closeCancelModal()">Keep Order</button>
                <button class="btn-modal-confirm" onclick="handleOrderCancellation()">Confirm Cancellation</button>
            </div>
        </div>
    </div>

    <!-- Hidden Printing Iframe for Invoice -->
    <iframe id="invoice-print-frame"></iframe>

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

        let currentTrackedOrderId = null;

        // Deterministic generator based on input string hash
        function generateCustomTrackOrder(orderId, contact) {
            let hash = 0;
            const fullStr = orderId + contact;
            for (let i = 0; i < fullStr.length; i++) {
                hash = fullStr.charCodeAt(i) + ((hash << 5) - hash);
            }
            hash = Math.abs(hash);

            const statuses = ['Placed', 'Processed', 'Shipped', 'Out for Delivery'];
            const statusIdx = hash % 4;
            const status = statuses[statusIdx];

            const orderDateStr = 'May 21, 2026';
            const estDateStr = 'May 24, 2026';

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

            const cities = ['Srinagar', 'Anantnag', 'Baramulla', 'Sopore', 'Pulwama', 'Budgam'];
            const chosenCity = cities[hash % cities.length];
            const address = `Main Bazaar Ward ${hash % 10 + 1}, ${chosenCity}, Jammu & Kashmir - ${190001 + (hash % 200)}`;

            const displayPhone = contact.includes('@') ? '94190XXXXX' : contact;
            const displayName = contact.includes('@') ? contact.split('@')[0] : 'Al Barr Patron';

            const route = [];
            const r_date = 'May 21, 2026';

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

                let order = null;
                const lookupId = orderId.toUpperCase();
                
                // Fetch local storage orders
                let localOrders = [];
                const savedOrders = localStorage.getItem('al_barr_orders');
                if (savedOrders) {
                    try {
                        localOrders = JSON.parse(savedOrders);
                    } catch(e) {
                        console.error("Failed to parse orders list from localStorage", e);
                    }
                }

                // Check in local storage first
                let matchedOrder = localOrders.find(o => o.orderId.toUpperCase() === lookupId);
                if (matchedOrder) {
                    order = matchedOrder;
                } else if (PRE_BAKED_ORDERS[lookupId]) {
                    order = JSON.parse(JSON.stringify(PRE_BAKED_ORDERS[lookupId]));
                    // Save to local storage for future updates (rating, cancellation)
                    localOrders.push(order);
                    localStorage.setItem('al_barr_orders', JSON.stringify(localOrders));
                } else {
                    order = generateCustomTrackOrder(lookupId, contact);
                    // Save to local storage for future updates (rating, cancellation)
                    localOrders.push(order);
                    localStorage.setItem('al_barr_orders', JSON.stringify(localOrders));
                }

                if (!order) {
                    if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                        AlBarrCart.showToast('Order not found. Please check Order ID format.', 'error');
                    }
                    return;
                }

                currentTrackedOrderId = order.orderId;

                // Hide Initial Screen & Show results
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
                const isCancelled = (order.status === 'Cancelled');

                if (isCancelled) {
                    badge.className = 'summary-status-badge status-cancelled';
                    badge.innerHTML = `<span>❌</span> Cancelled`;
                    
                    // Determine cancellation point by counting valid checkpoints
                    const validRoute = (order.route || []).filter(c => 
                        !c.location.includes('Cancelled') && 
                        !c.desc.includes('cancelled') &&
                        !c.desc.includes('Cancelled')
                    );
                    activeNodeIndex = Math.max(1, Math.min(validRoute.length, 5));
                    stepperPercent = (activeNodeIndex - 1) * 25;
                } else {
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
                }

                // Update Stepper fill width
                const fillBar = document.getElementById('stepper-fill');
                fillBar.style.width = `${stepperPercent}%`;
                if (isCancelled) {
                    fillBar.style.background = '#c62828';
                } else {
                    fillBar.style.background = 'var(--color-gold-gradient)';
                }

                // Update Stepper Nodes styles
                for (let i = 1; i <= 5; i++) {
                    const node = document.getElementById(`step-node-${i}`);
                    node.classList.remove('completed', 'active');
                    node.style.opacity = '1';
                    node.style.color = '';
                    
                    const circle = node.querySelector('.stepper-circle');
                    const dateLbl = document.getElementById(`step-date-${i}`);
                    
                    // Reset styling modifications
                    circle.style.borderColor = '';
                    circle.style.backgroundColor = '';
                    circle.style.color = '';

                    // Reset icon contents based on step number
                    if (i === 1) circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    if (i === 2) circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    if (i === 3) circle.innerHTML = '🚚';
                    if (i === 4) circle.innerHTML = '🏍️';
                    if (i === 5) circle.innerHTML = '🎁';

                    if (isCancelled) {
                        if (i < activeNodeIndex) {
                            node.classList.add('completed');
                            circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                        } else if (i === activeNodeIndex) {
                            node.classList.add('active');
                            node.style.color = '#c62828';
                            circle.innerHTML = '❌';
                            circle.style.borderColor = '#c62828';
                            circle.style.backgroundColor = '#ffebee';
                            circle.style.color = '#c62828';
                        } else {
                            node.style.opacity = '0.5';
                        }
                    } else {
                        if (i < activeNodeIndex) {
                            node.classList.add('completed');
                            circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                        } else if (i === activeNodeIndex) {
                            if (order.status === 'Delivered') {
                                node.classList.add('completed');
                                circle.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                            } else {
                                node.classList.add('active');
                            }
                        }
                    }

                    // Setup step dates
                    if (i === 1) dateLbl.innerText = order.date.split(',')[0];
                    else if (i === 2 && activeNodeIndex >= 2) dateLbl.innerText = order.date.split(',')[0];
                    else if (i === 3 && activeNodeIndex >= 3) dateLbl.innerText = 'May 21';
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

                // Action Buttons updates
                const cancelBtn = document.getElementById('btn-cancel-order');
                if (order.status === 'Placed' || order.status === 'Processed') {
                    cancelBtn.style.display = 'inline-flex';
                } else {
                    cancelBtn.style.display = 'none';
                }

                // Update visual SVG roadmap
                updateVisualRoadmap(order);

                // Render dynamic ratings panel
                renderRatingWidget(order);

                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(`Order details loaded for ${orderId}`);
                }

            }, 1000);
        }

        // SVG Visual Journey Map Updater
        function updateVisualRoadmap(order) {
            const vehicle = document.getElementById('roadmap-vehicle');
            const vehicleEmoji = document.getElementById('vehicle-emoji');
            const roadActivePath = document.getElementById('road-active-path');
            
            if (!vehicle || !roadActivePath) return;
            
            let activeNodeIndex = 1;
            const isCancelled = (order.status === 'Cancelled');
            
            if (isCancelled) {
                const validRoute = (order.route || []).filter(c => 
                    !c.location.includes('Cancelled') && 
                    !c.desc.includes('cancelled') &&
                    !c.desc.includes('Cancelled')
                );
                activeNodeIndex = Math.max(1, Math.min(validRoute.length, 5));
            } else {
                if (order.status === 'Placed') activeNodeIndex = 1;
                else if (order.status === 'Processed') activeNodeIndex = 2;
                else if (order.status === 'Shipped') activeNodeIndex = 3;
                else if (order.status === 'Out for Delivery') activeNodeIndex = 4;
                else if (order.status === 'Delivered') activeNodeIndex = 5;
            }
            
            const coordinates = {
                1: { x: 60, y: 80, emoji: '📦' },
                2: { x: 210, y: 56, emoji: '⚙️' },
                3: { x: 390, y: 84, emoji: '🚚' },
                4: { x: 570, y: 56, emoji: '🏍️' },
                5: { x: 740, y: 80, emoji: '🎁' }
            };
            
            const coord = coordinates[activeNodeIndex] || coordinates[1];
            
            // Animate vehicle position
            vehicle.style.display = 'block';
            vehicle.setAttribute('transform', `translate(${coord.x}, ${coord.y})`);
            vehicleEmoji.textContent = isCancelled ? '❌' : coord.emoji;
            
            // Draw route fill path
            let dashoffset = 800 - ((activeNodeIndex - 1) * 200);
            if (isCancelled) {
                roadActivePath.setAttribute('stroke', '#b0bec5');
            } else {
                roadActivePath.setAttribute('stroke', 'url(#road-active-grad)');
            }
            roadActivePath.setAttribute('stroke-dashoffset', dashoffset);
            
            // Update node style attributes and classes
            for (let i = 1; i <= 5; i++) {
                const svgNode = document.getElementById(`roadmap-node-${i}`);
                if (!svgNode) continue;
                
                svgNode.classList.remove('completed', 'active', 'cancelled');
                const nodeIcon = svgNode.querySelector('.node-icon');
                
                // Reset custom icons to default values
                if (nodeIcon) {
                    if (i === 1) nodeIcon.textContent = '🌳';
                    else if (i === 2) nodeIcon.textContent = '⚙️';
                    else if (i === 3) nodeIcon.textContent = '🚚';
                    else if (i === 4) nodeIcon.textContent = '🏍️';
                    else if (i === 5) nodeIcon.textContent = '🏠';
                }

                if (isCancelled) {
                    if (i < activeNodeIndex) {
                        svgNode.classList.add('completed');
                    } else if (i === activeNodeIndex) {
                        svgNode.classList.add('cancelled');
                        if (nodeIcon) nodeIcon.textContent = '❌';
                    } else {
                        svgNode.classList.add('cancelled');
                    }
                } else {
                    if (i < activeNodeIndex) {
                        svgNode.classList.add('completed');
                    } else if (i === activeNodeIndex) {
                        if (order.status === 'Delivered') {
                            svgNode.classList.add('completed');
                        } else {
                            svgNode.classList.add('active');
                        }
                    }
                }
            }
        }

        // Render stars in quality feedback widget
        function renderRatingWidget(order) {
            const ratingCard = document.getElementById('track-rating-card');
            const ratingStars = document.getElementById('track-rating-stars');
            if (!ratingCard || !ratingStars) return;
            
            if (order.status === 'Delivered') {
                ratingCard.style.display = 'flex';
                ratingStars.innerHTML = '';
                
                const activeRating = order.rating || 0;
                
                for (let val = 1; val <= 5; val++) {
                    const star = document.createElement('span');
                    star.className = `star-item${val <= activeRating ? ' selected' : ''}`;
                    star.innerHTML = '★';
                    star.title = `${val} Star${val > 1 ? 's' : ''}`;
                    star.onclick = () => saveOrderRating(order.orderId, val);
                    
                    // Add micro-animations
                    star.onmouseenter = () => {
                        const siblings = ratingStars.children;
                        for (let j = 0; j < siblings.length; j++) {
                            if (j < val) {
                                siblings[j].classList.add('selected');
                            } else {
                                siblings[j].classList.remove('selected');
                            }
                        }
                    };
                    
                    star.onmouseleave = () => {
                        const siblings = ratingStars.children;
                        const currentRating = order.rating || 0;
                        for (let j = 0; j < siblings.length; j++) {
                            if (j < currentRating) {
                                siblings[j].classList.add('selected');
                            } else {
                                siblings[j].classList.remove('selected');
                            }
                        }
                    };
                    
                    ratingStars.appendChild(star);
                }
            } else {
                ratingCard.style.display = 'none';
            }
        }

        // Save order rating feedback locally
        function saveOrderRating(orderId, ratingVal) {
            const savedOrders = localStorage.getItem('al_barr_orders');
            if (savedOrders) {
                try {
                    let orders = JSON.parse(savedOrders);
                    let idx = orders.findIndex(o => o.orderId.toUpperCase() === orderId.toUpperCase());
                    if (idx !== -1) {
                        orders[idx].rating = ratingVal;
                        localStorage.setItem('al_barr_orders', JSON.stringify(orders));
                        
                        renderRatingWidget(orders[idx]);
                        
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast(`Thank you! Order rated ${ratingVal} stars successfully!`, 'success');
                        }
                    }
                } catch(e) {
                    console.error("Failed to save quality feedback rating", e);
                }
            }
        }

        // Cancel dialog modal functions
        function triggerCancelModal() {
            document.getElementById('cancel-order-modal').style.display = 'flex';
            document.getElementById('cancel-reason').value = '';
        }

        function closeCancelModal() {
            document.getElementById('cancel-order-modal').style.display = 'none';
        }

        function handleOrderCancellation() {
            if (!currentTrackedOrderId) return;
            const reason = document.getElementById('cancel-reason').value.trim() || 'Changed my mind';
            
            const savedOrders = localStorage.getItem('al_barr_orders');
            if (savedOrders) {
                try {
                    let orders = JSON.parse(savedOrders);
                    let idx = orders.findIndex(o => o.orderId.toUpperCase() === currentTrackedOrderId.toUpperCase());
                    if (idx !== -1) {
                        const order = orders[idx];
                        order.status = 'Cancelled';
                        
                        const now = new Date();
                        const dateString = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                        
                        // Prep logs timeline
                        order.route.unshift({
                            location: 'Cancelled',
                            time: `${dateString}, ${timeString}`,
                            desc: `Order cancelled by customer. Reason: ${reason}. Refund check initiated.`,
                            completed: true,
                            active: true
                        });
                        
                        // Disable active status of older checkpoints
                        order.route.forEach((c, idx) => {
                            if (idx > 0) c.active = false;
                        });
                        
                        localStorage.setItem('al_barr_orders', JSON.stringify(orders));
                        closeCancelModal();
                        
                        // Re-render
                        loadTrackingDetails(order.orderId, order.shippingPhone);
                        
                        if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                            AlBarrCart.showToast('Order cancelled successfully.', 'success');
                        }
                    }
                } catch(e) {
                    console.error("Failed to process order cancellation", e);
                }
            }
        }

        // PDF print trigger via hidden iframe write procedure
        function printInvoice() {
            const savedOrders = localStorage.getItem('al_barr_orders');
            if (!savedOrders || !currentTrackedOrderId) return;
            
            try {
                const orders = JSON.parse(savedOrders);
                const order = orders.find(o => o.orderId.toUpperCase() === currentTrackedOrderId.toUpperCase());
                if (!order) return;
                
                const printFrame = document.getElementById('invoice-print-frame');
                const doc = printFrame.contentDocument || printFrame.contentWindow.document;
                
                // Formulate rows
                let itemsHtml = '';
                order.items.forEach((item, index) => {
                    itemsHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.title} (${item.weight})</td>
                            <td>₹${item.price.toFixed(2)}</td>
                            <td>${item.qty}</td>
                            <td>₹${(item.price * item.qty).toFixed(2)}</td>
                        </tr>
                    `;
                });
                
                const invoiceHtml = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Invoice_${order.orderId}</title>
                        <style>
                            body {
                                font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
                                color: #333;
                                margin: 40px;
                                padding: 0;
                            }
                            .invoice-box {
                                max-width: 800px;
                                margin: auto;
                                border: 1px solid #eee;
                                padding: 30px;
                                border-radius: 12px;
                                position: relative;
                            }
                            .invoice-header {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                border-bottom: 2px solid #018849;
                                padding-bottom: 20px;
                                margin-bottom: 25px;
                            }
                            .brand-logo {
                                font-size: 26px;
                                font-weight: 800;
                                color: #0B192C;
                            }
                            .brand-logo span {
                                color: #018849;
                            }
                            .company-details {
                                text-align: right;
                                font-size: 11px;
                                color: #666;
                                line-height: 1.4;
                            }
                            .invoice-meta-grid {
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                                gap: 20px;
                                margin-bottom: 30px;
                            }
                            .meta-block h4 {
                                margin: 0 0 6px 0;
                                font-size: 13px;
                                color: #018849;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                            }
                            .meta-block p {
                                margin: 0;
                                font-size: 12px;
                                line-height: 1.4;
                            }
                            .invoice-table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 30px;
                            }
                            .invoice-table th {
                                background-color: #f7f9f7;
                                color: #333;
                                text-align: left;
                                padding: 12px;
                                font-size: 12px;
                                font-weight: 700;
                                border-bottom: 1px solid #ddd;
                            }
                            .invoice-table td {
                                padding: 12px;
                                font-size: 12px;
                                border-bottom: 1px solid #eee;
                            }
                            .totals-block {
                                width: 250px;
                                margin-left: auto;
                                margin-top: 20px;
                            }
                            .totals-row {
                                display: flex;
                                justify-content: space-between;
                                font-size: 12px;
                                margin-bottom: 6px;
                            }
                            .totals-row.grand-total {
                                font-size: 15px;
                                font-weight: bold;
                                color: #0B192C;
                                border-top: 1.5px solid #018849;
                                padding-top: 8px;
                                margin-top: 8px;
                            }
                            .footer {
                                margin-top: 50px;
                                text-align: center;
                                font-size: 11px;
                                color: #888;
                                border-top: 1px solid #eee;
                                padding-top: 15px;
                            }
                            .stamp-container {
                                position: absolute;
                                bottom: 120px;
                                right: 50px;
                                opacity: 0.85;
                            }
                            .organic-seal {
                                border: 3px double #018849;
                                color: #018849;
                                padding: 8px 12px;
                                font-weight: 800;
                                border-radius: 6px;
                                transform: rotate(-12deg);
                                font-size: 13px;
                                text-align: center;
                                display: inline-block;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="invoice-box">
                            <div class="invoice-header">
                                <div class="brand-logo">Al Barr<span>.com</span></div>
                                <div class="company-details">
                                    <strong>Al Barr Organic Farm Foods Private Limited</strong><br>
                                    GSTIN: 01AABCA1234F1Z8<br>
                                    Shalimar Orchards Belt, Srinagar, J&K - 190021<br>
                                    support@albarr.com | +91 94190 12345
                                </div>
                            </div>
                            
                            <div class="invoice-meta-grid">
                                <div class="meta-block">
                                    <h4>Invoice Details</h4>
                                    <p>
                                        <strong>Invoice No:</strong> INV-${order.orderId.replace('ALB-', '')}<br>
                                        <strong>Date:</strong> ${order.date}<br>
                                        <strong>Order ID:</strong> ${order.orderId}<br>
                                        <strong>Payment Mode:</strong> ${order.paymentMethod}
                                    </p>
                                </div>
                                <div class="meta-block">
                                    <h4>Ship To</h4>
                                    <p>
                                        <strong>${order.shippingName}</strong><br>
                                        ${order.shippingAddress}<br>
                                        <strong>Phone:</strong> ${order.shippingPhone}
                                    </p>
                                </div>
                            </div>
                            
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th style="width: 8%">S.No</th>
                                        <th>Item Description</th>
                                        <th style="width: 18%">Rate</th>
                                        <th style="width: 12%">Qty</th>
                                        <th style="width: 18%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
                            </table>
                            
                            <div class="totals-block">
                                <div class="totals-row">
                                    <span>Subtotal:</span>
                                    <span>₹${order.subtotal.toFixed(2)}</span>
                                </div>
                                ${order.discount > 0 ? `
                                <div class="totals-row" style="color: #018849;">
                                    <span>Discount:</span>
                                    <span>-₹${order.discount.toFixed(2)}</span>
                                </div>` : ''}
                                <div class="totals-row">
                                    <span>Delivery Fee:</span>
                                    <span>₹${order.delivery.toFixed(2)}</span>
                                </div>
                                <div class="totals-row grand-total">
                                    <span>Total:</span>
                                    <span>₹${order.grandTotal.toFixed(2)}</span>
                                </div>
                            </div>
                            
                            <div class="stamp-container">
                                <div class="organic-seal">AL BARR VERIFIED<br>100% ORGANIC</div>
                            </div>
                            
                            <div class="footer">
                                Thank you for patronizing the traditional organic agriculture of Kashmir Valley.<br>
                                This is a computer-generated tax invoice and requires no physical signature.
                            </div>
                        </div>
                    </body>
                    </html>
                `;
                
                doc.open();
                doc.write(invoiceHtml);
                doc.close();
                
                printFrame.contentWindow.focus();
                setTimeout(() => {
                    printFrame.contentWindow.print();
                }, 250);
            } catch (err) {
                console.error("Failed to generate and print invoice", err);
            }
        }
    </script>
</body>
</html>
