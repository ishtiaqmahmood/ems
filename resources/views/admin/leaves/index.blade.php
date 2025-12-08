<x-admin-layout>
    <div class="p-6 space-y-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.leaves.index') }}"
                class="flex items-center w-full md:w-auto bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="relative flex-1">
                    <!-- Search Icon -->
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 rounded-l-lg"
                        placeholder="Search by user, type, or status">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold transition duration-300 rounded-r-lg">
                    Search
                </button>
            </form>

            <!-- Reset Button -->
            <a href="{{ route('admin.leaves.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg font-medium transition duration-300">
                <i class="bi bi-x-circle mr-2"></i> Reset
            </a>

        </div>


        <!-- Page Heading -->
        <div class="flex items-center justify-between">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">
                Leave Applications
            </h1>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table Wrapper -->
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            User
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Type
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Duration
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Status
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($leaves as $leave)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-800 font-medium">
                                {{ $leave->user->name }}
                            </td>

                            <td class="px-6 py-4 text-center capitalize font-semibold text-gray-700">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                    {{ $leave->type }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center text-gray-700">
                                <span class="font-medium">
                                    {{ $leave->start_date->format('d M Y') }}
                                </span>
                                <span class="mx-1 text-gray-400">→</span>
                                <span class="font-medium">
                                    {{ $leave->end_date->format('d M Y') }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    ({{ $leave->total_days }} days)
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    $color = match ($leave->status) {
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-yellow-100 text-yellow-700',
                                    };
                                @endphp

                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('admin.leaves.show', $leave->id) }}"
                                    class="inline-flex items-center px-4 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 shadow-sm transition">
                                    View
                                </a>

                                <form action="{{ route('admin.leaves.destroy', $leave->id) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete this leave application?')"
                                        class="inline-flex items-center px-4 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 shadow-sm transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $leaves->links() }}
        </div>

    </div>
</x-admin-layout>
