<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Cashier POS Terminal</title>

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Modern Reset & Dynamic Brand Theme Engine */
        :root {
            --theme-primary: #1a4373;        /* TapAndGo Core Deep Blue */
            --theme-primary-hover: #113259;  /* Darker Blue */
            --theme-accent: #f97316;         /* TapAndGo Vibrant Orange */
            --theme-accent-hover: #ea580c;   /* Darker Orange */
            --theme-dark: #0f172a;           /* Clean Off-Black */
            --theme-success: #10b981;        /* Clean Green */
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

        /* Strict Fit Screen Constraints */
        html, body {
            height: 100vh;
            width: 100vw;
            overflow: hidden; 
            background-color: var(--pos-bg);
            display: flex;
            flex-direction: column;
        }

        /* Nav Layout */
        .pos-header {
            background-color: var(--theme-primary);
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            z-index: 100;
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
        }

        .pos-brand i {
            color: var(--theme-accent);
        }

        /* Main Workspace Container Grid */
        .pos-workspace {
            flex-grow: 1;
            display: flex;
            min-height: 0; /* Critical for inner scrolling columns */
            width: 100vw;
        }

        /* Left column: Quick Nav Sidebar */
        .pos-sidebar {
            width: 80px;
            background-color: var(--theme-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            gap: 1.5rem;
            flex-shrink: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-btn {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            border: none;
            background: transparent;
            color: rgba(255,255,255,0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-btn:hover, .sidebar-btn.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--theme-accent);
        }

        .sidebar-btn .badge-counter {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: var(--theme-accent);
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 50rem;
            font-weight: 700;
        }

        /* Core Column Panes */
        .pos-col-queue {
            width: 320px;
            flex-shrink: 0;
            border-right: 1px solid var(--border-color);
            background: white;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .pos-col-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            background-color: var(--pos-bg);
            border-right: 1px solid var(--border-color);
        }

        .pos-col-cart {
            width: 380px;
            flex-shrink: 0;
            background: white;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        /* Rigid internal scrolling headers/bodies */
        .pane-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            background-color: white;
            flex-shrink: 0;
        }

        .pane-body {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1.25rem;
            min-height: 0;
        }

        /* Beautiful Scrollbar design for cashiers fast flow */
        .pane-body::-webkit-scrollbar, .product-grid::-webkit-scrollbar {
            width: 6px;
        }
        .pane-body::-webkit-scrollbar-track, .product-grid::-webkit-scrollbar-track {
            background: transparent;
        }
        .pane-body::-webkit-scrollbar-thumb, .product-grid::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        /* Order Cards in the Queue */
        .order-ticket-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }

        .order-ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .order-ticket-card.active {
            border-left: 5px solid var(--theme-accent);
            border-color: var(--theme-primary);
            background-color: rgba(26, 67, 115, 0.02);
        }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 50rem;
        }

        .status-ready {
            background-color: #fff7ed;
            color: #ea580c;
        }

        .status-completed {
            background-color: #ecfdf5;
            color: #059669;
        }

        /* Active Order Processing Section */
        .processing-box {
            background: white;
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1.5rem;
            margin-bottom: 1.25rem;
        }

        /* Interactive Scan Input box */
        .scanner-input-group {
            position: relative;
            box-shadow: 0 4px 12px rgba(26, 67, 115, 0.08);
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            background: #ffffff;
            border: 2px solid var(--theme-primary);
        }

        .scanner-input {
            border: none !important;
            padding: 1rem 1.25rem;
            flex-grow: 1;
            font-size: 1.1rem;
            outline: none;
        }

        .scanner-btn {
            background-color: var(--theme-primary);
            color: white;
            border: none;
            width: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .scanner-btn:hover {
            background-color: var(--theme-primary-hover);
        }

        /* Product Catalog Grid styling for Walk-In orders */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            overflow-y: auto;
            max-height: 280px;
            padding-right: 5px;
        }

        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background: white;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .product-card:hover {
            transform: scale(1.02);
            border-color: var(--theme-accent);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.08);
        }

        .product-icon {
            font-size: 1.75rem;
            color: var(--theme-primary);
            margin-bottom: 0.25rem;
        }

        /* Cart Receipt Preview items */
        .cart-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0;
            border-bottom: 1px dashed var(--border-color);
            font-size: 0.85rem;
        }

        .cart-qty-btn {
            width: 24px;
            height: 24px;
            padding: 0;
            line-height: 1;
            font-size: 0.75rem;
            border: 1px solid var(--border-color);
            background: #ffffff;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .cart-qty-btn:hover {
            background-color: var(--theme-light);
        }

        /* Premium Customized action buttons */
        .btn-custom {
            border: none;
            border-radius: 0.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
        }

        .btn-custom-primary {
            background-color: var(--theme-primary);
            color: white;
            padding: 0.9rem;
        }

        .btn-custom-primary:hover {
            background-color: var(--theme-primary-hover);
        }

        .btn-custom-success {
            background-color: var(--theme-success);
            color: white;
            padding: 0.9rem;
        }

        .btn-custom-success:hover {
            background-color: #059669;
        }

        .btn-custom-danger {
            background-color: #ef4444;
            color: white;
            padding: 0.6rem 1rem;
            width: auto;
        }

        .btn-custom-danger:hover {
            background-color: #dc2626;
        }

        /* Critical Fallback helpers to fix the visual bugs from image_83e5e9.png */
        .d-none {
            display: none !important;
        }

        .hidden-metadata {
            display: none !important;
        }

        /* Customized modal notification banner instead of default alert() */
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
            padding: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-light">

    <!-- Brand POS Header -->
    <header class="pos-header">
        <a class="pos-brand" href="#">
            <i class="bi bi-lightning-fill"></i> 
            <span>TapAndGo POS Terminal</span>
        </a>
        <div class="d-flex align-items-center gap-3" style="display: flex; align-items: center; gap: 1rem;">
            <span class="badge bg-light text-dark fw-bold px-3 py-2 d-none d-md-block" style="background: white; color: var(--text-dark); padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 700;">
                <i class="bi bi-shop me-1 text-primary"></i> Station #03
            </span>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--theme-primary); font-weight: 700;">
                    JD
                </div>
                <div class="d-none d-sm-block text-start" style="line-height: 1.1; color: white;">
                    <p class="small mb-0 fw-bold" style="font-weight: 700; font-size: 0.9rem;">John Doe</p>
                    <span class="text-white-50" style="font-size: 0.75rem; opacity: 0.7;">Cashier Manager</span>
                </div>
            </div>
        </div>
    </header>

    <!-- App Wrapper Container -->
    <main class="pos-workspace">
        
        <!-- Left Side: POS Sidebar Nav controllers -->
        <nav class="pos-sidebar">
            <button class="sidebar-btn active" title="Active Orders Queue">
                <i class="bi bi-collection-play-fill"></i>
                <span class="badge-counter" id="live-queue-counter">1</span>
            </button>
            <button class="sidebar-btn" title="Walk-In POS Grid">
                <i class="bi bi-cart-plus-fill"></i>
            </button>
            <button class="sidebar-btn" title="Complete Order History">
                <i class="bi bi-clock-history"></i>
            </button>
            <div style="margin-top: auto;">
                <button class="sidebar-btn" title="Terminal Settings">
                    <i class="bi bi-sliders2"></i>
                </button>
            </div>
        </nav>

        <!-- Column 1: Live pickup Queue tracker -->
        <section class="pos-col-queue">
            <div class="pane-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h6 style="font-weight: 700; color: var(--text-dark);">Active Pickups</h6>
                    <span style="background-color: var(--theme-primary); color: white; padding: 0.2rem 0.6rem; border-radius: 50rem; font-size: 0.75rem;" id="live-active-tag">1 Active</span>
                </div>
                <div style="margin-top: 0.5rem;">
                    <input type="text" class="form-control form-control-sm" style="width: 100%; padding: 0.4rem; border: 1px solid var(--border-color); border-radius: 0.35rem;" placeholder="Search Order ID..." id="queue-search">
                </div>
            </div>
            
            <div class="pane-body" id="order-queue-list">
                <!-- Preset Simulated Order Card #1 (Tied to the user's Order Pass page) -->
                <div class="order-ticket-card active" onclick="selectOrder('TG-94820')" id="card-TG-94820">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                        <span style="font-weight: 700; color: var(--theme-primary);">#TG-94820</span>
                        <span class="status-badge status-ready" id="status-tag-TG-94820">Ready to Scan</span>
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                        <i class="bi bi-clock"></i> Placed 12 mins ago
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                        <span style="color: var(--text-dark);">Classic Cheeseburger Deluxe...</span>
                        <strong style="color: var(--text-dark);">$20.00</strong>
                    </div>
                    <!-- Hidden elements holding detailed order objects (Uses robust direct style hiding rule to prevent leakage) -->
                    <div class="hidden-metadata" style="display: none !important;">
                        {
                            "id": "TG-94820",
                            "code": "837-D0C",
                            "items": [
                                {"name": "Classic Cheeseburger Deluxe", "qty": 1, "price": 12.50},
                                {"name": "Crispy Cajun Fries (Large)", "qty": 1, "price": 4.50},
                                {"name": "House Brewed Iced Tea", "qty": 1, "price": 3.00}
                            ],
                            "total": 20.00,
                            "timestamp": "12 mins ago"
                        }
                    </div>
                </div>
            </div>
        </section>

        <!-- Column 2: Order Validation / Scanner Emulator -->
        <section class="pos-col-main">
            <div class="pane-header" style="border-bottom: none;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 style="font-weight: 700; color: var(--text-dark); font-size: 1.1rem;">Validation Terminal</h5>
                    <div>
                        <span style="background-color: #ecfdf5; color: #059669; border: 1px solid #bbf7d0; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                            <i class="bi bi-wifi"></i> Scanner Online
                        </span>
                    </div>
                </div>
            </div>

            <!-- Scrollable validation frame -->
            <div class="pane-body">
                
                <!-- Verification Scanner Input box -->
                <div class="processing-box">
                    <h6 style="font-weight: 700; color: var(--text-dark); margin-bottom: 0.75rem;">Scan or Input Verification Pass Code</h6>
                    <div class="scanner-input-group">
                        <span style="display: flex; align-items: center; padding-left: 1rem; color: var(--text-muted);">
                            <i class="bi bi-qr-code-scan" style="color: var(--theme-primary); font-size: 1.25rem;"></i>
                        </span>
                        <input type="text" class="scanner-input" placeholder="E.g. 837-D0C" id="manual-code-input" autofocus>
                        <button class="scanner-btn" type="button" onclick="validateManualCode()" title="Process Scan">
                            <i class="bi bi-arrow-right-circle" style="font-size: 1.25rem;"></i>
                        </button>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">
                        <i class="bi bi-info-circle"></i> Enter the alphanumeric pass code displayed on customer's active screen.
                    </div>
                </div>

                <!-- Verification Panel details (Toggles dynamic classes) -->
                <div class="processing-box" id="verification-display-pane" style="position: relative;">
                    
                    <!-- Empty State (Hidden when active order loaded) -->
                    <div class="text-center py-5 text-muted d-none" id="empty-state-loader" style="text-align: center; padding: 3rem 0;">
                        <i class="bi bi-qr-code" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem; display: block;"></i>
                        <h6 style="font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Waiting for Scanner Event</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Use scanner gun or type the active customer code above.</p>
                    </div>

                    <!-- Populated State details (Now defaults to displayed using our corrected state engine) -->
                    <div id="loaded-state-details">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1rem;">
                            <div>
                                <h6 style="font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Verified Live Order: <span id="v-order-id" style="color: var(--theme-primary);">#TG-94820</span></h6>
                                <p style="color: var(--text-muted); font-size: 0.85rem;">Pass Code: <strong id="v-pass-code" style="color: var(--theme-accent); text-transform: uppercase;">837-D0C</strong></p>
                            </div>
                            <span style="background-color: var(--theme-accent); color: white; padding: 0.35rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700;" id="v-status-badge">ACTIVE</span>
                        </div>

                        <!-- Scanned Items Review List -->
                        <h6 style="font-weight: 700; color: var(--text-dark); margin-bottom: 0.75rem;">Release Checklist</h5>
                        <div id="v-items-checklist" style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem;">
                            <!-- Populated on load or select click via js -->
                        </div>

                        <!-- Release Orders actions wrapper -->
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn-custom btn-custom-primary" style="width: auto; padding: 0.75rem 1.5rem;" onclick="resetActiveVerification()">
                                <i class="bi bi-x-circle"></i> Reset
                            </button>
                            <button class="btn-custom btn-custom-success" style="flex-grow: 1;" onclick="completeOrderHandover()">
                                <i class="bi bi-check-all"></i> Confirm Meal Handover & Release Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Column 3: Walk-In / direct cashiers order flow -->
        <section class="pos-col-cart">
            <div class="pane-header">
                <h6 style="font-weight: 700; color: var(--text-dark);">Walk-In & New Sale</h6>
            </div>

            <!-- Scrollable pane containing quick catalog items -->
            <div class="pane-body">
                <h6 style="font-weight: 700; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.75rem;">Quick Catalog Tap</h6>
                <div class="product-grid mb-4" style="margin-bottom: 1.5rem;">
                    <div class="product-card" onclick="addLocalCartItem('Classic Cheeseburger Deluxe', 12.50)">
                        <div class="product-icon"><i class="bi bi-basket3"></i></div>
                        <p style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Cheeseburger</p>
                        <span style="color: var(--theme-primary); font-size: 0.85rem; font-weight: 600;">$12.50</span>
                    </div>
                    <div class="product-card" onclick="addLocalCartItem('Crispy Cajun Fries (Large)', 4.50)">
                        <div class="product-icon"><i class="bi bi-fire"></i></div>
                        <p style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Cajun Fries</p>
                        <span style="color: var(--theme-primary); font-size: 0.85rem; font-weight: 600;">$4.50</span>
                    </div>
                    <div class="product-card" onclick="addLocalCartItem('House Brewed Iced Tea', 3.00)">
                        <div class="product-icon"><i class="bi bi-cup-straw"></i></div>
                        <p style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Brewed Iced Tea</p>
                        <span style="color: var(--theme-primary); font-size: 0.85rem; font-weight: 600;">$3.00</span>
                    </div>
                    <div class="product-card" onclick="addLocalCartItem('Premium Vanilla Shake', 5.00)">
                        <div class="product-icon"><i class="bi bi-droplet"></i></div>
                        <p style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">Vanilla Shake</p>
                        <span style="color: var(--theme-primary); font-size: 0.85rem; font-weight: 600;">$5.00</span>
                    </div>
                </div>

                <!-- Live Walk-In Cart Container Panel -->
                <div style="border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 1rem; background-color: #f8fafc;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                        <h6 style="font-weight: 700; color: var(--text-dark); font-size: 0.85rem;">Direct Register Cart</h6>
                        <button class="btn-custom-link-danger" onclick="clearLocalCart()">Clear</button>
                    </div>

                    <!-- Cart Item container -->
                    <div id="local-cart-items" style="max-height: 120px; overflow-y: auto; margin-bottom: 1rem;">
                        <p style="color: var(--text-muted); font-size: 0.85rem; text-align: center; padding: 0.5rem 0;" id="empty-cart-msg">No items tapped yet.</p>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; font-weight: 700; color: var(--text-dark); font-size: 0.9rem; padding-top: 0.5rem; border-top: 1px solid var(--border-color); margin-bottom: 1rem;">
                        <span>Grand Total</span>
                        <span style="color: var(--theme-primary);" id="local-cart-total">$0.00</span>
                    </div>

                    <button class="btn-custom btn-custom-primary" onclick="checkoutLocalCart()">
                        <i class="bi bi-credit-card-2-back"></i> Pay & Checkout Walk-In
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Custom Floating Alert Modal Banner -->
    <div class="custom-banner shadow" id="success-banner">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="bi bi-check-circle-fill" style="color: var(--theme-success); font-size: 1.25rem;"></i>
            <div>
                <strong style="display: block; font-weight: 700; color: var(--text-dark); font-size: 0.9rem;">Notification</strong>
                <span style="font-size: 0.8rem; color: var(--text-muted);" id="success-banner-msg">Action processed.</span>
            </div>
        </div>
    </div>

    <!-- POS Runtime Script logic -->
    <script>
        // Preset mock order data registry mapped to dynamic systems
        const loadedOrders = {
            "TG-94820": {
                id: "TG-94820",
                code: "837-D0C",
                items: [
                    {name: "Classic Cheeseburger Deluxe", qty: 1, price: 12.50},
                    {name: "Crispy Cajun Fries (Large)", qty: 1, price: 4.50},
                    {name: "House Brewed Iced Tea", qty: 1, price: 3.00}
                ],
                total: 20.00,
                status: "Ready to Scan"
            }
        };

        // Current active validator storage
        let activeVerificationOrder = null;

        // Direct walk-in shopping basket storage
        let localCart = [];

        // Manual search query for Queue filtering
        document.getElementById('queue-search').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.order-ticket-card');
            cards.forEach(card => {
                const id = card.id.replace('card-', '').toLowerCase();
                if (id.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Load targeted ticket data into the active verification window
        function selectOrder(orderId) {
            // Remove active classes
            document.querySelectorAll('.order-ticket-card').forEach(c => c.classList.remove('active'));
            const card = document.getElementById(`card-${orderId}`);
            if (card) {
                card.classList.add('active');
            }

            const data = loadedOrders[orderId];
            if (!data) return;

            activeVerificationOrder = data;

            // Update UI components
            document.getElementById('empty-state-loader').classList.add('d-none');
            document.getElementById('loaded-state-details').classList.remove('d-none');

            document.getElementById('v-order-id').innerText = `#${data.id}`;
            document.getElementById('v-pass-code').innerText = data.code;
            
            const badge = document.getElementById('v-status-badge');
            badge.innerText = data.status.toUpperCase();
            
            if (data.status === "Delivered") {
                badge.style.backgroundColor = "#64748b";
                badge.style.color = "white";
            } else {
                badge.style.backgroundColor = "var(--theme-accent)";
                badge.style.color = "white";
            }

            // Build item verification check rows with explicit styling fallback
            const checkList = document.getElementById('v-items-checklist');
            checkList.innerHTML = '';
            
            data.items.forEach((item, index) => {
                const itemRow = document.createElement('div');
                itemRow.style.display = 'flex';
                itemRow.style.justifyContent = 'space-between';
                itemRow.style.alignItems = 'center';
                itemRow.style.padding = '0.75rem 1rem';
                itemRow.style.backgroundColor = '#f8fafc';
                itemRow.style.border = '1px solid var(--border-color)';
                itemRow.style.borderRadius = '0.5rem';
                itemRow.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <input class="form-check-input" type="checkbox" id="itemCheck-${index}" ${data.status === "Delivered" ? 'checked disabled' : ''} style="width: 18px; height: 18px; cursor: pointer;">
                        <label class="form-check-label" style="font-weight: 600; color: var(--text-dark); cursor: pointer;" for="itemCheck-${index}">
                            ${item.qty}x ${item.name}
                        </label>
                    </div>
                    <span style="color: var(--text-muted); font-weight: 700;">$${(item.price * item.qty).toFixed(2)}</span>
                `;
                checkList.appendChild(itemRow);
            });
        }

        // Simulates scanning event when enter or scan trigger is pressed
        function validateManualCode() {
            const inputField = document.getElementById('manual-code-input');
            const code = inputField.value.trim().toUpperCase();

            if (!code) {
                showToastNotification("Please enter a valid pass code first.", "warning");
                return;
            }

            // Find order matching code parameter
            let matchKey = null;
            for (const key in loadedOrders) {
                if (loadedOrders[key].code.toUpperCase() === code) {
                    matchKey = key;
                    break;
                }
            }

            if (matchKey) {
                selectOrder(matchKey);
                showToastNotification(`Pass code ${code} scanned successfully! Order details loaded.`, "success");
                inputField.value = '';
            } else {
                showToastNotification(`Invalid Pass Code: "${code}". No active ticket matched.`, "error");
            }
        }

        // Capture enter keys inside the code verification input
        document.getElementById('manual-code-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                validateManualCode();
            }
        });

        // Cancel and clear current validation active frame
        function resetActiveVerification() {
            activeVerificationOrder = null;
            document.getElementById('empty-state-loader').classList.remove('d-none');
            document.getElementById('loaded-state-details').classList.add('d-none');
        }

        // Releases completed order back to client
        function completeOrderHandover() {
            if (!activeVerificationOrder) return;

            // Verify if all items checked
            const totalChecks = document.querySelectorAll('#v-items-checklist input[type="checkbox"]').length;
            const checkedCount = document.querySelectorAll('#v-items-checklist input[type="checkbox"]:checked').length;

            if (checkedCount < totalChecks) {
                showToastNotification("Ensure all kitchen items are double checked on the checklist prior to releasing.", "warning");
                return;
            }

            const currentId = activeVerificationOrder.id;
            
            // Mark as delivered in local dataset
            loadedOrders[currentId].status = "Delivered";

            // Update status display on Queue Card
            const cardTag = document.getElementById(`status-tag-${currentId}`);
            if (cardTag) {
                cardTag.className = "status-badge status-completed";
                cardTag.innerText = "Completed";
            }

            // Refresh view
            selectOrder(currentId);
            showToastNotification(`Order #${currentId} has been successfully completed and released.`, "success");
            
            // Decrease Queue active counters
            document.getElementById('live-active-tag').innerText = "0 Active";
            document.getElementById('live-queue-counter').innerText = "0";
        }

        // Add local Tap catalog items to direct Walk-In cart drawer
        function addLocalCartItem(name, price) {
            const existing = localCart.find(item => item.name === name);
            if (existing) {
                existing.qty++;
            } else {
                localCart.push({ name, price, qty: 1 });
            }
            renderLocalCart();
        }

        // Adjust specific cart quantities up/down
        function updateLocalQty(name, amount) {
            const item = localCart.find(item => item.name === name);
            if (item) {
                item.qty += amount;
                if (item.qty <= 0) {
                    localCart = localCart.filter(i => i.name !== name);
                }
            }
            renderLocalCart();
        }

        // Clean local cart entirely
        function clearLocalCart() {
            localCart = [];
            renderLocalCart();
        }

        // Renders items inside walk-in cart dynamically
        function renderLocalCart() {
            const container = document.getElementById('local-cart-items');
            const totalDisplay = document.getElementById('local-cart-total');

            if (localCart.length === 0) {
                container.innerHTML = `<p style="color: var(--text-muted); font-size: 0.85rem; text-align: center; padding: 0.5rem 0;" id="empty-cart-msg">No items tapped yet.</p>`;
                totalDisplay.innerText = "$0.00";
                return;
            }

            container.innerHTML = '';
            let totalSum = 0;

            localCart.forEach(item => {
                const itemTotal = item.price * item.qty;
                totalSum += itemTotal;

                const row = document.createElement('div');
                row.className = "cart-item-row";
                row.innerHTML = `
                    <div style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <span style="font-weight: 700; color: var(--text-dark);">${item.qty}x</span> ${item.name}
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--theme-primary); font-weight: 700;">$${itemTotal.toFixed(2)}</span>
                        <div style="display: flex; gap: 0.25rem;">
                            <button class="cart-qty-btn" onclick="updateLocalQty('${item.name}', -1)">-</button>
                            <button class="cart-qty-btn" onclick="updateLocalQty('${item.name}', 1)">+</button>
                        </div>
                    </div>
                `;
                container.appendChild(row);
            });

            totalDisplay.innerText = `$${totalSum.toFixed(2)}`;
        }

        // Completes walk-in purchase event
        function checkoutLocalCart() {
            if (localCart.length === 0) {
                showToastNotification("Tapping products first before attempting checkout.", "warning");
                return;
            }

            showToastNotification(`Direct Walk-In order paid. Ticket successfully sent to printer terminal!`, "success");
            clearLocalCart();
        }

        // Shows customized clean alert banners to manager
        function showToastNotification(message, type) {
            const banner = document.getElementById('success-banner');
            const bannerMsg = document.getElementById('success-banner-msg');

            bannerMsg.innerText = message;
            
            if (type === "warning") {
                banner.style.backgroundColor = "#fffbeb";
                banner.style.borderColor = "#fef3c7";
                banner.style.color = "#78350f";
            } else if (type === "error") {
                banner.style.backgroundColor = "#fef2f2";
                banner.style.borderColor = "#fca5a5";
                banner.style.color = "#7f1d1d";
            } else {
                banner.style.backgroundColor = "#dcfce7";
                banner.style.borderColor = "#bbf7d0";
                banner.style.color = "#14532d";
            }

            banner.style.display = 'block';

            setTimeout(() => {
                banner.style.display = 'none';
            }, 3500);
        }

        // Auto select the default preset active pass for display onboarding
        window.onload = function() {
            selectOrder('TG-94820');
        };
    </script>

</body>
</html>