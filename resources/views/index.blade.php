<x-viewer-layout>
    <div class="p-6 space-y-10">

        <h1 class="text-3xl font-extrabold text-gray-900">User Dashboard</h1>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center">Leave Types</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Casual Leave --}}
                <a href="{{ route('vacations.casual.create') }}"
                    class="group block bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6 text-white">
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
                    class="group block bg-gradient-to-br from-red-500 to-red-700 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6 text-white">
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
                    class="group block bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6 text-white">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-5xl mb-4">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 group-hover:underline">বিনা বেতন ছুটি</h3>
                        <p class="text-sm text-yellow-100 text-center">Apply for unpaid leave while keeping your
                            workflow intact.</p>
                    </div>
                </a>

                {{-- Disability Leave --}}
                <a href="{{ route('vacations.disability.create') }}"
                    class="group block bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6 text-white">
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-xl shadow border">
                <p class="text-sm text-gray-500">Total Apply</p>
                <h2 class="text-3xl font-bold text-gray-900">{{ $totalApplied }}</h2>
            </div>

            <div class="bg-green-50 p-6 rounded-xl shadow border border-green-200">
                <p class="text-sm text-gray-500">Approved</p>
                <h2 class="text-3xl font-bold text-green-700">{{ $approved }}</h2>
            </div>

            <div class="bg-yellow-50 p-6 rounded-xl shadow border border-yellow-200">
                <p class="text-sm text-gray-500">Pending</p>
                <h2 class="text-3xl font-bold text-yellow-700">{{ $pending }}</h2>
            </div>

            <div class="bg-red-50 p-6 rounded-xl shadow border border-red-200">
                <p class="text-sm text-gray-500">Rejected</p>
                <h2 class="text-3xl font-bold text-red-700">{{ $rejected }}</h2>
            </div>

        </div>

        <!-- Graph Section -->
        <div class="bg-white p-8 rounded-xl shadow border">
            <h2 class="text-2xl font-bold mb-4">Vacation Trend (Last 6 Months)</h2>

            <canvas id="vacationChart" height="100"></canvas>
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
