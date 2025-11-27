<x-admin-layout>
    <div class="container mx-auto px-4 py-8 space-y-10">

        {{-- Page Header --}}
        <div class="flex justify-between items-center">
            <div>
                <h1
                    class="text-4xl font-extrabold bg-clip-text text-transparent
                    bg-gradient-to-r from-sky-600 to-blue-400 drop-shadow">
                    {{ $section->name }} Details
                </h1>
                <p class="text-gray-500 mt-1">Complete overview of this section</p>
            </div>

            <a href="{{ route('admin.sections.edit', $section) }}"
                class="px-5 py-2.5 bg-gradient-to-r from-sky-600 to-blue-500 text-white
               rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                <i class="bi bi-pencil-square mr-1"></i> Edit Section
            </a>
        </div>

        {{-- Section Info --}}
        <div class="bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl p-8 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="bi bi-info-circle text-sky-600"></i> Section Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Left Columns --}}
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 text-sm">Organization</p>
                        <p class="text-gray-800 font-semibold text-lg">
                            {{ $section->organization->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Department</p>
                        <p class="text-gray-800 font-semibold text-lg">
                            {{ $section->department->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Sort Order</p>
                        <p class="text-gray-800 font-semibold text-lg">
                            {{ $section->sort_order ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- Right Columns --}}
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 text-sm">UUID</p>
                        <span class="font-mono text-gray-700 bg-gray-100 px-3 py-1.5 rounded-lg shadow-sm inline-block">
                            {{ $section->uuid }}
                        </span>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Status</p>
                        <span
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            @if ($section->status === 'active') bg-green-100 text-green-700
                            @elseif($section->status === 'inactive') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($section->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if ($section->description)
                <div class="mt-6">
                    <h3 class="font-semibold text-gray-800 text-lg">Description</h3>
                    <p class="text-gray-700 mt-1 leading-relaxed whitespace-pre-line">
                        {{ $section->description }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Section Images --}}
        @if ($section->images && count($section->images))
            <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl p-8 border border-gray-200">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="bi bi-images text-purple-600"></i> Section Images
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @foreach ($section->images as $img)
                        <div class="relative group rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/' . $img) }}"
                                class="h-40 w-full object-cover group-hover:scale-110 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Employee List --}}
        @if ($section->employees && $section->employees->count())
            <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl p-8 border border-gray-200">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="bi bi-people text-emerald-600"></i> Employees in this Section
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                            <tr>
                                <th class="p-3 border-b">Name</th>
                                <th class="p-3 border-b">Email</th>
                                <th class="p-3 border-b">Phone</th>
                                <th class="p-3 border-b">Designation</th>
                                <th class="p-3 border-b">Status</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">
                            @foreach ($section->employees as $emp)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3">
                                        <a href="{{ route('admin.employers.show', $emp) }}"
                                            class="text-sky-600 font-semibold hover:underline hover:text-sky-700 transition">
                                            {{ $emp->name }}
                                        </a>
                                    </td>
                                    <td class="p-3">{{ $emp->email }}</td>
                                    <td class="p-3">{{ $emp->phone ?? '-' }}</td>
                                    <td class="p-3">{{ $emp->designation ?? '-' }}</td>
                                    <td class="p-3">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                            @if ($emp->status == 'active') bg-green-100 text-green-700
                                            @elseif ($emp->status == 'inactive') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst($emp->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</x-admin-layout>
