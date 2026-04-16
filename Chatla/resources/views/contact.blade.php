<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Contact Us - Chatla 🌱</title>

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
        .hero-overlay {
            background: linear-gradient(to right, rgba(22, 29, 21, 0.9) 0%, rgba(22, 29, 21, 0.4) 100%);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">

<!-- Top Navigation Bar (Matched to Dashboard/Welcome) -->
<header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-6 lg:px-20 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-lg">spa</span>
            </div>
            <h2 class="text-primary text-xl font-bold tracking-tight">Chatla</h2>
        </div>
        <nav class="hidden md:flex items-center gap-8">
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ url('/') }}">Home</a>
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="#">Explore</a>
            <a class="hover:text-primary transition-colors text-sm font-medium text-slate-600 dark:text-slate-300" href="{{ route('contact') }}">Contact us</a>
            
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

<main class="flex-grow">
    <!-- Hero Section -->
    <section class="relative h-[400px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img alt="Botanical Conservatory" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80"/>
            <div class="absolute inset-0 hero-overlay"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
            <h1 class="text-5xl font-black text-white max-w-2xl leading-tight tracking-tight mb-4">
                Get in Touch with our Botanical Experts
            </h1>
            <p class="text-xl text-primary-fixed-dim text-slate-200 max-w-xl font-medium opacity-90">
                Nurturing your green space with professional advice and premium Moroccan flora.
            </p>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="max-w-7xl mx-auto px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Column: Report Form -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-900 rounded-3xl p-10 shadow-xl shadow-primary/5 border border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3 mb-8">
                    <span class="material-symbols-outlined text-primary text-3xl">report</span>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Send us a Message</h2>
                </div>
                
                <div class="mb-10">
                    <label class="text-xs font-bold uppercase tracking-widest text-slate-500 block mb-4">Select Category</label>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-4 py-2 rounded-full bg-primary text-white text-sm font-bold cursor-pointer">Bug/Error</span>
                        <span class="px-4 py-2 rounded-full bg-primary/5 text-primary text-sm font-bold hover:bg-primary/10 cursor-pointer transition-colors">False information</span>
                        <span class="px-4 py-2 rounded-full bg-primary/5 text-primary text-sm font-bold hover:bg-primary/10 cursor-pointer transition-colors">Feature Request</span>
                        <span class="px-4 py-2 rounded-full bg-primary/5 text-primary text-sm font-bold hover:bg-primary/10 cursor-pointer transition-colors">Missing Content</span>
                        <span class="px-4 py-2 rounded-full bg-primary/5 text-primary text-sm font-bold hover:bg-primary/10 cursor-pointer transition-colors">Other</span>
                    </div>
                </div>

                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Full Name</label>
                            <input class="w-full bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="John Doe" type="text"/>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Email Address</label>
                            <input class="w-full bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="john@example.com" type="email"/>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Subject (Optional)</label>
                        <input class="w-full bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="How can we help?" type="text"/>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Message</label>
                        <div class="relative">
                            <textarea class="w-full bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none resize-none" placeholder="Write your message here..." rows="6"></textarea>
                        </div>
                    </div>
                    <button class="w-full md:w-auto flex items-center justify-center gap-2 bg-primary text-white px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all">
                        Send Message
                        <span class="material-symbols-outlined text-sm">send</span>
                    </button>
                </form>
            </div>

            <!-- Right Column: Info & Details -->
            <div class="lg:col-span-5 space-y-8">
                <div class="bg-primary text-white p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold mb-4">Your feedback makes Chatla better.</h3>
                    <p class="text-white/80 leading-relaxed">
                        Our green community thrives on your input. If you have questions about a nursery, plant care, or spotted a bug in the soil, we're here to help.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-500">What you can report</h4>
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary text-xl">bug_report</span>
                            </div>
                            <div>
                                <p class="font-bold">Technical Issues</p>
                                <p class="text-sm text-slate-500">Something isn't working as expected.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary text-xl">potted_plant</span>
                            </div>
                            <div>
                                <p class="font-bold">Botanical Inquiries</p>
                                <p class="text-sm text-slate-500">Need help identifying or caring for a plant.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary text-xl">storefront</span>
                            </div>
                            <div>
                                <p class="font-bold">Nursery Partnerships</p>
                                <p class="text-sm text-slate-500">Interested in listing your nursery on Chatla.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">mail</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Prefer to email directly?</p>
                        <a class="font-bold text-primary hover:underline" href="mailto:contact@chatla.ma">contact@chatla.ma</a>
                    </div>
                </div>

                <div class="relative rounded-3xl overflow-hidden h-48 flex items-end">
                    <img alt="Fern leaves" class="absolute inset-0 w-full h-full object-cover" src="https://images.unsplash.com/photo-1530667912788-f976e8ee0bd5?auto=format&fit=crop&q=80"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="relative p-6">
                        <p class="text-white font-medium italic opacity-90">"Botany is patience... Growth takes time."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer (Matched to Login Page) -->
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
