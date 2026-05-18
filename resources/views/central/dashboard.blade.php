<x-app-layout>
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Central Administration Dashboard') }}</h1>
            <div class="text-sm text-gray-500 font-medium">{{ now()->format('Y-m-d') }}</div>
        </div>

        <!-- Global Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('Total Tenants') }}</h2>
                    <span class="bg-indigo-50 text-indigo-600 p-2 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </span>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $tenantCount ?? 0 }}</p>
                <div class="mt-2 flex items-center text-xs text-green-600 font-bold">
                    <svg class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    <span>{{ __('2 new this month') }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('Total System Users') }}</h2>
                    <span class="bg-blue-50 text-blue-600 p-2 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </span>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $userCount ?? 0 }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('Platform Status') }}</h2>
                    <span class="bg-green-50 text-green-600 p-2 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944V21m0-18.056L3.382 7.016m17.236 0L12 2.944M12 21c4.474 0 8.068-3.132 8.068-7h-16.136c0 3.868 3.594 7 8.068 7z"/></svg>
                    </span>
                </div>
                <p class="text-lg font-bold text-green-600 uppercase tracking-widest">{{ __('Healthy') }}</p>
                <p class="mt-1 text-xs text-gray-400 italic">{{ __('All node systems active') }}</p>
            </div>
        </div>

        <!-- Recent Tenant Registrations -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">{{ __('Recent Tenant Registrations') }}</h3>
                <a href="{{ route('central.tenants.create') }}" class="text-xs font-bold text-indigo-600 hover:underline">{{ __('View All Tenants') }}</a>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Company') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Domain') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Created At') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentTenants ?? [] as $tenant)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $tenant->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $tenant->domain }}.governance.test</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 uppercase">
                                    {{ $tenant->subscription_status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                                {{ __('No recent registrations found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
