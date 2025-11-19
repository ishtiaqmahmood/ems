<x-admin-layout>
    <div class="p-6">

        <!-- Back Button -->
        <a href="{{ route('admin.documents.index') }}"
            class="flex items-center gap-1 text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="bi bi-arrow-left"></i> Back to Documents
        </a>

        <!-- Details Card -->
        <div class="bg-white p-8 shadow-2xl rounded-2xl border border-gray-100">

            <!-- Title -->
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-sky-100 text-sky-700 rounded-xl text-xl">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">
                    {{ $document->title }}
                </h1>
            </div>

            <!-- Info Grid -->
            <div class="grid md:grid-cols-2 gap-6">

                <div class="space-y-2">
                    <p class="flex items-center gap-2 text-gray-700">
                        <i class="bi bi-tag text-sky-600"></i>
                        <strong>Type:</strong> {{ $document->type ?? 'N/A' }}
                    </p>

                    <p class="flex items-center gap-2 text-gray-700">
                        <i class="bi bi-person text-sky-600"></i>
                        <strong>Uploaded By:</strong> {{ $document->uploader->name ?? 'Admin' }}
                    </p>

                    <p class="flex items-center gap-2 text-gray-700">
                        <i class="bi bi-clock text-sky-600"></i>
                        <strong>Uploaded:</strong> {{ $document->created_at->format('d M, Y') }}
                    </p>

                    @if ($document->updated_by)
                        <p class="flex items-center gap-2 text-gray-700">
                            <i class="bi bi-pencil text-sky-600"></i>
                            <strong>Last Updated:</strong> {{ $document->updated_at->format('d M, Y') }}
                        </p>
                    @endif
                </div>

                <!-- File Preview Icon Box -->
                <div class="flex items-center justify-center">
                    <div
                        class="w-40 h-40 rounded-xl border border-gray-200 bg-gray-50 flex flex-col items-center justify-center shadow-md">
                        <i class="bi bi-file-earmark-text text-6xl text-gray-500"></i>
                        <p class="mt-2 text-gray-600 text-sm">
                            .{{ $document->extension }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Description -->
            <div class="mt-6">
                <h3 class="font-semibold text-gray-800 mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $document->description ?? 'No description available for this document.' }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-wrap gap-4">

                <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                    class="px-6 py-3 bg-sky-600 text-white rounded-lg hover:bg-sky-700 flex items-center gap-2 shadow-md">
                    <i class="bi bi-eye"></i> View File
                </a>

                <a href="{{ route('admin.documents.edit', $document->id) }}"
                    class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 flex items-center gap-2 shadow-md">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this document?');">
                    @csrf
                    @method('DELETE')

                    <button
                        class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2 shadow-md">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>

        </div>

    </div>
</x-admin-layout>
