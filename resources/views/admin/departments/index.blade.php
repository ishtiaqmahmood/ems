<x-admin-layout>
    <div class="container mx-auto px-4 py-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1
                class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-sky-600 to-blue-400 drop-shadow">
                Departments
            </h1>
        </div>

        {{-- Actions Row --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">

            {{-- Create Button --}}
            <a href="{{ route('admin.departments.create') }}"
                class="px-5 py-2.5 bg-gradient-to-r from-sky-600 to-blue-500 text-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition">
                + Create Department
            </a>

            {{-- Search --}}
            <form action="{{ route('admin.departments.index') }}" method="GET"
                class="flex w-full md:w-auto gap-2 items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                    placeholder="Search departments...">

                <button type="submit"
                    class="px-5 py-2.5 bg-gray-800 text-white rounded-xl shadow hover:bg-black transition">
                    Search
                </button>
            </form>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 rounded-xl border border-green-200 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Departments Table --}}
        <div class="overflow-x-auto bg-white shadow-xl border border-gray-100 rounded-2xl">
            <table class="min-w-full">
                <thead class="bg-gray-50 text-gray-600 text-sm font-semibold uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">Sort</th>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Organization</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Code</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody id="sortable" class="divide-y divide-gray-200 text-gray-700">
                    @foreach ($departments as $department)
                        <tr data-id="{{ $department->id }}" class="hover:bg-gray-50 transition">

                            {{-- Sort Handle --}}
                            <td
                                class="px-4 py-3 cursor-move drag-handle text-gray-300 text-xl hover:text-gray-500 transition">
                                ☰
                            </td>

                            <td class="px-4 py-3">{{ $department->id }}</td>
                            <td class="px-4 py-3">{{ $department->organization->name ?? '-' }}</td>

                            {{-- Name --}}
                            <td class="px-4 py-3 font-semibold">
                                <a href="{{ route('admin.departments.show', $department) }}"
                                    class="text-gray-800 hover:text-sky-600 transition">
                                    {{ $department->name }}
                                </a>
                            </td>

                            <td class="px-4 py-3">{{ $department->code ?? '-' }}</td>

                            {{-- Improved Status Badge --}}
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-700 border-green-200',
                                        'inactive' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'archived' => 'bg-gray-100 text-gray-700 border-gray-300',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 text-xs rounded-full border
                                    {{ $statusColors[$department->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($department->status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('admin.departments.edit', $department) }}"
                                    class="px-3 py-1.5 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.departments.destroy', $department) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $departments->links() }}
        </div>
    </div>

    @push('scripts')
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
                                console.log('Order updated');
                            }
                        });
                    }
                }).disableSelection();
            });
        </script>
    @endpush
</x-admin-layout>
