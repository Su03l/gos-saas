<x-tenant-layout>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <h1 class="text-xl font-bold text-gray-900">{{ __('Company Branding Settings') }}</h1>
                <p class="text-sm text-gray-600">{{ __('Customize the appearance of your organization\'s portal.') }}</p>
            </div>

            <form action="{{ route('tenant.settings.branding.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PATCH')

                <!-- Logo Upload -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">{{ __('Organization Logo') }}</label>
                        <p class="text-xs text-gray-500">{{ __('Recommended: PNG or SVG with transparent background.') }}</p>
                    </div>
                    <div class="md:col-span-2 space-y-4">
                        @if(session('tenant')?->logo_path)
                            <div class="h-20 w-auto p-2 border border-gray-100 rounded-md bg-gray-50 inline-block">
                                <img src="{{ asset(session('tenant')->logo_path) }}" alt="Current Logo" class="h-full w-auto">
                            </div>
                        @endif
                        <input type="file" name="logo" class="block w-full text-sm text-gray-500 file:ml-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Primary Color -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">{{ __('Primary Brand Color') }}</label>
                        <p class="text-xs text-gray-500">{{ __('Used for buttons, headers, and active states.') }}</p>
                    </div>
                    <div class="md:col-span-2 flex items-center space-x-reverse space-x-4">
                        <input type="color" name="primary_color" value="{{ session('tenant')->primary_color ?? '#1e3a8a' }}" class="h-10 w-20 p-1 rounded-md border-gray-300">
                        <span class="text-sm font-mono text-gray-600 uppercase">{{ session('tenant')->primary_color ?? '#1e3a8a' }}</span>
                    </div>
                </div>

                <!-- Secondary Color -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">{{ __('Secondary Color') }}</label>
                        <p class="text-xs text-gray-500">{{ __('Used for background accents and secondary UI elements.') }}</p>
                    </div>
                    <div class="md:col-span-2 flex items-center space-x-reverse space-x-4">
                        <input type="color" name="secondary_color" value="{{ session('tenant')->secondary_color ?? '#ffffff' }}" class="h-10 w-20 p-1 rounded-md border-gray-300">
                        <span class="text-sm font-mono text-gray-600 uppercase">{{ session('tenant')->secondary_color ?? '#ffffff' }}</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-md hover:bg-primary/90 font-bold transition-all shadow-lg">
                        {{ __('Save Branding Settings') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Live Preview Stub -->
        <div class="mt-8 p-6 bg-white rounded-lg border border-dashed border-gray-300">
            <h3 class="text-xs font-bold text-gray-400 uppercase mb-4">{{ __('Live Preview') }}</h3>
            <div class="flex items-center space-x-reverse space-x-4">
                <button class="bg-primary text-white px-4 py-2 rounded-md text-sm font-bold">Primary Button</button>
                <div class="h-10 w-10 rounded-full bg-secondary border border-gray-200"></div>
                <span class="text-primary font-bold">Link Color</span>
            </div>
        </div>
    </div>
</x-tenant-layout>
