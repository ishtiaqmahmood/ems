<x-admin-layout>
    <div class="container mx-auto px-4 py-8 space-y-6">

        {{-- Breadcrumb --}}
        <nav class="text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="list-reset flex space-x-2">
                <li><a href="/admin" class="hover:text-sky-600">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('admin.employers.index') }}" class="hover:text-sky-600">Employers</a></li>
                <li>/</li>
                <li class="text-gray-700 font-semibold">{{ $employer->name }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-4xl font-extrabold text-gray-800">{{ $employer->name }} Details</h1>
            <a href="{{ route('admin.employers.edit', $employer) }}"
                class="px-5 py-2.5 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition font-medium shadow-lg">
                Edit Employer
            </a>
        </div>

        {{-- Profile Image --}}
        @if ($employer->profile_image)
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $employer->profile_image) }}"
                    class="w-48 h-48 object-cover rounded-full border shadow-lg">
            </div>
        @endif

        {{-- Basic Info Card --}}
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100 space-y-6">

            {{-- General Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-700">Organization:</span>
                        {{ $employer->organization->name ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Department:</span>
                        {{ $employer->department->name ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Section:</span> {{ $employer->section->name ?? '-' }}
                    </p>
                    <p><span class="font-semibold text-gray-700">Designation:</span> {{ $employer->designation ?? '-' }}
                    </p>
                </div>
                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-700">Email:</span> {{ $employer->email }}</p>
                    <p><span class="font-semibold text-gray-700">Phone:</span> {{ $employer->phone ?? '-' }}</p>
                    <p>
                        <span class="font-semibold text-gray-700">Status:</span>
                        <span
                            class="px-3 py-1 rounded-full
                            {{ $employer->status == 'active' ? 'bg-green-200 text-green-800' : '' }}
                            {{ $employer->status == 'inactive' ? 'bg-yellow-200 text-yellow-800' : '' }}
                            {{ in_array($employer->status, ['resigned', 'terminated']) ? 'bg-red-200 text-red-800' : '' }}">
                            {{ ucfirst($employer->status) }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <p><span class="font-semibold text-gray-700">Gender:</span> {{ ucfirst($employer->gender ?? '-') }}</p>
                <p><span class="font-semibold text-gray-700">DOB:</span> {{ $employer->date_of_birth ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Blood Group:</span> {{ $employer->blood_group ?? '-' }}
                </p>
            </div>

            {{-- Address --}}
            <div>
                <p class="font-semibold text-gray-700 mb-1">Address:</p>
                <p>{{ $employer->address ?? '-' }}</p>
                <p>{{ $employer->city ?? '' }}, {{ $employer->state ?? '' }}, {{ $employer->country ?? '' }} -
                    {{ $employer->postal_code ?? '' }}</p>
            </div>

            {{-- Employment Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <p><span class="font-semibold text-gray-700">Joining Date:</span> {{ $employer->joining_date ?? '-' }}
                </p>
                <p><span class="font-semibold text-gray-700">Resign Date:</span> {{ $employer->resign_date ?? '-' }}
                </p>
            </div>

            {{-- Emergency Contact --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <p><span class="font-semibold text-gray-700">Emergency Name:</span>
                    {{ $employer->emergency_contact_name ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Emergency Phone:</span>
                    {{ $employer->emergency_contact_phone ?? '-' }}</p>
                <p><span class="font-semibold text-gray-700">Relation:</span>
                    {{ $employer->emergency_relation ?? '-' }}</p>
            </div>

            {{-- Documents --}}
            @if ($employer->documents)
                <div>
                    <p class="font-semibold text-gray-700 mb-2">Documents:</p>
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach (json_decode($employer->documents) as $doc)
                            <li>
                                <a href="{{ asset('storage/' . $doc) }}" target="_blank"
                                    class="text-sky-600 hover:underline">
                                    {{ basename($doc) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</x-admin-layout>
