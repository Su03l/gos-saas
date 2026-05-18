<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-right" dir="rtl">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Two-Factor Authentication') }}</h2>
            <p class="text-sm text-gray-600 mb-6">
                {{ __('To secure your account, please scan the QR code below with your authenticator app and enter the 6-digit code.') }}
            </p>

            <!-- Placeholder for QR Code -->
            <div class="flex justify-center mb-8">
                <div class="p-4 bg-white border-2 border-dashed border-gray-200 rounded-lg flex flex-col items-center">
                    <div class="w-48 h-48 bg-gray-100 rounded flex items-center justify-center mb-2">
                        <svg class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400 font-mono">SECRET_KEY_PLACEHOLDER</span>
                </div>
            </div>

            <form action="{{ route('two-factor.enable') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Authentication Code') }}</label>
                    <input type="text" name="code" required maxlength="6" class="mt-1 block w-full text-center tracking-[1em] text-2xl font-bold rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="000000">
                </div>

                <div class="pt-4 flex flex-col space-y-3">
                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-md font-bold hover:bg-primary/90 transition-colors shadow-md">
                        {{ __('Verify & Enable 2FA') }}
                    </button>
                    <a href="{{ route('tenant.dashboard') }}" class="text-sm text-center text-gray-500 hover:underline">
                        {{ __('Cancel and return to dashboard') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
