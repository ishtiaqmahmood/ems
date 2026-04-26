<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-12">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                    <span class="p-3 bg-violet-600 text-white rounded-2xl shadow-xl shadow-violet-100">
                        <i class="bi bi-diagram-3 text-2xl"></i>
                    </span>
                    Departments
                </h2>
                <p class="text-gray-500 font-medium ml-1">Structure your organization with specialized functional units.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <form action="{{ route('admin.departments.index') }}" method="GET" class="relative group">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-violet-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-11 pr-6 py-4 bg-white border-2 border-gray-100 rounded-2xl w-full sm:w-64 font-bold text-gray-700 shadow-sm focus:ring-4 focus:ring-violet-500/10 focus:border-violet-500 transition-all outline-none"
                        placeholder="Search...">
                </form>

                <a href="{{ route('admin.departments.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-violet-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-violet-200 hover:bg-violet-700 hover:-translate-y-1 transition-all duration-300">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add Department</span>
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 border-2 border-emerald-100 rounded-2xl font-bold flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-xl"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Departments Table --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] border-b border-gray-50">
                            <th class="px-8 py-6 w-16">Sort</th>
                            <th class="px-8 py-6">Department Identity</th>
                            <th class="px-8 py-6">Organization</th>
                            <th class="px-8 py-6">Code</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="sortable" class="divide-y divide-gray-50">
                        @foreach ($departments as $department)
                            <tr data-id="{{ $department->id }}" class="group hover:bg-slate-50/80 transition-all duration-200">

                                {{-- Drag Handle --}}
                                <td class="px-8 py-6">
                                    <div class="drag-handle cursor-move w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-violet-100 group-hover:text-violet-500 transition-all">
                                        <i class="bi bi-grid-3x2-gap-fill"></i>
                                    </div>
                                </td>

                                {{-- Name & Show Link --}}
                                <td class="px-8 py-6">
                                    <a href="{{ route('admin.departments.show', $department) }}" class="group/link block">
                                        <p class="text-gray-900 font-black text-lg group-hover/link:text-violet-600 transition-colors">{{ $department->name }}</p>
                                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">ID: #{{ str_pad($department->id, 3, '0', STR_PAD_LEFT) }}</p>
                                    </a>
                                </td>

                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                                        <span class="text-gray-600 font-bold">{{ $department->organization->name ?? 'Standalone' }}</span>
                                    </div>
                                </td>

                                <td class="px-8 py-6">
                                    <code class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-black text-xs border border-slate-200">
                                        {{ $department->code ?? 'N/A' }}
                                    </code>
                                </td>

                                <td class="px-8 py-6">
                                    @php
                                        $statusStyles = [
                                            'active'   => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'inactive' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'archived' => 'bg-slate-100 text-slate-500 border-slate-200',
                                        ];
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusStyles[$department->status] ?? $statusStyles['inactive'] }}">
                                        {{ $department->status }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.departments.edit', $department) }}"
                                            class="p-3 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all duration-300 shadow-sm"
                                            title="Edit Department">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST"
                                            onsubmit="return confirm('Permanently delete this department?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm"
                                                title="Delete Department">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($departments->hasPages())
                <div class="p-8 border-t border-gray-50 bg-gray-50/30">
                    {{ $departments->links() }}
                </div>
            @endif
        </div>

        <p class="text-center text-gray-400 text-xs font-bold uppercase tracking-widest">
            <i class="bi bi-info-circle mr-1"></i> Drag and drop the handles to reorder departments.
        </p>

    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            $(function() {
                if (typeof $.fn.sortable !== 'undefined') {
                    $("#sortable").sortable({
                        handle: '.drag-handle',
                        placeholder: "bg-violet-50/50",
                        opacity: 0.8,
                        update: function(event, ui) {
                            let order = [];
                            $('#sortable tr').each(function() {
                                let id = $(this).data('id');
                                if (id) order.push(id);
                            });

                            $.ajax({
                                url: "{{ route('admin.departments.sort') }}",
                                method: 'POST',
                                data: {
                                    order: order,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    console.log('Sort order synchronized.');
                                },
                                error: function(err) {
                                    console.error('Sort synchronization failed.');
                                }
                            });
                        }
                    }).disableSelection();
                }
            });
        </script>
    @endpush
</x-admin-layout>
