@extends('layouts.nursery')

@section('title', (auth()->user()->nursery->name ?? 'Chatla') . ' - Nursery Admin Dashboard')

@section('content')
            <div class="p-8 space-y-6">

                @if($status === \App\Models\User::STATUS_PENDING)
                <!-- Pending Account Warning -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 flex items-center gap-4 text-amber-800 animate-pulse">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-amber-600 text-3xl">hourglass_empty</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Pending Account</h4>
                        <p class="text-sm opacity-90">Wait for our team to activate your account. You won't be able to manage inventory or public profiles until then.</p>
                    </div>
                </div>
                @endif

                <!-- Page title -->
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight">Nursery Overview</h2>
                        <p class="text-slate-500 text-sm mt-1">Good morning, {{ explode(' ', auth()->user()->name)[0] }}. Here's what's happening with your inventory.</p>
                    </div>
                    @if($status === \App\Models\User::STATUS_ACTIVE)
                    <a href="{{ route('nursery.inventory.create') }}" class="bg-primary text-white px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Add New Plant
                    </a>
                    @else
                    <button disabled class="bg-slate-200 text-slate-400 px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm cursor-not-allowed">
                        <span class="material-symbols-outlined text-[18px]">lock</span>
                        Add New Plant
                    </button>
                    @endif
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
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">notification_important</span>
                        </div>
                        <p class="text-slate-500 text-sm">Low Stock Items (Alerts)</p>
                        <p class="text-2xl font-bold mt-0.5">{{ $lowStock ?? 0 }}</p>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-100 p-5">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500 mb-4">
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">category</span>
                        </div>
                        <p class="text-slate-500 text-sm">Plant Families</p>
                        <p class="text-2xl font-bold mt-0.5">{{ $familyCount ?? 0 }}</p>
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

                    <!-- Simplified Custom Pagination -->
                    @if(isset($inventories) && $inventories instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-primary/40"></span>
                                <p class="text-xs font-medium text-slate-500">
                                    Total: <span class="text-slate-800 font-bold">{{ $inventories->total() }}</span> Plants
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                {{-- Summary for mobile-ish or compact view --}}
                                <span class="text-[11px] text-slate-400 font-medium mr-2">Page {{ $inventories->currentPage() }} of {{ $inventories->lastPage() }}</span>

                                @if($inventories->onFirstPage())
                                    <span class="flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-100 bg-white text-slate-300 text-xs font-semibold cursor-not-allowed">
                                        <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $inventories->previousPageUrl() }}" class="flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:bg-slate-50 hover:border-primary/30 hover:text-primary transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                                        Previous
                                    </a>
                                @endif

                                @if($inventories->hasMorePages())
                                    <a href="{{ $inventories->nextPageUrl() }}" class="flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:bg-slate-50 hover:border-primary/30 hover:text-primary transition-all shadow-sm">
                                        Next
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @else
                                    <span class="flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-100 bg-white text-slate-300 text-xs font-semibold cursor-not-allowed">
                                        Next
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
@endsection
