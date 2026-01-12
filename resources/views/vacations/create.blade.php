<x-viewer-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6">

        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 px-8 py-6 text-white">
                <h2 class="text-2xl sm:text-3xl font-bold flex items-center gap-3">
                    <i class="bi bi-calendar-plus-fill text-2xl"></i>
                    Apply for Leave
                </h2>
                <p class="text-sky-100 mt-1 text-sm">
                    Fill out the form below to submit your leave request for approval.
                </p>
            </div>

            <!-- Form Body -->
            <div class="p-8 sm:p-10">
                <form action="{{ route('vacations.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Start Date
                            </label>
                            <div class="relative">
                                <input type="text" name="start_date"
                                    class="flatpickr w-full rounded-xl border border-gray-300 px-4 py-3
                                       focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                                    placeholder="YYYY-MM-DD" required>
                                <i
                                    class="bi bi-calendar-date absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('start_date')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                End Date
                            </label>
                            <div class="relative">
                                <input type="text" name="end_date"
                                    class="flatpickr w-full rounded-xl border border-gray-300 px-4 py-3
                                       focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                                    placeholder="YYYY-MM-DD" required>
                                <i
                                    class="bi bi-calendar-date absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('end_date')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Leave Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Leave Type
                        </label>
                        <select name="leave_type_id" required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
           focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm">

                            <option value="">-- Select Leave Type --</option>

                            @forelse ($leaveTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('leave_type_id', $vacation->leave_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @empty
                                <option disabled>No leave types found</option>
                            @endforelse
                        </select>

                        @error('leave_type_id')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Short Description
                        </label>
                        <input type="text" name="description"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                            placeholder="e.g. Family emergency, medical check-up">
                        @error('description')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Detailed Reason (Optional)
                        </label>
                        <textarea name="reason" rows="4"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                                  focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                            placeholder="Provide additional details if necessary..."></textarea>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Supporting Document (Optional)
                        </label>
                        <input type="file" name="letter_pdf"
                            class="block w-full text-sm text-gray-700
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-xl file:border-0
                               file:bg-sky-50 file:text-sky-700
                               hover:file:bg-sky-100
                               border border-gray-300 rounded-xl px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">
                            Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 2MB)
                        </p>
                        @error('letter_pdf')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2
                                bg-gradient-to-r from-sky-600 to-sky-700
                                hover:from-sky-700 hover:to-sky-800
                                text-white font-semibold px-8 py-3
                                rounded-2xl shadow-lg
                                transform hover:scale-105 transition-all">
                            <i class="bi bi-send-fill"></i>
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
            onChange: function(_, dateStr) {
                const end = document.querySelector("input[name='end_date']");
                if (end && end._flatpickr) {
                    end._flatpickr.set("minDate", dateStr);
                }
            }
        });

        flatpickr("input[name='end_date']", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    </script>
</x-viewer-layout>
