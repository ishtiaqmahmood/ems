<x-admin-layout>
    <div class="p-6 space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">All Sections</h1>
            <a href="{{ route('admin.sections.create') }}"
                class="px-5 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition transform hover:scale-105">
                Create Section
            </a>
        </div>

        {{-- Search & Sort --}}
        <form method="GET" class="flex flex-col md:flex-row gap-3 items-start md:items-center mb-4">
            <input type="text" name="search" placeholder="Search sections..." value="{{ request('search') }}"
                class="border rounded-lg px-4 py-2 w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-sky-500">

            <select name="sort_by" class="border rounded-lg px-4 py-2">
                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created At
                </option>
            </select>

            <select name="sort_order" class="border rounded-lg px-4 py-2">
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
            </select>

            <button type="submit"
                class="bg-sky-600 text-white px-4 py-2 rounded-lg shadow hover:bg-sky-700 transition transform hover:scale-105">
                Filter
            </button>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
            <table class="w-full table-auto border-collapse text-left">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">Name</th>
                        <th class="p-3 border-b">Department</th>
                        <th class="p-3 border-b">Organization</th>
                        <th class="p-3 border-b">Status</th>
                        <th class="p-3 border-b text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @forelse ($sections as $index => $s)
                        <tr class="border-b hover:bg-gray-50 transition transform hover:scale-[1.01]">
                            {{-- Index Column --}}
                            <td class="p-3">{{ $sections->firstItem() + $index }}</td>

                            {{-- Name --}}
                            <td class="p-3">
                                <a href="{{ route('admin.sections.show', $s) }}"
                                    class="text-sky-600 font-semibold hover:underline">
                                    {{ $s->name }}
                                </a>
                            </td>

                            {{-- Department --}}
                            <td class="p-3">{{ $s->department->name ?? '-' }}</td>

                            {{-- Organization --}}
                            <td class="p-3">{{ $s->organization->name ?? '-' }}</td>

                            {{-- Status --}}
                            <td class="p-3">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $s->status == 'active' ? 'bg-gradient-to-r from-green-200 to-green-300 text-green-800' : '' }}
                                    {{ $s->status == 'inactive' ? 'bg-gradient-to-r from-yellow-200 to-yellow-300 text-yellow-800' : '' }}
                                    {{ $s->status == 'archived' ? 'bg-gradient-to-r from-red-200 to-red-300 text-red-800' : '' }}">
                                    {{ ucfirst($s->status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="p-3 text-center flex justify-center items-center space-x-2">
                                <a href="{{ route('admin.sections.edit', $s) }}"
                                    class="text-sky-600 hover:text-sky-800 p-2 rounded-full hover:bg-gray-100 transition"
                                    title="Edit Section">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <form action="{{ route('admin.sections.destroy', $s) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this section?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-gray-100 transition"
                                        title="Delete Section">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">No sections found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-end">
            {{ $sections->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin-layout>
