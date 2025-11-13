<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
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
                    <i class="bi bi-people-fill text-sky-600"></i> HRM Panel
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


            {{-- <!-- Organization -->
            <button @click="orgOpen = !orgOpen"
                class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
                {{ request()->routeIs('organization.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <span class="flex items-center gap-2"><i class="bi bi-building text-sky-600"></i> Organization</span>
                <i class="bi" :class="orgOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
            </button>

            <!-- 🔸 Department -->
            <div x-show="orgOpen" x-collapse class="pl-6 space-y-2">
                <button @click="deptOpen = !deptOpen"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
                    {{ request()->routeIs('departments.*')
                        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                        : 'border-gray-200 text-gray-700' }}
                    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <span class="flex items-center gap-2"><i class="bi bi-diagram-3 text-sky-600"></i>
                        Departments</span>
                    <i class="bi" :class="deptOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </button>

                <!-- 🔹 Sections -->
                <div x-show="deptOpen" x-collapse class="pl-6 space-y-2">
                    <button @click="sectionOpen = !sectionOpen"
                        class="flex items-center justify-between w-full px-4 py-2 rounded-lg border
                        {{ request()->routeIs('sections.*')
                            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                            : 'border-gray-200 text-gray-700' }}
                        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                        <span class="flex items-center gap-2"><i class="bi bi-grid text-sky-600"></i> Sections</span>
                        <i class="bi" :class="sectionOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </button>

                    <!-- 🔹 Employees -->
                    <div x-show="sectionOpen" x-collapse class="pl-6 space-y-2">
                        <a href="#"
                            class="block px-4 py-2 rounded-lg border
                            {{ request()->routeIs('employees.*')
                                ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                                : 'border-gray-200 text-gray-700' }}
                            hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                            <i class="bi bi-people text-sky-600 mr-2"></i> Employees
                        </a>
                    </div>
                </div>
            </div> --}}

            <!-- 🔹 Organization -->
            <a href="{{ route('admin.organizations.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('organizations.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-building text-sky-600 text-lg"></i>
                <span>Organization</span>
            </a>

            <!-- 🔹 Departments -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('departments.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-diagram-3 text-sky-600 text-lg"></i>
                <span>Departments</span>
            </a>

            <!-- 🔹 Sections -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('sections.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-grid-1x2 text-sky-600 text-lg"></i>
                <span>Sections</span>
            </a>

            <!-- 🔹 Employees -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
    {{ request()->routeIs('employees.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-people text-sky-600 text-lg"></i>
                <span>Employees</span>
            </a>



            <!-- 🔹 Document Management Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Dropdown Trigger -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('documents.*') ||
        request()->routeIs('doccategories.*') ||
        request()->routeIs('hrdocs.*') ||
        request()->routeIs('acknowledgments.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-file-earmark-text text-sky-600"></i>
                        Documents
                    </div>
                    <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="text-sky-600"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition class="mt-2 ml-4 flex flex-col gap-1 border-l border-sky-200 pl-3">
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('doccategories.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-folder text-sky-500"></i> Document Categories
                    </a>

                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('hrdocs.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-people text-sky-500"></i> HR Documents
                    </a>

                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('acknowledgments.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-check2-circle text-sky-500"></i> Acknowledgments
                    </a>
                </div>
            </div>

            <!-- 🔹 Calendar -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('calendar.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-calendar3 text-sky-600"></i> Calendar
            </a>

            <!-- 🔹 Photos -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('photos.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-image text-sky-600"></i> Media library
            </a>


            <!-- 🔹 Attendance Management Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Dropdown Button -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('attendance.*') ||
        request()->routeIs('attendancepolicies.*') ||
        request()->routeIs('attendancerecords.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar-check text-sky-600"></i>
                        Attendance Manage
                    </div>
                    <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="text-sky-600 transition"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition class="mt-2 ml-4 flex flex-col gap-1 border-l border-sky-200 pl-3">
                    <!-- Attendance Policies -->
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('attendancepolicies.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-clipboard-check text-sky-500"></i> Attendance Policies
                    </a>

                    <!-- Attendance Records -->
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('attendancerecords.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-journal-text text-sky-500"></i> Attendance Records
                    </a>
                </div>
            </div>

            <!-- 🔹 Leave Management Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Dropdown Button -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('leaves.*') ||
        request()->routeIs('leavetypes.*') ||
        request()->routeIs('leaveapplications.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar-week text-sky-600"></i>
                        Leave Management
                    </div>
                    <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="text-sky-600 transition"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition class="mt-2 ml-4 flex flex-col gap-1 border-l border-sky-200 pl-3">
                    <!-- Leave Types -->
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('leaveapplications.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-envelope-paper text-sky-500"></i> Leave Types

                        <!-- Leave Applications -->
                        <a href="#"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('leaveapplications.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                            <i class="bi bi-envelope-paper text-sky-500"></i> Leave Applications
                        </a>
                </div>
            </div>

            <!-- 🔹 Time Tracking Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Dropdown Button -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('timetracking.*') || request()->routeIs('timeentries.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-stopwatch text-sky-600"></i>
                        Time Tracking
                    </div>
                    <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="text-sky-600 transition"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition class="mt-2 ml-4 flex flex-col gap-1 border-l border-sky-200 pl-3">
                    <!-- Time Entries -->
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('timeentries.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-clock-history text-sky-500"></i> Time Entries
                    </a>
                </div>
            </div>

            <!-- 🔹 Payroll Management Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Dropdown Button -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('payroll.*') || request()->routeIs('salary.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-cash-stack text-sky-600"></i>
                        Payroll
                    </div>
                    <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="text-sky-600 transition"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-collapse x-transition
                    class="mt-2 ml-4 flex flex-col gap-1 border-l border-sky-200 pl-3">
                    <!-- Employer Salary -->
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
           {{ request()->routeIs('salary.*')
               ? 'bg-sky-100 text-sky-800 font-semibold'
               : 'text-gray-700 hover:bg-sky-100 hover:text-sky-800' }}">
                        <i class="bi bi-wallet2 text-sky-500"></i> Employer Salary
                    </a>
                </div>
            </div>


            <!-- 🔹 Events -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('events.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-calendar-event text-sky-600"></i> Events
            </a>

            <!-- 🔹 Settings -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
                {{ request()->routeIs('settings.*')
                    ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
                    : 'border-gray-200 text-gray-700' }}
                hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                <i class="bi bi-gear text-sky-600"></i> Settings
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
