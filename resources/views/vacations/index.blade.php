<x-viewer-layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between
                       bg-gradient-to-r from-sky-600 via-sky-500 to-sky-600
                       px-6 py-6 text-white">

                <h2 class="text-xl sm:text-2xl font-bold flex items-center gap-3">
                    <i class="bi bi-calendar-week text-2xl"></i>
                    My Leave Requests
                </h2>

                <a href="{{ route('vacations.create') }}"
                    class="inline-flex items-center gap-2 bg-white/95 text-sky-600
                           px-5 py-2.5 rounded-xl font-semibold shadow
                           hover:bg-white hover:shadow-md transition">
                    <i class="bi bi-plus-circle"></i>
                    Apply Leave
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wide font-semibold border-b">
                        <tr>
                            <th class="px-6 py-4">Period</th>
                            <th class="px-6 py-4 text-center">Days</th>
                            <th class="px-6 py-4">Leave Type</th>
                            <th class="px-6 py-4">Replacement</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            {{-- <th class="px-6 py-4">Reason</th> --}}
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($vacations as $vacation)
                            <tr class="hover:bg-sky-50/60 transition">

                                <!-- Period -->
                                <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                    {{ $vacation->start_date }}
                                    <span class="text-gray-400 mx-1">→</span>
                                    {{ $vacation->end_date }}
                                </td>

                                <!-- Days -->
                                <td class="px-6 py-4 text-center font-bold text-gray-800">
                                    {{ $vacation->total_days }}
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full
                                               text-xs font-semibold bg-sky-100 text-sky-700">
                                        {{ $vacation->leaveType?->name_bn ?? '—' }}
                                    </span>
                                </td>

                                <!-- Replacement User -->
                                <td class="px-6 py-4">
                                    {{ $vacation->replacementUser?->name ?? '—' }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClasses = match ($vacation->status) {
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full
                                               text-xs font-semibold {{ $statusClasses }}">
                                        {{ ucfirst($vacation->status) }}
                                    </span>
                                </td>

                                {{-- <!-- Reason -->
                                <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                    {{ $vacation->reason ?: '—' }}
                                </td> --}}

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    @if ($vacation->status === 'pending')
                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('vacations.edit', $vacation) }}"
                                                class="inline-flex items-center gap-1
                                                       px-3 py-1.5 rounded-lg
                                                       bg-blue-500 text-white text-xs font-semibold
                                                       hover:bg-blue-600 transition">
                                                <i class="bi bi-pencil-fill"></i>
                                                Edit
                                            </a>

                                            <form action="{{ route('vacations.destroy', $vacation) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this leave request?')"
                                                    class="inline-flex items-center gap-1
                                                           px-3 py-1.5 rounded-lg
                                                           bg-red-500 text-white text-xs font-semibold
                                                           hover:bg-red-600 transition">
                                                    <i class="bi bi-trash-fill"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-14 text-center text-gray-400">
                                    <i class="bi bi-inbox text-4xl block mb-3"></i>
                                    No leave requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 border-t px-6 py-4">
                {{ $vacations->links() }}
            </div>

        </div>
    </div>
</x-viewer-layout>
