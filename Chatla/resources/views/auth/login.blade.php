<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chatla - Login</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2c5926",
                        "background-light": "#f9fafa", /* Adjusted slightly to match your earlier design background */
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
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">

    <nav class="w-full bg-transparent h-20 px-8 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2 text-slate-900 font-bold text-xl">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">spa</span>
            </div>
            Chatla
        </a>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="hover:text-slate-900 transition-colors">Home</a>
            <a href="#" class="hover:text-slate-900 transition-colors">Explore</a>
            <a href="{{ route('contact') }}" class="hover:text-slate-900 transition-colors">Contact us</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Login</a>
            @endauth
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4 md:p-8">
        <div class="max-w-[1100px] w-full grid grid-cols-1 lg:grid-cols-2 bg-white dark:bg-background-dark rounded-[24px] shadow-xl overflow-hidden border border-primary/5 min-h-[650px]">
            
            <div class="relative hidden lg:flex flex-col justify-between p-12 bg-primary overflow-hidden">
                <div class="absolute inset-0 opacity-80 mix-blend-multiply">
                    <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/login-bg.jpg') }}')"></div>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-primary/40 to-black/60 z-0"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-8">
                        <span class="material-symbols-outlined text-3xl text-white">spa</span>
                        <span class="text-2xl font-bold text-white tracking-tight">Chatla</span>
                    </div>
                    <h1 class="text-5xl font-bold text-white leading-tight mb-6">Grow your green<br>world together.</h1>
                    <p class="text-lg text-white/80 max-w-md">Connect with local nurseries, find rare botanical treasures, and join a community that breathes life into spaces.</p>
                </div>
                
                <div class="relative z-10 flex gap-4 mt-8">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-primary bg-[#e8cdb8]"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-primary bg-[#f4e4d4]"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-primary bg-[#f8f5f2] flex items-center justify-center text-xs text-primary font-bold">+</div>
                    </div>
                    <p class="text-sm text-white/90 self-center font-medium">Joined by 10k+ plant enthusiasts</p>
                </div>
            </div>

            <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white">
                
                <div class="mb-10 lg:hidden">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-3xl text-primary">spa</span>
                        <span class="text-2xl font-black text-primary tracking-tight">Chatla</span>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Welcome back</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-2">Please enter your details to access your garden.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="email">Email Address</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">mail</span>
                            <input class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-slate-800 border-0 ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 transition-all outline-none" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="hello@nature.com" type="email"/>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="text-xs text-red-600 mt-1" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="password">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-primary hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">lock</span>
                            <input class="w-full pl-12 pr-12 py-3.5 bg-background-light dark:bg-slate-800 border-0 ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 transition-all outline-none" id="password" name="password" required placeholder="••••••••" type="password"/>
                            <button onclick="togglePassword()" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors" type="button" id="togglePasswordIcon">visibility</button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-xs text-red-600 mt-1" />
                    </div>

                    <div class="flex items-center gap-2 py-1">
                        <input class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 cursor-pointer" id="remember_me" name="remember" type="checkbox"/>
                        <label class="text-sm text-slate-600 dark:text-slate-400 cursor-pointer select-none" for="remember_me">Keep me logged in for 30 days</label>
                    </div>

                    <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98] mt-2" type="submit">
                        Sign In
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-background-dark text-slate-500">Or continue with</span>
                    </div>
                </div>

                <button class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"></path>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                    </svg>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Google</span>
                </button>

                <div class="mt-10">
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400 mb-4">
                        Don't have an account? <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Join the community</a>
                    </p>
                    
                    <div class="flex p-1 bg-background-light border border-slate-200 border-dashed rounded-lg max-w-sm mx-auto">
                        <a href="{{ route('register', ['role' => 'simple']) }}" class="flex-1 py-2.5 text-center text-sm font-bold rounded-md bg-white shadow-sm text-primary transition-all">
                            I am a Buyer
                        </a>
                        <a href="{{ route('register', ['role' => 'nursery_owner']) }}" class="flex-1 py-2.5 text-center text-sm font-bold rounded-md text-slate-500 hover:text-primary transition-all">
                            I am a Nursery Owner
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>