@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Varianti</h2>
    <a href="{{ route('variants.create') }}" class="btn btn-primary btn-sm">+ Nuova Variante</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2 flex-wrap">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cerca per SKU..." class="form-control form-control-sm w-auto">
    <select name="product_id" class="form-select form-select-sm w-auto">
        <option value="">Tutti i prodotti</option>
        @foreach($products as $id => $name)
            <option value="{{ $id }}" {{ request('product_id') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <button class="btn btn-outline-secondary btn-sm">Filtra</button>
    @if(request()->anyFilled(['search','product_id']))
        <a href="{{ route('variants.index') }}" class="btn btn-outline-danger btn-sm">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>SKU</th>
                    <th>Prodotto</th>
                    <th>Tonalità</th>
                    <th>Formato</th>
                    <th>Prezzo</th>
                    <th>Stock</th>
                    <th>Default</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($variants as $variant)
                <tr>
                    <td class="font-monospace small">{{ $variant->sku }}</td>
                    <td>{{ $variant->product?->translations->first()?->name ?? $variant->product?->sku ?? '—' }}</td>
                    <td>
                        @if($variant->shade)
                            @if($variant->shade->hex_color)
                                <span class="d-inline-block rounded border me-1"
                                      style="width:14px;height:14px;background:{{ $variant->shade->hex_color }};vertical-align:middle"></span>
                            @endif
                            {{ $variant->shade->name }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $variant->size?->display_label ?? '—' }}</td>
                    <td>{{ number_format($variant->price, 2) }} {{ $variant->currency }}</td>
                    <td>
                        <span class="badge {{ $variant->stock_qty > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $variant->stock_qty }}
                        </span>
                    </td>
                    <td>
                        @if($variant->is_default)
                            <span class="badge bg-primary">✓ Default</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('variants.edit', $variant) }}"
                           class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('variants.destroy', $variant) }}"
                              class="d-inline" onsubmit="return confirm('Eliminare questa variante?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Nessuna variante trovata.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($variants->hasPages())
        <div class="card-footer">{{ $variants->links() }}</div>
    @endif
</div>

@endsection