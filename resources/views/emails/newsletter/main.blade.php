<x-mail::message>
# {{ $mailSubject }}

{{ $mailBody }}

@if($ctaUrl)
<x-mail::button :url="$ctaUrl">
{{ $ctaLabel }}
</x-mail::button>
@endif

Grazie,<br>
{{ config("app.name") }}

---

<small>Hai ricevuto questa email perché sei iscritto alla newsletter di {{ config("app.name") }}.
Se non vuoi più riceverla, puoi cancellarti dal tuo profilo.</small>
</x-mail::message>