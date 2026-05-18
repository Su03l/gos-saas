<x-tenant-layout>
    <div class="max-w-xl mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ __('Conflict of Interest Declaration') }}</h1>
            <p class="text-sm text-gray-600 mb-6">{{ __('Meeting') }}: {{ $meeting->title }}</p>

            <form action="{{ route('coi.store', $meeting) }}" method="POST" x-data="{ hasConflict: false }" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <label class="flex items-center p-4 border rounded-md cursor-pointer hover:bg-gray-50 transition" :class="!hasConflict ? 'border-primary bg-primary/5' : 'border-gray-200'">
                        <input type="radio" name="has_conflict" value="0" x-model="hasConflict" @click="hasConflict = false" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                        <span class="mr-3 font-medium text-gray-900">{{ __('I have no conflict of interest for this meeting.') }}</span>
                    </label>

                    <label class="flex items-center p-4 border rounded-md cursor-pointer hover:bg-gray-50 transition" :class="hasConflict ? 'border-red-500 bg-red-50' : 'border-gray-200'">
                        <input type="radio" name="has_conflict" value="1" x-model="hasConflict" @click="hasConflict = true" class="h-4 w-4 text-red-500 border-gray-300 focus:ring-red-500">
                        <span class="mr-3 font-medium text-gray-900">{{ __('I declare a conflict of interest.') }}</span>
                    </label>
                </div>

                <div x-show="hasConflict" x-cloak class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Please state the reason for the conflict') }}</label>
                    <textarea name="conflict_reason" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" rows="3"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 rounded-md font-bold text-white transition" :class="hasConflict ? 'bg-red-600 hover:bg-red-700' : 'bg-primary hover:bg-primary/90'">
                        {{ __('Submit Declaration') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-tenant-layout>
