{{-- 
    Drug Pharma Egypt — Custom Admin Login Page
    Split-screen design with a branded info panel on the left and the login form on the right.
    Uses Filament's simple page wrapper to keep all Livewire/CSRF/auth wiring intact,
    while injecting a fully branded UI on top.
--}}

<x-filament-panels::page.simple>
    {{-- ============================================
         Branded styles (scoped via #dp-login)
         ============================================ --}}
    <style>
        :root {
            --dp-navy: #1B2360;
            --dp-navy-700: #2A337A;
            --dp-navy-900: #11163F;
            --dp-orange: #E87330;
            --dp-orange-700: #C95A1B;
            --dp-orange-200: #FBE3D2;
            --dp-text: #1F1F2E;
            --dp-muted: #6B6B7A;
            --dp-line: #E8E8EA;
            --dp-bg: #FAFAF7;
        }

        /* === Reset Filament's default page wrapping for full-screen layout === */
        body.fi-body { background: var(--dp-bg); }

        .fi-simple-layout {
            background: var(--dp-bg) !important;
            min-height: 100vh;
            display: block !important;
            padding: 0 !important;
        }

        .fi-simple-main-ctn,
        .fi-simple-main {
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            border-radius: 0 !important;
            border: none !important;
        }

        /* Hide the default Filament header/heading — we render our own */
        .fi-simple-header { display: none !important; }

        /* === Two-column split-screen container === */
        #dp-login {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
            min-height: 100vh;
            font-family: 'DM Sans', 'Cairo', system-ui, sans-serif;
            color: var(--dp-text);
        }
        @media (max-width: 960px) {
            #dp-login { grid-template-columns: 1fr; }
            #dp-login__brand { display: none !important; }
        }

        /* ===========================================================
           LEFT PANEL — Brand showcase
           =========================================================== */
        #dp-login__brand {
            position: relative;
            background:
                radial-gradient(ellipse at top right, rgba(232, 115, 48, 0.45) 0%, transparent 55%),
                radial-gradient(ellipse at bottom left, rgba(27, 35, 96, 0.85) 0%, transparent 60%),
                linear-gradient(135deg, var(--dp-navy) 0%, var(--dp-navy-900) 100%);
            color: #fff;
            padding: 56px 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            isolation: isolate;
        }

        /* Decorative blobs */
        #dp-login__brand::before,
        #dp-login__brand::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }
        #dp-login__brand::before {
            top: -150px; right: -150px;
            width: 480px; height: 480px;
            background: rgba(232, 115, 48, 0.40);
        }
        #dp-login__brand::after {
            bottom: -200px; left: -100px;
            width: 520px; height: 520px;
            background: rgba(42, 51, 122, 0.55);
        }

        /* SVG dot pattern */
        #dp-login__pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 28px 28px;
            mask-image: radial-gradient(circle at 70% 30%, black 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        #dp-login__brand > * { position: relative; z-index: 1; }

        /* Top: logo + brand line */
        .dp-brand-top {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .dp-brand-top img {
            height: 56px;
            width: auto;
            background: white;
            padding: 8px 14px;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.20);
        }
        .dp-brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.10em;
            text-transform: uppercase;
        }
        .dp-brand-pill .pulse {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--dp-orange);
            box-shadow: 0 0 0 0 rgba(232, 115, 48, 0.6);
            animation: dp-pulse 1.8s infinite;
        }
        @keyframes dp-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(232, 115, 48, 0.6); }
            70%  { box-shadow: 0 0 0 10px rgba(232, 115, 48, 0); }
            100% { box-shadow: 0 0 0 0 rgba(232, 115, 48, 0); }
        }

        /* Middle: hero text */
        .dp-brand-hero h1 {
            font-family: 'Outfit', 'Cairo', sans-serif;
            font-size: 52px;
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.02em;
            margin: 0 0 24px 0;
            color: #fff;
        }
        .dp-brand-hero h1 .accent {
            color: var(--dp-orange);
            font-weight: 800;
        }
        .dp-brand-hero p {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.78);
            max-width: 480px;
            line-height: 1.65;
            margin: 0;
        }

        /* Stats strip at the bottom */
        .dp-brand-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }
        .dp-stat-num {
            font-family: 'Outfit', sans-serif;
            color: var(--dp-orange);
            font-size: 30px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 6px;
        }
        .dp-stat-label {
            color: rgba(255, 255, 255, 0.65);
            font-size: 12.5px;
            line-height: 1.4;
        }

        /* ===========================================================
           RIGHT PANEL — Login form
           =========================================================== */
        #dp-login__form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 32px;
            background: var(--dp-bg);
            position: relative;
        }
        #dp-login__form::before {
            content: "";
            position: absolute;
            top: -150px; right: -150px;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--dp-orange-200) 0%, transparent 70%);
            filter: blur(60px);
            opacity: 0.5;
            pointer-events: none;
        }

        .dp-form-card {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        /* Mobile-only logo (shown when brand panel is hidden) */
        .dp-mobile-logo {
            display: none;
            text-align: center;
            margin-bottom: 32px;
        }
        .dp-mobile-logo img {
            height: 64px;
        }
        @media (max-width: 960px) {
            .dp-mobile-logo { display: block; }
        }

        /* Header */
        .dp-form-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--dp-orange-200);
            color: var(--dp-orange-700);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.10em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        .dp-form-eyebrow .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--dp-orange);
        }

        .dp-form-title {
            font-family: 'Outfit', 'Cairo', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: var(--dp-navy);
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin: 0 0 12px 0;
        }
        .dp-form-title .wave { display: inline-block; }
        .dp-form-subtitle {
            color: var(--dp-muted);
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 32px 0;
        }

        /* === Style the actual Filament form === */
        #dp-login .fi-fo-component-ctn { margin-bottom: 16px !important; }
        #dp-login .fi-fo-field-wrp-label,
        #dp-login .fi-fo-field-wrp-label *,
        #dp-login label,
        #dp-login label * {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: var(--dp-orange-700) !important;
            letter-spacing: 0 !important;
        }
        #dp-login .fi-input-wrp {
            border-radius: 12px !important;
            border: 1.5px solid var(--dp-line) !important;
            background: white !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
        }
        #dp-login .fi-input-wrp:hover {
            border-color: var(--dp-muted) !important;
        }
        #dp-login .fi-input-wrp:focus-within {
            border-color: var(--dp-orange) !important;
            box-shadow: 0 0 0 4px rgba(232, 115, 48, 0.12) !important;
        }
        #dp-login .fi-input {
            padding: 12px 16px !important;
            font-size: 15px !important;
            font-family: inherit !important;
            color: var(--dp-text) !important;
        }
        #dp-login .fi-input::placeholder {
            color: var(--dp-muted) !important;
        }

        /* Remember-me checkbox */
        #dp-login input[type="checkbox"]:checked {
            background-color: var(--dp-orange) !important;
            border-color: var(--dp-orange) !important;
        }

        /* Submit button */
        #dp-login .fi-form-actions {
            margin-top: 28px !important;
            padding-top: 0 !important;
            border-top: none !important;
        }
        #dp-login .fi-btn-color-primary {
            background: var(--dp-orange) !important;
            color: #fff !important;
            font-family: 'Outfit', 'Cairo', sans-serif !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            padding: 14px 24px !important;
            border-radius: 12px !important;
            box-shadow:
                0 10px 24px rgba(232, 115, 48, 0.30),
                0 0 0 0 rgba(232, 115, 48, 0.4) !important;
            border: none !important;
            transition: all 0.2s ease !important;
            width: 100% !important;
            justify-content: center !important;
            letter-spacing: 0.01em !important;
        }
        #dp-login .fi-btn-color-primary:hover {
            background: var(--dp-orange-700) !important;
            transform: translateY(-2px);
            box-shadow:
                0 14px 28px rgba(232, 115, 48, 0.36) !important;
        }
        #dp-login .fi-btn-color-primary:active {
            transform: translateY(0);
        }

        /* Forgot password link */
        #dp-login .fi-link {
            color: var(--dp-orange-700) !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }
        #dp-login .fi-link:hover {
            color: var(--dp-orange) !important;
            text-decoration: underline !important;
        }

        /* Error states */
        #dp-login .fi-fo-field-wrp-error-message {
            color: #d94545 !important;
            font-size: 12.5px !important;
            font-weight: 500 !important;
            margin-top: 6px !important;
        }

        /* Demo credentials hint card */
        .dp-demo-hint {
            margin-top: 28px;
            background: white;
            border: 1.5px dashed var(--dp-orange-200);
            border-radius: 14px;
            padding: 16px 18px;
            font-size: 13px;
            color: var(--dp-muted);
        }
        .dp-demo-hint strong {
            color: var(--dp-navy);
            display: block;
            margin-bottom: 6px;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .dp-demo-hint code {
            background: var(--dp-orange-200);
            color: var(--dp-orange-700);
            padding: 2px 8px;
            border-radius: 6px;
            font-family: 'Menlo', 'Monaco', monospace;
            font-size: 12px;
            font-weight: 600;
        }

        /* Footer note */
        .dp-form-footer {
            margin-top: 32px;
            text-align: center;
            color: var(--dp-muted);
            font-size: 13px;
        }
        .dp-form-footer a {
            color: var(--dp-orange-700);
            font-weight: 600;
            text-decoration: none;
        }
        .dp-form-footer a:hover { text-decoration: underline; }

        /* RTL polish for Arabic users */
        html[dir="rtl"] #dp-login {
            font-family: 'Cairo', system-ui, sans-serif;
        }
        html[dir="rtl"] .dp-form-title,
        html[dir="rtl"] .dp-brand-hero h1 {
            font-family: 'Cairo', sans-serif;
            letter-spacing: 0;
        }

        /* ============================================
           Language toggle — floating top-right
           ============================================ */
        .dp-lang-toggle {
            position: absolute;
            top: 28px;
            inset-inline-end: 28px;
            z-index: 50;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 999px;
            font-family: 'Outfit', 'Cairo', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.95);
            color: var(--dp-navy);
            border: 1.5px solid var(--dp-orange-200);
            box-shadow: 0 4px 12px rgba(27, 35, 96, 0.10);
        }
        .dp-lang-toggle:hover {
            background: var(--dp-orange);
            color: #fff;
            border-color: var(--dp-orange);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(232, 115, 48, 0.30);
        }

        /* Cairo font for any Arabic visitors */
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    {{-- ============================================
         Layout
         ============================================ --}}
    <div id="dp-login">

        {{-- ============== LEFT BRAND PANEL ============== --}}
        <div id="dp-login__brand">
            <div id="dp-login__pattern"></div>

            <div class="dp-brand-top">
                <img src="{{ asset('logo.png') }}" alt="Drug Pharma Egypt">
                <span class="dp-brand-pill">
                    <span class="pulse"></span>
                    Admin Portal
                </span>
            </div>

            <div class="dp-brand-hero">
                <h1>
                    Welcome <br>
                    <span class="accent">back.</span>
                </h1>
                <p>
                    Sign in to manage Drug Pharma Egypt — your products, categories, and customer messages.
                    The future of Egyptian pharmaceuticals, since 2016.
                </p>
            </div>

            <div class="dp-brand-stats">
                <div>
                    <div class="dp-stat-num">30+</div>
                    <div class="dp-stat-label">Products</div>
                </div>
                <div>
                    <div class="dp-stat-num">5</div>
                    <div class="dp-stat-label">Categories</div>
                </div>
                <div>
                    <div class="dp-stat-num">2016</div>
                    <div class="dp-stat-label">Established</div>
                </div>
            </div>
        </div>

        {{-- ============== RIGHT FORM PANEL ============== --}}
        <div id="dp-login__form">
            <div class="dp-form-card">
                {{-- Mobile-only logo (when brand panel is hidden) --}}
                <div class="dp-mobile-logo">
                    <img src="{{ asset('logo.png') }}" alt="Drug Pharma Egypt">
                </div>

                <span class="dp-form-eyebrow">
                    <span class="dot"></span>
                    Sign In
                </span>

                <h2 class="dp-form-title">
                    Welcome <span class="accent">back</span>.
                </h2>

                <p class="dp-form-subtitle">
                    Enter your credentials to access the Drug Pharma Egypt dashboard.
                </p>

                {{-- The actual Filament login form (CSRF, validation, auth — all wired) --}}
                <x-filament-panels::form wire:submit="authenticate">
                    {{ $this->form }}

                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()"
                    />
                </x-filament-panels::form>

                <div class="dp-form-footer">
                    © {{ date('Y') }} Drug Pharma Egypt. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page.simple>
