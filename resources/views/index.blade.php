<x-viewer-layout>
    <div class="p-6 space-y-10">

        <h1 class="text-3xl font-extrabold text-gray-900">User Dashboard</h1>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-2xl md:text-3xl font-black mb-8 text-slate-800 flex items-center gap-3">
                <i class="bi bi-calendar-range text-indigo-600"></i> Quick Apply Leave
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Casual Leave --}}
                <a href="{{ route('vacations.casual.create') }}"
                    class="group block bg-gradient-to-br from-indigo-600 to-violet-700 rounded-[2rem] shadow-xl shadow-indigo-100 hover:shadow-2xl hover:shadow-indigo-200 transform hover:-translate-y-2 transition-all duration-500 p-8 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-calendar-event text-[120px]"></i>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-5xl mb-4">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 group-hover:underline">গড় বেতনে অধিত ছুটি</h3>
                        <p class="text-sm text-blue-100 text-center">Apply for your casual leave easily and track it.
                        </p>
                    </div>
                </a>

                {{-- Emergency Leave --}}
                <a href="{{ route('vacations.emergency.create') }}"
                    class="group block bg-gradient-to-br from-red-500 to-red-700 rounded-[2rem] shadow-xl shadow-red-100 hover:shadow-2xl hover:shadow-red-200 transform hover:-translate-y-2 transition-all duration-500 p-6 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-exclamation-triangle text-[120px]"></i>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-5xl mb-4">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 group-hover:underline">নৈমিত্তিক ছুটি</h3>
                        <p class="text-sm text-red-100 text-center">Request emergency leave quickly when needed.</p>
                    </div>
                </a>

                {{-- Leave Without Pay --}}
                <a href="{{ route('vacations.leave_without_pay.create') }}"
                    class="group block bg-gradient-to-br from-amber-500 to-orange-600 rounded-[2rem] shadow-xl shadow-amber-100 hover:shadow-2xl hover:shadow-amber-200 transform hover:-translate-y-2 transition-all duration-500 p-6 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-wallet2 text-[120px]"></i>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-5xl mb-4">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 group-hover:underline">বিনা বেতন ছুটি</h3>
                        <p class="text-sm text-amber-100 text-center">Apply for unpaid leave while keeping your
                            workflow intact.</p>
                    </div>
                </a>

                {{-- Disability Leave --}}
                <a href="{{ route('vacations.disability.create') }}"
                    class="group block bg-gradient-to-br from-purple-500 to-purple-700 rounded-[2rem] shadow-xl shadow-purple-100 hover:shadow-2xl hover:shadow-purple-200 transform hover:-translate-y-2 transition-all duration-500 p-6 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-person-wheelchair text-[120px]"></i>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-5xl mb-4">
                            <i class="fas fa-wheelchair"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 group-hover:underline">অক্ষমতা-জনিত ছুটি</h3>
                        <p class="text-sm text-purple-100 text-center">Submit leave requests related to disability
                            easily.</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Applied</p>
                <h2 class="text-4xl font-black text-slate-900">{{ $totalApplied }}</h2>
            </div>

            <div class="bg-emerald-50/50 p-8 rounded-[2rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-emerald-200/50 transition-all duration-300">
                <p class="text-xs font-black text-emerald-600/60 uppercase tracking-widest mb-2">Approved</p>
                <h2 class="text-4xl font-black text-emerald-700">{{ $approved }}</h2>
            </div>

            <div class="bg-amber-50/50 p-8 rounded-[2rem] shadow-sm border border-amber-100 hover:shadow-xl hover:shadow-amber-200/50 transition-all duration-300">
                <p class="text-xs font-black text-amber-600/60 uppercase tracking-widest mb-2">Pending</p>
                <h2 class="text-4xl font-black text-amber-700">{{ $pending }}</h2>
            </div>

            <div class="bg-rose-50/50 p-8 rounded-[2rem] shadow-sm border border-rose-100 hover:shadow-xl hover:shadow-rose-200/50 transition-all duration-300">
                <p class="text-xs font-black text-rose-600/60 uppercase tracking-widest mb-2">Rejected</p>
                <h2 class="text-4xl font-black text-rose-700">{{ $rejected }}</h2>
            </div>

        </div>

        <!-- Graph Section -->
        <div class="bg-white p-8 rounded-xl shadow border">
            <h2 class="text-2xl font-bold mb-4">Vacation Trend (Last 6 Months)</h2>

            <div class="relative h-[300px] sm:h-[400px]">
                <canvas id="vacationChart"></canvas>
            </div>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('vacationChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Leaves Applied',
                    data: @json($monthlyLeaves),
                    borderWidth: 3,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#0284c7',
                    pointRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-viewer-layout>
