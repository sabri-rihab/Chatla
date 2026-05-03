<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chatla Admin | User Requests</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"/>
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
                        "display": ["Inter", "sans-serif"],
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-down { animation: slideDown 0.3s ease-out; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-4 md:px-10 lg:px-20 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-slate-900 dark:text-white font-bold text-xl">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-lg">spa</span>
                </div>
                <h2 class="text-primary text-xl font-bold tracking-tight">Chatla</h2>
            </a>
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Dashboard_admin</a>
                <a href="{{ route('nurseries.index') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Nurseries</a>
                <a href="{{ route('explore') }}" class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">Explore</a>
                <a href="{{ route('admin.requests') }}" class="text-primary font-bold text-sm font-medium">Requests</a>
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
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">User Requests</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Manage bug reports, feature requests, and inquiries.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="bg-white dark:bg-slate-800 px-4 py-2 rounded-xl border border-primary/10 shadow-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $reports->total() }} Total Requests</span>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white dark:bg-slate-800/50 p-4 rounded-2xl border border-primary/5 shadow-sm mb-6">
            <form action="{{ route('admin.requests') }}" method="GET" class="flex flex-wrap items-end gap-4">

                <!-- Type Filter -->
                <div class="flex flex-col gap-2 min-w-[150px] w-full md:w-auto">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Type</label>
                    <select name="type" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/50 outline-none cursor-pointer">
                        <option value="">All Types</option>
                        @foreach($availableTypes as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex flex-col gap-2 min-w-[150px] w-full md:w-auto">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Status</label>
                    <select name="status" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/50 outline-none cursor-pointer">
                        <option value="">All Statuses</option>
                        @foreach($availableStatuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest w-10"></th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">User</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Update Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($reports as $report)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <button onclick="toggleDetails('details-{{ $report->id }}', this)" class="w-8 h-8 rounded-full hover:bg-primary/10 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-slate-400">expand_more</span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-slate-100">{{ $report->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $report->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-tight">{{ $report->request_type }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-medium">{{ $report->subject }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'resolved' => 'bg-emerald-100 text-emerald-700',
                                    ];
                                    $badge = $statusClasses[$report->status] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $badge }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.requests.status.update', $report) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold border-0 ring-1 ring-slate-200 dark:ring-slate-700 bg-white dark:bg-slate-800 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-primary transition-all">
                                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $report->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <!-- Hidden Row for Message Content -->
                        <tr id="details-{{ $report->id }}" class="hidden bg-slate-50/50 dark:bg-slate-900/30">
                            <td colspan="6" class="px-20 py-6">
                                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-primary/5 shadow-sm animate-slide-down">
                                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Request Message</h4>
                                    <p class="text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $report->message }}</p>
                                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                                        <span class="text-xs text-slate-400">Received on: {{ $report->created_at->format('M d, Y - H:i') }}</span>
                                        <!-- opens the defaul app for emails -->
                                        <!-- <a href="mailto:{{ $report->email }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">mail</span>
                                            Reply to User
                                        </a> -->

                                        <!-- opens emails on the browser-->
                                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $report->email }}&su=Re: Your Chatla Support Request&body=Hello,%0A%0AThank you for contacting Chatla. We will review your request and get back to you as soon as possible.%0A%0A---------------------------------%0A🌱 Chatla Support Team%0A🌿 Simplifying Nursery Management in Morocco%0A---------------------------------" target="_blank" class="bg-primary text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                            Reply to User
                                        </a>                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-4xl">inbox</span>
                                    <p>No requests found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/20">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    </main>

    <script>
        function toggleDetails(id, btn) {
            const row = document.getElementById(id);
            const icon = btn.querySelector('.material-symbols-outlined');
            
            if (row.classList.contains('hidden')) {
                row.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
                icon.style.transition = 'transform 0.2s ease';
            } else {
                row.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>
</html>
