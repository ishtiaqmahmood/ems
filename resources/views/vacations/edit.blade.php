<x-viewer-layout>
    <div class="max-w-5xl mx-auto py-12 px-6">

        {{-- Breadcrumb --}}
        <nav class="flex text-gray-500 text-sm mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600 inline-flex items-center">
                        <i class="bi bi-house-door-fill mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('vacations.index') }}" class="hover:text-indigo-600">Vacations</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-400">Edit Application</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-indigo-100/50">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-700 p-10 text-white relative">
                <div class="absolute top-0 right-0 p-10 opacity-10">
                    <i class="bi bi-pencil-square text-8xl"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-indigo-100 text-xs font-black uppercase tracking-[0.2em] mb-2">Update Request</p>
                    <h2 class="text-4xl font-black tracking-tight">Edit Leave Application</h2>
                    <p class="text-indigo-100/80 mt-2 font-medium">Refine your leave details and supporting documents.</p>
                </div>
            </div>

            {{-- Form Container --}}
            <form action="{{ route('vacations.update', $vacation) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-12">
                @csrf
                @method('PATCH')

                {{-- Personal Snapshot Section --}}
                <div class="space-y-8">
                    <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">01</span>
                        Personal Snapshot
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Mobile Number</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $vacation->mobile) }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300">
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">NID Number</label>
                            <input type="text" name="nid_number" value="{{ old('nid_number', $vacation->nid_number) }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300">
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Designation</label>
                            <input type="text" name="designation" value="{{ old('designation', $vacation->designation) }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300">
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Address During Leave</label>
                            <input type="text" name="address" value="{{ old('address', $vacation->address) }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300">
                        </div>
                    </div>
                </div>

                {{-- Leave Details Section --}}
                <div class="space-y-8">
                    <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">02</span>
                        Leave Specifics
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Leave Type</label>
                            <select name="leave_type_id" class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 appearance-none" required>
                                @foreach ($leaveTypes as $type)
                                    <option value="{{ $type->id }}" @selected($vacation->leave_type_id == $type->id)>{{ $type->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Replacement Employee</label>
                            <select name="replacement_user_id" class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 appearance-none">
                                <option value="">-- No Replacement --</option>
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}" @selected(old('replacement_user_id', $vacation->replacement_user_id) == $emp->id)>
                                        {{ $emp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Start Date</label>
                            <input type="text" id="start_date" name="start_date" value="{{ old('start_date', $vacation->start_date) }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300" required>
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">End Date</label>
                            <input type="text" id="end_date" name="end_date" value="{{ old('end_date', $vacation->end_date) }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300" required>
                        </div>
                    </div>
                </div>

                {{-- Reason & Documents Section --}}
                <div class="space-y-8">
                    <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">03</span>
                        Evidence & Context
                    </h3>

                    <div class="space-y-3">
                        <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Detailed Reason</label>
                        <textarea name="reason" rows="4" class="w-full border-2 border-gray-100 rounded-3xl bg-gray-50 px-5 py-4 text-gray-800 font-medium shadow-inner focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300">{{ old('reason', $vacation->reason) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Supporting Letter (PDF/Image)</label>
                            <div class="relative group">
                                <input type="file" name="letter_pdf" class="hidden" id="letter_pdf">
                                <label for="letter_pdf" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-200 rounded-[2rem] bg-gray-50 cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-300 group">
                                    <i class="bi bi-cloud-arrow-up text-3xl text-gray-300 group-hover:text-indigo-500 transition-colors"></i>
                                    <span class="mt-2 text-sm text-gray-500 font-bold group-hover:text-indigo-600">Click to upload new letter</span>
                                    @if($vacation->letter_pdf)
                                        <span class="mt-1 text-[10px] text-emerald-500 font-black uppercase">Current file exists</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Medical Certificate (Optional)</label>
                            <div class="relative group">
                                <input type="file" name="medical_certificate" class="hidden" id="medical_certificate">
                                <label for="medical_certificate" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-200 rounded-[2rem] bg-gray-50 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-all duration-300 group">
                                    <i class="bi bi-shield-plus text-3xl text-gray-300 group-hover:text-emerald-500 transition-colors"></i>
                                    <span class="mt-2 text-sm text-gray-500 font-bold group-hover:text-emerald-600">Click to upload medical cert</span>
                                    @if($vacation->medical_certificate)
                                        <span class="mt-1 text-[10px] text-emerald-500 font-black uppercase">Current file exists</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t-2 border-gray-50">
                    <a href="{{ route('vacations.index') }}"
                        class="flex items-center gap-3 px-8 py-4 text-gray-500 hover:text-gray-800 font-bold transition-all duration-300">
                        <i class="bi bi-arrow-left text-xl"></i>
                        <span>Discard Changes</span>
                    </a>

                    <button type="submit"
                        class="w-full sm:w-auto items-center justify-center gap-3 px-12 py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-[1.5rem] shadow-2xl shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Update Application</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Flatpickr --}}
    <script>
        const endPicker = flatpickr("#end_date", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            minDate: "{{ $vacation->start_date }}"
        });
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            onChange: function(_, dateStr) {
                endPicker.set("minDate", dateStr);
            }
        });
    </script>
</x-viewer-layout>
