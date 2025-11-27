<x-admin-layout>
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h1
                class="text-4xl font-extrabold bg-clip-text text-transparent
            bg-gradient-to-r from-sky-600 to-blue-500 drop-shadow-lg">
                All Employers
            </h1>
            <a href="{{ route('admin.employers.create') }}"
                class="px-5 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add Employer
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" class="flex flex-col md:flex-row gap-3 mb-4">
            <input type="text" name="search" placeholder="Search by name, email, phone..."
                value="{{ request('search') }}"
                class="border rounded-lg px-4 py-2 w-full md:w-1/3 focus:ring-2 focus:ring-sky-500 focus:outline-none transition shadow-sm">
            <button type="submit"
                class="bg-sky-600 text-white px-4 py-2 rounded-lg shadow hover:bg-sky-700 transition">
                <i class="bi bi-search me-1"></i> Search
            </button>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 uppercase text-sm text-gray-700">
                    <tr>
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">Name</th>
                        <th class="p-3 border-b">Email</th>
                        <th class="p-3 border-b">Department</th>
                        <th class="p-3 border-b">Section</th>
                        <th class="p-3 border-b">Status</th>
                        <th class="p-3 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($employers as $index => $emp)
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="p-3">{{ $employers->firstItem() + $index }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.employers.show', $emp) }}"
                                    class="text-sky-600 hover:text-sky-800 font-medium hover:underline transition">
                                    {{ $emp->name }}
                                </a>
                            </td>
                            <td class="p-3">{{ $emp->email }}</td>
                            <td class="p-3">{{ $emp->department->name ?? '-' }}</td>
                            <td class="p-3">{{ $emp->section->name ?? '-' }}</td>
                            <td class="p-3">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-yellow-100 text-yellow-800',
                                        'resigned' => 'bg-red-100 text-red-800',
                                        'terminated' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$emp->status] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ ucfirst($emp->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-center flex justify-center items-center gap-2">
                                <a href="{{ route('admin.employers.edit', $emp) }}"
                                    class="text-sky-600 hover:text-sky-800 transition">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>
                                <form action="{{ route('admin.employers.destroy', $emp) }}" method="POST"
                                    onsubmit="return confirm('Delete this employer?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">No employers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-end">
            {{ $employers->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>
