<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-8">

        {{-- Page Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-building text-sky-600"></i>
                Organization
            </h2>
            <a href="{{ route('admin.organizations.create') }}"
                class="inline-flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-lg shadow hover:bg-sky-700 transition">
                <i class="bi bi-plus-circle"></i> Add New
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Organizations Blog-style Cards --}}
        <div class="space-y-8">
            @forelse ($organizations as $org)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">

                    {{-- Logo and Title --}}
                    <div class="flex items-center gap-4 p-4 border-b border-gray-100">
                        @if ($org->logo_url)
                            <img src="{{ $org->logo_url }}" alt="Logo"
                                class="w-16 h-16 rounded-full object-cover border">
                        @else
                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border">
                                <i class="bi bi-building text-2xl"></i>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-800">{{ $org->name }}</h3>
                    </div>

                    {{-- Image Carousel --}}
                    @if ($org->images && count($org->images))
                        <div x-data="carousel()" x-init="init()"
                            class="relative w-full overflow-hidden rounded-lg h-80 md:h-96">

                            <template x-for="(img, index) in images" :key="index">
                                <div x-show="active === index" x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-500"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="absolute inset-0">
                                    <img :src="img" alt="Organization Image"
                                        class="w-full h-full object-contain">
                                </div>
                            </template>

                            {{-- Prev / Next --}}
                            <button @click="prev()"
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-black/30 text-white rounded-full p-2 hover:bg-black/50 transition">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button @click="next()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black/30 text-white rounded-full p-2 hover:bg-black/50 transition">
                                <i class="bi bi-chevron-right"></i>
                            </button>

                            {{-- Dots --}}
                            <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2">
                                <template x-for="(img, index) in images" :key="index">
                                    <span @click="active = index" :class="active === index ? 'bg-white' : 'bg-white/50'"
                                        class="w-3 h-3 rounded-full cursor-pointer transition"></span>
                                </template>
                            </div>
                        </div>

                        <script>
                            function carousel() {
                                return {
                                    active: 0,
                                    images: @json($org->image_urls),
                                    init() {
                                        if (this.images.length > 1) {
                                            setInterval(() => this.next(), 4000);
                                        }
                                    },
                                    next() {
                                        this.active = (this.active + 1) % this.images.length;
                                    },
                                    prev() {
                                        this.active = (this.active === 0 ? this.images.length - 1 : this.active - 1);
                                    }
                                }
                            }
                        </script>
                    @endif


                    {{-- Description --}}
                    <div class="px-4 py-3 text-gray-700">
                        <p>{{ $org->description ?? 'No description available.' }}</p>
                    </div>

                    {{-- Contact & Website --}}
                    <div class="px-4 py-4 border-t border-gray-200 bg-gray-50 space-y-2">
                        <div class="flex items-center gap-2 text-gray-800 font-semibold">
                            <i class="bi bi-envelope text-sky-500 text-lg"></i>
                            <span>{{ $org->email ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-800 font-semibold">
                            <i class="bi bi-telephone text-green-500 text-lg"></i>
                            <span>{{ $org->phone ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-800 font-semibold">
                            <i class="bi bi-globe text-orange-500 text-lg"></i>
                            @if ($org->website)
                                <a href="{{ $org->website }}" target="_blank"
                                    class="text-sky-600 underline hover:text-sky-800">
                                    {{ $org->website }}
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>


                    {{-- Actions --}}
                    <div class="px-4 py-3 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('admin.organizations.edit', $org) }}"
                            class="inline-flex items-center gap-1 text-yellow-700 bg-yellow-100 hover:bg-yellow-200 px-4 py-2 rounded-md text-sm font-medium transition">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="{{ route('admin.organizations.destroy', $org) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this organization?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 text-red-700 bg-red-100 hover:bg-red-200 px-4 py-2 rounded-md text-sm font-medium transition">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-10">
                    <i class="bi bi-exclamation-circle text-gray-400 text-3xl"></i>
                    <p class="mt-2 text-gray-600">No organizations found.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $organizations->links('pagination::tailwind') }}
        </div>

    </div>
</x-admin-layout>
