<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-12">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                    <span class="p-3 bg-teal-600 text-white rounded-2xl shadow-xl shadow-teal-100">
                        <i class="bi bi-grid-1x2 text-2xl"></i>
                    </span>
                    Sections
                </h2>
                <p class="text-gray-500 font-medium ml-1">Manage sub-units and team divisions within departments.</p>
            </div>

            <a href="{{ route('admin.sections.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-teal-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-teal-200 hover:bg-teal-700 hover:-translate-y-1 transition-all duration-300">
                <i class="bi bi-plus-lg"></i>
                <span>Create Section</span>
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 border-2 border-emerald-100 rounded-2xl font-bold flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-xl"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Sections List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($sections as $section)
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-teal-600 group-hover:text-white transition-all">
                            <i class="bi bi-stack"></i>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-slate-50 px-3 py-1 rounded-full border border-gray-100">
                            #SEC-{{ str_pad($section->id, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">{{ $section->name }}</h3>

                    <div class="space-y-3 mt-6">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-building text-gray-300"></i>
                            <span class="text-sm font-bold text-gray-600">{{ $section->organization->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="bi bi-diagram-3 text-gray-300"></i>
                            <span class="text-sm font-bold text-gray-500">{{ $section->department->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-50">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.sections.edit', $section) }}" class="p-3 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Delete this section?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('admin.sections.show', $section) }}" class="text-xs font-black text-teal-600 uppercase tracking-widest hover:underline">
                            View Full →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-400 font-bold uppercase tracking-widest">No sections established yet.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-admin-layout>
