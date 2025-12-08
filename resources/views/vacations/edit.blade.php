<x-viewer-layout>
    <div class="max-w-3xl mx-auto py-12 px-6">
        <div class="bg-white shadow-2xl rounded-3xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-8 py-6">
                <h2 class="text-2xl sm:text-3xl font-bold flex items-center gap-3">
                    <i class="bi bi-pencil-square text-2xl"></i>
                    Edit Leave Request
                </h2>
                <p class="text-sky-200 mt-1 text-sm sm:text-base">
                    Update your leave request before HR approval
                </p>
            </div>

            <!-- Form -->
            <div class="p-8 sm:p-10 bg-white">
                <form action="{{ route('vacations.update', $vacation) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Start Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="text" id="start_date" name="start_date"
                            value="{{ old('start_date', $vacation->start_date) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm transition"
                            placeholder="Select start date" required>
                        @error('start_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="text" id="end_date" name="end_date"
                            value="{{ old('end_date', $vacation->end_date) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm transition"
                            placeholder="Select end date" required>
                        @error('end_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Leave Type</label>
                        <select name="type"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                            required>
                            <option value="annual" {{ $vacation->type == 'annual' ? 'selected' : '' }}>Annual</option>
                            <option value="sick" {{ $vacation->type == 'sick' ? 'selected' : '' }}>Sick</option>
                            <option value="unpaid" {{ $vacation->type == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="other" {{ $vacation->type == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                        <input type="text" name="description"
                            value="{{ old('description', $vacation->description) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                            placeholder="Brief description about your leave...">
                        @error('description')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                        <textarea name="reason" rows="4"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                            placeholder="Write your reason here...">{{ old('reason', $vacation->reason) }}</textarea>
                    </div>

                    <!-- Letter PDF Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Letter (PDF Only)</label>
                        @if ($vacation->letter_pdf)
                            <p class="text-sm text-gray-600 mb-1">
                                Current File: <a href="{{ asset('storage/letters/' . $vacation->letter_pdf) }}"
                                    target="_blank" class="text-sky-600 underline">{{ $vacation->letter_pdf }}</a>
                            </p>
                        @endif
                        <input type="file" name="letter_pdf" accept="application/pdf"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm bg-white">
                        @error('letter_pdf')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="pt-4 flex flex-col sm:flex-row sm:items-center sm:gap-3">
                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2
                            bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-3
                            rounded-xl shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="bi bi-save-fill"></i> Update Leave Request
                        </button>


                    </div>

                </form>

                <div class="mt-5">

                    <form action="{{ route('vacations.destroy', $vacation) }}" method="POST"
                        class="w-full sm:w-auto mt-3 sm:mt-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2
                                bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3
                                rounded-xl shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="bi bi-trash-fill"></i> Delete Leave
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        flatpickr("#start_date", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                // Automatically set minDate for end date
                endPicker.set('minDate', dateStr);
            }
        });

        const endPicker = flatpickr("#end_date", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    </script>

</x-viewer-layout>
