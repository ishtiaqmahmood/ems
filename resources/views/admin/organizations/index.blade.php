<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-12">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                    <span class="p-3 bg-sky-600 text-white rounded-2xl shadow-xl shadow-sky-100">
                        <i class="bi bi-building text-2xl"></i>
                    </span>
                    Organizations
                </h2>
                <p class="text-gray-500 font-medium ml-1">Manage corporate entities and branch information.</p>
            </div>

            <a href="{{ route('admin.organizations.create') }}"
                class="inline-flex items-center gap-2 bg-sky-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-sky-200 hover:bg-sky-700 hover:-translate-y-1 transition-all duration-300">
                <i class="bi bi-plus-lg"></i>
                <span>Add New Organization</span>
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 border-2 border-emerald-100 rounded-2xl font-bold flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-xl"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Organizations Feed --}}
        <div class="space-y-10">
            @forelse ($organizations as $org)
                <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 group transition-all duration-500 hover:shadow-sky-100/50">

                    <div class="flex flex-col lg:flex-row">

                        {{-- Identity Section --}}
                        <div class="lg:w-1/3 p-10 bg-slate-50/50 border-r border-gray-50 space-y-8">
                            <div class="flex items-center gap-6">
                                @if ($org->logo_url)
                                    <img src="{{ $org->logo_url }}" alt="Logo"
                                        class="w-20 h-20 rounded-[1.5rem] object-cover border-4 border-white shadow-xl">
                                @else
                                    <div class="w-20 h-20 rounded-[1.5rem] bg-white flex items-center justify-center text-sky-200 border-4 border-white shadow-xl">
                                        <i class="bi bi-building text-3xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900 leading-tight">{{ $org->name }}</h3>
                                    <span class="text-xs font-black text-sky-600 uppercase tracking-widest">Enterprise</span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-gray-50">
                                    <i class="bi bi-envelope-at text-sky-500"></i>
                                    <span class="text-sm font-bold text-gray-700 truncate">{{ $org->email ?? 'no-email@corp.com' }}</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-gray-50">
                                    <i class="bi bi-phone text-emerald-500"></i>
                                    <span class="text-sm font-bold text-gray-700">{{ $org->phone ?? 'N/A' }}</span>
                                </div>
                                @if($org->website)
                                    <a href="{{ $org->website }}" target="_blank" class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-gray-50 hover:bg-sky-50 transition-colors group/link">
                                        <i class="bi bi-globe2 text-orange-500 group-hover/link:animate-spin"></i>
                                        <span class="text-sm font-bold text-sky-600 truncate">{{ $org->website }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Content Section --}}
                        <div class="flex-1 p-10 flex flex-col justify-between space-y-8">
                            <div>
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">About the organization</h4>
                                <p class="text-gray-600 font-medium leading-relaxed italic">
                                    "{{ $org->description ?? 'Empowering our workforce with excellence and integrity.' }}"
                                </p>
                            </div>

                            {{-- Image Carousel / Gallery Preview --}}
                            @if ($org->images && count($org->images))
                                <div class="relative rounded-3xl overflow-hidden h-48 bg-slate-100 group/gallery">
                                    <div class="absolute inset-0 flex">
                                        @foreach($org->image_urls as $url)
                                            <img src="{{ $url }}" class="w-1/3 h-full object-cover border-r border-white/20 first:rounded-l-3xl last:rounded-r-3xl last:border-0" alt="Org Image">
                                            @if($loop->iteration == 3) @break @endif
                                        @endforeach
                                    </div>
                                    @if(count($org->images) > 3)
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/gallery:opacity-100 transition-opacity cursor-pointer">
                                            <span class="text-white font-black text-sm uppercase tracking-widest">+ {{ count($org->images) - 3 }} More Images</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="flex justify-end items-center gap-4 pt-6">
                                <a href="{{ route('admin.organizations.edit', $org) }}"
                                    class="p-4 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-600 hover:text-white transition-all duration-300 shadow-sm font-bold flex items-center gap-2">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.organizations.destroy', $org) }}" method="POST"
                                    onsubmit="return confirm('Permanently remove this organization?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-4 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm font-bold flex items-center gap-2">
                                        <i class="bi bi-trash3"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-24 bg-white rounded-[3rem] border-4 border-dashed border-gray-100">
                    <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center text-slate-200 mx-auto mb-6">
                        <i class="bi bi-building-slash text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800">Foundation Missing</h3>
                    <p class="text-gray-400 font-bold mt-2">Start by creating your first organization profile.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($organizations->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $organizations->links() }}
            </div>
        @endif

    </div>
</x-admin-layout>
