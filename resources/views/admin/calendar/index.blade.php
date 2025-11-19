<x-admin-layout>

    <!-- Header -->
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-calendar3 text-sky-600"></i>
            Event Calendar
        </h1>
        <p class="text-sm text-gray-500">A colorful monthly view</p>
    </div>

    <!-- Navigation -->
    <div class="flex items-center gap-3 mb-5">
        <a href="?date={{ $prevMonth }}"
            class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 transition flex items-center gap-1">
            <i class="bi bi-chevron-left"></i> Prev
        </a>

        <div class="px-5 py-2 bg-gradient-to-r from-sky-500 to-indigo-500 text-white rounded-lg shadow font-semibold">
            {{ $current->format('F Y') }}
        </div>

        <a href="?date={{ $nextMonth }}"
            class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 transition flex items-center gap-1">
            Next <i class="bi bi-chevron-right"></i>
        </a>
    </div>

    <!-- Week Days -->
    <div class="grid grid-cols-7 gap-2 text-sm text-center mb-4">
        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d)
            <div
                class="font-semibold text-gray-700 bg-gradient-to-r from-gray-100 to-gray-200 py-2 rounded-lg shadow-sm border">
                {{ $d }}
            </div>
        @endforeach
    </div>

    <!-- Calendar Days -->
    @php
        // Weekly Off-Days (Friday=5, Saturday=6, Sunday=0 if needed)
        $weeklyOff = [5, 6]; // Friday & Saturday
    @endphp

    <div class="grid grid-cols-7 gap-3">
        @foreach ($days as $day)
            @php
                $isCurrentMonth = $day->month === $current->month;
                $isToday = $day->isSameDay(now());
                $dayKey = $day->format('Y-m-d');
                $dayEvents = $events[$dayKey] ?? [];

                // Weekly off condition
                $isOffDay = in_array($day->dayOfWeek, $weeklyOff);
            @endphp

            <div
                class="
                min-h-[130px] p-2 rounded-xl border shadow-sm transition relative overflow-hidden
                @if ($isToday) ring-2 ring-sky-400 bg-sky-50 @endif
                @if ($isOffDay) bg-red-50 border-red-200 @endif
                @if (!$isCurrentMonth && !$isOffDay) bg-gray-50 text-gray-400 @endif
                @if ($isCurrentMonth && !$isOffDay && !$isToday) bg-white @endif
            ">

                <!-- Backdrop for Off Day -->
                @if ($isOffDay)
                    <div class="absolute inset-0 bg-red-100/30 pointer-events-none"></div>
                @endif

                <!-- Date Header -->
                <div class="flex justify-between items-center mb-1 relative z-10">
                    <span class="text-sm font-bold @if ($isOffDay) text-red-700 @endif">
                        {{ $day->day }}
                    </span>

                    @if ($isToday)
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-sky-600 text-white shadow">
                            Today
                        </span>
                    @endif

                    @if ($isOffDay)
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-600 text-white shadow">
                            Holiday
                        </span>
                    @endif
                </div>

                <!-- Events -->
                <div class="space-y-1 relative z-10">
                    @forelse($dayEvents as $ev)
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full text-xs text-left truncate px-2 py-1 rounded-md border shadow-sm
                                   bg-gradient-to-r from-sky-100 via-sky-200 to-sky-100
                                   text-sky-800 font-medium hover:shadow-md hover:scale-[1.02] transition">
                                <span class="inline-block w-2 h-2 rounded-full mr-1"
                                    style="background: {{ $ev['color'] ?? '#0284c7' }};"></span>
                                {{ $ev['title'] }}
                            </button>

                            <div x-show="open" x-cloak
                                class="mt-1 text-xs text-gray-600 px-2 py-1 bg-white rounded-md shadow border">
                                <strong>Time:</strong> {{ $ev['time'] ?? '' }} <br>
                                <a href="{{ route('admin.events.edit', $ev['id']) }}"
                                    class="text-sky-600 underline text-[11px] hover:text-sky-800">
                                    Edit Event
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-gray-300">&nbsp;</div>
                    @endforelse
                </div>

            </div>
        @endforeach
    </div>


</x-admin-layout>
