<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chatla - Join Our Community</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2c5926",
                        "background-light": "#fbfcfb",
                        "background-dark": "#161d15",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "2xl": "2rem", "full": "9999px"},
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased min-h-screen flex flex-col">

    <!-- Navigation (Matched to Nursery Owner & Login) -->
    <nav class="w-full bg-transparent h-20 px-8 flex items-center justify-between border-b border-gray-200 bg-white dark:bg-background-dark">
        <a href="/" class="flex items-center gap-2 text-slate-900 dark:text-white font-bold text-xl">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">spa</span>
            </div>
            Chatla
        </a>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600 dark:text-slate-300">
            <a href="/" class="hover:text-primary transition-colors">Home</a>
            <a href="#" class="hover:text-primary transition-colors">Explore</a>
            <a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Contact us</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 md:px-10">
        <div class="w-full max-w-[1100px] grid lg:grid-cols-2 bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] border border-slate-100 dark:border-slate-800 animate-slide-up">
            
            <!-- Left Side: Visual/Context -->
            <div class="hidden lg:flex flex-col relative bg-primary p-16 text-white overflow-hidden">
                <div class="absolute inset-0 opacity-40 mix-blend-multiply scale-110" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCuc3w0cfBVE6z0t2swEB75Dy5cLzVLt6LeGGwo8SL2yjf2XiOcSpOdm_Vc8BaFWGsv6yxXAnfXU7GKUCJ1p21st-72Oh7FmXLTuXH_FodKzY9ljHNc5_zqZXCuTp15_jT62BQtYIE_xGGDpuKqPXWjeaZo8fS61OQnOnSkqQ0FUXC0zpZN09LRY03kY6Sgi4wiDnL8EEsg--IXST_lWfutsxef_cadRN_3dD17SFnUihzZXPueWPwcyc0S2CCKwPbTi9iHDxduqnQ"); background-size: cover; background-position: center;'></div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="inline-flex items-center justify-center size-12 bg-white/20 rounded-2xl mb-10 backdrop-blur-md">
                            <span class="material-symbols-outlined text-3xl">leafy_green</span>
                        </div>
                        <h1 class="text-5xl font-extrabold mb-8 leading-[1.15]">Grow your green space with Chatla</h1>
                        <p class="text-white/90 text-xl leading-relaxed max-w-md">Join thousands of nature enthusiasts. Swap tips, buy rare plants, and connect with local nurseries.</p>
                    </div>
                    <div class="bg-white/10 p-8 rounded-2xl backdrop-blur-xl border border-white/20">
                        <p class="text-base italic mb-6 leading-relaxed">"Chatla transformed how I care for my indoor garden. The community is incredibly supportive!"</p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full border-2 border-white/30 overflow-hidden">
                                <img alt="Sarah J." class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAmusvrbdOpkRNLdjWkU5wQ9L3dKV2HZEfryxsD2zFEGqKYjvM8woyqXAmnFnsGGyAxMRruPkMap-za-1-G8YAZvD35aw8HRykyVjWClC-yl4rRRwSFDXTSVA3ckuViFlfy4FVtLRs3D3s_C5cy3Lb66i7Kb4Pgo45TgcbMy7pd3oGwC_roeXD7bTJMla7ljs2zXq4DW-BpkzVBTDGDuGOe8UhJlQazeS_8IPJnTPbQmJuTQv05zhce7hN3BzZZCo3BsnO0Wft8Y2U"/>
                            </div>
                            <div>
                                <p class="font-bold text-base">Sarah Jenkins</p>
                                <p class="text-sm text-white/70">Verified Member</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Registration Form -->
            <div class="p-8 md:p-14 lg:p-16 flex flex-col">
                <div class="mb-12">
                    <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-3">Create Your Account</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">Start your journey with us today.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="role" value="simple">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <label class="flex flex-col gap-2.5">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Name</span>
                            <input name="name" value="{{ old('name') }}" required class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 focus:border-primary focus:ring-primary h-14 px-5 text-base transition-all" placeholder="Jane Doe" type="text"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </label>
                        <label class="flex flex-col gap-2.5">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Email Address</span>
                            <input name="email" value="{{ old('email') }}" required class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 focus:border-primary focus:ring-primary h-14 px-5 text-base transition-all" placeholder="jane@example.com" type="email"/>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <label class="flex flex-col gap-2.5">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Password</span>
                            <div class="relative">
                                <input id="password" name="password" required class="form-input w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 focus:border-primary focus:ring-primary h-14 px-5 text-base pr-12 transition-all" placeholder="••••••••" type="password"/>
                                <span onclick="togglePassword('password')" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer text-xl hover:text-slate-600 transition-colors">visibility</span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </label>
                        <label class="flex flex-col gap-2.5">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Confirm Password</span>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" required class="form-input w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 focus:border-primary focus:ring-primary h-14 px-5 text-base pr-12 transition-all" placeholder="••••••••" type="password"/>
                                <span onclick="togglePassword('password_confirmation')" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer text-xl hover:text-slate-600 transition-colors">visibility</span>
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 py-2">
                        <input name="terms" required class="size-5 rounded border-slate-300 text-primary focus:ring-primary transition-all cursor-pointer" id="terms" type="checkbox"/>
                        <label class="text-sm text-slate-500 dark:text-slate-400 cursor-pointer" for="terms">
                            I agree to the <a class="text-primary font-bold hover:underline" href="#">Terms of Service</a> and <a class="text-primary font-bold hover:underline" href="#">Privacy Policy</a>.
                        </label>
                    </div>

                    <button class="w-full bg-primary text-white font-bold py-5 rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/30 hover:-translate-y-0.5 transition-all active:scale-[0.98] text-lg" type="submit">
                        Create Account
                    </button>
                </form>

                <div class="mt-10 pt-10 border-t border-slate-100 dark:border-slate-800">
                    <div class="bg-primary/5 dark:bg-primary/10 p-6 rounded-2xl border border-primary/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <p class="text-base font-bold text-primary mb-1">Are you a Nursery Owner?</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">List your products and reach more customers.</p>
                        </div>
                        <a class="bg-primary/10 dark:bg-primary/20 text-primary text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-primary hover:text-white transition-all whitespace-nowrap" href="{{ route('register', ['role' => 'nursery_owner']) }}">
                            Switch to Business
                        </a>
                    </div>
                </div>

                <p class="text-center mt-10 text-base text-slate-500 dark:text-slate-400">
                    Already have an account? <a class="text-primary font-extrabold hover:underline" href="{{ route('login') }}">Sign In</a>
                </p>
            </div>
        </div>
    </main>

    <!-- Footer (Matched to Nursery Owner) -->
    <footer class="mt-auto px-8 py-10 border-t border-gray-200 bg-white dark:bg-background-dark">
        <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-6 h-6 rounded bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-[14px]">spa</span>
                </div>
                <p class="text-sm font-semibold tracking-wider uppercase">Chatla &copy; 2026</p>
            </div>
            <div class="flex gap-10">
                <a class="text-xs text-slate-500 dark:text-slate-400 hover:text-primary font-bold tracking-widest transition-colors uppercase" href="#">Terms</a>
                <a class="text-xs text-slate-500 dark:text-slate-400 hover:text-primary font-bold tracking-widest transition-colors uppercase" href="#">Privacy</a>
                <a class="text-xs text-slate-500 dark:text-slate-400 hover:text-primary font-bold tracking-widest transition-colors uppercase" href="#">Cookies</a>
            </div>
        </div>
    </footer>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
