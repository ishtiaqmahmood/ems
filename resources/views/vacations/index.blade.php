<x-viewer-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="bg-white shadow-2xl rounded-2xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between bg-gradient-to-r from-sky-600 to-sky-500 text-white px-6 py-5">
                <h2 class="text-xl sm:text-2xl font-semibold flex items-center gap-2">
                    <i class="bi bi-calendar-week text-white text-xl"></i>
                    Leave Requests
                </h2>

                @if (auth()->user()->role === 'Viewer')
                    <a href="{{ route('vacations.create') }}"
                        class="mt-3 sm:mt-0 inline-flex items-center gap-2 bg-white text-sky-600 px-4 py-2.5 rounded-xl font-medium shadow hover:bg-sky-50 transition-all duration-200">
                        <i class="bi bi-plus-circle"></i> Apply Leave
                    </a>
                @endif

                <!-- Leave Summary button -->
                @if (auth()->user()->role === 'Viewer')
                    <a href="{{ route('vacations.summary') }}"
                        class="inline-flex items-center gap-2 bg-white text-sky-600 px-4 py-2.5 rounded-xl font-medium shadow hover:bg-sky-50 transition-all duration-200">
                        <i class="bi bi-bar-chart-line"></i> Leave Summary
                    </a>
                @elseif(in_array(auth()->user()->role, ['Admin', 'HR']))
                    <a href="{{ route('vacations.adminSummary') }}"
                        class="inline-flex items-center gap-2 bg-white text-sky-600 px-4 py-2.5 rounded-xl font-medium shadow hover:bg-sky-50 transition-all duration-200">
                        <i class="bi bi-bar-chart-line"></i> Leave Summary
                    </a>
                @endif
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">Employee</th>
                            <th class="px-6 py-3">Period</th>
                            <th class="px-6 py-3 text-center">Days</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3">Reason</th>
                            @if (in_array(auth()->user()->role, ['Admin', 'HR']))
                                <th class="px-6 py-3 text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($vacations as $vacation)
                            <tr class="hover:bg-sky-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $vacation->user->name }}</td>
                                <td class="px-6 py-4">{{ $vacation->start_date }} → {{ $vacation->end_date }}</td>
                                <td class="px-6 py-4 text-center font-semibold">{{ $vacation->total_days }}</td>
                                <td class="px-6 py-4 capitalize">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-sky-100 text-sky-700">
                                        {{ $vacation->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $color = match ($vacation->status) {
                                            'approved' => 'green',
                                            'rejected' => 'red',
                                            default => 'yellow',
                                        };
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-700">
                                        {{ ucfirst($vacation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $vacation->reason ?? '—' }}
                                </td>

                                @if (in_array(auth()->user()->role, ['Admin', 'HR']))
                                    <td class="px-6 py-4 text-center space-x-1">
                                        @if ($vacation->status === 'pending')
                                            <form action="{{ route('vacations.updateStatus', $vacation) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-green-500 text-white text-xs rounded-xl hover:bg-green-600 transition">
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('vacations.updateStatus', $vacation) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-xl hover:bg-red-600 transition">
                                                    <i class="bi bi-x-circle"></i> Reject
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic">—</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-400 italic">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No leave requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 border-t border-gray-100 px-6 py-4">
                {{ $vacations->links() }}
            </div>
        </div>
    </div>
</x-viewer-layout>
