<x-admin-layout>
    <div class="max-w-md mx-auto py-12 px-6">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">
            <h2 class="text-2xl font-semibold text-sky-700 mb-6 flex items-center gap-2">
                <i class="bi bi-person-gear text-sky-600"></i>
                Edit User Role
            </h2>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" value="{{ $user->name }}" readonly
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="text" value="{{ $user->email }}" readonly
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Role</label>
                    <select name="role"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition">
                        <option value="viewer" @selected($user->role == 'viewer')>Viewer</option>
                        <option value="admin" @selected($user->role == 'admin')>Admin</option>
                        <option value="hr" @selected($user->role == 'hr')>HR</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-sky-600 text-white font-medium hover:bg-sky-700 shadow-md hover:shadow-lg transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
