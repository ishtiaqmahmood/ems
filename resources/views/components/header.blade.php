<header class="flex justify-between items-center px-6 py-4 bg-white shadow border-b border-gray-200">
    <!-- Page Title -->
    <h1 class="text-2xl font-semibold text-gray-800">{{ $pageTitle ?? 'Dashboard' }}</h1>

    <!-- User Info -->
    <div class="flex items-center space-x-3">
        @auth
            <a href="{{ route('profile.show') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-indigo-100 transition">
                <!-- User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.121 17.804z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                <!-- Username -->
                <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            </a>
        @endauth
    </div>
</header>
