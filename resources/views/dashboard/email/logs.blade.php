@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Log Email</h1>
    <a href="{{ route('dashboard.email.index') }}" class="btn btn-outline-secondary">← Torna</a>
</div>

{{-- Filtri --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="type" class="form-select" onchange="this.form.submit()">
            <option value="">Tutti i tipi</option>
            <option value="newsletter" {{ request('type') === 'newsletter' ? 'selected' : '' }}>Newsletter</option>
            <option value="welcome" {{ request('type') === 'welcome' ? 'selected' : '' }}>Benvenuto</option>
            <option value="order" {{ request('type') === 'order' ? 'selected' : '' }}>Ordine</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tutti gli stati</option>
            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Inviate</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Fallite</option>
        </select>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tipo</th>
                    <th>Destinatario</th>
                    <th>Oggetto</th>
                    <th>Stato</th>
                    <th>Note</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td><span class="badge bg-secondary">{{ $log->type }}</span></td>
                    <td>{{ $log->recipient }}</td>
                    <td>{{ $log->subject }}</td>
                    <td>
                        <span class="badge bg-{{ $log->status === 'sent' ? 'success' : 'danger' }}">
                            {{ $log->status === 'sent' ? 'Inviata' : 'Fallita' }}
                        </span>
                    </td>
                    <td>{{ $log->notes ?? '-' }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">Nessuna email nel log</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection