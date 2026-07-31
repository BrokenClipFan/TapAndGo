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
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            width: 100%;
            background-color: var(--pos-bg);
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
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .pos-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .pos-brand i {
            color: var(--theme-accent);
        }

        /* Responsive Main Container */
        .pos-workspace {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 1.5rem;
            width: 100%;
        }

        .terminal-card {
            width: 100%;
            max-width: 850px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin: auto 0;
        }

        .terminal-header {
            padding: 1.25rem 1.5rem;
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .terminal-body {
            padding: 1.5rem;
        }

        /* Input Group Form */
        .scanner-form {
            display: flex;
            width: 100%;
            align-items: center;
        }

        .scanner-input-group {
            position: relative;
            box-shadow: 0 4px 12px rgba(26, 67, 115, 0.08);
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            background: #ffffff;
            border: 2px solid var(--theme-primary);
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .scanner-input {
            border: none !important;
            padding: 1rem 1.25rem;
            flex-grow: 1;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 1px;
            outline: none;
            text-transform: uppercase;
            width: 100%;
            min-width: 0;
        }

        .scanner-btn {
            background-color: var(--theme-primary);
            color: white;
            border: none;
            width: 4rem;
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
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            max-height: 380px;
            overflow-y: auto;
            margin-bottom: 1.25rem;
            padding: 0.25rem;
        }

        .item-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .item-image-container {
            width: 100%;
            height: 120px;
            overflow: hidden;
            background-color: #f1f5f9;
        }

        .item-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-content {
            padding: 0.75rem;
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
            line-height: 1.2;
        }

        .item-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .item-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--theme-primary);
        }

        /* Buttons Layout */
        .action-buttons-group {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-custom {
            border: none;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.25rem;
            flex: 1 1 200px;
        }

        .btn-custom-success {
            background-color: var(--theme-success);
            color: white;
        }

        .btn-custom-success:hover {
            background-color: #059669;
        }

        .btn-custom-danger {
            background-color: var(--theme-danger);
            color: white;
        }

        .btn-custom-danger:hover {
            background-color: #dc2626;
        }

        .d-none {
            display: none !important;
        }

        /* Toast Alert */
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
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            max-width: 90vw;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Mobile Breakpoint Adjustments */
        @media (max-width: 576px) {
            .pos-workspace {
                padding: 0.75rem;
            }

            .terminal-body {
                padding: 1rem;
            }

            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                max-height: 300px;
            }

            .item-image-container {
                height: 90px;
            }
        }
    </style>
</head>

