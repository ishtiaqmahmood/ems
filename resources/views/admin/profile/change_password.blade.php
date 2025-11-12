<x-admin-layout>
    <div class="max-w-2xl mx-auto py-12 px-6">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">
            <h2 class="text-2xl font-semibold text-sky-700 mb-6 flex items-center gap-2">
                <i class="bi bi-shield-lock text-sky-600 text-xl"></i>
                Change Password
            </h2>

            <form action="{{ route('admin.profile.update_password') }}" method="POST" class="space-y-5">
                @csrf

                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 border border-red-200 rounded-lg">
                        {{ implode(', ', $errors->all()) }}
                    </div>
                @endif

                <!-- Current Password -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Current Password</label>
                    <input type="password" name="current_password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition"
                        placeholder="Enter current password" required>
                </div>

                <!-- New Password -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">New Password</label>
                    <input type="password" name="new_password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition"
                        placeholder="Enter new password" required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition"
                        placeholder="Confirm new password" required>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('admin.profile.show') }}"
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-sky-600 text-white font-medium hover:bg-sky-700 shadow-md hover:shadow-lg transition">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
