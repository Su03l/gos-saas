<x-tenant-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Resolutions') }}</h1>
            <a href="{{ route('resolutions.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-darker focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Create Resolution') }}
            </a>
        </div>

        <!-- Advanced Filtering Bar -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <form action="{{ route('resolutions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label for="start_date" class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                        class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                
                <div>
                    <label for="end_date" class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                        class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('Status') }}</label>
                    <select name="status" id="status" 
                        class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        <option value="voting" {{ request('status') === 'voting' ? 'selected' : '' }}>{{ __('Voting') }}</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                    </select>
                </div>

                <div class="flex items-center mb-3">
                    <input type="checkbox" name="my_votes" id="my_votes" value="1" {{ request('my_votes') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <label for="my_votes" class="mr-2 text-sm text-gray-600">{{ __('My Votes Only') }}</label>
                </div>

                <div class="flex space-x-2 space-x-reverse">
                    <button type="submit" class="flex-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Filter') }}
                    </button>
                    <a href="{{ route('resolutions.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Resolution') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Committee') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($resolutions as $resolution)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $resolution->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $resolution->committee->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full 
                                    {{ $resolution->state === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($resolution->state === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ strtoupper($resolution->state) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $resolution->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                <a href="{{ route('resolutions.show', $resolution) }}" class="text-primary hover:text-primary-dark">{{ __('View') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                {{ __('No resolutions found matching your criteria.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($resolutions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $resolutions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-tenant-layout>
