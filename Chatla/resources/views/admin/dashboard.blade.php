<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chatla | Admin Dashboard</title>
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
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display min-h-screen flex flex-col">

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
                    <a href="{{ route('admin.dashboard') }}" class="text-primary font-bold text-sm font-medium">Dashboard_admin</a>
                @else
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Home</a>
                @endif
                <a href="{{ route('nurseries.index') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Nurseries</a>
                <a href="{{ route('explore') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Explore</a>
                <a href="{{ route('admin.requests') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Requests</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Logout</button>
                    </form>
                @endauth
            </nav>
            <button class="md:hidden text-primary"><span class="material-symbols-outlined">menu</span></button>
        </div>
    </header>

    <main class="flex-1 px-6 md:px-10 py-8 max-w-7xl mx-auto w-full">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">Management Dashboard</h1>
            <p class="text-slate-600 dark:text-slate-400">Manage and monitor all nurseries and clients</p>
        </div>

        <!-- Filters and Search Section -->
        <div class="bg-white dark:bg-slate-800/50 rounded-xl border border-primary/5 shadow-sm p-6 mb-8">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Search -->
                <div class="flex-1 relative w-full">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 block">Search</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                        <input 
                            name="search"
                            value="{{ request('search') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2.5 pl-10 pr-4 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/50 focus:border-transparent outline-none" 
                            placeholder="Search by name, email..." 
                            type="text"
                        />
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="flex flex-col gap-2 min-w-[150px] w-full md:w-auto">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Role</label>
                    <select name="role" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/50 outline-none cursor-pointer">
                        <option value="">All Roles</option>
                        @foreach($availableRoles as $role)
                            <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role === 'nursery_owner' ? 'nursery' : ($role === 'simple' ? 'client' : $role))) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex flex-col gap-2 min-w-[150px] w-full md:w-auto">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Status</label>
                    <select name="status" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/50 outline-none cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <button type="submit" class="hidden">Apply</button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800/50 rounded-xl border border-primary/5 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-lg">
                                            {{ $user->role === 'nursery_owner' ? 'eco' : 'person' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900 dark:text-slate-100">
                                            {{ $user->role === 'nursery_owner' && $user->nursery ? $user->nursery->name : $user->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $user->role === 'nursery_owner' && $user->nursery && $user->nursery->city ? $user->nursery->city->name . ', Morocco' : ($user->address ?? 'N/A') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'nursery_owner')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                    <span class="material-symbols-outlined text-sm">storefront</span>
                                    Nursery
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    Client
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                        'inactive' => 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400',
                                        'suspended' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                        'pending' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    ];
                                    $badgeClass = $statusClasses[$user->status] ?? $statusClasses['inactive'];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                    <span class="w-2 h-2 rounded-full bg-current {{ $user->status === 'active' ? 'animate-pulse' : '' }}"></span>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($user->status === 'active')
                                <form action="{{ route('admin.users.status.update', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="inactive">
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                        Deactivate
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.users.status.update', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-emerald-100 dark:hover:bg-emerald-900/30 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                        Activate
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-4xl">search_off</span>
                                    <p>No users or nurseries found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                {{ $users->links() }}
            </div>
        </div>
    </main>

    <!-- Footer (Matched to Login) -->
    <footer class="mt-auto px-8 py-6 border-t border-gray-200 bg-white dark:bg-slate-900">
        <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-6 h-6 rounded bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-[14px]">spa</span>
                </div>
                <p class="text-xs font-semibold tracking-wider uppercase">CHATLA © {{ date('Y') }}</p>
            </div>
            <div class="flex gap-8">
                <a class="text-xs text-slate-500 hover:text-slate-900 dark:hover:text-white font-semibold tracking-wider transition-colors" href="#">TERMS</a>
                <a class="text-xs text-slate-500 hover:text-slate-900 dark:hover:text-white font-semibold tracking-wider transition-colors" href="#">PRIVACY</a>
                <a class="text-xs text-slate-500 hover:text-slate-900 dark:hover:text-white font-semibold tracking-wider transition-colors" href="#">COOKIES</a>
            </div>
        </div>
    </footer>

</body>
</html>
