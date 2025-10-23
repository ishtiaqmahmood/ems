<x-viewer-layout>
    <div class="max-w-3xl mx-auto py-12 px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-600 via-sky-500 to-cyan-400 text-white text-center py-8 px-6">
                <h2 class="text-3xl font-bold tracking-tight">Add Attendance</h2>
                <p class="text-sm text-sky-100 mt-2">Mark daily attendance record for users</p>
            </div>

            <!-- Form -->
            <form action="{{ route('attendance.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <!-- User -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">User</label>
                    <select name="user_id"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-2.5 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"
                        required>
                        <option value="">-- Select User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                {{-- <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                    <input type="date" name="date"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-2.5 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"
                        required>
                </div> --}}

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-2.5 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"
                        required readonly>
                </div>
                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-2.5 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200">
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Leave">Leave</option>
                    </select>
                </div>

                <!-- Check In / Check Out -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Check In</label>
                        <input type="time" name="check_in"
                            class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-2.5 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Check Out</label>
                        <input type="time" name="check_out"
                            class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-2.5 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('attendance.index') }}"
                        class="flex items-center gap-2 px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-2xl text-sm font-medium transition duration-200 shadow-sm">
                        <i class="bi bi-arrow-left-circle text-lg"></i>
                        <span>Cancel</span>
                    </a>

                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl text-sm font-medium shadow-md transition duration-300 transform hover:scale-[1.03] hover:shadow-lg">
                        <i class="bi bi-save2"></i>
                        <span>Save Attendance</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
