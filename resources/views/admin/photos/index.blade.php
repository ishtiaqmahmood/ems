<x-admin-layout>
    <div class="p-6" x-data="{ openFilter: false }">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <h1 class="text-4xl font-extrabold text-gray-800 flex items-center gap-3">
                <i class="bi bi-images text-sky-600"></i>
                Photo Gallery
            </h1>

            <a href="{{ route('admin.photos.create') }}"
                class="px-6 py-2.5 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition flex items-center gap-2">
                <i class="bi bi-cloud-upload-fill"></i> Upload Photos
            </a>
        </div>

        <!-- Filters + Search -->
        <form method="GET" class="bg-white rounded-2xl shadow p-5 mb-8 border">

            <div class="grid md:grid-cols-4 gap-5">

                <!-- Search -->
                <div>
                    <label class="text-gray-600 font-semibold">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="mt-1 w-full rounded-xl border-gray-300 shadow-sm" placeholder="Search photos...">
                </div>

                <!-- Filter By Type -->
                <div>
                    <label class="text-gray-600 font-semibold">Filter by File Type</label>
                    <select name="type" class="mt-1 w-full rounded-xl border-gray-300 shadow-sm">
                        <option value="">All Types</option>
                        @foreach ($types as $t)
                            <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>
                                {{ strtoupper($t) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sorting -->
                <div>
                    <label class="text-gray-600 font-semibold">Sort By</label>
                    <select name="sort" class="mt-1 w-full rounded-xl border-gray-300 shadow-sm">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="type" {{ request('sort') == 'type' ? 'selected' : '' }}>File Type</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button
                        class="w-full px-4 py-2 bg-sky-600 text-white rounded-xl shadow hover:bg-sky-700 transition">
                        Apply
                    </button>
                </div>
            </div>
        </form>

        <!-- Masonry Grid -->
        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">

            @forelse($photos as $photo)
                <div class="break-inside-avoid">

                    <div
                        class="bg-white border border-gray-100 rounded-3xl shadow-lg overflow-hidden
                            hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                        <!-- Image -->
                        <a href="{{ route('admin.photos.show', $photo->id) }}" class="block relative group">
                            <img src="{{ Storage::url($photo->file_path) }}"
                                class="w-full object-cover group-hover:opacity-90 transition duration-300">

                            <!-- Hover Overlay -->
                            <div
                                class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <i class="bi bi-eye-fill text-white text-3xl"></i>
                            </div>
                        </a>

                        <!-- Info -->
                        <div class="p-4 flex flex-col gap-2">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $photo->title ?? 'Untitled' }}</h3>

                            <div class="flex justify-between items-center text-gray-500 text-sm">
                                <span class="uppercase flex items-center gap-1">
                                    <i class="bi bi-file-earmark-image"></i> {{ $photo->extension }}
                                </span>

                                <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this photo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 transition">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>

            @empty
                <div class="col-span-full text-center py-20">
                    <i class="bi bi-images text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">No photos found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            <div class="bg-white px-6 py-3 rounded-xl shadow border">
                {{ $photos->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
