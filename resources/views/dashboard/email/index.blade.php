@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Gestione Email</h1>
</div>

{{-- Stats --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h6 class="card-title">Email totali inviate</h6>
                <p class="card-text display-6">{{ $stats['totali'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Newsletter</h6>
                <p class="card-text display-6">{{ $stats['newsletter'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h6 class="card-title">Transazionali</h6>
                <p class="card-text display-6">{{ $stats['transazionali'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h6 class="card-title">Fallite</h6>
                <p class="card-text display-6">{{ $stats['fallite'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Azioni rapide --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">Newsletter</h5>
                <p class="text-muted">{{ $stats['iscritti'] }} utenti iscritti</p>
                <a href="{{ route('dashboard.email.newsletter') }}" class="btn btn-primary">
                    Invia Newsletter
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">Log Email</h5>
                <p class="text-muted">Storico di tutte le email inviate</p>
                <a href="{{ route('dashboard.email.logs') }}" class="btn btn-secondary">
                    Vedi Log
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">Template</h5>
                <p class="text-muted">Gestisci i template email</p>
                <a href="{{ route('dashboard.email.templates') }}" class="btn btn-dark">
                    Vedi Template
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Email recenti --}}
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Email recenti</span>
        <a href="{{ route('dashboard.email.logs') }}" class="btn btn-sm btn-outline-secondary">Vedi tutte</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tipo</th>
                    <th>Destinatario</th>
                    <th>Oggetto</th>
                    <th>Stato</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recenti as $log)
                <tr>
                    <td><span class="badge bg-secondary">{{ $log->type }}</span></td>
                    <td>{{ $log->recipient }}</td>
                    <td>{{ $log->subject }}</td>
                    <td>
                        <span class="badge bg-{{ $log->status === 'sent' ? 'success' : 'danger' }}">
                            {{ $log->status === 'sent' ? 'Inviata' : 'Fallita' }}
                        </span>
                    </td>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">Nessuna email inviata ancora</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection