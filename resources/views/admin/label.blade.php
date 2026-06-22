<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label{{ $orders->count() > 1 ? 's' : '' }} — Al Barr Foods</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1a1a2e;
            background: #e8ecf1;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Screen Actions Bar ─── */
        .actions-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: rgba(10, 15, 30, 0.96);
            backdrop-filter: blur(14px);
            color: #fff;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
        }

        .actions-bar-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1rem;
        }

        .actions-bar-btns {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-print {
            background: linear-gradient(135deg, #c5a880, #b4956d);
            color: #fff;
        }
        .btn-print:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(197,168,128,0.4); }

        .btn-back {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .btn-back:hover { background: rgba(255,255,255,0.15); }

        /* ─── Label Card ─── */
        .labels-grid {
            max-width: 900px;
            margin: 80px auto 40px;
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
        }

        .label-card {
            width: 4in;
            min-height: 6in;
            background: #fff;
            border: 2px solid #1a1a2e;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            page-break-inside: avoid;
            page-break-after: always;
        }

        .label-card:last-child {
            page-break-after: auto;
        }

        /* Label Header */
        .label-header {
            background: #0a1229;
            color: #fff;
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .label-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
        }

        .label-type-badge {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 3px 8px;
            border-radius: 4px;
            background: rgba(255,255,255,0.15);
        }

        /* From / To Sections */
        .label-section {
            padding: 14px 18px;
            border-bottom: 1px dashed #cbd5e1;
        }

        .label-section:last-child {
            border-bottom: none;
        }

        .label-section-title {
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .label-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .label-address {
            font-size: 0.82rem;
            color: #475569;
            line-height: 1.5;
        }

        .label-phone {
            font-size: 0.82rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 4px;
        }

        /* To section gets larger styling */
        .label-to {
            flex: 1;
            background: #fafbfc;
        }

        .label-to .label-name {
            font-size: 1.2rem;
        }

        .label-to .label-address {
            font-size: 0.9rem;
        }

        .label-to .label-phone {
            font-size: 0.9rem;
        }

        /* Pincode highlight */
        .label-pincode {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #0f172a;
            color: #fff;
            padding: 4px 12px;
            border-radius: 6px;
            font-family: 'Fira Code', monospace;
            font-size: 1rem;
            font-weight: 700;
            margin-top: 8px;
        }

        /* Order Info Strip */
        .label-order-strip {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            padding: 12px 18px;
            background: #f1f5f9;
            border-top: 2px solid #e2e8f0;
            border-bottom: 2px solid #e2e8f0;
        }

        .label-info-item {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .label-info-lbl {
            font-size: 0.58rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
        }

        .label-info-val {
            font-size: 0.78rem;
            font-weight: 700;
            color: #0f172a;
            font-family: 'Fira Code', monospace;
        }

        /* Tracking / Carrier */
        .label-tracking-strip {
            padding: 10px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .label-tracking-num {
            font-family: 'Fira Code', monospace;
            font-size: 0.82rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 0.5px;
        }

        .label-carrier-badge {
            font-size: 0.68rem;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 6px;
            background: #e6f5ec;
            color: #018849;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* COD Badge */
        .label-cod-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            background: #fff3cd;
            color: #7a5f00;
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-top: 2px dashed #e0c96e;
        }

        .label-cod-amount {
            font-family: 'Fira Code', monospace;
            font-size: 1rem;
        }

        /* Barcode placeholder */
        .label-barcode {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px 18px 14px;
            gap: 4px;
        }

        .barcode-bars {
            display: flex;
            gap: 1px;
            align-items: flex-end;
            height: 36px;
        }

        .barcode-bars span {
            display: inline-block;
            background: #0f172a;
            width: 2px;
        }

        .barcode-text {
            font-family: 'Fira Code', monospace;
            font-size: 0.72rem;
            color: #64748b;
            letter-spacing: 2px;
        }

        /* Weight summary */
        .label-weight {
            padding: 6px 18px 10px;
            font-size: 0.78rem;
            color: #64748b;
            display: flex;
            justify-content: space-between;
        }

        .label-weight strong {
            color: #0f172a;
        }

        /* ─── Print Styles ─── */
        @media print {
            body { background: #fff; }
            .actions-bar { display: none !important; }
            .labels-grid { margin: 0; gap: 0; }
            .label-card {
                box-shadow: none;
                border-radius: 0;
                margin: 0 auto;
            }
            .label-header,
            .label-order-strip,
            .label-cod-badge,
            .label-carrier-badge,
            .label-pincode,
            .label-to {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        @media (max-width: 680px) {
            .actions-bar {
                padding: 12px 16px;
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }
            .actions-bar-title {
                text-align: center;
                font-size: 0.9rem;
            }
            .actions-bar-btns {
                justify-content: center;
            }
            .btn-action {
                flex: 1;
                justify-content: center;
                padding: 8px 12px;
                font-size: 0.8rem;
            }
            .labels-grid {
                margin: 95px 12px 24px;
            }
        }

        @media (max-width: 420px) {
            .label-card {
                width: 100% !important;
                min-height: auto !important;
            }
        }
    </style>
</head>
<body>

<!-- Screen Actions Bar -->
<div class="actions-bar">
    <div class="actions-bar-title">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> {{ $orders->count() > 1 ? $orders->count() . ' Shipping Labels' : 'Label — ' . $orders->first()->order_number }}
    </div>
    <div class="actions-bar-btns">
        <button class="btn-action btn-print" style="display: inline-flex; align-items: center;" onclick="window.print()"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg> Print{{ $orders->count() > 1 ? ' All' : '' }}</button>
        <a href="{{ route('admin.orders') }}" class="btn-action btn-back">← Back to Orders</a>
    </div>
</div>

<div class="labels-grid">
@foreach($orders as $order)
    <div class="label-card">

        <!-- Header -->
        <div class="label-header">
            <span class="label-brand"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M2 22c0-5.5 4.5-10 10-10H22M22 2c-5.5 0-10 4.5-10 10V22"></path></svg> {{ $settings['site_name'] ?? 'Al Barr Foods' }}</span>
            <span class="label-type-badge">Shipping Label</span>
        </div>

        <!-- From -->
        <div class="label-section">
            <div class="label-section-title">From (Seller)</div>
            <div class="label-name">{{ $settings['site_name'] ?? 'Al Barr Foods' }}</div>
            <div class="label-address">{{ $settings['site_address'] ?? 'Srinagar, J&K, India' }}</div>
            @if(!empty($settings['site_phone']))
                <div class="label-phone"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> {{ $settings['site_phone'] }}</div>
            @endif
        </div>

        <!-- To (prominent) -->
        <div class="label-section label-to">
            <div class="label-section-title">Ship To (Recipient)</div>
            <div class="label-name">{{ $order->shipping_name }}</div>
            <div class="label-address">
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}
                @if($order->shipping_landmark), {{ $order->shipping_landmark }}@endif
            </div>
            <div class="label-phone">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> {{ $order->shipping_phone }}
                @if($order->shipping_alt_phone) / {{ $order->shipping_alt_phone }}@endif
            </div>
            <div class="label-pincode"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> {{ $order->shipping_pincode }}</div>
        </div>

        <!-- Order Info -->
        <div class="label-order-strip">
            <div class="label-info-item">
                <span class="label-info-lbl">Order #</span>
                <span class="label-info-val">{{ $order->order_number }}</span>
            </div>
            <div class="label-info-item">
                <span class="label-info-lbl">Date</span>
                <span class="label-info-val">{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="label-info-item">
                <span class="label-info-lbl">Items</span>
                <span class="label-info-val">{{ $order->items->sum('quantity') }} pcs</span>
            </div>
            <div class="label-info-item">
                <span class="label-info-lbl">Total Value</span>
                <span class="label-info-val">₹{{ number_format($order->grand_total, 0) }}</span>
            </div>
        </div>

        <!-- Weight -->
        <div class="label-weight">
            <span>Total Items: <strong>{{ $order->items->count() }} SKU(s)</strong></span>
            <span>Qty: <strong>{{ $order->items->sum('quantity') }}</strong></span>
        </div>

        <!-- Tracking / Carrier -->
        @if($order->tracking_number || $order->carrier_name)
        <div class="label-tracking-strip">
            <div>
                <div style="font-size: 0.58rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; margin-bottom: 2px;">Tracking / AWB</div>
                <div class="label-tracking-num">{{ $order->tracking_number ?? '—' }}</div>
            </div>
            @if($order->carrier_name)
            <span class="label-carrier-badge">{{ $order->carrier_name }}</span>
            @endif
        </div>
        @endif

        <!-- COD Badge -->
        @if(strtolower($order->payment_method) === 'cod')
        <div class="label-cod-badge">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg> CASH ON DELIVERY — COLLECT
            <span class="label-cod-amount">₹{{ number_format($order->grand_total, 0) }}</span>
        </div>
        @endif

        <!-- Barcode (visual representation) -->
        <div class="label-barcode">
            <div class="barcode-bars">
                @php
                    $chars = str_split($order->order_number);
                    foreach ($chars as $c) {
                        $h = (ord($c) % 20) + 18;
                        echo '<span style="height: '.$h.'px;"></span>';
                        echo '<span style="height: '.($h - 8).'px; background: #fff;"></span>';
                        echo '<span style="height: '.($h - 4).'px;"></span>';
                    }
                @endphp
            </div>
            <div class="barcode-text">{{ $order->order_number }}</div>
        </div>

    </div>
@endforeach
</div>

</body>
</html>
