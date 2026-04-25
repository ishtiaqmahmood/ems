<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-12">

        {{-- Breadcrumb --}}
        <nav class="flex text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/admin" class="hover:text-violet-600 inline-flex items-center">
                        <i class="bi bi-house-door-fill mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('admin.departments.index') }}" class="hover:text-violet-600">Departments</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-400">{{ $department->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Section --}}
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-violet-100/50 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-violet-600 to-indigo-700 p-12 text-white relative">
                <div class="absolute top-0 right-0 p-12 opacity-10">
                    <i class="bi bi-diagram-3 text-9xl"></i>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div>
                        <p class="text-violet-100 text-xs font-black uppercase tracking-[0.3em] mb-3">Department Profile</p>
                        <h1 class="text-5xl font-black tracking-tighter">{{ $department->name }}</h1>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold border border-white/30">
                                {{ $department->organization->name ?? 'Standalone' }}
                            </span>
                            <span class="px-4 py-1.5 bg-violet-400/30 rounded-full text-xs font-bold border border-violet-300/30">
                                Code: {{ $department->code ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.departments.edit', $department) }}"
                            class="px-8 py-4 bg-white text-indigo-600 font-black rounded-2xl shadow-xl hover:bg-slate-50 hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                            <i class="bi bi-pencil-square"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            {{-- Info Content --}}
            <div class="p-12 grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- Metadata Sidebar --}}
                <div class="space-y-8">
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Technical Details</h3>
                        <div class="bg-slate-50 rounded-3xl p-6 space-y-4">
                            <div class="flex justify-between border-b border-slate-200 pb-3">
                                <span class="text-gray-500 font-bold text-xs uppercase">UUID</span>
                                <span class="text-gray-900 font-mono text-xs truncate max-w-[150px]">{{ $department->uuid ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200 pb-3">
                                <span class="text-gray-500 font-bold text-xs uppercase">Slug</span>
                                <span class="text-gray-900 font-medium text-xs">{{ $department->slug ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200 pb-3">
                                <span class="text-gray-500 font-bold text-xs uppercase">Sort Order</span>
                                <span class="text-gray-900 font-black">{{ $department->sort_order }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-bold text-xs uppercase">Status</span>
                                @php
                                    $statusStyles = [
                                        'active' => 'text-emerald-500',
                                        'inactive' => 'text-rose-500',
                                        'archived' => 'text-slate-400',
                                    ];
                                @endphp
                                <span class="font-black uppercase tracking-widest text-xs {{ $statusStyles[$department->status] ?? 'text-gray-400' }}">
                                    ● {{ $department->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($department->images)
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Gallery</h3>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach (json_decode($department->images) as $img)
                                    <div class="group relative rounded-2xl overflow-hidden aspect-square shadow-md">
                                        <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Main Info --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- About --}}
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-3">
                            <i class="bi bi-text-left text-violet-500"></i> Functional Description
                        </h3>
                        <div class="bg-indigo-50/30 border border-indigo-100 rounded-[2.5rem] p-10">
                            <p class="text-gray-700 font-medium leading-relaxed text-lg italic">
                                "{{ $department->description ?? 'No specific mission statement provided for this department yet.' }}"
                            </p>
                        </div>
                    </div>

                    {{-- Sections --}}
                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-3">
                                <i class="bi bi-grid-3x3-gap text-violet-500"></i> Departmental Sections
                            </h3>
                            <span class="px-4 py-1 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">{{ $department->sections->count() }} Total</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse ($department->sections as $section)
                                <a href="{{ route('admin.sections.show', $section) }}" class="group bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-colors">
                                            <i class="bi bi-stack"></i>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-widest {{ $section->status == 'active' ? 'text-emerald-500' : 'text-slate-400' }}">
                                            {{ $section->status }}
                                        </span>
                                    </div>
                                    <h4 class="text-lg font-black text-gray-900 mb-2">{{ $section->name }}</h4>
                                    <p class="text-gray-400 text-sm font-medium line-clamp-2">
                                        {{ $section->description ?? 'No additional description for this section.' }}
                                    </p>
                                </a>
                            @empty
                                <div class="col-span-full py-12 text-center bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No sections registered</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-admin-layout>
