<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TapAndGo - Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --brand-navy: #1a4373;
            --brand-navy-dark: #123055;
            --brand-orange: #ff6b00;
            --brand-orange-hover: #e05e00;
            --brand-bg-light: #f4f6f9;
            --theme-card-radius: 18px;
            --theme-card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --theme-card-shadow-hover: 0 20px 30px -10px rgba(0, 0, 0, 0.2), 0 10px 15px -5px rgba(0, 0, 0, 0.15);
            --card-border: rgba(0, 0, 0, 0.06);
        }

        body {
            background-color: var(--brand-bg-light);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: #334155;
        }

        .navbar-brand-bg {
            background-color: var(--brand-navy);
        }

        .btn-brand-orange {
            background-color: var(--brand-orange);
            color: #ffffff;
            border: none;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.25 ease;
        }

        .btn-brand-orange:hover {
            background-color: var(--brand-orange-hover);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(255, 107, 0, 0.35);
        }

        .text-brand-orange {
            color: var(--brand-orange) !important;
        }

        .text-brand-navy {
            color: var(--brand-navy) !important;
        }

        .bg-brand-navy {
            background-color: var(--brand-navy) !important;
        }

        /* Custom Scrollbars */
        .custom-scroll::-webkit-scrollbar,
        .modal-body::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track,
        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scroll::-webkit-scrollbar-thumb,
        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        /* UNIFIED KPI STAT CARDS */
        .kpi-card {
            border: 1px solid var(--card-border);
            border-radius: var(--theme-card-radius);
            box-shadow: var(--theme-card-shadow);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            background: #ffffff;
        }

        .kpi-card-clickable {
            cursor: pointer;
        }

        .kpi-card-clickable:hover {
            transform: translateY(-4px);
            box-shadow: var(--theme-card-shadow-hover);
        }

        .kpi-icon-box {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 1.35rem;
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                opacity: 0.9;
            }

            50% {
                transform: scale(1.04);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0.9;
            }
        }

        .pulse-hook {
            animation: pulse-glow 2s infinite ease-in-out;
        }

        .category-container-scroll {
            flex-grow: 1;
            overflow-y: auto;
        }

        /* MAIN GLASS/SURFACE CONTAINER */
        .surface-card {
            background: #ffffff;
            border-radius: var(--theme-card-radius);
            border: 1px solid var(--card-border);
            box-shadow: var(--theme-card-shadow);
        }

        /* FULL-IMAGE OVERLAY CARDS (UNIFIED CATEGORY & PRODUCT CARD LOOK) */
        .overlay-card {
            position: relative;
            width: 100%;
            border-radius: var(--theme-card-radius);
            overflow: hidden;
            background-color: #0f172a;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.25rem;
            box-shadow: var(--theme-card-shadow);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .overlay-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: var(--theme-card-shadow-hover);
        }

        /* Gradient Mask for Readability */
        .overlay-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.25) 10%, rgba(0, 0, 0, 0.88) 85%);
            z-index: 1;
            transition: opacity 0.25s ease;
        }

        .overlay-card-top {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .overlay-card-bottom {
            position: relative;
            z-index: 2;
            color: #ffffff;
        }

        .category-overlay-card {
            height: 230px;
            cursor: pointer;
        }

        .product-overlay-card {
            height: 290px;
        }

        .card-title-text {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
            margin-bottom: 0.2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .card-subtitle-text {
            font-size: 1.15rem;
            font-weight: 800;
            color: #fbbf24;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .btn-card-action {
            border-radius: 50px;
            padding: 0.45rem 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }

        .btn-card-action:hover {
            transform: translateY(-1px);
        }

        .img-preview-box {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        /* MODALS & OVERLAYS */
        .modal-content {
            border-radius: var(--theme-card-radius) !important;
            overflow: hidden;
        }

        .modal-fixed-height .modal-dialog {
            height: calc(100% - 3.5rem);
            margin-top: 1.75rem;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
        }

        .modal-fixed-height .modal-content {
            height: 82vh !important;
            max-height: 82vh !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .modal-fixed-height .modal-header {
            flex-shrink: 0;
        }

        .modal-fixed-height .modal-body {
            flex: 1 1 auto !important;
            overflow-y: auto !important;
        }
    </style>
</head>

<body class="vh-100 overflow-hidden d-flex flex-column">
    @include('partials.notifications')

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-brand-bg px-3 py-2 flex-shrink-0 shadow-sm">
        <div class="container-fluid p-0">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <img src="{{ asset('Logo.png') }}" alt="TapAndGo Logo" height="38"
                    class="d-inline-block align-text-top">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="nav nav-pills me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
                    <li class="nav-item">
                        <span class="nav-link active px-3 py-1-5 rounded-pill fw-semibold text-white bg-brand-orange">
                            <i class="bi bi-grid-1x2-fill me-1"></i> Menu Management
                        </span>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <div class="text-end text-white d-none d-md-block">
                        <div class="fw-bold lh-1">{{ Auth::user()->name ?? 'Administrator' }}</div>
                        <small class="text-white-50 fs-8">Role: System Admin</small>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Workspace -->
    <div class="container-fluid flex-grow-1 overflow-hidden p-3 p-md-4 d-flex flex-column">
        <div class="d-flex flex-column h-100 gap-3">
            <!-- UNIFIED KPI STATS CARDS -->
            <div class="row g-3 flex-shrink-0">
                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card h-100">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase">Categories</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ count($categories) }}</h2>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">
                                    <i class="bi bi-layers-fill me-1"></i> Active Sections
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-tags-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card h-100">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase">Total Products</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ count($products) }}</h2>
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill small">
                                    <i class="bi bi-box-seam me-1"></i> Items in Inventory
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-box-seam-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $lowStockProducts = $products->filter(fn($p) => $p->stock > 0 && $p->stock < 20);
                    $lowStockCount = $lowStockProducts->count();
                @endphp
                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card kpi-card-clickable border-warning-subtle h-100" data-bs-toggle="modal"
                        data-bs-target="#lowStockModal">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase">Low Stock Alert</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ $lowStockCount }}</h2>
                                <span class="badge bg-warning text-dark rounded-pill small pulse-hook">
                                    <i class="bi bi-eye-fill me-1"></i> View Low Stock
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-exclamation-square-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $outOfStockProducts = $products->filter(fn($p) => $p->stock <= 0);
                    $outOfStockCount = $outOfStockProducts->count();
                @endphp
                <div class="col-sm-6 col-xl-3">
                    <div class="card kpi-card kpi-card-clickable border-danger-subtle h-100" data-bs-toggle="modal"
                        data-bs-target="#outOfStockModal">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase">Out of Stock</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ $outOfStockCount }}</h2>
                                <span class="badge bg-danger text-white rounded-pill small pulse-hook">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> View Out of Stock
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-dash-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- UNIFIED CATEGORY CONTAINER GRID -->
            <div class="surface-card flex-grow-1 d-flex flex-column overflow-hidden mb-2">
                <div
                    class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center flex-shrink-0 flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold text-brand-navy mb-0">
                            <i class="bi bi-grid-fill me-2 text-brand-orange"></i>Menu Categories
                        </h6>
                        <small class="text-muted">Click any category card to view and manage its products</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <span class="input-group-text bg-light border-end-0 rounded-start-pill"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" id="categorySearchInput"
                                class="form-control bg-light border-start-0 rounded-end-pill ps-0"
                                placeholder="Filter categories...">
                        </div>
                        <button class="btn btn-sm btn-brand-orange px-3" data-bs-toggle="modal"
                            data-bs-target="#addCategoryModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Category
                        </button>
                    </div>
                </div>

                <div class="card-body p-3 category-container-scroll custom-scroll">
                    <div class="row g-3" id="categoryGrid">
                        @foreach ($categories as $category)
                            @php
                                $catProducts = $products->where('category_id', $category->id);
                                $prodCount = $catProducts->count();
                                $hasLowStock = $catProducts->contains(fn($p) => $p->stock < 20);
                                $catImgUrl = $category->image_path
                                    ? Storage::url($category->image_path)
                                    : 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=600&auto=format&fit=crop';
                            @endphp
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 category-item-col"
                                data-category-name="{{ strtolower($category->name) }}">

                                <div class="overlay-card category-overlay-card btn-view-category-products"
                                    style="background-image: url('{{ $catImgUrl }}');"
                                    data-category-id="{{ $category->id }}"
                                    data-category-name="{{ $category->name }}">

                                    <!-- TOP BADGES AND ACTION MENU -->
                                    <div class="overlay-card-top">
                                        <span
                                            class="badge bg-white bg-opacity-90 text-dark backdrop-blur rounded-pill px-2.5 py-1.5 shadow-sm">
                                            {{ $prodCount }} {{ Str::plural('Item', $prodCount) }}
                                        </span>

                                        <div class="dropdown" onclick="event.stopPropagation();">
                                            <button
                                                class="btn btn-sm btn-light bg-white bg-opacity-75 rounded-circle shadow-sm border-0"
                                                type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical text-dark"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                                <li>
                                                    <a class="dropdown-item small btn-edit-category" href="#"
                                                        data-id="{{ $category->id }}"
                                                        data-name="{{ $category->name }}"
                                                        data-img="{{ $category->image_path ? Storage::url($category->image_path) : '' }}">
                                                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit
                                                        Category
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small text-danger btn-delete-category"
                                                        href="#" data-id="{{ $category->id }}"
                                                        data-name="{{ $category->name }}">
                                                        <i class="bi bi-eye-slash me-2"></i>Hide Category
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- BOTTOM DETAILS -->
                                    <div class="overlay-card-bottom">
                                        <div class="card-title-text">{{ $category->name }}</div>
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            <span
                                                class="btn btn-sm btn-light btn-card-action text-dark fw-bold shadow-sm">
                                                View Items <i class="bi bi-arrow-right ms-1"></i>
                                            </span>
                                            @if ($hasLowStock)
                                                <span class="badge bg-warning text-dark rounded-pill">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Stock Alert
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ==================== SYSTEM MODALS ==================== -->

    <!-- LOW STOCK MODAL -->
    <div class="modal fade modal-fixed-height" id="lowStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark p-3">
                    <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Low Stock
                        Warning (&lt; 20 Remaining)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase sticky-top" style="z-index: 1;">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th class="text-center">Stock</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowStockProducts as $p)
                                <tr>
                                    <td class="ps-3 fw-bold text-brand-navy">{{ $p->name }}</td>
                                    <td><span
                                            class="badge bg-light text-dark border rounded-pill">{{ $p->category->name ?? 'Unassigned' }}</span>
                                    </td>
                                    <td>₱{{ number_format($p->price, 2) }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-warning text-dark fw-bold rounded-pill">{{ $p->stock }}
                                            pcs</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-brand-orange btn-trigger-restock"
                                            data-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                            data-qty="{{ $p->stock }}">
                                            <i class="bi bi-plus-lg me-1"></i> Restock
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No low stock items
                                        detected.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- OUT OF STOCK MODAL -->
    <div class="modal fade modal-fixed-height" id="outOfStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white p-3">
                    <h5 class="modal-title fw-bold"><i class="bi bi-x-circle-fill me-2"></i>Out of Stock Items</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase sticky-top" style="z-index: 1;">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th class="text-center">Stock</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($outOfStockProducts as $p)
                                <tr>
                                    <td class="ps-3 fw-bold text-brand-navy">{{ $p->name }}</td>
                                    <td><span
                                            class="badge bg-light text-dark border rounded-pill">{{ $p->category->name ?? 'Unassigned' }}</span>
                                    </td>
                                    <td>₱{{ number_format($p->price, 2) }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-danger text-white fw-bold rounded-pill">0 pcs</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-danger rounded-pill btn-trigger-restock"
                                            data-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                            data-qty="0">
                                            <i class="bi bi-plus-lg me-1"></i> Restock Now
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No out-of-stock items
                                        detected.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CATEGORY PRODUCTS MODAL (FULL OVERLAY CARDS WITH ACTION BUTTONS) -->
    <div class="modal fade modal-fixed-height" id="categoryProductsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-brand-navy text-white p-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam-fill text-brand-orange fs-4"></i>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalCategoryTitle">Category Products
                            </h5>
                            <small class="text-white-50">Manage inventory items</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-light border-end-0 rounded-start-pill"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" id="productSearchInput"
                                class="form-control bg-light border-start-0 rounded-end-pill ps-0"
                                placeholder="Search product...">
                        </div>
                        <button class="btn btn-brand-orange btn-sm px-3" id="btnAddNewProductModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Product
                        </button>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>

                <div class="modal-body p-4 bg-light custom-scroll">
                    <!-- PRODUCT GRID CONTAINER -->
                    <div class="row g-3" id="categoryProductsGrid">
                        <!-- Dynamic JS Grid Render -->
                    </div>

                    <div id="emptyCategoryState" class="text-center py-5 d-none">
                        <i class="bi bi-box-seam display-4 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold text-secondary">No active products found</h6>
                        <p class="small text-muted mb-3">Start by adding your first product to this category.</p>
                        <button class="btn btn-brand-orange btn-sm px-3" id="btnEmptyStateAddProd">
                            <i class="bi bi-plus-circle me-1"></i> Add Product Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RESTOCK MODAL -->
    <div class="modal fade" id="restockItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-brand-orange"></i>Restock
                        Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="restockItemForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="restockItemId" name="id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" class="form-control bg-light" id="restockItemName" readonly>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Current Stock</label>
                                <input type="text" class="form-control bg-light" id="restockCurrentQty" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Quantity to Add</label>
                                <input type="number" name="quantity" class="form-control" min="1"
                                    value="50" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange px-4"><i class="bi bi-check-lg me-1"></i>
                            Add Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ADD CATEGORY MODAL -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-folder-plus me-2 text-brand-orange"></i>Add New
                        Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="e.g. Espresso Drinks" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Image</label>
                            <input type="file" name="image" class="form-control image-file-input"
                                accept="image/*" data-preview="#addCategoryPreview">
                            <div class="mt-2 text-center d-none">
                                <img id="addCategoryPreview" src="#" class="img-preview-box">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange px-4">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT CATEGORY MODAL -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-brand-orange"></i>Edit
                        Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" id="editCategoryName" name="name" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Image</label>
                            <div class="mb-2 text-center" id="editCategoryImgWrapper">
                                <img id="editCategoryImgPreview" src="" class="img-preview-box">
                            </div>
                            <label class="form-label fw-semibold">Update Image (Optional)</label>
                            <input type="file" name="image" class="form-control image-file-input"
                                accept="image/*" data-preview="#editCategoryImgPreview">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange px-4">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CATEGORY MODAL -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="bi bi-eye-slash me-2"></i>Hide Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="deleteCategoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4">
                        <p class="mb-0">Are you sure you want to hide <strong id="deleteCategoryName"
                                class="text-brand-navy"></strong>? This will set its status to invisible on the menu.
                        </p>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 font-weight-bold"><i
                                class="bi bi-eye-slash me-1"></i> Confirm & Hide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ADD PRODUCT MODAL -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2 text-brand-orange"></i>Add New
                        Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id" id="addProductCategoryId">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Target Category</label>
                            <select id="addProductCategoryDropdown" name="category_id_display"
                                class="form-select bg-light" disabled>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="e.g. Salmon and Avocado Burger" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Price (₱)</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    placeholder="120.00" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Initial Stock</label>
                                <input type="number" name="stock" class="form-control" value="50" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control image-file-input"
                                accept="image/*" data-preview="#addProductPreview">
                            <div class="mt-2 text-center d-none">
                                <img id="addProductPreview" src="#" class="img-preview-box">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange px-4">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT PRODUCT MODAL -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-brand-orange"></i>Edit
                        Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category / Section</label>
                            <select name="category_id" id="editProductCategoryId" class="form-select" required>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" id="editProductName" name="name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Price (₱)</label>
                                <input type="number" step="0.01" id="editProductPrice" name="price"
                                    class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Stock Quantity</label>
                                <input type="number" id="editProductStock" name="stock" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Image</label>
                            <div class="mb-2 text-center" id="editProductImgWrapper">
                                <img id="editProductImgPreview" src="" class="img-preview-box">
                            </div>
                            <label class="form-label fw-semibold">Update Image (Optional)</label>
                            <input type="file" name="image" class="form-control image-file-input"
                                accept="image/*" data-preview="#editProductImgPreview">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange px-4">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE PRODUCT MODAL -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="bi bi-eye-slash me-2"></i>Hide Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4">
                        <p class="mb-0">Are you sure you want to hide <strong id="deleteProductName"
                                class="text-brand-navy"></strong>? This will set its visibility to hidden on the
                            Ordering Screen.</p>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 font-weight-bold"><i
                                class="bi bi-eye-slash me-1"></i> Confirm & Hide</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    const categoriesData = @json($categories);
    const productsData = @json($products);

    let activeCategoryId = null;

    document.addEventListener('DOMContentLoaded', function() {

        // 1. Live Category Search Filter
        const searchInput = document.getElementById('categorySearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                document.querySelectorAll('.category-item-col').forEach(col => {
                    const name = col.getAttribute('data-category-name');
                    col.classList.toggle('d-none', !name.includes(query));
                });
            });
        }

        // 2. Live Product Search Filter
        const prodSearchInput = document.getElementById('productSearchInput');
        if (prodSearchInput) {
            prodSearchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                document.querySelectorAll('#categoryProductsGrid .product-col').forEach(col => {
                    const prodName = col.getAttribute('data-product-name') || '';
                    col.classList.toggle('d-none', !prodName.includes(query));
                });
            });
        }

        // 3. Open Category Products Modal
        document.querySelectorAll('.btn-view-category-products').forEach(card => {
            card.addEventListener('click', function() {
                activeCategoryId = this.getAttribute('data-category-id');
                const categoryName = this.getAttribute('data-category-name');

                document.getElementById('modalCategoryTitle').innerText = categoryName +
                    ' Products';

                if (prodSearchInput) prodSearchInput.value = '';

                renderCategoryProducts(activeCategoryId);

                const catModal = new bootstrap.Modal(document.getElementById(
                    'categoryProductsModal'));
                catModal.show();
            });
        });

        // 4. Render Category Products Grid (Fully Unified Overlay Style)
        function renderCategoryProducts(catId) {
            const gridContainer = document.getElementById('categoryProductsGrid');
            const emptyState = document.getElementById('emptyCategoryState');

            gridContainer.innerHTML = '';
            const filteredProducts = productsData.filter(p => p.category_id == catId);

            if (filteredProducts.length === 0) {
                gridContainer.classList.add('d-none');
                emptyState.classList.remove('d-none');
            } else {
                gridContainer.classList.remove('d-none');
                emptyState.classList.add('d-none');

                filteredProducts.forEach(product => {
                    const imgUrl = product.image_path ? `/storage/${product.image_path}` :
                        'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=600&auto=format&fit=crop';

                    const col = document.createElement('div');
                    col.className = 'col-12 col-sm-6 col-md-4 col-xl-3 product-col';
                    col.setAttribute('data-product-name', product.name.toLowerCase());

                    col.innerHTML = `
                            <div class="overlay-card product-overlay-card" style="background-image: url('${imgUrl}');">
                                <!-- TOP BADGE AND DROPDOWN MENU -->
                                <div class="overlay-card-top">
                                    <span class="badge ${product.stock <= 0 ? 'bg-danger' : (product.stock < 20 ? 'bg-warning text-dark' : 'bg-success')} rounded-pill px-2.5 py-1.5">
                                        ${product.stock <= 0 ? 'Out of Stock' : product.stock + ' left'}
                                    </span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light bg-white bg-opacity-75 rounded-circle shadow-sm border-0" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical text-dark"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                            <li>
                                                <a class="dropdown-item small btn-edit-product-action" href="#" data-id="${product.id}">
                                                    <i class="bi bi-pencil text-primary me-2"></i>Edit Product
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item small text-danger btn-delete-product-action" href="#" data-id="${product.id}" data-name="${product.name}">
                                                    <i class="bi bi-eye-slash me-2"></i>Hide Product
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- BOTTOM DETAILS & MANAGEMENT ACTIONS -->
                                <div class="overlay-card-bottom">
                                    <div class="card-title-text">${product.name}</div>
                                    <div class="card-subtitle-text">₱${parseFloat(product.price).toLocaleString('en-US', {minimumFractionDigits: 2})}</div>
                                    
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-brand-orange btn-card-action flex-grow-1 btn-trigger-restock" data-id="${product.id}" data-name="${product.name}" data-qty="${product.stock}">
                                            <i class="bi bi-plus-circle me-1"></i> Restock
                                        </button>
                                        <button class="btn btn-light bg-white bg-opacity-80 text-dark border-0 btn-card-action btn-edit-product-action" data-id="${product.id}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    gridContainer.appendChild(col);
                });
            }
        }

        // 5. Trigger Add Product Modal
        const triggerAddProduct = () => {
            if (!activeCategoryId) return;
            document.getElementById('addProductCategoryId').value = activeCategoryId;
            document.getElementById('addProductCategoryDropdown').value = activeCategoryId;

            const addModal = new bootstrap.Modal(document.getElementById('addProductModal'));
            addModal.show();
        };

        document.getElementById('btnAddNewProductModal').addEventListener('click', triggerAddProduct);
        document.getElementById('btnEmptyStateAddProd').addEventListener('click', triggerAddProduct);

        // 6. Restock Bridge
        document.addEventListener('click', function(e) {
            const restockBtn = e.target.closest('.btn-trigger-restock');
            if (restockBtn) {
                e.preventDefault();
                const id = restockBtn.getAttribute('data-id');
                const name = restockBtn.getAttribute('data-name');
                const qty = restockBtn.getAttribute('data-qty');

                document.getElementById('restockItemId').value = id;
                document.getElementById('restockItemName').value = name;
                document.getElementById('restockCurrentQty').value = qty + ' pcs';
                document.getElementById('restockItemForm').action = `/admin/products/${id}/restock`;

                ['lowStockModal', 'outOfStockModal', 'categoryProductsModal'].forEach(mId => {
                    const instance = bootstrap.Modal.getInstance(document.getElementById(mId));
                    if (instance) instance.hide();
                });

                new bootstrap.Modal(document.getElementById('restockItemModal')).show();
            }
        });

        // 7. Image Previews
        document.querySelectorAll('.image-file-input').forEach(input => {
            input.addEventListener('change', function() {
                const previewImg = document.querySelector(this.getAttribute('data-preview'));
                const file = this.files[0];

                if (file && previewImg) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewImg.src = e.target.result;
                        const container = previewImg.closest('div');
                        if (container) container.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // 8. Edit Category Setup
        document.querySelectorAll('.btn-edit-category').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const img = this.getAttribute('data-img');

                document.getElementById('editCategoryName').value = name;
                document.getElementById('editCategoryForm').action =
                    `/admin/categories/${id}/update`;

                const imgPreview = document.getElementById('editCategoryImgPreview');
                if (img) {
                    imgPreview.src = img;
                    document.getElementById('editCategoryImgWrapper').classList.remove(
                        'd-none');
                } else {
                    document.getElementById('editCategoryImgWrapper').classList.add('d-none');
                }

                new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
            });
        });

        // 9. Delete Category Setup
        document.querySelectorAll('.btn-delete-category').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                document.getElementById('deleteCategoryName').innerText = this.getAttribute(
                    'data-name');
                document.getElementById('deleteCategoryForm').action =
                    `/admin/categories/${id}/delete`;

                new bootstrap.Modal(document.getElementById('deleteCategoryModal')).show();
            });
        });

        // 10. Product Actions Delegation
        document.getElementById('categoryProductsGrid').addEventListener('click', function(e) {
            const editBtn = e.target.closest('.btn-edit-product-action');
            const deleteBtn = e.target.closest('.btn-delete-product-action');

            if (editBtn) {
                e.preventDefault();
                const id = editBtn.getAttribute('data-id');
                const product = productsData.find(p => p.id == id);
                if (product) {
                    document.getElementById('editProductCategoryId').value = product.category_id;
                    document.getElementById('editProductName').value = product.name;
                    document.getElementById('editProductPrice').value = product.price;
                    document.getElementById('editProductStock').value = product.stock;
                    document.getElementById('editProductForm').action = `/admin/products/${id}/update`;

                    const imgPreview = document.getElementById('editProductImgPreview');
                    if (product.image_path) {
                        imgPreview.src = `/storage/${product.image_path}`;
                        document.getElementById('editProductImgWrapper').classList.remove('d-none');
                    } else {
                        document.getElementById('editProductImgWrapper').classList.add('d-none');
                    }

                    new bootstrap.Modal(document.getElementById('editProductModal')).show();
                }
            }

            if (deleteBtn) {
                e.preventDefault();
                const id = deleteBtn.getAttribute('data-id');
                document.getElementById('deleteProductName').innerText = deleteBtn.getAttribute(
                    'data-name');
                document.getElementById('deleteProductForm').action = `/admin/products/${id}/delete`;

                new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
            }
        });

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toastElements = document.querySelectorAll('.toast-container .toast');
        toastElements.forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    });
</script>
</body>

</html>
