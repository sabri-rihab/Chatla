<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatla — Nursery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sage:    #7a9e7e;
            --sage-lt: #b4cdb7;
            --cream:   #f7f3ed;
            --stone:   #e8e0d5;
            --bark:    #5c4b3b;
            --bark-lt: #8c7060;
            --moss:    #3d5c42;
            --white:   #fdfcfa;
            --err:     #c0614a;
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--bark);
            overflow-x: hidden;
        }

        /* ── BACKGROUND TEXTURE ── */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 15% 10%, #d9e8d4 0%, transparent 55%),
                radial-gradient(ellipse 60% 70% at 85% 80%, #e3d9cc 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 90% 10%, #cddec9 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── FLOATING LEAVES ── */
        .leaf {
            position: fixed;
            opacity: 0.12;
            animation: drift linear infinite;
            pointer-events: none;
            z-index: 0;
        }
        @keyframes drift {
            0%   { transform: translateY(110vh) rotate(0deg); }
            100% { transform: translateY(-10vh) rotate(360deg); }
        }

        /* ── LAYOUT ── */
        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── LEFT PANEL ── */
        .left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 72px;
            position: relative;
            overflow: hidden;
        }

        .left-bg {
            position: absolute; inset: 0;
            background: linear-gradient(145deg, #4a7050 0%, #2e4a33 100%);
            z-index: 0;
        }
        .left-bg::after {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='0' cy='0' r='80' fill='none' stroke='%23ffffff08' stroke-width='40'/%3E%3Ccircle cx='200' cy='200' r='80' fill='none' stroke='%23ffffff06' stroke-width='40'/%3E%3C/svg%3E");
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        /* ── LOGO ── */
        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 56px;
        }

        .logo-mark { flex-shrink: 0; }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 400;
            color: #fdfcfa;
            letter-spacing: 0.08em;
            line-height: 1;
        }

        .logo-sub {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 300;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #b4cdb7;
            margin-top: 4px;
        }

        .tagline {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.2rem;
            font-weight: 300;
            line-height: 1.2;
            color: #fdfcfa;
            margin-bottom: 24px;
        }
        .tagline em {
            font-style: italic;
            color: #b4cdb7;
        }

        .left-desc {
            font-size: 0.9rem;
            font-weight: 300;
            line-height: 1.7;
            color: rgba(253,252,250,0.65);
            max-width: 340px;
        }

        .left-decoration {
            position: absolute;
            bottom: -40px;
            right: -40px;
            opacity: 0.08;
        }

        /* ── RIGHT PANEL ── */
        .right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
            background: var(--white);
        }

        .card {
            width: 100%;
            max-width: 400px;
            animation: fadeUp 0.6s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── TAB SWITCHER ── */
        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--stone);
            position: relative;
        }

        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 400;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--bark-lt);
            padding: 14px 0;
            transition: color 0.25s;
            position: relative;
        }
        .tab-btn.active {
            color: var(--moss);
            font-weight: 500;
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 0; right: 0;
            height: 2px;
            background: var(--moss);
            border-radius: 1px;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: scaleX(0); }
            to   { transform: scaleX(1); }
        }

        /* ── FORM ── */
        .form-panel { display: none; }
        .form-panel.active {
            display: block;
            animation: fadeUp 0.35s ease both;
        }

        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.9rem;
            font-weight: 400;
            color: var(--bark);
            margin-bottom: 8px;
        }
        .form-subtitle {
            font-size: 0.82rem;
            font-weight: 300;
            color: var(--bark-lt);
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .field {
            margin-bottom: 18px;
        }
        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--bark-lt);
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }
        .input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            opacity: 0.45;
        }

        .field input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1px solid var(--stone);
            border-radius: 10px;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            font-weight: 300;
            color: var(--bark);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field input::placeholder { color: var(--sage-lt); }
        .field input:focus {
            border-color: var(--sage);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(122,158,126,0.12);
        }
        .field input.is-invalid {
            border-color: var(--err);
            box-shadow: 0 0 0 3px rgba(192,97,74,0.12);
        }

        .invalid-feedback {
            display: block;
            font-size: 0.73rem;
            color: var(--err);
            margin-top: 5px;
            padding-left: 2px;
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .forgot {
            text-align: right;
            margin-top: -8px;
            margin-bottom: 24px;
        }
        .forgot a {
            font-size: 0.75rem;
            color: var(--sage);
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot a:hover { color: var(--moss); }

        /* ── SUBMIT BUTTON ── */
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4a7050, #2e4a33);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 4px 18px rgba(46,74,51,0.28);
            margin-bottom: 22px;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(46,74,51,0.36);
        }
        .btn-primary:active { transform: translateY(0); }

        /* ── DIVIDER ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .divider span {
            flex: 1;
            height: 1px;
            background: var(--stone);
        }
        .divider p {
            font-size: 0.72rem;
            color: var(--bark-lt);
            letter-spacing: 0.06em;
        }

        /* ── SOCIAL BUTTONS ── */
        .social-btns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 28px;
        }
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px;
            border: 1px solid var(--stone);
            border-radius: 10px;
            background: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 400;
            color: var(--bark);
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            text-decoration: none;
        }
        .btn-social:hover {
            border-color: var(--sage-lt);
            background: var(--cream);
        }

        .switch-msg {
            text-align: center;
            font-size: 0.8rem;
            color: var(--bark-lt);
        }
        .switch-msg a {
            color: var(--moss);
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
        }
        .switch-msg a:hover { text-decoration: underline; }

        /* ── MOBILE ── */
        @media (max-width: 860px) {
            .page { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 40px 28px; min-height: 100vh; }
            .mobile-logo {
                display: flex !important;
                align-items: center;
                gap: 12px;
                margin-bottom: 36px;
                justify-content: center;
            }
        }
        .mobile-logo { display: none; }

        /* ── TERMS CHECKBOX ── */
        .check-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }
        .check-row input[type=checkbox] {
            margin-top: 2px;
            accent-color: var(--moss);
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }
        .check-row label {
            font-size: 0.78rem;
            font-weight: 300;
            color: var(--bark-lt);
            line-height: 1.5;
            text-transform: none;
            letter-spacing: 0;
        }
        .check-row label a { color: var(--moss); text-decoration: none; }
        .check-row label a:hover { text-decoration: underline; }

        /* ── SESSION ALERT ── */
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 18px;
            line-height: 1.5;
        }
        .alert-danger {
            background: rgba(192, 97, 74, 0.1);
            border: 1px solid rgba(192, 97, 74, 0.25);
            color: var(--err);
        }
        .alert-success {
            background: rgba(61, 92, 66, 0.1);
            border: 1px solid rgba(61, 92, 66, 0.25);
            color: var(--moss);
        }
    </style>
