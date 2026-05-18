@props(['status', 'signedAt' => null])

<div {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    @if($status === 'signed')
        <div class="flex items-center px-3 py-1.5 bg-green-50 border border-green-200 rounded-full shadow-sm">
            <div class="flex-shrink-0 h-4 w-4 text-green-600 ml-2">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-bold text-green-800 leading-tight">
                    {{ __('Signed Digitally via PKI/Nafath') }}
                </span>
                @if($signedAt)
                    <span class="text-[10px] text-green-600 font-mono">
                        {{ $signedAt }}
                    </span>
                @endif
            </div>
        </div>
    @else
        <div class="flex items-center px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-full shadow-sm">
            <div class="flex-shrink-0 h-4 w-4 text-gray-400 ml-2 animate-pulse">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2" />
                </svg>
            </div>
            <span class="text-xs font-bold text-gray-600 leading-tight">
                {{ __('Pending Signature') }}
            </span>
        </div>
    @endif
</div>
