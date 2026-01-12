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

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Start Date
                            </label>
                            <input type="text" id="start_date" name="start_date"
                                value="{{ old('start_date', $vacation->start_date) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3
                                   focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                                required>
                            @error('start_date')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                End Date
                            </label>
                            <input type="text" id="end_date" name="end_date"
                                value="{{ old('end_date', $vacation->end_date) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3
                                   focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                                required>
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
                        <select name="leave_type_id"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                            required>
                            <option value="">-- Select Leave Type --</option>
                            @foreach ($leaveTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ $vacation->leave_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
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
                            value="{{ old('description', $vacation->description) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                            placeholder="Brief summary of your leave">
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
                            placeholder="Additional explanation if required">{{ old('reason', $vacation->reason) }}</textarea>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Supporting Document
                        </label>

                        @if ($vacation->letter_pdf)
                            <p class="text-sm text-gray-600 mb-2">
                                Current file:
                                <a href="{{ asset('storage/' . $vacation->letter_pdf) }}" target="_blank"
                                    class="text-sky-600 underline font-medium">
                                    View document
                                </a>
                            </p>
                        @endif

                        <input type="file" name="letter_pdf"
                            class="block w-full text-sm text-gray-700
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-xl file:border-0
                               file:bg-sky-50 file:text-sky-700
                               hover:file:bg-sky-100
                               border border-gray-300 rounded-xl px-3 py-2">
                        @error('letter_pdf')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 flex flex-col sm:flex-row sm:justify-between gap-4">

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2
                                bg-gradient-to-r from-sky-600 to-sky-700
                                hover:from-sky-700 hover:to-sky-800
                                text-white font-semibold px-8 py-3
                                rounded-2xl shadow-lg
                                transform hover:scale-105 transition-all">
                            <i class="bi bi-save-fill"></i>
                            Update Request
                        </button>

                        <form action="{{ route('vacations.destroy', $vacation) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this leave request?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2
                                    bg-red-500 hover:bg-red-600
                                    text-white font-semibold px-8 py-3
                                    rounded-2xl shadow-lg
                                    transform hover:scale-105 transition-all">
                                <i class="bi bi-trash-fill"></i>
                                Delete
                            </button>
                        </form>

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
