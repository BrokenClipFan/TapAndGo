{{-- {{ dd($order) }} --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ticket</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0f172a] min-h-screen flex items-center justify-center p-4">

    <!-- ORDER SUCCESS SCREEN (QR CODE & TICKET WITH AUTO-RESET) -->
    <div id="screen-success"
        class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 text-center border-t-8 border-orange-500 relative my-auto">

        <span
            class="w-16 h-16 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow">
            <i class="bi bi-patch-check-fill animate-bounce"></i>
        </span>

        <h2 class="text-[#1a4373] text-2xl font-black">Order Placed!</h2>
        <p class="text-slate-400 text-xs mt-1">Please proceed to the cashier to complete your payment.</p>

        <div class="my-6 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 p-5 space-y-4 relative">
            <div>
                <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Order Ticket</span>
                <h3 class="text-2xl font-extrabold text-[#1a4373]" id="success-order-id">#{{ $order->id }}</h3>
            </div>

            <!-- Scannable QR matrix block -->
            <div
                class="w-36 h-36 mx-auto bg-white p-3 rounded-xl border border-slate-100 shadow flex items-center justify-center">
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

            <!-- Restored Code Block -->
            <div>
                <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block">Pickup / Payment
                    Code</span>
                <strong
                    class="text-2xl font-mono font-extrabold tracking-widest text-orange-500 bg-orange-100/50 px-4 py-1.5 rounded-lg border border-orange-200 inline-block mt-1"
                    id="success-pass-code">{{ $order->order_code }}</strong>
            </div>
        </div>

        <div
            class="text-left bg-slate-50 border border-slate-100 rounded-2xl p-4 space-y-2.5 mb-6 text-xs text-slate-600">
            <p class="font-extrabold text-[#1a4373] flex items-center gap-1">
                <i class="bi bi-info-circle-fill"></i>
                <span>Next Steps:</span>
            </p>
            <div class="flex gap-2">
                <strong class="text-orange-500">1.</strong>
                <span>Head over to the cashier terminal.</span>
            </div>
            <div class="flex gap-2">
                <strong class="text-orange-500">2.</strong>
                <span>Show this QR code or provide code <b id="instruction-pass-code"
                        class="text-slate-800">{{ $order->order_code }}</b>.</span>
            </div>
            <div class="flex gap-2">
                <strong class="text-orange-500">3.</strong>
                <span>Pay cash or scan via e-wallet at the counter.</span>
            </div>
        </div>

        <button onclick="resetToWelcome()"
            class="w-full bg-[#1a4373] hover:bg-blue-900 text-white font-black py-4 rounded-xl shadow-lg transition-all active:scale-95">
            Done & Back to Start
        </button>

        <!-- Auto Refresh Countdown Badge -->
        <div class="mt-4 flex items-center justify-center gap-1.5 text-xs text-slate-400 font-bold">
            <i class="bi bi-arrow-repeat text-orange-500 animate-spin"></i>
            <span>Auto-resetting in <strong id="reset-countdown-text"
                    class="text-orange-500 font-extrabold">30</strong>s</span>
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

        // Initialize timer on load
        startSuccessTimer();

        // Interaction resets countdown
        document.getElementById('screen-success').addEventListener('pointerdown', resetSuccessTimer);
    </script>
</body>

</html>
