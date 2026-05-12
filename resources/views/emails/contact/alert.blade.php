<x-mail::message>
# Nuovo messaggio ricevuto

Hai ricevuto un nuovo messaggio sul sito.

| | |
|:--|:--|
| Tipo | {{ $contactMessage->typeLabel() }} |
| Nome | {{ $contactMessage->name }} |
| Email | {{ $contactMessage->email }} |
| Oggetto | {{ $contactMessage->subject }} |

**Messaggio:**

{{ $contactMessage->message }}

<x-mail::button :url="url('/dashboard/contacts/' . $contactMessage->id)">
Gestisci il messaggio
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>