<x-auth-layout>
    <x-slot:title>Welcome Back | EMS Pro</x-slot:title>

    {{-- Animated Background Elements --}}
    <div class="absolute top-0 -left-40 w-96 h-96 bg-sky-600/20 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-0 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] animate-pulse delay-700"></div>

    <div class="w-full max-w-[1100px] flex rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10 border border-white/5">

        {{-- Left Side: Branding/Visual --}}
        <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-sky-600 via-indigo-700 to-violet-800 p-16 flex-col justify-between relative">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <div class="relative z-10">
                <h2 class="text-5xl font-black text-white leading-tight">Master your workforce <br><span class="text-sky-300">with precision.</span></h2>
                <p class="text-sky-100/70 mt-8 text-lg font-medium leading-relaxed max-w-sm">The all-in-one management suite designed for modern enterprises that demand speed and elegance.</p>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full bg-sky-400 border-2 border-indigo-600"></div>
                        <div class="w-10 h-10 rounded-full bg-indigo-400 border-2 border-indigo-600"></div>
                        <div class="w-10 h-10 rounded-full bg-violet-400 border-2 border-indigo-600"></div>
                    </div>
                    <p class="text-white text-xs font-bold uppercase tracking-widest">Trusted by 500+ global teams</p>
                </div>
            </div>
        </div>

        {{-- Right Side: Login Form --}}
        <div class="flex-1 bg-white p-10 sm:p-20 flex flex-col justify-center">
            <div class="mb-12 text-center lg:text-left">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Welcome Back</h1>
                <p class="text-slate-500 mt-2 font-medium">Please enter your credentials to access your portal.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-100 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-rose-600 text-sm font-bold flex items-center gap-2">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <div class="relative group">
                        <i class="bi bi-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-sky-500 transition-colors"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com"
                            class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:border-sky-500 transition-all outline-none">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Password</label>
                        <a href="/forgot-password" class="text-xs font-bold text-sky-600 hover:text-sky-700 transition-colors">Forgot?</a>
                    </div>
                    <div class="relative group">
                        <i class="bi bi-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-sky-500 transition-colors"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:border-sky-500 transition-all outline-none">
                    </div>
                </div>

                <div class="flex items-center gap-3 ml-1 pt-2">
                    <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-lg border-2 border-slate-100 text-sky-600 focus:ring-sky-500 transition-all cursor-pointer">
                    <label for="remember" class="text-sm font-bold text-slate-500 cursor-pointer">Remember this session</label>
                </div>

                <button type="submit"
                    class="w-full py-5 bg-sky-600 hover:bg-sky-700 text-white font-black rounded-2xl shadow-2xl shadow-sky-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                    <span>Sign In</span>
                    <i class="bi bi-arrow-right text-lg"></i>
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-slate-500 font-bold text-sm">
                    New here?
                    <a href="/register" class="text-sky-600 hover:text-sky-700 transition-all underline decoration-2 underline-offset-4">Create your account</a>
                </p>
            </div>
        </div>
    </div>
</x-auth-layout>
