<x-mail::message>
# Il tuo ordine è in viaggio! 🚚

Ciao **{{ $order->user->name }}**, il tuo ordine è stato spedito.

**Numero ordine:** #{{ $order->order_number }}
**Data spedizione:** {{ $order->shipped_at->format('d/m/Y') }}

@if($order->tracking_number)
**Numero di tracciamento:** `{{ $order->tracking_number }}`

<x-mail::button :url="'https://www.tracking.it/' . $order->tracking_number">
Traccia il tuo ordine
</x-mail::button>
@endif

**Indirizzo di consegna:**
{{ $order->shipping_name }}
{{ $order->shipping_address }}
{{ $order->shipping_postal_code }} {{ $order->shipping_city }}
{{ $order->shipping_country }}

Grazie per il tuo acquisto!<br>
{{ config('app.name') }}
</x-mail::message>