@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Ordine #{{ $order->order_number }}</h1>
    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-secondary">← Torna</a>
</div>

<div class="row">
    {{-- Dettagli ordine --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">Prodotti ordinati</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Prodotto</th>
                            <th>SKU</th>
                            <th class="text-center">Qtà</th>
                            <th class="text-end">Prezzo</th>
                            <th class="text-end">Totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td><small class="text-muted">{{ $item->product_sku ?? '-' }}</small></td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">€ {{ number_format($item->price, 2) }}</td>
                            <td class="text-end">€ {{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end">Subtotale</td>
                            <td class="text-end">€ {{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Spedizione</td>
                            <td class="text-end">€ {{ number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Totale</strong></td>
                            <td class="text-end"><strong>€ {{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Indirizzo spedizione --}}
        <div class="card mb-4">
            <div class="card-header">Indirizzo di spedizione</div>
            <div class="card-body">
                <p class="mb-0">
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_postal_code }} {{ $order->shipping_city }}<br>
                    {{ $order->shipping_country }}
                </p>
            </div>
        </div>
    </div>

    {{-- Sidebar gestione --}}
    <div class="col-md-4">
        {{-- Info cliente --}}
        <div class="card mb-4">
            <div class="card-header">Cliente</div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                <p class="mb-1 text-muted">{{ $order->user->email }}</p>
                <p class="mb-0 text-muted">{{ $order->user->phone ?? 'Nessun telefono' }}</p>
            </div>
        </div>

        {{-- Aggiorna stato --}}
        <div class="card">
            <div class="card-header">Aggiorna ordine</div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.orders.update', $order) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Stato</label>
                        <select name="status" class="form-select">
                            @foreach(['pending','processing','shipped','delivered','cancelled','refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                {{ $order->statusLabel() === $order->statusLabel() ? (match($s) {
                                    'pending'    => 'In attesa',
                                    'processing' => 'In lavorazione',
                                    'shipped'    => 'Spedito',
                                    'delivered'  => 'Consegnato',
                                    'cancelled'  => 'Annullato',
                                    'refunded'   => 'Rimborsato',
                                }) : $s }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            Passare a "In lavorazione" invia la mail di conferma al cliente.<br>
                            Passare a "Spedito" invia la mail di spedizione.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Numero tracking</label>
                        <input type="text" name="tracking_number" class="form-control"
                               value="{{ $order->tracking_number }}"
                               placeholder="Es. IT123456789">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note interne</label>
                        <textarea name="notes" rows="3" class="form-control"
                                  placeholder="Note visibili solo all'admin...">{{ $order->notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Salva e invia email
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection