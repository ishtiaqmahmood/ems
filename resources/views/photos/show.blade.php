<x-viewer-layout>
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}"
                class="w-full max-h-[600px] object-cover">

            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $photo->title }}</h1>
                <p class="text-gray-500 text-sm mb-4">{{ $photo->formattedDate() }} • Views: {{ $photo->views }}</p>
                <p class="text-gray-700 leading-relaxed mb-6">{{ $photo->description ?? 'No description provided.' }}</p>

                <div class="flex justify-between items-center">
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full
                    {{ $photo->visibility === 'public' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                        {{ ucfirst($photo->visibility) }}
                    </span>

                    <a href="{{ route('photos.index') }}" class="text-indigo-600 hover:underline text-sm font-medium">←
                        Back to Gallery</a>
                </div>
            </div>
        </div>
    </div>
</x-viewer-layout>
