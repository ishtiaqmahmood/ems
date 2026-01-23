<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-gray-100 h-screen flex overflow-hidden">

    {{-- Sidebar --}}
    <!-- ✅ HRM Admin Panel Sidebar -->
    <aside x-data="{ orgOpen: false, deptOpen: false, sectionOpen: false }" class="w-64 bg-white border-r border-gray-200 min-h-screen flex flex-col shadow-lg">

        <!-- 🔹 Sidebar Header -->
        <a href="/admin">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-sky-700 flex items-center gap-2">
                    <i class="bi bi-building-gear text-sky-600"></i> LMS Panel
                </h2>
            </div>
        </a>


        <!-- 🔹 Sidebar Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 text-sm font-medium overflow-y-auto">

            <!-- Profile -->
            <a href="{{ route('admin.profile.show') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.profile.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-person-circle text-sky-600"></i> Profile
            </a>

            <!-- 🔹 Staff Dropdown -->
            <div x-data="{ staffOpen: false }">
                <button @click="staffOpen = !staffOpen"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
            {{ request()->routeIs('staff.*')
                ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                : 'border-gray-200 text-gray-700' }}
            hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-people-fill text-sky-600"></i> Staff
                    </span>
                    <i class="bi" :class="staffOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </button>

                <!-- 🔸 Dropdown Items -->
                <div x-show="staffOpen" x-collapse class="pl-6 space-y-2">

                    <!-- 🛡 User Roles -->
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.users.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                        <i class="bi bi-shield-lock text-sky-600"></i> User Roles
                    </a>

                    <!-- 👥 User List -->
                    <a href="{{ route('admin.users.list') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('admin.users.list') ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold' : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                        <i class="bi bi-person-lines-fill text-sky-600"></i>
                        User List
                    </a>

                </div>
            </div>


            <!-- 🔹 Organization -->
            <a href="{{ route('admin.organizations.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('admin.organizations.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-building text-sky-600 text-lg"></i>
                <span>Organization</span>
            </a>

            <!-- 🔹 Departments -->
            <a href="{{ route('admin.departments.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('admin.departments.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-diagram-3 text-sky-600 text-lg"></i>
                <span>Departments</span>
            </a>

            <!-- 🔹 Sections -->
            <a href="{{ route('admin.sections.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('admin.sections.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-grid-1x2 text-sky-600 text-lg"></i>
                <span>Sections</span>
            </a>

            <!-- 🔹 Employees -->
            <a href="{{ route('admin.employers.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('admin.employers.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-people text-sky-600 text-lg"></i>
                <span>Employees</span>
            </a>

            <!-- 🔹 Document -->
            <a href="{{ route('admin.documents.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.documents.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-calendar3 text-sky-600"></i> Documents
            </a>

            <!-- 🔹 Calendar -->
            <a href="{{ route('admin.calendar.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.calendar.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-calendar3 text-sky-600"></i> Calendar
            </a>

            <!-- 🔹 Photos -->
            <a href="{{ route('admin.photos.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.photos.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-image text-sky-600"></i> Media library
            </a>

            <!-- 🔹 Events -->
            <a href="{{ route('admin.events.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.events.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-calendar-event text-sky-600"></i> Events
            </a>

            <!-- 🔹 Leaves -->
            <a href="{{ route('admin.leaves.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.leaves.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-calendar-check text-sky-600"></i> Leaves
            </a>

            <a href="{{ route('admin.leave-types.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('admin.leave-types.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-clipboard-check text-sky-600"></i> Leave Types
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
