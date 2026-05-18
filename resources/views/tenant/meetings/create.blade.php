<x-tenant-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Schedule New Meeting') }}</h1>

        <form action="{{ route('meetings.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Committee') }}</label>
                <select name="committee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                    @foreach($committees as $committee)
                        <option value="{{ $committee->id }}">{{ $committee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('Start Date & Time') }}</label>
                    <input type="datetime-local" name="scheduled_start" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('End Date & Time') }}</label>
                    <input type="datetime-local" name="scheduled_end" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Meeting Link') }} ({{ __('Optional') }})</label>
                <input type="url" name="meeting_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary/90 font-bold">
                    {{ __('Save Meeting') }}
                </button>
            </div>
        </form>
    </div>
</x-tenant-layout>
