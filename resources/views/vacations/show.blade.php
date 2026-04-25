<x-viewer-layout>
    <div class="max-w-5xl mx-auto p-6 space-y-8">

        {{-- Breadcrumb --}}
        <nav class="flex text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-sky-600 inline-flex items-center">
                        <i class="bi bi-house-door-fill mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('vacations.index') }}" class="hover:text-sky-600">Vacations</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-400">Application Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Main Content --}}
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-indigo-100/50">

            {{-- Header Section --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-700 p-8 text-white relative">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="bi bi-calendar-event text-8xl"></i>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider mb-2">Leave Application</p>
                        <h1 class="text-3xl font-extrabold flex items-center gap-3">
                            {{ $vacation->user->name }}
                        </h1>
                        <p class="text-indigo-100 mt-1 flex items-center gap-2">
                            <i class="bi bi-briefcase"></i>
                            {{ $vacation->designation ?? 'N/A' }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-bookmark-fill"></i>
                            {{ $vacation->leaveType->name_en }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $statusColors = [
                                'pending'  => 'bg-amber-400/20 text-amber-100 border-amber-400/30',
                                'approved' => 'bg-emerald-400/20 text-emerald-100 border-emerald-400/30',
                                'rejected' => 'bg-rose-400/20 text-rose-100 border-rose-400/30',
                            ];
                        @endphp
                        <span class="px-5 py-2.5 rounded-full text-sm font-bold border {{ $statusColors[$vacation->status] ?? 'bg-white/20 text-white border-white/30' }} backdrop-blur-md uppercase tracking-widest">
                            <i class="bi bi-circle-fill text-[10px] mr-2"></i>
                            {{ $vacation->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 border-b border-gray-100">
                <div class="p-8 border-r border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="bi bi-calendar-range text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Duration</p>
                        <p class="text-lg font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($vacation->start_date)->diffInDays(\Carbon\Carbon::parse($vacation->end_date)) + 1 }} Days
                        </p>
                    </div>
                </div>
                <div class="p-8 border-r border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Starts</p>
                        <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($vacation->start_date)->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="p-8 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">
                        <i class="bi bi-calendar-x text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Ends</p>
                        <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($vacation->end_date)->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Detailed Information --}}
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-12">

                {{-- Column 1 --}}
                <div class="space-y-8">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                            <i class="bi bi-card-text text-indigo-600"></i>
                            Leave Details
                        </h2>
                        <div class="bg-slate-50 rounded-2xl p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-medium">Reason</span>
                                <span class="text-gray-900 font-bold">{{ $vacation->reason ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-gray-500 font-medium text-sm">Description</span>
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $vacation->description ?? 'No additional description provided.' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                            <i class="bi bi-person-check text-indigo-600"></i>
                            Replacement Information
                        </h2>
                        <div class="bg-indigo-50/50 rounded-2xl p-6 flex items-center gap-4 border border-indigo-100">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black">
                                {{ $vacation->replacementUser ? strtoupper(substr($vacation->replacementUser->name, 0, 2)) : '?' }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-indigo-500 uppercase">Replacement Employee</p>
                                <p class="text-gray-900 font-bold">{{ $vacation->replacementUser->name ?? 'None Assigned' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 2 --}}
                <div class="space-y-8">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                            <i class="bi bi-info-circle text-indigo-600"></i>
                            Employment Snapshot
                        </h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 border-b border-gray-50">
                                <span class="text-gray-500 text-sm">Mobile</span>
                                <span class="font-semibold text-gray-800">{{ $vacation->mobile ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 border-b border-gray-50">
                                <span class="text-gray-500 text-sm">NID Number</span>
                                <span class="font-semibold text-gray-800">{{ $vacation->nid_number ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 border-b border-gray-50">
                                <span class="text-gray-500 text-sm">Due Leave Balance</span>
                                <span class="font-bold text-indigo-600">{{ $vacation->due_leave ?? 0 }} Days</span>
                            </div>
                            <div class="flex items-center justify-between p-3">
                                <span class="text-gray-500 text-sm">Address During Leave</span>
                                <span class="text-right font-medium text-gray-800 text-xs max-w-[200px]">{{ $vacation->address ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                            <i class="bi bi-file-earmark-pdf text-indigo-600"></i>
                            Documents
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            @if($vacation->letter_pdf)
                            <a href="{{ Storage::url($vacation->letter_pdf) }}" target="_blank" class="p-4 bg-white border border-gray-200 rounded-xl flex flex-col items-center gap-2 hover:border-indigo-400 hover:shadow-md transition group">
                                <i class="bi bi-file-earmark-text text-2xl text-gray-400 group-hover:text-indigo-600"></i>
                                <span class="text-xs font-bold text-gray-600 group-hover:text-indigo-900">Leave Letter</span>
                            </a>
                            @endif

                            @if($vacation->medical_certificate)
                            <a href="{{ Storage::url($vacation->medical_certificate) }}" target="_blank" class="p-4 bg-white border border-gray-200 rounded-xl flex flex-col items-center gap-2 hover:border-emerald-400 hover:shadow-md transition group">
                                <i class="bi bi-file-earmark-medical text-2xl text-gray-400 group-hover:text-emerald-600"></i>
                                <span class="text-xs font-bold text-gray-600 group-hover:text-emerald-900">Medical Cert</span>
                            </a>
                            @endif

                            @if(!$vacation->letter_pdf && !$vacation->medical_certificate)
                            <div class="col-span-2 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200 flex items-center justify-center">
                                <p class="text-gray-400 text-sm font-medium">No documents attached.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="bg-slate-50 p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex gap-4">
                    @if($vacation->status === 'pending')
                        <a href="{{ route('vacations.edit', $vacation) }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white border border-gray-200 text-gray-800 font-bold rounded-2xl hover:bg-gray-50 transition shadow-sm">
                            <i class="bi bi-pencil"></i> Edit Application
                        </a>
                    @endif
                </div>
                <div class="flex gap-4">
                    <button onclick="window.print()" class="inline-flex items-center gap-2 px-8 py-3 bg-slate-800 text-white font-bold rounded-2xl hover:bg-slate-900 transition shadow-xl">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <a href="{{ route('vacations.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-200">
                        Back to Overview
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-viewer-layout>
