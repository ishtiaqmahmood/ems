<x-admin-layout>
    <div class="p-6">

        <!-- Back Button -->
        <a href="{{ route('admin.photos.index') }}"
            class="flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-6 inline-block">
            <i class="bi bi-arrow-left"></i> Back to Photos
        </a>

        <!-- Photo Card -->
        <div class="bg-white p-10 shadow-2xl rounded-3xl max-w-4xl mx-auto space-y-8">

            <!-- Title -->
            <div class="flex flex-col items-center gap-4">
                <h1
                    class="text-5xl font-extrabold text-gray-800 text-center bg-sky-100 px-6 py-3 rounded-3xl shadow-inner w-full md:w-auto">
                    {{ $photo->title ?? 'Untitled Photo' }}
                </h1>
            </div>

            <!-- Image Preview -->
            <div class="w-full flex justify-center">
                <img src="{{ Storage::url($photo->file_path) }}"
                    class="w-full md:w-4/5 lg:w-2/3 h-auto rounded-2xl border border-gray-200 shadow-xl">
            </div>

            <!-- Photo Info -->
            <div class="grid md:grid-cols-2 gap-8 text-gray-700">
                <div class="space-y-3">
                    <p class="flex items-center gap-3">
                        <i class="bi bi-file-earmark text-sky-600 text-lg"></i>
                        <strong>Extension:</strong> {{ $photo->extension ?? '-' }}
                    </p>

                    <p class="flex items-center gap-3">
                        <i class="bi bi-code-slash text-sky-600 text-lg"></i>
                        <strong>MIME Type:</strong> {{ $photo->mime_type ?? '-' }}
                    </p>

                    <p class="flex items-center gap-3">
                        <i class="bi bi-person text-sky-600 text-lg"></i>
                        <strong>Uploaded by:</strong> {{ $photo->uploader->name ?? 'Admin' }}
                    </p>
                </div>

                <!-- Description -->
                <div>
                    <h2 class="font-semibold text-gray-800 text-xl mb-3 border-b pb-1">Description</h2>
                    <p class="text-gray-700 leading-relaxed text-base text-justify">
                        {{ $photo->description ?? 'No description available for this photo.' }}
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-wrap justify-center gap-5">
                <a href="{{ Storage::url($photo->file_path) }}" target="_blank"
                    class="px-7 py-3 bg-sky-600 text-white rounded-2xl hover:bg-sky-700 flex items-center gap-3 shadow-lg transition">
                    <i class="bi bi-eye-fill"></i> View Full
                </a>

                <a href="{{ route('admin.photos.edit', $photo->id) }}"
                    class="px-7 py-3 bg-yellow-500 text-white rounded-2xl hover:bg-yellow-600 flex items-center gap-3 shadow-lg transition">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST"
                    onsubmit="return confirm('Delete this photo?');">
                    @csrf
                    @method('DELETE')
                    <button
                        class="px-7 py-3 bg-red-600 text-white rounded-2xl hover:bg-red-700 flex items-center gap-3 shadow-lg transition">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </form>
            </div>

        </div>

    </div>
</x-admin-layout>
