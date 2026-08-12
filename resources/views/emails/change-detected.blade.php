<x-mail::message>
# A page you're watching has changed

**URL:** {{ $url }}
**Detected:** {{ $detectedAt }}

<x-mail::panel>
{{ $summary }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>