</head>
<body>

{{-- ── FLOATING LEAVES ── --}}
<svg class="leaf" style="left:8%;width:36px;animation-duration:28s;animation-delay:-7s" viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 5 C5 15 2 35 20 55 C38 35 35 15 20 5Z" fill="#3d5c42"/><line x1="20" y1="5" x2="20" y2="55" stroke="#3d5c42" stroke-width="1.2"/></svg>
<svg class="leaf" style="left:75%;width:28px;animation-duration:22s;animation-delay:-14s" viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 5 C5 15 2 35 20 55 C38 35 35 15 20 5Z" fill="#7a9e7e"/><line x1="20" y1="5" x2="20" y2="55" stroke="#7a9e7e" stroke-width="1.2"/></svg>
<svg class="leaf" style="left:45%;width:22px;animation-duration:35s;animation-delay:-2s" viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 5 C5 15 2 35 20 55 C38 35 35 15 20 5Z" fill="#5c4b3b"/><line x1="20" y1="5" x2="20" y2="55" stroke="#5c4b3b" stroke-width="1.2"/></svg>
<svg class="leaf" style="left:90%;width:30px;animation-duration:19s;animation-delay:-10s" viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 5 C5 15 2 35 20 55 C38 35 35 15 20 5Z" fill="#4a7050"/><line x1="20" y1="5" x2="20" y2="55" stroke="#4a7050" stroke-width="1.2"/></svg>

