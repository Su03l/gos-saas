<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $agendaItem->title }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: {{ session('tenant')?->primary_color ?? '#1e3a8a' }};
            --color-secondary: {{ session('tenant')?->secondary_color ?? '#ffffff' }};
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm py-4">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center">
            @if(session('tenant')?->logo_path)
                <img src="{{ asset(session('tenant')->logo_path) }}" alt="Logo" class="h-10 w-auto">
            @else
                <span class="text-2xl font-bold text-primary">{{ session('tenant')->name ?? 'Portal' }}</span>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-8 space-y-6">
            <div class="border-b border-gray-100 pb-4">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('External Advisor Access') }}</span>
                <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $agendaItem->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('Meeting') }}: {{ $agendaItem->meeting->title }} ({{ $agendaItem->meeting->committee->name }})</p>
            </div>

            @if($agendaItem->description)
                <div class="prose prose-sm max-w-none text-gray-800">
                    {!! nl2br(e($agendaItem->description)) !!}
                </div>
            @endif

            <div class="bg-gray-50 p-6 rounded-md border border-gray-100 mt-6">
                <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase">{{ __('Attached Documents') }}</h3>
                <div class="space-y-3">
                    @forelse($agendaItem->getMedia('confidential_documents') as $media)
                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-md">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">{{ $media->file_name }}</span>
                            </div>
                            <a href="{{ route('documents.show', $media) }}" class="text-xs font-bold text-white bg-primary px-3 py-1.5 rounded hover:bg-primary/90 transition-colors">
                                {{ __('Download securely') }}
                            </a>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">{{ __('No documents attached.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center">
        <p class="text-xs text-gray-500">{{ __('Secure Document Delivery via Board Governance Portal') }} &copy; {{ date('Y') }}</p>
    </footer>
</body>
</html>
