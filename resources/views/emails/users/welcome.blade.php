<x-mail::message>
# Benvenuto, {{ $user->name }}!

Grazie per esserti iscritto a **{{ config('app.name') }}**.

<x-mail::button :url="url('/')">
Vai al sito
</x-mail::button>

Grazie,<br>
{{ config('app.name') }}
</x-mail::message>
