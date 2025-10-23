<x-viewer-layout>
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="bg-white shadow-2xl rounded-3xl p-8 border border-gray-100">

            <!-- Header -->
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Upload New Photo</h2>

            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                        placeholder="Enter photo title" required>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                        placeholder="Optional description">{{ old('description') }}</textarea>
                </div>

                <!-- Upload Image -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Upload Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                        required>
                </div>

                <!-- Visibility -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Visibility</label>
                    <select name="visibility"
                        class="w-full border border-gray-300 rounded-2xl bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-md hover:shadow-lg transition transform hover:scale-[1.02]">
                        <i class="bi bi-upload text-lg"></i>
                        <span>Upload</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
