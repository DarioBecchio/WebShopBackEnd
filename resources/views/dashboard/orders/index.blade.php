@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Gestione Ordini</h1>
</div>

{{-- Stats --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h6 class="card-title">Totali</h6>
                <p class="card-text display-6">{{ $stats['totali'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h6 class="card-title">In attesa</h6>
                <p class="card-text display-6">{{ $stats['pending'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h6 class="card-title">In lavorazione</h6>
                <p class="card-text display-6">{{ $stats['processing'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Spediti</h6>
                <p class="card-text display-6">{{ $stats['shipped'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Filtri --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control"
               placeholder="Cerca per numero ordine..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tutti gli stati</option>
            <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>In attesa</option>
            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>In lavorazione</option>
            <option value="shipped"    {{ request('status') === 'shipped'    ? 'selected' : '' }}>Spediti</option>
            <option value="delivered"  {{ request('status') === 'delivered'  ? 'selected' : '' }}>Consegnati</option>
            <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Annullati</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Cerca</button>
    </div>
</form>

{{-- Tabella ordini --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ordine</th>
                    <th>Cliente</th>
                    <th>Totale</th>
                    <th>Stato</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td>{{ $order->user->name }}<br>
                        <small class="text-muted">{{ $order->user->email }}</small></td>
                    <td>€ {{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $order->statusColor() }}">
                            {{ $order->statusLabel() }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('dashboard.orders.show', $order) }}"
                           class="btn btn-sm btn-outline-primary">Gestisci</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">Nessun ordine trovato</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer">{{ $orders->links() }}</div>
    @endif
</div>
@endsection