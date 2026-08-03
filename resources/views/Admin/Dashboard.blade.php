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
            --brand-navy-light: #182a4a;
            --brand-orange: #ff6b00;
            --brand-orange-hover: #e05e00;
            --brand-bg-light: #f4f6f9;
        }

        body {
            background-color: var(--brand-bg-light);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .navbar-brand-bg {
            background-color: var(--brand-navy);
        }

        .bg-brand-navy {
            background-color: var(--brand-navy) !important;
        }

        .bg-brand-orange {
            background-color: var(--brand-orange) !important;
            color: #ffffff;
        }

        .btn-brand-orange {
            background-color: var(--brand-orange);
            color: #ffffff;
            border: none;
            font-weight: 600;
        }

        .btn-brand-orange:hover {
            background-color: var(--brand-orange-hover);
            color: #ffffff;
        }

        .text-brand-orange {
            color: var(--brand-orange) !important;
        }

        .text-brand-navy {
            color: var(--brand-navy) !important;
        }

        /* Custom Scrollbars */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Nav Pills active state */
        .nav-pills .nav-link {
            cursor: pointer;
            color: #ffffff;
            opacity: 0.8;
        }

        .nav-pills .nav-link.active {
            background-color: var(--brand-orange) !important;
            color: #ffffff !important;
            opacity: 1;
        }

        .nav-pills .nav-link:hover {
            opacity: 1;
            color: #ffffff;
        }

        /* KPI Card Hover Effect */
        .kpi-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(15, 29, 54, 0.08) !important;
        }

        .category-icon-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body class="vh-100 overflow-hidden d-flex flex-column">

    <!-- Top Admin Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-brand-bg px-3 py-2 flex-shrink-0">
        <div class="container-fluid p-0">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <img src="{{ asset('Logo.png') }}" alt="TapAndGo Logo" height="40"
                    class="d-inline-block align-text-top">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Admin Navigation Tab Controllers -->
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="nav nav-pills me-auto mb-2 mb-lg-0 ms-lg-4 gap-1" id="adminTabs">
                    <li class="nav-item">
                        <button class="nav-link active px-3 rounded-2" data-target="view-overview"><i
                                class="bi bi-grid-1x2-fill me-1"></i> Overview</button>
                    </li>
                </ul>

                <!-- Admin Profile Info & Breeze Logout -->
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end text-white d-none d-md-block">
                        <div class="fw-bold lh-1">{{ Auth::user()->name ?? 'Administrator' }}</div>
                        <small class="text-white-50">Role: System Admin</small>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-2">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Viewport Workspace -->
    <div class="container-fluid flex-grow-1 overflow-hidden p-3">
        <div class="row h-100 g-3">

            <!-- MAIN FULL WIDTH CONTENT COLUMN -->
            <div class="col-12 h-100 d-flex flex-column gap-3 overflow-auto custom-scroll pe-2">

                <!-- Section 1: KPI Statistics Summary Cards -->
                <div class="row g-3 flex-shrink-0" id="view-overview">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Total Revenue</span>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-light border py-0 px-2 dropdown-toggle fs-8 text-muted"
                                            type="button" id="kpiRevenueTimeframe" data-bs-toggle="dropdown">
                                            Today
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="revenue" data-range="today">Today</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="revenue" data-range="weekly">Weekly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="revenue" data-range="monthly">Monthly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="revenue" data-range="yearly">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1" id="kpiRevenueVal">$1,482.50</h3>
                                <small class="text-success fw-semibold" id="kpiRevenueTrend"><i
                                        class="bi bi-arrow-up-right me-1"></i>+12.4% vs yesterday</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Orders Processed</span>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-light border py-0 px-2 dropdown-toggle fs-8 text-muted"
                                            type="button" id="kpiOrdersTimeframe" data-bs-toggle="dropdown">
                                            Today
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="orders" data-range="today">Today</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="orders" data-range="weekly">Weekly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="orders" data-range="monthly">Monthly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="orders" data-range="yearly">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1" id="kpiOrdersVal">142</h3>
                                <small class="text-success fw-semibold" id="kpiOrdersTrend"><i
                                        class="bi bi-arrow-up-right me-1"></i>+8.1% vs yesterday</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Tax Accrued</span>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-light border py-0 px-2 dropdown-toggle fs-8 text-muted"
                                            type="button" id="kpiTaxTimeframe" data-bs-toggle="dropdown">
                                            Today
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="tax" data-range="today">Today</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="tax" data-range="weekly">Weekly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="tax" data-range="monthly">Monthly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#"
                                                    data-kpi="tax" data-range="yearly">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1" id="kpiTaxVal">$134.77</h3>
                                <small class="text-success fw-semibold" id="kpiTaxTrend"><i
                                        class="bi bi-arrow-up-right me-1"></i>10% Standard VAT</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Active Kiosks</span>
                                    <span class="bg-info bg-opacity-10 text-info rounded-2 px-2 py-1 fs-6">
                                        <i class="bi bi-display-fill"></i>
                                    </span>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1">4 / 4</h3>
                                <small class="text-success fw-semibold"><i
                                        class="bi bi-check-circle-fill me-1"></i>100% Operational</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Analytics & Sales Performance Breakdown -->
                <div class="row g-3" id="view-analytics">
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div
                                class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-brand-navy mb-0"><i
                                        class="bi bi-clock-history me-2 text-brand-orange"></i>Peak Hours Order Volume
                                </h6>
                                <span class="badge bg-light text-dark border">Today</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>11:00 AM - 1:00 PM (Lunch Rush)</span>
                                        <span class="fw-bold text-brand-navy">58 Orders (41%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-brand-orange" role="progressbar"
                                            style="width: 75%;"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>5:00 PM - 7:00 PM (Dinner Peak)</span>
                                        <span class="fw-bold text-brand-navy">42 Orders (30%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-brand-navy" role="progressbar"
                                            style="width: 55%;"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>2:00 PM - 4:00 PM (Afternoon Snacks)</span>
                                        <span class="fw-bold text-brand-navy">28 Orders (20%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Sales Breakdown -->
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column">
                            <div
                                class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-brand-navy mb-0"><i
                                        class="bi bi-pie-chart-fill me-2 text-brand-orange"></i>Sales by Category</h6>
                                <button class="btn btn-sm btn-brand-orange" data-bs-toggle="modal"
                                    data-bs-target="#addCategoryModal">
                                    <i class="bi bi-plus-circle me-1"></i> Add Category
                                </button>
                            </div>

                            <div class="card-body p-3 overflow-auto custom-scroll" style="max-height: 250px;"
                                id="categoriesContainer">
                                <ul class="list-group list-group-flush" id="categoryList">
                                    @foreach ($categories as $category)
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0 category-item"
                                            data-id="{{ $category->id }}">
                                            <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                                                @if ($category->image_path)
                                                    <img src="{{ Storage::url($category->image_path) }}"
                                                        alt="{{ $category->name }}"
                                                        class="rounded-2 flex-shrink-0 category-img-preview"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-2 d-flex align-items-center justify-content-center flex-shrink-0 category-img-placeholder"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="bi bi-tags-fill fs-5"></i>
                                                    </div>
                                                @endif

                                                <div class="text-truncate">
                                                    <div class="fw-bold text-brand-navy category-title text-truncate">
                                                        {{ $category->name }}</div>
                                                    <small class="text-muted">62 items sold</small>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                <span class="fw-bold text-brand-navy me-1">$775.00</span>
                                                <button
                                                    class="btn btn-sm btn-outline-primary py-0 px-2 btn-edit-category"
                                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                    data-img="{{ $category->image_path ? Storage::url($category->image_path) : '' }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-outline-danger py-0 px-2 btn-delete-category"
                                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Stocks & Inventory Management Table -->
                <div class="card border-0 shadow-sm rounded-3 mb-3" id="view-inventory">
                    <div
                        class="card-header bg-white border-bottom p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h6 class="fw-bold text-brand-navy mb-0"><i
                                    class="bi bi-boxes me-2 text-brand-orange"></i>Inventory & Stock Control</h6>
                            <small class="text-muted">Monitor product items, pricing, availability, and restock
                                alerts</small>
                        </div>
                        <div class="d-flex gap-2">
                            <select id="stockFilter" class="form-select form-select-sm" style="width: auto;">
                                <option value="all">Show All Items</option>
                                <option value="low">Low/Out of Stock Only</option>
                            </select>
                            <button class="btn btn-brand-orange btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addItemModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Product
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 overflow-auto">
                        <table class="table table-hover align-middle mb-0" id="inventoryTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-3" style="width: 70px;">Image</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col" class="text-center">Remaining Quantity</th>
                                    <th scope="col" class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @php
                                        if ($product->stock <= 0) {
                                            $status = 'out';
                                            $badgeClass = 'bg-danger';
                                            $statusIcon = 'bi-x-circle';
                                            $statusText = 'Out of Stock';
                                            $qtyClass = 'text-danger';
                                            $btnClass = 'btn-danger';
                                        } elseif ($product->stock < 20) {
                                            $status = 'low';
                                            $badgeClass = 'bg-warning text-dark';
                                            $statusIcon = 'bi-exclamation-triangle';
                                            $statusText = 'Low Stock';
                                            $qtyClass = 'text-danger';
                                            $btnClass = 'btn-brand-orange';
                                        } else {
                                            $status = 'ok';
                                            $badgeClass = 'bg-success';
                                            $statusIcon = 'bi-check-circle';
                                            $statusText = 'In Stock';
                                            $qtyClass = 'text-brand-navy';
                                            $btnClass = 'btn-outline-primary';
                                        }
                                    @endphp
                                    <tr data-id="{{ $product->id }}" data-qty="{{ $product->stock }}"
                                        data-price="{{ $product->price }}" data-status="{{ $status }}"
                                        data-category="{{ $product->category->id }}">

                                        <!-- PRODUCT IMAGE COLUMN -->
                                        <td class="ps-3">
                                            @if ($product->image_path)
                                                <img src="{{ Storage::url($product->image_path) }}"
                                                    alt="{{ $product->name }}" class="rounded-2 border"
                                                    style="width: 45px; height: 45px; max-width: 45px; max-height: 45px; object-fit: cover;">
                                            @else
                                                <div class="bg-light text-secondary rounded-2 border d-flex align-items-center justify-content-center"
                                                    style="width: 45px; height: 45px; max-width: 45px; max-height: 45px;">
                                                    <i class="bi bi-box-seam fs-5"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="fw-bold text-brand-navy item-name">
                                            {{ $product->name }}
                                        </td>
                                        <td><span
                                                class="badge bg-light text-dark border category-badge">{{ $product->category->name }}</span>
                                        </td>
                                        <td class="price-cell">₱<span class="price-val">{{ $product->price }}</span>
                                        </td>
                                        <td class="status-cell">
                                            <span class="badge {{ $badgeClass }}"><i
                                                    class="bi {{ $statusIcon }} me-1"></i>
                                                {{ $statusText }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="fw-bold {{ $qtyClass }} qty-text">{{ $product->stock }}
                                                pcs</div>
                                        </td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm {{ $btnClass }} btn-restock"><i
                                                    class="bi bi-plus-lg"></i> Restock</button>
                                            <button class="btn btn-sm btn-outline-secondary btn-edit-item"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-outline-danger btn-delete-item"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ==================== CATEGORY MODALS ==================== -->

    <!-- ADD CATEGORY MODAL -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-tag-fill me-2 text-brand-orange"></i>Add Food
                        Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addCategoryForm" action="{{ route('admin.category.store') }}"
                    enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control" id="inputCatName" required
                                placeholder="e.g. Pasta & Noodles">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Image</label>
                            <input type="file" name="image" class="form-control" id="inputCatImage"
                                accept="image/*">
                            <small class="text-muted fs-8">PNG or JPG recommended for best UI fit.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Save
                            Category</button>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="modal-body p-4">
                        <div class="mb-3 text-center d-none" id="editCatPreviewContainer">
                            <img id="editCatImgPreview" src="" class="rounded-3 border mb-2"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" class="form-control" id="editCatName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Change Image (Optional)</label>
                            <input type="file" class="form-control" id="editCatImage" name="image"
                                accept="image/*">
                            <small class="text-muted fs-8">Leave empty to keep current image.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CATEGORY MODAL -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Delete
                        Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="deleteCategoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4 text-center">
                        <i class="bi bi-trash text-danger display-4 d-block mb-3"></i>
                        <h5>Are you sure?</h5>
                        <p class="text-muted mb-0">Are you sure you want to delete <strong id="deleteCatNameText"
                                class="text-dark">this category</strong>? Items attached to this category may lose
                            their reference.</p>
                    </div>
                    <div class="modal-footer bg-light border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-trash me-1"></i> Confirm
                            Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== PRODUCT (INVENTORY) MODALS ==================== -->

    <!-- ADD PRODUCT MODAL -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2 text-brand-orange"></i>Add New
                        Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addItemForm" action="{{ route('admin.product.store') }}" enctype="multipart/form-data"
                    method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" name="name" class="form-control" id="inputItemName" required
                                placeholder="e.g. Cheese Burger">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" name="category_id" id="inputCategory" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Price (₱)</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    id="inputPrice" min="0" placeholder="0.00" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="inputQty"
                                    min="0" value="50" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control" id="imgInput"
                                accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Add
                            Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- RESTOCK PRODUCT MODAL -->
    <div class="modal fade" id="restockItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-brand-orange"></i>Restock
                        Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="restockItemForm" method="POST">
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
                                <input type="number" name="quantity" class="form-control" id="restockAddQty"
                                    min="1" value="50" required>
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

    <!-- EDIT PRODUCT MODAL -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-brand-orange"></i>Edit
                        Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editItemForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editItemId" name="id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" name="name" class="form-control" id="editItemName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" name="category_id" id="editItemCategory" required>
                                @foreach ($categories as $category)
                                    <option class="editCatProducts" value="{{ $category->id }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Price (₱)</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    id="editItemPrice" min="0" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="editItemQty"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Change Image (Optional)</label>
                            <input type="file" name="image" class="form-control" id="editItemImg"
                                accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE PRODUCT MODAL -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Delete Item
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="deleteItemForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4 text-center">
                        <i class="bi bi-box-seam text-danger display-4 d-block mb-3"></i>
                        <h5>Remove Stock Item?</h5>
                        <p class="text-muted mb-0">Are you sure you want to remove <strong id="deleteItemNameText"
                                class="text-dark">this item</strong> from inventory? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer bg-light border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4" id="btnConfirmDeleteItem"><i
                                class="bi bi-trash me-1"></i> Delete Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ADMIN INTERACTIVE LOGIC -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. TOP NAVIGATION TAB CONTROLLER
            const navLinks = document.querySelectorAll('#adminTabs .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    const targetId = this.dataset.target;
                    const targetEl = document.getElementById(targetId);
                    if (targetEl) {
                        targetEl.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // 2. CATEGORY ACTION HANDLERS (EDIT & DELETE)
            const categoryList = document.getElementById('categoryList');
            if (categoryList) {
                categoryList.addEventListener('click', function(e) {
                    const editCatBtn = e.target.closest('.btn-edit-category');
                    const deleteCatBtn = e.target.closest('.btn-delete-category');

                    if (editCatBtn) {
                        const catId = editCatBtn.dataset.id;
                        const catName = editCatBtn.dataset.name;
                        const catImg = editCatBtn.dataset.img;

                        const editCatForm = document.getElementById('editCategoryForm');
                        editCatForm.action = `/admin/category/update/${catId}`;

                        document.getElementById('editCategoryId').value = catId;
                        document.getElementById('editCatName').value = catName;

                        const previewContainer = document.getElementById('editCatPreviewContainer');
                        const imgPreview = document.getElementById('editCatImgPreview');
                        if (catImg) {
                            imgPreview.src = catImg;
                            previewContainer.classList.remove('d-none');
                        } else {
                            previewContainer.classList.add('d-none');
                        }

                        const editCatModal = new bootstrap.Modal(document.getElementById(
                            'editCategoryModal'));
                        editCatModal.show();
                    }

                    if (deleteCatBtn) {
                        const catId = deleteCatBtn.dataset.id;
                        const catName = deleteCatBtn.dataset.name;

                        const deleteCatForm = document.getElementById('deleteCategoryForm');
                        deleteCatForm.action = `/admin/category/delete/${catId}`;

                        document.getElementById('deleteCatNameText').textContent = catName;

                        const deleteCatModal = new bootstrap.Modal(document.getElementById(
                            'deleteCategoryModal'));
                        deleteCatModal.show();
                    }
                });
            }

            // 3. STOCK LEVEL & BADGE REFRESH HELPER
            function updateRowStockState(row, newQty) {
                row.dataset.qty = newQty;

                const qtyText = row.querySelector('.qty-text');
                const statusCell = row.querySelector('.status-cell');
                const restockBtn = row.querySelector('.btn-restock');

                qtyText.textContent = `${newQty} pcs`;

                if (newQty <= 0) {
                    row.dataset.status = 'out';
                    statusCell.innerHTML =
                        `<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Out of Stock</span>`;
                    restockBtn.className = 'btn btn-sm btn-danger btn-restock';
                    qtyText.className = 'fw-bold text-danger qty-text';
                } else if (newQty < 20) {
                    row.dataset.status = 'low';
                    statusCell.innerHTML =
                        `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Low Stock</span>`;
                    restockBtn.className = 'btn btn-sm btn-brand-orange btn-restock';
                    qtyText.className = 'fw-bold text-danger qty-text';
                } else {
                    row.dataset.status = 'ok';
                    statusCell.innerHTML =
                        `<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> In Stock</span>`;
                    restockBtn.className = 'btn btn-sm btn-outline-primary btn-restock';
                    qtyText.className = 'fw-bold text-brand-navy qty-text';
                }
            }

            // INITIALIZE ALL INVENTORY ROWS ON LOAD
            const inventoryRows = document.querySelectorAll('#inventoryTable tbody tr');
            inventoryRows.forEach(row => {
                const qty = parseInt(row.dataset.qty) || 0;
                updateRowStockState(row, qty);
            });

            // 4. RESTOCK, EDIT & DELETE PRODUCT INVENTORY ITEMS
            let activeTargetRow = null;
            const inventoryTable = document.getElementById('inventoryTable');

            if (inventoryTable) {
                inventoryTable.addEventListener('click', function(e) {
                    const restockBtn = e.target.closest('.btn-restock');
                    const editBtn = e.target.closest('.btn-edit-item');
                    const deleteBtn = e.target.closest('.btn-delete-item');

                    if (restockBtn) {
                        activeTargetRow = restockBtn.closest('tr');
                        const productId = activeTargetRow.dataset.id;
                        const itemName = activeTargetRow.querySelector('.item-name').textContent.trim();
                        const currentQty = parseInt(activeTargetRow.dataset.qty) || 0;

                        const restockForm = document.getElementById('restockItemForm');
                        restockForm.action = `/admin/product/restock/${productId}`;

                        document.getElementById('restockItemId').value = productId || '';
                        document.getElementById('restockItemName').value = itemName;
                        document.getElementById('restockCurrentQty').value = `${currentQty} pcs`;
                        document.getElementById('restockAddQty').value = 50;

                        const restockModal = new bootstrap.Modal(document.getElementById(
                            'restockItemModal'));
                        restockModal.show();
                    }

                    if (editBtn) {
                        activeTargetRow = editBtn.closest('tr');
                        const productId = activeTargetRow.dataset.id;

                        const editForm = document.getElementById('editItemForm');
                        editForm.action = `/admin/product/update/${productId}`;

                        const editCatProducts = document.querySelectorAll('.editCatProducts');

                        editCatProducts.forEach(element => {
                            if (element.value == activeTargetRow.dataset.category) {
                                element.selected = true;
                            }
                        });

                        document.getElementById('editItemId').value = productId || '';
                        document.getElementById('editItemName').value = activeTargetRow.querySelector(
                            '.item-name').textContent.trim();
                        document.getElementById('editItemPrice').value = activeTargetRow.dataset.price ||
                            activeTargetRow.querySelector('.price-val').textContent.trim();
                        document.getElementById('editItemQty').value = activeTargetRow.dataset.qty;

                        const editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
                        editModal.show();
                    }

                    if (deleteBtn) {
                        activeTargetRow = deleteBtn.closest('tr');
                        const productId = activeTargetRow.dataset.id;
                        const name = activeTargetRow.querySelector('.item-name').textContent;

                        const deleteForm = document.getElementById('deleteItemForm');
                        deleteForm.action = `/admin/product/delete/${productId}`;

                        document.getElementById('deleteItemNameText').textContent = name;

                        const deleteModal = new bootstrap.Modal(document.getElementById('deleteItemModal'));
                        deleteModal.show();
                    }
                });
            }

            // 5. INVENTORY FILTERING
            const stockFilter = document.getElementById('stockFilter');
            if (stockFilter) {
                stockFilter.addEventListener('change', function() {
                    const value = this.value;
                    const rows = inventoryTable.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const status = row.dataset.status;
                        if (value === 'all') {
                            row.style.display = '';
                        } else if (value === 'low') {
                            row.style.display = (status === 'low' || status === 'out') ? '' :
                            'none';
                        }
                    });
                });
            }

        });
    </script>
</body>

</html>
