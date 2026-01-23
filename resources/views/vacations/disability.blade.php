<x-viewer-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">Disability Leave Request</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vacations.disability.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow-md">
            @csrf

            {{-- Leave Type --}}
            <div class="mb-4">
                <label for="leave_type_id" class="block font-medium mb-1">Leave Type <span
                        class="text-red-500">*</span></label>
                <select name="leave_type_id" id="leave_type_id" class="w-full border rounded p-2">
                    <option value="">Select Leave Type</option>
                    @foreach ($leaveTypes as $type)
                        <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                            {{ app()->getLocale() === 'bn' ? $type->name_bn : $type->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dates --}}
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block font-medium mb-1">Start Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="w-full border rounded p-2">
                </div>
                <div>
                    <label for="end_date" class="block font-medium mb-1">End Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="w-full border rounded p-2">
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="mb-4">
                <label for="mobile" class="block font-medium mb-1">Mobile</label>
                <input type="text" name="mobile" id="mobile" value="{{ old('mobile', auth()->user()->mobile) }}"
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="address" class="block font-medium mb-1">Address</label>
                <textarea name="address" id="address" rows="2" class="w-full border rounded p-2">{{ old('address', auth()->user()->address) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="salary" class="block font-medium mb-1">Salary</label>
                <input type="number" name="salary" id="salary" value="{{ old('salary', auth()->user()->salary) }}"
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="designation" class="block font-medium mb-1">Designation</label>
                <input type="text" name="designation" id="designation"
                    value="{{ old('designation', auth()->user()->designation) }}" class="w-full border rounded p-2">
            </div>

            {{-- Leave Balance --}}
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="due_leave" class="block font-medium mb-1">Due Leave</label>
                    <input type="number" name="due_leave" id="due_leave" value="{{ old('due_leave') }}"
                        class="w-full border rounded p-2">
                </div>
                <div>
                    <label for="earned_leaves" class="block font-medium mb-1">Earned Leaves</label>
                    <input type="number" name="earned_leaves" id="earned_leaves" value="{{ old('earned_leaves') }}"
                        class="w-full border rounded p-2">
                </div>
                <div>
                    <label for="leaves_taken" class="block font-medium mb-1">Leaves Taken</label>
                    <input type="number" name="leaves_taken" id="leaves_taken" value="{{ old('leaves_taken') }}"
                        class="w-full border rounded p-2">
                </div>
            </div>

            {{-- Reason & Description --}}
            <div class="mb-4">
                <label for="reason" class="block font-medium mb-1">Reason</label>
                <textarea name="reason" id="reason" rows="2" class="w-full border rounded p-2">{{ old('reason') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium mb-1">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full border rounded p-2">{{ old('description') }}</textarea>
            </div>

            {{-- Letter Upload --}}
            <div class="mb-4">
                <label for="letter_pdf" class="block font-medium mb-1">Letter (PDF/DOC/JPG/PNG)</label>
                <input type="file" name="letter_pdf" id="letter_pdf" class="w-full">
            </div>

            {{-- Submit --}}
            <div class="mt-6">
                <button type="submit"
                    class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700 transition">
                    Submit Disability Leave
                </button>
            </div>
        </form>
    </div>
</x-viewer-layout>
