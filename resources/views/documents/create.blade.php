<x-viewer-layout>
    {{-- 📤 Upload Section --}}
    <div class="bg-white shadow-2xl rounded-3xl p-8 mb-8 border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-3">
            <i class="bi bi-cloud-arrow-up text-sky-600 text-2xl"></i> Upload New Document
        </h2>

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Title</label>
                <input type="text" name="title" placeholder="Enter document title"
                    class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"
                    required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Description</label>
                <textarea name="description" rows="4" placeholder="Optional description"
                    class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"></textarea>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">File</label>
                <input type="file" name="file"
                    class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"
                    required>
            </div>

            <!-- Visibility -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Visibility</label>
                <select name="visibility"
                    class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200"
                    required>
                    <option value="">-- Select Visibility --</option>
                    <option value="private">Private (Only Me)</option>
                    <option value="public">Public (Everyone)</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 text-right">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-2xl shadow-md hover:shadow-lg transition transform hover:scale-[1.02]">
                    <i class="bi bi-upload text-lg"></i> Upload
                </button>
            </div>
        </form>
    </div>

</x-viewer-layout>
