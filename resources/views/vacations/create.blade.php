<x-viewer-layout>
    <div class="max-w-3xl mx-auto py-12 px-6">
        <div class="bg-white shadow-2xl rounded-3xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-8 py-6">
                <h2 class="text-2xl sm:text-3xl font-bold flex items-center gap-3">
                    <i class="bi bi-calendar-plus-fill text-2xl"></i>
                    Apply for Leave
                </h2>
                <p class="text-sky-200 mt-1 text-sm sm:text-base">
                    Submit your leave request for HR approval
                </p>
            </div>

            <!-- Form -->
            <div class="p-8 sm:p-10 bg-white">
                <form action="{{ route('vacations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Start Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <div class="relative">
                            <input type="date" name="start_date"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                                required>
                            <i
                                class="bi bi-calendar-date absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('start_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <div class="relative">
                            <input type="date" name="end_date"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                                required>
                            <i
                                class="bi bi-calendar-date absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('end_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Leave Type</label>
                        <select name="type"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                            required>
                            <option value="annual">Annual</option>
                            <option value="sick">Sick</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="other">Other</option>
                        </select>
                        @error('type')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                        <textarea name="reason" rows="4"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                            placeholder="Write your reason here..."></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="bi bi-send-fill"></i> Submit Leave Request
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-viewer-layout>
