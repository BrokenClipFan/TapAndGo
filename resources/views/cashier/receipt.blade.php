<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Receipt - Tap&Go</title>

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --theme-primary: #1a4373;
            --theme-accent: #f97316;
            --theme-dark: #0f172a;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --bg-body: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* Top Action Bar (Hidden when printing) */
        .actions-bar {
            width: 100%;
            max-width: 400px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }

        .btn-action {
            border: none;
            border-radius: 0.5rem;
            padding: 0.6rem 1.25rem;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-print {
            background-color: var(--theme-primary);
            color: white;
        }

        .btn-print:hover {
            background-color: #113259;
        }

        .btn-back {
            background-color: #e2e8f0;
            color: var(--text-dark);
        }

        .btn-back:hover {
            background-color: #cbd5e1;
        }

        /* Receipt Card Container */
        .receipt-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 2rem 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            position: relative;
        }

        /* Header / Branding */
        .receipt-header {
            text-align: center;
            padding-bottom: 1.25rem;
            border-bottom: 2px dashed var(--border-color);
            margin-bottom: 1.25rem;
        }

        .receipt-logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 0.5rem;
            object-fit: contain;
        }

        .receipt-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Meta details */
        .receipt-meta {
            font-size: 0.825rem;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .receipt-meta-row {
            display: flex;
            justify-content: space-between;
        }

        .receipt-meta-row strong {
            color: var(--text-dark);
        }

        /* Table / Lists */
        .receipt-section-title {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .receipt-items {
            list-style: none;
            margin-bottom: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            font-size: 0.9rem;
        }

        .item-details {
            display: flex;
            flex-direction: column;
        }

        .item-name {
            font-weight: 700;
            color: var(--text-dark);
        }

        .item-subtext {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .item-price {
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Excluded section */
        .excluded-box {
            background-color: #fef2f2;
            border: 1px dashed #fca5a5;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .excluded-box .receipt-section-title {
            color: #991b1b;
            margin-bottom: 0.35rem;
        }

        .excluded-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #7f1d1d;
            margin-bottom: 0.25rem;
        }

        .excluded-item:last-child {
            margin-bottom: 0;
        }

        /* Totals Block */
        .receipt-totals {
            border-top: 2px dashed var(--border-color);
            padding-top: 1rem;
            margin-top: 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .total-row.grand-total {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--theme-primary);
            padding-top: 0.4rem;
            border-top: 1px solid var(--border-color);
            margin-top: 0.25rem;
        }

        /* Footer & Barcode */
        .receipt-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 2px dashed var(--border-color);
        }

        .receipt-footer p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }

        .barcode {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            font-size: 1.25rem;
            letter-spacing: 4px;
            background: #f1f5f9;
            padding: 0.5rem 1rem;
            display: inline-block;
            border-radius: 0.25rem;
            color: var(--text-dark);
        }

        /* Thermal Printer Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .actions-bar {
                display: none;
            }

            .receipt-card {
                box-shadow: none;
                border: none;
                width: 100%;
                max-width: 100%;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Top Action Navigation -->
    <div class="actions-bar">
        <a href="{{ route('cashier.terminal') ?? '#' }}" class="btn-action btn-back">
            <i class="bi bi-arrow-left"></i> Terminal
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            <i class="bi bi-printer-fill"></i> Print Receipt
        </button>
    </div>

    <!-- Printable Receipt -->
    <div class="receipt-card">

        <!-- Header with Official Logo -->
        <div class="receipt-header">
            <img src="{{ asset('Logo.png') }}" alt="Tap&Go Logo" class="receipt-logo">
            <div class="receipt-sub">Station #03 - Kiosk Payment Terminal</div>
        </div>

        <!-- Order Metadata -->
        <div class="receipt-meta">
            <div class="receipt-meta-row">
                <span>Order Reference:</span>
                <strong>#{{ $order->id ?? '6' }}</strong>
            </div>
            <div class="receipt-meta-row">
                <span>Pass Code:</span>
                <strong>{{ $order->order_code ?? ($order->code ?? '558D-E49A') }}</strong>
            </div>
            <div class="receipt-meta-row">
                <span>Date & Time:</span>
                <strong>{{ isset($order->updated_at) ? $order->updated_at->format('M d, Y - h:i A') : 'Aug 02, 2026 - 04:30 PM' }}</strong>
            </div>
            <div class="receipt-meta-row">
                <span>Payment Method:</span>
                <strong>Cash</strong>
            </div>
        </div>

        <!-- Purchased Items Section -->
        <div class="receipt-section-title">Purchased Items</div>
        <ul class="receipt-items">
            @if (isset($purchasedItems) && count($purchasedItems) > 0)
                @foreach ($purchasedItems as $item)
                    <li class="receipt-item">
                        <div class="item-details">
                            <span class="item-name">{{ $item['name'] }}</span>
                            <span class="item-subtext">{{ $item['quantity'] }} x
                                ₱{{ number_format($item['price'], 2) }}</span>
                        </div>
                        <span class="item-price">₱{{ number_format($item['quantity'] * $item['price'], 2) }}</span>
                    </li>
                @endforeach
            @else
                <!-- Fallback Preview Data -->
                <li class="receipt-item">
                    <div class="item-details">
                        <span class="item-name">Burger Special</span>
                        <span class="item-subtext">2 x ₱120.00</span>
                    </div>
                    <span class="item-price">₱240.00</span>
                </li>
                <li class="receipt-item">
                    <div class="item-details">
                        <span class="item-name">Iced Coffee</span>
                        <span class="item-subtext">1 x ₱85.00</span>
                    </div>
                    <span class="item-price">₱85.00</span>
                </li>
            @endif
        </ul>

        <!-- Items Left Behind / Excluded Section -->
        @if (isset($excludedItems) && count($excludedItems) > 0)
            <div class="excluded-box">
                <div class="receipt-section-title">Excluded / Left Behind</div>
                @foreach ($excludedItems as $item)
                    <div class="excluded-item">
                        <span>{{ $item['name'] }} ({{ $item['reason'] }})</span>
                        <span>Qty: {{ $item['quantity'] }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Static Preview Excluded Section -->
            <div class="excluded-box">
                <div class="receipt-section-title">Excluded / Left Behind</div>
                <div class="excluded-item">
                    <span>Crispy Fries (Out of Stock)</span>
                    <span>Qty: 1</span>
                </div>
            </div>
        @endif

        <!-- Totals breakdown -->
        <div class="receipt-totals">
            <div class="total-row">
                <span>Subtotal</span>
                <span>₱{{ number_format($totalDue ?? 325.0, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Tax (0%)</span>
                <span>₱0.00</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL PAID</span>
                <span>₱{{ number_format($totalDue ?? 325.0, 2) }}</span>
            </div>
        </div>

        <!-- Footer / Barcode -->
        <div class="receipt-footer">
            <p>Thank you for using Tap&Go!<br>Please present this receipt at the pickup counter.</p>
            <div class="barcode">*{{ $order->order_code ?? ($order->code ?? '558D-E49A') }}*</div>
        </div>

    </div>

</body>

</html>
