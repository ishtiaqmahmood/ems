<x-admin-layout>
    <div class="p-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-archive"></i>
                Documents
            </h1>

            <a href="{{ route('admin.documents.create') }}"
                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition flex items-center gap-2">
                <i class="bi bi-plus-lg text-lg"></i> Add Document
            </a>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-700 border border-green-300 rounded-lg flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-green-600"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Document</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Type</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Uploaded By</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($documents as $doc)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- Title (Clickable) -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.documents.show', $doc->id) }}"
                                    class="text-blue-700 font-semibold hover:underline hover:text-blue-900 flex items-center gap-3">
                                    <i class="bi bi-file-earmark text-2xl text-blue-500"></i>
                                    <span>{{ $doc->title }}</span>
                                </a>
                            </td>

                            <!-- Type Badge -->
                            <td class="px-6 py-4">
                                @if ($doc->type)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        {{ $doc->type }}
                                    </span>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>

                            <!-- Uploader -->
                            <td class="px-6 py-4">
                                <span class="text-gray-700">{{ $doc->uploader->name ?? 'Admin' }}</span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">

                                    <!-- View -->
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800" title="View File">
                                        <i class="bi bi-eye-fill text-lg"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.documents.edit', $doc->id) }}"
                                        class="text-yellow-600 hover:text-yellow-800" title="Edit Document">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this document permanently?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600 hover:text-red-800" title="Delete Document">
                                            <i class="bi bi-trash-fill text-lg"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $documents->links() }}
        </div>

    </div>
</x-admin-layout>
