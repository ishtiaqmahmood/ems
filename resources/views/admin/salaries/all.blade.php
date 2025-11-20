<x-admin-layout>

    <div class="p-6 space-y-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-sky-600"><i class="bi bi-cash-stack"></i></span>
                    Employer Salaries
                </h1>
                <p class="text-gray-500 text-sm mt-1">Track, filter & manage employer salary records</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.employers.index') }}"
                    class="px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-xl text-sm shadow-md flex items-center gap-2 transition">
                    <i class="bi bi-people"></i> All Employers
                </a>
            </div>
        </div>

        <!-- Add Salary Dropdown -->
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100">
            <form id="add-salary-form" class="flex flex-col md:flex-row gap-4 md:items-end">
                <div class="flex-1">
                    <label class="text-sm font-medium text-gray-700">Employer</label>
                    <select id="employer_id"
                        class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">Select Employer</option>
                        @foreach ($allEmployers as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md text-sm flex items-center gap-2 transition">
                    <i class="bi bi-plus-circle"></i> Add Salary
                </button>
            </form>

            <script>
                document.getElementById('add-salary-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const employerId = document.getElementById('employer_id').value;
                    if (!employerId) return;
                    window.location.href = `/admin/employers/${employerId}/salaries/create`;
                });
            </script>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Search -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Employer, Salary, Grade..."
                        class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Employer Filter -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Employer</label>
                    <select name="employer"
                        class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">All Employers</option>
                        @foreach ($allEmployers as $emp)
                            <option value="{{ $emp->id }}" {{ request('employer') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Grade Filter -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Salary Grade</label>
                    <select name="grade"
                        class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">All Grades</option>
                        @foreach ($allGrades as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Effective From</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <div class="md:col-span-4 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl shadow flex items-center gap-2 transition">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>

            </form>
        </div>

        <!-- Salaries Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">

            <table class="min-w-full text-sm">
                <thead class="bg-gray-100/70 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Employer</th>
                        <th class="px-6 py-3 text-left">Grade</th>
                        <th class="px-6 py-3 text-left">Basic</th>
                        <th class="px-6 py-3 text-left">Gross</th>
                        <th class="px-6 py-3 text-left">Effective From</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($salaries as $salary)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- Employer -->
                            <td class="px-6 py-3">
                                <div class="font-semibold text-gray-900">{{ $salary->employer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $salary->employer->email }}</div>
                            </td>

                            <!-- Grade -->
                            <td class="px-6 py-3">
                                @if ($salary->grade)
                                    <span class="px-2.5 py-1 bg-sky-100 text-sky-700 text-xs rounded-lg">
                                        {{ $salary->grade->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">N/A</span>
                                @endif
                            </td>

                            <!-- Basic Salary -->
                            <td class="px-6 py-3 text-gray-800 font-semibold">
                                ৳{{ number_format($salary->basic_salary, 2) }}
                            </td>

                            <!-- Gross Salary -->
                            <td class="px-6 py-3 text-green-600 font-semibold">
                                ৳{{ number_format($salary->gross_salary, 2) }}
                            </td>

                            <!-- Effective From -->
                            <td class="px-6 py-3">
                                {{ $salary->effective_from->format('d M, Y') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-3 flex justify-center gap-3">

                                <!-- Edit -->
                                <a href="{{ route('admin.salaries.edit', [$salary->employer_id, $salary->id]) }}"
                                    class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs shadow transition flex items-center gap-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <!-- Delete -->
                                <form method="POST"
                                    action="{{ route('admin.salaries.destroy', [$salary->employer_id, $salary->id]) }}"
                                    onsubmit="return confirm('Delete this salary record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs shadow transition flex items-center gap-1">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                No salary records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <!-- Pagination -->
        <div>
            {{ $salaries->appends(request()->query())->links() }}
        </div>

    </div>

</x-admin-layout>
