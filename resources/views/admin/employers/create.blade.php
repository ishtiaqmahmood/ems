<x-admin-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            {{ isset($employer) ? 'Edit' : 'Create' }} Employer
        </h1>

        <form
            action="{{ isset($employer) ? route('admin.employers.update', $employer) : route('admin.employers.store') }}"
            method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-4">
            @csrf
            @if (isset($employer))
                @method('PUT')
            @endif

            {{-- Organization --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Organization</label>
                <select name="organization_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                    required>
                    <option value="">Select Organization</option>
                    @foreach ($organizations as $org)
                        <option value="{{ $org->id }}"
                            {{ old('organization_id', $employer->organization_id ?? '') == $org->id ? 'selected' : '' }}>
                            {{ $org->name }}</option>
                    @endforeach
                </select>
                @error('organization_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Department --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Department</label>
                <select name="department_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <option value="">Select Department</option>
                    @foreach ($departments as $d)
                        <option value="{{ $d->id }}"
                            {{ old('department_id', $employer->department_id ?? '') == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Section --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Section</label>
                <select name="section_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <option value="">Select Section</option>
                    @foreach ($sections as $s)
                        <option value="{{ $s->id }}"
                            {{ old('section_id', $employer->section_id ?? '') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }}</option>
                    @endforeach
                </select>
                @error('section_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Basic Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $employer->name ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $employer->email ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                        required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $employer->phone ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Designation</label>
                    <input type="text" name="designation"
                        value="{{ old('designation', $employer->designation ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('designation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Gender</label>
                    <select name="gender"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <option value="">Select Gender</option>
                        <option value="male"
                            {{ old('gender', $employer->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female"
                            {{ old('gender', $employer->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other"
                            {{ old('gender', $employer->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                        value="{{ old('date_of_birth', $employer->date_of_birth ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('date_of_birth')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Blood Group</label>
                    <input type="text" name="blood_group"
                        value="{{ old('blood_group', $employer->blood_group ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('blood_group')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Address --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Country</label>
                    <input type="text" name="country" value="{{ old('country', $employer->country ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('country')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $employer->city ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('city')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">State</label>
                    <input type="text" name="state" value="{{ old('state', $employer->state ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('state')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Postal Code</label>
                    <input type="text" name="postal_code"
                        value="{{ old('postal_code', $employer->postal_code ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('postal_code')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Address</label>
                    <textarea name="address" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">{{ old('address', $employer->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Profile Image --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Profile Image</label>
                <input type="file" name="profile_image" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                @if (isset($employer) && $employer->profile_image)
                    <img src="{{ asset('storage/' . $employer->profile_image) }}" alt="Profile"
                        class="mt-2 w-32 h-32 object-cover rounded">
                @endif
                @error('profile_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Documents --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Documents</label>
                <input type="file" name="documents[]" multiple
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                @if (isset($employer) && $employer->documents)
                    <ul class="mt-2 list-disc ml-5">
                        @foreach (json_decode($employer->documents) as $doc)
                            <li><a href="{{ asset('storage/' . $doc) }}" target="_blank"
                                    class="text-sky-600 hover:underline">{{ basename($doc) }}</a></li>
                        @endforeach
                    </ul>
                @endif
                @error('documents')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Employment Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Joining Date</label>
                    <input type="date" name="joining_date"
                        value="{{ old('joining_date', $employer->joining_date ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('joining_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Resign Date</label>
                    <input type="date" name="resign_date"
                        value="{{ old('resign_date', $employer->resign_date ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('resign_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Emergency Contact --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name"
                        value="{{ old('emergency_contact_name', $employer->emergency_contact_name ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('emergency_contact_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Emergency Contact Phone</label>
                    <input type="text" name="emergency_contact_phone"
                        value="{{ old('emergency_contact_phone', $employer->emergency_contact_phone ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('emergency_contact_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Relation</label>
                    <input type="text" name="emergency_relation"
                        value="{{ old('emergency_relation', $employer->emergency_relation ?? '') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    @error('emergency_relation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Status</label>
                <select name="status"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <option value="active" {{ old('status', $employer->status ?? '') == 'active' ? 'selected' : '' }}>
                        Active</option>
                    <option value="inactive"
                        {{ old('status', $employer->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="terminated"
                        {{ old('status', $employer->status ?? '') == 'terminated' ? 'selected' : '' }}>Terminated
                    </option>
                    <option value="resigned"
                        {{ old('status', $employer->status ?? '') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit"
                    class="px-6 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 transition">
                    {{ isset($employer) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
