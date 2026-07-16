<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Modern CSS Reset & Dynamic Brand Theme Engine */
        :root {
            --theme-primary: #1a4373;        /* TapAndGo Core Deep Blue */
            --theme-primary-hover: #113259;  /* Darker Blue for states */
            --theme-accent: #f97316;         /* TapAndGo Vibrant Orange */
            --theme-accent-hover: #ea580c;   /* Darker Orange for hover */
            --theme-dark: #0f172a;           /* Clean Off-Black */
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

        /* Strict Fit Screen Constraints + Premium Gradient Background */
        html, body {
            height: 100vh;
            width: 100vw;
            overflow: hidden; 
            /* Beautiful brand-aligned gradient background */
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #1a4373 100%);
            display: flex;
            flex-direction: column;
        }

        /* Nav Layout */
        .custom-nav {
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            z-index: 10;
        }

        .nav-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Color branding token on the navbar logo icon */
        .nav-brand i {
            color: var(--theme-accent);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--theme-accent);
        }

        /* Main Viewport Workspace */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            min-height: 0; 
        }

        /* Split-Pane Form Card - Sized identically to Login for design consistency */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            width: 100%;
            max-width: 900px; 
            height: 100%;
            max-height: 600px; 
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            overflow: hidden; 
        }

        /* Left Side: Logo Branding Section */
        .logo-branding-pane {
            flex: 1.1; 
            background-color: #ffffff;
            border-right: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        /* Optimized Logo Sizing Rules */
        .brand-logo-img {
            width: 100%;
            max-width: 320px;   
            max-height: 320px;  
            object-fit: contain;
            user-select: none;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.05));
        }

        /* Right Side: Strictly Scrollable Form Area */
        .form-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 3.5rem 3rem;
            min-height: 0;
        }

        /* Custom Premium Scrollbar for Form Pane */
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

        /* Form Controls & Headings */
        .header-section {
            margin-bottom: 2rem;
        }

        .form-title {
            color: var(--theme-primary);
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.35rem;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1.1rem;
            border: 1.5px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px rgba(26, 67, 115, 0.15);
        }

        /* Links matching brand accent orange */
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

        /* Primary Action Button themed with Brand Blue */
        .btn-submit {
            width: 100%;
            background: var(--theme-primary);
            color: white;
            border: none;
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(26, 67, 115, 0.2);
            transition: background 0.2s, transform 0.1s;
            margin-top: 0.75rem;
        }

        .btn-submit:hover {
            background: var(--theme-primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        /* Alert styling */
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
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* Responsive Breakpoint for mobile/smaller viewports */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 440px;
                max-height: 82vh;
            }
            .logo-branding-pane {
                padding: 2rem 1.5rem;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                max-height: 180px;
            }
            .brand-logo-img {
                max-height: 120px;
                max-width: 160px;
            }
            .form-pane {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Header Bar -->
    <nav class="custom-nav">
        <a class="nav-brand" href="#">
            <i class="bi bi-layers-half"></i> 
            <span>TapAndGo</span>
        </a>
        <ul class="nav-links">
            <li><a class="active" href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- UI View Wrapper -->
    <main class="main-wrapper">
        <div class="login-card">
            
            <!-- Left Side: Logo Display Frame -->
            <div class="logo-branding-pane">
                <img src="{{ asset('storage/Logo.png') }}" alt="TapAndGo Logo" class="brand-logo-img">
            </div>
            
            <!-- Right Side: Content Frame (Scrollbar will trigger automatically here for overflow fields) -->
            <div class="form-pane">
                
                <!-- Branding Header -->
                <div class="header-section">
                    <h3 class="form-title">Create Account</h3>
                    <p class="form-subtitle">Join us and start delivering gourmet meals</p>
                </div>

                <!-- Session Status / Errors -->
                @if ($errors->any())
                    <ul class="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <!-- Form Layout -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Input -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus autocomplete="name">
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="username">
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                    </div>

                    <!-- Submit action -->
                    <button class="btn-submit" type="submit">
                        <span>Register Now</span>
                        <i class="bi bi-person-plus-fill"></i>
                    </button>
                    
                    <!-- Back to Login Link -->
                    <div class="footer-divider">
                        <span>Already registered? <a href="{{ route('login') }}" class="link-action">Sign In</a></span>
                    </div>
                </form>

            </div>
        </div>
    </main>

</body>
</html>