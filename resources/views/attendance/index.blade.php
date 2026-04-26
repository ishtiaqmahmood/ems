<x-viewer-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-10">

        {{-- Header & Stats --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                    <span class="p-3 bg-sky-600 text-white rounded-2xl shadow-xl shadow-sky-200">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </span>
                    {{ $user->role == 'Viewer' ? 'My Attendance' : 'Attendance Overview' }}
                </h2>
                <p class="text-gray-500 font-medium ml-1">Track and manage daily work logs and check-ins.</p>
            </div>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('attendance.export.pdf') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-rose-100 text-rose-600 font-bold rounded-2xl hover:bg-rose-50 transition-all duration-300 shadow-sm">
                    <i class="bi bi-file-earmark-pdf text-xl"></i>
                    <span>Export PDF</span>
                </a>
                <a href="{{ route('attendance.create') }}"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-sky-600 text-white font-bold rounded-2xl hover:bg-sky-700 hover:scale-105 transition-all duration-300 shadow-xl shadow-sky-200">
                    <i class="bi bi-plus-lg text-lg font-black"></i>
                    <span>New Record</span>
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $stats = [
                    [
                        'label' => 'This Month',
                        'value' => $totalThisMonth,
                        'icon' => 'bi-calendar-date',
                        'color' => 'sky',
                        'bg' => 'from-sky-500 to-blue-600',
                    ],
                    [
                        'label' => 'This Year',
                        'value' => $totalThisYear,
                        'icon' => 'bi-calendar4-week',
                        'color' => 'indigo',
                        'bg' => 'from-indigo-500 to-violet-600',
                    ],
                    [
                        'label' => 'Total Presence',
                        'value' => $totalAllTime,
                        'icon' => 'bi-award',
                        'color' => 'emerald',
                        'bg' => 'from-emerald-500 to-teal-600',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div
                    class="relative overflow-hidden bg-gradient-to-br {{ $stat['bg'] }} p-8 rounded-[2rem] shadow-2xl text-white transition-transform duration-300 hover:-translate-y-2">
                    <div class="absolute -right-4 -bottom-4 opacity-10">
                        <i class="bi {{ $stat['icon'] }} text-9xl"></i>
                    </div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-widest opacity-80">{{ $stat['label'] }}</span>
                            <i class="bi {{ $stat['icon'] }} text-2xl opacity-80"></i>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black">{{ $stat['value'] }}</span>
                            <span class="text-sm font-bold opacity-70">Days</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Recent Logs</h3>
                <div class="text-sm text-gray-500 font-medium">Showing latest records</div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-xs font-black uppercase tracking-widest border-b border-gray-50">
                            <th class="px-8 py-6">Date & Employee</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6">Check In/Out</th>
                            <th class="px-8 py-6 text-center">Total Hours</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($attendances as $attendance)
                            <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold group-hover:bg-sky-100 group-hover:text-sky-600 transition-colors">
                                            {{ \Carbon\Carbon::parse($attendance->date)->format('d') }}
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-bold">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</p>
                                            @if ($user->role != 'Viewer')
                                                <p class="text-gray-500 text-xs font-medium">{{ $attendance->user->name }}</p>
                                            @else
                                                <p class="text-gray-500 text-xs font-medium">{{ \Carbon\Carbon::parse($attendance->date)->format('l') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-8 py-6">
                                    @php
                                        $statusClass = [
                                            'Present' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'Leave' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'Absent' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-full text-xs font-black border {{ $statusClass[$attendance->status] ?? 'bg-gray-50 text-gray-600 border-gray-100' }} uppercase tracking-tighter">
                                        {{ $attendance->status }}
                                    </span>
                                </td>

                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="px-3 py-1 bg-slate-50 rounded-lg font-bold text-gray-700 border border-slate-100">
                                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--:--' }}
                                        </div>
                                        <i class="bi bi-arrow-right text-gray-300"></i>
                                        <div class="px-3 py-1 bg-slate-50 rounded-lg font-bold text-gray-700 border border-slate-100">
                                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--:--' }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-black text-gray-900">{{ $attendance->total_hours ?? '0.00' }}</span>
                                    <span class="text-xs font-bold text-gray-400 ml-1 uppercase">hrs</span>
                                </td>

                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('attendance.show', $attendance) }}"
                                            class="p-2.5 text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white rounded-xl transition-all duration-300 shadow-sm"
                                            title="View Details">
                                            <i class="bi bi-eye-fill text-lg"></i>
                                        </a>
                                        <a href="{{ route('attendance.edit', $attendance) }}"
                                            class="p-2.5 text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-xl transition-all duration-300 shadow-sm"
                                            title="Edit Record">
                                            <i class="bi bi-pencil-fill text-lg"></i>
                                        </a>
                                        @if (in_array($user->role, ['Admin', 'HR']) || $attendance->user_id == $user->id)
                                            <form action="{{ route('attendance.destroy', $attendance) }}" method="POST"
                                                onsubmit="return confirm('Permanently delete this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2.5 text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-xl transition-all duration-300 shadow-sm"
                                                    title="Delete Record">
                                                    <i class="bi bi-trash3-fill text-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-200">
                                            <i class="bi bi-calendar-x text-5xl"></i>
                                        </div>
                                        <p class="text-gray-400 font-bold">No attendance records found for this period.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($attendances->hasPages())
                <div class="p-8 border-t border-gray-50 bg-gray-50/30">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>
</x-viewer-layout>
