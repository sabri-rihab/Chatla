<aside class="w-52 flex flex-col bg-white border-r border-slate-100 shrink-0">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100">
        <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center text-white shrink-0">
            <span class="material-symbols-outlined mat-fill text-[20px]">psychiatry</span>
        </div>
        <div class="leading-tight">
            <p class="font-bold text-[15px] text-primary">Chatla</p>
            <p class="text-[10px] text-slate-400 font-medium">Nursery Admin</p>
        </div>
    </div>

    <!-- Nav -->
    @php
        $route = Route::currentRouteName();
    @endphp
    <nav class="flex-1 px-3 py-5 space-y-0.5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $route === 'dashboard' ? 'bg-primary text-white font-semibold' : 'text-slate-600 hover:bg-primary/8 hover:text-primary' }}">
            <span class="material-symbols-outlined {{ $route === 'dashboard' ? 'mat-fill' : 'mat' }} text-[20px]">grid_view</span>
            Overview
        </a>
        <a href="{{ route('nursery.inventory.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $route === 'nursery.inventory.index' ? 'bg-primary text-white font-semibold' : 'text-slate-600 hover:bg-primary/8 hover:text-primary' }}">
            <span class="material-symbols-outlined {{ $route === 'nursery.inventory.index' ? 'mat-fill' : 'mat' }} text-[20px]">potted_plant</span>
            My Plants
        </a>
        <a href="{{ route('nursery.inventory.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $route === 'nursery.inventory.create' ? 'bg-primary text-white font-semibold' : 'text-slate-600 hover:bg-primary/8 hover:text-primary' }}">
            <span class="material-symbols-outlined {{ $route === 'nursery.inventory.create' ? 'mat-fill' : 'mat' }} text-[20px]">add_circle</span>
            Add New Plant
        </a>
        <a href="{{ route('nursery.profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $route === 'nursery.profile.edit' ? 'bg-primary text-white font-semibold' : 'text-slate-600 hover:bg-primary/8 hover:text-primary' }}">
            <span class="material-symbols-outlined {{ $route === 'nursery.profile.edit' ? 'mat-fill' : 'mat' }} text-[20px]">storefront</span>
            Nursery Info
        </a>
    </nav>

    <!-- Settings -->
    <div class="px-3 py-4 border-t border-slate-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-red-50 hover:text-red-600 rounded-lg text-sm font-medium transition-colors cursor-pointer text-left">
                <span class="material-symbols-outlined mat text-[20px]">logout</span>
                Log Out
            </button>
        </form>
    </div>
</aside>