<body>

    <header class="pos-header">
        <a class="pos-brand" href="#">
            <i class="bi bi-lightning-fill"></i>
            <span>TapAndGo Kiosk Payment Terminal</span>
        </a>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span
                style="background: white; color: var(--text-dark); padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.85rem;">
                <i class="bi bi-shop text-primary"></i> Station #03
            </span>
            <div style="color: white; font-weight: 700; font-size: 0.9rem;">
                Cashier Terminal
            </div>
        </div>
    </header>

    <main class="pos-workspace">
        <div class="terminal-card">
            <div class="terminal-header">
                <div>
                    <h5 style="font-weight: 800; color: var(--text-dark); margin: 0;">Scan Kiosk Order</h5>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Enter or scan customer receipt
                        code</p>
                </div>
                <span
                    style="background-color: #ecfdf5; color: #059669; border: 1px solid #bbf7d0; padding: 0.3rem 0.6rem; border-radius: 0.35rem; font-size: 0.75rem; font-weight: 700;">
                    <i class="bi bi-wifi"></i> Ready for Code
                </span>
            </div>

            <div class="terminal-body">
                <!-- Input Scanner -->
                <div class="scanner-input-group">
                    <span style="display: flex; align-items: center; padding-left: 1.25rem; color: var(--text-muted);">
                        <i class="bi bi-qr-code-scan" style="color: var(--theme-primary); font-size: 1.5rem;"></i>
                    </span>
                    <form action="{{ route('cashier.order') }}" method="POST" class="scanner-form">
                        @csrf
                        <input type="text" name="code" class="scanner-input"
                            placeholder="ENTER CODE (E.G. 558D-E49A)" id="kiosk-code-input" autofocus required>
                        <button class="scanner-btn" type="submit" title="Fetch Kiosk Order">
                            <i class="bi bi-arrow-right-circle-fill" style="font-size: 1.5rem;"></i>
                        </button>
                    </form>
                </div>

                <!-- Empty State -->
                <div id="empty-state" style="text-align: center; padding: 3rem 1rem;" class="text-muted">
                    <i class="bi bi-receipt-cutoff"
                        style="font-size: 3.5rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                    <h6 style="font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Waiting for Customer
                        Code</h6>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Scan barcode or type the kiosk pass code
                        above.</p>
                </div>

                <!-- Active Loaded Order -->
                <div id="loaded-order-panel" class="d-none">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span
                                style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Order
                                Number</span>
                            <h4 style="font-weight: 800; color: var(--theme-primary); margin: 0;" id="display-order-id">
                                #6</h4>
                        </div>
                        <div style="text-align: right;">
                            <span
                                style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Pass
                                Code</span>
                            <div style="font-weight: 800; color: var(--theme-accent); font-size: 1.1rem;"
                                id="display-pass-code">558D-E49A</div>
                        </div>
                    </div>

                    <!-- Items Grid -->
                    <h6 style="font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Scanned Items</h6>
                    <div class="items-grid" id="kiosk-items-grid">
                        <!-- Populated by JS -->
                    </div>

                    <!-- Total Due -->
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-top: 2px solid var(--border-color); font-weight: 800; font-size: 1.2rem; color: var(--text-dark); margin-bottom: 1rem;">
                        <span>Total Due:</span>
                        <span style="color: var(--theme-primary);" id="display-order-total">₱0.00</span>
                    </div>

                    <!-- Actions -->
                    <div class="action-buttons-group">
                        <button class="btn-custom btn-custom-danger" onclick="cancelOrder()">
                            <i class="bi bi-trash3-fill"></i> Cancel Order
                        </button>
                        <button class="btn-custom btn-custom-success" onclick="processPayment()">
                            <i class="bi bi-cash-stack"></i> Accept Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Notification Toast -->
    <div class="custom-banner shadow" id="toast-banner">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="bi bi-info-circle-fill" id="toast-icon" style="font-size: 1.25rem;"></i>
            <div>
                <strong style="display: block; font-weight: 700; color: var(--text-dark); font-size: 0.9rem;"
                    id="toast-title">Notification</strong>
                <span style="font-size: 0.8rem;" id="toast-msg">Action processed.</span>
            </div>
        </div>
    </div>

    <script>
        // Storage asset base path generated by Laravel
        const storageAssetBase = "{{ asset('storage') }}";
        const fallbackImage = "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=80";

        let currentActiveOrder = null;

        const orderData = @json($order ?? null);
        if (orderData) {
            loadOrderUI(orderData);
        }

        function loadOrderUI(order) {
            currentActiveOrder = order;

            document.getElementById('empty-state').classList.add('d-none');
            document.getElementById('loaded-order-panel').classList.remove('d-none');

            document.getElementById('display-order-id').innerText = `#${order.id}`;
            document.getElementById('display-pass-code').innerText = order.order_code || order.code || 'N/A';

            const total = parseFloat(order.total_price || order.total || 0);
            document.getElementById('display-order-total').innerText =
                `₱${total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

            const itemsContainer = document.getElementById('kiosk-items-grid');
            itemsContainer.innerHTML = '';

            if (order.items && order.items.length > 0) {
                order.items.forEach(item => {
                    // Resolve image source URL correctly
                    let imageSrc = fallbackImage;
                    if (item.product && item.product.image_path) {
                        imageSrc = `${storageAssetBase}/${item.product.image_path.replace(/^\/+/, '')}`;
                    } else if (item.image) {
                        imageSrc = item.image;
                    }

                    const itemName = item.name || (item.product ? item.product.name : 'Unknown Item');
                    const qty = item.quantity || item.qty || 1;
                    const price = parseFloat(item.price || (item.product ? item.product.price : 0));
                    const itemTotal = price * qty;

                    const card = document.createElement('div');
                    card.className = 'item-card';
                    card.innerHTML = `
                        <div class="item-image-container">
                            <img src="${imageSrc}" alt="${itemName}" class="item-image" onerror="this.onerror=null;this.src='${fallbackImage}';">
                        </div>
                        <div class="item-content">
                            <div>
                                <div class="item-name">${itemName}</div>
                                <div class="item-meta">Qty: ${qty}</div>
                            </div>
                            <div class="item-footer">
                                <span class="item-price">₱${itemTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                            </div>
                        </div>
                    `;
                    itemsContainer.appendChild(card);
                });
            }
        }

        function cancelOrder() {
            if (!currentActiveOrder) return;
            const codeToCancel = currentActiveOrder.order_code || currentActiveOrder.code || currentActiveOrder.id;

            resetTerminal();
            showToast(`Order #${codeToCancel} was cancelled and voided.`, "error");
        }

        function processPayment() {
            if (!currentActiveOrder) return;
            const completedId = currentActiveOrder.id;

            resetTerminal();
            showToast(`Payment accepted! Order #${completedId} completed.`, "success");
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
                toastTitle.innerText = "Order Cancelled / Error";
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
