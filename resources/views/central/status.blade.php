<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Status | Governance SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased font-sans">
    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="h-10 w-10 bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <span class="text-2xl font-bold">Governance SaaS Status</span>
            </div>
            <a href="/" class="text-sm font-semibold text-blue-900 hover:underline">Back to Main Site</a>
        </div>

        <!-- Overall Status -->
        <div class="bg-green-500 text-white p-8 rounded-2xl shadow-lg mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">All Systems Operational</h1>
                <p class="opacity-90">Last checked: {{ now()->format('H:i') }} UTC</p>
            </div>
            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>

        <!-- System Breakdown -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-12 overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h2 class="font-bold text-gray-700">Services Status</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($systems as $system)
                    <div class="p-6 flex items-center justify-between">
                        <span class="font-medium">{{ $system['name'] }}</span>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="text-sm font-bold text-green-600">Operational</span>
                            <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Uptime Chart Mock -->
        <div class="mb-12">
            <h3 class="font-bold text-gray-700 mb-4 px-2">Uptime (Last 90 Days)</h3>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex gap-1 h-12">
                    @for($i=0; $i<90; $i++)
                        <div class="flex-1 bg-green-400 rounded-sm opacity-{{ rand(60, 100) }} hover:bg-green-600 transition-colors cursor-help" title="99.9% Uptime"></div>
                    @endfor
                </div>
                <div class="flex justify-between mt-4 text-xs font-bold text-gray-400 uppercase tracking-widest">
                    <span>90 Days Ago</span>
                    <span>100% Uptime</span>
                    <span>Today</span>
                </div>
            </div>
        </div>

        <!-- Incident History -->
        <div>
            <h3 class="font-bold text-gray-700 mb-6 px-2">Incident History</h3>
            <div class="space-y-6">
                @foreach($incidents as $incident)
                    <div class="relative pl-8 pb-6 border-r-2 border-gray-100 last:border-0 mr-4">
                        <div class="absolute -right-1.5 top-0 h-3 w-3 rounded-full bg-gray-300 ring-4 ring-gray-50"></div>
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-bold text-gray-900">{{ $incident['title'] }}</h4>
                                <span class="text-xs font-bold uppercase py-1 px-2 bg-gray-100 rounded text-gray-500">{{ $incident['status'] }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mb-4">{{ $incident['date'] }}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $incident['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <footer class="mt-20 text-center border-t border-gray-100 pt-8">
            <p class="text-sm text-gray-400">Powered by Governance SaaS Health Monitor</p>
        </footer>
    </div>
</body>
</html>
