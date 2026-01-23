<x-viewer-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6">

        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 px-8 py-6 text-white">
                <h2 class="text-2xl sm:text-3xl font-bold flex items-center gap-3">
                    <i class="bi bi-calendar-plus-fill"></i>
                    Apply for Leave
                </h2>
                <p class="text-sky-100 mt-1 text-sm">
                    Submit your leave request for approval
                </p>
            </div>

            <!-- Form -->
            <div class="p-8 sm:p-10">
                <form action="{{ route('vacations.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-sm">Start Date</label>
                            <input type="text" name="start_date" required
                                class="flatpickr w-full rounded-xl border px-4 py-3" value="{{ old('start_date') }}">
                        </div>

                        <div>
                            <label class="font-semibold text-sm">End Date</label>
                            <input type="text" name="end_date" required
                                class="flatpickr w-full rounded-xl border px-4 py-3" value="{{ old('end_date') }}">
                        </div>
                    </div>

                    <!-- Leave Type -->
                    <div>
                        <label class="font-semibold text-sm">Leave Type</label>
                        <select name="leave_type_id" required class="w-full rounded-xl border px-4 py-3">
                            <option value="">-- Select Leave Type --</option>
                            @foreach ($leaveTypes as $type)
                                <option value="{{ $type->id }}" @selected(old('leave_type_id') == $type->id)>
                                    {{ $type->name_bn }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Employee Snapshot -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-sm">Mobile Number</label>
                            <input type="text" name="mobile" value="{{ old('mobile', auth()->user()->mobile) }}"
                                class="w-full rounded-xl border px-4 py-3">
                        </div>

                        <div>
                            <label class="font-semibold text-sm">NID Number</label>
                            <input type="text" name="nid_number"
                                value="{{ old('nid_number', auth()->user()->nid_number) }}"
                                class="w-full rounded-xl border px-4 py-3">
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Designation</label>
                            <input type="text" name="designation"
                                value="{{ old('designation', auth()->user()->designation) }}"
                                class="w-full rounded-xl border px-4 py-3">
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Address</label>
                            <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}"
                                class="w-full rounded-xl border px-4 py-3">
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Salary</label>
                        <input type="number" step="0.01" name="salary"
                            value="{{ old('salary', auth()->user()->salary) }}"
                            class="w-full rounded-xl border px-4 py-3">
                    </div>
                    <!-- Leave Balances -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
                        <div>
                            <label class="font-semibold text-sm">Due Leave</label>
                            <input type="number" name="due_leave" value="{{ old('due_leave', 0) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('due_leave')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Earned Leaves</label>
                            <input type="number" name="earned_leaves" value="{{ old('earned_leaves', 0) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('earned_leaves')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Leaves Taken</label>
                            <input type="number" name="leaves_taken" value="{{ old('leaves_taken', 0) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('leaves_taken')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <!-- Replacement -->
                    <div>
                        <label class="font-semibold text-sm">Replacement Employee</label>
                        <select name="replacement_user_id" class="w-full rounded-xl border px-4 py-3">
                            <option value="">-- None --</option>
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}" @selected(old('replacement_user_id') == $emp->id)>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="font-semibold text-sm">Short Description</label>
                        <input type="text" name="description" class="w-full rounded-xl border px-4 py-3"
                            value="{{ old('description') }}">
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="font-semibold text-sm">Reason</label>
                        <textarea name="reason" rows="4" class="w-full rounded-xl border px-4 py-3">{{ old('reason') }}</textarea>
                    </div>

                    <!-- Documents -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-sm">Application Letter</label>
                            <input type="file" name="letter_pdf" class="w-full rounded-xl border px-3 py-2">
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Medical Certificate</label>
                            <input type="file" name="medical_certificate" class="w-full rounded-xl border px-3 py-2">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 flex justify-end">
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white
                                       font-semibold px-8 py-3 rounded-2xl shadow-lg">
                            Submit Request
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Flatpickr -->
    <script>
        flatpickr("input[name='start_date']", {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange(_, dateStr) {
                document.querySelector("input[name='end_date']")
                    ?._flatpickr?.set("minDate", dateStr);
            }
        });

        flatpickr("input[name='end_date']", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    </script>
</x-viewer-layout>
