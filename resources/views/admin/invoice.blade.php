<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice{{ $orders->count() > 1 ? 's' : '' }} — Al Barr Foods</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1a1a2e;
            background: #f0f2f5;
            line-height: 1.5;
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
            letter-spacing: -0.3px;
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

        /* ─── Invoice Page ─── */
        .invoice-page {
            max-width: 820px;
            margin: 80px auto 40px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.06);
            overflow: hidden;
            page-break-after: always;
        }

        .invoice-page:last-child {
            page-break-after: auto;
        }

        /* Header */
        .inv-header {
            background: linear-gradient(135deg, #0a1229 0%, #0d1a3a 100%);
            color: #fff;
            padding: 36px 44px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .inv-brand {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .inv-brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .inv-brand-tagline {
            font-size: 0.78rem;
            opacity: 0.6;
            font-weight: 500;
        }

        .inv-title-block {
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .inv-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: linear-gradient(135deg, #c5a880, #e8d5b7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .inv-number {
            font-family: 'Fira Code', monospace;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .inv-date {
            font-size: 0.8rem;
            opacity: 0.6;
        }

        /* Body */
        .inv-body {
            padding: 36px 44px;
        }

        /* Addresses Row */
        .inv-addresses {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
            padding-bottom: 28px;
            border-bottom: 2px solid #f1f5f9;
        }

        .inv-address-block h4 {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .inv-address-name {
            font-weight: 700;
            font-size: 1rem;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .inv-address-line {
            font-size: 0.88rem;
            color: #475569;
            line-height: 1.6;
        }

        /* Order Meta */
        .inv-meta-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px 20px;
            border: 1px solid #e2e8f0;
        }

        .inv-meta-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .inv-meta-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
        }

        .inv-meta-value {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* Items Table */
        .inv-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .inv-items-table thead th {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            border-bottom: 2px solid #e2e8f0;
            padding: 10px 12px;
            text-align: left;
        }

        .inv-items-table thead th:last-child,
        .inv-items-table thead th:nth-child(3),
        .inv-items-table thead th:nth-child(4) {
            text-align: right;
        }

        .inv-items-table tbody td {
            padding: 14px 12px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        .inv-items-table tbody tr:last-child td {
            border-bottom: 2px solid #e2e8f0;
        }

        .inv-items-table tbody td:last-child,
        .inv-items-table tbody td:nth-child(3),
        .inv-items-table tbody td:nth-child(4) {
            text-align: right;
            font-family: 'Fira Code', monospace;
            font-size: 0.85rem;
        }

        .item-name { font-weight: 700; color: #0f172a; }
        .item-weight { font-size: 0.78rem; color: #94a3b8; font-weight: 500; }

        /* Totals */
        .inv-totals {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 32px;
        }

        .inv-totals-box {
            width: 320px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .inv-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #64748b;
        }

        .inv-total-row span:last-child {
            font-family: 'Fira Code', monospace;
            font-weight: 600;
        }

        .inv-total-row.discount {
            color: #018849;
        }

        .inv-total-row.grand {
            border-top: 2px solid #0f172a;
            padding-top: 12px;
            margin-top: 8px;
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
        }

        .inv-total-row.grand span:last-child {
            font-family: 'Fira Code', monospace;
        }

        /* Footer */
        .inv-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 44px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 32px;
        }

        .inv-footer-col h5 {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .inv-footer-col p {
            font-size: 0.82rem;
            color: #64748b;
            line-height: 1.5;
        }

        .inv-watermark {
            text-align: center;
            padding: 16px;
            font-size: 0.72rem;
            color: #cbd5e1;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Payment badge */
        .inv-payment-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .inv-payment-badge.completed { background: #d1e7dd; color: #0a5c36; }
        .inv-payment-badge.pending { background: #fff3cd; color: #7a5f00; }
        .inv-payment-badge.failed { background: #f8d7da; color: #842029; }
        .inv-payment-badge.refunded { background: #e2e3e5; color: #383d41; }

        /* ─── Print Styles ─── */
        @media print {
            body { background: #fff; }
            .actions-bar { display: none !important; }
            .invoice-page {
                margin: 0;
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }
            .inv-header { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .inv-meta-grid { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .inv-footer { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .inv-payment-badge { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        }

        @media (max-width: 680px) {
            .inv-header { flex-direction: column; gap: 16px; padding: 24px; }
            .inv-title-block { text-align: left; }
            .inv-body { padding: 24px; }
            .inv-addresses { grid-template-columns: 1fr; gap: 20px; }
            .inv-meta-grid { grid-template-columns: 1fr 1fr; }
            .inv-footer { flex-direction: column; padding: 20px 24px; }
            .inv-totals-box { width: 100%; }
        }
    </style>
</head>
<body>

<!-- Screen Actions Bar -->
<div class="actions-bar">
    <div class="actions-bar-title">
        📄 {{ $orders->count() > 1 ? $orders->count() . ' Invoices' : 'Invoice #INV-' . $orders->first()->order_number }}
    </div>
    <div class="actions-bar-btns">
        <button class="btn-action btn-print" onclick="window.print()">🖨️ Print{{ $orders->count() > 1 ? ' All' : '' }}</button>
        <a href="{{ route('admin.orders') }}" class="btn-action btn-back">← Back to Orders</a>
    </div>
</div>

@foreach($orders as $order)
<div class="invoice-page">

    <!-- Header -->
    <div class="inv-header">
        <div class="inv-brand">
            <div class="inv-brand-name">🌿 {{ $settings['site_name'] ?? 'Al Barr Foods' }}</div>
            <div class="inv-brand-tagline">{{ $settings['site_tagline'] ?? 'Kashmiri Organic Staples · Premium Dry Fruits' }}</div>
        </div>
        <div class="inv-title-block">
            <div class="inv-title">Invoice</div>
            <div class="inv-number">INV-{{ $order->order_number }}</div>
            <div class="inv-date">Issued: {{ $order->created_at->format('d M Y') }}</div>
        </div>
    </div>

    <!-- Body -->
    <div class="inv-body">

        <!-- Addresses -->
        <div class="inv-addresses">
            <div class="inv-address-block">
                <h4>From (Seller)</h4>
                <div class="inv-address-name">{{ $settings['site_name'] ?? 'Al Barr Foods' }}</div>
                <div class="inv-address-line">
                    {{ $settings['site_address'] ?? 'Srinagar, Jammu & Kashmir, India' }}<br>
                    @if(!empty($settings['site_phone'])) Phone: {{ $settings['site_phone'] }}<br>@endif
                    @if(!empty($settings['site_email'])) Email: {{ $settings['site_email'] }}<br>@endif
                    @if(!empty($settings['site_gstin'])) GSTIN: {{ $settings['site_gstin'] }}<br>@endif
                    @if(!empty($settings['site_fssai'])) FSSAI: {{ $settings['site_fssai'] }}@endif
                </div>
            </div>
            <div class="inv-address-block">
                <h4>Bill To / Ship To</h4>
                <div class="inv-address-name">{{ $order->shipping_name }}</div>
                <div class="inv-address-line">
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_pincode }}<br>
                    @if($order->shipping_landmark) Landmark: {{ $order->shipping_landmark }}<br>@endif
                    Phone: {{ $order->shipping_phone }}
                    @if($order->shipping_alt_phone) / {{ $order->shipping_alt_phone }}@endif
                </div>
            </div>
        </div>

        <!-- Order Meta -->
        <div class="inv-meta-grid">
            <div class="inv-meta-item">
                <span class="inv-meta-label">Order Number</span>
                <span class="inv-meta-value">{{ $order->order_number }}</span>
            </div>
            <div class="inv-meta-item">
                <span class="inv-meta-label">Order Date</span>
                <span class="inv-meta-value">{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="inv-meta-item">
                <span class="inv-meta-label">Payment Method</span>
                <span class="inv-meta-value">{{ $order->payment_method }}</span>
            </div>
            <div class="inv-meta-item">
                <span class="inv-meta-label">Payment Status</span>
                <span class="inv-payment-badge {{ strtolower($order->payment_status) }}">{{ $order->payment_status }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <table class="inv-items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th>Item Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="item-name">{{ $item->title }}</div>
                        <div class="item-weight">{{ $item->weight }}</div>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td style="font-weight: 700;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="inv-totals">
            <div class="inv-totals-box">
                <div class="inv-total-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="inv-total-row discount">
                    <span>Discount</span>
                    <span>− ₹{{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                <div class="inv-total-row">
                    <span>Delivery Charge</span>
                    <span>₹{{ number_format($order->delivery_charge, 2) }}</span>
                </div>
                <div class="inv-total-row grand">
                    <span>Grand Total</span>
                    <span>₹{{ number_format($order->grand_total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="inv-footer">
        <div class="inv-footer-col">
            <h5>Terms & Conditions</h5>
            <p>
                Returns accepted within 7 days of delivery for unopened items.<br>
                All disputes subject to {{ $settings['site_city'] ?? 'Srinagar' }} jurisdiction.
            </p>
        </div>
        <div class="inv-footer-col" style="text-align: right;">
            <h5>Thank You</h5>
            <p>
                We appreciate your business!<br>
                {{ $settings['site_email'] ?? 'support@albarrfoods.com' }}
            </p>
        </div>
    </div>

    <div class="inv-watermark">
        This is a computer-generated invoice · {{ $settings['site_name'] ?? 'Al Barr Foods' }} · {{ now()->format('Y') }}
    </div>
</div>
@endforeach

</body>
</html>
