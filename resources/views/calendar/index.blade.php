<x-viewer-layout>

    <div class="max-w-7xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">এইচআরএম কালেন্ডার</h1>
                <p class="text-sm text-gray-500">বছর: {{ bn_num($current->year) }} • মাস: {{ banglaMonth($current) }}</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('calendar.index', ['year' => $prev->year, 'month' => $prev->month]) }}"
                    class="px-3 py-2 bg-white border rounded shadow-sm hover:bg-gray-50">
                    ← আগের মাস
                </a>

                <a href="{{ route('calendar.index', ['year' => $next->year, 'month' => $next->month]) }}"
                    class="px-3 py-2 bg-white border rounded shadow-sm hover:bg-gray-50">
                    পরের মাস →
                </a>

                <button x-data x-on:click="$dispatch('open-event-modal', { date: '{{ $current->toDateString() }}' })"
                    class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    নতুন ইভেন্ট যোগ করুন
                </button>
            </div>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Color Legend --}}
        <div class="flex space-x-4 mb-4">
            <span class="flex items-center space-x-1">
                <span class="w-3 h-3 rounded-full bg-blue-200"></span>
                <span>উপস্থিতি</span>
            </span>
            <span class="flex items-center space-x-1">
                <span class="w-3 h-3 rounded-full bg-red-200"></span>
                <span>ছুটি</span>
            </span>
            <span class="flex items-center space-x-1">
                <span class="w-3 h-3 rounded-full bg-green-200"></span>
                <span>ছুটির দিন</span>
            </span>
            <span class="flex items-center space-x-1">
                <span class="w-3 h-3 rounded-full bg-indigo-200"></span>
                <span>ইভেন্ট</span>
            </span>
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-2 text-sm">
            {{-- Weekday headers --}}
            @foreach (banglaWeekDays() as $wd)
                <div class="text-center font-medium text-gray-700 py-2">{{ $wd }}</div>
            @endforeach

            {{-- Empty slots before first day --}}
            @php
                $startWeekDay = $startOfMonth->dayOfWeek;
                $slotCount = $startWeekDay;
                $daysInMonth = $endOfMonth->day;
            @endphp

            @for ($i = 0; $i < $slotCount; $i++)
                <div class="h-28 bg-transparent"></div>
            @endfor

            {{-- Days --}}
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $date = $current->copy()->day($day)->toDateString();
                    $dayEvents = $events->get($date, collect());
                    $isToday = \Illuminate\Support\Carbon::now()->toDateString() === $date;
                @endphp

                <div
                    class="h-28 p-2 bg-white rounded-lg shadow-sm border {{ $isToday ? 'border-indigo-400 ring-1 ring-indigo-50' : 'border-gray-100' }}">
                    <div class="flex justify-between items-start">
                        <div class="text-xs text-gray-500">{{ bn_num($day) }}</div>
                        @if ($dayEvents->count())
                            <div class="text-xs text-white px-2 py-0.5 rounded-full text-[11px] bg-indigo-600">
                                {{ bn_num($dayEvents->count()) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-2 space-y-1 max-h-20 overflow-auto">
                        @php
                            // type => tailwind classes fallback
                            $eventColors = [
                                'attendance' => 'bg-blue-200 text-blue-800',
                                'leave' => 'bg-red-200 text-red-800',
                                'holiday' => 'bg-green-200 text-green-800',
                                'event' => 'bg-indigo-200 text-indigo-800',
                            ];

                            // Optional: mapping to Bangla labels (use in view if needed)
                            $typeLabels = [
                                'attendance' => 'হাজিরা',
                                'leave' => 'ছুটি',
                                'holiday' => 'ছুটির দিন',
                                'event' => 'ইভেন্ট',
                            ];
                        @endphp

                        @foreach ($dayEvents as $ev)
                            @php
                                // Normalize type (avoid mismatch like " Holiday " or "Holiday")
                                $type = isset($ev->type) ? strtolower(trim($ev->type)) : '';

                                // If a custom color exists and looks like a hex/color string, use it via inline style.
                                $customColor = null;
                                if (!empty($ev->color)) {
                                    // sanitize a bit: accept values starting with '#' or 'rgb' or named colors
                                    $c = trim($ev->color);
                                    if (
                                        str_starts_with($c, '#') ||
                                        str_starts_with($c, 'rgb') ||
                                        preg_match('/^[a-zA-Z]+$/', $c)
                                    ) {
                                        $customColor = $c;
                                    }
                                }

                                if ($customColor) {
                                    // Use inline style for arbitrary color values. Use white text for contrast by default.
                                    $inlineStyle = "background: {$customColor};";
                                    $classes = 'text-white';
                                } else {
                                    // No custom color — use the type->tailwind fallback
                                    $classes = $eventColors[$type] ?? 'bg-gray-100 text-gray-800';
                                    $inlineStyle = '';
                                }

                                // Human-readable label (Bangla fallback to ucfirst type)
                                $label = $typeLabels[$type] ?? ucfirst($type);
                            @endphp

                            <div class="flex items-center justify-between gap-2 p-1 rounded text-xs {{ $classes }}"
                                style="{{ $inlineStyle }}">
                                <div class="truncate">
                                    <strong class="text-sm">{{ $ev->title }}</strong>
                                    <div class="text-xs">{{ $label }}</div>
                                </div>

                                @if ($ev->user_id === auth()->id())
                                    <form method="POST" action="{{ route('calendar.events.destroy', $ev) }}"
                                        onsubmit="return confirm('এই ইভেন্ট মুছে ফেলবেন?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 text-xs px-2 py-1">মুছুন</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach


                    </div>
                </div>
            @endfor
        </div>

        {{-- Event Modal --}}
        <div x-data="{ open: false, payload: {} }" x-on:open-event-modal.window="open = true; payload = $event.detail" x-show="open"
            class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-black opacity-40" x-on:click="open = false"></div>

            <div class="relative bg-white rounded-lg max-w-lg w-full shadow-lg p-6 z-10">
                <h3 class="text-lg font-semibold mb-3">নতুন ইভেন্ট</h3>
                <form method="POST" action="{{ route('calendar.events.store') }}">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium">শিরোনাম</label>
                            <input name="title" required class="w-full mt-1 border rounded px-3 py-2" />
                        </div>

                        <div>
                            <label class="text-sm font-medium">বর্ণনা</label>
                            <textarea name="description" rows="3" class="w-full mt-1 border rounded px-3 py-2"></textarea>
                        </div>

                        <div>
                            <label class="text-sm font-medium">তারিখ</label>
                            <input name="date" type="date"
                                :value="payload.date ?? '{{ \Illuminate\Support\Carbon::now()->toDateString() }}'"
                                class="w-full mt-1 border rounded px-3 py-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-sm font-medium">শুরুর সময়</label>
                                <input name="start_time" type="time" class="w-full mt-1 border rounded px-3 py-2" />
                            </div>
                            <div>
                                <label class="text-sm font-medium">শেষ সময়</label>
                                <input name="end_time" type="time" class="w-full mt-1 border rounded px-3 py-2" />
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium">টাইপ</label>
                            <select name="type" class="w-full mt-1 border rounded px-3 py-2">
                                <option value="event">ইভেন্ট</option>
                                <option value="attendance">হাজিরা</option>
                                <option value="leave">ছুটি</option>
                                <option value="holiday">ছুটির দিন</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">রঙ (বিকল্প)</label>
                            <input name="color" type="color" class="w-12 h-10 p-0 border rounded" />
                            <span class="text-xs text-gray-500 ml-2">প্রদর্শনের জন্য</span>
                        </div>

                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" @click="open = false" class="px-4 py-2 border rounded">বাতিল</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">সংরক্ষণ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- PHP Helpers --}}
    @php
        if (!function_exists('bn_num')) {
            function bn_num($num)
            {
                $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                return str_replace($en, $bn, (string) $num);
            }
        }

        if (!function_exists('banglaMonth')) {
            function banglaMonth($carbon)
            {
                $months = [
                    1 => 'জানুয়ারী',
                    2 => 'ফেব্রুয়ারী',
                    3 => 'মার্চ',
                    4 => 'এপ্রিল',
                    5 => 'মে',
                    6 => 'জুন',
                    7 => 'জুলাই',
                    8 => 'আগস্ট',
                    9 => 'সেপ্টেম্বর',
                    10 => 'অক্টোবর',
                    11 => 'নভেম্বর',
                    12 => 'ডিসেম্বর',
                ];
                return $months[intval($carbon->month)] ?? $carbon->format('F');
            }
        }

        if (!function_exists('banglaWeekDays')) {
            function banglaWeekDays()
            {
                return ['রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহস্পতি', 'শুক্র', 'শনি'];
            }
        }

        $eventColors = [
            'attendance' => 'bg-blue-200 text-blue-800',
            'leave' => 'bg-red-200 text-red-800',
            'holiday' => 'bg-green-200 text-green-800',
            'event' => 'bg-indigo-200 text-indigo-800',
        ];
    @endphp

</x-viewer-layout>
