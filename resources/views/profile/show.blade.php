<x-viewer-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        {{-- ✅ Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- ========================= --}}
        {{-- 🧑 Profile Overview Section --}}
        {{-- ========================= --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="text-center">
                {{-- Profile Image --}}
                <img src="{{ $user->profile_pic }}" alt="Profile Picture"
                    class="mx-auto mb-4 border-4 border-indigo-500 rounded-full"
                    style="width:150px; height:150px; object-fit:cover;">

                {{-- Basic Info --}}
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->designation ?? 'N/A' }}</p>
                <p class="text-gray-500">{{ $user->department ?? 'N/A' }}</p>

                {{-- Status Badge --}}
                <div class="mt-4">
                    <span
                        class="px-4 py-1 text-sm font-medium rounded-full
                        @if ($user->status == 'Active') bg-green-100 text-green-800
                        @elseif($user->status == 'Inactive') bg-gray-200 text-gray-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $user->status }}
                    </span>
                </div>

                {{-- Personal & Contact Info --}}
                <div class="mt-6 text-left space-y-2 text-sm text-gray-700">
                    <hr class="mb-2">
                    <div class="space-y-1">
                        <p><strong>Role:</strong> {{ $user->role }}</p>
                        <p><strong>Employee ID:</strong> {{ $user->employee_id ?? 'N/A' }}</p>
                        <p><strong>Joining Date:</strong> {{ $user->joining_date ?? 'N/A' }}</p>
                        <p><strong>Date of Birth:</strong> {{ $user->date_of_birth ?? 'N/A' }}</p>
                        <p><strong>Gender:</strong> {{ $user->gender ?? 'N/A' }}</p>
                        <p><strong>National ID:</strong> {{ $user->national_id ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        <p><strong>Emergency Contact:</strong> {{ $user->emergency_contact ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ $user->city ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $user->country ?? 'N/A' }}</p>
                    </div>

                    {{-- Timestamps --}}
                    <hr class="my-2">
                    <p class="text-xs text-gray-500">
                        <strong>Account Created:</strong> {{ $user->created_at->format('d M Y, h:i A') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        <strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- ✍️ Edit Profile Section --}}
            {{-- ========================= --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mt-10">
                <h3 class="text-xl font-semibold mb-6 text-indigo-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 17a4 4 0 100-8 4 4 0 000 8zM21 21l-4.35-4.35" />
                    </svg>
                    Edit Profile
                </h3>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                class="mt-1 w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Designation --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Designation</label>
                            <input type="text" name="designation"
                                value="{{ old('designation', $user->designation) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Department --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <input type="text" name="department" value="{{ old('department', $user->department) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Employee ID --}}
                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700">Employee ID</label>
                            <input type="text" name="employee_id"
                                value="{{ old('employee_id', $user->employee_id) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div> --}}

                        {{-- Joining Date --}}
                        <div>

                            <input type="date" name="joining_date"
                                value="{{ old('joining_date', $user->joining_date ? $user->joining_date->format('Y-m-d') : '') }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Date of Birth --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select</option>
                                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        {{-- National ID --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">National ID</label>
                            <input type="text" name="national_id"
                                value="{{ old('national_id', $user->national_id) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Emergency Contact --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Emergency Contact</label>
                            <input type="text" name="emergency_contact"
                                value="{{ old('emergency_contact', $user->emergency_contact) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Address --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- City --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Country --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" value="{{ old('country', $user->country) }}"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Profile Picture --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                            <input type="file" name="profile_pic"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================= --}}
        {{-- 🔐 Change Password Section --}}
        {{-- ========================= --}}
        <div class="mt-10 bg-white rounded-2xl shadow-lg p-6 border border-gray-100 max-w-3xl mx-auto">
            <h3 class="text-xl font-semibold mb-6 text-yellow-600 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0-1.657-1.343-3-3-3S6 9.343 6 11m6 0a3 3 0 116 0m-6 0v4m0 0H6m6 0h6" />
                </svg>
                Change Password
            </h3>

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="new_password" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 transition">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
