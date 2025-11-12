<x-admin-layout>
    <div class="max-w-5xl mx-auto py-10 px-6">
        <h2 class="text-3xl font-semibold text-sky-700 mb-8 flex items-center gap-2">
            <i class="bi bi-person-lines-fill text-sky-600"></i>
            Edit Profile
        </h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 space-y-6">
            @csrf

            <!-- Profile Picture -->
            <div class="flex flex-col items-center text-center mb-8">
                <img src="{{ $user->profile_pic }}" alt="Profile Picture"
                    class="rounded-full border-4 border-sky-200 shadow-md w-36 h-36 object-cover mb-4">
                <label class="block text-gray-600 font-medium mb-1">Change Profile Picture</label>
                <input type="file" name="profile_pic"
                    class="block w-64 text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400" />
            </div>

            <!-- Grid form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Basic Info -->
                <div>
                    <label class="text-gray-700 font-medium">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                        required>
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm"
                        required>
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Employee ID</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Designation</label>
                    <input type="text" name="designation" value="{{ old('designation', $user->designation) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Department</label>
                    <input type="text" name="department" value="{{ old('department', $user->department) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Joining Date</label>
                    <input type="date" name="joining_date" value="{{ old('joining_date', $user->joining_date) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <!-- Personal Info -->
                <div>
                    <label class="text-gray-700 font-medium">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Gender</label>
                    <select name="gender"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                        <option value="">Select</option>
                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="text-gray-700 font-medium">National ID</label>
                    <input type="text" name="national_id" value="{{ old('national_id', $user->national_id) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Emergency Contact</label>
                    <input type="text" name="emergency_contact"
                        value="{{ old('emergency_contact', $user->emergency_contact) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">City</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Country</label>
                    <input type="text" name="country" value="{{ old('country', $user->country) }}"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                </div>

                <div>
                    <label class="text-gray-700 font-medium">Status</label>
                    <select name="status"
                        class="mt-1 w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500 shadow-sm">
                        <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Suspended" {{ $user->status == 'Suspended' ? 'selected' : '' }}>Suspended
                        </option>
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 mt-8">
                <button type="submit"
                    class="bg-sky-600 text-white px-6 py-2.5 rounded-xl hover:bg-sky-700 shadow-md transition transform hover:scale-[1.02]">
                    Save Changes
                </button>
                <a href="{{ route('admin.profile.show') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
