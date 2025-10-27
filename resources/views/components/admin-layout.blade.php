<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-gray-100 h-screen flex overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-md flex-shrink-0 flex flex-col">
        <a href="{{ route('adminhome') }}">
            <div class="px-6 py-4 text-2xl font-bold border-b border-gray-200 cursor-pointer hover:bg-gray-100">
                EMS
            </div>
        </a>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Profile
            </a>
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                User Roles
            </a>

            <!-- Organization (Main) -->
            <button @click="orgOpen = !orgOpen"
                class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
        {{ request()->routeIs('organization.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <span>Organization</span>
                <i class="bi" :class="orgOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
            </button>

            <!-- Department (Submenu of Organization) -->
            <div x-show="orgOpen" x-collapse class="pl-6 space-y-2">
                <button @click="deptOpen = !deptOpen"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
            {{ request()->routeIs('departments.*')
                ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                : 'border-gray-200 text-gray-700' }}
            hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <span>Departments</span>
                    <i class="bi" :class="deptOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </button>

                <!-- Section (Submenu of Department) -->
                <div x-show="deptOpen" x-collapse class="pl-6 space-y-2">
                    <button @click="sectionOpen = !sectionOpen"
                        class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
                {{ request()->routeIs('sections.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                        <span>Sections</span>
                        <i class="bi" :class="sectionOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </button>

                    <!-- Employees (Submenu of Section) -->
                    <div x-show="sectionOpen" x-collapse class="pl-6 space-y-2">
                        <a href="#"
                            class="block px-4 py-2 rounded-lg border
                    {{ request()->routeIs('employees.*')
                        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                        : 'border-gray-200 text-gray-700' }}
                    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                            Employees
                        </a>
                    </div>
                </div>
            </div>
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Attendance management
            </a>
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                leave management
            </a>

            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Payroll management
            </a>

            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Documents
            </a>
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Photos
            </a>
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Calendar
            </a>
            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Events
            </a>

            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Settings
            </a>
        </nav>

        @auth
            <div class="px-4 py-6 border-t border-gray-200">
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-100 text-red-600 font-semibold">
                        Log Out
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top Navbar --}}
        <x-header :pageTitle="$pageTitle ?? 'Dashboard'" />

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>
    @stack('scripts')

</body>

</html>
