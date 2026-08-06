<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Kiosk Payment Terminal</title>

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

        :root {
            --theme-primary: #1a4373;
            --theme-primary-hover: #113259;
            --theme-accent: #f97316;
            --theme-dark: #0f172a;
            --theme-success: #10b981;
            --theme-danger: #ef4444;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --pos-bg: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            min-height: 100vh;
            width: 100%;
            background-color: var(--theme-dark);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Header Layout */
        .pos-header {
            background-color: var(--theme-primary);
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .pos-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .pos-brand-logo {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .pos-brand-title {
            font-weight: 800;
            font-size: 1.05rem;
            color: #ffffff;
            border-left: 1px solid rgba(255, 255, 255, 0.25);
            padding-left: 0.75rem;
            letter-spacing: -0.01em;
        }

        /* Responsive Workspace */
        .pos-workspace {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            width: 100%;
        }

        .terminal-card {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin: auto 0;
        }

        .terminal-header {
            padding: 1.25rem 1.75rem;
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .terminal-body {
            padding: 1.75rem;
            background-color: #ffffff;
        }

        /* Scanner Form */
        .scanner-input-group {
            position: relative;
            box-shadow: 0 4px 14px rgba(26, 67, 115, 0.08);
            border-radius: 1rem;
            overflow: hidden;
            display: flex;
            background: #ffffff;
            border: 2px solid var(--theme-primary);
            margin-bottom: 1.5rem;
            width: 100%;
            transition: border-color 0.2s;
        }

        .scanner-input-group:focus-within {
            border-color: var(--theme-accent);
        }

        .scanner-input {
            border: none !important;
            padding: 1.1rem 1.25rem;
            flex-grow: 1;
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            outline: none;
            text-transform: uppercase;
            width: 100%;
            min-width: 0;
            color: var(--theme-primary);
        }

        .scanner-btn {
            background-color: var(--theme-primary);
            color: white;
            border: none;
            width: 4.5rem;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .scanner-btn:hover {
            background-color: var(--theme-primary-hover);
        }

        /* Items Grid */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 1rem;
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 1.25rem;
            padding: 0.25rem;
        }

        .item-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .item-card.zero-qty,
        .item-card.outline-out-of-stock,
        .item-card.outline-unavailable {
            background: #f8fafc;
            opacity: 0.7;
        }

        .item-card.outline-out-of-stock,
        .item-card.outline-unavailable {
            border: 2px solid var(--theme-danger);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
        }

        .item-card.outline-invalid {
            border: 2px solid var(--theme-accent);
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.2);
        }

        .item-image-container {
            width: 100%;
            height: 125px;
            overflow: hidden;
            background-color: #f1f5f9;
            position: relative;
        }

        .item-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-content {
            padding: 0.85rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
        }

        .item-name {
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 0.2rem;
            line-height: 1.25;
        }

        .item-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 0.25rem;
        }

        .item-price {
            font-size: 1.05rem;
            font-weight: 900;
            color: var(--theme-primary);
        }

        /* Action Buttons */
        .action-buttons-group {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-custom {
            border: none;
            border-radius: 0.85rem;
            font-weight: 800;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem 1.25rem;
            flex: 1 1 200px;
        }

        .btn-custom-success {
            background-color: var(--theme-success);
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        }

        .btn-custom-success:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        .btn-custom-danger {
            background-color: var(--theme-danger);
            color: white;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        }

        .btn-custom-danger:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }

        .btn-custom-secondary {
            background-color: #e2e8f0;
            color: var(--text-dark);
        }

        .btn-custom-secondary:hover {
            background-color: #cbd5e1;
        }

        .d-none {
            display: none !important;
        }

        /* Notifications & Modals */
        .custom-banner {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            display: none;
            animation: slideIn 0.3s forwards;
            background-color: #dcfce7;
            border: 2px solid #bbf7d0;
            color: #14532d;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            max-width: 90vw;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(6px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.2s ease-out;
        }

        .modal-card {
            background: #ffffff;
            width: 100%;
            max-width: 550px;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            background-color: var(--theme-primary);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.7rem 0.85rem;
            border-radius: 0.75rem;
            background: #f8fafc;
            font-size: 0.9rem;
            border: 1px solid var(--border-color);
        }

        .badge-status {
            font-size: 0.65rem;
            font-weight: 800;
            padding: 0.25rem 0.55rem;
            border-radius: 6px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-danger {
            background: var(--theme-danger);
        }

        .badge-warning {
            background: var(--theme-accent);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 576px) {
            .pos-workspace {
                padding: 0.75rem;
            }

            .terminal-body {
                padding: 1rem;
            }

            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                max-height: 320px;
            }

            .item-image-container {
                height: 95px;
            }

            .pos-brand-title {
                display: none;
            }
        }

        .idInput {
            display: none;
        }
    </style>
</head>

<body>
    @include('partials.splash-screen', [
        'title' => 'Tap&Go',
        'subtitle' => 'Payment Terminal',
    ])
    <header class="pos-header">
        <a class="pos-brand" href="#">
            <img src="{{ asset('Logo.png') }}" alt="Tap&Go Logo" class="pos-brand-logo">
            <span class="pos-brand-title">Kiosk Payment Terminal</span>
        </a>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span
                style="background: rgba(255,255,255,0.15); color: #ffffff; padding: 0.4rem 0.8rem; border-radius: 0.6rem; font-weight: 800; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.2);">
                <i class="bi bi-shop text-orange-400"></i> Station #03
            </span>
            <div
                style="color: white; font-weight: 800; font-size: 0.85rem; background: var(--theme-accent); padding: 0.4rem 0.8rem; border-radius: 0.6rem;">
                Cashier Active
            </div>
        </div>
    </header>

    <main class="pos-workspace">
        <div class="terminal-card">
            <div class="terminal-header">
                <div>
                    <h5 style="font-weight: 900; color: var(--text-dark); margin: 0; font-size: 1.15rem;">Scan Kiosk
                        Order</h5>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0; font-weight: 500;">Enter or scan
                        customer receipt pass code</p>
                </div>
                <span
                    style="background-color: #ecfdf5; color: #059669; border: 1px solid #bbf7d0; padding: 0.4rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; gap: 0.35rem;">
                    <i class="bi bi-wifi text-emerald-500"></i> Terminal Ready
                </span>
            </div>

            <div class="terminal-body">
                <!-- Input Scanner -->
                <div class="scanner-input-group">
                    <span
                        style="display: flex; align-items: center; padding-left: 1.25rem; color: var(--theme-primary);">
                        <i class="bi bi-qr-code-scan" style="font-size: 1.5rem;"></i>
                    </span>
                    <form action="{{ route('cashier.order') }}" method="POST" class="scanner-form"
                        style="display:flex; width:100%;">
                        @csrf
                        <input type="text" name="code" class="scanner-input"
                            placeholder="ENTER ORDER CODE (E.G. 558D-E49A)" id="kiosk-code-input" autofocus required>
                        <button class="scanner-btn" type="submit" title="Fetch Kiosk Order">
                            <i class="bi bi-arrow-right-circle-fill" style="font-size: 1.6rem;"></i>
                        </button>
                    </form>
                </div>

                <!-- Empty State -->
                <div id="empty-state" style="text-align: center; padding: 3.5rem 1rem;" class="text-muted">
                    <i class="bi bi-receipt-cutoff"
                        style="font-size: 4rem; color: #cbd5e1; display: block; margin-bottom: 0.75rem;"></i>
                    <h6 style="font-weight: 800; color: var(--text-dark); margin-bottom: 0.25rem; font-size: 1.1rem;">
                        Waiting for Customer Code</h6>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Scan barcode or type the kiosk pass code
                        above.</p>
                </div>

                <!-- Active Loaded Order -->
                <div id="loaded-order-panel" class="d-none">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 2px dashed var(--border-color); flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span
                                style="font-size: 0.7rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; tracking-wider;">Order
                                Ticket</span>
                            <h4 style="font-weight: 900; color: var(--theme-primary); margin: 0; font-size: 1.5rem;"
                                id="display-order-id">#6</h4>
                        </div>
                        <div style="text-align: right;">
                            <span
                                style="font-size: 0.7rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Pass
                                Code</span>
                            <div style="font-weight: 900; color: var(--theme-accent); font-size: 1.2rem; font-family: monospace;"
                                id="display-pass-code">558D-E49A</div>
                        </div>
                    </div>

                    <!-- Items Grid -->
                    <h6
                        style="font-weight: 800; color: var(--text-dark); margin-bottom: 0.6rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        Scanned Order Items</h6>
                    <div class="items-grid" id="kiosk-items-grid">
                        <!-- Populated dynamically via JS -->
                    </div>

                    <!-- Total Due -->
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-top: 2px solid var(--border-color); font-weight: 900; font-size: 1.25rem; color: var(--text-dark); margin-bottom: 1.25rem;">
                        <span>Total Amount Due:</span>
                        <span style="color: var(--theme-primary); font-size: 1.5rem;"
                            id="display-order-total">₱0.00</span>
                    </div>

                    <!-- Actions -->
                    <div class="action-buttons-group">
                        <form action="{{ route('cashier.order.cancel') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="number" name="id" class="idInput">
                            <button type="submit" class="btn-custom btn-custom-danger">
                                <i class="bi bi-trash3-fill"></i> Cancel Order
                            </button>
                        </form>
                        <form action="{{ route('cashier.order.pay') }}" method="POST" id="payment-form">
                            @csrf
                            @method('PUT')
                            <input type="number" name="id" class="idInput">
                            <button type="button" onclick="openConfirmationModal()"
                                class="btn-custom btn-custom-success">
                                <i class="bi bi-cash-stack"></i> Accept Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div class="modal-overlay d-none" id="confirmation-modal">
        <div class="modal-card">
            <div class="modal-header">
                <h5
                    style="font-weight: 900; margin: 0; display: flex; align-items: center; gap: 0.5rem; font-size: 1.1rem;">
                    <i class="bi bi-cart-check-fill" style="color: var(--theme-accent);"></i> Confirm Order Checkout
                </h5>
                <button type="button" onclick="closeConfirmationModal()"
                    style="background: none; border: none; color: white; font-size: 1.25rem; cursor: pointer;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Included Items -->
                <div>
                    <h6
                        style="font-weight: 800; color: var(--theme-success); font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.35rem; letter-spacing: 0.5px;">
                        <i class="bi bi-check-circle-fill"></i> Items to be Purchased
                    </h6>
                    <ul class="summary-list" id="modal-purchased-items">
                        <!-- Populated by JS -->
                    </ul>
                </div>

                <!-- Left Behind / Excluded Items -->
                <div id="modal-excluded-section" class="d-none">
                    <h6
                        style="font-weight: 800; color: var(--theme-danger); font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.35rem; letter-spacing: 0.5px;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Items Excluded / Unavailable
                    </h6>
                    <ul class="summary-list" id="modal-excluded-items">
                        <!-- Populated by JS -->
                    </ul>
                </div>

                <!-- Total Summary -->
                <div
                    style="border-top: 2px solid var(--border-color); padding-top: 0.85rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; color: var(--text-dark);">Final Total Due:</span>
                    <span style="font-weight: 900; font-size: 1.4rem; color: var(--theme-primary);"
                        id="modal-final-total">₱0.00</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeConfirmationModal()" class="btn-custom btn-custom-secondary"
                    style="flex: 0 0 auto; padding: 0.65rem 1.25rem;">
                    Back / Edit
                </button>
                <button type="button" onclick="submitFinalPayment()" class="btn-custom btn-custom-success"
                    style="flex: 1 1 auto; padding: 0.65rem 1.25rem;">
                    <i class="bi bi-check2-circle"></i> Confirm & Pay
                </button>
            </div>
        </div>
    </div>

    <!-- Notification Toast -->
    <div class="custom-banner shadow" id="toast-banner">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="bi bi-info-circle-fill" id="toast-icon" style="font-size: 1.25rem;"></i>
            <div>
                <strong style="display: block; font-weight: 800; color: var(--text-dark); font-size: 0.9rem;"
                    id="toast-title">Notification</strong>
                <span style="font-size: 0.8rem; font-weight: 500;" id="toast-msg">Action processed.</span>
            </div>
        </div>
    </div>

    <script>
        // Storage asset base path generated by Laravel
        const storageAssetBase = "{{ asset('storage') }}";
        const fallbackImage = "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=80";
        const idInputs = document.querySelectorAll('.idInput');

        let currentActiveOrder = null;

        // Arrays and stock mapping injected from Controller checks
        const outOfStockItems = @json($outOfStockItems ?? []);
        const unavailableItems = @json($unavailableItems ?? []);
        const invalidItems = @json($invalidItems ?? []);
        const itemStocks = @json($itemStocks ?? []);

        const orderData = @json($order ?? null);
        if (orderData) {
            loadOrderUI(orderData);
        }

        // Show session errors/success messages on load
        @if (session('success'))
            showToast("{{ session('success') }}", "success");
        @endif
        @if (session('error'))
            showToast("{{ session('error') }}", "error");
        @endif

        function loadOrderUI(order) {
            currentActiveOrder = order;

            document.getElementById('empty-state').classList.add('d-none');
            document.getElementById('loaded-order-panel').classList.remove('d-none');

            document.getElementById('display-order-id').innerText = `#${order.id}`;
            document.getElementById('display-pass-code').innerText = order.order_code || order.code || 'N/A';

            idInputs[0].value = order.id;
            idInputs[1].value = order.id;

            renderItems(order.items);
        }

        function renderItems(items) {
            const itemsContainer = document.getElementById('kiosk-items-grid');
            itemsContainer.innerHTML = '';

            let calculatedTotal = 0;

            if (items && items.length > 0) {
                items.forEach(item => {
                    let imageSrc = fallbackImage;
                    if (item.product && item.product.image_path) {
                        imageSrc = `${storageAssetBase}/${item.product.image_path.replace(/^\/+/, '')}`;
                    } else if (item.image) {
                        imageSrc = item.image;
                    }

                    const itemName = item.name || (item.product ? item.product.name : 'Unknown Item');
                    const qty = item.quantity !== undefined ? item.quantity : (item.qty || 1);
                    const price = parseFloat(item.price || (item.product ? item.product.price : 0));
                    const itemTotal = price * qty;

                    const maxStock = itemStocks[item.id] !== undefined ? parseInt(itemStocks[item.id]) : (item
                        .product ? parseInt(item.product.stock) : 9999);

                    // Determine Badges and Classes
                    let cardOutlineClass = '';
                    let badgeHtml = '';
                    let isButtonDisabled = false;
                    let isProblematic = false;

                    let isCurrentlyInvalid = invalidItems.includes(item.id);
                    if (isCurrentlyInvalid && qty <= maxStock) {
                        isCurrentlyInvalid = false;
                    }

                    if (outOfStockItems.includes(item.id)) {
                        cardOutlineClass = 'outline-out-of-stock';
                        isButtonDisabled = true;
                        isProblematic = true;
                        badgeHtml =
                            '<div style="position: absolute; bottom: 8px; left: 8px; z-index: 2;"><span class="badge-status badge-danger">OUT OF STOCK</span></div>';
                    } else if (unavailableItems.includes(item.id)) {
                        cardOutlineClass = 'outline-unavailable';
                        isButtonDisabled = true;
                        isProblematic = true;
                        badgeHtml =
                            '<div style="position: absolute; bottom: 8px; left: 8px; z-index: 2;"><span class="badge-status badge-danger">UNAVAILABLE</span></div>';
                    } else if (isCurrentlyInvalid) {
                        cardOutlineClass = 'outline-invalid';
                        isProblematic = true;
                        badgeHtml =
                            '<div style="position: absolute; bottom: 8px; left: 8px; z-index: 2;"><span class="badge-status badge-warning">INVALID QTY</span></div>';
                    }

                    if (qty > 0 && !isProblematic) {
                        calculatedTotal += itemTotal;
                    }

                    const minusDisabledAttr = (isButtonDisabled || qty <= 0) ?
                        'disabled style="background: #e2e8f0; color: #94a3b8; cursor: not-allowed; border: none; padding: 0.25rem 0.6rem;"' :
                        'style="background: #f1f5f9; border: none; padding: 0.25rem 0.6rem; cursor: pointer;"';
                    const plusDisabledAttr = (isButtonDisabled || qty >= maxStock) ?
                        'disabled style="background: #e2e8f0; color: #94a3b8; cursor: not-allowed; border: none; padding: 0.25rem 0.6rem;"' :
                        'style="background: #f1f5f9; border: none; padding: 0.25rem 0.6rem; cursor: pointer;"';

                    const card = document.createElement('div');
                    card.className = `item-card ${qty === 0 ? 'zero-qty' : ''} ${cardOutlineClass}`;
                    card.innerHTML = `
                        <div class="item-image-container">
                            <img src="${imageSrc}" alt="${itemName}" class="item-image" onerror="this.onerror=null;this.src='${fallbackImage}';">
                            ${badgeHtml}
                        </div>
                        <div class="item-content">
                            <div>
                                <div class="item-name">${itemName}</div>
                                <div class="item-meta">₱${price.toFixed(2)} each (Stock: ${maxStock})</div>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin: 0.5rem 0;">
                                <div style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: 6px; overflow:hidden; background: #fff;">
                                    <button type="button" onclick="updateQuantity(${item.id}, -1)" ${minusDisabledAttr}><i class="bi bi-dash"></i></button>
                                    <span style="padding: 0 0.6rem; font-weight: 800; font-size: 0.85rem;">${qty}</span>
                                    <button type="button" onclick="updateQuantity(${item.id}, 1)" ${plusDisabledAttr}><i class="bi bi-plus"></i></button>
                                </div>
                            </div>
                            <div class="item-footer">
                                <span class="item-price">₱${itemTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                            </div>
                        </div>
                    `;
                    itemsContainer.appendChild(card);
                });
            }

            document.getElementById('display-order-total').innerText =
                `₱${calculatedTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }

        function updateQuantity(itemId, change) {
            if (!currentActiveOrder || !currentActiveOrder.items) return;

            currentActiveOrder.items = currentActiveOrder.items.map(item => {
                if (item.id === itemId) {
                    let currentQty = item.quantity !== undefined ? item.quantity : (item.qty || 1);
                    let maxStock = itemStocks[item.id] !== undefined ? parseInt(itemStocks[item.id]) : 9999;
                    let newQty = currentQty + change;

                    if (newQty < 0) newQty = 0;
                    if (change > 0 && newQty > maxStock) newQty = maxStock;

                    item.quantity = newQty;
                    item.qty = newQty;
                }
                return item;
            });

            renderItems(currentActiveOrder.items);
        }

        // Modal triggers and rendering logic
        function openConfirmationModal() {
            if (!currentActiveOrder || !currentActiveOrder.items) return;

            const purchasedContainer = document.getElementById('modal-purchased-items');
            const excludedContainer = document.getElementById('modal-excluded-items');
            const excludedSection = document.getElementById('modal-excluded-section');

            purchasedContainer.innerHTML = '';
            excludedContainer.innerHTML = '';

            let grandTotal = 0;
            let excludedCount = 0;

            currentActiveOrder.items.forEach(item => {
                const itemName = item.name || (item.product ? item.product.name : 'Unknown Item');
                const qty = item.quantity !== undefined ? item.quantity : (item.qty || 1);
                const price = parseFloat(item.price || (item.product ? item.product.price : 0));
                const itemTotal = price * qty;
                const maxStock = itemStocks[item.id] !== undefined ? parseInt(itemStocks[item.id]) : 9999;

                let isCurrentlyInvalid = invalidItems.includes(item.id) && qty > maxStock;
                let isOutOfStock = outOfStockItems.includes(item.id);
                let isUnavailable = unavailableItems.includes(item.id);

                if (isOutOfStock || isUnavailable || isCurrentlyInvalid || qty === 0) {
                    excludedCount++;
                    let reasonBadge = '';
                    if (isOutOfStock) reasonBadge = '<span class="badge-status badge-danger">Out of Stock</span>';
                    else if (isUnavailable) reasonBadge =
                        '<span class="badge-status badge-danger">Unavailable</span>';
                    else if (isCurrentlyInvalid) reasonBadge =
                        '<span class="badge-status badge-warning">Invalid Qty</span>';
                    else if (qty === 0) reasonBadge = '<span class="badge-status badge-warning">Qty Zero</span>';

                    excludedContainer.innerHTML += `
                        <li class="summary-item">
                            <div>
                                <strong>${itemName}</strong>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">Qty: ${qty}</div>
                            </div>
                            ${reasonBadge}
                        </li>
                    `;
                } else {
                    grandTotal += itemTotal;
                    purchasedContainer.innerHTML += `
                        <li class="summary-item">
                            <div>
                                <strong>${itemName}</strong>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">${qty} x ₱${price.toFixed(2)}</div>
                            </div>
                            <strong style="color: var(--theme-primary);">₱${itemTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
                        </li>
                    `;
                }
            });

            if (purchasedContainer.children.length === 0) {
                purchasedContainer.innerHTML =
                    '<li class="summary-item" style="color: var(--text-muted);">No valid items available for purchase.</li>';
            }

            if (excludedCount > 0) {
                excludedSection.classList.remove('d-none');
            } else {
                excludedSection.classList.add('d-none');
            }

            document.getElementById('modal-final-total').innerText =
                `₱${grandTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            document.getElementById('confirmation-modal').classList.remove('d-none');
        }

        function closeConfirmationModal() {
            document.getElementById('confirmation-modal').classList.add('d-none');
        }

        function submitFinalPayment() {
            const form = document.getElementById('payment-form');
            form.querySelectorAll('.dynamic-item-input').forEach(el => el.remove());

            if (currentActiveOrder && currentActiveOrder.items) {
                currentActiveOrder.items.forEach((item, index) => {
                    let inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.className = 'dynamic-item-input';
                    inputId.name = `items[${index}][id]`;
                    inputId.value = item.id;
                    form.appendChild(inputId);

                    let inputProductId = document.createElement('input');
                    inputProductId.type = 'hidden';
                    inputProductId.className = 'dynamic-item-input';
                    inputProductId.name = `items[${index}][product_id]`;
                    inputProductId.value = item.product_id || (item.product ? item.product.id : '');
                    form.appendChild(inputProductId);

                    let inputQty = document.createElement('input');
                    inputQty.type = 'hidden';
                    inputQty.className = 'dynamic-item-input';
                    inputQty.name = `items[${index}][quantity]`;
                    inputQty.value = item.quantity !== undefined ? item.quantity : (item.qty || 1);
                    form.appendChild(inputQty);
                });
            }

            form.submit();
        }

        function resetTerminal() {
            currentActiveOrder = null;
            document.getElementById('empty-state').classList.remove('d-none');
            document.getElementById('loaded-order-panel').classList.add('d-none');
            document.getElementById('kiosk-code-input').focus();
        }

        function showToast(message, type) {
            const banner = document.getElementById('toast-banner');
            const toastMsg = document.getElementById('toast-msg');
            const toastTitle = document.getElementById('toast-title');
            const toastIcon = document.getElementById('toast-icon');

            toastMsg.innerText = message;

            if (type === "warning") {
                banner.style.backgroundColor = "#fffbeb";
                banner.style.borderColor = "#fef3c7";
                banner.style.color = "#78350f";
                toastTitle.innerText = "Warning";
                toastIcon.className = "bi bi-exclamation-triangle-fill";
            } else if (type === "error") {
                banner.style.backgroundColor = "#fef2f2";
                banner.style.borderColor = "#fca5a5";
                banner.style.color = "#7f1d1d";
                toastTitle.innerText = "Action Failed";
                toastIcon.className = "bi bi-x-circle-fill";
            } else {
                banner.style.backgroundColor = "#dcfce7";
                banner.style.borderColor = "#bbf7d0";
                banner.style.color = "#14532d";
                toastTitle.innerText = "Success";
                toastIcon.className = "bi bi-check-circle-fill";
            }

            banner.style.display = 'block';
            setTimeout(() => {
                banner.style.display = 'none';
            }, 3500);
        }
    </script>

</body>

</html>
