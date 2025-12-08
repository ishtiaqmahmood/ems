<x-viewer-layout>
    <div class="p-6 space-y-10">

        <h1 class="text-3xl font-extrabold text-gray-900">User Dashboard</h1>

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
