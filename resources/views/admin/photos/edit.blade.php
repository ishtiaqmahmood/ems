<x-admin-layout>
    <div class="p-6">

        <a href="{{ route('admin.photos.index') }}"
            class="text-blue-600 hover:underline mb-4 inline-block flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Back to Photos
        </a>

        <div class="bg-white p-8 shadow-xl rounded-xl max-w-2xl mx-auto">

            <h2 class="text-2xl font-bold mb-6">Edit Photo</h2>

            <form action="{{ route('admin.photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Photo Preview -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Current Photo</label>
                    <img src="{{ Storage::url($photo->file_path) }}"
                        class="w-full h-64 object-cover rounded-lg border border-gray-200 mb-2">
                </div>

                <!-- Replace Photo -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Replace Photo (Optional)</label>
                    <input type="file" name="file" class="w-full border rounded-lg p-2">
                    @error('file')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo Title -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Title (Optional)</label>
                    <input type="text" name="title" value="{{ old('title', $photo->title) }}"
                        class="w-full border rounded-lg p-2">
                    @error('title')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo Description -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Description (Optional)</label>
                    <textarea name="description" rows="3" class="w-full border rounded-lg p-2">{{ old('description', $photo->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Update Photo
                </button>
            </form>

        </div>

    </div>
</x-admin-layout>
