@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Certificazioni</h2>
    <a href="{{ route('certifications.create') }}" class="btn btn-primary btn-sm">+ Nuova Certificazione</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Codice</th><th>Nome</th><th>Ente</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($certifications as $cert)
                <tr>
                    <td class="font-monospace small">{{ $cert->code }}</td>
                    <td class="fw-medium">{{ $cert->name }}</td>
                    <td>{{ $cert->issuing_body ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('certifications.edit', $cert) }}" class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('certifications.destroy', $cert) }}" class="d-inline"
                              onsubmit="return confirm('Eliminare?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Nessuna certificazione trovata.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($certifications->hasPages())
        <div class="card-footer">{{ $certifications->links() }}</div>
    @endif
</div>

@endsection
