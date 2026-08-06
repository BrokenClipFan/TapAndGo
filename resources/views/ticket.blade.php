<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ticket - Tap&Go</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Side Notch Cuts for Ticket Effect */
        .ticket-notch-left {
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background-color: #0f172a;
            border-radius: 50%;
        }

        .ticket-notch-right {
            position: absolute;
            right: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background-color: #0f172a;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-[#0f172a] min-h-screen flex items-center justify-center p-4">

    <!-- ORDER TICKET CARD -->
    <div id="screen-success"
        class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border-t-8 border-orange-500 relative my-auto">

        <!-- Header Ribbon with Logo -->
        <div
            class="bg-[#1a4373] p-5 text-center flex flex-col items-center justify-center border-b border-blue-900/40 relative">
            <img src="{{ asset('Logo.png') }}" alt="Tap&Go Logo" class="h-12 object-contain mb-2 drop-shadow-md">
            <span
                class="bg-orange-500 text-white font-black text-[10px] uppercase tracking-widest px-3 py-1 rounded-full shadow-sm">
                {{ $order->order_type ?? 'Dine In' }}
            </span>
        </div>

        <div class="p-6 text-center">

            <!-- Success Alert Header -->
            <div class="flex items-center justify-center gap-2 text-emerald-600 mb-1">
                <i class="bi bi-patch-check-fill text-2xl animate-bounce"></i>
                <h2 class="text-xl font-black text-[#1a4373]">Order Successfully Placed!</h2>
            </div>
            <p class="text-slate-500 text-xs mb-5">Please proceed to the cashier counter to complete payment.</p>

            <!-- Ticket Section -->
            <div
                class="border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50 p-5 space-y-4 relative overflow-hidden shadow-inner">
                <!-- Decorative Receipt Notches -->
                <div class="ticket-notch-left"></div>
                <div class="ticket-notch-right"></div>

                <!-- Order ID Header -->
                <div class="border-b border-slate-200/80 pb-3">
                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block">Order Ticket
                        Number</span>
                    <h3 class="text-3xl font-black text-[#1a4373]" id="success-order-id">#{{ $order->id }}</h3>
                </div>

                <!-- Scannable QR Matrix Block -->
                <div
                    class="w-40 h-40 mx-auto bg-white p-3 rounded-2xl border border-slate-200 shadow-md flex items-center justify-center">
                    <svg width="120" height="120" viewBox="0 0 100 100" class="w-full h-full">
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

                <!-- Pickup/Payment Passcode Block -->
                <div class="pt-1">
                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block mb-1">Pickup /
                        Payment Code</span>
                    <strong
                        class="text-2xl font-mono font-black tracking-widest text-orange-600 bg-orange-100/80 px-5 py-2 rounded-xl border border-orange-200 inline-block shadow-sm"
                        id="success-pass-code">
                        {{ $order->order_code }}
                    </strong>
                </div>

                <!-- Total Summary Row -->
                @if (isset($order->total_amount))
                    <div class="border-t border-slate-200/80 pt-3 flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-bold uppercase tracking-wider">Total Amount Due</span>
                        <span
                            class="text-[#1a4373] font-black text-lg">₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                @endif
            </div>

            <!-- Next Steps Guidance Card -->
            <div
                class="text-left bg-slate-50 border border-slate-100 rounded-2xl p-4 space-y-2 mt-5 text-xs text-slate-600 shadow-sm">
                <p class="font-extrabold text-[#1a4373] flex items-center gap-1.5 border-b border-slate-200/60 pb-1.5">
                    <i class="bi bi-info-circle-fill text-orange-500"></i>
                    <span>Instructions for Payment:</span>
                </p>
                <div class="flex gap-2">
                    <strong class="text-orange-500 font-black">1.</strong>
                    <span>Walk to the cashier counter terminal.</span>
                </div>
                <div class="flex gap-2">
                    <strong class="text-orange-500 font-black">2.</strong>
                    <span>Present this screen or state code <b id="instruction-pass-code"
                            class="text-slate-900 font-black">{{ $order->order_code }}</b>.</span>
                </div>
                <div class="flex gap-2">
                    <strong class="text-orange-500 font-black">3.</strong>
                    <span>Complete payment via Cash or E-Wallet.</span>
                </div>
            </div>

            <!-- Return Button -->
            <button onclick="resetToWelcome()"
                class="w-full mt-5 bg-[#1a4373] hover:bg-blue-900 text-white font-black py-4 rounded-2xl shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                <i class="bi bi-house-door-fill text-lg"></i>
                <span>Done & Back to Start</span>
            </button>

            <!-- Auto-reset Timer Indicator -->
            <div class="mt-4 flex items-center justify-center gap-1.5 text-xs text-slate-400 font-bold">
                <i class="bi bi-arrow-repeat text-orange-500 animate-spin"></i>
                <span>Auto-resetting in <strong id="reset-countdown-text"
                        class="text-orange-500 font-extrabold">30</strong>s</span>
            </div>
        </div>
    </div>

    <script>
        let successCountdown = 30;
        let countdownTimer = null;

        function startSuccessTimer() {
            clearSuccessTimer();
            successCountdown = 30;
            updateCountdownUI();

            countdownTimer = setInterval(() => {
                successCountdown--;
                updateCountdownUI();

                if (successCountdown <= 0) {
                    clearSuccessTimer();
                    window.location.href = "{{ url('/') }}";
                }
            }, 1000);
        }

        function resetSuccessTimer() {
            successCountdown = 30;
            updateCountdownUI();
        }

        function clearSuccessTimer() {
            if (countdownTimer) {
                clearInterval(countdownTimer);
                countdownTimer = null;
            }
        }

        function updateCountdownUI() {
            const timerEl = document.getElementById('reset-countdown-text');
            if (timerEl) {
                timerEl.innerText = successCountdown;
            }
        }

        function resetToWelcome() {
            window.location.href = "{{ url('/') }}";
        }

        // Initialize countdown on view load
        startSuccessTimer();

        // User touch/pointer interaction resets the countdown timer
        document.getElementById('screen-success').addEventListener('pointerdown', resetSuccessTimer);
    </script>
</body>

</html>
