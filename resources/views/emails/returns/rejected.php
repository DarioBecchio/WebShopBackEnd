<x-mail::message>
# Aggiornamento sulla tua richiesta di reso

Ciao **{{ $returnRequest->user->name }}**,

abbiamo esaminato la tua richiesta di reso per l'ordine **#{{ $returnRequest->order_number }}**.

Purtroppo, dopo un'attenta valutazione, non siamo in grado di approvare il reso richiesto.

**Dettagli richiesta:**

| | |
|:--|:--|
| Ordine | #{{ $returnRequest->order_number }} |
| Motivo indicato | {{ $returnRequest->reasonLabel() }} |

@if($returnRequest->admin_notes)
**Motivazione:**
{{ $returnRequest->admin_notes }}
@endif

Se ritieni che ci sia stato un errore o hai bisogno di ulteriori chiarimenti, puoi contattarci rispondendo a questa email.

Grazie per la comprensione.<br>
{{ config('app.name') }}
</x-mail::message>
