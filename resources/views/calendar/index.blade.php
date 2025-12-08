<x-viewer-layout>

    <div class="max-w-7xl mx-auto py-10 px-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Calendar - {{ $current->format('F Y') }}</h1>
            <div class="space-x-2">
                <a href="{{ route('calendar.index', ['year' => $prev->year, 'month' => $prev->month]) }}"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">&larr; Previous</a>
                <a href="{{ route('calendar.index', ['year' => $next->year, 'month' => $next->month]) }}"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Next &rarr;</a>
            </div>
        </div>

        <!-- Weekdays -->
        <div class="grid grid-cols-7 gap-1 text-center font-semibold bg-gray-100 rounded-t-lg">
            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="py-2 border-b border-gray-200">{{ $day }}</div>
            @endforeach
        </div>

        <!-- Days Grid -->
        <div class="grid grid-cols-7 gap-1">
            @php
                $startWeekday = $startOfMonth->dayOfWeek; // 0=Sunday
                $daysInMonth = $endOfMonth->day;
            @endphp

            <!-- Empty slots before start of month -->
            @for ($i = 0; $i < $startWeekday; $i++)
                <div class="p-4 border border-gray-100"></div>
            @endfor

            <!-- Days of month -->
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $date = $current->copy()->day($day);
                    $weekday = $date->dayOfWeek; // 0=Sun, 5=Fri, 6=Sat
                    $dayEvents = $events[$date->toDateString()] ?? [];
                    $isWeekend = in_array($weekday, [5, 6]); // Friday, Saturday
                @endphp
                <div
                    class="border border-gray-100 p-2 min-h-[80px] flex flex-col justify-start
                    {{ $isWeekend ? 'bg-red-100' : 'bg-white' }}">
                    <div class="font-semibold text-sm">{{ $day }}</div>

                    @foreach ($dayEvents as $event)
                        <div class="mt-1 px-1 py-0.5 rounded text-xs text-white truncate"
                            style="background-color: {{ $event->color ?? '#1e3a8a' }};" title="{{ $event->title }}">
                            {{ $event->title }}
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>

</x-viewer-layout>
