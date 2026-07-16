<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Self-Service Kiosk</title>

    <!-- Tailwind CSS for modern design -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        :root {
            --theme-primary: #1a4373;        /* TapAndGo Core Deep Blue */
            --theme-accent: #f97316;         /* TapAndGo Vibrant Orange */
            --theme-dark: #0f172a;           /* Clean Off-Black */
            --theme-success: #10b981;        /* Clean Green */
        }

        body {
            font-family: 'Inter', sans-serif;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Strict Full Screen Container Controls */
        html, body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* Jollibee Kiosk standard pulsing scroll indicators */
        @keyframes pulse-orange {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        .pulse-accent {
            animation: pulse-orange 2s infinite ease-in-out;
        }

        /* Custom Scrollbar for visual touch lists */
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

        /* Touch interaction tap indicators */
        .kiosk-btn-active:active {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }
    </style>
</head>
<body class="bg-slate-50 flex flex-col h-screen w-screen relative">

    <!-- SCREEN 1: WELCOME SCREEN (DINE IN / TAKE OUT SELECTOR) -->
    <div id="screen-welcome" class="absolute inset-0 bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#1a4373] z-50 flex flex-col justify-between p-8 transition-all duration-500">
        <!-- Top branding banner -->
        <div class="flex justify-between items-center w-full">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/30">
                    <i class="bi bi-lightning-fill text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-white text-xl font-extrabold tracking-wider">TapAndGo</h1>
                    <p class="text-orange-400 text-xs font-bold uppercase tracking-widest">Self-Service Express</p>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-full px-4 py-1.5 text-xs text-slate-300 font-semibold">
                <i class="bi bi-globe me-1"></i> English
            </div>
        </div>

        <!-- Center visual trigger block -->
        <div class="text-center my-auto flex flex-col items-center">
            <!-- Animated Touch Ring -->
            <div class="w-32 h-32 rounded-full bg-orange-500/10 border-2 border-orange-500/30 flex items-center justify-center pulse-accent mb-6">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center shadow-lg shadow-orange-500/40">
                    <i class="bi bi-hand-index-thumb text-white text-4xl"></i>
                </div>
            </div>
            <h2 class="text-white text-4xl sm:text-5xl font-black mb-3 leading-tight tracking-tight">Gourmet Meals,<br>Delivered in a Flash!</h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-md mx-auto mb-10">Tap below to order your favorite burgers, crispy cajun fries, and cold milkshakes.</p>

            <!-- Big selector touch blocks -->
            <div class="flex flex-col sm:flex-row gap-6 w-full max-w-xl justify-center">
                <button onclick="selectOrderType('Dine In')" class="kiosk-btn-active bg-white text-slate-900 border-4 border-transparent hover:border-orange-500 rounded-3xl p-6 flex-1 flex flex-col items-center justify-center shadow-2xl transition-all duration-300">
                    <span class="w-16 h-16 rounded-2xl bg-orange-100 text-orange-500 flex items-center justify-center mb-3 text-3xl">
                        <i class="bi bi-cup-hot-fill"></i>
                    </span>
                    <strong class="text-xl font-extrabold">Dine In</strong>
                    <span class="text-slate-400 text-xs mt-1">Eat inside our dining area</span>
                </button>
                <button onclick="selectOrderType('Take Out')" class="kiosk-btn-active bg-white text-slate-900 border-4 border-transparent hover:border-orange-500 rounded-3xl p-6 flex-1 flex flex-col items-center justify-center shadow-2xl transition-all duration-300">
                    <span class="w-16 h-16 rounded-2xl bg-blue-100 text-[#1a4373] flex items-center justify-center mb-3 text-3xl">
                        <i class="bi bi-bag-heart-fill"></i>
                    </span>
                    <strong class="text-xl font-extrabold">Take Out</strong>
                    <span class="text-slate-400 text-xs mt-1">Packed safely to go</span>
                </button>
            </div>
        </div>

        <!-- Touch-to-start safe zone notice -->
        <div class="text-center w-full">
            <p class="text-slate-500 text-xs font-semibold">Touch a button to begin • Station ID: #K-01</p>
        </div>
    </div>

    <!-- SCREEN 2: MAIN MENU SCREEN -->
    <div class="flex-grow flex flex-col h-full w-full min-h-0 bg-slate-50">
        
        <!-- Header Ribbon (Touch optimized checkout status display) -->
        <header class="bg-[#1a4373] text-white flex-shrink-0 px-6 py-4 flex justify-between items-center shadow-md">
            <div class="flex items-center gap-3">
                <button onclick="resetToWelcome()" class="kiosk-btn-active bg-white/10 hover:bg-white/20 text-white rounded-xl p-2.5">
                    <i class="bi bi-arrow-left-square-fill text-xl"></i>
                </button>
                <div>
                    <h3 class="font-extrabold text-base tracking-wide flex items-center gap-1.5">
                        <span>TapAndGo Order Screen</span>
                        <span id="kiosk-order-type-badge" class="bg-orange-500 text-[10px] uppercase font-black px-2 py-0.5 rounded-full">Dine In</span>
                    </h3>
                    <p class="text-[11px] text-slate-300">Station #K-01 • Direct Terminal</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-right">
                    <p class="text-[10px] text-orange-400 font-bold uppercase tracking-wider">Estimated Wait</p>
                    <p class="text-xs font-extrabold text-white">3 - 5 Minutes</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-orange-500/10 border border-orange-500/30 flex items-center justify-center">
                    <i class="bi bi-clock-history text-orange-500"></i>
                </div>
            </div>
        </header>

        <!-- Main Body split layout (Touch menu panels) -->
        <div class="flex-grow flex min-h-0 w-full">
            
            <!-- Category Sidebar -->
            <aside class="w-32 bg-slate-900 flex-shrink-0 flex flex-col gap-3 py-4 px-2 overflow-y-auto">
                <button onclick="filterCategory('burgers')" class="kiosk-btn-active category-tab active bg-orange-500 text-white flex flex-col items-center justify-center p-3 rounded-2xl transition-all duration-200" id="cat-burgers">
                    <i class="bi bi-basket-fill text-2xl mb-1"></i>
                    <span class="text-[10px] font-black uppercase text-center tracking-wide">Burgers</span>
                </button>
                <button onclick="filterCategory('sides')" class="kiosk-btn-active category-tab text-slate-400 hover:bg-slate-800/50 flex flex-col items-center justify-center p-3 rounded-2xl transition-all duration-200" id="cat-sides">
                    <i class="bi bi-fire text-2xl mb-1"></i>
                    <span class="text-[10px] font-black uppercase text-center tracking-wide">Sides</span>
                </button>
                <button onclick="filterCategory('drinks')" class="kiosk-btn-active category-tab text-slate-400 hover:bg-slate-800/50 flex flex-col items-center justify-center p-3 rounded-2xl transition-all duration-200" id="cat-drinks">
                    <i class="bi bi-cup-straw text-2xl mb-1"></i>
                    <span class="text-[10px] font-black uppercase text-center tracking-wide">Drinks</span>
                </button>
                <button onclick="filterCategory('desserts')" class="kiosk-btn-active category-tab text-slate-400 hover:bg-slate-800/50 flex flex-col items-center justify-center p-3 rounded-2xl transition-all duration-200" id="cat-desserts">
                    <i class="bi bi-droplet-fill text-2xl mb-1"></i>
                    <span class="text-[10px] font-black uppercase text-center tracking-wide">Sweets</span>
                </button>
            </aside>

            <!-- Product Grid Center Panel -->
            <main class="flex-grow p-6 overflow-y-auto kiosk-scroll">
                <h4 id="category-title" class="text-slate-900 font-extrabold text-lg mb-4 uppercase tracking-wider border-b pb-2 border-slate-200">Gourmet Burgers</h4>
                
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Dynamic product card items populated below -->
                </div>
            </main>
        </div>

        <!-- Interactive Cart Footer Drawer -->
        <footer class="bg-white border-t border-slate-200 flex-shrink-0 px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4 z-40 shadow-inner">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-500">
                        <i class="bi bi-cart3 text-2xl"></i>
                    </div>
                    <span id="cart-badge-counter" class="absolute -top-1.5 -right-1.5 bg-orange-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full border-2 border-white shadow">0</span>
                </div>
                <div class="flex-grow">
                    <p class="text-xs text-slate-400 uppercase font-black tracking-wider">Your Basket</p>
                    <div id="cart-item-preview-text" class="text-sm font-extrabold text-slate-800">Your basket is empty</div>
                </div>
            </div>

            <!-- Active totals and proceed triggers -->
            <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">Grand Total</p>
                    <p id="cart-grand-total" class="text-2xl font-black text-[#1a4373]">$0.00</p>
                </div>
                <button onclick="openPaymentSelector()" id="btn-proceed-checkout" class="kiosk-btn-active bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-base px-8 py-4 rounded-2xl shadow-lg shadow-orange-500/20 flex items-center gap-2 opacity-50 cursor-not-allowed" disabled>
                    <span>Proceed to Checkout</span>
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
            </div>
        </footer>
    </div>

    <!-- RIGHT DRAWER PANEL: BASKET DETAIL DRAWER OVERLAY -->
    <div id="drawer-basket" class="hidden absolute inset-0 bg-slate-900/60 z-40 backdrop-blur-sm flex justify-end">
        <div class="w-full max-w-md bg-white h-full shadow-2xl flex flex-col">
            <div class="bg-[#1a4373] text-white p-5 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="bi bi-bag-check-fill text-xl text-orange-400"></i>
                    <h5 class="font-extrabold text-lg">My Tray Summary</h5>
                </div>
                <button onclick="toggleBasketDrawer(false)" class="text-white hover:text-orange-400 text-2xl">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            </div>
            
            <!-- Cart Items listing body -->
            <div id="drawer-cart-list" class="flex-grow overflow-y-auto p-5 space-y-3 kiosk-scroll">
                <!-- Items built here dynamic -->
            </div>

            <!-- Drawer Bottom calculations and pay buttons -->
            <div class="p-5 border-t border-slate-100 bg-slate-50 space-y-4">
                <div class="flex justify-between items-center text-slate-600 text-sm">
                    <span>Order Subtotal</span>
                    <span id="drawer-subtotal" class="font-bold">$0.00</span>
                </div>
                <div class="flex justify-between items-center text-slate-600 text-sm pb-3 border-b">
                    <span>Local Sales Tax (Included)</span>
                    <span>10%</span>
                </div>
                <div class="flex justify-between items-center text-slate-900 font-extrabold text-lg">
                    <span>Total Price</span>
                    <span id="drawer-total" class="text-orange-500">$0.00</span>
                </div>
                <button onclick="openPaymentSelector()" class="kiosk-btn-active w-full bg-[#1a4373] hover:bg-blue-900 text-white font-black py-4 rounded-xl shadow-lg flex items-center justify-center gap-2">
                    <i class="bi bi-credit-card-2-front-fill"></i>
                    <span>Select Payment Option</span>
                </button>
            </div>
        </div>
    </div>

    <!-- SCREEN 3: PAYMENT TYPE SELECTOR MODAL -->
    <div id="modal-payment" class="hidden absolute inset-0 bg-slate-900/70 z-50 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden animate-scale-up">
            <div class="bg-[#1a4373] text-white p-6 text-center">
                <h4 class="font-extrabold text-xl">How would you like to pay?</h4>
                <p class="text-slate-300 text-xs mt-1">Please select an option below to authorize payment</p>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <button onclick="processFinalPayment('Credit/Debit Card')" class="kiosk-btn-active bg-slate-50 hover:bg-slate-100 border-2 border-slate-200 hover:border-orange-500 p-5 rounded-2xl flex flex-col items-center justify-center text-center transition-all">
                    <span class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl mb-3">
                        <i class="bi bi-credit-card-fill"></i>
                    </span>
                    <strong class="text-slate-800 font-extrabold text-base">Credit/Debit Card</strong>
                    <span class="text-slate-400 text-xs mt-0.5">Pay with Visa/Mastercard</span>
                </button>
                
                <button onclick="processFinalPayment('Mobile E-Wallet')" class="kiosk-btn-active bg-slate-50 hover:bg-slate-100 border-2 border-slate-200 hover:border-orange-500 p-5 rounded-2xl flex flex-col items-center justify-center text-center transition-all">
                    <span class="w-14 h-14 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center text-2xl mb-3">
                        <i class="bi bi-phone-vibrate-fill"></i>
                    </span>
                    <strong class="text-slate-800 font-extrabold text-base">E-Wallet Pass</strong>
                    <span class="text-slate-400 text-xs mt-0.5">Scan GCash or PayMaya QR</span>
                </button>

                <button onclick="processFinalPayment('Pay at Counter')" class="kiosk-btn-active bg-slate-50 hover:bg-slate-100 border-2 border-slate-200 hover:border-orange-500 p-5 rounded-2xl flex flex-col items-center justify-center text-center transition-all sm:col-span-2">
                    <span class="w-14 h-14 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-2xl mb-3">
                        <i class="bi bi-cash-stack"></i>
                    </span>
                    <strong class="text-slate-800 font-extrabold text-base">Pay Cash at Counter</strong>
                    <span class="text-slate-400 text-xs mt-0.5">Receive scannable order code & settle payment with cashier</span>
                </button>
            </div>

            <!-- Cancel modal button -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button onclick="closePaymentSelector()" class="kiosk-btn-active bg-slate-300 hover:bg-slate-400 text-slate-700 font-bold px-6 py-2.5 rounded-xl">
                    Back to Menu
                </button>
            </div>
        </div>
    </div>

    <!-- SCREEN 4: ORDER SUCCESS SCREEN -->
    <div id="screen-success" class="hidden absolute inset-0 bg-[#0f172a] z-50 flex flex-col justify-between p-8 overflow-y-auto">
        <div class="my-auto max-w-md mx-auto w-full bg-white rounded-3xl shadow-2xl p-6 text-center border-t-8 border-orange-500 relative">
            
            <span class="w-16 h-16 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow">
                <i class="bi bi-patch-check-fill animate-bounce"></i>
            </span>
            
            <h2 class="text-[#1a4373] text-2xl font-black">Thank You! Order Confirmed</h2>
            <p class="text-slate-400 text-xs mt-1">Your meal is currently being fresh-cooked in our kitchen</p>

            <!-- Scannable Ticket pass rendering (Perfect POS alignment!) -->
            <div class="my-6 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 p-5 space-y-4 relative">
                <div>
                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Order Ticket</span>
                    <h3 class="text-2xl font-extrabold text-[#1a4373]" id="success-order-id">#TG-94820</h3>
                </div>

                <!-- Simulated scannable QR matrix block -->
                <div class="w-32 h-32 mx-auto bg-white p-3 rounded-xl border border-slate-100 shadow flex items-center justify-center">
                    <svg width="100" height="100" viewBox="0 0 100 100" class="w-full h-full">
                        <rect x="5" y="5" width="22" height="22" fill="#1a4373" rx="2" />
                        <rect x="9" y="9" width="14" height="14" fill="white" />
                        <rect x="12" y="12" width="8" height="8" fill="#1a4373" />
                        
                        <rect x="73" y="5" width="22" height="22" fill="#1a4373" rx="2" />
                        <rect x="77" y="9" width="14" height="14" fill="white" />
                        <rect x="80" y="12" width="8" height="8" fill="#1a4373" />
                        
                        <rect x="5" y="73" width="22" height="22" fill="#1a4373" rx="2" />
                        <rect x="9" y="77" width="14" height="14" fill="white" />
                        <rect x="12" y="80" width="8" height="8" fill="#1a4373" />

                        <rect x="36" y="8" width="8" height="8" fill="#f97316" rx="1" />
                        <rect x="48" y="5" width="14" height="6" fill="#1a4373" rx="1" />
                        <rect x="36" y="20" width="12" height="10" fill="#1a4373" rx="1" />
                        
                        <rect x="8" y="36" width="16" height="8" fill="#1a4373" rx="1" />
                        <rect x="20" y="48" width="10" height="10" fill="#1a4373" rx="1" />
                        <rect x="36" y="36" width="14" height="14" fill="#f97316" rx="2" />

                        <rect x="56" y="36" width="12" height="8" fill="#1a4373" rx="1" />
                        <rect x="74" y="36" width="8" height="16" fill="#1a4373" rx="1" />
                        <rect x="36" y="56" width="8" height="18" fill="#1a4373" rx="1" />
                        <rect x="48" y="56" width="14" height="8" fill="#f97316" rx="1" />

                        <rect x="36" y="80" width="18" height="8" fill="#f97316" rx="1" />
                        <rect x="58" y="72" width="8" height="20" fill="#1a4373" rx="1" />
                        <rect x="70" y="78" width="12" height="12" fill="#f97316" rx="1" />
                    </svg>
                </div>

                <div>
                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block">Pickup Code</span>
                    <strong class="text-xl font-mono font-extrabold tracking-widest text-orange-500 bg-orange-100/50 px-4 py-1.5 rounded-lg border border-orange-200 inline-block mt-1" id="success-pass-code">837-D0C</strong>
                </div>
            </div>

            <!-- On-Screen Instructions -->
            <div class="text-left bg-slate-50 border border-slate-100 rounded-2xl p-4 space-y-2.5 mb-6 text-xs text-slate-600">
                <p class="font-extrabold text-[#1a4373] flex items-center gap-1">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Next Steps for Pick up:</span>
                </p>
                <div class="flex gap-2">
                    <strong class="text-orange-500">1.</strong>
                    <span>Go to any available **TapAndGo Cashier** station.</span>
                </div>
                <div class="flex gap-2">
                    <strong class="text-orange-500">2.</strong>
                    <span>Present this confirmation code screen or printed ticket.</span>
                </div>
                <div class="flex gap-2">
                    <strong class="text-orange-500">3.</strong>
                    <span>Collect your hot order and enjoy!</span>
                </div>
            </div>

            <button onclick="resetToWelcome()" class="kiosk-btn-active w-full bg-[#1a4373] hover:bg-blue-900 text-white font-black py-4 rounded-xl shadow-lg transition-all">
                Close & Complete Order
            </button>
        </div>
        <div class="text-center">
            <p class="text-slate-500 text-xs font-semibold">Your ticket receipt is printing below...</p>
        </div>
    </div>

    <!-- SCRIPT STATE CONTROLLER (KIOSK ENGINE) -->
    <script>
        // Preset Kiosk Menu Catalog database
        const menuDatabase = {
            burgers: [
                { id: "burg-1", name: "Classic Cheeseburger Deluxe", price: 12.50, category: "burgers", desc: "Premium beef patty, real cheddar cheese, house sauce", icon: "bi-basket-fill" },
                { id: "burg-2", name: "Jolly-style Double stacker", price: 15.50, category: "burgers", desc: "Double patty, sweet honey mustard, pickles, toast buns", icon: "bi-layers-half" },
                { id: "burg-3", name: "Spicy Volcano Patty Sandwich", price: 13.00, category: "burgers", desc: "Spiced crust layer, chili slices, fresh lettuce salad", icon: "bi-fire" }
            ],
            sides: [
                { id: "side-1", name: "Crispy Cajun Fries (Large)", price: 4.50, category: "sides", desc: "Golden spiced fries served with garlic aioli", icon: "bi-box-seam" },
                { id: "side-2", name: "Gourmet Crispy Onion Rings", price: 5.00, category: "sides", desc: "Golden-battered colossal sweet onion rings", icon: "bi-circle" },
                { id: "side-3", name: "Cheesy Potato Wedges Pack", price: 5.50, category: "sides", desc: "Loaded with cheddar sauce & parsley flakes", icon: "bi-grid-fill" }
            ],
            drinks: [
                { id: "drink-1", name: "House Brewed Iced Tea", price: 3.00, category: "drinks", desc: "Freshly squeezed lemon slices & golden sweet brew", icon: "bi-cup-straw" },
                { id: "drink-2", name: "Zero Sugar Soda Can", price: 2.50, category: "drinks", desc: "Refreshing zero-sugar carbonated cooler", icon: "bi-droplet" },
                { id: "drink-3", name: "Fresh Squeezed Citrus Lemonade", price: 3.50, category: "drinks", desc: "Ice-cold real hand pressed lemonade", icon: "bi-cup-hot" }
            ],
            desserts: [
                { id: "dess-1", name: "Premium Vanilla Shake", price: 5.00, category: "desserts", desc: "Vanilla bean whipped cream with cherry topping", icon: "bi-droplet-fill" },
                { id: "dess-2", name: "Warm Chocolate Fudge Sundae", price: 6.00, category: "desserts", desc: "Rich chocolate swirl combined with milk fudge", icon: "bi-activity" },
                { id: "dess-3", name: "Sizzling Apple Pie Pocket", price: 4.00, category: "desserts", desc: "Golden cinnamon flaky crust loaded with baked apple", icon: "bi-box" }
            ]
        };

        // Kiosk Runtime State Store
        let currentOrderType = "Dine In";
        let activeCategory = "burgers";
        let cart = [];

        // Selecting Dining preference
        function selectOrderType(type) {
            currentOrderType = type;
            document.getElementById('kiosk-order-type-badge').innerText = type;
            
            // Slide away welcome layout screen
            const welcomeScreen = document.getElementById('screen-welcome');
            welcomeScreen.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                welcomeScreen.classList.add('hidden');
            }, 500);

            // Populate catalog
            filterCategory('burgers');
        }

        // Return order session back to welcome frame
        function resetToWelcome() {
            cart = [];
            updateCartUI();
            
            const welcomeScreen = document.getElementById('screen-welcome');
            welcomeScreen.classList.remove('hidden');
            setTimeout(() => {
                welcomeScreen.classList.remove('opacity-0', 'pointer-events-none');
            }, 50);

            // Hide other overlay frames
            document.getElementById('screen-success').classList.add('hidden');
            closePaymentSelector();
            toggleBasketDrawer(false);
        }

        // Filters food items displayed by category
        function filterCategory(catName) {
            activeCategory = catName;
            
            // Highlight tabs
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.classList.remove('bg-orange-500', 'text-white');
                tab.classList.add('text-slate-400', 'hover:bg-slate-800/50');
            });
            
            const activeTab = document.getElementById(`cat-${catName}`);
            if (activeTab) {
                activeTab.classList.remove('text-slate-400', 'hover:bg-slate-800/50');
                activeTab.classList.add('bg-orange-500', 'text-white');
            }

            // Update title header
            const titleMap = {
                burgers: "Gourmet Burgers",
                sides: "Hot Sides & Appetizers",
                drinks: "Refreshing Drinks",
                desserts: "Ice Creams & Sweets"
            };
            document.getElementById('category-title').innerText = titleMap[catName];

            // Render matching items list
            const productGrid = document.getElementById('product-grid');
            productGrid.innerHTML = '';

            const list = menuDatabase[catName] || [];
            list.forEach(prod => {
                const card = document.createElement('div');
                card.className = "bg-white border border-slate-200 rounded-3xl p-4 flex flex-col justify-between shadow-sm hover:shadow-md hover:border-orange-200 transition-all";
                card.innerHTML = `
                    <div>
                        <div class="w-full h-32 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mb-3.5">
                            <i class="bi ${prod.icon} text-5xl text-[#1a4373]"></i>
                        </div>
                        <h5 class="font-extrabold text-slate-900 text-sm mb-1 line-clamp-1">${prod.name}</h5>
                        <p class="text-slate-400 text-xs mb-3 line-clamp-2">${prod.desc}</p>
                    </div>
                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-slate-100">
                        <span class="text-[#1a4373] text-lg font-black">$${prod.price.toFixed(2)}</span>
                        <button onclick="addToCart('${prod.id}', '${prod.name}', ${prod.price})" class="kiosk-btn-active bg-orange-500 hover:bg-orange-600 text-white rounded-xl px-4 py-2 text-xs font-black uppercase tracking-wide flex items-center gap-1 shadow-md shadow-orange-500/10">
                            <i class="bi bi-plus-circle"></i>
                            <span>Add</span>
                        </button>
                    </div>
                `;
                productGrid.appendChild(card);
            });
        }

        // Inserts item to virtual basket
        function addToCart(id, name, price) {
            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            updateCartUI();
        }

        // Adjust quantities inside cart
        function updateCartQty(id, delta) {
            const item = cart.find(item => item.id === id);
            if (item) {
                item.qty += delta;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                }
            }
            updateCartUI();
        }

        // Redraws the checkout bar totals and items
        function updateCartUI() {
            const countBadge = document.getElementById('cart-badge-counter');
            const totalText = document.getElementById('cart-grand-total');
            const previewText = document.getElementById('cart-item-preview-text');
            const proceedBtn = document.getElementById('btn-proceed-checkout');

            let totalSum = 0;
            let totalQty = 0;

            cart.forEach(i => {
                totalSum += (i.price * i.qty);
                totalQty += i.qty;
            });

            // Update badge
            countBadge.innerText = totalQty;
            totalText.innerText = `$${totalSum.toFixed(2)}`;

            if (totalQty > 0) {
                countBadge.classList.remove('hidden');
                previewText.innerHTML = `<span class="text-orange-500 font-extrabold cursor-pointer hover:underline" onclick="toggleBasketDrawer(true)">View Tray (${totalQty} Items loaded)</span>`;
                
                proceedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                proceedBtn.disabled = false;
            } else {
                countBadge.classList.add('hidden');
                previewText.innerText = "Your basket is empty";
                
                proceedBtn.classList.add('opacity-50', 'cursor-not-allowed');
                proceedBtn.disabled = true;
            }

            // Sync with Right Tray Modal Drawer
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
                    row.className = "flex justify-between items-center p-3 bg-slate-50 border border-slate-100 rounded-2xl";
                    row.innerHTML = `
                        <div class="max-w-[200px]">
                            <h6 class="font-bold text-slate-900 text-xs">${item.name}</h6>
                            <span class="text-[#1a4373] text-xs font-black">$${(item.price * item.qty).toFixed(2)}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="updateCartQty('${item.id}', -1)" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600">-</button>
                            <span class="text-xs font-black px-1">${item.qty}</span>
                            <button onclick="updateCartQty('${item.id}', 1)" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600">+</button>
                        </div>
                    `;
                    drawerList.appendChild(row);
                });
            }

            drawerSub.innerText = `$${totalSum.toFixed(2)}`;
            drawerTot.innerText = `$${totalSum.toFixed(2)}`;
        }

        // Toggles detail basket summary slideout drawer
        function toggleBasketDrawer(show) {
            const drawer = document.getElementById('drawer-basket');
            if (show) {
                drawer.classList.remove('hidden');
            } else {
                drawer.classList.add('hidden');
            }
        }

        // Opens checkout modal selection
        function openPaymentSelector() {
            toggleBasketDrawer(false);
            document.getElementById('modal-payment').classList.remove('hidden');
        }

        // Closes checkout modal selection
        function closePaymentSelector() {
            document.getElementById('modal-payment').classList.add('hidden');
        }

        // Finalizes order processing and outputs scannable ticket pass matching order pass logic
        function processFinalPayment(method) {
            closePaymentSelector();

            // Setup mock successful receipt IDs mapped directly to Customer & Cashier dashboard assets
            const receiptId = "TG-94820";
            const passCode = "837-D0C";

            document.getElementById('success-order-id').innerText = `#${receiptId}`;
            document.getElementById('success-pass-code').innerText = passCode;

            // Trigger success view
            document.getElementById('screen-success').classList.remove('hidden');
        }
    </script>
</body>
</html>