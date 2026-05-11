@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Richiesta reso - Ordine #{{ $returnRequest->order_number }}</h1>
    <a href="{{ route('dashboard.returns.index') }}" class="btn btn-outline-secondary">← Torna</a>
</div>

<div class="row">
    {{-- Dettagli richiesta --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">Dettagli richiesta</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="200">Ordine</th>
                        <td>#{{ $returnRequest->order_number }}</td>
                    </tr>
                    <tr>
                        <th>Stato attuale</th>
                        <td>
                            <span class="badge bg-{{ $returnRequest->statusColor() }}">
                                {{ $returnRequest->statusLabel() }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Motivo</th>
                        <td>{{ $returnRequest->reasonLabel() }}</td>
                    </tr>
                    <tr>
                        <th>Descrizione cliente</th>
                        <td>{{ $returnRequest->description }}</td>
                    </tr>
                    <tr>
                        <th>Data richiesta</th>
                        <td>{{ $returnRequest->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($returnRequest->resolved_at)
                    <tr>
                        <th>Data risoluzione</th>
                        <td>{{ $returnRequest->resolved_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    @if($returnRequest->refund_amount)
                    <tr>
                        <th>Importo rimborso</th>
                        <td><strong>€ {{ number_format($returnRequest->refund_amount, 2) }}</strong></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Info cliente --}}
        <div class="card mb-4">
            <div class="card-header">Cliente</div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $returnRequest->user->name }}</strong></p>
                <p class="mb-1 text-muted">{{ $returnRequest->user->email }}</p>
                <p class="mb-0 text-muted">{{ $returnRequest->user->phone ?? 'Nessun telefono' }}</p>
            </div>
        </div>
    </div>

    {{-- Sidebar gestione --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Gestisci richiesta</div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.returns.update', $returnRequest) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Stato</label>
                        <select name="status" class="form-select">
                            @foreach(['pending' => 'In attesa', 'approved' => 'Approvato', 'rejected' => 'Rifiutato', 'completed' => 'Completato'] as $value => $label)
                            <option value="{{ $value }}" {{ $returnRequest->status === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            "Approvato" invia la mail di approvazione.<br>
                            "Rifiutato" invia la mail di rifiuto.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Importo rimborso (€)</label>
                        <input type="number" name="refund_amount" step="0.01" min="0"
                               class="form-control" value="{{ $returnRequest->refund_amount }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note interne / Motivazione</label>
                        <textarea name="admin_notes" rows="4" class="form-control"
                                  placeholder="Visibile al cliente nell'email...">{{ $returnRequest->admin_notes }}</textarea>
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