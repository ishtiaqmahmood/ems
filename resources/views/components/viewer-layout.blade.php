<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-gray-100 h-screen flex overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-md flex-shrink-0 flex flex-col">
        <div
            class="px-6 py-5 border-b border-gray-200 cursor-pointer bg-white/80 backdrop-blur-sm
            hover:bg-white transition">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="p-2 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white shadow-md group-hover:shadow-lg transition">
                    <i class="bi bi-speedometer2 text-xl"></i>
                </div>
                <span
                    class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 to-indigo-600 text-transparent bg-clip-text group-hover:scale-105 transition">
                    EMS
                </span>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">

            <!-- Attendance -->
            <a href="{{ route('attendance.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('attendance.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-calendar-check"></i> Attendance
            </a>

            <!-- Profile -->
            <a href="{{ route('profile.show') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('profile.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-person-circle"></i> Profile
            </a>

            <!-- Documents -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('documents.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-file-earmark-text"></i> Documents
            </a>

            <!-- Photos -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('photos.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-image"></i> Photos
            </a>

            <!-- Calendar -->
            <a href="{{ route('calendar.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('calendar.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-calendar-event"></i> Calendar
            </a>

            <!-- Leave -->
            <a href="{{ route('vacations.index') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('vacations.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-airplane-fill"></i> Leave
            </a>

            <!-- Payroll -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('salaries.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-cash-coin"></i> Payroll
            </a>

            <!-- Events -->
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border
        {{ request()->routeIs('events.*')
            ? 'bg-sky-100 border-sky-300 text-sky-800 font-semibold'
            : 'border-gray-200 text-gray-700' }}
        hover:bg-sky-200 hover:border-sky-400 hover:text-sky-900 transition">

                <i class="bi bi-megaphone"></i> Events
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
