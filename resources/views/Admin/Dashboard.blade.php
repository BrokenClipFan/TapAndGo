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
            --brand-navy: #0f1d36;
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
                <span class="bg-brand-orange rounded-3 px-2 py-1 fs-5">
                    <i class="bi bi-lightning-charge-fill"></i>
                </span>
                <div>
                    <div class="lh-1 fs-5">TapAndGo</div>
                    <small class="text-uppercase text-white-50 fs-8 fw-normal" style="letter-spacing: 1px;">Admin Console</small>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Admin Navigation Tab Controllers -->
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="nav nav-pills me-auto mb-2 mb-lg-0 ms-lg-4 gap-1" id="adminTabs">
                    <li class="nav-item">
                        <button class="nav-link active px-3 rounded-2" data-target="view-overview"><i class="bi bi-grid-1x2-fill me-1"></i> Overview</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 rounded-2" data-target="view-analytics"><i class="bi bi-bar-chart-line-fill me-1"></i> Analytics</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 rounded-2" data-target="view-inventory"><i class="bi bi-boxes me-1"></i> Inventory & Stocks</button>
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
            
            <!-- LEFT MAIN COLUMN -->
            <div class="col-lg-8 col-xl-9 h-100 d-flex flex-column gap-3 overflow-auto custom-scroll pe-2">
                
                <!-- Section 1: KPI Statistics Summary Cards -->
                <div class="row g-3 flex-shrink-0" id="view-overview">
                    
                    <!-- KPI 1: Total Revenue -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Total Revenue</span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border py-0 px-2 dropdown-toggle fs-8 text-muted" type="button" id="kpiRevenueTimeframe" data-bs-toggle="dropdown">
                                            Today
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="revenue" data-range="today">Today</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="revenue" data-range="weekly">Weekly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="revenue" data-range="monthly">Monthly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="revenue" data-range="yearly">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1" id="kpiRevenueVal">$1,482.50</h3>
                                <small class="text-success fw-semibold" id="kpiRevenueTrend"><i class="bi bi-arrow-up-right me-1"></i>+12.4% vs yesterday</small>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 2: Orders Processed -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Orders Processed</span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border py-0 px-2 dropdown-toggle fs-8 text-muted" type="button" id="kpiOrdersTimeframe" data-bs-toggle="dropdown">
                                            Today
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="orders" data-range="today">Today</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="orders" data-range="weekly">Weekly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="orders" data-range="monthly">Monthly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="orders" data-range="yearly">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1" id="kpiOrdersVal">142</h3>
                                <small class="text-success fw-semibold" id="kpiOrdersTrend"><i class="bi bi-arrow-up-right me-1"></i>+8.1% vs yesterday</small>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 3: Tax Accrued (Replaced Avg Order Value) -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 kpi-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold">Tax Accrued</span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border py-0 px-2 dropdown-toggle fs-8 text-muted" type="button" id="kpiTaxTimeframe" data-bs-toggle="dropdown">
                                            Today
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="tax" data-range="today">Today</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="tax" data-range="weekly">Weekly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="tax" data-range="monthly">Monthly</a></li>
                                            <li><a class="dropdown-item small timeframe-select" href="#" data-kpi="tax" data-range="yearly">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-brand-navy mb-1" id="kpiTaxVal">$134.77</h3>
                                <small class="text-success fw-semibold" id="kpiTaxTrend"><i class="bi bi-arrow-up-right me-1"></i>10% Standard VAT</small>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 4: Active Kiosks -->
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
                                <small class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>100% Operational</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Analytics & Sales Performance Breakdown -->
                <div class="row g-3" id="view-analytics">
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-brand-navy mb-0"><i class="bi bi-clock-history me-2 text-brand-orange"></i>Peak Hours Order Volume</h6>
                                <span class="badge bg-light text-dark border">Today</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>11:00 AM - 1:00 PM (Lunch Rush)</span>
                                        <span class="fw-bold text-brand-navy">58 Orders (41%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-brand-orange" role="progressbar" style="width: 75%;"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>5:00 PM - 7:00 PM (Dinner Peak)</span>
                                        <span class="fw-bold text-brand-navy">42 Orders (30%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-brand-navy" role="progressbar" style="width: 55%;"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>2:00 PM - 4:00 PM (Afternoon Snacks)</span>
                                        <span class="fw-bold text-brand-navy">28 Orders (20%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Sales Breakdown with Scroll & Add Category Button -->
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column">
                            <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-brand-navy mb-0"><i class="bi bi-pie-chart-fill me-2 text-brand-orange"></i>Sales by Category</h6>
                                <button class="btn btn-sm btn-brand-orange" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="bi bi-plus-circle me-1"></i> Add Category
                                </button>
                            </div>
                            
                            <!-- Scrollable Categories Container -->
                            <div class="card-body p-3 overflow-auto custom-scroll" style="max-height: 250px;" id="categoriesContainer">
                                <ul class="list-group list-group-flush" id="categoryList">
                                    @foreach($categories as $category)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0 category-item" data-id="{{ $category->id }}">
                                        <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                                            
                                            {{-- Category Image --}}
                                            @if($category->image_path)
                                                <img src="{{ Storage::url($category->image_path) }}" 
                                                    alt="{{ $category->name }}" 
                                                    class="rounded-2 flex-shrink-0 category-img-preview" 
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-2 d-flex align-items-center justify-content-center flex-shrink-0 category-img-placeholder" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-tags-fill fs-5"></i>
                                                </div>
                                            @endif

                                            <div class="text-truncate">
                                                <div class="fw-bold text-brand-navy category-title text-truncate">{{ $category->name }}</div>
                                                <small class="text-muted">62 items sold</small>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                            <span class="fw-bold text-brand-navy me-1">$775.00</span>
                                            
                                            <!-- Action Buttons -->
                                            <button class="btn btn-sm btn-outline-primary py-0 px-2 btn-edit-category" 
                                                    data-id="{{ $category->id }}" 
                                                    data-name="{{ $category->name }}"
                                                    data-img="{{ $category->image_path ? Storage::url($category->image_path) : '' }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-delete-category" data-id="{{ $category->id }}">
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
                    <div class="card-header bg-white border-bottom p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h6 class="fw-bold text-brand-navy mb-0"><i class="bi bi-boxes me-2 text-brand-orange"></i>Inventory & Stock Control</h6>
                            <small class="text-muted">Monitor item ingredients, availability, and restock alerts</small>
                        </div>
                        <div class="d-flex gap-2">
                            <select id="stockFilter" class="form-select form-select-sm" style="width: auto;">
                                <option value="all">Show All Items</option>
                                <option value="low">Low/Out of Stock Only</option>
                            </select>
                            <button class="btn btn-brand-orange btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 overflow-auto">
                        <table class="table table-hover align-middle mb-0" id="inventoryTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-3">Item Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col" class="text-center">Remaining Quantity</th>
                                    <th scope="col" class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-qty="180" data-max="200" data-status="ok">
                                    <td class="ps-3">
                                        <strong class="text-brand-navy item-name">Classic Beef Patties</strong>
                                        <br><small class="text-muted">SKU: #ING-101</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Ingredients</span></td>
                                    <td class="status-cell"><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> In Stock</span></td>
                                    <td class="text-center">
                                        <div class="fw-bold text-brand-navy qty-text">180 pcs</div>
                                        <div class="progress mt-1 mx-auto" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success progress-bar-fill" style="width: 90%;"></div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-primary btn-restock"><i class="bi bi-plus-lg"></i> Restock</button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr data-qty="15" data-max="100" data-status="low">
                                    <td class="ps-3">
                                        <strong class="text-brand-navy item-name">Cheddar Cheese Slices</strong>
                                        <br><small class="text-muted">SKU: #ING-104</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Ingredients</span></td>
                                    <td class="status-cell"><span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Low Stock</span></td>
                                    <td class="text-center">
                                        <div class="fw-bold text-danger qty-text">15 pcs</div>
                                        <div class="progress mt-1 mx-auto" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-warning progress-bar-fill" style="width: 15%;"></div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-brand-orange btn-restock"><i class="bi bi-plus-lg"></i> Restock</button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr data-qty="0" data-max="50" data-status="out">
                                    <td class="ps-3">
                                        <strong class="text-brand-navy item-name">Cold Milkshake Base</strong>
                                        <br><small class="text-muted">SKU: #BEV-302</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Beverages</span></td>
                                    <td class="status-cell"><span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Out of Stock</span></td>
                                    <td class="text-center">
                                        <div class="fw-bold text-danger qty-text">0 pcs</div>
                                        <div class="progress mt-1 mx-auto" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-danger progress-bar-fill" style="width: 0%;"></div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-danger btn-restock"><i class="bi bi-plus-lg"></i> Restock</button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDEBAR COLUMN: Terminals & Recent Transactions -->
            <div class="col-lg-4 col-xl-3 h-100 d-flex flex-column gap-3">
                
                <!-- Kiosk Terminals Panel -->
                <div class="card border-0 shadow-sm rounded-3 flex-shrink-0">
                    <div class="card-header bg-brand-navy text-white p-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-display me-2 text-brand-orange"></i>Kiosk Terminals</h6>
                        <span class="badge bg-success">Live</span>
                    </div>
                    <div class="card-body p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <strong class="text-brand-navy">Station #K-01</strong>
                                <br><small class="text-muted">Express Main Counter</small>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success">Online</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <strong class="text-brand-navy">Station #K-02</strong>
                                <br><small class="text-muted">Dine In Terminal A</small>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success">Online</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <strong class="text-brand-navy">Station #K-03</strong>
                                <br><small class="text-muted">Dine In Terminal B</small>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success">Online</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <strong class="text-brand-navy">Station #K-04</strong>
                                <br><small class="text-muted">Take Out Drive-thru</small>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success">Online</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions Activity Log -->
                <div class="card border-0 shadow-sm rounded-3 flex-grow-1 d-flex flex-column overflow-hidden">
                    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-brand-navy mb-0"><i class="bi bi-receipt me-2 text-brand-orange"></i>Recent Transactions</h6>
                        <a href="#" class="small text-decoration-none text-brand-orange fw-semibold">View All</a>
                    </div>
                    <div class="card-body p-2 overflow-auto custom-scroll flex-grow-1 bg-light">
                        
                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-brand-navy small">#TG-94820</strong>
                                    <span class="fw-bold text-brand-navy">$45.10</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span>Code: <strong class="text-brand-orange">837-D0C</strong></span>
                                    <span class="badge bg-success">Paid</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-brand-navy small">#TG-94821</strong>
                                    <span class="fw-bold text-brand-navy">$17.05</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span>Code: <strong class="text-brand-orange">201-F2B</strong></span>
                                    <span class="badge bg-warning text-dark">Awaiting Payment</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-brand-navy small">#TG-94819</strong>
                                    <span class="fw-bold text-brand-navy">$28.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span>Code: <strong class="text-brand-orange">492-X1P</strong></span>
                                    <span class="badge bg-success">Paid</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-2">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-brand-navy small">#TG-94818</strong>
                                    <span class="fw-bold text-brand-navy">$12.50</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span>Code: <strong class="text-brand-orange">104-A9Z</strong></span>
                                    <span class="badge bg-success">Paid</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- MODAL 1: ADD NEW CATEGORY (WITH IMAGE INPUT) -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-tag-fill me-2 text-brand-orange"></i>Add Food Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCategoryForm" action="{{ route('admin.category.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control" id="inputCatName" required placeholder="e.g. Pasta & Noodles">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Image</label>
                            <input type="file" name="image" class="form-control" id="inputCatImage" accept="image/*">
                            <small class="text-muted fs-8">PNG or JPG recommended for best UI fit.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: ADD NEW INVENTORY ITEM -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2 text-brand-orange"></i>Add New Stock Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addItemForm">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" class="form-control" id="inputItemName" required placeholder="e.g. Hamburger Buns">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" id="inputCategory">
                                <option value="Ingredients">Ingredients</option>
                                <option value="Beverages">Beverages</option>
                                <option value="Packaging">Packaging</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Initial Quantity</label>
                                <input type="number" class="form-control" id="inputQty" min="1" value="50" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Max Target Stock</label>
                                <input type="number" class="form-control" id="inputMax" min="1" value="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Add to Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-brand-navy text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-brand-orange"></i>Edit Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm">
                    <input type="hidden" id="editCategoryId">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" class="form-control" id="editCatName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Change Image (Optional)</label>
                            <input type="file" class="form-control" id="editCatImage" accept="image/*">
                            <small class="text-muted fs-8">Leave empty to keep current image.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand-orange"><i class="bi bi-check-lg me-1"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ADMIN INTERACTIVE LOGIC -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. TOP NAVIGATION TAB CONTROLLER
            const navLinks = document.querySelectorAll('#adminTabs .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    const targetId = this.dataset.target;
                    const targetEl = document.getElementById(targetId);
                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // 2. DYNAMIC TIMEFRAME CLICK LISTENERS FOR KPI METRICS
            const kpiDataMap = {
                revenue: {
                    today: { val: '$1,482.50', trend: '<i class="bi bi-arrow-up-right me-1"></i>+12.4% vs yesterday' },
                    weekly: { val: '$9,840.00', trend: '<i class="bi bi-arrow-up-right me-1"></i>+18.2% vs last week' },
                    monthly: { val: '$42,150.00', trend: '<i class="bi bi-arrow-up-right me-1"></i>+5.6% vs last month' },
                    yearly: { val: '$512,000.00', trend: '<i class="bi bi-arrow-up-right me-1"></i>+22.1% vs last year' }
                },
                orders: {
                    today: { val: '142', trend: '<i class="bi bi-arrow-up-right me-1"></i>+8.1% vs yesterday' },
                    weekly: { val: '980', trend: '<i class="bi bi-arrow-up-right me-1"></i>+14.0% vs last week' },
                    monthly: { val: '4,120', trend: '<i class="bi bi-arrow-up-right me-1"></i>+3.2% vs last month' },
                    yearly: { val: '49,800', trend: '<i class="bi bi-arrow-up-right me-1"></i>+19.8% vs last year' }
                },
                tax: {
                    today: { val: '$134.77', trend: '<i class="bi bi-arrow-up-right me-1"></i>10% Standard VAT' },
                    weekly: { val: '$894.50', trend: '<i class="bi bi-arrow-up-right me-1"></i>10% Standard VAT' },
                    monthly: { val: '$3,831.80', trend: '<i class="bi bi-arrow-up-right me-1"></i>10% Standard VAT' },
                    yearly: { val: '$46,545.00', trend: '<i class="bi bi-arrow-up-right me-1"></i>10% Standard VAT' }
                }
            };

            document.querySelectorAll('.timeframe-select').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const kpiType = this.dataset.kpi;
                    const range = this.dataset.range;
                    const capitalizedRange = range.charAt(0).toUpperCase() + range.slice(1);

                    if (kpiType === 'revenue') {
                        document.getElementById('kpiRevenueTimeframe').textContent = capitalizedRange;
                        document.getElementById('kpiRevenueVal').textContent = kpiDataMap.revenue[range].val;
                        document.getElementById('kpiRevenueTrend').innerHTML = kpiDataMap.revenue[range].trend;
                    } else if (kpiType === 'orders') {
                        document.getElementById('kpiOrdersTimeframe').textContent = capitalizedRange;
                        document.getElementById('kpiOrdersVal').textContent = kpiDataMap.orders[range].val;
                        document.getElementById('kpiOrdersTrend').innerHTML = kpiDataMap.orders[range].trend;
                    } else if (kpiType === 'tax') {
                        document.getElementById('kpiTaxTimeframe').textContent = capitalizedRange;
                        document.getElementById('kpiTaxVal').textContent = kpiDataMap.tax[range].val;
                        document.getElementById('kpiTaxTrend').innerHTML = kpiDataMap.tax[range].trend;
                    }
                });
            });

            // 3. ADD CATEGORY FORM LOGIC (WITH PREVIEW/IMAGE SUPPORT)
            // const addCategoryForm = document.getElementById('addCategoryForm');
            // addCategoryForm.addEventListener('submit', function(e) {
            //     e.preventDefault();

            //     const catName = document.getElementById('inputCatName').value.trim();
            //     const imageInput = document.getElementById('inputCatImage');
            //     const categoryList = document.getElementById('categoryList');

            //     let imageHtml = `
            //         <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            //             <i class="bi bi-tags-fill fs-5"></i>
            //         </div>`;

            //     // If user uploaded an image, read it locally for instant preview
            //     if (imageInput.files && imageInput.files[0]) {
            //         const reader = new FileReader();
            //         reader.onload = function(evt) {
            //             renderCategoryItem(evt.target.result);
            //         };
            //         reader.readAsDataURL(imageInput.files[0]);
            //     } else {
            //         renderCategoryItem(null);
            //     }

            //     function renderCategoryItem(imgSrc) {
            //         if (imgSrc) {
            //             imageHtml = `<img src="${imgSrc}" class="category-icon-img" alt="${catName}">`;
            //         }

            //         const li = document.createElement('li');
            //         li.className = 'list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0';
            //         li.innerHTML = `
            //             <div class="d-flex align-items-center gap-2">
            //                 ${imageHtml}
            //                 <div>
            //                     <div class="fw-bold text-brand-navy category-title">${catName}</div>
            //                     <small class="text-muted">0 items sold</small>
            //                 </div>
            //             </div>
            //             <span class="fw-bold text-brand-navy">$0.00</span>
            //         `;

            //         categoryList.prepend(li);

            //         // Close Modal & Reset
            //         const modalEl = document.getElementById('addCategoryModal');
            //         const modalInstance = bootstrap.Modal.getInstance(modalEl);
            //         if (modalInstance) modalInstance.hide();
            //         addCategoryForm.reset();
            //     }
            // });

            // 4. STOCK LEVEL & BADGE REFRESH HELPER
            function updateRowStockState(row, newQty) {
                const max = parseInt(row.dataset.max) || 100;
                row.dataset.qty = newQty;

                const qtyText = row.querySelector('.qty-text');
                const progressBar = row.querySelector('.progress-bar-fill');
                const statusCell = row.querySelector('.status-cell');
                const restockBtn = row.querySelector('.btn-restock');

                const percent = Math.min(Math.round((newQty / max) * 100), 100);
                qtyText.textContent = `${newQty} pcs`;
                progressBar.style.width = `${percent}%`;

                if (newQty <= 0) {
                    row.dataset.status = 'out';
                    statusCell.innerHTML = `<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Out of Stock</span>`;
                    progressBar.className = 'progress-bar bg-danger progress-bar-fill';
                    restockBtn.className = 'btn btn-sm btn-danger btn-restock';
                    qtyText.className = 'fw-bold text-danger qty-text';
                } else if (percent < 25) {
                    row.dataset.status = 'low';
                    statusCell.innerHTML = `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Low Stock</span>`;
                    progressBar.className = 'progress-bar bg-warning progress-bar-fill';
                    restockBtn.className = 'btn btn-sm btn-brand-orange btn-restock';
                    qtyText.className = 'fw-bold text-danger qty-text';
                } else {
                    row.dataset.status = 'ok';
                    statusCell.innerHTML = `<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> In Stock</span>`;
                    progressBar.className = 'progress-bar bg-success progress-bar-fill';
                    restockBtn.className = 'btn btn-sm btn-outline-primary btn-restock';
                    qtyText.className = 'fw-bold text-brand-navy qty-text';
                }
            }

            // 5. RESTOCK & DELETE INVENTORY ITEMS
            const inventoryTable = document.getElementById('inventoryTable');
            inventoryTable.addEventListener('click', function(e) {
                const restockBtn = e.target.closest('.btn-restock');
                const deleteBtn = e.target.closest('.btn-delete');

                if (restockBtn) {
                    const row = restockBtn.closest('tr');
                    const itemName = row.querySelector('.item-name').textContent;
                    const currentQty = parseInt(row.dataset.qty) || 0;

                    const addQty = prompt(`Restock "${itemName}"\nCurrent quantity: ${currentQty}\nEnter amount to add:`, "50");
                    if (addQty !== null && !isNaN(addQty) && parseInt(addQty) > 0) {
                        const newTotal = currentQty + parseInt(addQty);
                        updateRowStockState(row, newTotal);
                    }
                }

                if (deleteBtn) {
                    const row = deleteBtn.closest('tr');
                    const itemName = row.querySelector('.item-name').textContent;
                    if (confirm(`Are you sure you want to remove "${itemName}" from inventory?`)) {
                        row.remove();
                    }
                }
            });

            // 6. ADD NEW INVENTORY ITEM
            const addItemForm = document.getElementById('addItemForm');
            addItemForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const name = document.getElementById('inputItemName').value.trim();
                const category = document.getElementById('inputCategory').value;
                const qty = parseInt(document.getElementById('inputQty').value) || 0;
                const max = parseInt(document.getElementById('inputMax').value) || 100;
                const sku = '#ING-' + Math.floor(100 + Math.random() * 900);

                const tbody = inventoryTable.querySelector('tbody');
                const newRow = document.createElement('tr');
                newRow.dataset.qty = qty;
                newRow.dataset.max = max;

                newRow.innerHTML = `
                    <td class="ps-3">
                        <strong class="text-brand-navy item-name">${name}</strong>
                        <br><small class="text-muted">SKU: ${sku}</small>
                    </td>
                    <td><span class="badge bg-light text-dark border">${category}</span></td>
                    <td class="status-cell"></td>
                    <td class="text-center">
                        <div class="fw-bold qty-text">${qty} pcs</div>
                        <div class="progress mt-1 mx-auto" style="height: 6px; width: 100px;">
                            <div class="progress-bar progress-bar-fill" style="width: 0%;"></div>
                        </div>
                    </td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-primary btn-restock"><i class="bi bi-plus-lg"></i> Restock</button>
                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                    </td>
                `;

                tbody.appendChild(newRow);
                updateRowStockState(newRow, qty);

                const modalEl = document.getElementById('addItemModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();

                addItemForm.reset();
            });

            // 7. INVENTORY FILTERING
            const stockFilter = document.getElementById('stockFilter');
            stockFilter.addEventListener('change', function() {
                const value = this.value;
                const rows = inventoryTable.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const status = row.dataset.status;
                    if (value === 'all') {
                        row.style.display = '';
                    } else if (value === 'low') {
                        row.style.display = (status === 'low' || status === 'out') ? '' : 'none';
                    }
                });
            });

        });
    </script>
</body>
</html>