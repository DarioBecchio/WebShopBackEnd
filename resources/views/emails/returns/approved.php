<x-mail::message>
# Il tuo reso è stato approvato ✅

Ciao **{{ $returnRequest->user->name }}**,

abbiamo esaminato la tua richiesta di reso per l'ordine **#{{ $returnRequest->order_number }}** e siamo lieti di comunicarti che è stata **approvata**.

**Dettagli del rimborso:**

| | |
|:--|:--|
| Ordine | #{{ $returnRequest->order_number }} |
| Motivo reso | {{ $returnRequest->reasonLabel() }} |
| Importo rimborso | **€ {{ number_format($returnRequest->refund_amount, 2) }}** |

Il rimborso verrà accreditato entro **5-7 giorni lavorativi** sul metodo di pagamento originale.

@if($returnRequest->admin_notes)
**Note aggiuntive:**
{{ $returnRequest->admin_notes }}
@endif

Grazie per la tua pazienza.<br>
{{ config('app.name') }}
</x-mail::message>