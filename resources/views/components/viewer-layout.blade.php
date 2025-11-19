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
        <a href="{{ route('home') }}">
            <div class="px-6 py-4 text-2xl font-bold border-b border-gray-200 cursor-pointer hover:bg-gray-100">
                EMS
            </div>
        </a>

        <nav class="flex-1 px-4 py-6 space-y-2">
            {{-- <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 rounded-lg hover:bg-indigo-100 {{ request()->routeIs('dashboard') ? 'bg-indigo-100 font-semibold' : '' }}">Dashboard</a>
            <a href="{{ route('employees.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-indigo-100 {{ request()->routeIs('employees.*') ? 'bg-indigo-100 font-semibold' : '' }}">Employees</a>
            <a href="{{ route('departments.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-indigo-100 {{ request()->routeIs('departments.*') ? 'bg-indigo-100 font-semibold' : '' }}">Departments</a>
            <a href="{{ route('attendance.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-indigo-100 {{ request()->routeIs('attendance.*') ? 'bg-indigo-100 font-semibold' : '' }}">Attendance</a>
            <a href="{{ route('leaves.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-indigo-100 {{ request()->routeIs('leaves.*') ? 'bg-indigo-100 font-semibold' : '' }}">Leaves</a> --}}
            <a href="{{ route('attendance.index') }}"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('attendance.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                Attendance
            </a>
            <a href="{{ route('profile.show') }}"
                class="block px-4 py-2 rounded-lg border
          {{ request()->routeIs('profile.*')
              ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
              : 'border-gray-200 text-gray-700' }}
          hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Profile
            </a>
            <a href="#"
                class="block px-4 py-2 rounded-lg border
   {{ request()->routeIs('documents.*')
       ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
       : 'border-gray-200 text-gray-700' }}
   hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Documents
            </a>

            <a href="#"
                class="block px-4 py-2 rounded-lg border
   {{ request()->routeIs('photos.*')
       ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
       : 'border-gray-200 text-gray-700' }}
   hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Photos
            </a>

            <a href="{{ route('calendar.index') }}"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('calendar.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                Calendar
            </a>


            <a href="{{ route('vacations.index') }}"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('vacations.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                Leave
            </a>

            <a href="{{ route('salaries.index') }}"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('salaries.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                Payroll
            </a>

            <a href="#"
                class="flex items-center px-4 py-2 rounded-lg border
    {{ request()->routeIs('events.*')
        ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
        : 'border-gray-200 text-gray-700' }}
    hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">
                Events
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
