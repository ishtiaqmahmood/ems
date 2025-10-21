<x-viewer-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Your Photo Gallery</h1>
            <a href="{{ route('photos.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">+ Upload Photo</a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($photos->count())
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                @foreach ($photos as $photo)
                    <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-lg transition">
                        <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}"
                            class="w-full h-56 object-cover">
                        <div class="p-4">
                            <h2 class="font-semibold text-lg truncate">{{ $photo->title }}</h2>
                            <p class="text-gray-500 text-sm mt-1">{{ $photo->formattedDate() }}</p>
                            <span
                                class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $photo->visibility === 'public' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                {{ ucfirst($photo->visibility) }}
                            </span>

                            <div class="flex justify-between items-center mt-4">
                                <a href="{{ route('photos.show', $photo) }}"
                                    class="text-indigo-600 text-sm font-medium hover:underline">View</a>

                                @if ($photo->user_id == auth()->id())
                                    <form action="{{ route('photos.destroy', $photo) }}" method="POST"
                                        onsubmit="return confirm('Delete this photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 text-sm font-medium hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $photos->links() }}
            </div>
        @else
            <p class="text-center text-gray-500">No photos found. <a href="{{ route('photos.create') }}"
                    class="text-indigo-600 hover:underline">Upload one now</a>.</p>
        @endif
    </div>
</x-viewer-layout>
