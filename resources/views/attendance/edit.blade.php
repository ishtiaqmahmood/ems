<x-viewer-layout>
    <div class="max-w-4xl mx-auto py-12 px-6">

        {{-- Breadcrumb --}}
        <nav class="flex text-gray-500 text-sm mb-8" aria-label="Breadcrumb">
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
                        <a href="{{ route('attendance.index') }}" class="hover:text-sky-600">Attendance</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-400">Edit Record</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-sky-100/50">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-sky-600 to-blue-700 p-10 text-white relative">
                <div class="absolute top-0 right-0 p-10 opacity-10">
                    <i class="bi bi-pencil-square text-8xl"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-sky-100 text-xs font-black uppercase tracking-[0.2em] mb-2">Update Entry</p>
                    <h2 class="text-4xl font-black tracking-tight">Edit Attendance</h2>
                    <p class="text-sky-100/80 mt-2 font-medium">Refine timing and status for this specific log.</p>
                </div>
            </div>

            {{-- Form Container --}}
            <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="p-10 space-y-10">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    {{-- Left Column: Identity & Status --}}
                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="bi bi-person-circle text-sky-500"></i> Employee
                            </label>
                            <select name="user_id"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all duration-300 appearance-none cursor-pointer"
                                required>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" {{ $attendance->user_id == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="bi bi-activity text-sky-500"></i> Attendance Status
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['Present', 'Absent', 'Leave'] as $status)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="status" value="{{ $status }}" class="hidden peer" {{ $attendance->status == $status ? 'checked' : '' }}>
                                        <div class="text-center p-4 rounded-2xl border-2 border-gray-50 bg-gray-50 text-gray-400 font-bold transition-all duration-300 group-hover:bg-gray-100 peer-checked:border-sky-500 peer-checked:bg-sky-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-sky-100">
                                            {{ $status }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Date & Time --}}
                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="bi bi-calendar3 text-sky-500"></i> Date
                            </label>
                            <input type="date" name="date" value="{{ $attendance->date }}"
                                class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all duration-300"
                                required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <label class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center gap-2 text-xs">
                                    <i class="bi bi-box-arrow-in-right text-emerald-500"></i> Check In
                                </label>
                                <input type="time" name="check_in"
                                    value="{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '' }}"
                                    class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all duration-300">
                            </div>
                            <div class="space-y-3">
                                <label class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center gap-2 text-xs">
                                    <i class="bi bi-box-arrow-right text-rose-500"></i> Check Out
                                </label>
                                <input type="time" name="check_out"
                                    value="{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '' }}"
                                    class="w-full border-2 border-gray-100 rounded-2xl bg-gray-50 px-5 py-4 text-gray-800 font-bold shadow-inner focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all duration-300">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t-2 border-gray-50">
                    <a href="{{ route('attendance.index') }}"
                        class="flex items-center gap-3 px-8 py-4 text-gray-500 hover:text-gray-800 font-bold transition-all duration-300">
                        <i class="bi bi-arrow-left text-xl"></i>
                        <span>Discard Changes</span>
                    </a>

                    <div class="flex gap-4 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none items-center justify-center gap-3 px-12 py-4 bg-sky-600 hover:bg-sky-700 text-white font-black rounded-[1.5rem] shadow-2xl shadow-sky-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Update Entry</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
