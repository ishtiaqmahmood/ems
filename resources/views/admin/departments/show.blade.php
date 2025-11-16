<x-admin-layout>
    <div class="container mx-auto px-4 py-8">

        {{-- Breadcrumb --}}
        <nav class="text-gray-500 text-sm mb-6" aria-label="Breadcrumb">
            <ol class="list-reset flex">
                <li><a href="/admin" class="hover:text-sky-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.departments.index') }}" class="hover:text-sky-600">Departments</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700 font-semibold">{{ $department->name }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-4 md:mb-0">{{ $department->name }} Details</h1>
            <a href="{{ route('admin.departments.edit', $department) }}"
                class="px-5 py-2.5 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition font-medium shadow-lg">
                Edit Department
            </a>
        </div>

        {{-- Department Info Card --}}
        <div class="bg-white shadow-xl rounded-2xl p-6 mb-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Left Column --}}
                <div class="space-y-4">
                    <p><span class="font-semibold text-gray-700">UUID:</span> <span
                            class="text-gray-800">{{ $department->uuid ?? '-' }}</span></p>
                    <p><span class="font-semibold text-gray-700">Organization:</span>
                        {{ $department->organization->name ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Code:</span> {{ $department->code ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Slug:</span> {{ $department->slug ?? '-' }}</p>
                    <p>
                        <span class="font-semibold text-gray-700">Status:</span>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $department->status == 'active' ? 'bg-green-100 text-green-800' : ($department->status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-800') }}">
                            {{ ucfirst($department->status) }}
                        </span>
                    </p>
                    <p><span class="font-semibold text-gray-700">Sort Order:</span> {{ $department->sort_order }}</p>
                </div>

                {{-- Right Column: Images --}}
                <div>
                    @if ($department->images)
                        <p class="font-semibold text-gray-700 mb-3">Images:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach (json_decode($department->images) as $img)
                                <div
                                    class="overflow-hidden rounded-xl shadow hover:scale-105 transform transition duration-300">
                                    <img src="{{ asset('storage/' . $img) }}" alt="Department Image"
                                        class="w-full h-32 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            @if ($department->description)
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Description</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $department->description }}</p>
                </div>
            @endif
        </div>

        {{-- Sections --}}
        @if ($department->sections && $department->sections->count())
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100 mb-8">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Sections under this Department</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($department->sections as $section)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-gray-100 p-5 rounded-xl shadow hover:shadow-2xl transition transform hover:-translate-y-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">
                                <a href="{{ route('admin.sections.show', $section) }}" class="hover:text-sky-600">
                                    {{ $section->name }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($section->description, 80) }}</p>
                            <span
                                class="px-2 py-1 text-xs rounded-full
                                {{ $section->status == 'active' ? 'bg-green-100 text-green-800' : ($section->status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-800') }}">
                                {{ ucfirst($section->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-admin-layout>
