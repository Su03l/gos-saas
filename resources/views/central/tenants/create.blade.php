<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Create New SaaS Tenant') }}</h1>
            
            <form action="{{ route('central.tenants.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Company Name') }}</label>
                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">{{ __('The official registered name of the client organization.') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Subdomain / Domain') }}</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="domain" required class="block w-full flex-1 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">
                            .governance.test
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Isolated Database Name') }}</label>
                    <input type="text" name="database_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">{{ __('Used for the unique SQLite filename (e.g. client_abc_db.sqlite).') }}</p>
                </div>

                <div class="pt-4 flex items-center justify-end border-t border-gray-100">
                    <a href="{{ route('central.dashboard') }}" class="text-sm font-medium text-gray-600 hover:underline ml-6">{{ __('Cancel') }}</a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 font-bold shadow-md">
                        {{ __('Provision Tenant') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
