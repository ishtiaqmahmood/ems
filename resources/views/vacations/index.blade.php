<x-viewer-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-10">

        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                    <span class="p-3 bg-indigo-600 text-white rounded-2xl shadow-xl shadow-indigo-200">
                        <i class="bi bi-airplane-engines text-2xl"></i>
                    </span>
                    Leave Management
                </h2>
                <p class="text-gray-500 font-medium ml-1">Submit and track your vacation and leave applications.</p>
            </div>

            <div class="flex flex-wrap gap-4">
                <div class="relative group">
                    <button class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all duration-300 shadow-xl shadow-indigo-200">
                        <i class="bi bi-plus-lg text-lg"></i>
                        <span>Apply for Leave</span>
                        <i class="bi bi-chevron-down ml-2 transition-transform group-hover:rotate-180"></i>
                    </button>
                    {{-- Dropdown for leave types if multiple forms exist --}}
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <a href="{{ route('vacations.casual.create') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-indigo-50 text-gray-700 font-bold transition-colors">
                            <i class="bi bi-emoji-smile text-indigo-500"></i> Casual Leave
                        </a>
                        <a href="{{ route('vacations.emergency.create') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-indigo-50 text-gray-700 font-bold transition-colors">
                            <i class="bi bi-exclamation-triangle text-amber-500"></i> Emergency Leave
                        </a>
                        <a href="{{ route('vacations.leave_without_pay.create') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-indigo-50 text-gray-700 font-bold transition-colors">
                            <i class="bi bi-wallet2 text-rose-500"></i> Leave Without Pay
                        </a>
                        <a href="{{ route('vacations.disability.create') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-indigo-50 text-gray-700 font-bold transition-colors">
                            <i class="bi bi-heart-pulse text-emerald-500"></i> Disability Leave
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="bg-emerald-50 border-2 border-emerald-100 p-4 rounded-2xl flex items-center gap-4 text-emerald-700 font-bold animate-fade-in-down">
                <i class="bi bi-check-circle-fill text-2xl"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Applications List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($vacations as $vacation)
                <div class="group bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">

                    {{-- Status Banner --}}
                    @php
                        $statusStyles = [
                            'pending'  => ['bg' => 'bg-amber-500', 'text' => 'Pending Review', 'icon' => 'bi-clock-history'],
                            'approved' => ['bg' => 'bg-emerald-500', 'text' => 'Approved', 'icon' => 'bi-check-all'],
                            'rejected' => ['bg' => 'bg-rose-500', 'text' => 'Rejected', 'icon' => 'bi-x-circle'],
                        ];
                        $style = $statusStyles[$vacation->status] ?? $statusStyles['pending'];
                    @endphp

                    <div class="{{ $style['bg'] }} py-2 px-6 flex items-center justify-between text-white text-[10px] font-black uppercase tracking-[0.2em]">
                        <span class="flex items-center gap-2">
                            <i class="bi {{ $style['icon'] }}"></i>
                            {{ $style['text'] }}
                        </span>
                        <span>#{{ str_pad($vacation->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="p-8 space-y-6 flex-1">
                        {{-- User (Admin/HR View) --}}
                        @if(Auth::user()->role !== 'Viewer')
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-sm">
                                    {{ strtoupper(substr($vacation->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase">Applicant</p>
                                    <p class="text-sm font-black text-gray-800">{{ $vacation->user->name }}</p>
                                </div>
                            </div>
                        @endif

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Leave Type</p>
                            <h3 class="text-xl font-black text-gray-900 group-hover:text-indigo-600 transition-colors">
                                {{ $vacation->leaveType->name_en }}
                            </h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Start Date</p>
                                <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($vacation->start_date)->format('M d, Y') }}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] font-black text-gray-400 uppercase mb-1">End Date</p>
                                <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($vacation->end_date)->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between py-2 border-t border-dashed border-gray-100 mt-4">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-chat-left-dots text-gray-300"></i>
                                <span class="text-xs text-gray-500 font-medium italic truncate max-w-[150px]">
                                    {{ $vacation->reason ?? 'No reason provided' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1 text-indigo-600 font-black">
                                <span class="text-lg">{{ \Carbon\Carbon::parse($vacation->start_date)->diffInDays(\Carbon\Carbon::parse($vacation->end_date)) + 1 }}</span>
                                <span class="text-[10px] uppercase">Days</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 flex items-center justify-between gap-3 border-t border-gray-100">
                        <a href="{{ route('vacations.show', $vacation) }}" class="flex-1 text-center py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-300 shadow-sm text-xs">
                            View Details
                        </a>
                        @if($vacation->status === 'pending')
                            <a href="{{ route('vacations.edit', $vacation) }}" class="p-3 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all duration-300">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        @endif
                        @if($vacation->status === 'pending' || in_array(Auth::user()->role, ['Admin', 'HR']))
                            <form action="{{ route('vacations.destroy', $vacation) }}" method="POST" onsubmit="return confirm('Withdraw this application?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-500 hover:text-white transition-all duration-300">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-50 text-slate-200 mb-6">
                        <i class="bi bi-calendar2-x text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-800">No Applications Found</h3>
                    <p class="text-gray-500 mt-2 font-medium">You haven't submitted any leave requests yet.</p>
                </div>
            @endforelse
        </div>

        @if ($vacations->hasPages())
            <div class="mt-10">
                {{ $vacations->links() }}
            </div>
        @endif
    </div>
</x-viewer-layout>
