<x-tenant-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Browser Sessions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Browser Sessions') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Manage and log out your active sessions on other browsers and devices.') }}
                            </p>
                        </header>

                        @if (count($sessions) > 0)
                            <div class="mt-5 space-y-6">
                                <!-- Other Browser Sessions -->
                                @foreach ($sessions as $session)
                                    <div class="flex items-center">
                                        <div>
                                            @if ($session->agent->isDesktop())
                                                <svg class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>

                                        <div class="ms-3">
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                                            </div>

                                            <div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $session->ip_address }},

                                                    @if ($session->is_current_device)
                                                        <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                                    @else
                                                        {{ __('Last active') }} {{ $session->last_active }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center mt-5">
                            <form method="POST" action="{{ route('tenant.sessions.destroy') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('Log Out Other Browser Sessions') }}
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
