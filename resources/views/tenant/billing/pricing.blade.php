<x-tenant-layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                {{ __('Upgrade Your Portal') }}
            </h2>
            <p class="mt-4 text-xl text-gray-600">
                {{ __('Choose the plan that best fits your organization\'s governance needs.') }}
            </p>
        </div>

        <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0">
            <!-- Starter Plan -->
            <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 leading-6">{{ __('Starter') }}</h2>
                    <p class="mt-4 text-sm text-gray-500">{{ __('Perfect for small committees.') }}</p>
                    <p class="mt-8">
                        <span class="text-4xl font-extrabold text-gray-900">$99</span>
                        <span class="text-base font-medium text-gray-500">/{{ __('mo') }}</span>
                    </p>
                    <form action="{{ route('central.billing.checkout', ['plan' => 'starter']) }}" method="POST" class="mt-8">
                        @csrf
                        <button type="submit" class="block w-full bg-primary border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-primary/90">
                            {{ __('Subscribe to Starter') }}
                        </button>
                    </form>
                </div>
                <div class="pt-6 pb-8 px-6">
                    <h3 class="text-xs font-medium text-gray-900 uppercase tracking-wide">{{ __('What\'s included') }}</h3>
                    <ul class="mt-6 space-y-4">
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('Up to 10 Users') }}</span>
                        </li>
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('1GB Secure Storage') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Pro Plan -->
            <div class="border-2 border-primary rounded-lg shadow-sm divide-y divide-gray-200 bg-white relative">
                <div class="absolute top-0 right-1/2 transform translate-x-1/2 -translate-y-1/2 bg-primary text-white px-4 py-1 rounded-full text-xs font-bold uppercase">
                    {{ __('Most Popular') }}
                </div>
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 leading-6">{{ __('Professional') }}</h2>
                    <p class="mt-4 text-sm text-gray-500">{{ __('For growing boards with active meetings.') }}</p>
                    <p class="mt-8">
                        <span class="text-4xl font-extrabold text-gray-900">$299</span>
                        <span class="text-base font-medium text-gray-500">/{{ __('mo') }}</span>
                    </p>
                    <form action="{{ route('central.billing.checkout', ['plan' => 'pro']) }}" method="POST" class="mt-8">
                        @csrf
                        <button type="submit" class="block w-full bg-primary border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-primary/90 shadow-lg transition-all transform hover:scale-[1.02]">
                            {{ __('Upgrade to Pro') }}
                        </button>
                    </form>
                </div>
                <div class="pt-6 pb-8 px-6">
                    <h3 class="text-xs font-medium text-gray-900 uppercase tracking-wide">{{ __('What\'s included') }}</h3>
                    <ul class="mt-6 space-y-4">
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('Up to 50 Users') }}</span>
                        </li>
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('10GB Secure Storage') }}</span>
                        </li>
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('VDR Document Watermarking') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 leading-6">{{ __('Enterprise') }}</h2>
                    <p class="mt-4 text-sm text-gray-500">{{ __('Complete control for large enterprises.') }}</p>
                    <p class="mt-8">
                        <span class="text-4xl font-extrabold text-gray-900">$999</span>
                        <span class="text-base font-medium text-gray-500">/{{ __('mo') }}</span>
                    </p>
                    <form action="{{ route('central.billing.checkout', ['plan' => 'enterprise']) }}" method="POST" class="mt-8">
                        @csrf
                        <button type="submit" class="block w-full bg-indigo-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-indigo-700">
                            {{ __('Contact Sales') }}
                        </button>
                    </form>
                </div>
                <div class="pt-6 pb-8 px-6">
                    <h3 class="text-xs font-medium text-gray-900 uppercase tracking-wide">{{ __('What\'s included') }}</h3>
                    <ul class="mt-6 space-y-4">
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('Unlimited Users') }}</span>
                        </li>
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('Unlimited Storage') }}</span>
                        </li>
                        <li class="flex space-x-reverse space-x-3">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-500">{{ __('White-labeling') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
