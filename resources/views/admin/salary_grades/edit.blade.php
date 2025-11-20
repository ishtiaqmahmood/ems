{{-- resources/views/admin/salary_grades/edit.blade.php --}}
{{-- resources/views/admin/salary_grades/edit.blade.php --}}
<x-admin-layout>

    <div class="max-w-4xl mx-auto p-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-pencil-square text-sky-600"></i> Edit Salary Grade
            </h1>
            <a href="{{ route('admin.salary-grades.index') }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow flex items-center gap-2">
                <i class="bi bi-arrow-left"></i> Back to Grades
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.salary-grades.update', $salaryGrade) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                @include('admin.salary_grades._form')
            </form>
        </div>

    </div>

</x-admin-layout>
