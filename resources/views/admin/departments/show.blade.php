<x-admin-layout>
    <div class="container mx-auto px-4 py-10 space-y-10">

        {{-- Breadcrumb --}}
        <nav class="text-gray-500 text-sm mb-4" aria-label="Breadcrumb">
            <ol class="list-reset flex items-center space-x-2">
                <li><a href="/admin" class="hover:text-sky-600">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('admin.departments.index') }}" class="hover:text-sky-600">Departments</a></li>
                <li>/</li>
                <li class="text-gray-700 font-semibold">{{ $department->name }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1
                    class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-sky-600 to-blue-400 drop-shadow">
                    {{ $department->name }} Details
                </h1>
                <p class="text-gray-500 mt-1">Comprehensive overview of the department</p>
            </div>

            <a href="{{ route('admin.departments.edit', $department) }}"
                class="mt-4 md:mt-0 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                <i class="bi bi-pencil-square text-lg"></i>
                Edit Department
            </a>
        </div>

        {{-- Department Info --}}
        <div
            class="bg-white/70 backdrop-blur-lg border border-gray-200 shadow-xl rounded-2xl p-8 transition hover:shadow-2xl">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                {{-- Left --}}
                <div class="space-y-4 text-gray-700">
                    <p><span class="font-semibold">UUID:</span> {{ $department->uuid ?? '-' }}</p>
                    <p><span class="font-semibold">Organization:</span> {{ $department->organization->name ?? '-' }}</p>
                    <p><span class="font-semibold">Code:</span> {{ $department->code ?? '-' }}</p>
                    <p><span class="font-semibold">Slug:</span> {{ $department->slug ?? '-' }}</p>

                    <p class="flex items-center gap-2">
                        <span class="font-semibold">Status:</span>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $department->status == 'active'
                            ? 'bg-green-100 text-green-800'
                            : ($department->status == 'inactive'
                                ? 'bg-red-100 text-red-800'
                                : 'bg-gray-200 text-gray-800') }}">
                            {{ ucfirst($department->status) }}
                        </span>
                    </p>

                    <p><span class="font-semibold">Sort Order:</span> {{ $department->sort_order }}</p>
                </div>

                {{-- Images --}}
                <div>
                    @if ($department->images)
                        <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="bi bi-images text-sky-600"></i> Images
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach (json_decode($department->images) as $img)
                                <div
                                    class="rounded-xl overflow-hidden shadow hover:shadow-xl hover:-translate-y-1 transform transition-all">
                                    <img src="{{ asset('storage/' . $img) }}"
                                        class="w-full h-36 object-cover rounded-xl">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            {{-- Description --}}
            @if ($department->description)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold flex items-center gap-2 text-gray-800">
                        <i class="bi bi-text-paragraph text-sky-600"></i> Description
                    </h2>
                    <p class="text-gray-600 leading-relaxed mt-2 whitespace-pre-line">
                        {{ $department->description }}
                    </p>
                </div>
            @endif

        </div>

        {{-- Sections --}}
        @if ($department->sections && $department->sections->count())
            <div class="bg-white/70 backdrop-blur-lg border border-gray-200 shadow-xl rounded-2xl p-8">

                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-grid-3x3-gap text-sky-600"></i>
                    Sections under this Department
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    @foreach ($department->sections as $section)
                        <div
                            class="rounded-xl p-5 bg-gradient-to-br from-gray-50 to-gray-100 shadow hover:shadow-2xl border border-gray-200 hover:-translate-y-1 transition-all duration-300">

                            <h3 class="text-lg font-bold text-gray-800 mb-2">
                                <a href="{{ route('admin.sections.show', $section) }}"
                                    class="hover:text-sky-600">{{ $section->name }}</a>
                            </h3>

                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($section->description, 80) }}
                            </p>

                            <span
                                class="px-3 py-1 text-xs rounded-full
                                {{ $section->status == 'active'
                                    ? 'bg-green-100 text-green-800'
                                    : ($section->status == 'inactive'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-gray-200 text-gray-800') }}">
                                {{ ucfirst($section->status) }}
                            </span>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

    </div>
</x-admin-layout>
