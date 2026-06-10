@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Ingredienti</h2>
    <a href="{{ route('ingredients.create') }}" class="btn btn-primary btn-sm">+ Nuovo Ingrediente</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cerca per nome INCI o comune..." class="form-control form-control-sm w-auto">
    <button class="btn btn-outline-secondary btn-sm">Cerca</button>
    @if(request('search'))
        <a href="{{ route('ingredients.index') }}" class="btn btn-outline-danger btn-sm">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome INCI</th>
                    <th>Nome comune</th>
                    <th>Allergene</th>
                    <th>Distruttore endocrino</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($ingredients as $ingredient)
                <tr>
                    <td class="fw-medium font-monospace small">{{ $ingredient->inci_name }}</td>
                    <td>{{ $ingredient->common_name ?? '—' }}</td>
                    <td>
                        @if($ingredient->is_allergen)
                            <span class="badge bg-warning text-dark">⚠ Sì</span>
                        @else
                            <span class="text-muted">No</span>
                        @endif
                    </td>
                    <td>
                        @if($ingredient->is_endocrine_disruptor)
                            <span class="badge bg-danger">⚠ Sì</span>
                        @else
                            <span class="text-muted">No</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('ingredients.edit', $ingredient) }}"
                           class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('ingredients.destroy', $ingredient) }}"
                              class="d-inline" onsubmit="return confirm('Eliminare questo ingrediente?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Nessun ingrediente trovato.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($ingredients->hasPages())
        <div class="card-footer">{{ $ingredients->links() }}</div>
    @endif
</div>

@endsection