<style>
    /* Splash Screen Overlay */
    #splash-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
        overflow: hidden;
    }

    #splash-screen.fade-out {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    /* Background Glow Pulse Effect */
    .splash-glow {
        position: absolute;
        width: 320px;
        height: 320px;
        background: var(--theme-accent, #f97316);
        opacity: 0.15;
        filter: blur(80px);
        border-radius: 50%;
        animation: pulseGlow 3s infinite ease-in-out;
    }

    /* Splash Content Animations */
    .splash-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        animation: zoomIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .splash-logo {
        height: 85px;
        width: auto;
        object-fit: contain;
        margin-bottom: 1.25rem;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.4));
    }

    .splash-title {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin-bottom: 0.25rem;
    }

    .splash-subtitle {
        font-size: 0.9rem;
        color: var(--theme-accent, #f97316);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 2rem;
    }

    /* Animated Progress Bar */
    .splash-progress-container {
        width: 220px;
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .splash-progress-bar {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--theme-primary, #1a4373), var(--theme-accent, #f97316));
        border-radius: 10px;
        animation: fillProgress 3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Keyframes */
    @keyframes fillProgress {
        0% {
            width: 0%;
        }

        50% {
            width: 65%;
        }

        100% {
            width: 100%;
        }
    }

    @keyframes zoomIn {
        0% {
            opacity: 0;
            transform: scale(0.85);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulseGlow {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.15;
        }

        50% {
            transform: scale(1.3);
            opacity: 0.25;
        }
    }
</style>

<!-- Animated Splash Screen HTML -->
<div id="splash-screen">
    <div class="splash-glow"></div>
    <div class="splash-content">
        <img src="{{ asset('Logo.png') }}" alt="Logo" class="splash-logo">
        <h1 class="splash-title">{{ $title ?? 'Tap&Go' }}</h1>
        <p class="splash-subtitle">{{ $subtitle ?? 'Payment Terminal' }}</p>
        <div class="splash-progress-container">
            <div class="splash-progress-bar"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const splash = document.getElementById('splash-screen');
            if (splash) {
                splash.classList.add('fade-out');

                // Optional auto-focus handling if input exists on page
                setTimeout(() => {
                    const focusInput = document.getElementById('kiosk-code-input');
                    if (focusInput) focusInput.focus();
                }, 800);
            }
        }, 3000);
    });
</script>
