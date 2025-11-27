<x-admin-layout>
    <div class="p-6 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1
                    class="text-4xl font-extrabold bg-clip-text text-transparent
                    bg-gradient-to-r from-sky-600 to-blue-500 drop-shadow">
                    All Sections
                </h1>
                <p class="text-gray-500 mt-1">Manage all system sections from here.</p>
            </div>

            <a href="{{ route('admin.sections.create') }}"
                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 text-white shadow-lg
                hover:shadow-xl hover:scale-105 transition transform">
                + Create Section
            </a>
        </div>

        {{-- Filter Box --}}
        <div class="bg-white/70 backdrop-blur-lg border border-gray-200 rounded-2xl shadow px-6 py-5 space-y-4">

            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-funnel"></i> Filters
            </h2>

            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <input type="text" name="search" placeholder="Search sections..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none">

                <select name="sort_by" class="border border-gray-300 rounded-xl px-4 py-2">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created At
                    </option>
                </select>

                <select name="sort_order" class="border border-gray-300 rounded-xl px-4 py-2">
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-sky-600 text-white rounded-xl shadow hover:bg-sky-700 hover:scale-105 transition">
                    Apply Filters
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white/80 backdrop-blur rounded-2xl shadow-lg border border-gray-200">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wide">
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">Name</th>
                        <th class="p-3 border-b">Department</th>
                        <th class="p-3 border-b">Organization</th>
                        <th class="p-3 border-b">Status</th>
                        <th class="p-3 border-b text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sections as $index => $s)
                        <tr class="border-b hover:bg-gray-50/80 transition-all hover:scale-[1.01]">

                            <td class="p-3 text-gray-700">
                                {{ $sections->firstItem() + $index }}
                            </td>

                            {{-- Name --}}
                            <td class="p-3">
                                <a href="{{ route('admin.sections.show', $s) }}"
                                    class="font-semibold text-sky-600 hover:text-sky-800 hover:underline">
                                    {{ $s->name }}
                                </a>
                            </td>

                            <td class="p-3 text-gray-700">{{ $s->department->name ?? '-' }}</td>

                            <td class="p-3 text-gray-700">{{ $s->organization->name ?? '-' }}</td>

                            {{-- Status Badge --}}
                            <td class="p-3">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                                    @if ($s->status == 'active') bg-green-100 text-green-700
                                    @elseif ($s->status == 'inactive') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($s->status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="p-3 text-center flex justify-center items-center gap-3">

                                {{-- Edit --}}
                                <a href="{{ route('admin.sections.edit', $s) }}"
                                    class="p-2 rounded-full hover:bg-gray-100 text-sky-600 hover:scale-110 transition"
                                    title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.sections.destroy', $s) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 rounded-full hover:bg-gray-100 text-red-600 hover:scale-110 transition"
                                        title="Delete">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">No sections found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-end">
            <div class="shadow rounded-lg">
                {{ $sections->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
