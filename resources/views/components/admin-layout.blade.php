<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</head>

<body x-data="{ mobileMenuOpen: false }" class="bg-slate-50 font-sans antialiased h-screen flex overflow-hidden selection:bg-sky-100 selection:text-sky-900">

    {{-- Mobile Sidebar Overlay --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] lg:hidden">
    </div>

    {{-- Mobile Sidebar --}}
    <aside x-show="mobileMenuOpen"
           x-transition:enter="transition ease-out duration-300 transform"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200 transform"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 w-72 bg-white z-[70] flex flex-col shadow-2xl lg:hidden">
        <div class="px-8 py-10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-600 to-indigo-700 flex items-center justify-center text-white">
                    <i class="bi bi-layers-half text-xl"></i>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tighter">EMS <span class="text-sky-600">Pro</span></h2>
            </div>
            <button @click="mobileMenuOpen = false" class="p-2 text-slate-400 hover:text-slate-600">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <nav class="flex-1 px-6 space-y-1 overflow-y-auto pb-10">
            <x-nav-link href="/admin" :active="request()->routeIs('adminhome')" icon="bi-grid-1x2-fill">Dashboard</x-nav-link>
            <x-nav-link :href="route('admin.employers.index')" :active="request()->routeIs('admin.employers.*')" icon="bi-people-fill">Employees</x-nav-link>
            <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')" icon="bi-diagram-3-fill">Departments</x-nav-link>
        </nav>
    </aside>

    {{-- Desktop Sidebar --}}
    <aside class="hidden lg:flex w-72 bg-white border-r border-slate-100 h-screen flex-col shadow-[20px_0_40px_-20px_rgba(0,0,0,0.02)] z-50">

        <!-- 🔹 Brand Header -->
        <div class="px-8 py-10 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-600 to-indigo-700 flex items-center justify-center text-white shadow-2xl shadow-sky-200">
                <i class="bi bi-layers-half text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tighter">EMS <span class="text-sky-600">Pro</span></h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] leading-none">Admin Suite</p>
            </div>
        </div>

        <!-- 🔹 Sidebar Navigation -->
        <nav class="flex-1 px-6 space-y-1 overflow-y-auto pb-10">

            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-4">System Core</div>

            <x-nav-link href="/admin" :active="request()->routeIs('adminhome')" icon="bi-grid-1x2-fill">Dashboard</x-nav-link>
            <x-nav-link :href="route('admin.profile.show')" :active="request()->routeIs('admin.profile.*')" icon="bi-person-badge-fill">My Profile</x-nav-link>

            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-6">Organization</div>

            <x-nav-link :href="route('admin.organizations.index')" :active="request()->routeIs('admin.organizations.*')" icon="bi-building-fill">Organizations</x-nav-link>
            <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')" icon="bi-diagram-3-fill">Departments</x-nav-link>
            <x-nav-link :href="route('admin.sections.index')" :active="request()->routeIs('admin.sections.*')" icon="bi-stack">Sections</x-nav-link>

            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-6">Workforce</div>

            <x-nav-link :href="route('admin.employers.index')" :active="request()->routeIs('admin.employers.*')" icon="bi-people-fill">Employees</x-nav-link>
            <x-nav-link :href="route('admin.leaves.index')" :active="request()->routeIs('admin.leaves.*')" icon="bi-calendar-check-fill">Leaves</x-nav-link>

            <div x-data="{ staffOpen: {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.users.list') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="staffOpen = !staffOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-slate-600 font-bold hover:bg-slate-50 transition-all group">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-shield-lock-fill text-lg opacity-40 group-hover:text-sky-600 transition-colors"></i>
                        <span>Access Control</span>
                    </div>
                    <i class="bi text-[10px] transition-transform duration-300" :class="staffOpen ? 'bi-chevron-up rotate-180' : 'bi-chevron-down'"></i>
                </button>
                <div x-show="staffOpen" x-collapse x-cloak class="pl-4 space-y-1">
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.list')" icon="bi-key-fill" subnav>Roles</x-nav-link>
                    <x-nav-link :href="route('admin.users.list')" :active="request()->routeIs('admin.users.list')" icon="bi-person-lines-fill" subnav>Users</x-nav-link>
                </div>
            </div>

            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-6">Resources</div>

            <x-nav-link :href="route('admin.documents.index')" :active="request()->routeIs('admin.documents.*')" icon="bi-file-earmark-zip-fill">Documents</x-nav-link>
            <x-nav-link :href="route('admin.calendar.index')" :active="request()->routeIs('admin.calendar.*')" icon="bi-calendar3">Events Hub</x-nav-link>
            <x-nav-link :href="route('admin.photos.index')" :active="request()->routeIs('admin.photos.*')" icon="bi-images">Media Library</x-nav-link>

        </nav>

        <!-- 🔹 Sidebar Footer -->
        @auth
            <div class="p-6 border-t border-slate-50">
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-[1.25rem] bg-rose-50 text-rose-600 font-black text-xs uppercase tracking-widest hover:bg-rose-600 hover:text-white hover:shadow-xl hover:shadow-rose-100 transition-all duration-300 group">
                        <i class="bi bi-power text-lg transition-transform group-hover:rotate-90"></i>
                        <span>Secure Logout</span>
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden relative">
        <x-header :pageTitle="$pageTitle ?? 'Dashboard'" />

        <main class="flex-1 overflow-y-auto relative z-10">
            <div class="min-h-full pb-20 p-4 sm:p-6 md:p-10">
                {{ $slot }}
            </div>
        </main>

        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-br from-sky-50/20 to-indigo-50/20 blur-[120px] -z-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-gradient-to-tr from-violet-50/20 to-fuchsia-50/20 blur-[120px] -z-10 rounded-full"></div>
    </div>
    @stack('scripts')

</body>

</html>
