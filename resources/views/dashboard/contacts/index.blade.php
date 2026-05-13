@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Messaggi e Reclami</h1>
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
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h6 class="card-title">Nuovi</h6>
                <p class="card-text display-6">{{ $stats['new'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h6 class="card-title">In gestione</h6>
                <p class="card-text display-6">{{ $stats['in_progress'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Risolti</h6>
                <p class="card-text display-6">{{ $stats['resolved'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Filtri --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tutti gli stati</option>
            <option value="new"         {{ request('status') === 'new'         ? 'selected' : '' }}>Nuovi</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In gestione</option>
            <option value="resolved"    {{ request('status') === 'resolved'    ? 'selected' : '' }}>Risolti</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="type" class="form-select" onchange="this.form.submit()">
            <option value="">Tutti i tipi</option>
            <option value="complaint" {{ request('type') === 'complaint' ? 'selected' : '' }}>Reclami</option>
            <option value="return"    {{ request('type') === 'return'    ? 'selected' : '' }}>Richieste reso</option>
            <option value="order"     {{ request('type') === 'order'     ? 'selected' : '' }}>Problemi ordine</option>
            <option value="info"      {{ request('type') === 'info'      ? 'selected' : '' }}>Informazioni</option>
            <option value="other"     {{ request('type') === 'other'     ? 'selected' : '' }}>Altro</option>
        </select>
    </div>
</form>

{{-- Tabella --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Oggetto</th>
                    <th>Stato</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr class="{{ $message->status === 'new' ? 'fw-bold' : '' }}">
                    <td>
                        <span class="badge bg-{{ $message->typeColor() }}">
                            {{ $message->typeLabel() }}
                        </span>
                    </td>
                    <td>{{ $message->name }}<br>
                        <small class="text-muted">{{ $message->email }}</small></td>
                    <td>{{ $message->subject }}</td>
                    <td>
                        <span class="badge bg-{{ $message->statusColor() }}">
                            {{ $message->statusLabel() }}
                        </span>
                    </td>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('dashboard.contacts.show', $message) }}"
                           class="btn btn-sm btn-outline-primary">Apri</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">Nessun messaggio ricevuto</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
    <div class="card-footer">{{ $messages->links() }}</div>
    @endif
</div>
@endsection