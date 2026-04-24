<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Explore Plants - Chatla 🌱</title>

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
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">

<!-- Top Navigation Bar (Official Chatla Header) -->
<header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-6 lg:px-20 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">spa</span>
            </div>
            <h2 class="text-primary text-xl font-bold tracking-tight">Chatla</h2>
        </div>
        <nav class="hidden md:flex items-center gap-8">
            @if(auth()->check() && auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('admin.dashboard') }}">Dashboard_admin</a>
            @else
                <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ url('/') }}">Home</a>
            @endif
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('nurseries.index') }}">Nurseries</a>
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('explore') }}">Explore</a>
            @if(auth()->check() && auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('admin.requests') }}">Requests</a>
            @else
                <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('contact') }}">Contact us</a>
            @endif
            
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

<main class="flex-grow px-6 lg:px-20 py-8">
    <div class="max-w-7xl mx-auto">
<form id="filter-form" action="{{ route('explore') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 sticky top-24 border border-slate-100 dark:border-slate-700 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Filters</h3>
                        <a href="{{ route('explore') }}" onclick="localStorage.removeItem('recent_city'); localStorage.removeItem('recent_family');" class="bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-4 py-1.5 rounded-full text-xs font-bold border border-slate-200 dark:border-slate-600 hover:bg-slate-100 transition-all text-center">Reset</a>
                    </div>

                    <!-- City -->
                    <div class="mb-10">
                        <h4 class="text-[10px] font-black tracking-[0.2em] text-slate-400 mb-4 uppercase">City</h4>
                        <div class="relative mb-6">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                            <input type="text" id="city-search" list="cities-data" autocomplete="off" placeholder="Search city..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-700 border-none rounded-xl text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 transition-all"/>
                            <datalist id="cities-data">
                                @foreach($allCities as $city)
                                    <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div id="recent-city-container" class="space-y-4">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Plant Family -->
                    <div class="mb-10">
                        <h4 class="text-[10px] font-black tracking-[0.2em] text-slate-400 mb-4 uppercase">Plant Family</h4>
                        <div class="relative mb-6">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                            <input type="text" id="family-search" list="families-data" autocomplete="off" placeholder="Search family..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-700 border-none rounded-xl text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 transition-all"/>
                            <datalist id="families-data">
                                @foreach($allFamilies as $family)
                                    <option value="{{ $family->name }}" data-id="{{ $family->id }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div id="recent-family-container" class="space-y-4">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Growth Stage -->
                    <div class="mb-10">
                        <h4 class="text-[10px] font-black tracking-[0.2em] text-slate-400 mb-4 uppercase">Growth Stage</h4>
                        <div class="space-y-4">
                            @php $stages = ['Seed', 'Seedling', 'Vegetative', 'Mature']; @endphp
                            @foreach($stages as $stage)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" name="growth_stages[]" value="{{ strtolower($stage) }}"
                                        {{ in_array(strtolower($stage), (array)request('growth_stages')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filter-form').submit()"
                                        class="peer appearance-none w-5 h-5 rounded border-2 border-slate-200 dark:border-slate-600 checked:bg-primary checked:border-primary transition-all"/>
                                    <span class="material-symbols-outlined absolute text-white text-sm scale-0 peer-checked:scale-100 transition-transform">check</span>
                                </div>
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">{{ $stage }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                        Apply Filters
                    </button>
                </div>
            </div>

            <script>
                const RECENT_LIMIT = 3;

                function updateRecent(type, id, name) {
                    let recent = JSON.parse(localStorage.getItem(`recent_${type}`) || '[]');
                    recent = recent.filter(item => item.id !== id);
                    recent.unshift({ id, name });
                    if (recent.length > RECENT_LIMIT) recent.pop();
                    localStorage.setItem(`recent_${type}`, JSON.stringify(recent));
                }

                function renderRecent(type, paramName) {
                    const container = document.getElementById(`recent-${type}-container`);
                    const recent = JSON.parse(localStorage.getItem(`recent_${type}`) || '[]');
                    const urlParams = new URL(window.location.href).searchParams;
                    const checkedIds = urlParams.getAll(`${paramName}[]`);

                    if (recent.length === 0) {
                        container.innerHTML = '';
                        return;
                    }

                    container.innerHTML = recent.map(item => `
                        <label class="flex items-center gap-3 cursor-pointer group animate-in fade-in slide-in-from-left-2 duration-300">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" name="${paramName}[]" value="${item.id}" 
                                    ${checkedIds.includes(String(item.id)) ? 'checked' : ''}
                                    onchange="document.getElementById('filter-form').submit()"
                                    class="peer appearance-none w-5 h-5 rounded border-2 border-slate-200 dark:border-slate-600 checked:bg-primary checked:border-primary transition-all"/>
                                <span class="material-symbols-outlined absolute text-white text-sm scale-0 peer-checked:scale-100 transition-transform">check</span>
                            </div>
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">${item.name}</span>
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


            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Large Top Search Bar -->
                <div class="mb-8">
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 text-2xl group-focus-within:text-primary transition-colors">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search plant name or botanical family..." class="w-full pl-16 pr-8 py-5 bg-white dark:bg-slate-800 border-none rounded-full shadow-lg shadow-slate-200/50 dark:shadow-none text-lg placeholder:text-slate-400 focus:ring-4 focus:ring-primary/10 transition-all outline-none"/>
                    </div>
                </div>

                <!-- Results Header -->
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white">
                        <span class="text-slate-400 font-medium">{{ $inventories->total() }}</span> Plants found
                    </h2>
                </div>

                <!-- Plant Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 font-display">
                    @forelse($inventories as $inventory)
                    <div class="group bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-slate-100 dark:border-slate-700">
                        <a href="{{ route('public.plants.show', $inventory) }}" class="relative aspect-square overflow-hidden bg-slate-50 dark:bg-slate-900 block">
                            @php
                                $firstImage = $inventory->images->first();
                                $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://images.unsplash.com/photo-1599599810694-d5c4d7e4c0f5?auto=format&fit=crop&q=80';
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $inventory->plant->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"/>
                            
                            <div class="absolute top-4 right-4 {{ $inventory->stock_status === 'out_of_stock' ? 'bg-red-500/10 text-red-500' : 'bg-primary/10 text-primary' }} backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black tracking-widest uppercase border border-white/20">
                                {{ str_replace('_', ' ', $inventory->stock_status) }}
                            </div>
                        </a>
                        <div class="p-8">
                            <p class="text-[10px] font-black text-primary mb-3 tracking-[0.2em] uppercase">{{ $inventory->plant->family->name ?? 'Unknown Family' }}</p>
                            <a href="{{ route('public.plants.show', $inventory) }}" class="block">
                                <h3 class="text-xl font-bold mb-6 text-slate-900 dark:text-white group-hover:text-primary transition-colors leading-tight">{{ $inventory->plant->name }}</h3>
                            </a>
                            
                            <div class="space-y-3 pt-6 border-t border-slate-50 dark:border-slate-700">
                                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 group/nursery">
                                    <span class="material-symbols-outlined text-lg opacity-60">storefront</span>
                                    <a href="{{ route('public.nurseries.show', $inventory->nursery) }}" class="text-sm font-medium hover:text-primary transition-colors cursor-pointer">
                                        {{ $inventory->nursery->name }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-lg opacity-60">location_on</span>
                                    <span class="text-sm font-medium">{{ $inventory->nursery->city->name ?? 'Unknown City' }}</span>
                                </div>
                            </div>

                            @if($inventory->price)
                            <div class="mt-6 flex items-center justify-between">
                                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ number_format($inventory->price, 2) }} <span class="text-xs font-bold text-slate-400">MAD</span></span>
                                <!-- <button class="w-10 h-10 rounded-full bg-primary/5 text-primary hover:bg-primary hover:text-white transition-all duration-300 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-lg">shopping_cart</span>
                                </button> -->
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center">
                        <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">search_off</span>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No plants found</h3>
                        <p class="text-slate-500">Try adjusting your filters or search terms.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $inventories->links() }}
                </div>
            </div>
            </div>
        </form>
    </div>
</main>

<!-- Footer (Official Chatla Footer) -->
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

</body>
</html>
