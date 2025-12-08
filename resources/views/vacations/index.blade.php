<x-viewer-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="bg-white shadow-2xl rounded-2xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between bg-gradient-to-r from-sky-600 to-sky-500 text-white px-6 py-5">
                <h2 class="text-xl sm:text-2xl font-semibold flex items-center gap-2">
                    <i class="bi bi-calendar-week text-white text-xl"></i>
                    My Leave Requests
                </h2>

                <a href="{{ route('vacations.create') }}"
                    class="mt-3 sm:mt-0 inline-flex items-center gap-2 bg-white text-sky-600 px-4 py-2.5 rounded-xl font-medium shadow hover:bg-sky-50 transition-all duration-200">
                    <i class="bi bi-plus-circle"></i> Apply Leave
                </a>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">Period</th>
                            <th class="px-6 py-3 text-center">Days</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3">Reason</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($vacations as $vacation)
                            <tr class="hover:bg-sky-50 transition">
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
                                <td class="px-6 py-4 text-gray-700">{{ $vacation->reason ?? '—' }}</td>

                                <td class="px-6 py-4 text-center space-x-2">
                                    @if ($vacation->status === 'pending')
                                        <a href="{{ route('vacations.edit', $vacation) }}"
                                            class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded-xl hover:bg-blue-600 transition">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a>

                                        <form action="{{ route('vacations.destroy', $vacation) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this leave request?')"
                                                class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-xl hover:bg-red-600 transition">
                                                <i class="bi bi-trash-fill"></i> Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs italic">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-400 italic">
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
