<x-admin-layout>
    <div class="p-6">

        <a href="{{ route('admin.photos.index') }}"
            class="text-blue-600 hover:underline mb-4 inline-block flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Back to Photos
        </a>

        <div class="bg-white p-8 shadow-xl rounded-xl max-w-2xl mx-auto">

            <h2 class="text-2xl font-bold mb-6">Upload Photos</h2>

            <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Multiple Photo Upload -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Select Photos</label>
                    <input type="file" name="photos[]" multiple class="w-full border rounded-lg p-2">
                    <p class="text-gray-500 text-sm mt-1">You can select multiple images.</p>

                    @error('photos.*')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Single Title for All Photos -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Title (Optional)</label>
                    <input type="text" name="title" class="w-full border rounded-lg p-2"
                        placeholder="This title will apply to all selected photos.">
                    @error('title')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Single Description for All Photos -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Description (Optional)</label>
                    <textarea name="description" rows="3" class="w-full border rounded-lg p-2"
                        placeholder="This description will apply to all selected photos."></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Upload
                </button>
            </form>

        </div>

    </div>
</x-admin-layout>
