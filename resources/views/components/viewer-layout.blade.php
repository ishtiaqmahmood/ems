<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal | EMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>

<body x-data="{ mobileMenuOpen: false }" class="bg-slate-50 font-sans antialiased h-screen flex overflow-hidden selection:bg-indigo-100 selection:text-indigo-900">

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
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-700 flex items-center justify-center text-white">
                    <i class="bi bi-person-workspace text-xl"></i>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tighter">EMS <span class="text-indigo-600">Portal</span></h2>
            </div>
            <button @click="mobileMenuOpen = false" class="p-2 text-slate-400 hover:text-slate-600">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <nav class="flex-1 px-6 space-y-1 overflow-y-auto pb-10">
            <x-nav-link-viewer href="{{ route('home') }}" :active="request()->routeIs('home')" icon="bi-house-heart-fill">Dashboard</x-nav-link-viewer>
            <x-nav-link-viewer :href="route('profile.show')" :active="request()->routeIs('profile.*')" icon="bi-person-circle">My Profile</x-nav-link-viewer>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-6">Records</div>
            <x-nav-link-viewer :href="route('attendance.index')" :active="request()->routeIs('attendance.*')" icon="bi-calendar-check-fill">My Attendance</x-nav-link-viewer>
            <x-nav-link-viewer :href="route('vacations.index')" :active="request()->routeIs('vacations.*')" icon="bi-airplane-engines-fill">Leave Requests</x-nav-link-viewer>
        </nav>
    </aside>

    {{-- Desktop Sidebar --}}
    <aside class="hidden lg:flex w-72 bg-white border-r border-slate-100 h-screen flex-col shadow-[20px_0_40px_-20px_rgba(0,0,0,0.02)] z-50">

        <div class="px-8 py-10 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-700 flex items-center justify-center text-white shadow-2xl shadow-indigo-200">
                <i class="bi bi-person-workspace text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tighter">EMS <span class="text-indigo-600">Portal</span></h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] leading-none">Employee Self Service</p>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-1 overflow-y-auto pb-10">
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-4">Personal</div>

            <x-nav-link-viewer href="{{ route('home') }}" :active="request()->routeIs('home')" icon="bi-house-heart-fill">Dashboard</x-nav-link-viewer>
            <x-nav-link-viewer :href="route('profile.show')" :active="request()->routeIs('profile.*')" icon="bi-person-circle">My Profile</x-nav-link-viewer>

            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-6">Records</div>

            <x-nav-link-viewer :href="route('attendance.index')" :active="request()->routeIs('attendance.*')" icon="bi-calendar-check-fill">My Attendance</x-nav-link-viewer>
            <x-nav-link-viewer :href="route('vacations.index')" :active="request()->routeIs('vacations.*')" icon="bi-airplane-engines-fill">Leave Requests</x-nav-link-viewer>
            <x-nav-link-viewer :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" icon="bi-calendar3-event">Company Calendar</x-nav-link-viewer>

            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 py-4 mt-6">Resources</div>

            <x-nav-link-viewer href="#" icon="bi-file-earmark-text-fill">Documents</x-nav-link-viewer>
            <x-nav-link-viewer href="#" icon="bi-cash-stack">Payroll & Slips</x-nav-link-viewer>
            <x-nav-link-viewer href="#" icon="bi-megaphone-fill">Announcements</x-nav-link-viewer>
        </nav>

        @auth
            <div class="p-6 border-t border-slate-50">
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-[1.25rem] bg-indigo-50 text-indigo-600 font-black text-xs uppercase tracking-widest hover:bg-indigo-600 hover:text-white hover:shadow-xl hover:shadow-indigo-100 transition-all duration-300 group">
                        <i class="bi bi-power text-lg transition-transform group-hover:rotate-90"></i>
                        <span>Secure Logout</span>
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden relative">
        <x-header :pageTitle="$pageTitle ?? 'Employee Dashboard'" />

        <main class="flex-1 overflow-y-auto relative z-10">
            <div class="min-h-full pb-20">
                {{ $slot }}
            </div>
        </main>

        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-br from-indigo-50/20 to-violet-50/20 blur-[120px] -z-10 rounded-full"></div>
    </div>
    @stack('scripts')

</body>

</html>
