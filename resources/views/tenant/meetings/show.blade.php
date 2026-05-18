<x-tenant-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ $meeting->title }}</h1>
            <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-700 uppercase">
                {{ $meeting->status }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
                    <h2 class="text-lg font-bold text-gray-700">{{ __('Meeting Details') }}</h2>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('Committee') }}</p>
                        <p class="font-medium">{{ $meeting->committee->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('Scheduled At') }}</p>
                        <p class="font-medium">{{ $meeting->scheduled_start->format('Y-m-d H:i') }}</p>
                    </div>
                    @if($meeting->meeting_link)
                        <a href="{{ $meeting->meeting_link }}" target="_blank" class="block w-full text-center bg-primary text-white py-2 rounded-md hover:bg-primary/90 font-bold">
                            {{ __('Join Meeting') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Agenda Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">{{ __('Agenda') }}</h2>
                    <div class="space-y-4">
                        @foreach($meeting->agendaItems as $item)
                            <div class="p-4 border border-gray-100 rounded-md">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">{{ $item->order_index }}. {{ $item->title }}</h3>
                                    <span class="text-sm text-gray-500">{{ $item->allocated_minutes }} {{ __('min') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">{{ $item->description }}</p>
                                
                                <!-- Document VDR -->
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Documents (VDR)') }}</h4>
                                    <div class="space-y-2">
                                        @foreach($item->getMedia('confidential_documents') as $media)
                                            <a href="{{ route('documents.show', $media) }}" class="flex items-center text-sm text-primary hover:underline">
                                                <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                {{ $media->file_name }} ({{ __('Secure PDF') }})
                                            </a>
                                        @endforeach
                                    </div>
                                    
                                    @can('manage_meetings')
                                        <form action="{{ route('documents.store', $item) }}" method="POST" enctype="multipart/form-data" class="mt-4 flex items-center space-x-reverse space-x-2">
                                            @csrf
                                            <input type="file" name="document" accept=".pdf" class="text-xs text-gray-500">
                                            <button type="submit" class="text-xs bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">{{ __('Upload') }}</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
