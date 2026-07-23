<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TapAndGo - Cashier Terminal</title>
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

        /* Active Order Card Selection */
        .order-card {
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            border-left: 5px solid transparent !important;
        }
        .order-card.active {
            border-left: 5px solid var(--brand-orange) !important;
            background-color: #ffffff !important;
        }

        /* Modal Custom Styles */
        .payment-option-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            background-color: #ffffff;
        }
        .payment-option-card:hover {
            border-color: var(--brand-orange);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.15);
        }
        .payment-option-card.selected {
            border-color: var(--brand-orange) !important;
            background-color: rgba(255, 107, 0, 0.03) !important;
        }

        .modal-payment-header {
            background-color: var(--brand-navy);
            color: #ffffff;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
    </style>
</head>
<body class="vh-100 overflow-hidden d-flex flex-column">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-brand-bg px-3 py-2 flex-shrink-0">
        <div class="container-fluid p-0">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <span class="bg-brand-orange rounded-3 px-2 py-1 fs-5">
                    <i class="bi bi-lightning-charge-fill"></i>
                </span>
                <div>
                    <div class="lh-1 fs-5">TapAndGo</div>
                    <small class="text-uppercase text-white-50 fs-8 fw-normal" style="letter-spacing: 1px;">Cashier Station</small>
                </div>
            </a>

            <!-- Quick Kiosk Code Quick Lookup Bar -->
            <form id="kioskCodeForm" class="d-flex align-items-center ms-lg-4 me-auto my-1 my-lg-0" style="max-width: 320px; width: 100%;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-brand-navy border-0 fw-bold">
                        <i class="bi bi-qr-code-scan"></i>
                    </span>
                    <input type="text" id="kioskCodeInput" class="form-control border-0 fw-bold px-2" placeholder="Enter Pickup Code (e.g. 837-D0C)" autocomplete="off">
                    <button class="btn btn-brand-orange fw-bold" type="submit">
                        Lookup
                    </button>
                </div>
            </form>

            <!-- Cashier Profile / Station Info & Breeze Logout -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                <div class="text-end text-white d-none d-md-block">
                    <div class="fw-bold lh-1">{{ Auth::user()->name ?? 'Cashier #01' }}</div>
                    <small class="text-white-50">Station ID: #CS-01</small>
                </div>
                <!-- Breeze Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-2">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Workspace Container -->
    <div class="container-fluid flex-grow-1 overflow-hidden p-3">
        <div class="row h-100 g-3">
            
            <!-- COLUMN 1: Active Orders List -->
            <div class="col-lg-4 col-md-5 h-100 d-flex flex-column">
                <div class="card border-0 shadow-sm flex-grow-1 d-flex flex-column overflow-hidden rounded-3">
                    
                    <!-- Search Header -->
                    <div class="card-header bg-white border-bottom p-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="orderSearchInput" class="form-control bg-light border-start-0" placeholder="Filter orders list...">
                        </div>
                    </div>

                    <!-- Scrollable Orders Container -->
                    <div class="card-body p-2 overflow-auto custom-scroll flex-grow-1 bg-light" id="ordersListContainer">
                        
                        <!-- Order Card #1 -->
                        <div class="card mb-2 border-0 shadow-sm order-card active" data-ticket="TG-94820" data-type="Dine In" data-type-color="bg-brand-orange" data-code="837-D0C" data-total="45.10" data-subtotal="41.00" data-tax="4.10" data-status="pending">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-brand-orange text-uppercase">Dine In</span>
                                        <h6 class="fw-bold text-brand-navy mb-0 mt-1">Ticket #TG-94820</h6>
                                    </div>
                                    <span class="text-end">
                                        <span class="fw-bold text-brand-navy fs-5">$45.10</span>
                                        <br><small class="text-muted">Code: <strong class="text-brand-orange">837-D0C</strong></small>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="bi bi-clock me-1"></i> 2 mins ago</span>
                                    <span class="badge bg-warning text-dark status-badge"><i class="bi bi-hourglass-split"></i> Awaiting Payment</span>
                                </div>
                            </div>
                            <!-- Hidden Data Payload for JS -->
                            <template class="order-items-template">
                                <tr>
                                    <td><strong class="text-brand-navy">Classic Cheeseburger Deluxe</strong><br><small class="text-muted">+ Extra Cheddar Cheese, No Pickles</small></td>
                                    <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">2</span></td>
                                    <td class="text-end">$12.50</td>
                                    <td class="text-end fw-bold">$25.00</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-brand-navy">Spicy Volcano Patty Sandwich</strong><br><small class="text-muted">+ House Sauce Extra</small></td>
                                    <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">1</span></td>
                                    <td class="text-end">$13.00</td>
                                    <td class="text-end fw-bold">$13.00</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-brand-navy">Cold Milkshake (Chocolate)</strong></td>
                                    <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">1</span></td>
                                    <td class="text-end">$3.00</td>
                                    <td class="text-end fw-bold">$3.00</td>
                                </tr>
                            </template>
                        </div>

                        <!-- Order Card #2 -->
                        <div class="card mb-2 border-0 shadow-sm order-card" data-ticket="TG-94821" data-type="Take Out" data-type-color="bg-primary" data-code="201-F2B" data-total="17.05" data-subtotal="15.50" data-tax="1.55" data-status="pending">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary text-uppercase">Take Out</span>
                                        <h6 class="fw-bold text-brand-navy mb-0 mt-1">Ticket #TG-94821</h6>
                                    </div>
                                    <span class="text-end">
                                        <span class="fw-bold text-brand-navy fs-5">$17.05</span>
                                        <br><small class="text-muted">Code: <strong class="text-brand-orange">201-F2B</strong></small>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="bi bi-clock me-1"></i> 5 mins ago</span>
                                    <span class="badge bg-warning text-dark status-badge"><i class="bi bi-hourglass-split"></i> Awaiting Payment</span>
                                </div>
                            </div>
                            <!-- Hidden Data Payload for JS -->
                            <template class="order-items-template">
                                <tr>
                                    <td><strong class="text-brand-navy">Jolly-style Double stacker</strong><br><small class="text-muted">Sweet honey mustard, pickles</small></td>
                                    <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">1</span></td>
                                    <td class="text-end">$15.50</td>
                                    <td class="text-end fw-bold">$15.50</td>
                                </tr>
                            </template>
                        </div>

                    </div>
                </div>
            </div>

            <!-- COLUMN 2: Selected Ticket Details -->
            <div class="col-lg-8 col-md-7 h-100 d-flex flex-column">
                <div class="card border-0 shadow-sm flex-grow-1 d-flex flex-column overflow-hidden rounded-3">
                    
                    <!-- Ticket Header Details -->
                    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h4 class="fw-bold text-brand-navy mb-0" id="displayTicketId">Ticket #TG-94820</h4>
                                <span class="badge bg-brand-orange" id="displayTypeBadge">Dine In</span>
                            </div>
                            <small class="text-muted">Pickup Code: <strong class="text-brand-orange fs-6 ms-1" id="displayPickupCode">837-D0C</strong> | Station: #K-01</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-danger btn-sm" id="btnCancelOrder"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print</button>
                        </div>
                    </div>

                    <!-- Scrollable Order Items Table -->
                    <div class="card-body p-3 overflow-auto custom-scroll flex-grow-1">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Item Description</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-end">Unit Price</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="displayTableBody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Summary & Action Footer -->
                    <div class="card-footer bg-light border-top p-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="fw-semibold" id="displaySubtotal">$41.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Tax (10%):</span>
                                    <span class="fw-semibold" id="displayTax">$4.10</span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex justify-content-between">
                                    <strong class="text-brand-navy fs-5">Grand Total:</strong>
                                    <strong class="text-brand-orange fs-4" id="displayGrandTotal">$45.10</strong>
                                </div>
                            </div>

                            <div class="col-md-6" id="actionButtonContainer">
                                <button type="button" class="btn btn-brand-orange btn-lg w-100 py-3 fw-bold d-flex justify-content-center align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    <i class="bi bi-wallet2 fs-5"></i>
                                    <span>Select Payment Method</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- PAYMENT SELECTION MODAL -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                
                <div class="modal-header modal-payment-header text-center d-block py-4 border-0">
                    <h4 class="fw-bold mb-1" id="paymentModalLabel">How would you like to pay?</h4>
                    <p class="text-white-50 mb-0 small">Please select an option below to authorize payment</p>
                </div>

                <div class="modal-body p-4 bg-light">
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="payment-option-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center" data-method="Credit/Debit Card">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                    <i class="bi bi-credit-card-fill fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-brand-navy mb-1">Credit/Debit Card</h5>
                                <small class="text-muted">Pay with Visa/Mastercard</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="payment-option-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center" data-method="E-Wallet Pass">
                                <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                    <i class="bi bi-phone-fill fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-brand-navy mb-1">E-Wallet Pass</h5>
                                <small class="text-muted">Scan GCash or PayMaya QR</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="payment-option-card p-4 text-center d-flex flex-column align-items-center justify-content-center" data-method="Cash">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                    <i class="bi bi-cash-stack fs-3 text-brand-orange"></i>
                                </div>
                                <h5 class="fw-bold text-brand-navy mb-1">Pay Cash at Counter</h5>
                                <small class="text-muted">Receive scannable order code & settle payment with cashier</small>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light border-0 d-flex justify-content-between pb-4 px-4">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-3 fw-semibold" data-bs-dismiss="modal">Back to Menu</button>
                    <button type="button" class="btn btn-brand-orange px-4 py-2 rounded-3 fw-semibold d-none" id="btnConfirmPayment">
                        <i class="bi bi-check-circle me-1"></i> Confirm Payment
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cashier Interactive Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let activeCard = document.querySelector('.order-card.active');
            let selectedMethod = null;

            // 1. Function to Load Selected Order into Right Panel
            function loadOrderDetails(card) {
                if (!card) return;

                document.querySelectorAll('.order-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                activeCard = card;

                const ticket = card.dataset.ticket;
                const type = card.dataset.type;
                const typeColor = card.dataset.typeColor;
                const code = card.dataset.code;
                const total = parseFloat(card.dataset.total).toFixed(2);
                const subtotal = parseFloat(card.dataset.subtotal).toFixed(2);
                const tax = parseFloat(card.dataset.tax).toFixed(2);
                const status = card.dataset.status;

                document.getElementById('displayTicketId').textContent = 'Ticket #' + ticket;
                
                const typeBadge = document.getElementById('displayTypeBadge');
                typeBadge.textContent = type;
                typeBadge.className = 'badge ' + typeColor;

                document.getElementById('displayPickupCode').textContent = code;
                document.getElementById('displaySubtotal').textContent = '$' + subtotal;
                document.getElementById('displayTax').textContent = '$' + tax;
                document.getElementById('displayGrandTotal').textContent = '$' + total;

                const template = card.querySelector('.order-items-template');
                const tbody = document.getElementById('displayTableBody');
                if (template) {
                    tbody.innerHTML = template.innerHTML;
                }

                const btnContainer = document.getElementById('actionButtonContainer');
                if (status === 'paid') {
                    btnContainer.innerHTML = `
                        <div class="alert alert-success mb-0 py-3 text-center fw-bold d-flex align-items-center justify-content-center gap-2 rounded-3">
                            <i class="bi bi-check-circle-fill fs-5"></i> Payment Completed
                        </div>
                    `;
                } else {
                    btnContainer.innerHTML = `
                        <button type="button" class="btn btn-brand-orange btn-lg w-100 py-3 fw-bold d-flex justify-content-center align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="bi bi-wallet2 fs-5"></i>
                            <span>Select Payment Method</span>
                        </button>
                    `;
                }
            }

            if (activeCard) loadOrderDetails(activeCard);

            document.querySelectorAll('.order-card').forEach(card => {
                card.addEventListener('click', () => loadOrderDetails(card));
            });

            // 2. Kiosk Code Direct Lookup Logic
            const kioskForm = document.getElementById('kioskCodeForm');
            const kioskInput = document.getElementById('kioskCodeInput');

            kioskForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const query = kioskInput.value.trim().toLowerCase();
                if (!query) return;

                let matchFound = false;
                document.querySelectorAll('.order-card').forEach(card => {
                    const code = (card.dataset.code || '').toLowerCase();
                    const ticket = (card.dataset.ticket || '').toLowerCase();

                    if (code === query || ticket === query || code.includes(query) || ticket.includes(query)) {
                        loadOrderDetails(card);
                        card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        matchFound = true;
                    }
                });

                if (!matchFound) {
                    alert('No order found matching code: ' + kioskInput.value);
                } else {
                    kioskInput.value = ''; // clear input on success
                }
            });

            // 3. Filter Search Logic
            const searchInput = document.getElementById('orderSearchInput');
            searchInput.addEventListener('keyup', function () {
                const query = this.value.toLowerCase();
                document.querySelectorAll('.order-card').forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(query) ? 'block' : 'none';
                });
            });

            // 4. Payment Modal Card Selection Logic
            const confirmBtn = document.getElementById('btnConfirmPayment');
            document.querySelectorAll('.payment-option-card').forEach(option => {
                option.addEventListener('click', function () {
                    document.querySelectorAll('.payment-option-card').forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedMethod = this.dataset.method;
                    
                    confirmBtn.classList.remove('d-none');
                    confirmBtn.textContent = `Confirm ${selectedMethod} Payment`;
                });
            });

            // 5. Confirm Payment Logic
            confirmBtn.addEventListener('click', function () {
                if (!activeCard) return;

                activeCard.dataset.status = 'paid';
                const statusBadge = activeCard.querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.className = 'badge bg-success status-badge';
                    statusBadge.innerHTML = '<i class="bi bi-check-circle"></i> Paid';
                }

                const modalEl = document.getElementById('paymentModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();

                document.querySelectorAll('.payment-option-card').forEach(opt => opt.classList.remove('selected'));
                confirmBtn.classList.add('d-none');

                loadOrderDetails(activeCard);
            });

            // 6. Cancel Order Option
            document.getElementById('btnCancelOrder').addEventListener('click', function () {
                if (activeCard && confirm('Are you sure you want to cancel this order?')) {
                    activeCard.remove();
                    const remainingCards = document.querySelectorAll('.order-card');
                    if (remainingCards.length > 0) {
                        loadOrderDetails(remainingCards[0]);
                    } else {
                        document.getElementById('displayTableBody').innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">No active orders available.</td></tr>';
                    }
                }
            });
        });
    </script>
</body>
</html> 