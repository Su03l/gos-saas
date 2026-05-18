<x-tenant-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Immutable Audit Trail') }}</h1>
            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest border border-gray-200">
                {{ __('Read-Only') }}
            </span>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-right" dir="rtl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Timestamp') }}</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('User') }}</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('IP Address') }}</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Payload') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                {{ $activity->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $activity->causer?->name ?? __('System') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                {{ $activity->properties['ip'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-bold rounded-md bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ strtoupper($activity->description) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ json_encode($activity->properties) }}">
                                <code class="text-xs bg-gray-50 p-1 rounded">{{ json_encode($activity->properties['attributes'] ?? []) }}</code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 italic">
                                {{ __('No activity logs recorded yet.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $activities->links() }}
        </div>

        <div class="p-4 bg-yellow-50 border border-yellow-100 rounded-md">
            <p class="text-xs text-yellow-700 leading-relaxed">
                <strong>{{ __('Note') }}:</strong> {{ __('This audit trail is immutable and cryptographically secured. Logs cannot be modified or deleted by any user, including administrators.') }}
            </p>
        </div>
    </div>
</x-tenant-layout>
