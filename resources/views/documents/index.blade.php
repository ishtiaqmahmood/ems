<x-viewer-layout>
    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div
            class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button class="text-green-800" onclick="this.parentElement.remove()">✖</button>
        </div>
    @endif

    {{-- ❌ Error Messages --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 📤 Upload Section --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
            <i class="bi bi-cloud-arrow-up text-sky-600"></i> Upload New Document
        </h2>
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Title</label>
                <input type="text" name="title"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"
                    required>
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium">File</label>
                <input type="file" name="file"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"
                    required>
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Visibility</label>
                <select name="visibility"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"
                    required>
                    <option value="">-- Select Visibility --</option>
                    <option value="private">Private (Only Me)</option>
                    <option value="public">Public (Everyone)</option>
                </select>
            </div>
            <div class="pt-3">
                <button type="submit" class="px-5 py-2.5 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                    <i class="bi bi-upload"></i> Upload
                </button>
            </div>
        </form>
    </div>

    {{-- 📄 Document List --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 flex justify-between items-center border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-folder2"></i> My Documents
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Visibility</th>
                        <th class="px-6 py-3">Uploaded On</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $doc->title }}</td>
                            <td class="px-6 py-3">{{ Str::limit($doc->description, 40) }}</td>
                            <td class="px-6 py-3">
                                @if ($doc->visibility === 'private')
                                    <span class="px-2 py-1 text-xs bg-gray-200 rounded-full">Private</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">Public</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">{{ $doc->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-center space-x-2">
                                {{-- 👁️ View --}}
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                    class="inline-block px-3 py-1.5 text-white bg-green-600 hover:bg-green-700 rounded-md transition">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- ✏️ Edit --}}
                                <button type="button"
                                    class="inline-block px-3 py-1.5 text-white bg-yellow-500 hover:bg-yellow-600 rounded-md transition"
                                    onclick="openEditModal({{ $doc->id }}, @js($doc->title), @js($doc->description), '{{ $doc->visibility }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                {{-- 🗑️ Delete --}}
                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this document?')"
                                        class="px-3 py-1.5 text-white bg-red-600 hover:bg-red-700 rounded-md transition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-5 text-center text-gray-500">
                                No documents uploaded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $documents->links() }}
        </div>
    </div>

    {{-- ✏️ Edit Modal --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Edit Document</h3>
                <button onclick="closeEditModal()" class="text-gray-600 hover:text-gray-800">✖</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Title</label>
                    <input type="text" name="title" id="editTitle"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Description</label>
                    <textarea name="description" id="editDescription" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Replace File (optional)</label>
                    <input type="file" name="file"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Visibility</label>
                    <select name="visibility" id="editVisibility"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"
                        required>
                        <option value="private">Private</option>
                        <option value="public">Public</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ✨ Modal Script --}}
    <script>
        const editModal = document.getElementById('editModal');
        const editForm = document.getElementById('editForm');
        const editTitle = document.getElementById('editTitle');
        const editDescription = document.getElementById('editDescription');
        const editVisibility = document.getElementById('editVisibility');

        function openEditModal(id, title, description, visibility) {
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
            editForm.action = `/documents/${id}`;
            editTitle.value = title;
            editDescription.value = description;
            editVisibility.value = visibility;
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        }
    </script>
</x-viewer-layout>
