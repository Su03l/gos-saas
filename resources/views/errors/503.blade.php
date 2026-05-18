<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('System Maintenance') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @php
        $tenant = session('tenant') ?? \App\Models\Tenant::where('domain', request()->getHost())->first();
        $primaryColor = $tenant?->primary_color ?? '#1e3a8a';
    @endphp
    <style>
        :root { --primary: {{ $primaryColor }}; }
        .bg-primary { background-color: var(--primary); }
        .text-primary { color: var(--primary); }
    </style>
</head>
<body class="antialiased bg-gray-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-10 text-center border border-gray-100">
        @if($tenant && $tenant->logo_path)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($tenant->logo_path) }}" alt="{{ $tenant->name }}" class="h-16 mx-auto mb-8">
        @else
            <div class="h-16 w-16 bg-primary rounded-xl mx-auto mb-8 flex items-center justify-center">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Scheduled Maintenance') }}</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            {{ __('We are currently upgrading our systems to provide you with a better experience. We will be back online shortly.') }}
        </p>

        <div class="space-y-4">
            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: 75%"></div>
            </div>
            <p class="text-xs font-bold text-primary uppercase tracking-widest">{{ __('Upgrading Core Engine...') }}</p>
        </div>

        <div class="mt-10 pt-8 border-t border-gray-100">
            <p class="text-sm text-gray-500">
                {{ __('If you have any urgent inquiries, please contact') }}
                <a href="mailto:support@governance-saas.com" class="text-primary font-bold hover:underline">support@governance-saas.com</a>
            </p>
        </div>
    </div>
</body>
</html>
