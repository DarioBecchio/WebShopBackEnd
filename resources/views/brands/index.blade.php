@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Brand</h2>
    <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">+ Nuovo Brand</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cerca brand..." class="form-control form-control-sm w-auto">
    <button class="btn btn-outline-secondary btn-sm">Cerca</button>
    @if(request('search'))
        <a href="{{ route('brands.index') }}" class="btn btn-outline-danger btn-sm">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Paese</th>
                    <th>Cruelty Free</th>
                    <th>Vegan</th>
                    <th>Sito Web</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr>
                    <td class="fw-medium">{{ $brand->name }}</td>
                    <td>{{ $brand->country_code ?? '—' }}</td>
                    <td>
                        @if($brand->is_cruelty_free)
                            <span class="badge bg-success">✓ Sì</span>
                        @else
                            <span class="text-muted">No</span>
                        @endif
                    </td>
                    <td>
                        @if($brand->is_vegan)
                            <span class="badge bg-success">✓ Sì</span>
                        @else
                            <span class="text-muted">No</span>
                        @endif
                    </td>
                    <td>
                        @if($brand->website_url)
                            <a href="{{ $brand->website_url }}" target="_blank" class="small">
                                {{ parse_url($brand->website_url, PHP_URL_HOST) }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('brands.edit', $brand) }}"
                           class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('brands.destroy', $brand) }}"
                              class="d-inline"
                              onsubmit="return confirm('Eliminare questo brand?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nessun brand trovato.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($brands->hasPages())
        <div class="card-footer">{{ $brands->links() }}</div>
    @endif
</div>

@endsection