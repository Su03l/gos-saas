@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (session('tenant') && session('tenant')->logo_path)
    <img src="{{ Storage::url(session('tenant')->logo_path) }}" class="logo" alt="{{ session('tenant')->name }}" style="max-height: 50px;">
@else
    {{ config('app.name') }}
@endif
</a>
</td>
</tr>
