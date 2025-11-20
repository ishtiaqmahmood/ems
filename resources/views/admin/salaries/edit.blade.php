<x-admin-layout>
    <div class="max-w-3xl mx-auto p-6">

        <!-- Header -->
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-pencil-square text-sky-600 text-2xl"></i>
            Edit Salary for {{ $employer->name }}
        </h1>

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-2xl p-6">
            <form action="{{ route('admin.salaries.update', [$employer->id, $salary->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Salary Grade -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Salary Grade</label>
                        <select name="salary_grade_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            <option value="">Select Grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}"
                                    {{ $salary->salary_grade_id == $grade->id ? 'selected' : '' }}>
                                    {{ $grade->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Basic Salary -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Basic Salary</label>
                        <input type="number" name="basic_salary" value="{{ $salary->basic_salary }}" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                            required>
                    </div>

                    <!-- House Rent -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">House Rent</label>
                        <input type="number" name="house_rent" value="{{ $salary->house_rent }}" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <!-- Transport Allowance -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Transport Allowance</label>
                        <input type="number" name="transport_allowance" value="{{ $salary->transport_allowance }}"
                            step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <!-- Medical Allowance -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Medical Allowance</label>
                        <input type="number" name="medical_allowance" value="{{ $salary->medical_allowance }}"
                            step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <!-- Other Allowances -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Other Allowances</label>
                        <input type="number" name="other_allowances" value="{{ $salary->other_allowances }}"
                            step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <!-- Effective From -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Effective From</label>
                        <input type="date" name="effective_from"
                            value="{{ $salary->effective_from->format('Y-m-d') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                            required>
                    </div>

                    <!-- Change Reason -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-1">Change Reason</label>
                        <textarea name="change_reason" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                            required>{{ old('change_reason') }}</textarea>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md transition">
                        Update Salary
                    </button>
                    <a href="{{ route('admin.salaries.all') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
