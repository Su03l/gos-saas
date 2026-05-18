<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-primary transition-colors focus:outline-none">
        <span class="sr-only">{{ __('View notifications') }}</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 block h-4 w-4 transform -translate-y-1/2 translate-x-1/2 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-white">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-95" 
         class="absolute left-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50 overflow-hidden" 
         style="display: none;">
        
        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-900">{{ __('Notifications') }}</h3>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="#" class="text-xs text-primary hover:underline font-medium">{{ __('Mark all as read') }}</a>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer">
                    <p class="text-sm font-bold text-gray-900 mb-1">
                        {{ $notification->data['title'] ?? __('Notification') }}
                    </p>
                    <p class="text-xs text-gray-600 leading-normal mb-2">
                        {{ $notification->data['message'] ?? '' }}
                    </p>
                    <span class="text-[10px] text-gray-400 font-medium">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H4a2 2 0 00-2 2v7m18 0v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5m18 0l-2-2m-14 0l2-2" />
                    </svg>
                    <p class="text-sm text-gray-500">{{ __('No new notifications') }}</p>
                </div>
            @endforelse
        </div>

        @if(auth()->user()->notifications->count() > 0)
            <a href="#" class="block p-3 text-center text-xs font-bold text-gray-700 bg-gray-50 hover:bg-gray-100 border-t border-gray-200">
                {{ __('View All Activity') }}
            </a>
        @endif
    </div>
</div>
