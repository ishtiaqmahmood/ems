<x-admin-layout>
    <div class="container mx-auto px-4 py-10 space-y-10">

        {{-- Breadcrumb --}}
        <nav class="text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="list-reset flex space-x-2 items-center">
                <li><a href="/admin" class="hover:text-sky-600">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('admin.employers.index') }}" class="hover:text-sky-600">Employers</a></li>
                <li>/</li>
                <li class="text-gray-700 font-semibold">{{ $employer->name }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-5 mb-4">
            <h1 class="text-4xl font-extrabold text-gray-800 drop-shadow">
                {{ $employer->name }} Details
            </h1>

            <a href="{{ route('admin.employers.edit', $employer) }}"
                class="px-5 py-2.5 bg-gradient-to-r from-sky-600 to-blue-600 text-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition flex items-center gap-2">
                <i class="bi bi-pencil-square text-lg"></i> Edit Employer
            </a>
        </div>

        {{-- Profile Photo --}}
        @if ($employer->profile_image)
            <div class="flex justify-center">
                <div class="relative group">
                    <img src="{{ asset('storage/' . $employer->profile_image) }}"
                        class="w-44 h-44 object-cover rounded-full border-4 border-white shadow-xl group-hover:scale-105 transition duration-300">
                </div>
            </div>
        @endif

        {{-- Main Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 space-y-10">

            {{-- General Info --}}
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-3 border-l-4 border-sky-500 pl-3">General Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <p><span class="font-semibold text-gray-700">Organization:</span>
                            {{ $employer->organization->name ?? '-' }}</p>

                        <p><span class="font-semibold text-gray-700">Department:</span>
                            {{ $employer->department->name ?? '-' }}</p>

                        <p><span class="font-semibold text-gray-700">Section:</span>
                            {{ $employer->section->name ?? '-' }}</p>

                        <p><span class="font-semibold text-gray-700">Designation:</span>
                            {{ $employer->designation ?? '-' }}</p>
                    </div>

                    <div class="space-y-3">
                        <p><span class="font-semibold text-gray-700">Email:</span> {{ $employer->email }}</p>
                        <p><span class="font-semibold text-gray-700">Phone:</span> {{ $employer->phone ?? '-' }}</p>

                        <p>
                            <span class="font-semibold text-gray-700">Status:</span>

                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-700 border-green-300',
                                    'inactive' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                    'resigned' => 'bg-red-100 text-red-700 border-red-300',
                                    'terminated' => 'bg-red-100 text-red-700 border-red-300',
                                ];
                            @endphp

                            <span
                                class="px-3 py-1 rounded-full text-sm border {{ $statusColors[$employer->status] ?? 'bg-gray-100 text-gray-700 border-gray-300' }}">
                                {{ ucfirst($employer->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Personal Info --}}
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-3 border-l-4 border-sky-500 pl-3">Personal Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <p><span class="font-semibold text-gray-700">Gender:</span> {{ ucfirst($employer->gender ?? '-') }}
                    </p>

                    <p><span class="font-semibold text-gray-700">DOB:</span> {{ $employer->date_of_birth ?? '-' }}</p>

                    <p><span class="font-semibold text-gray-700">Blood Group:</span>
                        {{ $employer->blood_group ?? '-' }}</p>
                </div>
            </div>

            {{-- Address --}}
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-3 border-l-4 border-sky-500 pl-3">Address</h2>
                <p>{{ $employer->address ?? '-' }}</p>
                <p>{{ $employer->city ?? '' }}, {{ $employer->state ?? '' }}, {{ $employer->country ?? '' }} -
                    {{ $employer->postal_code ?? '' }}</p>
            </div>

            {{-- Employment Info --}}
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-3 border-l-4 border-sky-500 pl-3">Employment Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <p><span class="font-semibold text-gray-700">Joining Date:</span>
                        {{ $employer->joining_date ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Resign Date:</span>
                        {{ $employer->resign_date ?? '-' }}</p>
                </div>
            </div>

            {{-- Emergency Contact --}}
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-3 border-l-4 border-sky-500 pl-3">Emergency Contact</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <p><span class="font-semibold text-gray-700">Name:</span>
                        {{ $employer->emergency_contact_name ?? '-' }}</p>

                    <p><span class="font-semibold text-gray-700">Phone:</span>
                        {{ $employer->emergency_contact_phone ?? '-' }}</p>

                    <p><span class="font-semibold text-gray-700">Relation:</span>
                        {{ $employer->emergency_relation ?? '-' }}</p>
                </div>
            </div>

            {{-- Documents --}}
            @if ($employer->documents)
                <div>
                    <h2 class="text-xl font-bold text-gray-700 mb-3 border-l-4 border-sky-500 pl-3">Documents</h2>

                    <ul class="space-y-2">
                        @foreach (json_decode($employer->documents) as $doc)
                            <li class="flex items-center gap-2">
                                <i class="bi bi-file-earmark-text text-sky-500"></i>

                                <a href="{{ asset('storage/' . $doc) }}" target="_blank"
                                    class="text-sky-600 hover:underline hover:text-sky-700">
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
