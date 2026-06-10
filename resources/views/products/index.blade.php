@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Prodotti</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">+ Nuovo Prodotto</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2 flex-wrap">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cerca per SKU o nome..." class="form-control form-control-sm w-auto">
    <select name="brand_id" class="form-select form-select-sm w-auto">
        <option value="">Tutti i brand</option>
        @foreach($brands as $id => $name)
            <option value="{{ $id }}" {{ request('brand_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <select name="category_id" class="form-select form-select-sm w-auto">
        <option value="">Tutte le categorie</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" {{ request('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <button class="btn btn-outline-secondary btn-sm">Filtra</button>
    @if(request()->anyFilled(['search','brand_id','category_id']))
        <a href="{{ route('products.index') }}" class="btn btn-outline-danger btn-sm">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>SKU</th>
                    <th>Nome</th>
                    <th>Brand</th>
                    <th>Categoria</th>
                    <th>Stato</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="font-monospace small">{{ $product->sku }}</td>
                    <td class="fw-medium">
                        {{ $product->translations->first()?->name ?? '—' }}
                    </td>
                    <td>{{ $product->brand?->name ?? '—' }}</td>
                    <td>{{ $product->category?->name ?? '—' }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success">Attivo</span>
                        @else
                            <span class="badge bg-secondary">Inattivo</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('products.edit', $product) }}"
                           class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                              class="d-inline" onsubmit="return confirm('Eliminare questo prodotto?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nessun prodotto trovato.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="card-footer">{{ $products->links() }}</div>
    @endif
</div>

@endsection