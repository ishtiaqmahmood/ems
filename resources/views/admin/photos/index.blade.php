<x-admin-layout>
    <div class="p-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                <i class="bi bi-image text-sky-600"></i> Photos
            </h1>

            <a href="{{ route('admin.photos.create') }}"
                class="px-5 py-2 bg-blue-600 text-white rounded-2xl shadow hover:bg-blue-700 flex items-center gap-2 transition">
                <i class="bi bi-plus-lg"></i> Upload Photos
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl flex items-center gap-3 shadow">
                <i class="bi bi-check-circle-fill text-green-600 text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Photos Grid -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($photos as $photo)
                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition duration-300">

                    <!-- Photo Preview -->
                    <a href="{{ route('admin.photos.show', $photo->id) }}">
                        <img src="{{ Storage::url($photo->file_path) }}" class="w-full h-52 object-cover">
                    </a>

                    <!-- Info & Actions -->
                    <div class="p-4 flex flex-col gap-2">
                        <!-- Title -->
                        <h2 class="text-gray-800 font-semibold truncate" title="{{ $photo->title }}">
                            {{ $photo->title ?? 'Untitled' }}
                        </h2>

                        <!-- Details -->
                        <div class="flex justify-between items-center text-gray-500 text-sm">
                            <span>{{ strtoupper($photo->extension) }}</span>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this photo?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 transition">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-10">
                    No photos uploaded yet.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $photos->links() }}
        </div>

    </div>
</x-admin-layout>
