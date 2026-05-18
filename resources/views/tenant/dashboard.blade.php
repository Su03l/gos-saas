<x-tenant-layout>
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.welcome_back') }}, {{ auth()->user()->name }}</h1>
            <div class="text-sm text-gray-500 font-medium">
                {{ now()->format('Y-m-d') }}
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 transition-hover hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('messages.upcoming_meetings') }}</h2>
                    <span class="bg-primary/10 text-primary p-2 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $generalStats['upcoming_meetings'] ?? 0 }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 transition-hover hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('messages.pending_votes') }}</h2>
                    <span class="bg-yellow-50 text-yellow-600 p-2 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $generalStats['active_resolutions'] ?? 0 }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 transition-hover hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('messages.my_tasks') }}</h2>
                    <span class="bg-green-50 text-green-600 p-2 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </span>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $taskStats['pending'] + $taskStats['in_progress'] ?? 0 }}</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Task Completion Overview') }}</h3>
                <div class="relative h-64">
                    <canvas id="taskCompletionChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-center">
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Performance Metrics') }}</h3>
                    <div class="space-y-3">
                        @php
                            $totalTasks = array_sum($taskStats ?? []);
                            $completionRate = $totalTasks > 0 ? round(($taskStats['closed'] / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-600">{{ __('Overall SLA Compliance') }}</span>
                            <span class="font-bold text-primary">{{ $completionRate }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="bg-primary h-2.5 rounded-full" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('taskCompletionChart').getContext('2d');
            const data = {
                labels: [
                    '{{ __("messages.pending") }}', 
                    '{{ __("messages.in_progress") }}', 
                    '{{ __("messages.evidence_submitted") }}', 
                    '{{ __("messages.closed") }}', 
                    '{{ __("messages.escalated") }}'
                ],
                datasets: [{
                    data: [
                        {{ $taskStats['pending'] ?? 0 }},
                        {{ $taskStats['in_progress'] ?? 0 }},
                        {{ $taskStats['evidence_submitted'] ?? 0 }},
                        {{ $taskStats['closed'] ?? 0 }},
                        {{ $taskStats['escalated'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#e5e7eb', // gray-200
                        '#fbbf24', // yellow-400
                        '#60a5fa', // blue-400
                        '#10b981', // green-500
                        '#ef4444'  // red-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: true,
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    family: 'Instrument Sans',
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-tenant-layout>
