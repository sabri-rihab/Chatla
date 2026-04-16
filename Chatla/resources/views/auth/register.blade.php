<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chatla - Nursery Registration</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2c5926",
                        "background-light": "#f9fafa",
                        "background-dark": "#161d15",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.2em 1.2em;
            -webkit-appearance: none;
            appearance: none;
        }

        /* ── Custom City Dropdown ── */
        .cd-wrap { position: relative; }

        .cd-trigger {
            position: relative;
            display: flex; align-items: center;
            width: 100%;
            padding: 0.875rem 2.75rem 0.875rem 3rem;
            background: #f9fafa;
            border: none;
            box-shadow: 0 0 0 1px #e2e8f0;
            border-radius: 1.5rem; 
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: #0f172a;
            cursor: pointer;
            text-align: left;
            transition: box-shadow 0.15s;
            outline: none;
        }
        .cd-trigger:focus { box-shadow: 0 0 0 2px #2c5926; }  /* green ring */
        .cd-trigger.open  { box-shadow: 0 0 0 2px #2c5926; }  /* stays green while open */
        .cd-trigger.placeholder { color: #0f172a; } /* placeholder stays dark */
        .cd-trigger-text { flex: 1; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }

        .cd-chevron {
            position: absolute; right: 1rem; top: 50%;
            transform: translateY(-50%);
            width: 1.1rem; height: 1.1rem; color: #94a3b8;
            transition: transform 0.2s;
            pointer-events: none;
        }
        .cd-trigger.open .cd-chevron { transform: translateY(-50%) rotate(180deg); }

        .cd-panel {
            position: absolute; z-index: 999;
            left: 0; right: 0; top: calc(100% + 4px);
            background: #fff;
            border-radius: 1.25rem;  /* slightly less than trigger so it looks nested cleanly */
            box-shadow: 0 10px 40px rgba(0,0,0,.1), 0 0 0 1px #e2e8f0;
            overflow: hidden;
            display: none;
        }
        .cd-panel.open { display: block; animation: cdDrop .15s ease; }
        @keyframes cdDrop {
            from { opacity: 0; transform: translateY(-5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .cd-search-wrap { padding: 0.5rem 0.6rem; border-bottom: 1px solid #f1f5f9; }
        .cd-search {
            width: 100%; padding: 0.4rem 0.75rem;
            background: #f9fafa;
            border: none;
            box-shadow: 0 0 0 1px #e2e8f0;
            border-radius: 0.5rem;
            font-family: 'Inter', sans-serif; font-size: 0.825rem;
            color: #0f172a; outline: none;
        }
        .cd-search::placeholder { color: #94a3b8; }
        .cd-search:focus { box-shadow: 0 0 0 2px #2c5926; }

        /* ← This is what limits height to ~6 items */
        .cd-list {
            max-height: 210px;   /* ≈ 6 rows × 35px */
            overflow-y: auto;
            padding: 0.3rem 0;
        }
        .cd-list::-webkit-scrollbar { width: 4px; }
        .cd-list::-webkit-scrollbar-track { background: transparent; }
        .cd-list::-webkit-scrollbar-thumb { background: #c6d8c7; border-radius: 9999px; }

        .cd-option {
            padding: 0.5rem 1rem;
            font-family: 'Inter', sans-serif; font-size: 0.875rem;
            color: #0f172a; cursor: pointer;
            transition: background 0.1s, color 0.1s;
        }
        .cd-option:hover   { background: #e3ebe4; color: #2c5926; }
        .cd-option.active  { background: #e3ebe4; color: #2c5926; font-weight: 600; }

        .cd-empty {
            padding: 0.75rem 1rem;
            font-family: 'Inter', sans-serif; font-size: 0.8rem;
            color: #94a3b8; text-align: center;
        }
    </style>
</head>
<body class="bg-background-light font-display text-slate-900 min-h-screen flex flex-col">

    <!-- Navigation (Matched to Login) -->
    <nav class="w-full bg-transparent h-20 px-8 flex items-center justify-between border-b border-gray-200 bg-white">
        <a href="/" class="flex items-center gap-2 text-slate-900 font-bold text-xl">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
            </div>
            Chatla
        </a>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <a href="#" class="hover:text-slate-900 transition-colors">Home</a>
            <a href="#" class="hover:text-slate-900 transition-colors">Explore</a>
            <a href="#" class="hover:text-slate-900 transition-colors">Contact us</a>
            <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Login</a>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4 md:p-8">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content: Value Proposition -->
            <div class="hidden lg:flex flex-col gap-8 pr-8">
                <div class="space-y-4">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-[#e3ebe4] text-primary text-xs font-bold uppercase tracking-wider">JOIN OUR NETWORK</span>
                    <h1 class="text-5xl font-black leading-tight text-slate-900">
                        Grow your business <br/>
                        <span class="text-primary">with Chatla</span>
                    </h1>
                    <p class="text-lg text-slate-600 max-w-md mt-4">
                        Connect with plant enthusiasts across the region. Manage your inventory, track orders, and showcase your nursery to thousands of customers.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 mt-4">
                    <div class="flex gap-4 items-start">
                        <div class="p-2 bg-[#e3ebe4] rounded-full text-primary shrink-0">
                            <!-- Visibility Icon -->
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Increase Visibility</h4>
                            <p class="text-slate-500 text-sm mt-1">Be discovered by local and regional customers looking for specific species.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <div class="p-2 bg-[#e3ebe4] rounded-full text-primary shrink-0">
                            <!-- Inventory Icon -->
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><path d="M9 21V9"/><path d="M15 21V9"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Stock Management</h4>
                            <p class="text-slate-500 text-sm mt-1">Easy-to-use digital tools to track your seedlings and mature plants.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl overflow-hidden h-56 mt-4 shadow-sm relative">
                    <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                    <img alt="Professional greenhouse environment" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCORLhHaR4S00_QYsHMrukQRGocrObeRtongxv0QDJXfbUKp36w_4R6g-SVouWjresgfGzfyLl6lc2P7te-RT8u-W12ESwIeHNy0EfJg4IkdOng6Yady8rBoK8DpjWlIFf-2W2sryRdra7vpZpyWSkVUsLdk1DgRPLy3i-mVaKAn-1qLUIFIAbbFUu-hN_4KytuSGIzd-GhoLSw7ScYyH-oUqyKttiFtas-j8VZsc6uoe_xh4MOAXmt8OMT5lY8noEu7re7QnmAT78"/>
                </div>
            </div>

            <!-- Right Content: Registration Form -->
            <div class="bg-white p-8 md:p-12 rounded-[24px] shadow-xl border border-primary/5">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Create your account</h2>
                    <p class="text-slate-500 text-sm">Fill in the details to register your nursery.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Global error summary: catches any validation failure from the controller --}}
                    @if ($errors->any())
                        <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 space-y-1">
                            <p class="font-semibold">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Nursery Name</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                            <input name="nursery_name" value="{{ old('nursery_name') }}" required class="w-full pl-12 pr-4 py-3.5 bg-background-light border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 placeholder:text-slate-400 transition-all outline-none" placeholder="Green Valley Nursery" type="text"/>
                        </div>
                        <x-input-error :messages="$errors->get('nursery_name')" class="text-xs text-red-600 mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="cd-trigger" class="text-sm font-semibold text-slate-700">City</label>

                            {{-- Hidden input: carries city_id to form submit --}}
                            <input type="hidden" name="city_id" id="city_id_val"
                                   value="{{ old('city_id') }}" required />

                            <div class="cd-wrap">
                                {{-- Map icon --}}
                                <svg class="absolute left-4 z-10 pointer-events-none text-slate-400"
                                     style="top:50%;transform:translateY(-50%);width:1.2rem;height:1.2rem"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/>
                                    <line x1="9" y1="3" x2="9" y2="18"/>
                                    <line x1="15" y1="6" x2="15" y2="21"/>
                                </svg>

                                {{-- Trigger button --}}
                                <button type="button" id="cd-trigger" class="cd-trigger placeholder"
                                        aria-haspopup="listbox" aria-expanded="false">
                                    <span class="cd-trigger-text" id="cd-label">
                                        @if(old('city_id') && isset($cities))
                                            {{ $cities->firstWhere('id', old('city_id'))?->name ?? 'Select your city...' }}
                                        @else
                                            Select your city...
                                        @endif
                                    </span>
                                    <svg class="cd-chevron" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                </button>

                                {{-- Dropdown panel --}}
                                <div class="cd-panel" id="cd-panel" role="listbox">
                                    <div class="cd-search-wrap">
                                        <input type="text" id="cd-search"
                                               class="cd-search"
                                               placeholder="Search city…"
                                               autocomplete="off" aria-label="Search cities" />
                                    </div>
                                    <div class="cd-list" id="cd-list">
                                        @if(isset($cities))
                                            @foreach($cities as $city)
                                                <div class="cd-option {{ old('city_id') == $city->id ? 'active' : '' }}"
                                                     data-id="{{ $city->id }}"
                                                     data-name="{{ $city->name }}"
                                                     role="option">
                                                    {{ $city->name }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="cd-empty" id="cd-empty" style="display:none">No cities found</div>
                                </div>
                            </div>

                            @error('city_id')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Phone Number</label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <input name="phone" value="{{ old('phone') }}" required class="w-full pl-12 pr-4 py-3.5 bg-background-light border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 placeholder:text-slate-400 transition-all outline-none" placeholder="+1 234 567 890" type="tel"/>
                            </div>
                            <x-input-error :messages="$errors->get('phone')" class="text-xs text-red-600 mt-1" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Full Address</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <input name="address" value="{{ old('address') }}" required class="w-full pl-12 pr-4 py-3.5 bg-background-light border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 placeholder:text-slate-400 transition-all outline-none" placeholder="123 Plant Street, Nature City" type="text"/>
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="text-xs text-red-600 mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Email Address</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <input name="email" value="{{ old('email') }}" required class="w-full pl-12 pr-4 py-3.5 bg-background-light border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 placeholder:text-slate-400 transition-all outline-none" placeholder="owner@nursery.com" type="email"/>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="text-xs text-red-600 mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <input id="password" name="password" required class="w-full pl-12 pr-12 py-3.5 bg-background-light border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 placeholder:text-slate-400 transition-all outline-none tracking-widest" placeholder="••••••••" type="password"/>
                            <button onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors focus:outline-none" type="button" id="togglePasswordIcon">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-xs text-red-600 mt-1" />
                        <p class="text-[11px] text-slate-400 mt-1">Must contain at least 8 characters, one number and one special character.</p>
                    </div>

                    <div class="flex items-center gap-2 py-1">
                        <input name="terms" required class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 cursor-pointer" id="terms" type="checkbox"/>
                        <label class="text-sm text-slate-600 cursor-pointer select-none" for="terms">
                            I agree to the <a class="text-primary font-bold hover:underline" href="#">Terms of Service</a> and <a class="text-primary font-bold hover:underline" href="#">Privacy Policy</a>.
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('terms')" class="text-xs text-red-600" />

                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2 mt-2">
                        Register Nursery
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>

                    <div class="text-center pt-4">
                        <p class="text-sm text-slate-500">Already registered? <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Log in to your account</a></p>
                    </div>
                </form>

                <div class="mt-8 pt-8 border-t border-slate-100">
                    <div class="bg-primary/5 p-6 rounded-2xl border border-primary/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <p class="text-base font-bold text-primary mb-1">Looking for a personal account?</p>
                            <p class="text-sm text-slate-600">Join our community to buy plants and share tips.</p>
                        </div>
                        <a class="bg-primary/10 text-primary text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-primary hover:text-white transition-all whitespace-nowrap" href="{{ route('register', ['role' => 'simple']) }}">
                            Register as User
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer (Matched to Login) -->
    <footer class="mt-auto px-8 py-6 border-t border-gray-200 bg-white">
        <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-slate-500">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                <p class="text-xs font-semibold tracking-wider">CHATLA © 2026</p>
            </div>
            <div class="flex gap-8">
                <a class="text-xs text-slate-500 hover:text-slate-900 font-semibold tracking-wider transition-colors" href="#">TERMS</a>
                <a class="text-xs text-slate-500 hover:text-slate-900 font-semibold tracking-wider transition-colors" href="#">PRIVACY</a>
                <a class="text-xs text-slate-500 hover:text-slate-900 font-semibold tracking-wider transition-colors" href="#">COOKIES</a>
            </div>
        </div>
    </footer>

    <script>
        /* ── City custom dropdown ── */
        document.addEventListener('DOMContentLoaded', function () {
            const trigger  = document.getElementById('cd-trigger');
            const panel    = document.getElementById('cd-panel');
            const search   = document.getElementById('cd-search');
            const list     = document.getElementById('cd-list');
            const empty    = document.getElementById('cd-empty');
            const label    = document.getElementById('cd-label');
            const hidden   = document.getElementById('city_id_val');
            if (!trigger) return;

            function open() {
                panel.classList.add('open');
                trigger.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                search.value = '';
                filter('');
                search.focus();
                const active = list.querySelector('.active');
                if (active) active.scrollIntoView({ block: 'nearest' });
            }
            function close() {
                panel.classList.remove('open');
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            trigger.addEventListener('click', function (e) {
                e.stopPropagation();
                panel.classList.contains('open') ? close() : open();
            });
            document.addEventListener('click', function (e) {
                if (!trigger.closest('.cd-wrap').contains(e.target)) close();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') close();
            });

            function filter(q) {
                const lower = q.toLowerCase().trim();
                let hits = 0;
                list.querySelectorAll('.cd-option').forEach(function (opt) {
                    const show = opt.dataset.name.toLowerCase().includes(lower);
                    opt.style.display = show ? '' : 'none';
                    if (show) hits++;
                });
                empty.style.display = hits === 0 ? '' : 'none';
            }
            search.addEventListener('input', function () { filter(this.value); });

            list.addEventListener('click', function (e) {
                const opt = e.target.closest('.cd-option');
                if (!opt) return;
                list.querySelectorAll('.cd-option').forEach(function (o) { o.classList.remove('active'); });
                opt.classList.add('active');
                hidden.value = opt.dataset.id;
                label.textContent = opt.dataset.name;
                trigger.classList.remove('placeholder');
                close();
            });
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIconBtn = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Switch to eye-off SVG
                toggleIconBtn.innerHTML = '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
            } else {
                passwordInput.type = 'password';
                // Switch back to regular eye SVG
                toggleIconBtn.innerHTML = '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
            }
        }
    </script>
</body>
</html>