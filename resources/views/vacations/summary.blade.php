<x-viewer-layout>
    <div class="max-w-4xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-8 flex items-center gap-2">
            <i class="bi bi-calendar-week text-emerald-600"></i>
            Leave Summary
        </h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Monthly -->
            <div class="bg-white border border-emerald-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-emerald-700">This Month</h3>
                    <i class="bi bi-calendar2-date text-emerald-500 text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-emerald-600">{{ $monthlyTotal }}</p>
                <p class="text-sm text-gray-500 mt-1">days approved</p>
            </div>

            <!-- Yearly -->
            <div class="bg-white border border-emerald-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-emerald-700">This Year</h3>
                    <i class="bi bi-calendar3 text-emerald-500 text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-emerald-600">{{ $yearlyTotal }}</p>
                <p class="text-sm text-gray-500 mt-1">days approved</p>
            </div>

            <!-- All Time -->
            <div class="bg-white border border-emerald-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-emerald-700">All Time</h3>
                    <i class="bi bi-infinity text-emerald-500 text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-emerald-600">{{ $allTimeTotal }}</p>
                <p class="text-sm text-gray-500 mt-1">days approved</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 gap-10">
            <!-- Monthly Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-bar-chart text-emerald-600"></i> Monthly Leave Chart ({{ $year }})
                </h3>
                <canvas id="monthlyLeaveChart" height="120"></canvas>
            </div>

            <!-- Yearly Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-bar-chart text-sky-600"></i> Yearly Leave Chart
                </h3>
                <canvas id="yearlyLeaveChart" height="120"></canvas>
            </div>

            <!-- All Time Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-bar-chart text-orange-600"></i> All Time Leave Chart
                </h3>
                <canvas id="alltimeLeaveChart" height="120"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                // Monthly Chart
                const monthlyCtx = document.getElementById('monthlyLeaveChart').getContext('2d');
                const monthlyData = @json($monthlyData); // array of 12 numbers for the user
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Approved Leave Days',
                            data: monthlyData,
                            backgroundColor: 'rgba(16, 185, 129, 0.6)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                // Yearly Chart
                const yearlyCtx = document.getElementById('yearlyLeaveChart').getContext('2d');
                const yearlyData = @json($yearlyData); // prepare in controller: e.g., [2020=>5,2021=>10,...]
                new Chart(yearlyCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(yearlyData),
                        datasets: [{
                            label: 'Approved Leave Days',
                            data: Object.values(yearlyData),
                            backgroundColor: 'rgba(14, 165, 233, 0.6)',
                            borderColor: 'rgba(14, 165, 233, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                // All Time Chart
                const alltimeCtx = document.getElementById('alltimeLeaveChart').getContext('2d');
                const alltimeData = @json($alltimeData); // prepare in controller if needed
                new Chart(alltimeCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(alltimeData),
                        datasets: [{
                            label: 'Approved Leave Days',
                            data: Object.values(alltimeData),
                            backgroundColor: 'rgba(251, 191, 36, 0.6)',
                            borderColor: 'rgba(251, 191, 36, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-viewer-layout>
