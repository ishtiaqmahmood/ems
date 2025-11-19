<x-admin-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">Add New Document</h1>

        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow p-6 rounded-xl space-y-5">
            @csrf

            <div>
                <label class="font-medium">Document Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="font-medium">Document Type</label>
                <input type="text" name="type" placeholder="CV, NID, Certificate"
                    class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded"></textarea>
            </div>

            <div>
                <label class="font-medium">Upload File</label>
                <input type="file" name="file" required class="w-full border p-2 rounded">
            </div>

            <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                Upload Document
            </button>
        </form>

    </div>
</x-admin-layout>
