@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Categorie</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">+ Nuova Categoria</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cerca categoria..." class="form-control form-control-sm w-auto">
    <button class="btn btn-outline-secondary btn-sm">Cerca</button>
    @if(request('search'))
        <a href="{{ route('categories.index') }}" class="btn btn-outline-danger btn-sm">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Categoria padre</th>
                    <th>Livello</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-medium">
                        @for($i = 0; $i < $category->depth; $i++)
                            <span class="text-muted">— </span>
                        @endfor
                        {{ $category->name }}
                    </td>
                    <td>{{ $category->parent?->name ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ $category->depth == 0 ? 'Radice' : 'Livello '.$category->depth }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('categories.edit', $category) }}"
                           class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                              class="d-inline" onsubmit="return confirm('Eliminare questa categoria?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Nessuna categoria trovata.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="card-footer">{{ $categories->links() }}</div>
    @endif
</div>

@endsection