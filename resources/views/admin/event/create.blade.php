<x-admin-layout>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-xl">

        <!-- Header -->
        <h1 class="text-3xl font-bold mb-6 flex items-center gap-2 text-gray-800">
            <i class="bi bi-plus-circle text-sky-600"></i>
            Create Event
        </h1>

        <!-- Form -->
        <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-400 focus:outline-none"
                    placeholder="Event title" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Description</label>
                <textarea name="description"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-400 focus:outline-none"
                    rows="4" placeholder="Event description"></textarea>
            </div>

            <!-- Start Date & Time -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Start Date & Time <span
                        class="text-red-500">*</span></label>
                <input type="datetime-local" name="start_datetime"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-400 focus:outline-none"
                    required>
            </div>

            <!-- End Date & Time -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">End Date & Time <span
                        class="text-red-500">*</span></label>
                <input type="datetime-local" name="end_datetime"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-400 focus:outline-none"
                    required>
            </div>

            <!-- Location -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Location</label>
                <input type="text" name="location"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-400 focus:outline-none"
                    placeholder="Event location">
            </div>

            <!-- Color -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Color (optional)</label>
                <input type="color" name="color" class="w-16 h-10 p-1 border rounded-lg shadow-sm cursor-pointer">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-sky-500 to-indigo-500 text-white font-semibold rounded-lg shadow hover:from-sky-600 hover:to-indigo-600 transition">
                    Save Event
                </button>
            </div>
        </form>

    </div>

</x-admin-layout>
