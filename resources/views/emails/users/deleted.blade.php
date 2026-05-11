<x-mail::message>
# Ci dispiace vederti andare, {{ $user->name }}

Il tuo account su **{{ config('app.name') }}** è stato eliminato con successo.

Tutti i tuoi dati personali sono stati rimossi dai nostri sistemi.

Se hai eliminato l account per errore o hai cambiato idea, puoi registrarti nuovamente in qualsiasi momento.

<x-mail::button :url="url('/register')">
Registrati di nuovo
</x-mail::button>

Grazie per aver fatto parte di {{ config('app.name') }}.<br>
{{ config('app.name') }}
</x-mail::message>
