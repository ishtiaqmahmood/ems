<x-admin-layout>

    <div class="p-6 space-y-10">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h1 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3">
                <i class="bi bi-speedometer2 text-sky-600"></i>
                Admin Dashboard
            </h1>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $stats = [
                    ['name' => 'Total Employees', 'value' => $employers, 'icon' => 'bi-people-fill', 'color' => 'indigo'],
                    [
                        'name' => 'Departments',
                        'value' => $departments,
                        'icon' => 'bi-diagram-3-fill',
                        'color' => 'violet',
                    ],
                    ['name' => 'Sections', 'value' => $sections, 'icon' => 'bi-grid-1x2-fill', 'color' => 'emerald'],
                    [
                        'name' => 'Organizations',
                        'value' => $organizations,
                        'icon' => 'bi-building-fill',
                        'color' => 'amber'],
                    ['name' => 'Salary Records', 'value' => $salaries, 'icon' => 'bi-cash-stack', 'color' => 'sky'],
                    [
                        'name' => 'Documents',
                        'value' => $documents,
                        'icon' => 'bi-file-earmark-text-fill',
                        'color' => 'rose',
                    ],
                ];
            @endphp

            @foreach ($stats as $item)
                <div
                    class="group bg-white shadow-xl shadow-slate-200/50 border border-slate-100 rounded-[2rem] p-8
                    hover:shadow-2xl hover:shadow-slate-300 transition-all duration-500 hover:-translate-y-1">
                    <div class="flex items-center gap-6">
                        <div
                            class="w-16 h-16 flex items-center justify-center rounded-2xl bg-{{ $item['color'] }}-50 text-{{ $item['color'] }}-600
                            group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                            <i class="bi {{ $item['icon'] }} text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">{{ $item['name'] }}</p>
                            <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ $item['value'] }}</h2>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- Employer Growth -->
            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6 hover:shadow-2xl transition-all">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-800">
                    <i class="bi bi-graph-up text-sky-600"></i> Employer Growth (12 Months)
                </h2>
                <canvas id="growthChart" height="140"></canvas>
            </div>

            <!-- Department-wise Employees -->
            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6 hover:shadow-2xl transition-all">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-800">
                    <i class="bi bi-diagram-3-fill text-purple-600"></i> Department-wise Employees
                </h2>
                <canvas id="deptChart" height="140"></canvas>
            </div>

            <!-- Section-wise Employees (Doughnut) -->
            <div
                class="lg:col-span-2 bg-white shadow-xl rounded-2xl border border-gray-100 p-6 hover:shadow-2xl transition-all min-h-[420px]">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-800">
                    <i class="bi bi-grid-1x2 text-green-600"></i> Section-wise Employees
                </h2>
                <div class="w-full h-[380px] flex justify-center items-center">
                    <canvas id="sectionChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Prepare PHP data arrays
        const growthLabels = @json($monthlyGrowth->pluck('month')->toArray());
        const growthData = @json($monthlyGrowth->pluck('total')->toArray());

        const deptLabels = @json($deptStats->pluck('name')->toArray());
        const deptData = @json($deptStats->pluck('employees_count')->toArray());

        const sectionLabels = @json($sectionStats->pluck('name')->toArray());
        const sectionData = @json($sectionStats->pluck('employees_count')->toArray());

        // Employer Growth (Line)
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'New Employers',
                    data: growthData,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14,165,233,0.25)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });

        // Department-wise Employees (Bar)
        new Chart(document.getElementById('deptChart'), {
            type: 'bar',
            data: {
                labels: deptLabels,
                datasets: [{
                    label: 'Employees',
                    data: deptData,
                    backgroundColor: ['#6366f1', '#0ea5e9', '#10b981', '#f97316', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Employees'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Departments'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });

        // Section-wise Employees (Doughnut)
        const sectionColors = [
            "#0ea5e9", "#6366f1", "#10b981", "#f59e0b",
            "#ef4444", "#14b8a6", "#a855f7", "#ec4899"
        ];
        new Chart(document.getElementById('sectionChart'), {
            type: 'doughnut',
            data: {
                labels: sectionLabels,
                datasets: [{
                    data: sectionData,
                    backgroundColor: sectionData.map((_, i) => sectionColors[i % sectionColors.length]),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>

</x-admin-layout>
