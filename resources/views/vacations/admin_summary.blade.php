<x-viewer-layout>
    <div class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-8 flex items-center gap-2">
            <i class="bi bi-bar-chart-line text-sky-600"></i>
            Leave Summary (Admin/HR)
        </h2>

        <!-- Filters -->
        <form method="GET" action="{{ route('vacations.adminSummary') }}" class="flex flex-wrap items-end gap-4 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Select Year</label>
                <select name="year" class="border-gray-300 rounded-xl w-40">
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Select Month</label>
                <select name="month" class="border-gray-300 rounded-xl w-40">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="px-5 py-2.5 bg-sky-600 text-white rounded-2xl shadow hover:bg-sky-700 transition">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </form>

        <!-- Overall Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white border border-sky-100 rounded-2xl p-6 shadow hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-sky-700">This Month</h3>
                    <i class="bi bi-calendar2-date text-sky-500 text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-sky-600">{{ $overall['monthly'] }}</p>
                <p class="text-sm text-gray-500 mt-1">days total</p>
            </div>

            <div class="bg-white border border-sky-100 rounded-2xl p-6 shadow hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-sky-700">This Year</h3>
                    <i class="bi bi-calendar3 text-sky-500 text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-sky-600">{{ $overall['yearly'] }}</p>
                <p class="text-sm text-gray-500 mt-1">days total</p>
            </div>

            <div class="bg-white border border-sky-100 rounded-2xl p-6 shadow hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-sky-700">All Time</h3>
                    <i class="bi bi-infinity text-sky-500 text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-sky-600">{{ $overall['all_time'] }}</p>
                <p class="text-sm text-gray-500 mt-1">days total</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-bar-chart text-sky-600"></i> Monthly Leave Chart ({{ $year }})
                </h3>
            </div>

            <canvas id="leaveChart" height="120"></canvas>
        </div>

        <!-- Employee Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <table class="min-w-full border-collapse">
                <thead class="bg-sky-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Employee</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">This Month</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">This Year</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">All Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                        <tr class="border-t hover:bg-sky-50 transition">
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $emp['name'] }}</td>
                            <td class="py-3 px-4">{{ $emp['monthly'] }}</td>
                            <td class="py-3 px-4">{{ $emp['yearly'] }}</td>
                            <td class="py-3 px-4">{{ $emp['all_time'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 text-center text-gray-500">No data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('leaveChart').getContext('2d');

            const labels = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];

            // Chart.js expects datasets in proper format
            const datasets = @json($monthlyData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#374151'
                            },
                            grid: {
                                color: '#e5e7eb'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#374151'
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#374151',
                                boxWidth: 20
                            }
                        }
                    }
                }
            });
        </script>
    @endpush

</x-viewer-layout>
