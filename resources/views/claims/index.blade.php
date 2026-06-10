@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Claim</h2>
    <a href="{{ route('claims.create') }}" class="btn btn-primary btn-sm">+ Nuovo Claim</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Codice</th><th>Label</th><th>Categoria</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($claims as $claim)
                <tr>
                    <td class="font-monospace small">{{ $claim->code }}</td>
                    <td>{{ $claim->label }}</td>
                    <td>{{ $claim->category ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('claims.edit', $claim) }}" class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('claims.destroy', $claim) }}" class="d-inline"
                              onsubmit="return confirm('Eliminare?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Nessun claim trovato.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($claims->hasPages())
        <div class="card-footer">{{ $claims->links() }}</div>
    @endif
</div>

@endsection