<x-tenant-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Resolution Header -->
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex text-sm text-gray-500 mb-2 space-x-reverse space-x-2">
                    <a href="{{ route('resolutions.index') }}" class="hover:text-primary">{{ __('Resolutions') }}</a>
                    <span>/</span>
                    <span>{{ __('Resolution Details') }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">{{ $resolution->title }}</h1>
            </div>
            <span class="px-3 py-1 text-sm font-bold rounded-full 
                {{ $resolution->state === 'approved' ? 'bg-green-100 text-green-700' : 
                   ($resolution->state === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }} uppercase">
                {{ str_replace('_', ' ', $resolution->state) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">{{ __('Legally Binding Text') }}</h2>
                    <div class="prose prose-sm max-w-none text-gray-800 bg-gray-50 p-6 rounded-md border border-gray-100">
                        {!! nl2br(e($resolution->legally_binding_text)) !!}
                    </div>
                </div>

                <!-- Voting Section -->
                @if($resolution->state === 'voting')
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-lg font-bold text-gray-700 mb-6 text-center">{{ __('Cast Your Vote') }}</h2>
                        
                        <form action="{{ route('resolutions.vote', $resolution) }}" method="POST" class="grid grid-cols-3 gap-4">
                            @csrf
                            <button type="submit" name="vote" value="approve" 
                                class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all group">
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mb-3 group-hover:bg-green-200">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="font-bold text-gray-900">{{ __('Approve') }}</span>
                            </button>

                            <button type="submit" name="vote" value="reject" 
                                class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-red-500 hover:bg-red-50 transition-all group">
                                <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center mb-3 group-hover:bg-red-200">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <span class="font-bold text-gray-900">{{ __('Reject') }}</span>
                            </button>

                            <button type="submit" name="vote" value="abstain" 
                                class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-gray-500 hover:bg-gray-50 transition-all group">
                                <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mb-3 group-hover:bg-gray-200">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </div>
                                <span class="font-bold text-gray-900">{{ __('Abstain') }}</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
                    <h2 class="text-lg font-bold text-gray-700">{{ __('Resolution Info') }}</h2>
                    
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">{{ __('Committee') }}</p>
                        <p class="font-medium">{{ $resolution->committee->name }}</p>
                    </div>

                    @if($resolution->is_circular)
                        <div class="p-3 bg-blue-50 text-blue-700 rounded-md text-xs font-bold uppercase text-center">
                            {{ __('Circular Resolution') }}
                        </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">{{ __('Voting Deadline') }}</p>
                        <p class="font-medium text-red-600">
                            {{ $resolution->voting_deadline ? $resolution->voting_deadline->format('Y-m-d H:i') : __('No deadline') }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-700 mb-3">{{ __('Current Tally') }}</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ __('Votes Cast') }}</span>
                                <span class="font-bold">{{ $resolution->votes->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
