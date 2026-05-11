<x-mail::message>
# Ordine confermato!

Ciao **{{ $order->user->name }}**, abbiamo ricevuto il tuo ordine.

**Numero ordine:** #{{ $order->order_number }}
**Data:** {{ $order->created_at->format('d/m/Y H:i') }}

<x-mail::table>
| Prodotto | Qtà | Prezzo |
|:---------|:---:|-------:|
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | € {{ number_format($item->price, 2) }} |
@endforeach
| | **Spedizione** | € {{ number_format($order->shipping, 2) }} |
| | **Totale** | **€ {{ number_format($order->total, 2) }}** |
</x-mail::table>

**Indirizzo di spedizione:**
{{ $order->shipping_name }}
{{ $order->shipping_address }}
{{ $order->shipping_postal_code }} {{ $order->shipping_city }}
{{ $order->shipping_country }}

Ti invieremo un'altra email quando il tuo ordine verrà spedito.

Grazie per il tuo acquisto!<br>
{{ config('app.name') }}
</x-mail::message>