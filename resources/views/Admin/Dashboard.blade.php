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
            --brand-navy-light: #225188;
            --brand-orange: #ff6b00;
            --brand-orange-hover: #e05e00;
            --brand-bg-light: #f4f6f9;
            --card-border: rgba(0, 0, 0, 0.08);
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
            transition: all 0.2s ease;
        }

        .btn-brand-orange:hover {
            background-color: var(--brand-orange-hover);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(255, 107, 0, 0.25);
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
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* KPI Cards & Click Hooks */
        .kpi-card {
            border: 1px solid var(--card-border);
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kpi-card-clickable {
            cursor: pointer;
            position: relative;
        }

        .kpi-card-clickable:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(26, 67, 115, 0.12) !important;
        }

        .kpi-card-clickable.border-warning-subtle:hover {
            border-color: #ffc107 !important;
        }

        .kpi-card-clickable.border-danger-subtle:hover {
            border-color: #dc3545 !important;
        }

        .kpi-icon-box {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.25rem;
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                opacity: 0.9;
            }

            50% {
                transform: scale(1.05);
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

        .category-grid-card {
            border: 1px solid var(--card-border);
            border-radius: 14px;
            background: #ffffff;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .category-grid-card:hover {
            border-color: var(--brand-orange);
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(255, 107, 0, 0.12) !important;
        }

        .category-card-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 12px;
        }

        .status-badge {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.35em 0.75em;
            border-radius: 20px;
        }

        .modal-subheader-text {
            color: #cbd5e1 !important;
        }

        .img-preview-box {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body class="vh-100 overflow-hidden d-flex flex-column">

    <!-- Top Admin Navigation Bar -->
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
                        <span class="nav-link active px-3 py-1-5 rounded-2 fw-semibold text-white bg-brand-orange">
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
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-2 px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Viewport Workspace -->
    <div class="container-fluid flex-grow-1 overflow-hidden p-3 p-md-4 d-flex flex-column">
        <div class="d-flex flex-column h-100 gap-3">

            <!-- Alert Flash Feedback Message Banner -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-0 py-2 px-3 shadow-sm flex-shrink-0"
                    role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- SECTION 1: KPI STATS CARDS -->
            <div class="row g-3 flex-shrink-0">
                <!-- Total Categories -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-white shadow-sm kpi-card h-100">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span
                                    class="text-muted small fw-semibold text-uppercase tracking-wide">Categories</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ count($categories) }}</h2>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">
                                    <i class="bi bi-layers-fill me-1"></i> Active Menu Sections
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-tags-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-white shadow-sm kpi-card h-100">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase tracking-wide">Total
                                    Products</span>
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

                <!-- Low Stock Warning -->
                @php
                    $lowStockProducts = $products->filter(fn($p) => $p->stock > 0 && $p->stock < 20);
                    $lowStockCount = $lowStockProducts->count();
                @endphp
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-white shadow-sm kpi-card kpi-card-clickable border-warning-subtle h-100"
                        data-bs-toggle="modal" data-bs-target="#lowStockModal">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase tracking-wide">Low Stock
                                    Alert</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ $lowStockCount }}</h2>
                                <span class="badge bg-warning text-dark rounded-pill small pulse-hook">
                                    <i class="bi bi-eye-fill me-1"></i> View Low Stock Items
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-exclamation-square-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock Alert -->
                @php
                    $outOfStockProducts = $products->filter(fn($p) => $p->stock <= 0);
                    $outOfStockCount = $outOfStockProducts->count();
                @endphp
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-white shadow-sm kpi-card kpi-card-clickable border-danger-subtle h-100"
                        data-bs-toggle="modal" data-bs-target="#outOfStockModal">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-semibold text-uppercase tracking-wide">Out of
                                    Stock</span>
                                <h2 class="fw-bold text-brand-navy my-1">{{ $outOfStockCount }}</h2>
                                <span class="badge bg-danger text-white rounded-pill small pulse-hook">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> View Out of Stock Items
                                </span>
                            </div>
                            <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-dash-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: CATEGORY GRID CONTAINER -->
            <div class="card border-0 shadow-sm rounded-3 flex-grow-1 d-flex flex-column overflow-hidden mb-2">
                <div
                    class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center flex-shrink-0 flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold text-brand-navy mb-0">
                            <i class="bi bi-grid-fill me-2 text-brand-orange"></i>Menu Categories
                        </h6>
                        <small class="text-muted">Click any category card to view, add, or manage its products</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Dynamic Live Category Filter -->
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" id="categorySearchInput"
                                class="form-control bg-light border-start-0 ps-0" placeholder="Filter categories...">
                        </div>
                        <button class="btn btn-sm btn-brand-orange rounded-2 px-3" data-bs-toggle="modal"
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
                            @endphp
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 category-item-col"
                                data-category-name="{{ strtolower($category->name) }}">
                                <div class="category-grid-card shadow-sm p-3 btn-view-category-products"
                                    data-category-id="{{ $category->id }}"
                                    data-category-name="{{ $category->name }}">

                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($category->image_path)
                                                <img src="{{ Storage::url($category->image_path) }}"
                                                    alt="{{ $category->name }}" class="category-card-img border">
                                            @else
                                                <div
                                                    class="category-card-img bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center border border-warning border-opacity-25">
                                                    <i class="bi bi-tags-fill fs-3"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="fw-bold text-brand-navy mb-0 text-truncate"
                                                    style="max-width: 130px;">{{ $category->name }}</h5>
                                                <span class="badge bg-light text-secondary border mt-1">
                                                    {{ $prodCount }} {{ Str::plural('Product', $prodCount) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="dropdown" onclick="event.stopPropagation();">
                                            <button class="btn btn-sm btn-light border py-1 px-2 rounded-2"
                                                type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
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
                                                        <i class="bi bi-trash me-2"></i>Delete Category
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                        <span class="small text-brand-orange fw-bold">
                                            View Items <i class="bi bi-arrow-right ms-1"></i>
                                        </span>
                                        @if ($hasLowStock)
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill small">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i>Stock Alert
                                            </span>
                                        @endif
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
    <div class="modal fade" id="lowStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark p-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                        <h5 class="modal-title fw-bold">Low Stock Warning (< 20 Remaining)</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
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
                                            class="badge bg-light text-dark border">{{ $p->category->name ?? 'Unassigned' }}</span>
                                    </td>
                                    <td>₱{{ number_format($p->price, 2) }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-warning text-dark fw-bold">{{ $p->stock }} pcs</span>
                                    </td>
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
    <div class="modal fade" id="outOfStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white p-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle-fill fs-4"></i>
                        <h5 class="modal-title fw-bold">Out of Stock Items (Action Required)</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
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
                                            class="badge bg-light text-dark border">{{ $p->category->name ?? 'Unassigned' }}</span>
                                    </td>
                                    <td>₱{{ number_format($p->price, 2) }}</td>
                                    <td class="text-center"><span class="badge bg-danger text-white fw-bold">0
                                            pcs</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-danger btn-trigger-restock"
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

    <!-- CATEGORY PRODUCTS DRILL-DOWN MODAL -->
    <div class="modal fade" id="categoryProductsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-brand-navy text-white p-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam-fill text-brand-orange fs-4"></i>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalCategoryTitle">Category Products
                            </h5>
                            <small class="modal-subheader-text">Manage inventory items for this section</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-brand-orange btn-sm rounded-2" id="btnAddNewProductModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Product
                        </button>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body p-0 custom-scroll" style="max-height: 60vh;">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="categoryProductsTable">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-3" style="width: 70px;">Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="text-center">Stock Quantity</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoryProductsList">
                                <!-- Dynamic JS Render -->
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyCategoryState" class="text-center py-5 d-none">
                        <i class="bi bi-box-seam display-4 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold text-secondary">No products found in this category</h6>
                        <p class="small text-muted mb-3">Start by adding your first menu product to this section.</p>
                        <button class="btn btn-brand-orange btn-sm" id="btnEmptyStateAddProd">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Add
                            Stock</button>
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
                            <div class="mt-2 text-center d-none" id="addCategoryPreviewContainer">
                                <img id="addCategoryPreview" src="#" class="img-preview-box">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange">Save Category</button>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CATEGORY CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-trash me-2"></i>Delete Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="deleteCategoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4">
                        <p class="mb-0">Are you sure you want to delete <strong id="deleteCategoryName"
                                class="text-danger"></strong>? This will also remove all assigned products.</p>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Permanently</button>
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
                                placeholder="e.g. Iced Caramel Latte" required>
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
                            <div class="mt-2 text-center d-none" id="addProductPreviewContainer">
                                <img id="addProductPreview" src="#" class="img-preview-box">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange">Save Product</button>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE PRODUCT MODAL -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-trash me-2"></i>Delete Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4">
                        <p class="mb-0">Are you sure you want to delete <strong id="deleteProductName"
                                class="text-danger"></strong>?</p>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const allProducts = @json($products);
        let currentSelectedCategoryId = null;

        document.addEventListener('DOMContentLoaded', function() {

            // 1. DYNAMIC CATEGORY SEARCH / FILTERING
            const categorySearchInput = document.getElementById('categorySearchInput');
            if (categorySearchInput) {
                categorySearchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    const categoryCols = document.querySelectorAll('.category-item-col');

                    categoryCols.forEach(col => {
                        const name = col.dataset.categoryName;
                        if (name.includes(query)) {
                            col.style.display = '';
                        } else {
                            col.style.display = 'none';
                        }
                    });
                });
            }

            // 2. IMAGE PREVIEW HANDLER
            document.querySelectorAll('.image-file-input').forEach(input => {
                input.addEventListener('change', function() {
                    const targetSelector = this.dataset.preview;
                    const previewImg = document.querySelector(targetSelector);

                    if (this.files && this.files[0] && previewImg) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            const container = previewImg.closest('.d-none');
                            if (container) container.classList.remove('d-none');
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            // 3. OPEN RESTOCK MODAL HANDLER
            document.addEventListener('click', function(e) {
                const restockTrigger = e.target.closest('.btn-trigger-restock, .btn-restock-modal');
                if (restockTrigger) {
                    // Hide parent modal active instances if opened inside another modal
                    ['lowStockModal', 'outOfStockModal', 'categoryProductsModal'].forEach(id => {
                        const modalEl = document.getElementById(id);
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();
                    });

                    const productId = restockTrigger.dataset.id;
                    const name = restockTrigger.dataset.name;
                    const qty = restockTrigger.dataset.qty;

                    document.getElementById('restockItemForm').action =
                        `/admin/product/restock/${productId}`;
                    document.getElementById('restockItemId').value = productId;
                    document.getElementById('restockItemName').value = name;
                    document.getElementById('restockCurrentQty').value = `${qty} pcs`;

                    new bootstrap.Modal(document.getElementById('restockItemModal')).show();
                }
            });

            // 4. VIEW CATEGORY PRODUCTS DRILL-DOWN HANDLER
            document.querySelectorAll('.btn-view-category-products').forEach(card => {
                card.addEventListener('click', function() {
                    const catId = this.dataset.categoryId;
                    const catName = this.dataset.categoryName;
                    currentSelectedCategoryId = catId;

                    document.getElementById('modalCategoryTitle').textContent =
                        `${catName} Products`;
                    document.getElementById('addProductCategoryId').value = catId;

                    const dropdown = document.getElementById('addProductCategoryDropdown');
                    if (dropdown) dropdown.value = catId;

                    const categoryProds = allProducts.filter(p => p.category_id == catId);
                    renderCategoryProductsTable(categoryProds);

                    new bootstrap.Modal(document.getElementById('categoryProductsModal')).show();
                });
            });

            // 5. RENDER DYNAMIC PRODUCTS TABLE INSIDE MODAL
            function renderCategoryProductsTable(productsList) {
                const tbody = document.getElementById('categoryProductsList');
                const emptyState = document.getElementById('emptyCategoryState');
                const table = document.getElementById('categoryProductsTable');

                tbody.innerHTML = '';

                if (productsList.length === 0) {
                    table.classList.add('d-none');
                    emptyState.classList.remove('d-none');
                    return;
                }

                table.classList.remove('d-none');
                emptyState.classList.add('d-none');

                productsList.forEach(product => {
                    let badgeClass, statusIcon, statusText, qtyClass, btnClass;

                    if (product.stock <= 0) {
                        badgeClass =
                            'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25';
                        statusIcon = 'bi-x-circle-fill';
                        statusText = 'Out of Stock';
                        qtyClass = 'text-danger';
                        btnClass = 'btn-danger';
                    } else if (product.stock < 20) {
                        badgeClass =
                            'bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25';
                        statusIcon = 'bi-exclamation-triangle-fill';
                        statusText = 'Low Stock';
                        qtyClass = 'text-warning text-darken-2';
                        btnClass = 'btn-brand-orange';
                    } else {
                        badgeClass =
                            'bg-success bg-opacity-10 text-success border border-success border-opacity-25';
                        statusIcon = 'bi-check-circle-fill';
                        statusText = 'In Stock';
                        qtyClass = 'text-brand-navy';
                        btnClass = 'btn-outline-primary';
                    }

                    const imgTag = product.image_path ?
                        `<img src="/storage/${product.image_path}" class="rounded-2 border" style="width: 44px; height: 44px; object-fit: cover;">` :
                        `<div class="bg-light text-secondary rounded-2 border d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;"><i class="bi bi-box-seam fs-5"></i></div>`;

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="ps-3">${imgTag}</td>
                        <td class="fw-bold text-brand-navy">${product.name}</td>
                        <td class="fw-semibold">₱${parseFloat(product.price).toFixed(2)}</td>
                        <td><span class="status-badge ${badgeClass}"><i class="bi ${statusIcon} me-1"></i>${statusText}</span></td>
                        <td class="text-center"><div class="fw-bold ${qtyClass}">${product.stock} pcs</div></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button class="btn ${btnClass} btn-restock-modal me-1 rounded-1" data-id="${product.id}" data-name="${product.name}" data-qty="${product.stock}">
                                    <i class="bi bi-plus-lg"></i> Restock
                                </button>
                                <button class="btn btn-outline-secondary btn-edit-modal me-1 rounded-1" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}" data-qty="${product.stock}" data-img="${product.image_path ? '/storage/' + product.image_path : ''}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-delete-modal rounded-1" data-id="${product.id}" data-name="${product.name}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            // 6. ADD NEW PRODUCT TRIGGERS
            function openAddProductModal() {
                const catModalEl = document.getElementById('categoryProductsModal');
                const modalInstance = bootstrap.Modal.getInstance(catModalEl);
                if (modalInstance) modalInstance.hide();

                new bootstrap.Modal(document.getElementById('addProductModal')).show();
            }

            document.getElementById('btnAddNewProductModal').addEventListener('click', openAddProductModal);
            document.getElementById('btnEmptyStateAddProd').addEventListener('click', openAddProductModal);

            // 7. EDIT CATEGORY HANDLER
            document.querySelectorAll('.btn-edit-category').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const img = this.dataset.img;

                    document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
                    document.getElementById('editCategoryName').value = name;

                    const imgPreview = document.getElementById('editCategoryImgPreview');
                    const imgWrapper = document.getElementById('editCategoryImgWrapper');

                    if (img) {
                        imgPreview.src = img;
                        imgWrapper.classList.remove('d-none');
                    } else {
                        imgWrapper.classList.add('d-none');
                    }

                    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
                });
            });

            // 8. DELETE CATEGORY HANDLER
            document.querySelectorAll('.btn-delete-category').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    document.getElementById('deleteCategoryForm').action =
                        `/admin/categories/${id}`;
                    document.getElementById('deleteCategoryName').textContent = name;

                    new bootstrap.Modal(document.getElementById('deleteCategoryModal')).show();
                });
            });

            // 9. EDIT / DELETE PRODUCT HANDLERS INSIDE MODAL
            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest('.btn-edit-modal');
                if (editBtn) {
                    const catModalEl = document.getElementById('categoryProductsModal');
                    const catModalInstance = bootstrap.Modal.getInstance(catModalEl);
                    if (catModalInstance) catModalInstance.hide();

                    const id = editBtn.dataset.id;
                    const img = editBtn.dataset.img;

                    document.getElementById('editProductForm').action = `/admin/product/update/${id}`;
                    document.getElementById('editProductName').value = editBtn.dataset.name;
                    document.getElementById('editProductPrice').value = editBtn.dataset.price;
                    document.getElementById('editProductStock').value = editBtn.dataset.qty;

                    const imgPreview = document.getElementById('editProductImgPreview');
                    const imgWrapper = document.getElementById('editProductImgWrapper');

                    if (img) {
                        imgPreview.src = img;
                        imgWrapper.classList.remove('d-none');
                    } else {
                        imgWrapper.classList.add('d-none');
                    }

                    new bootstrap.Modal(document.getElementById('editProductModal')).show();
                }

                const deleteBtn = e.target.closest('.btn-delete-modal');
                if (deleteBtn) {
                    const catModalEl = document.getElementById('categoryProductsModal');
                    const catModalInstance = bootstrap.Modal.getInstance(catModalEl);
                    if (catModalInstance) catModalInstance.hide();

                    const id = deleteBtn.dataset.id;
                    document.getElementById('deleteProductForm').action = `/admin/product/delete/${id}`;
                    document.getElementById('deleteProductName').textContent = deleteBtn.dataset.name;

                    new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
                }
            });

        });
    </script>
</body>

</html>
