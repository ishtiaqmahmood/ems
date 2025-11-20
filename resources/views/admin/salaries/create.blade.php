<x-admin-layout>
    <div class="max-w-3xl mx-auto p-6">
        <!-- Header -->
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-plus-circle text-sky-600 text-2xl"></i>
            Add Salary for {{ $employer->name }}
        </h1>

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-2xl p-6">
            <form method="POST" action="{{ route('admin.salaries.store', $employer) }}" class="space-y-6">
                @csrf

                <!-- Salary Grade -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Salary Grade</label>
                    <select id="salary_grade" name="salary_grade_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">-- Select Grade --</option>
                        @foreach ($grades as $g)
                            <option value="{{ $g->id }}">{{ $g->name }} (Level {{ $g->level }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Basic Salary -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Basic Salary</label>
                    <input type="number" step="0.01" name="basic_salary"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Allowances Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">House Rent</label>
                        <input type="number" name="house_rent"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Transport Allowance</label>
                        <input type="number" name="transport_allowance"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Medical Allowance</label>
                        <input type="number" name="medical_allowance"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Other Allowances</label>
                        <input type="number" name="other_allowances"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div>

                <!-- Effective From -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Effective From</label>
                    <input type="date" name="effective_from"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Change Reason -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Change Reason</label>
                    <input type="text" name="change_reason"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="px-6 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 shadow-md transition">
                        Save Salary
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

<script>
    document.getElementById('salary_grade').addEventListener('change', function() {
        let gradeId = this.value;
        if (!gradeId) return;

        fetch(`/admin/salary/grade/${gradeId}/json`)
            .then(res => res.json())
            .then(data => {
                document.querySelector('[name=basic_salary]').value = data.basic_salary || 0;
                document.querySelector('[name=house_rent]').value = data.house_rent || 0;
                document.querySelector('[name=transport_allowance]').value = data.transport_allowance || 0;
                document.querySelector('[name=medical_allowance]').value = data.medical_allowance || 0;
                document.querySelector('[name=other_allowances]').value = data.other_allowances || 0;
            });
    });
</script>
