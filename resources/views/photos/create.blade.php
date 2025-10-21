<x-viewer-layout>
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Upload New Photo</h2>

            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('title') }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Visibility</label>
                    <select name="visibility"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">Upload</button>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
