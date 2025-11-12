<x-admin-layout>
    <div class="max-w-5xl mx-auto py-10 px-6">
        <!-- Page Title -->
        <h2 class="text-3xl font-semibold text-sky-700 mb-8 flex items-center gap-2">
            <i class="bi bi-person-circle text-sky-600 text-3xl"></i>
            My Profile
        </h2>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-300 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white shadow-xl border border-gray-100 rounded-2xl p-8 transition hover:shadow-2xl">
            <!-- Profile Header -->
            <div class="flex flex-col items-center text-center mb-8">
                <img src="{{ $user->profile_pic }}" alt="Profile Picture"
                    class="rounded-full border-4 border-sky-200 shadow-md w-36 h-36 object-cover mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-500">{{ $user->designation ?? 'No designation' }}</p>
            </div>

            <!-- Info Sections -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Account Info -->
                <div class="bg-sky-50 rounded-xl p-5 border border-sky-100 shadow-sm">
                    <h4 class="text-lg font-semibold text-sky-700 mb-3 flex items-center gap-2">
                        <i class="bi bi-person-badge text-sky-600"></i> Account Info
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li><span class="font-medium text-gray-900">Email:</span> {{ $user->email }}</li>
                        <li><span class="font-medium text-gray-900">Role:</span> {{ ucfirst($user->role) }}</li>
                        <li><span class="font-medium text-gray-900">Status:</span> {{ ucfirst($user->status) }}</li>
                        <li><span class="font-medium text-gray-900">Employee ID:</span>
                            {{ $user->employee_id ?? 'N/A' }}</li>
                    </ul>
                </div>

                <!-- Employment Info -->
                <div class="bg-sky-50 rounded-xl p-5 border border-sky-100 shadow-sm">
                    <h4 class="text-lg font-semibold text-sky-700 mb-3 flex items-center gap-2">
                        <i class="bi bi-briefcase text-sky-600"></i> Employment Info
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li><span class="font-medium text-gray-900">Department:</span> {{ $user->department ?? 'N/A' }}
                        </li>
                        <li><span class="font-medium text-gray-900">Joining Date:</span>
                            {{ $user->joining_date ?? 'N/A' }}</li>
                    </ul>
                </div>

                <!-- Personal Info -->
                <div class="bg-sky-50 rounded-xl p-5 border border-sky-100 shadow-sm">
                    <h4 class="text-lg font-semibold text-sky-700 mb-3 flex items-center gap-2">
                        <i class="bi bi-person-lines-fill text-sky-600"></i> Personal Info
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li><span class="font-medium text-gray-900">Date of Birth:</span>
                            {{ $user->date_of_birth ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-900">Gender:</span> {{ $user->gender ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-900">National ID:</span>
                            {{ $user->national_id ?? 'N/A' }}</li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="bg-sky-50 rounded-xl p-5 border border-sky-100 shadow-sm">
                    <h4 class="text-lg font-semibold text-sky-700 mb-3 flex items-center gap-2">
                        <i class="bi bi-telephone text-sky-600"></i> Contact Info
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li><span class="font-medium text-gray-900">Phone:</span> {{ $user->phone ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-900">Emergency Contact:</span>
                            {{ $user->emergency_contact ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-900">Address:</span> {{ $user->address ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-900">City:</span> {{ $user->city ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-900">Country:</span> {{ $user->country ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admin.profile.edit') }}"
                    class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-xl shadow-md transition">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profile
                </a>
                <a href="{{ route('admin.profile.change_password') }}"
                    class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl shadow-md transition">
                    <i class="bi bi-lock me-1"></i> Change Password
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
