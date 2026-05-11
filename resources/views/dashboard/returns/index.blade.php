@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Gestione Resi</h1>
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
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Approvati</h6>
                <p class="card-text display-6">{{ $stats['approved'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h6 class="card-title">Rifiutati</h6>
                <p class="card-text display-6">{{ $stats['rejected'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Filtri --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tutti gli stati</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>In attesa</option>
            <option value="approved"  {{ request('status') === 'approved'  ? 'selected' : '' }}>Approvati</option>
            <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Rifiutati</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completati</option>
        </select>
    </div>
</form>

{{-- Tabella --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ordine</th>
                    <th>Cliente</th>
                    <th>Motivo</th>
                    <th>Stato</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $return)
                <tr>
                    <td><strong>#{{ $return->order_number }}</strong></td>
                    <td>{{ $return->user->name }}<br>
                        <small class="text-muted">{{ $return->user->email }}</small></td>
                    <td>{{ $return->reasonLabel() }}</td>
                    <td>
                        <span class="badge bg-{{ $return->statusColor() }}">
                            {{ $return->statusLabel() }}
                        </span>
                    </td>
                    <td>{{ $return->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('dashboard.returns.show', $return) }}"
                           class="btn btn-sm btn-outline-primary">Gestisci</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">Nessuna richiesta di reso</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($returns->hasPages())
    <div class="card-footer">{{ $returns->links() }}</div>
    @endif
</div>
@endsection