<x-admin-layout>
    <div class="container mx-auto px-4 py-6 space-y-6">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">{{ $section->name }} Details</h1>
            <a href="{{ route('admin.sections.edit', $section) }}"
                class="px-4 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>

        {{-- Section Info --}}
        <div class="bg-white shadow-lg rounded-2xl p-6 space-y-4 border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Section Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Organization:</span>
                        {{ $section->organization->name ?? '-' }}</p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Department:</span>
                        {{ $section->department->name ?? '-' }}</p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Sort Order:</span>
                        {{ $section->sort_order ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">UUID:</span> <span
                            class="font-mono text-gray-700 bg-gray-100 px-2 py-0.5 rounded">{{ $section->uuid }}</span>
                    </p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Status:</span>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $section->status == 'active' ? 'bg-green-100 text-green-800' : ($section->status == 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                            {{ ucfirst($section->status) }}
                        </span>
                    </p>
                </div>
            </div>

            @if ($section->description)
                <div class="mt-4">
                    <h3 class="font-semibold text-gray-800 mb-1">Description</h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $section->description }}</p>
                </div>
            @endif
        </div>


        {{-- Images --}}
        @if ($section->images && count($section->images))
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <h2 class="text-xl font-semibold mb-3">Section Images</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($section->images as $img)
                        <img src="{{ asset('storage/' . $img) }}"
                            class="rounded-lg shadow h-32 w-full object-cover hover:scale-105 transform transition">
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Employees in this Section --}}
        @if ($section->employees && $section->employees->count())
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <h2 class="text-xl font-semibold mb-3">Employees in this Section</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse text-left">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
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
                                    <td class="p-3">{{ $emp->name }}</td>
                                    <td class="p-3">{{ $emp->email }}</td>
                                    <td class="p-3">{{ $emp->phone ?? '-' }}</td>
                                    <td class="p-3">{{ $emp->designation ?? '-' }}</td>
                                    <td class="p-3">
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium
                                            {{ $emp->status == 'active' ? 'bg-green-100 text-green-800' : ($emp->status == 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
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
