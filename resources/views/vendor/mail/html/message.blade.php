<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<style>
    .button-primary { background-color: {{ session('tenant')?->primary_color ?? '#1e3a8a' }} !important; border-color: {{ session('tenant')?->primary_color ?? '#1e3a8a' }} !important; }
    .header a { color: {{ session('tenant')?->primary_color ?? '#1e3a8a' }} !important; }
</style>

{!! $slot !!}

@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ session('tenant')?->name ?? config('app.name') }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
