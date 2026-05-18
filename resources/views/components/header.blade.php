<header class="flex justify-between items-center px-6 md:px-10 py-5 bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-gray-100/50 shadow-sm">
    <!-- Page Title & Mobile Menu Toggle -->
    <div class="flex items-center gap-4">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-600 hover:bg-slate-50 rounded-xl transition-all">
            <i class="bi bi-list text-2xl"></i>
        </button>

        <div class="hidden md:block w-1 h-8 bg-sky-600 rounded-full"></div>
        <h1 class="text-lg md:text-xl font-black text-gray-900 tracking-tight truncate max-w-[200px] md:max-w-none">{{ $pageTitle ?? 'Dashboard' }}</h1>
    </div>

    <!-- User & Actions -->
    <div class="flex items-center gap-6">

        {{-- Notification Bell --}}
        <button class="relative p-2 text-gray-400 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all group">
            <i class="bi bi-bell text-xl"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white group-hover:scale-125 transition-transform"></span>
        </button>

        @auth
            <div class="h-8 w-px bg-gray-100"></div>

            <a href="{{ route('profile.show') }}"
                class="flex items-center gap-3 pl-2 pr-4 py-2 rounded-2xl hover:bg-slate-50 transition-all group">

                {{-- Avatar Circle --}}
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-black shadow-lg shadow-sky-100 group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div class="hidden md:block">
                    <p class="text-sm font-black text-gray-900 leading-none mb-1 group-hover:text-sky-600 transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">{{ Auth::user()->role }}</p>
                </div>
            </a>
        @endauth
    </div>
</header>
