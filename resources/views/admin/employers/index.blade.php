<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-12">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                    <span class="p-3 bg-emerald-600 text-white rounded-2xl shadow-xl shadow-emerald-100">
                        <i class="bi bi-people text-2xl"></i>
                    </span>
                    Employees
                </h2>
                <p class="text-gray-500 font-medium ml-1">Manage your workforce, positions, and contact details.</p>
            </div>

            <a href="{{ route('admin.employers.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all duration-300">
                <i class="bi bi-person-plus-fill"></i>
                <span>Hire New Employee</span>
            </a>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] border-b border-gray-50">
                            <th class="px-8 py-6">Employee</th>
                            <th class="px-8 py-6">Position & Dept</th>
                            <th class="px-8 py-6">Contact</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse ($employers as $employer)
                            <tr class="group hover:bg-slate-50/80 transition-all duration-200">

                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-black shadow-lg shadow-emerald-100">
                                            {{ strtoupper(substr($employer->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-black text-lg group-hover:text-emerald-600 transition-colors">{{ $employer->name }}</p>
                                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">ID: #{{ str_pad($employer->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-8 py-6">
                                    <p class="text-gray-800 font-bold">{{ $employer->designation ?? 'Staff Member' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <i class="bi bi-diagram-2 text-emerald-500 text-xs"></i>
                                        <span class="text-gray-500 text-xs font-medium">{{ $employer->department->name ?? 'Unassigned' }}</span>
                                    </div>
                                </td>

                                <td class="px-8 py-6">
                                    <p class="text-gray-700 text-sm font-bold">{{ $employer->email }}</p>
                                    <p class="text-gray-400 text-xs font-medium mt-0.5">{{ $employer->phone ?? 'No phone' }}</p>
                                </td>

                                <td class="px-8 py-6">
                                    @php
                                        $statusStyles = [
                                            'active'   => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'inactive' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'resigned' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusStyles[$employer->status] ?? $statusStyles['inactive'] }}">
                                        {{ $employer->status }}
                                    </span>
                                </td>

                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.employers.show', $employer) }}"
                                            class="p-3 bg-sky-50 text-sky-600 rounded-xl hover:bg-sky-600 hover:text-white transition-all duration-300 shadow-sm"
                                            title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('admin.employers.edit', $employer) }}"
                                            class="p-3 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all duration-300 shadow-sm"
                                            title="Edit Profile">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('admin.employers.destroy', $employer) }}" method="POST"
                                            onsubmit="return confirm('Permanently remove this employee?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <p class="text-gray-400 font-bold">No employees found in the directory.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($employers->hasPages())
                <div class="p-8 border-t border-gray-50 bg-gray-50/30">
                    {{ $employers->links() }}
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>
