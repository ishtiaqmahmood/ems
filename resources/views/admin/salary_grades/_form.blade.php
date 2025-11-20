{{-- resources/views/admin/salary_grades/_form.blade.php --}}

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Grade Name --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Grade Name *</label>
        <input type="text" name="name" value="{{ old('name', $salaryGrade->name ?? '') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
            required>
    </div>

    {{-- Level --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Level *</label>
        <input type="number" name="level" value="{{ old('level', $salaryGrade->level ?? '') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
            required>
    </div>

    {{-- Basic Salary --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Basic Salary *</label>
        <input type="number" name="basic_salary" step="0.01"
            value="{{ old('basic_salary', $salaryGrade->basic_salary ?? '') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
            required>
    </div>

    {{-- House Rent --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">House Rent</label>
        <input type="number" name="house_rent" step="0.01"
            value="{{ old('house_rent', $salaryGrade->house_rent ?? 0) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
    </div>

    {{-- Transport Allowance --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Transport Allowance</label>
        <input type="number" name="transport_allowance" step="0.01"
            value="{{ old('transport_allowance', $salaryGrade->transport_allowance ?? 0) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
    </div>

    {{-- Medical Allowance --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Medical Allowance</label>
        <input type="number" name="medical_allowance" step="0.01"
            value="{{ old('medical_allowance', $salaryGrade->medical_allowance ?? 0) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
    </div>

    {{-- Other Allowances --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Other Allowances</label>
        <input type="number" name="other_allowances" step="0.01"
            value="{{ old('other_allowances', $salaryGrade->other_allowances ?? 0) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
    </div>

</div>

{{-- Buttons --}}
<div class="mt-6 flex gap-3">
    <button type="submit"
        class="px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow flex items-center gap-2">
        <i class="bi bi-save"></i> Save
    </button>

    <a href="{{ route('admin.salary-grades.index') }}"
        class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg shadow flex items-center gap-2">
        Cancel
    </a>
</div>
