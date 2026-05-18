<x-tenant-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('tenant.users.index') }}" class="text-sm text-gray-500 hover:text-primary flex items-center space-x-reverse space-x-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
                <span>{{ __('Back to Users') }}</span>
            </a>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Add New User') }}</h1>

            <form action="{{ route('tenant.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Full Name') }}</label>
                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                    <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Assign Role') }}</label>
                    <select name="roles[]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        @foreach($roles ?? [] as $role)
                            <option value="{{ $role->name }}">{{ str_replace('_', ' ', $role->name) }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-500">{{ __('Each user is assigned a specific role which dictates their permissions across the platform.') }}</p>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-2 rounded-md hover:bg-primary/90 font-bold shadow-md transition-all">
                        {{ __('Create User') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-tenant-layout>
