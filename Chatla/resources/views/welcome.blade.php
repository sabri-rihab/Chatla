<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chatla 🌱 - Rooting the Future of Moroccan Nurseries</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2c5926",
                        "background-light": "#f6f7f6",
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
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 transition-colors duration-300">

<!-- Top Navigation Bar -->
<header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-6 lg:px-20 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">spa</span>
            </div>
            <h2 class="text-primary text-xl font-bold tracking-tight">Chatla</h2>
        </div>
        <nav class="hidden md:flex items-center gap-8">
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ url('/') }}">Home</a>
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('nurseries.index') }}">Nurseries</a>
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('explore') }}">Explore</a>
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('contact') }}">Contact us</a>
            
            @if (Route::has('login'))
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">
                        Login
                    </a>
                @endauth
            @endif
        </nav>
        <button class="md:hidden text-primary">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>
</header>

<main>
    <!-- Hero Section -->
    <section class="relative px-6 py-12 lg:py-24">
        <div class="max-w-7xl mx-auto">
            <div class="relative overflow-hidden rounded-3xl min-h-[560px] flex flex-col items-center justify-center p-8 text-center bg-primary/5 border border-primary/10">
                <div class="absolute inset-0 z-0 opacity-20 pointer-events-none bg-[url('https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80')] bg-cover bg-center"></div>
                <div class="relative z-10 max-w-3xl space-y-8">
                    <h1 class="text-4xl md:text-6xl font-black leading-[1.1] tracking-tight text-slate-900 dark:text-white">
                        Rooting the Future of <span class="text-primary">Moroccan Nurseries</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300">
                        Connecting local growers with plant lovers across the Kingdom. Find rare species, outdoor plants, and everything your garden needs.
                    </p>
                    <form action="{{ route('explore') }}" method="GET" class="flex flex-col sm:flex-row items-center bg-white dark:bg-slate-800 p-2 rounded-2xl shadow-xl shadow-primary/10 border border-primary/5 w-full max-w-2xl mx-auto">
                        <div class="flex items-center flex-1 px-4 gap-3 w-full border-b sm:border-b-0 sm:border-r border-slate-100 dark:border-slate-700 py-3 sm:py-0">
                            <span class="material-symbols-outlined text-primary/60">search</span>
                            <input name="search" class="bg-transparent border-none focus:ring-0 w-full text-slate-900 dark:text-white placeholder:text-slate-400" placeholder="Search for plants or botanical families..." type="text" value="{{ request('search') }}"/>
                        </div>
                        <button type="submit" class="w-full sm:w-auto bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary/90 transition-all flex items-center justify-center gap-2">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="px-6 py-16 lg:py-24 max-w-7xl mx-auto">
        <div class="mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">How Chatla Works</h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-2xl">Our platform bridges the gap between traditional nurseries and modern gardening needs, making plant shopping and selling effortless.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="p-8 rounded-3xl bg-white dark:bg-slate-800 border border-primary/5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">yard</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">For Gardeners</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Browse a centralized inventory of local plants, compare prices from different nurseries, and get verified quality plants delivered to your doorstep across Morocco.
                </p>
                <ul class="mt-6 space-y-3">
                    <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Diverse plant selection</li>
                    <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Price comparison tools</li>
                    <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Safe doorstep delivery</li>
                </ul>
            </div>
            <div class="p-8 rounded-3xl bg-white dark:bg-slate-800 border border-primary/5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">storefront</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">For Nursery Owners</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Digitize your stock, reach a wider audience beyond your local region, and manage orders with our easy-to-use professional dashboard designed for Moroccan growers.
                </p>
                <ul class="mt-6 space-y-3">
                    <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Inventory management</li>
                    <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Sales analytics</li>
                    <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Marketing visibility</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Featured Nurseries -->
    <section class="bg-primary/5 px-6 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h2 class="text-3xl font-extrabold mb-2">Featured Nurseries</h2>
                    <p class="text-slate-600 dark:text-slate-400">Discover the finest botanical collections from top-rated local growers.</p>
                </div>
                <a class="text-primary font-bold flex items-center gap-1 hover:underline underline-offset-4" href="{{ route('nurseries.index') }}">
                    View All Nurseries <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Nursery 1 -->
                <div class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-cover bg-center group-hover:scale-110 transition-transform duration-500" style="background-image: url('https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&q=80')"></div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-1">Atlas Green Haven</h4>
                        <p class="text-slate-500 dark:text-slate-400 flex items-center gap-1 text-sm mb-4">
                            <span class="material-symbols-outlined text-sm text-primary">location_on</span> Marrakech-Safi Region
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400 text-sm">450+ Plants</span>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                                <span class="font-bold text-sm">4.9</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nursery 2 -->
                <div class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-cover bg-center group-hover:scale-110 transition-transform duration-500" style="background-image: url('https://images.unsplash.com/photo-1592150621344-82454a99d7b4?auto=format&fit=crop&q=80')"></div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-1">Coastal Blooms</h4>
                        <p class="text-slate-500 dark:text-slate-400 flex items-center gap-1 text-sm mb-4">
                            <span class="material-symbols-outlined text-sm text-primary">location_on</span> Casablanca-Settat
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400 text-sm">320+ Plants</span>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                                <span class="font-bold text-sm">4.7</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nursery 3 -->
                <div class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-cover bg-center group-hover:scale-110 transition-transform duration-500" style="background-image: url('https://images.unsplash.com/photo-1530667912788-f976e8ee0bd5?auto=format&fit=crop&q=80')"></div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-1">Rif Mountain Roots</h4>
                        <p class="text-slate-500 dark:text-slate-400 flex items-center gap-1 text-sm mb-4">
                            <span class="material-symbols-outlined text-sm text-primary">location_on</span> Tangier-Tetouan-Al Hoceima
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400 text-sm">280+ Plants</span>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                                <span class="font-bold text-sm">4.8</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Chatla? -->
    <section class="px-6 py-16 lg:py-24 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Why Choose Chatla?</h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">We combine traditional expertise with modern technology to provide the best plant-buying experience.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-12">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
                </div>
                <h3 class="text-xl font-bold mb-3">Guaranteed Trust</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Every nursery on our platform undergoes a verification process to ensure plant quality and healthy specimens.
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">inventory_2</span>
                </div>
                <h3 class="text-xl font-bold mb-3">Centralized Inventory</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Access thousands of plant varieties from different nurseries all in one place. No more driving for hours.
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl">psychology</span>
                </div>
                <h3 class="text-xl font-bold mb-3">Local Expertise</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Get advice tailored to the Moroccan climate. Our nurseries know exactly what grows best in your specific region.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-6 py-12 lg:py-24">
        <div class="max-w-5xl mx-auto rounded-3xl bg-primary px-8 py-16 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[200px]">forest</span>
            </div>
            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl md:text-5xl font-black tracking-tight">Join the Green Revolution</h2>
                <p class="text-primary-foreground/90 text-lg md:text-xl max-w-2xl mx-auto">
                    Whether you're looking to beautify your home or scale your nursery business, Chatla is here to help you grow.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <span class="text-white font-bold text-lg">You're already part of the community! 🌱</span>
                    @else
                        <a href="{{ route('register', ['role' => 'simple']) }}" class="w-full sm:w-auto bg-white text-primary px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-slate-100 transition-all shadow-xl text-center">
                            Sign Up Now
                        </a>
                        <button class="w-full sm:w-auto bg-primary/20 backdrop-blur-sm border border-white/30 text-white px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-primary/30 transition-all">
                            Learn More
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-slate-900 text-slate-300 px-6 py-16 lg:px-20 border-t border-slate-800">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="col-span-1 md:col-span-1 space-y-6">
            <div class="flex items-center gap-2 text-white">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-lg">spa</span>
                </div>
                <h2 class="text-xl font-bold">Chatla</h2>
            </div>
            <p class="text-sm leading-relaxed">
                The Kingdom's leading digital platform for nurseries and garden enthusiasts. Growing together since 2024.
            </p>
            <div class="flex gap-4">
                <a class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors" href="#">
                    <span class="material-symbols-outlined">public</span>
                </a>
                <a class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors" href="#">
                    <span class="material-symbols-outlined">alternate_email</span>
                </a>
            </div>
        </div>
        <div>
            <h4 class="text-white font-bold mb-6">Explore</h4>
            <ul class="space-y-4 text-sm">
                <li><a class="hover:text-primary transition-colors" href="#">All Plants</a></li>
                <li><a class="hover:text-primary transition-colors" href="#">Succulents</a></li>
                <li><a class="hover:text-primary transition-colors" href="#">Fruit Trees</a></li>
                <li><a class="hover:text-primary transition-colors" href="#">Ornamental</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-bold mb-6">Partnerships</h4>
            <ul class="space-y-4 text-sm">
                <li><a class="hover:text-primary transition-colors" href="{{ route('register', ['role' => 'nursery_owner']) }}">For Nurseries</a></li>
                <li><a class="hover:text-primary transition-colors" href="#">Landscaping Pro</a></li>
                <li><a class="hover:text-primary transition-colors" href="#">Wholesale</a></li>
                <li><a class="hover:text-primary transition-colors" href="#">Success Stories</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-bold mb-6">Contact</h4>
            <ul class="space-y-4 text-sm">
                <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">mail</span> contact@chatla.ma</li>
                <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">phone</span> +212 5XX-XXXXXX</li>
                <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">location_on</span> Casablanca, Morocco</li>
            </ul>
        </div>
    </div>
    <div class="max-w-7xl mx-auto pt-16 mt-16 border-t border-slate-800 text-center text-xs">
        <p>© 2024 Chatla Morocco. All rights reserved. Made with 🌿 in Casablanca.</p>
    </div>
</footer>

</body>
</html>
