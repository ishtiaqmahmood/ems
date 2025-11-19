<x-admin-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">Edit Document</h1>

        <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow p-6 rounded-xl space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="font-medium">Document Title</label>
                <input type="text" name="title" value="{{ $document->title }}" class="w-full border p-2 rounded"
                    required>
            </div>

            <div>
                <label class="font-medium">Document Type</label>
                <input type="text" name="type" value="{{ $document->type }}" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded">{{ $document->description }}</textarea>
            </div>

            <div>
                <label class="font-medium">Replace File (Optional)</label>
                <input type="file" name="file" class="w-full border p-2 rounded">

                <p class="text-sm text-gray-500 mt-1">
                    Current File:
                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 underline">
                        View current file
                    </a>
                </p>
            </div>

            <button class="px-4 py-2 rounded bg-yellow-600 text-white hover:bg-yellow-700">
                Update Document
            </button>
        </form>

    </div>
</x-admin-layout>
