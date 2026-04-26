<x-viewer-layout>
    <div class="max-w-4xl mx-auto p-6 space-y-8">

        {{-- Breadcrumb --}}
        <nav class="flex text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-sky-600 inline-flex items-center">
                        <i class="bi bi-house-door-fill mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('attendance.index') }}" class="hover:text-sky-600">Attendance</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-400">Record Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Main Content --}}
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-sky-100/50">

            {{-- Header Section --}}
            <div class="bg-gradient-to-r from-sky-600 to-blue-700 p-8 text-white relative">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="bi bi-calendar-check text-8xl"></i>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <p class="text-sky-100 text-sm font-medium uppercase tracking-wider mb-2">Attendance Record</p>
                        <h1 class="text-3xl font-extrabold flex items-center gap-3">
                            {{ $attendance->user->name }}
                        </h1>
                        <p class="text-sky-100 mt-1 flex items-center gap-2">
                            <i class="bi bi-calendar3"></i>
                            {{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}
                            <span class="mx-2">•</span>
                            {{ \Carbon\Carbon::parse($attendance->date)->format('l') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $statusColors = [
                                'Present' => 'bg-emerald-400/20 text-emerald-100 border-emerald-400/30',
                                'Leave'   => 'bg-amber-400/20 text-amber-100 border-amber-400/30',
                                'Absent'  => 'bg-rose-400/20 text-rose-100 border-rose-400/30',
                            ];
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-bold border {{ $statusColors[$attendance->status] ?? 'bg-white/20 text-white border-white/30' }} backdrop-blur-md">
                            <i class="bi bi-circle-fill text-[10px] mr-2"></i>
                            {{ $attendance->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Details Grid --}}
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Time Information --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <i class="bi bi-clock-history text-sky-600"></i>
                        Time Tracking
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Check In</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $attendance->check_in ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in)->format('h:i A') : '--:--' }}
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Check Out</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $attendance->check_out ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out)->format('h:i A') : '--:--' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 bg-sky-50 rounded-2xl border border-sky-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-sky-600 uppercase mb-1">Total Duration</p>
                            <p class="text-3xl font-black text-sky-900">
                                {{ $attendance->total_hours ?? '0.00' }} <span class="text-sm font-medium">hrs</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-sky-600 shadow-sm">
                            <i class="bi bi-hourglass-split text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- User & System Info --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <i class="bi bi-person-badge text-sky-600"></i>
                        Metadata
                    </h2>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition-colors">
                            <span class="text-gray-500">Employee ID</span>
                            <span class="font-bold text-gray-800">#EMP-{{ str_pad($attendance->user_id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition-colors">
                            <span class="text-gray-500">Department</span>
                            <span class="font-bold text-gray-800">{{ $attendance->user->department->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition-colors">
                            <span class="text-gray-500">Recorded At</span>
                            <span class="font-medium text-gray-600 text-sm">{{ $attendance->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>

                    @if($attendance->notes)
                    <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                        <p class="text-xs font-semibold text-amber-700 uppercase mb-2">Notes</p>
                        <p class="text-gray-700 text-sm italic">{{ $attendance->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="bg-slate-50 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex gap-3">
                    <a href="{{ route('attendance.edit', $attendance) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <i class="bi bi-pencil"></i> Edit Record
                    </a>
                </div>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition shadow-lg">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <a href="{{ route('attendance.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-700 transition shadow-lg shadow-sky-200">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-viewer-layout>
