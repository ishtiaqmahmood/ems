{{-- resources/views/admin/salary_grades/index.blade.php --}}
<x-admin-layout>
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-graph-up text-sky-600"></i> Salary Grades
            </h3>

            <a href="{{ route('admin.salary-grades.create') }}"
                class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow flex items-center gap-2">
                <i class="bi bi-plus-circle"></i> Add Grade
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-700 font-semibold">
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Level</th>
                        <th class="px-6 py-3">Basic Salary</th>
                        <th class="px-6 py-3">Gross</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($grades as $grade)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">{{ $grade->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $grade->name }}</td>
                            <td class="px-6 py-4">{{ $grade->level }}</td>
                            <td class="px-6 py-4 text-gray-800 font-semibold">
                                ৳{{ number_format($grade->basic_salary, 2) }}</td>
                            <td class="px-6 py-4 text-green-600 font-semibold">
                                ৳{{ number_format($grade->gross_salary, 2) }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">

                                <a href="{{ route('admin.salary-grades.edit', $grade) }}"
                                    class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-sm flex items-center gap-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('admin.salary-grades.destroy', $grade) }}" method="POST"
                                    onsubmit="return confirm('Delete this grade?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm flex items-center gap-1">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                No salary grades found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $grades->links() }}
        </div>

    </div>
</x-admin-layout>
