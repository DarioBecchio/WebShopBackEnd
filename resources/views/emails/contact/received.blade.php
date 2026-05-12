<x-mail::message>
# Abbiamo ricevuto il tuo messaggio!

Ciao **{{ $contactMessage->name }}**,

grazie per averci contattato. Abbiamo ricevuto il tuo messaggio e ti risponderemo il prima possibile.

**Riepilogo della tua richiesta:**

| | |
|:--|:--|
| Tipo | {{ $contactMessage->typeLabel() }} |
| Oggetto | {{ $contactMessage->subject }} |
| Messaggio | {{ $contactMessage->message }} |

Di solito rispondiamo entro **24-48 ore lavorative**.

Grazie per la pazienza.<br>
{{ config('app.name') }}
</x-mail::message>