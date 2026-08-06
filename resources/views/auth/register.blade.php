<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --theme-primary: #1a4373;
            --theme-primary-hover: #113259;
            --theme-accent: #f97316;
            --theme-accent-hover: #ea580c;
            --theme-dark: #0f172a;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        html,
        body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background: radial-gradient(circle at top right, #1e293b 0%, #0f172a 60%, #1a4373 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            width: 100%;
            max-width: 950px;
            height: 100%;
            max-height: 620px;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        /* Left Side: Visual Image Showcase Section */
        .image-showcase-pane {
            flex: 1.1;
            position: relative;
            background-color: var(--theme-dark);
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            padding: 2.5rem;
        }

        .showcase-bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.65;
            transition: transform 0.5s ease;
        }

        .login-card:hover .showcase-bg-img {
            transform: scale(1.03);
        }

        .showcase-overlay {
            position: relative;
            z-index: 2;
            color: #ffffff;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .showcase-overlay h4 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
        }

        .showcase-overlay p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.4;
        }

        /* Right Side: Form Area */
        .form-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 2.5rem;
            min-height: 0;
        }

        .form-pane::-webkit-scrollbar {
            width: 6px;
        }

        .form-pane::-webkit-scrollbar-track {
            background: transparent;
        }

        .form-pane::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        .header-section {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-brand-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
            margin-bottom: 1rem;
            display: block;
        }

        .form-title {
            color: var(--theme-primary);
            font-size: 1.65rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.1rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
            border: none;
            background: none;
        }

        .toggle-password:hover {
            color: var(--theme-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 2.8rem;
            border: 1.5px solid var(--border-color);
            border-radius: 0.6rem;
            font-size: 0.95rem;
            outline: none;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px rgba(26, 67, 115, 0.15);
        }

        .form-control:focus~.input-icon {
            color: var(--theme-primary);
        }

        .link-action {
            color: var(--theme-accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .link-action:hover {
            color: var(--theme-accent-hover);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: var(--theme-primary);
            color: white;
            border: none;
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.6rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(26, 67, 115, 0.25);
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background: var(--theme-primary-hover);
            box-shadow: 0 6px 16px rgba(26, 67, 115, 0.35);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .alert {
            padding: 0.75rem 1rem;
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            list-style-position: inside;
        }

        .footer-divider {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 440px;
                max-height: 88vh;
            }

            .image-showcase-pane {
                display: none;
            }

            .form-pane {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <main class="main-wrapper">
        <div class="login-card">

            <!-- Left Side: Image Showcase -->
            <div class="image-showcase-pane">
                <img src="{{ asset('MDF2.jpg') }}" alt="TapAndGo Experience" class="showcase-bg-img">
                <div class="showcase-overlay">
                    <h4>Join TapAndGo Today</h4>
                    <p>Start managing transactions effortlessly with our smart terminal solution.</p>
                </div>
            </div>

            <!-- Right Side: Form Pane -->
            <div class="form-pane">

                <div class="header-section">
                    <!-- Brand Logo Image -->
                    <img src="{{ asset('Logo.png') }}" alt="TapAndGo Logo" class="form-brand-logo">
                    <h3 class="form-title">Create Account</h3>
                    <p class="form-subtitle">Join us and access your payment dashboard</p>
                </div>

                @if ($errors->any())
                    <ul class="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" placeholder="Full Name" required autofocus autocomplete="name">
                        <i class="bi bi-person input-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="Email Address" required autocomplete="username">
                        <i class="bi bi-envelope input-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" required autocomplete="new-password">
                        <i class="bi bi-lock input-icon"></i>
                        <button type="button" class="toggle-password"
                            onclick="toggleVisibility('password', 'toggleIcon1')">
                            <i class="bi bi-eye" id="toggleIcon1"></i>
                        </button>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Confirm Password" required
                            autocomplete="new-password">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <button type="button" class="toggle-password"
                            onclick="toggleVisibility('password_confirmation', 'toggleIcon2')">
                            <i class="bi bi-eye" id="toggleIcon2"></i>
                        </button>
                    </div>

                    <button class="btn-submit" type="submit">
                        <span>Register Now</span>
                        <i class="bi bi-person-plus-fill"></i>
                    </button>

                    <div class="footer-divider">
                        <span>Already registered? <a href="{{ route('login') }}" class="link-action">Sign In</a></span>
                    </div>
                </form>

            </div>
        </div>
    </main>

    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

</body>

</html>
