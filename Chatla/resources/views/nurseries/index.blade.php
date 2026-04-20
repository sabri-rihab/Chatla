<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Nurseries - Chatla 🌱</title>

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
                        "background-light": "#f9fafa",
                        "background-dark": "#161d15",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                    borderRadius: { "DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        .nursery-card { animation: fadeUp 0.4s ease both; }
        .nursery-card:nth-child(1) { animation-delay: 0.05s; }
        .nursery-card:nth-child(2) { animation-delay: 0.10s; }
        .nursery-card:nth-child(3) { animation-delay: 0.15s; }
        .nursery-card:nth-child(4) { animation-delay: 0.20s; }
        .nursery-card:nth-child(5) { animation-delay: 0.25s; }
        .nursery-card:nth-child(6) { animation-delay: 0.30s; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-background-light font-display text-slate-900 min-h-screen flex flex-col">

    {{-- ── Header (Login-page style) ──────────────────────────────────── --}}
    <nav class="w-full bg-white h-20 px-4 md:px-10 flex items-center justify-between border-b border-slate-100 sticky top-0 z-50">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-slate-900 font-bold text-xl">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">spa</span>
            </div>
            Chatla
        </a>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
            <a href="{{ route('nurseries.index') }}" class="text-primary font-bold transition-colors">Nurseries</a>
            <a href="{{ route('explore') }}" class="hover:text-primary transition-colors">Explore</a>
            <a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Contact us</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Login</a>
            @endauth
        </div>
        <button class="md:hidden text-primary"><span class="material-symbols-outlined">menu</span></button>
    </nav>

    {{-- ── Page Body ─────────────────────────────────────────────────── --}}
    <form id="filter-form" action="{{ route('nurseries.index') }}" method="GET"
          class="max-w-7xl mx-auto w-full px-4 lg:px-8 py-10 flex gap-8 flex-1">

        {{-- ── Sidebar Filters ─────────────────────────────────────── --}}
        <aside class="hidden lg:block w-72 shrink-0">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 sticky top-24">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-slate-900">Filters</h3>
                    <a href="{{ route('nurseries.index') }}"
                       onclick="localStorage.removeItem('recent_city_nurseries')"
                       class="bg-slate-50 text-slate-600 px-4 py-1.5 rounded-full text-xs font-bold border border-slate-200 hover:bg-slate-100 transition-all">Reset</a>
                </div>

                {{-- City Filter --}}
                <div class="mb-8">
                    <h4 class="text-[10px] font-black tracking-[0.2em] text-slate-400 mb-4 uppercase">City</h4>
                    <div class="relative mb-4">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                        <input type="text" id="city-search" list="cities-data" autocomplete="off"
                               placeholder="Search city..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 transition-all"/>
                        <datalist id="cities-data">
                            @foreach($allCities as $city)
                                <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div id="recent-city-container" class="space-y-4">
                        {{-- Populated by JS --}}
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                    Apply Filters
                </button>
            </div>
        </aside>

        {{-- ── Main Content ─────────────────────────────────────────── --}}
        <main class="flex-1 min-w-0">

            {{-- Search Bar --}}
            <div class="relative mb-8">
                <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search nursery name..."
                       class="w-full pl-14 pr-6 py-4 rounded-2xl bg-white border border-slate-200 shadow-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all text-base"/>
            </div>

            {{-- Results Count --}}
            <div class="mb-6">
                <h2 class="text-2xl font-black text-slate-900">
                    <span class="text-primary mr-1">{{ $nurseries->total() }}</span>Nurseries found
                </h2>
            </div>

            {{-- Nursery Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($nurseries as $nursery)
                    @php
                        $logo = $nursery->profile_img
                            ? asset('storage/' . $nursery->profile_img)
                            : 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80&w=400';
                        $plantCount = $nursery->inventory()->count();
                    @endphp
                    <a href="{{ route('public.nurseries.show', $nursery) }}"
                       class="nursery-card bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">

                        {{-- Logo Banner --}}
                        <div class="h-48 relative overflow-hidden bg-primary/5">
                            <img src="{{ $logo }}" alt="{{ $nursery->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                            @if($nursery->rating)
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-yellow-400 text-base" style="font-variation-settings:'FILL' 1">star</span>
                                    <span class="text-xs font-bold text-slate-800">{{ number_format($nursery->rating, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-5">
                            <h3 class="text-base font-bold text-slate-900 mb-1 leading-snug group-hover:text-primary transition-colors">
                                {{ $nursery->name }}
                            </h3>
                            <div class="flex items-center gap-1.5 text-slate-500 text-sm mb-4">
                                <span class="material-symbols-outlined text-primary text-base">location_on</span>
                                <span>{{ $nursery->city->name ?? 'Morocco' }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs text-slate-400">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-primary text-sm">potted_plant</span>
                                    {{ $plantCount }} {{ Str::plural('plant', $plantCount) }}
                                </span>
                                <span class="text-primary font-semibold group-hover:underline">View catalog →</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-primary text-4xl">search_off</span>
                        </div>
                        <p class="text-xl font-bold text-slate-700 mb-2">No nurseries found</p>
                        <p class="text-slate-500 text-sm">Try adjusting your filters or search term.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $nurseries->links() }}
            </div>
        </main>
    </form>

    {{-- ── Footer (Login-page style) ───────────────────────────────── --}}
    <footer class="mt-auto px-4 md:px-10 py-8 border-t border-slate-100 bg-white">
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

</body>

{{-- ── JS: Recent-3 city checkbox logic (same as Explore) ─────────── --}}
<script>
    const RECENT_LIMIT = 3;
    const STORAGE_KEY  = 'recent_city_nurseries';

    function updateRecent(id, name) {
        let recent = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        recent = recent.filter(item => item.id !== id);
        recent.unshift({ id, name });
        if (recent.length > RECENT_LIMIT) recent.pop();
        localStorage.setItem(STORAGE_KEY, JSON.stringify(recent));
    }

    function renderRecent() {
        const container  = document.getElementById('recent-city-container');
        const recent     = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        const urlParams  = new URL(window.location.href).searchParams;
        const checkedIds = urlParams.getAll('cities[]');

        if (recent.length === 0) { container.innerHTML = ''; return; }

        container.innerHTML = recent.map(item => `
            <label class="flex items-center gap-3 cursor-pointer group">
                <div class="relative flex items-center justify-center">
                    <input type="checkbox" name="cities[]" value="${item.id}"
                        ${checkedIds.includes(String(item.id)) ? 'checked' : ''}
                        onchange="document.getElementById('filter-form').submit()"
                        class="peer appearance-none w-5 h-5 rounded border-2 border-slate-200 checked:bg-primary checked:border-primary transition-all"/>
                    <span class="material-symbols-outlined absolute text-white text-sm scale-0 peer-checked:scale-100 transition-transform">check</span>
                </div>
                <span class="text-sm font-medium text-slate-600 group-hover:text-slate-900 transition-colors">${item.name}</span>
            </label>
        `).join('');
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderRecent();

        const cityInput   = document.getElementById('city-search');
        const citiesData  = document.getElementById('cities-data');

        cityInput.addEventListener('change', (e) => {
            const val    = e.target.value;
            const option = Array.from(citiesData.options).find(opt => opt.value === val);
            if (option) {
                const id = option.getAttribute('data-id');
                updateRecent(id, val);

                const hidden  = document.createElement('input');
                hidden.type   = 'hidden';
                hidden.name   = 'cities[]';
                hidden.value  = id;
                document.getElementById('filter-form').appendChild(hidden);

                document.getElementById('filter-form').submit();
            }
        });
    });
</script>
</html>
