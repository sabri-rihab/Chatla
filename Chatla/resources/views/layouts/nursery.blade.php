<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nursery Admin Dashboard - Chatla')</title>
    
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
                        "primary-light": "#eaf3e8",
                        "bg-page": "#f6f7f6",
                        "background-light": "#f6f7f6",
                        "background-dark": "#161d15",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"], "sans": ["Inter", "sans-serif"] },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }
        .mat { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .mat-fill, .matf { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width:5px; height:5px; }
        ::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:9999px; }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light font-display text-slate-900">
    <div class="flex h-screen overflow-hidden">
        
        @include('layouts.partials.nursery-sidebar')

        <div class="flex flex-col flex-1 overflow-hidden">
            
            @section('header')
                <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
                    <!-- Search -->
                    <div class="relative w-72">
                        <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                        @hasSection('search_input')
                            @yield('search_input')
                        @else
                            <input type="text" placeholder="Search plants, orders, or leads..."
                                   class="w-full bg-background-light border-none rounded-full py-2 pl-10 pr-4 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 outline-none" />
                        @endif
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center gap-4">
                        <button class="text-slate-400 hover:text-primary transition-colors p-1.5 relative">
                            <span class="material-symbols-outlined mat text-[22px]">notifications</span>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <div class="h-6 w-px bg-slate-200"></div>
                        <div class="flex items-center gap-2.5">
                            <div class="text-right">
                                <p class="text-sm font-semibold leading-tight">{{ auth()->user()->name ?? 'Owner' }}</p>
                                <p class="text-[11px] text-slate-400">Owner</p>
                            </div>
                            @if(auth()->user()->profile_img ?? false)
                                @php
                                    $imgUrl = str_starts_with(auth()->user()->profile_img, 'http') ? auth()->user()->profile_img : asset('storage/' . auth()->user()->profile_img);
                                @endphp
                                <div class="w-9 h-9 rounded-full bg-cover bg-center border border-slate-200" style="background-image: url('{{ $imgUrl }}')"></div>
                            @elseif(auth()->user()->name ?? false)
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 text-primary font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </header>
            @show
            
            <main class="flex-1 overflow-y-auto bg-background-light">
                @yield('content')
            </main>
            
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
