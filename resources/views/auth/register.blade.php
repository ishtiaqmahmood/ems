<x-auth-layout>
    <x-slot:title>Create Your Account | EMS Pro</x-slot:title>

    {{-- Animated Background Elements --}}
    <div class="absolute top-0 -right-40 w-96 h-96 bg-violet-600/20 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-0 -left-40 w-96 h-96 bg-emerald-600/20 rounded-full blur-[100px] animate-pulse delay-700"></div>

    <div class="w-full max-w-[1100px] flex rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10 border border-white/5">

        {{-- Left Side: Branding/Visual --}}
        <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-violet-600 via-indigo-700 to-sky-800 p-16 flex-col justify-between relative">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <div class="relative z-10">
                <h2 class="text-5xl font-black text-white leading-tight">Begin your <br><span class="text-sky-300">professional journey.</span></h2>
                <p class="text-sky-100/70 mt-8 text-lg font-medium leading-relaxed max-w-sm">Join the enterprise standard for workforce management and unlock your team's full potential.</p>
            </div>

            <div class="relative z-10 space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Advanced Analytics Dashboard</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Smart Attendance Tracking</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Automated Leave Management</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Register Form --}}
        <div class="flex-1 bg-white p-10 sm:p-20 flex flex-col justify-center">
            <div class="mb-12 text-center lg:text-left">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Create Account</h1>
                <p class="text-slate-500 mt-2 font-medium">Please fill in your details to get started.</p>
            </div>

            <form action="/register" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <div class="relative group">
                        <i class="bi bi-person absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-violet-500 transition-colors"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                            class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:border-violet-500 transition-all outline-none">
                    </div>
                    @error('name') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <div class="relative group">
                        <i class="bi bi-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-violet-500 transition-colors"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@company.com"
                            class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:border-violet-500 transition-all outline-none">
                    </div>
                    @error('email') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                        <div class="relative group">
                            <i class="bi bi-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-violet-500 transition-colors"></i>
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:border-violet-500 transition-all outline-none">
                        </div>
                        @error('password') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Confirm</label>
                        <div class="relative group">
                            <i class="bi bi-shield-check absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-violet-500 transition-colors"></i>
                            <input type="password" name="password_confirmation" required placeholder="••••••••"
                                class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:border-violet-500 transition-all outline-none">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-5 bg-violet-600 hover:bg-violet-700 text-white font-black rounded-2xl shadow-2xl shadow-violet-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 mt-4">
                    <span>Create Account</span>
                    <i class="bi bi-arrow-right text-lg"></i>
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-slate-500 font-bold text-sm">
                    Already have an account?
                    <a href="/login" class="text-violet-600 hover:text-violet-700 transition-all underline decoration-2 underline-offset-4">Log in instead</a>
                </p>
            </div>
        </div>
    </div>
</x-auth-layout>