<div class="page">

    {{-- ───── LEFT PANEL ───── --}}
    <div class="left">
        <div class="left-bg"></div>

        {{-- Large decorative leaf --}}
        <svg class="left-decoration" width="340" height="480" viewBox="0 0 340 480" fill="none">
            <path d="M170 10 C30 80 10 250 170 470 C330 250 310 80 170 10Z" fill="white"/>
            <line x1="170" y1="10" x2="170" y2="470" stroke="white" stroke-width="4"/>
            <line x1="170" y1="120" x2="90" y2="180" stroke="white" stroke-width="2"/>
            <line x1="170" y1="180" x2="75" y2="250" stroke="white" stroke-width="2"/>
            <line x1="170" y1="240" x2="80" y2="310" stroke="white" stroke-width="2"/>
            <line x1="170" y1="120" x2="250" y2="180" stroke="white" stroke-width="2"/>
            <line x1="170" y1="180" x2="265" y2="250" stroke="white" stroke-width="2"/>
            <line x1="170" y1="240" x2="260" y2="310" stroke="white" stroke-width="2"/>
        </svg>

        <div class="left-content">
            {{-- Logo --}}
            <div class="logo-wrap">
                <div class="logo-mark">
                    <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="26" cy="26" r="25" stroke="rgba(253,252,250,0.25)" stroke-width="1"/>
                        <path d="M26 32 C14 28 12 14 26 10 C22 22 22 28 26 32Z" fill="#b4cdb7"/>
                        <path d="M26 32 C38 28 40 14 26 10 C30 22 30 28 26 32Z" fill="#fdfcfa" fill-opacity="0.85"/>
                        <line x1="26" y1="32" x2="26" y2="42" stroke="#fdfcfa" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M18 43 Q26 41 34 43" stroke="rgba(253,252,250,0.45)" stroke-width="1.4" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>
                <div>
                    <div class="logo-text">Chatla</div>
                    <div class="logo-sub">Nursery</div>
                </div>
            </div>

            <h1 class="tagline">Where little<br/>ones <em>bloom</em>.</h1>
            <p class="left-desc">A nurturing space crafted for the tiniest explorers. Trusted by thousands of families to bring the best of nature's gifts to your doorstep.</p>
        </div>
    </div>

    {{-- ───── RIGHT PANEL ───── --}}
    <div class="right">
        <div class="card">

            {{-- Mobile-only logo --}}
            <div class="mobile-logo">
                <svg width="40" height="40" viewBox="0 0 52 52" fill="none">
                    <circle cx="26" cy="26" r="25" stroke="#b4cdb7" stroke-width="1"/>
                    <path d="M26 32 C14 28 12 14 26 10 C22 22 22 28 26 32Z" fill="#7a9e7e"/>
                    <path d="M26 32 C38 28 40 14 26 10 C30 22 30 28 26 32Z" fill="#3d5c42" fill-opacity="0.85"/>
                    <line x1="26" y1="32" x2="26" y2="42" stroke="#3d5c42" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M18 43 Q26 41 34 43" stroke="#b4cdb7" stroke-width="1.4" stroke-linecap="round" fill="none"/>
                </svg>
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;color:var(--bark);letter-spacing:0.07em">Chatla</div>
                    <div style="font-size:0.6rem;letter-spacing:0.26em;text-transform:uppercase;color:var(--bark-lt)">Nursery</div>
                </div>
            </div>

            {{-- Tab switcher --}}
            <div class="tabs">
                <button class="tab-btn {{ $activeTab === 'register' ? '' : 'active' }}" id="tab-login" onclick="switchTab('login')">Sign In</button>
                <button class="tab-btn {{ $activeTab === 'register' ? 'active' : '' }}" id="tab-register" onclick="switchTab('register')">Create Account</button>
            </div>

            {{-- ── Session / Status Messages ── --}}
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            {{-- ── LOGIN FORM ── --}}
            <div class="form-panel {{ $activeTab === 'register' ? '' : 'active' }}" id="panel-login">
                <h2 class="form-title">Welcome back</h2>
                <p class="form-subtitle">Sign in to your Chatla account and continue nurturing.</p>

                @if ($errors->login->any())
                    <div class="alert alert-danger">
                        {{ $errors->login->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="field">
                        <label for="login_email">Email Address</label>
                        <div class="input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 8l10 6 10-6"/></svg>
                            <input
                                type="email"
                                id="login_email"
                                name="email"
                                placeholder="hello@example.com"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                class="{{ $errors->login->has('email') ? 'is-invalid' : '' }}"
                                required
                            />
                        </div>
                        @error('email', 'login')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="login_password">Password</label>
                        <div class="input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <input
                                type="password"
                                id="login_password"
                                name="password"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                class="{{ $errors->login->has('password') ? 'is-invalid' : '' }}"
                                required
                            />
                        </div>
                        @error('password', 'login')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="forgot">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        @else
                            <a href="#">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary">Sign In</button>
                </form>

                <div class="divider"><span></span><p>or continue with</p><span></span></div>

                <div class="social-btns">
                    <a class="btn-social" href="#">
                        <svg width="17" height="17" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Google
                    </a>
                    <a class="btn-social" href="#">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                </div>

                <p class="switch-msg">New to Chatla? <a onclick="switchTab('register')">Create an account →</a></p>
            </div>

            {{-- ── REGISTER FORM ── --}}
            <div class="form-panel {{ $activeTab === 'register' ? 'active' : '' }}" id="panel-register">
                <h2 class="form-title">Join Chatla</h2>
                <p class="form-subtitle">Create your account and start exploring our nursery collection.</p>

                @if ($errors->register->any() && !$errors->register->has('email') && !$errors->register->has('name') && !$errors->register->has('password'))
                    <div class="alert alert-danger">
                        {{ $errors->register->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="row-2">
                        {{-- First Name --}}
                        <div class="field">
                            <label for="register_first_name">First Name</label>
                            <div class="input-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <input
                                    type="text"
                                    id="register_first_name"
                                    name="first_name"
                                    placeholder="Sara"
                                    value="{{ old('first_name') }}"
                                    autocomplete="given-name"
                                    class="{{ $errors->register->has('first_name') ? 'is-invalid' : '' }}"
                                    required
                                />
                            </div>
                            @error('first_name', 'register')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div class="field">
                            <label for="register_last_name">Last Name</label>
                            <div class="input-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <input
                                    type="text"
                                    id="register_last_name"
                                    name="last_name"
                                    placeholder="Green"
                                    value="{{ old('last_name') }}"
                                    autocomplete="family-name"
                                    class="{{ $errors->register->has('last_name') ? 'is-invalid' : '' }}"
                                    required
                                />
                            </div>
                            @error('last_name', 'register')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="field">
                        <label for="register_email">Email Address</label>
                        <div class="input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 8l10 6 10-6"/></svg>
                            <input
                                type="email"
                                id="register_email"
                                name="email"
                                placeholder="hello@example.com"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                class="{{ $errors->register->has('email') ? 'is-invalid' : '' }}"
                                required
                            />
                        </div>
                        @error('email', 'register')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="register_password">Password</label>
                        <div class="input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <input
                                type="password"
                                id="register_password"
                                name="password"
                                placeholder="Min. 8 characters"
                                autocomplete="new-password"
                                class="{{ $errors->register->has('password') ? 'is-invalid' : '' }}"
                                required
                            />
                        </div>
                        @error('password', 'register')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="field">
                        <label for="register_password_confirmation">Confirm Password</label>
                        <div class="input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5c4b3b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <input
                                type="password"
                                id="register_password_confirmation"
                                name="password_confirmation"
                                placeholder="Repeat your password"
                                autocomplete="new-password"
                                class="{{ $errors->register->has('password_confirmation') ? 'is-invalid' : '' }}"
                                required
                            />
                        </div>
                    </div>

                    <div class="check-row">
                        <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required/>
                        <label for="terms">
                            I agree to Chatla's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms', 'register')
                        <span class="invalid-feedback" style="display:block;margin-top:-14px;margin-bottom:14px;">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn-primary">Create Account</button>
                </form>

                <div class="divider"><span></span><p>or sign up with</p><span></span></div>

                <div class="social-btns">
                    <a class="btn-social" href="#">
                        <svg width="17" height="17" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Google
                    </a>
                    <a class="btn-social" href="#">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                </div>

                <p class="switch-msg">Already have an account? <a onclick="switchTab('login')">Sign in →</a></p>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        document.getElementById('tab-login').classList.toggle('active', tab === 'login');
        document.getElementById('tab-register').classList.toggle('active', tab === 'register');
        document.getElementById('panel-login').classList.toggle('active', tab === 'login');
        document.getElementById('panel-register').classList.toggle('active', tab === 'register');
    }
</script>
</body>
</html>
