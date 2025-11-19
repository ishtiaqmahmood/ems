<x-admin-layout>

    <div class="p-6 max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-calendar-event text-sky-600"></i>
                Events
            </h1>
            <a href="{{ route('admin.events.create') }}"
                class="px-5 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add Event
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="p-4 mb-6 bg-green-100 text-green-700 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Title</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Start</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">End</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($events as $event)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $event->title }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $event->start_datetime->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $event->end_datetime->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3 flex items-center gap-2">

                                <a href="{{ route('admin.events.edit', $event) }}"
                                    class="px-3 py-1 bg-gradient-to-r from-sky-500 to-sky-600 text-white rounded shadow hover:opacity-90 transition">
                                    Edit
                                </a>

                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Are you sure to delete this event?')"
                                        class="px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white rounded shadow hover:opacity-90 transition">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>

</x-admin-layout>
