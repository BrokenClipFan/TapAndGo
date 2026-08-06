<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Self-Service Kiosk</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        html,
        body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        @keyframes pulse-orange {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        .pulse-accent {
            animation: pulse-orange 2s infinite ease-in-out;
        }

        .kiosk-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .kiosk-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        .kiosk-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        .kiosk-btn-active:active {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }
    </style>
</head>

<body class="bg-slate-50 flex flex-col h-screen w-screen relative">
    @include('partials.splash-screen', [
        'title' => 'Tap&Go',
        'subtitle' => 'Order Terminal',
    ])
    <!-- SCREEN 1: WELCOME SCREEN -->
    <div id="screen-welcome"
        class="absolute inset-0 bg-gradient-to-br from-[#0f172a] via-[#1a4373] to-[#0f172a] z-50 flex flex-col justify-between p-8 transition-all duration-500">
        <div class="flex justify-between items-center w-full">
            <div class="flex items-center gap-3">
                <img src="{{ asset('Logo.png') }}" alt="Tap&Go Logo" class="h-12 object-contain">
            </div>
            <div
                class="bg-white/10 backdrop-blur-md border border-white/10 rounded-full px-4 py-1.5 text-xs text-slate-300 font-semibold">
                <i class="bi bi-globe me-1"></i> English
            </div>
        </div>

        <div class="text-center my-auto flex flex-col items-center">
            <div
                class="w-36 h-36 rounded-full bg-orange-500/10 border-2 border-orange-500/30 flex items-center justify-center pulse-accent mb-6">
                <div
                    class="w-28 h-28 rounded-full bg-[#1a4373] flex items-center justify-center shadow-lg shadow-orange-500/20 border-2 border-orange-500/40 p-2">
                    <img src="{{ asset('Logo.png') }}" alt="Tap&Go" class="w-full h-full object-contain">
                </div>
            </div>
            <h2 class="text-white text-4xl sm:text-5xl font-black mb-3 leading-tight tracking-tight">Order Food in a
                Flash!</h2>
            <p class="text-slate-300 text-sm sm:text-base max-w-md mx-auto mb-10">Tap below to select your ordering
                method and get started.</p>

            <div class="flex flex-col sm:flex-row gap-6 w-full max-w-xl justify-center">
                <button onclick="selectOrderType('Dine In')"
                    class="kiosk-btn-active bg-white text-slate-900 border-4 border-transparent hover:border-orange-500 rounded-3xl p-6 flex-1 flex flex-col items-center justify-center shadow-2xl transition-all duration-300">
                    <span
                        class="w-16 h-16 rounded-2xl bg-orange-100 text-orange-500 flex items-center justify-center mb-3 text-3xl">
                        <i class="bi bi-cup-hot-fill"></i>
                    </span>
                    <strong class="text-xl font-extrabold">Dine In</strong>
                    <span class="text-slate-400 text-xs mt-1">Eat inside our dining area</span>
                </button>
                <button onclick="selectOrderType('Take Out')"
                    class="kiosk-btn-active bg-white text-slate-900 border-4 border-transparent hover:border-orange-500 rounded-3xl p-6 flex-1 flex flex-col items-center justify-center shadow-2xl transition-all duration-300">
                    <span
                        class="w-16 h-16 rounded-2xl bg-blue-100 text-[#1a4373] flex items-center justify-center mb-3 text-3xl">
                        <i class="bi bi-bag-heart-fill"></i>
                    </span>
                    <strong class="text-xl font-extrabold">Take Out</strong>
                    <span class="text-slate-400 text-xs mt-1">Packed safely to go</span>
                </button>
            </div>
        </div>

        <div class="text-center w-full">
            <p class="text-slate-400 text-xs font-semibold">Touch a button to begin • Station ID: #K-01</p>
        </div>
    </div>

    <!-- SCREEN 2: MAIN MENU SCREEN -->
    <div class="flex-grow flex flex-col h-full w-full min-h-0 bg-slate-50">

        <!-- Header Ribbon -->
        <header class="bg-[#1a4373] text-white flex-shrink-0 px-6 py-3 flex justify-between items-center shadow-md">
            <div class="flex items-center gap-4">
                <button onclick="resetToWelcome()"
                    class="kiosk-btn-active bg-white/10 hover:bg-white/20 text-white rounded-xl p-2.5">
                    <i class="bi bi-arrow-left-square-fill text-xl"></i>
                </button>
                <img src="{{ asset('Logo.png') }}" alt="Tap&Go Logo" class="h-10 object-contain">
                <div class="border-l border-white/20 pl-4">
                    <h3 class="font-extrabold text-base tracking-wide flex items-center gap-1.5">
                        <span>Order Screen</span>
                        <span id="kiosk-order-type-badge"
                            class="bg-orange-500 text-[10px] uppercase font-black px-2 py-0.5 rounded-full">Dine
                            In</span>
                    </h3>
                    <p class="text-[11px] text-slate-300">Station #K-01 • Direct Terminal</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-right">
                    <p class="text-[10px] text-orange-400 font-bold uppercase tracking-wider">Estimated Wait</p>
                    <p class="text-xs font-extrabold text-white">3 - 5 Minutes</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-orange-500/10 border border-orange-500/30 flex items-center justify-center">
                    <i class="bi bi-clock-history text-orange-500"></i>
                </div>
            </div>
        </header>

        <!-- Main Body Panel -->
        <div class="flex-grow flex min-h-0 w-full">

            <!-- Category Sidebar -->
            <aside class="w-32 bg-slate-900 flex-shrink-0 flex flex-col gap-3 py-4 px-2 overflow-y-auto kiosk-scroll">
                @foreach ($categories as $index => $category)
                    <button onclick="filterCategory({{ $category->id }}, '{{ addslashes($category->name) }}')"
                        class="category-tab kiosk-btn-active flex flex-col items-center justify-center p-3 rounded-2xl transition-all duration-200 {{ $index === 0 ? 'bg-orange-500 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}"
                        id="cat-tab-{{ $category->id }}">

                        @if ($category->image_path)
                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}"
                                class="w-10 h-10 object-cover rounded-lg mb-1">
                        @else
                            <i class="bi bi-grid-fill text-2xl mb-1"></i>
                        @endif

                        <span
                            class="text-[10px] font-black uppercase text-center tracking-wide leading-tight">{{ $category->name }}</span>
                    </button>
                @endforeach
            </aside>

            <!-- Dynamic Product Grid -->
            <main class="flex-grow p-6 overflow-y-auto kiosk-scroll">
                <h4 id="category-title"
                    class="text-slate-900 font-extrabold text-lg mb-4 uppercase tracking-wider border-b pb-2 border-slate-200">
                    {{ $categories->first()->name ?? 'Products' }}
                </h4>

                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <!-- Populated dynamically via JS -->
                </div>
            </main>
        </div>

        <!-- Interactive Cart Footer Drawer -->
        <footer
            class="bg-white border-t border-slate-200 flex-shrink-0 px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4 z-40 shadow-inner">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-500">
                        <i class="bi bi-cart3 text-2xl"></i>
                    </div>
                    <span id="cart-badge-counter"
                        class="absolute -top-1.5 -right-1.5 bg-orange-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full border-2 border-white shadow hidden">0</span>
                </div>
                <div class="flex-grow">
                    <p class="text-xs text-slate-400 uppercase font-black tracking-wider">Your Basket</p>
                    <div id="cart-item-preview-text" class="text-sm font-extrabold text-slate-800">Your basket is empty
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">Grand Total</p>
                    <p id="cart-grand-total" class="text-2xl font-black text-[#1a4373]">₱0.00</p>
                </div>
                <button onclick="toggleBasketDrawer(true)" id="btn-proceed-checkout"
                    class="kiosk-btn-active bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-base px-8 py-4 rounded-2xl shadow-lg shadow-orange-500/20 flex items-center gap-2 opacity-50 cursor-not-allowed"
                    disabled>
                    <span>Review Order</span>
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
            </div>
        </footer>
    </div>

    <!-- BASKET DETAIL & REVIEW DRAWER OVERLAY -->
    <div id="drawer-basket" class="hidden absolute inset-0 bg-slate-900/60 z-40 backdrop-blur-sm flex justify-end">
        <div class="w-full max-w-md bg-white h-full shadow-2xl flex flex-col">
            <div class="bg-[#1a4373] text-white p-5 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="bi bi-bag-check-fill text-xl text-orange-400"></i>
                    <h5 class="font-extrabold text-lg">Review Your Order</h5>
                </div>
                <button onclick="toggleBasketDrawer(false)" class="text-white hover:text-orange-400 text-2xl">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            </div>

            <div id="drawer-cart-list" class="flex-grow overflow-y-auto p-5 space-y-3 kiosk-scroll"></div>

            <div class="p-5 border-t border-slate-100 bg-slate-50 space-y-4">
                <div class="flex justify-between items-center text-slate-600 text-sm">
                    <span>Order Subtotal</span>
                    <span id="drawer-subtotal" class="font-bold">₱0.00</span>
                </div>
                <div class="flex justify-between items-center text-slate-900 font-extrabold text-lg">
                    <span>Total Amount Due</span>
                    <span id="drawer-total" class="text-orange-500">₱0.00</span>
                </div>
                <button onclick="processFinalPayment()" id="btn-place-order"
                    class="kiosk-btn-active w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-xl shadow-lg flex items-center justify-center gap-2">
                    <i class="bi bi-qr-code-scan text-xl"></i>
                    <span>Place Order & Get Ticket</span>
                </button>
            </div>
        </div>
    </div>

    <!-- UNAVAILABLE ITEMS / ERROR MODAL -->
    <div id="modal-unavailable"
        class="hidden fixed inset-0 bg-slate-900/60 z-50 backdrop-blur-sm flex items-center justify-center p-4">
        <div
            class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border-t-8 border-red-500 transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <h3 id="modal-error-title" class="text-xl font-black text-slate-900 mb-1">Stock Limit Reached</h3>
                <p id="modal-error-message" class="text-xs text-slate-500 mb-4">Some items in your order are currently
                    unavailable or exceed available stock.</p>

                <div id="modal-item-list-container"
                    class="hidden mb-6 bg-red-50 border border-red-100 rounded-2xl p-4 text-left max-h-40 overflow-y-auto kiosk-scroll">
                    <span class="text-[10px] font-black uppercase text-red-500 tracking-wider block mb-2">Unavailable /
                        Over Limit:</span>
                    <ul id="modal-item-list" class="space-y-1 text-xs font-bold text-slate-700 list-disc list-inside">
                    </ul>
                </div>

                <button onclick="closeUnavailableModal()"
                    class="w-full bg-[#1a4373] hover:bg-blue-900 text-white font-black py-3.5 rounded-xl shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">
                    Understood
                </button>
            </div>
        </div>
    </div>

    <!-- SCRIPT STATE CONTROLLER -->
    <script>
        const productsData = @json($products);
        const categoriesData = @json($categories);

        let currentOrderType = "Dine In";
        let activeCategoryId = categoriesData.length > 0 ? categoriesData[0].id : null;
        let cart = [];

        function selectOrderType(type) {
            currentOrderType = type;
            document.getElementById('kiosk-order-type-badge').innerText = type;

            const welcomeScreen = document.getElementById('screen-welcome');
            welcomeScreen.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                welcomeScreen.classList.add('hidden');
            }, 500);

            if (activeCategoryId) {
                const firstCategory = categoriesData.find(c => c.id === activeCategoryId);
                filterCategory(activeCategoryId, firstCategory ? firstCategory.name : 'Products');
            }
        }

        function resetToWelcome() {
            const welcomeScreen = document.getElementById('screen-welcome');
            welcomeScreen.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
        }

        function showUnavailableModal(items = [], title = "Stock Limit Reached", message = null) {
            const modal = document.getElementById('modal-unavailable');
            const titleEl = document.getElementById('modal-error-title');
            const msgEl = document.getElementById('modal-error-message');
            const listContainer = document.getElementById('modal-item-list-container');
            const listEl = document.getElementById('modal-item-list');

            titleEl.innerText = title;
            msgEl.innerText = message ||
                "Some items in your basket are currently unavailable or exceed available stock limits.";

            listEl.innerHTML = '';
            if (items && items.length > 0) {
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.innerText = item;
                    listEl.appendChild(li);
                });
                listContainer.classList.remove('hidden');
            } else {
                listContainer.classList.add('hidden');
            }

            modal.classList.remove('hidden');
        }

        function closeUnavailableModal() {
            document.getElementById('modal-unavailable').classList.add('hidden');
        }

        function filterCategory(categoryId, categoryName) {
            activeCategoryId = categoryId;

            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.classList.remove('bg-orange-500', 'text-white');
                tab.classList.add('text-slate-400', 'hover:bg-slate-800/50');
            });

            const activeTab = document.getElementById(`cat-tab-${categoryId}`);
            if (activeTab) {
                activeTab.classList.remove('text-slate-400', 'hover:bg-slate-800/50');
                activeTab.classList.add('bg-orange-500', 'text-white');
            }

            document.getElementById('category-title').innerText = categoryName;

            const productGrid = document.getElementById('product-grid');
            productGrid.innerHTML = '';

            const filteredProducts = productsData.filter(prod => prod.category_id == categoryId);

            if (filteredProducts.length === 0) {
                productGrid.innerHTML = `
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <i class="bi bi-box-seam text-4xl block mb-2"></i>
                        <p class="text-sm font-semibold">No products available in this category.</p>
                    </div>
                `;
                return;
            }

            filteredProducts.forEach(prod => {
                const card = document.createElement('div');
                card.className =
                    "relative h-72 rounded-3xl overflow-hidden shadow-lg border border-slate-800/20 bg-slate-900 flex flex-col justify-between p-4 transition-transform duration-200 active:scale-[0.98]";

                const imageSrc = prod.image_path ? `/storage/${prod.image_path}` : null;
                const isOutOfStock = prod.stock <= 0;
                const isStatusUnavailable = prod.status && prod.status.toLowerCase() !== 'available';
                const isDisabled = isOutOfStock || isStatusUnavailable;

                const cartItem = cart.find(item => item.id === prod.id);
                const inCartQty = cartItem ? cartItem.qty : 0;

                let buttonLabel = 'Add to Tray';
                if (isStatusUnavailable) {
                    buttonLabel = 'Unavailable';
                } else if (isOutOfStock) {
                    buttonLabel = 'Out of Stock';
                }

                card.innerHTML = `
                    <!-- Background Image -->
                    <div class="absolute inset-0 z-0 bg-slate-800">
                        ${imageSrc 
                            ? `<img src="${imageSrc}" class="w-full h-full object-cover ${isDisabled ? 'grayscale opacity-50' : ''}" alt="${prod.name}">` 
                            : `<div class="w-full h-full flex flex-col items-center justify-center text-slate-600 bg-slate-900"><i class="bi bi-cup-hot-fill text-6xl"></i></div>`
                        }
                        <!-- Bottom Gradient Overlay for text readability -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-black/10"></div>
                    </div>

                    <!-- Top Header: Stock Tag -->
                    <div class="relative z-10 flex justify-between items-start">
                        <span class="bg-amber-400 text-slate-950 font-black text-xs px-3 py-1 rounded-full shadow-md tracking-tight flex items-center gap-1">
                            ${prod.stock} left
                        </span>
                        
                        ${isDisabled ? `
                                                <span class="bg-red-500 border border-red-400 text-white font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-lg">
                                                    ${isStatusUnavailable ? 'Unavailable' : 'Sold Out'}
                                                </span>
                                            ` : ''}
                    </div>

                    <!-- Bottom Content Area -->
                    <div class="relative z-10 space-y-2 mt-auto">
                        <div>
                            <h5 class="text-white font-extrabold text-xl leading-tight drop-shadow-md line-clamp-1">${prod.name}</h5>
                            <p class="text-amber-400 font-black text-lg drop-shadow-sm">₱${parseFloat(prod.price).toFixed(2)}</p>
                        </div>

                        <div class="pt-1">
                            ${inCartQty > 0 && !isDisabled ? `
                                                    <!-- Quantity Controller Bar when item added -->
                                                    <div class="flex items-center justify-between bg-white text-slate-900 rounded-2xl p-1 shadow-xl">
                                                        <button onclick="updateCartQty(${prod.id}, -1)" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center font-black text-lg text-slate-700 active:scale-95 transition-all">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <span class="font-black text-base text-slate-900 px-2">${inCartQty} in tray</span>
                                                        <button onclick="addToCart(${prod.id}, '${prod.name.replace(/'/g, "\\'")}', ${prod.price})" class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center font-black text-lg active:scale-95 transition-all shadow-md shadow-orange-500/30">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                ` : `
                                                    <!-- Default Add Button -->
                                                    <button onclick="addToCart(${prod.id}, '${prod.name.replace(/'/g, "\\'")}', ${prod.price})" 
                                                        class="kiosk-btn-active w-full ${isDisabled ? 'bg-slate-700/80 text-slate-400 cursor-not-allowed' : 'bg-orange-500 hover:bg-orange-600 text-white shadow-lg shadow-orange-500/30'} font-extrabold py-3.5 px-4 rounded-2xl text-sm flex items-center justify-center gap-2 transition-all"
                                                        ${isDisabled ? 'disabled' : ''}>
                                                        <i class="bi ${isDisabled ? 'bi-slash-circle-fill' : 'bi-plus-circle-fill text-lg'}"></i>
                                                        <span>${buttonLabel}</span>
                                                    </button>
                                                `}
                        </div>
                    </div>
                `;
                productGrid.appendChild(card);
            });
        }

        function addToCart(id, name, price) {
            const product = productsData.find(p => p.id === id);
            const stockAvailable = product ? product.stock : 0;

            const existing = cart.find(item => item.id === id);
            if (existing) {
                if (existing.qty >= stockAvailable) {
                    showUnavailableModal([`${name} (Available: ${stockAvailable})`], "Stock Limit Reached",
                        "You cannot add more than the available stock.");
                    return;
                }
                existing.qty++;
            } else {
                if (stockAvailable <= 0) {
                    showUnavailableModal([name], "Out of Stock", "This item is currently out of stock.");
                    return;
                }
                cart.push({
                    id,
                    name,
                    price: parseFloat(price),
                    qty: 1
                });
            }
            updateCartUI();
            if (activeCategoryId) {
                const currentCat = categoriesData.find(c => c.id === activeCategoryId);
                filterCategory(activeCategoryId, currentCat ? currentCat.name : 'Products');
            }
        }

        function updateCartQty(id, delta) {
            const item = cart.find(item => item.id === id);
            const product = productsData.find(p => p.id === id);
            const stockAvailable = product ? product.stock : 0;

            if (item) {
                if (delta > 0 && item.qty >= stockAvailable) {
                    showUnavailableModal([`${item.name} (Max stock: ${stockAvailable})`], "Stock Limit Reached",
                        "You have reached the maximum available quantity for this item.");
                    return;
                }
                item.qty += delta;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                }
            }
            updateCartUI();
            if (activeCategoryId) {
                const currentCat = categoriesData.find(c => c.id === activeCategoryId);
                filterCategory(activeCategoryId, currentCat ? currentCat.name : 'Products');
            }
        }

        function updateCartUI() {
            const countBadge = document.getElementById('cart-badge-counter');
            const totalText = document.getElementById('cart-grand-total');
            const previewText = document.getElementById('cart-item-preview-text');
            const proceedBtn = document.getElementById('btn-proceed-checkout');
            const placeOrderBtn = document.getElementById('btn-place-order');

            let totalSum = 0;
            let totalQty = 0;

            cart.forEach(i => {
                totalSum += (i.price * i.qty);
                totalQty += i.qty;
            });

            countBadge.innerText = totalQty;
            totalText.innerText = `₱${totalSum.toFixed(2)}`;

            if (totalQty > 0) {
                countBadge.classList.remove('hidden');
                previewText.innerHTML =
                    `<span class="text-orange-500 font-extrabold cursor-pointer hover:underline" onclick="toggleBasketDrawer(true)">View Tray (${totalQty} Items loaded)</span>`;
                proceedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                proceedBtn.disabled = false;
                if (placeOrderBtn) placeOrderBtn.disabled = false;
            } else {
                countBadge.classList.add('hidden');
                previewText.innerText = "Your basket is empty";
                proceedBtn.classList.add('opacity-50', 'cursor-not-allowed');
                proceedBtn.disabled = true;
                if (placeOrderBtn) placeOrderBtn.disabled = true;
            }

            const drawerList = document.getElementById('drawer-cart-list');
            const drawerSub = document.getElementById('drawer-subtotal');
            const drawerTot = document.getElementById('drawer-total');

            drawerList.innerHTML = '';

            if (cart.length === 0) {
                drawerList.innerHTML = `
                    <div class="text-center py-10 text-slate-400">
                        <i class="bi bi-cart-x text-5xl block mb-2"></i>
                        <p class="text-xs">No food items added to tray yet.</p>
                    </div>
                `;
            } else {
                cart.forEach(item => {
                    const row = document.createElement('div');
                    row.className =
                        "flex justify-between items-center p-3 bg-slate-50 border border-slate-100 rounded-2xl";
                    row.innerHTML = `
                        <div class="max-w-[200px]">
                            <h6 class="font-bold text-slate-900 text-xs">${item.name}</h6>
                            <span class="text-[#1a4373] text-xs font-black">₱${(item.price * item.qty).toFixed(2)}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="updateCartQty(${item.id}, -1)" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600">-</button>
                            <span class="text-xs font-black px-1">${item.qty}</span>
                            <button onclick="updateCartQty(${item.id}, 1)" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600">+</button>
                        </div>
                    `;
                    drawerList.appendChild(row);
                });
            }

            drawerSub.innerText = `₱${totalSum.toFixed(2)}`;
            drawerTot.innerText = `₱${totalSum.toFixed(2)}`;
        }

        function toggleBasketDrawer(show) {
            const drawer = document.getElementById('drawer-basket');
            if (show) {
                drawer.classList.remove('hidden');
            } else {
                drawer.classList.add('hidden');
            }
        }

        async function processFinalPayment() {
            const order = {
                order_type: currentOrderType,
                items: cart
            };

            const placeOrderBtn = document.getElementById('btn-place-order');
            placeOrderBtn.disabled = true;

            try {
                const response = await fetch('/order/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(order)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.href = data.ticket_url;
                } else {
                    placeOrderBtn.disabled = false;

                    if (data.unavailableItems && data.unavailableItems.length > 0) {
                        showUnavailableModal(data.unavailableItems, "Order Submission Failed",
                            "The following items exceed available stock:");
                    } else if (data.message) {
                        showUnavailableModal([], "Order Error", data.message);
                    } else {
                        showUnavailableModal([], "Order Error", "Validation failed. Please check your order items.");
                    }
                }
            } catch (error) {
                placeOrderBtn.disabled = false;
                console.error('Network execution error:', error);
                showUnavailableModal([], "Connection Error", "A network error occurred. Please try submitting again.");
            }
        }
    </script>
</body>

</html>
