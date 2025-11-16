<x-admin-layout>
    <div class="p-6 space-y-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">All Employers</h1>
            <a href="{{ route('admin.employers.create') }}"
                class="px-5 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition">Add Employer</a>
        </div>

        {{-- Search --}}
        <form method="GET" class="flex gap-3 mb-4">
            <input type="text" name="search" placeholder="Search by name, email, phone..."
                value="{{ request('search') }}"
                class="border rounded-lg px-4 py-2 w-1/3 focus:ring-2 focus:ring-sky-500">
            <button class="bg-sky-600 text-white px-4 py-2 rounded-lg">Search</button>
        </form>

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
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $employers->firstItem() + $index }}</td>
                            <td class="p-3"><a href="{{ route('admin.employers.show', $emp) }}"
                                    class="text-sky-600 hover:underline">{{ $emp->name }}</a></td>
                            <td class="p-3">{{ $emp->email }}</td>
                            <td class="p-3">{{ $emp->department->name ?? '-' }}</td>
                            <td class="p-3">{{ $emp->section->name ?? '-' }}</td>
                            <td class="p-3">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $emp->status == 'active' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $emp->status == 'inactive' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $emp->status == 'resigned' || $emp->status == 'terminated' ? 'bg-red-200 text-red-800' : '' }}">
                                    {{ ucfirst($emp->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-center flex justify-center space-x-2">
                                <a href="{{ route('admin.employers.edit', $emp) }}"
                                    class="text-sky-600 hover:text-sky-800"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.employers.destroy', $emp) }}" method="POST"
                                    onsubmit="return confirm('Delete this employer?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800"><i
                                            class="bi bi-trash"></i></button>
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

        <div class="mt-4 flex justify-end">
            {{ $employers->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin-layout>
