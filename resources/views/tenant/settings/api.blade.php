<x-tenant-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API Developer Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Token Generation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Generate New API Token') }}</h3>
                
                @if (session('token'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                        <p class="text-sm text-green-700 font-bold mb-2">{{ __('Token generated successfully! Please copy it now, as you won\'t be able to see it again.') }}</p>
                        <code class="block p-2 bg-gray-100 rounded text-sm break-all select-all">{{ session('token') }}</code>
                    </div>
                @endif

                <form action="{{ route('tenant.api-tokens.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="token_name" class="block text-sm font-medium text-gray-700">{{ __('Token Name') }}</label>
                            <input type="text" name="token_name" id="token_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="e.g. ERP Integration" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Abilities') }}</label>
                            <div class="space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="abilities[]" value="read:resolutions" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Read Resolutions') }}</span>
                                </label>
                                <label class="inline-flex items-center ms-4">
                                    <input type="checkbox" name="abilities[]" value="write:resolutions" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Write Resolutions') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary/90 focus:bg-primary/90 active:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Generate Token') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Active Tokens List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Active API Tokens') }}</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Abilities') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Last Used') }}</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tokens as $token)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $token->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($token->abilities as $ability)
                                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $ability }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : __('Never') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('tenant.api-tokens.destroy', $token->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to revoke this token?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Revoke') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        {{ __('No active API tokens found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
