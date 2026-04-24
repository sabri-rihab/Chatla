<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
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
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    <title>{{ $inventory->plant->name }} - Chatla</title>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

    <!-- Top Navigation Bar (Official Chatla Header) -->
    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-4 md:px-10 lg:px-20 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-slate-900 font-bold text-xl">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-lg">spa</span>
                </div>
                <h2 class="text-primary text-xl font-bold tracking-tight">Chatla</h2>
            </a>
            <nav class="hidden md:flex items-center gap-8">
                @if(auth()->check() && auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Dashboard_admin</a>
                @else
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Home</a>
                @endif
                <a href="{{ route('nurseries.index') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Nurseries</a>
                <a href="{{ route('explore') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Explore</a>
                @if(auth()->check() && auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                    <a href="{{ route('admin.requests') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Requests</a>
                @else
                    <a href="{{ route('contact') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Contact us</a>
                @endif
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Login</a>
                @endauth
            </nav>
            <button class="md:hidden text-primary"><span class="material-symbols-outlined">menu</span></button>
        </div>
    </header>

    <main class="max-w-[1280px] mx-auto w-full px-6 md:px-10 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-8">
            <a class="hover:text-primary" href="{{ url('/') }}">Home</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <a class="hover:text-primary" href="{{ route('explore') }}">{{ $inventory->plant->family->name ?? 'Plants' }}</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-primary font-medium">{{ $inventory->plant->name }}</span>
        </nav>

        <!-- Featured Farm Photo Section -->
        <div class="mb-12 bg-white dark:bg-slate-800 rounded-xl border border-primary/10 overflow-hidden shadow-sm">
            <div class="flex flex-col sm:flex-row gap-0">
                <!-- Left: Farm Photo -->
                <div class="sm:w-2/5 h-72 sm:h-auto min-h-[280px] relative overflow-hidden flex-shrink-0">
                    @php
                        $mainImage = $inventory->images->first() ? asset('storage/' . $inventory->images->first()->image_path) : 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80';
                    @endphp
                    <img src="{{ $mainImage }}" alt="{{ $inventory->plant->name }}" class="w-full h-full object-cover"/>
                    <!-- Farm photo overlay tag -->
                    <div class="absolute bottom-3 left-3 bg-white/15 backdrop-blur-md border border-white/25 text-white text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                        <span class="material-symbols-outlined" style="font-size:14px">photo_camera</span>
                        Taken at our farm
                    </div>
                </div>

                <!-- Right: Info -->
                <div class="flex-1 p-6 md:p-8 flex flex-col justify-between">
                    <div>
                        <p class="text-xs text-primary font-bold uppercase tracking-widest mb-2">Featured Product</p>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3">
                            Healthy {{ $inventory->plant->name }}
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-4">
                            {{ $inventory->custom_description ?? $inventory->plant->about_description }}
                        </p>
                        
                        <!-- Quick Care Icons -->
                        <div class="flex flex-wrap gap-4 mt-5">
                            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <span class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined" style="font-size:16px">light_mode</span>
                                </span>
                                {{ $inventory->plant->light_need ?? 'Bright indirect light' }}
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <span class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined" style="font-size:16px">water_drop</span>
                                </span>
                                {{ $inventory->plant->watering ?? '1-2 weeks watering' }}
                            </div>
                        </div>
                    </div>

                    <!-- Price & CTA -->
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 flex items-end justify-between gap-4 flex-wrap">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Price</p>
                            <span class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white">{{ number_format($inventory->price, 0) }}</span>
                            <span class="text-lg font-semibold text-slate-500 ml-1">MAD</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('public.nurseries.show', $inventory->nursery) }}" class="px-4 py-2.5 rounded-lg border border-primary/20 text-primary font-semibold text-sm hover:bg-primary/5 transition-colors">
                                Visit Nursery
                            </a>
                            <button class="px-4 py-2.5 rounded-lg bg-primary text-white font-semibold text-sm hover:bg-primary/90 transition-colors shadow-md flex items-center gap-2">
                                <span class="material-symbols-outlined" style="font-size:18px">add_shopping_cart</span>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Column: Image Gallery & Details -->
            <div class="flex-1 space-y-8">
                <div class="space-y-4">
                    <div class="aspect-[4/3] w-full rounded-xl overflow-hidden bg-slate-200 shadow-sm">
                        <img id="main-image" class="w-full h-full object-cover" src="{{ $mainImage }}" alt="{{ $inventory->plant->name }}"/>
                    </div>
                    @if($inventory->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($inventory->images as $index => $image)
                        <div class="aspect-square rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-primary ring-2 ring-primary/20' : 'cursor-pointer hover:opacity-80 transition-opacity' }} gallery-thumb" data-src="{{ asset('storage/' . $image->image_path) }}">
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $image->image_path) }}" alt="Thumbnail"/>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="bg-white dark:bg-slate-800/50 p-6 md:p-8 rounded-xl border border-primary/10">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $inventory->plant->name }}</h1>
                            <p class="text-primary font-medium italic">{{ $inventory->plant->family->name ?? 'Araceae' }} Family</p>
                        </div>
                    </div>
                    <div class="prose dark:prose-invert max-w-none">
                        <h3 class="text-lg font-semibold mb-3">About this plant</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                            {{ $inventory->plant->about_description }}
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary">light_mode</span>
                                <div>
                                    <p class="font-semibold text-sm">Light Needs</p>
                                    <p class="text-sm text-slate-500">{{ $inventory->plant->light_need ?? 'Bright, indirect sunlight' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary">water_drop</span>
                                <div>
                                    <p class="font-semibold text-sm">Watering</p>
                                    <p class="text-sm text-slate-500">{{ $inventory->plant->watering ?? 'Every 1-2 weeks' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary">device_thermostat</span>
                                <div>
                                    <p class="font-semibold text-sm">Temperature</p>
                                    <p class="text-sm text-slate-500">{{ $inventory->plant->temperature ?? '18°C - 30°C' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary">pets</span>
                                <div>
                                    <p class="font-semibold text-sm">Pet Friendly</p>
                                    <p class="text-sm text-slate-500">{{ $inventory->plant->pet_friendly ? 'Pet Friendly' : 'Toxic if ingested' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Nursery Sidebar -->
            <aside class="lg:w-[360px] space-y-6">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-primary/10 shadow-sm sticky top-28">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden bg-primary/10 border-2 border-primary/20">
                            @php
                                $logo = $inventory->nursery->profile_img ? asset('storage/' . $inventory->nursery->profile_img) : 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80';
                            @endphp
                            <img class="w-full h-full object-cover" src="{{ $logo }}" alt="{{ $inventory->nursery->name }} logo"/>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $inventory->nursery->name }}</h3>
                            <div class="flex items-center text-primary text-sm">
                                <span class="material-symbols-outlined text-sm">verified</span>
                                <span class="ml-1">Certified Partner</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400">location_on</span>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $inventory->nursery->address }}, {{ $inventory->nursery->city->name ?? 'Morocco' }}</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400">call</span>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $inventory->nursery->phone }}</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400">schedule</span>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Mon - Sat: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                    <div class="w-full h-40 rounded-lg overflow-hidden mb-6 bg-slate-100 relative">
                        <!-- Map Placeholder -->
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary/10 via-transparent to-transparent opacity-50"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="bg-white dark:bg-slate-900 p-2 rounded-full shadow-lg border border-primary/20">
                                <span class="material-symbols-outlined text-primary text-3xl">location_on</span>
                            </div>
                        </div>
                        <img class="w-full h-full object-cover opacity-60" src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&q=80&w=400" alt="Map view"/>
                    </div>
                    <div class="flex flex-col gap-3">
                        <button class="w-full py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-xl">chat</span>
                            Inquiry
                        </button>
                        <a href="{{ route('public.nurseries.show', $inventory->nursery) }}" class="w-full py-3 bg-primary/10 text-primary rounded-xl font-bold hover:bg-primary/20 transition-all text-center">
                            Contact Nursery
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Care Guide Section -->
        <section class="mt-16 border-t border-primary/10 pt-12">
            <h2 class="text-2xl font-bold mb-8">Care Guide for your {{ $inventory->plant->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-primary/10">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined">sunny</span>
                    </div>
                    <h4 class="font-bold mb-2">Sun Exposure</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $inventory->plant->sun_exposure ?? 'Avoid direct hot afternoon sun as it can burn the leaves. Filtered morning light is ideal.' }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-primary/10">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined">eco</span>
                    </div>
                    <h4 class="font-bold mb-2">Leaf Care</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $inventory->plant->leaf_care ?? 'Wipe leaves with a damp cloth every few weeks to keep them dust-free and shiny.' }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-primary/10">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined">height</span>
                    </div>
                    <h4 class="font-bold mb-2">Support</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $inventory->plant->support_instructions ?? 'As a climber, it loves a moss pole to attach its aerial roots to for stability.' }}</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer (Official Login-page Style) -->
    <footer class="mt-auto px-4 md:px-10 py-8 border-t border-slate-100 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-6 h-6 rounded bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-[14px]">spa</span>
                </div>
                <p class="text-xs font-bold tracking-wider">CHATLA © {{ date('Y') }}</p>
            </div>
            <div class="flex gap-8 text-xs font-bold text-slate-500 tracking-widest">
                <a class="hover:text-primary transition-colors" href="#">TERMS</a>
                <a class="hover:text-primary transition-colors" href="#">PRIVACY</a>
                <a class="hover:text-primary transition-colors" href="#">COOKIES</a>
            </div>
        </div>
    </footer>
</div>

<script>
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const newSrc = this.getAttribute('data-src');
            document.getElementById('main-image').src = newSrc;
            
            // Update borders
            document.querySelectorAll('.gallery-thumb').forEach(t => {
                t.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
                t.classList.add('cursor-pointer', 'hover:opacity-80');
            });
            this.classList.add('border-primary', 'ring-2', 'ring-primary/20');
            this.classList.remove('cursor-pointer', 'hover:opacity-80');
        });
    });
</script>
</body>
</html>
