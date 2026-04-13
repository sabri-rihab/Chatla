<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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
                    fontFamily: { "display": ["Inter", "sans-serif"] },
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
    <title>{{ auth()->user()->nursery->name ?? 'Chatla' }} - Nursery Admin Dashboard</title>
</head>
<body class="bg-background-light font-display text-slate-900">
<div class="flex h-screen overflow-hidden">

    <!-- ── SIDEBAR ── -->
    <aside class="w-52 flex flex-col bg-white border-r border-slate-100 shrink-0">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100">
            <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center text-white shrink-0">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">psychiatry</span>
            </div>
            <div class="leading-tight">
                <p class="font-bold text-[15px] text-primary">Chatla</p>
                <p class="text-[10px] text-slate-400 font-medium">Nursery Admin</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-5 space-y-0.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">grid_view</span>
                Overview
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-primary/8 hover:text-primary rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[20px]">potted_plant</span>
                My Plants
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-primary/8 hover:text-primary rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                Add New Plant
            </a>
            <a href="{{ route('nursery.profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-primary/8 hover:text-primary rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[20px]">storefront</span>
                Nursery Info
            </a>
        </nav>

        <!-- Settings -->
        <div class="px-3 py-4 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-red-50 hover:text-red-600 rounded-lg text-sm font-medium transition-colors cursor-pointer text-left">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- ── MAIN COLUMN ── -->
    <div class="flex flex-col flex-1 overflow-hidden">

        <!-- ── HEADER ── -->
        <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
            <!-- Search -->
            <div class="relative w-72">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                <input
                    class="w-full bg-background-light border-none rounded-full py-2 pl-10 pr-4 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 outline-none"
                    placeholder="Search plants, orders, or leads..."
                    type="text"
                />
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-4">
                <!-- Bell -->
                <button class="text-slate-400 hover:text-primary transition-colors p-1.5">
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                </button>

                <div class="h-6 w-px bg-slate-200"></div>

                <!-- User -->
                <div class="flex items-center gap-2.5">
                    <div class="text-right">
                        <p class="text-sm font-semibold leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-400">Owner</p>
                    </div>
                    @if(auth()->user()->profile_img)
                        <div class="w-9 h-9 rounded-full bg-cover bg-center border border-slate-200" style="background-image: url('{{ auth()->user()->profile_img }}')"></div>
                    @else
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 text-primary font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- ── PAGE CONTENT ── -->
        <main class="flex-1 overflow-y-auto bg-background-light">
            <div class="p-8 space-y-6">

                <!-- Page title -->
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight">Nursery Overview</h2>
                        <p class="text-slate-500 text-sm mt-1">Good morning, {{ explode(' ', auth()->user()->name)[0] }}. Here's what's happening with your inventory.</p>
                    </div>
                    <button class="bg-primary text-white px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Add New Plant
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-4 gap-5">

                    <div class="bg-white rounded-xl border border-slate-100 p-5">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-4">
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">eco</span>
                        </div>
                        <p class="text-slate-500 text-sm">Total Plants</p>
                        <p class="text-2xl font-bold mt-0.5">{{ $totalPlants ?? 0 }}</p>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-100 p-5">
                        <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-500 mb-4">
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">inventory_2</span>
                        </div>
                        <p class="text-slate-500 text-sm">Out of Stock</p>
                        <p class="text-2xl font-bold mt-0.5">{{ $outOfStock ?? 0 }}</p>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-100 p-5">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500 mb-4">
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">visibility</span>
                        </div>
                        <p class="text-slate-500 text-sm">Total Views</p>
                        <p class="text-2xl font-bold mt-0.5">8.4k</p>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-100 p-5">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500 mb-4">
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">contacts</span>
                        </div>
                        <p class="text-slate-500 text-sm">Monthly Leads</p>
                        <p class="text-2xl font-bold mt-0.5">156</p>
                    </div>

                </div>

                <!-- Plant Inventory Table -->
                <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">

                    <!-- Table header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-4">
                        <h3 class="text-base font-bold">Plant Inventory</h3>
                        <div class="flex items-center gap-2">
                            <button class="flex items-center gap-1.5 text-sm text-slate-600 border border-slate-200 rounded-full px-4 py-1.5 hover:border-primary/40 hover:text-primary transition-colors">
                                All Families
                                <span class="material-symbols-outlined text-[14px]">expand_more</span>
                            </button>
                            <button class="flex items-center gap-1.5 text-sm text-slate-600 border border-slate-200 rounded-full px-4 py-1.5 hover:border-primary/40 hover:text-primary transition-colors">
                                Status: All
                                <span class="material-symbols-outlined text-[14px]">expand_more</span>
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                            <tr class="bg-background-light">
                                <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Plant Name</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Family</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">

                            @forelse($inventories ?? [] as $item)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 py-4">
                                        @php
                                            // Optional default image logic if plant isn't fully seeded, fallback to a placeholder
                                            $imgUrl = 'https://via.placeholder.com/150';
                                        @endphp
                                        <div class="w-11 h-11 rounded-lg bg-cover bg-center border border-slate-100" style="background-image: url('{{ $imgUrl }}')"></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-sm">{{ $item->plant->name ?? 'Unknown Plant' }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $item->plant->family->name ?? 'Unknown Family' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $item->plant->family->name ?? 'None' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium">{{ $item->stock_quantity }} units</td>
                                    <td class="px-6 py-4">
                                        @if($item->stock_quantity > 10)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-green-100 text-green-700">Available</span>
                                        @elseif($item->stock_quantity > 0)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-100 text-orange-700">Low Stock</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-700">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-slate-300 hover:text-primary transition-colors mr-1"><span class="material-symbols-outlined text-[19px]">edit</span></button>
                                        <button class="text-slate-300 hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[19px]">delete</span></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                        You don't have any plants in your inventory yet.
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(isset($inventories) && $inventories instanceof \Illuminate\Pagination\LengthAwarePaginator && $inventories->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="w-full">
                                {{ $inventories->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
