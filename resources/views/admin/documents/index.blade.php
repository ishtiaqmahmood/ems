<x-admin-layout>
    <div class="p-6 space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 pb-4 border-b border-gray-200">
            <h1 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                <i class="bi bi-archive text-sky-600"></i>
                Documents
            </h1>

            <a href="{{ route('admin.documents.create') }}"
                class="px-5 py-2.5 bg-sky-600 text-white rounded-xl shadow-lg hover:bg-sky-700 transition flex items-center gap-2">
                <i class="bi bi-plus-lg text-lg"></i> Add Document
            </a>
        </div>

        <!-- Search + Filter + Sort -->
        <form method="GET" class="bg-white p-5 rounded-xl shadow flex flex-col md:flex-row gap-4 md:items-center">

            <!-- Search -->
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search documents..."
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-sky-500">
            </div>

            <!-- Filter Type -->
            <select name="type" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-sky-500">
                <option value="">Filter Type</option>
                @foreach ($documentTypes as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <!-- Sort -->
            <select name="sort" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-sky-500">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
            </select>

            <!-- Submit -->
            <button class="px-5 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition">
                Apply
            </button>
        </form>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="p-4 bg-green-50 text-green-700 border border-green-300 rounded-lg flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-green-600"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Documents Table -->
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

                            <!-- Document Title -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.documents.show', $doc->id) }}"
                                    class="text-sky-700 font-semibold hover:text-sky-900 flex items-center gap-3">
                                    <i class="bi bi-file-earmark-text text-2xl text-sky-500"></i>
                                    <span>{{ $doc->title }}</span>
                                </a>
                            </td>

                            <!-- Type Badge -->
                            <td class="px-6 py-4">
                                @if ($doc->type)
                                    <span class="px-3 py-1 bg-sky-100 text-sky-800 rounded-full text-xs font-medium">
                                        {{ $doc->type }}
                                    </span>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>

                            <!-- Uploader -->
                            <td class="px-6 py-4 text-gray-700">
                                {{ $doc->uploader->name ?? 'Admin' }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">

                                    <!-- View -->
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                        class="text-sky-600 hover:text-sky-800" title="View File">
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
        <div class="mt-8 flex justify-center">
            <div class="bg-white px-6 py-3 rounded-xl shadow border">
                {{ $documents->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
