<!-- Top Admin Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-brand-bg px-3 py-2 flex-shrink-0">
    <div class="container-fluid p-0">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
            <img src="{{ asset('Logo.png') }}" alt="TapAndGo Logo" height="40" class="d-inline-block align-text-top">
            <div class="d-none d-sm-block">
                <small class="text-uppercase text-white-50 fs-8 fw-normal" style="letter-spacing: 1px;">Admin
                    Console</small>
            </div>
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
                <li class="nav-item">
                    <button class="nav-link px-3 rounded-2" data-target="view-analytics"><i
                            class="bi bi-bar-chart-line-fill me-1"></i> Analytics</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link px-3 rounded-2" data-target="view-inventory"><i
                            class="bi bi-boxes me-1"></i> Inventory & Stocks</button>
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
