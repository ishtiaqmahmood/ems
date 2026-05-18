<x-admin-layout>
    <div class="max-w-5xl mx-auto p-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-clock-history text-sky-600 text-2xl"></i>
                {{ $employer->name }} – Salary History
            </h1>

            <a href="{{ route('admin.salaries.create', $employer) }}"
                class="px-4 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition inline-flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add Salary
            </a>
        </div>

        <!-- Salary Table -->
        <div class="bg-white shadow-xl rounded-2xl overflow-x-auto custom-scrollbar">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Basic</th>
                        <th class="px-4 py-3 text-left">Gross</th>
                        <th class="px-4 py-3 text-left">Reason</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($salaries as $salary)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $salary->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">
                                ৳{{ number_format($salary->basic_salary, 2) }}</td>
                            <td class="px-4 py-3 font-medium text-green-600">
                                ৳{{ number_format($salary->gross_salary, 2) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $salary->change_reason }}</td>
                            <td class="px-4 py-3 text-center flex justify-center gap-2">
                                <form method="POST"
                                    action="{{ route('admin.salaries.destroy', [$employer, $salary->id]) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this salary record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 transition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                No salary records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $salaries->links() }}
        </div>
    </div>
</x-admin-layout>
