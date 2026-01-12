<x-admin-layout>
    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Leave Types</h1>
                <p class="text-sm text-gray-500">
                    Manage organization leave categories and policies
                </p>
            </div>

            <a href="{{ route('admin.leave-types.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-gradient-to-r from-sky-600 to-sky-700
                      text-white font-semibold rounded-xl shadow
                      hover:from-sky-700 hover:to-sky-800
                      transition">
                <i class="bi bi-plus-circle"></i>
                Add Leave Type
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Code
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Paid
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($leaveTypes as $type)
                            <tr class="hover:bg-sky-50 transition">
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full
                                                 text-xs font-semibold bg-sky-100 text-sky-700">
                                        {{ $type->code }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">
                                        {{ $type->name_en }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $type->name_bn }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    @if ($type->max_duration)
                                        {{ $type->max_duration }}
                                        <span class="text-sm text-gray-500">
                                            {{ ucfirst($type->duration_unit) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Unlimited</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if ($type->paid)
                                        <span
                                            class="inline-flex items-center gap-1
                                                     px-3 py-1 rounded-full
                                                     bg-emerald-100 text-emerald-700
                                                     text-xs font-semibold">
                                            <i class="bi bi-check-circle"></i> Paid
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1
                                                     px-3 py-1 rounded-full
                                                     bg-rose-100 text-rose-700
                                                     text-xs font-semibold">
                                            <i class="bi bi-x-circle"></i> Unpaid
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.leave-types.edit', $type) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5
                                              rounded-lg border border-sky-200
                                              text-sky-700 text-sm font-semibold
                                              hover:bg-sky-100 transition">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.leave-types.destroy', $type) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this leave type?')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5
                                                   rounded-lg border border-rose-200
                                                   text-rose-600 text-sm font-semibold
                                                   hover:bg-rose-100 transition">
                                            <i class="bi bi-trash3"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    No leave types found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $leaveTypes->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
