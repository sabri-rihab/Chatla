<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $nursery->name }} - Chatla</title>
    <base href="/">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
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
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100">
<div class="relative flex min-h-screen flex-col overflow-x-hidden">

    <!-- Top Navigation Bar (Official Chatla Header) -->
    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-4 md:px-10 lg:px-20 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-slate-900 dark:text-white font-bold text-xl">
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

    <main class="max-w-7xl mx-auto w-full px-4 md:px-10 py-6">
        <!-- Breadcrumbs -->
        <!-- <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-6 font-medium">
            <a class="hover:text-primary" href="{{ url('/') }}">Home</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <a class="hover:text-primary" href="{{ route('explore') }}">Explore</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-slate-900 dark:text-slate-100 font-bold underline decoration-primary/30 underline-offset-4">{{ $nursery->name }}</span>
        </nav> -->

        <!-- Nursery Hero Profile -->
        <section class="bg-white dark:bg-slate-900 rounded-3xl p-6 md:p-8 shadow-sm border border-primary/5 mb-8">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="relative group">
                    <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl overflow-hidden bg-primary/10 border-4 border-white dark:border-slate-800 shadow-lg">
                        @php
                            $nurseryLogo = $nursery->profile_img ? asset('storage/' . $nursery->profile_img) : 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80';
                        @endphp
                        <img class="w-full h-full object-cover" src="{{ $nurseryLogo }}" alt="{{ $nursery->name }}"/>
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-primary text-white p-1.5 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">verified</span>
                    </div>
                </div>
                <div class="flex-1 space-y-4">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                                {{ $nursery->name }}
                                
                                <span class="bg-amber-100 text-amber-600 text-sm px-2 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1">star</span>
                                    <!-- {{ number_format($nursery->ratings()->avg('rate') ?? 0, 1) }} -->
                                      {{ $nursery->average_rating }}
                                </span>
                            </h1>                            <p class="text-primary font-medium mt-1">{{ $nursery->city->name ?? 'Morocco' }}</p>
                            <p class="text-slate-600 dark:text-slate-400 mt-2 max-w-2xl">
                                {{ $nursery->custom_description ?? 'Specializing in Mediterranean flora and exotic varieties. Providing the highest quality plants with sustainable nursery practices.' }}
                            </p>
                        </div>
                        <!-- rating section -->
                        <div class="flex flex-col items-start md:items-end gap-2">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Rate this Nursery</p>
                            <div class="relative">
                                <form action="{{ route('public.nurseries.rate', $nursery) }}" method="POST" class="inline-block">
                                    @csrf
                                    
                                    @php
                                        // Find the user's current rating if they are logged in
                                        $currentRating = auth()->check() ? $nursery->ratings()->where('user_id', auth()->id())->value('rate') : null;
                                    @endphp

                                    <select name="rate" onchange="this.form.submit()" class="appearance-none bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl pl-4 pr-10 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary cursor-pointer shadow-sm hover:border-primary/50 transition-all">
                                        <option value="" {{ is_null($currentRating) ? 'selected' : '' }}>Rate...</option>
                                        <option value="1" {{ $currentRating == 1 ? 'selected' : '' }}>⭐</option>
                                        <option value="2" {{ $currentRating == 2 ? 'selected' : '' }}>⭐⭐</option>
                                        <option value="3" {{ $currentRating == 3 ? 'selected' : '' }}>⭐⭐⭐</option>
                                        <option value="4" {{ $currentRating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐</option>
                                        <option value="5" {{ $currentRating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
                                    </select>
                                </form>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none">expand_more</span>
                            </div>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-xl">call</span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Phone</p>
                                <p class="text-sm font-medium">{{ $nursery->phone }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-xl">mail</span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Email</p>
                                <p class="text-sm font-medium">{{ $nursery->owner->email ?? 'contact@chatla.ma' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-xl">location_on</span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Address</p>
                                <p class="text-sm font-medium">{{ $nursery->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Catalog Section -->
        <form id="filter-form" action="{{ route('public.nurseries.show', $nursery) }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar: Filters and Info -->
            <aside class="space-y-8">
                <!-- Internal Search & Filters -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-primary/5 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-lg">Filters</h3>
                        <a href="{{ route('public.nurseries.show', $nursery) }}" onclick="localStorage.removeItem('recent_family_nursery')" class="text-xs text-primary hover:underline">Reset</a>
                    </div>
                    <div class="space-y-4">
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Search in Catalog</span>
                            <div class="mt-1 relative">
                                <input name="search" value="{{ request('search') }}" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:ring-primary focus:border-primary" placeholder="Search e.g. 'Palm'..." type="text"/>
                                <span class="material-symbols-outlined absolute right-3 top-2 text-slate-400 text-lg">search</span>
                            </div>
                        </label>

                        <!-- Localisation Filter -->
                        <div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Localisation (City)</span>
                            <div class="mt-2 relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                <input type="text" id="city-search" list="cities-data" autocomplete="off" placeholder="Search city..." class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-700 border-none rounded-xl text-xs placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 transition-all"/>
                                <datalist id="cities-data">
                                    @foreach($allCities ?? [] as $city)
                                        <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div id="recent-city-container" class="mt-3 space-y-2">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                        
                        <!-- Explore Style Family Filter -->
                        <div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Botanical Family</span>
                            <div class="mt-2 relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                <input type="text" id="family-search" list="families-data" placeholder="Search family..." class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-700 border-none rounded-xl text-xs placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 transition-all"/>
                                <datalist id="families-data">
                                    @foreach($allFamilies as $family)
                                        <option value="{{ $family->name }}" data-id="{{ $family->id }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div id="recent-family-container" class="mt-3 space-y-2">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Stock Status</span>
                            <div class="mt-2 space-y-2">
                                @foreach(['in_stock' => 'In Stock', 'pre_order' => 'Pre-order', 'out_of_stock' => 'Out of Stock'] as $val => $label)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="stock_status[]" value="{{ $val }}" 
                                            {{ in_array($val, (array)request('stock_status')) ? 'checked' : '' }}
                                            onchange="document.getElementById('filter-form').submit()"
                                            class="rounded text-primary focus:ring-primary border-slate-300"/>
                                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-primary/5">
                    <h3 class="font-bold text-lg mb-4">Operating Hours</h3>
                    <ul class="space-y-2 text-sm">
                        @php
                            $hours = explode(' · ', $nursery->operating_hours ?? 'Mon-Fri: 08:30 AM - 18:30 PM · Sat: 09:00 AM - 17:00 PM · Sun: Closed');
                        @endphp
                        @foreach($hours as $hour)
                            @php $parts = explode(': ', $hour); @endphp
                            <li class="flex justify-between">
                                <span class="text-slate-500">{{ $parts[0] }}</span> 
                                <span class="font-medium {{ strpos($hour, 'Closed') !== false ? 'text-red-500 font-bold' : '' }}">
                                    {{ $parts[1] ?? '' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Map Section -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-primary/5">
                    <h3 class="font-bold text-lg mb-4 px-2">Location</h3>
                    <div class="h-48 w-full bg-slate-100 dark:bg-slate-800 rounded-xl overflow-hidden relative group">
                        <div class="absolute inset-0 bg-primary/5 mix-blend-multiply transition-colors group-hover:bg-transparent"></div>
                        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&q=80" alt="Map view"/>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <span class="material-symbols-outlined text-primary text-4xl drop-shadow-md">location_on</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-3 px-2">{{ $nursery->address }}</p>
                </div>
            </aside>

            <!-- Plant Grid -->
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Catalog <span class="text-slate-400 font-normal text-lg ml-2">({{ $catalog->total() }} plants)</span></h2>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500">Sort by:</span>
                        <select name='sort' onchange="document.getElementById('filter-form').submit()" class="bg-transparent border-none text-sm font-semibold focus:ring-0 text-primary cursor-pointer">
                            <option value="a-z" {{ request('sort') === 'a-z' ? 'selected' : '' }}>A-Z</option>
                            <option value="z-a" {{ request('sort') === 'z-a' ? 'selected' : '' }}>Z-A</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($catalog as $inventory)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-primary/5 hover:shadow-xl hover:-translate-y-1 transition-all group">
                        <a href="{{ route('public.plants.show', $inventory) }}" class="h-64 relative overflow-hidden bg-slate-50 dark:bg-slate-800/50 block">
                            @php
                                $firstImage = $inventory->images->first();
                                $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://images.unsplash.com/photo-1599599810694-d5c4d7e4c0f5?auto=format&fit=crop&q=80';
                            @endphp
                            <img class="w-full h-full object-cover transition-transform group-hover:scale-105" src="{{ $imageUrl }}" alt="{{ $inventory->plant->name }}"/>
                            
                            <div class="absolute top-3 right-3 px-2.5 py-1 backdrop-blur-md rounded-lg text-xs font-bold border border-white/20
                                {{ $inventory->stock_status === 'out_of_stock' ? 'text-red-500 bg-red-500/10' : 'text-primary bg-white/90 dark:bg-slate-900/90' }}">
                                <span class="w-2 h-2 rounded-full {{ $inventory->stock_status === 'out_of_stock' ? 'bg-red-500' : 'bg-emerald-500 animate-pulse' }}"></span>
                                {{ str_replace('_', ' ', $inventory->stock_status) }}
                            </div>

                        </a>
                        <div class="p-5 text-left">
                            <p class="text-xs text-primary font-bold uppercase tracking-wider">{{ $inventory->plant->family->name ?? 'Botanical' }}</p>
                            <a href="{{ route('public.plants.show', $inventory) }}" class="block">
                                <h4 class="text-lg font-bold mt-1 group-hover:text-primary transition-colors leading-tight">{{ $inventory->plant->name }}</h4>
                            </a>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">{{ $inventory->custom_description ?? $inventory->plant->about_description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold">{{ number_format($inventory->price, 0) }} MAD</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-10 text-center text-slate-400">
                        <span class="material-symbols-outlined text-4xl mb-2">inventory_2</span>
                        <p>No plants match your criteria.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $catalog->links() }}
                </div>
            </div>
        </form>
    </main>

    <!-- Footer (Matched to Login/Register) -->
    <footer class="mt-auto px-4 md:px-10 py-8 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                <div class="w-6 h-6 rounded bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-[14px]">spa</span>
                </div>
                <p class="text-xs font-bold tracking-wider capitalize">Chatla © {{ date('Y') }}</p>
            </div>
            <div class="flex gap-8 text-xs font-bold text-slate-500 dark:text-slate-400 tracking-widest">
                <a class="hover:text-primary transition-colors" href="#">TERMS</a>
                <a class="hover:text-primary transition-colors" href="#">PRIVACY</a>
                <a class="hover:text-primary transition-colors" href="#">COOKIES</a>
            </div>
        </div>
    </footer>
</div>

<script>
    const RECENT_LIMIT = 3;

    function updateRecent(type, id, name) {
        let recent = JSON.parse(localStorage.getItem(`recent_${type}_nursery`) || '[]');
        recent = recent.filter(item => item.id !== id);
        recent.unshift({ id, name });
        if (recent.length > RECENT_LIMIT) recent.pop();
        localStorage.setItem(`recent_${type}_nursery`, JSON.stringify(recent));
    }

    function renderRecent(type, paramName) {
        const container = document.getElementById(`recent-${type}-container`);
        const recent = JSON.parse(localStorage.getItem(`recent_${type}_nursery`) || '[]');
        const urlParams = new URL(window.location.href).searchParams;
        const checkedIds = urlParams.getAll(`${paramName}[]`);

        if (recent.length === 0) {
            container.innerHTML = '';
            return;
        }

        container.innerHTML = recent.map(item => `
            <label class="flex items-center gap-2 cursor-pointer group animate-in fade-in slide-in-from-left-1 duration-300">
                <input type="checkbox" name="${paramName}[]" value="${item.id}" 
                    ${checkedIds.includes(String(item.id)) ? 'checked' : ''}
                    onchange="document.getElementById('filter-form').submit()"
                    class="rounded text-primary focus:ring-primary border-slate-300 text-xs"/>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-900 transition-colors">${item.name}</span>
            </label>
        `).join('');
    }

    function setupSearchable(inputId, datalistId, type, paramName) {
        const input = document.getElementById(inputId);
        const datalist = document.getElementById(datalistId);

        input.addEventListener('change', (e) => {
            const val = e.target.value;
            const option = Array.from(datalist.options).find(opt => opt.value === val);
            if (option) {
                const id = option.getAttribute('data-id');
                updateRecent(type, id, val);
                
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `${paramName}[]`;
                hiddenInput.value = id;
                document.getElementById('filter-form').appendChild(hiddenInput);
                
                document.getElementById('filter-form').submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderRecent('city', 'cities');
        renderRecent('family', 'families');
        setupSearchable('city-search', 'cities-data', 'city', 'cities');
        setupSearchable('family-search', 'families-data', 'family', 'families');
    });
</script>
</body>
</html>
