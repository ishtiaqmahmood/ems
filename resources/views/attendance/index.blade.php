<x-viewer-layout>
    <div class="max-w-7xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-3">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ $user->role == 'Viewer' ? 'আমার উপস্থিতি' : 'সমস্ত উপস্থিতি রেকর্ড' }}
            </h2>

            <a href="{{ route('attendance.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg transition-all duration-200 shadow">
                <i class="bi bi-plus-circle text-lg"></i>
                <span>নতুন উপস্থিতি যোগ করুন</span>
            </a>
            {{-- Export PDF Button --}}
            <a href="{{ route('attendance.export.pdf') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all duration-200 shadow">
                <i class="bi bi-file-earmark-pdf text-lg"></i>
                <span>Export PDF</span>
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-sky-500 to-sky-600 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-80">এই মাসের উপস্থিতি</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalThisMonth }}</p>
                    </div>
                    <i class="bi bi-calendar-check text-4xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-80">এই বছরের উপস্থিতি</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalThisYear }}</p>
                    </div>
                    <i class="bi bi-calendar-week text-4xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-80">সর্বমোট উপস্থিতি</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalAllTime }}</p>
                    </div>
                    <i class="bi bi-bar-chart text-4xl opacity-80"></i>
                </div>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Container --}}
        <div class="bg-white shadow rounded-xl overflow-hidden border border-gray-100">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-sky-600 text-white uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        @if ($user->role != 'Viewer')
                            <th class="px-4 py-3">User</th>
                        @endif
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Check In</th>
                        <th class="px-4 py-3">Check Out</th>
                        <th class="px-4 py-3">Total Hours</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($attendances as $attendance)
                        <tr class="hover:bg-sky-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>

                            @if ($user->role != 'Viewer')
                                <td class="px-4 py-3">{{ $attendance->user->name }}</td>
                            @endif

                            <td class="px-4 py-3">{{ $attendance->date }}</td>

                            <td class="px-4 py-3">
                                @php
                                    $color =
                                        $attendance->status == 'Present'
                                            ? 'bg-green-100 text-green-800'
                                            : ($attendance->status == 'Leave'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800');
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                    {{ $attendance->status }}
                                </span>
                            </td>

                            <td class="px-4 py-3">{{ $attendance->check_in ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $attendance->check_out ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $attendance->total_hours ?? '-' }}</td>

                            <td class="px-4 py-3 flex items-center justify-center gap-2">
                                <a href="{{ route('attendance.edit', $attendance) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-sky-100 text-sky-700 hover:bg-sky-200 rounded-lg transition">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                @if (in_array($user->role, ['Admin', 'HR']) || $attendance->user_id == $user->id)
                                    <form action="{{ route('attendance.destroy', $attendance) }}" method="POST"
                                        onsubmit="return confirm('Delete this record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $user->role != 'Viewer' ? 8 : 7 }}"
                                class="px-4 py-6 text-center text-gray-500">
                                No attendance records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $attendances->links('pagination::tailwind') }}
        </div>
    </div>
</x-viewer-layout>
