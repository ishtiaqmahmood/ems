<x-admin-layout>
    <div class="max-w-6xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-semibold text-sky-700 mb-6 flex items-center gap-2">
            <i class="bi bi-people text-sky-600"></i>
            User List
        </h2>

        <div class="overflow-x-auto bg-white shadow-lg rounded-2xl border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-sky-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Role</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->role == 'Admin' ? 'bg-red-100 text-red-700' : ($user->role == 'HR' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->status == 'Active' ? 'bg-green-100 text-green-700' : ($user->status == 'Inactive' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="px-3 py-1 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition">
                                    Edit
                                </a>

                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 rounded-xl bg-red-600 text-white hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination (optional) --}}
        <div class="mt-6">
            {{-- $users->links() --}}
        </div>
    </div>
</x-admin-layout>
