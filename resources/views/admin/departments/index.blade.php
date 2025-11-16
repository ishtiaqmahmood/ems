<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Departments</h1>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <a href="{{ route('admin.departments.create') }}"
                class="px-4 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition">
                Create Department
            </a>

            <form action="{{ route('admin.departments.index') }}" method="GET" class="flex w-full md:w-auto gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                    placeholder="Search departments...">
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                    Search
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200" id="departments-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-500">Sort</th>
                        <th class="px-4 py-2 text-left text-gray-500">#</th>
                        <th class="px-4 py-2 text-left text-gray-500">Organization</th>
                        <th class="px-4 py-2 text-left text-gray-500">Name</th>
                        <th class="px-4 py-2 text-left text-gray-500">Code</th>
                        <th class="px-4 py-2 text-left text-gray-500">Status</th>
                        <th class="px-4 py-2 text-left text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable" class="divide-y divide-gray-200">
                    @foreach ($departments as $department)
                        <tr data-id="{{ $department->id }}" class="hover:bg-gray-50">
                            <td class="px-4 py-2 drag-handle cursor-move text-gray-400 text-lg">☰</td>
                            <td class="px-4 py-2">{{ $department->id }}</td>
                            <td class="px-4 py-2">{{ $department->organization->name ?? '-' }}</td>
                            <td class="px-4 py-2 font-medium text-gray-700">
                                <a href="{{ route('admin.departments.show', $department) }}"
                                    class="hover:text-sky-600 transition">
                                    {{ $department->name }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $department->code ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $department->status == 'active' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $department->status == 'inactive' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $department->status == 'archived' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($department->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.departments.edit', $department) }}"
                                    class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-sm">Edit</a>
                                <form action="{{ route('admin.departments.destroy', $department) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>

    @push('scripts')
        <!-- jQuery + jQuery UI -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            $(function() {
                $("#sortable").sortable({
                    handle: '.drag-handle',
                    update: function(event, ui) {
                        let order = [];
                        $('#sortable tr').each(function() {
                            order.push($(this).data('id'));
                        });

                        $.ajax({
                            url: "{{ route('admin.departments.sort') }}",
                            method: 'POST',
                            data: {
                                order: order,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                if (res.success) console.log('Order updated');
                            }
                        });
                    }
                }).disableSelection();
            });
        </script>
    @endpush
</x-admin-layout>
