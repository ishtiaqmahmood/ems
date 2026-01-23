<x-viewer-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6">
        <div class="bg-white shadow-2xl rounded-3xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-8 py-6">
                <h2 class="text-2xl sm:text-3xl font-bold flex items-center gap-3">
                    <i class="bi bi-pencil-square text-2xl"></i>
                    Edit Leave Request
                </h2>
                <p class="text-sky-100 mt-1 text-sm">
                    You may update this request while it is still pending.
                </p>
            </div>

            <!-- Form -->
            <div class="p-8 sm:p-10">
                <form action="{{ route('vacations.update', $vacation) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Employee Info -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-sm">Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $vacation->mobile) }}"
                                class="w-full rounded-xl border px-4 py-3">
                            @error('mobile')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">NID Number</label>
                            <input type="text" name="nid_number"
                                value="{{ old('nid_number', $vacation->nid_number) }}"
                                class="w-full rounded-xl border px-4 py-3">
                            @error('nid_number')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Address</label>
                            <input type="text" name="address" value="{{ old('address', $vacation->address) }}"
                                class="w-full rounded-xl border px-4 py-3">
                            @error('address')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Designation</label>
                            <input type="text" name="designation"
                                value="{{ old('designation', $vacation->designation) }}"
                                class="w-full rounded-xl border px-4 py-3">
                            @error('designation')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Salary</label>
                            <input type="number" name="salary" value="{{ old('salary', $vacation->salary) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('salary')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Leave Balances -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
                        <div>
                            <label class="font-semibold text-sm">Due Leave</label>
                            <input type="number" name="due_leave" value="{{ old('due_leave', $vacation->due_leave) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('due_leave')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Earned Leaves</label>
                            <input type="number" name="earned_leaves"
                                value="{{ old('earned_leaves', $vacation->earned_leaves) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('earned_leaves')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Leaves Taken</label>
                            <input type="number" name="leaves_taken"
                                value="{{ old('leaves_taken', $vacation->leaves_taken) }}"
                                class="w-full rounded-xl border px-4 py-3" min="0">
                            @error('leaves_taken')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Replacement Employee -->
                    <div class="mt-4">
                        <label class="font-semibold text-sm">Replacement Employee</label>
                        <select name="replacement_user_id" class="w-full rounded-xl border px-4 py-3">
                            <option value="">-- None --</option>
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}" @selected(old('replacement_user_id', $vacation->replacement_user_id) == $emp->id)>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('replacement_user_id')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                            <input type="text" id="start_date" name="start_date"
                                value="{{ old('start_date', $vacation->start_date) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm" required>
                            @error('start_date')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
                            <input type="text" id="end_date" name="end_date"
                                value="{{ old('end_date', $vacation->end_date) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm" required>
                            @error('end_date')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Leave Type -->
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Leave Type</label>
                        <select name="leave_type_id" class="w-full rounded-xl border px-4 py-3" required>
                            <option value="">-- Select Leave Type --</option>
                            @foreach ($leaveTypes as $type)
                                <option value="{{ $type->id }}" @selected($vacation->leave_type_id == $type->id)>{{ $type->name_bn }}
                                </option>
                            @endforeach
                        </select>
                        @error('leave_type_id')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description & Reason -->
                    <div class="mt-4">
                        <label class="font-semibold text-sm">Short Description</label>
                        <input type="text" name="description"
                            value="{{ old('description', $vacation->description) }}"
                            class="w-full rounded-xl border px-4 py-3">
                        @error('description')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Detailed Reason (Optional)</label>
                        <textarea name="reason" rows="4" class="w-full rounded-xl border px-4 py-3">{{ old('reason', $vacation->reason) }}</textarea>
                        @error('reason')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Uploads -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Supporting Document
                            (Letter)</label>
                        @if ($vacation->letter_pdf)
                            <p class="text-sm text-gray-600 mb-2">
                                Current file:
                                <a href="{{ asset('storage/' . $vacation->letter_pdf) }}" target="_blank"
                                    class="text-sky-600 underline font-medium">View document</a>
                            </p>
                        @endif
                        <input type="file" name="letter_pdf"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 border rounded-xl px-3 py-2">
                        @error('letter_pdf')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Medical Certificate</label>
                        @if ($vacation->medical_certificate)
                            <p class="text-sm text-gray-600 mb-2">
                                Current file:
                                <a href="{{ asset('storage/' . $vacation->medical_certificate) }}" target="_blank"
                                    class="text-sky-600 underline font-medium">View document</a>
                            </p>
                        @endif
                        <input type="file" name="medical_certificate"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 border rounded-xl px-3 py-2">
                        @error('medical_certificate')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 flex flex-col sm:flex-row sm:justify-between gap-4">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white font-semibold px-8 py-3 rounded-2xl shadow-lg transform hover:scale-105 transition-all">
                            <i class="bi bi-save-fill"></i>
                            Update Request
                        </button>


                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Flatpickr -->
    <script>
        const endPicker = flatpickr("#end_date", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            minDate: "today"
        });
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            minDate: "today",
            onChange: function(_, dateStr) {
                endPicker.set("minDate", dateStr);
            }
        });
    </script>
</x-viewer-layout>
