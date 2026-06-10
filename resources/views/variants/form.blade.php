@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $variant->exists ? 'Modifica Variante' : 'Nuova Variante' }}</h2>
    <a href="{{ route('variants.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<form method="POST"
      action="{{ $variant->exists ? route('variants.update', $variant) : route('variants.store') }}">
@csrf
@if($variant->exists) @method('PUT') @endif

<div class="card mb-4">
    <div class="card-header fw-medium">Dati variante</div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-medium">Prodotto *</label>
                <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                    <option value="">— Seleziona —</option>
                    @foreach($products as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('product_id', $variant->product_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">SKU *</label>
                <input type="text" name="sku" value="{{ old('sku', $variant->sku) }}"
                       class="form-control font-monospace @error('sku') is-invalid @enderror">
                @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Tonalità</label>
                <select name="shade_id" class="form-select">
                    <option value="">— Nessuna —</option>
                    @foreach($shades as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('shade_id', $variant->shade_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Formato</label>
                <select name="size_id" class="form-select">
                    <option value="">— Nessuno —</option>
                    @foreach($sizes as $id => $label)
                        <option value="{{ $id }}"
                            {{ old('size_id', $variant->size_id) == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Valuta</label>
                <select name="currency" class="form-select">
                    @foreach(['EUR','USD','GBP','CHF'] as $cur)
                        <option value="{{ $cur }}"
                            {{ old('currency', $variant->currency ?? 'EUR') == $cur ? 'selected' : '' }}>
                            {{ $cur }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Prezzo *</label>
                <div class="input-group">
                    <span class="input-group-text">€</span>
                    <input type="number" name="price" step="0.01" min="0"
                           value="{{ old('price', $variant->price) }}"
                           class="form-control @error('price') is-invalid @enderror">
                </div>
                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Stock *</label>
                <input type="number" name="stock_qty" min="0"
                       value="{{ old('stock_qty', $variant->stock_qty ?? 0) }}"
                       class="form-control @error('stock_qty') is-invalid @enderror">
                @error('stock_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input type="hidden" name="is_default" value="0">
                    <input type="checkbox" name="is_default" id="is_default" value="1"
                           class="form-check-input"
                           {{ old('is_default', $variant->is_default) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">Variante default</label>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Ingredienti INCI --}}
<div class="card mb-4">
    <div class="card-header fw-medium">Lista INCI ingredienti</div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            Seleziona gli ingredienti nell'ordine corretto (dal più concentrato al meno concentrato).
        </p>
        @php
            $selectedIngredients = old('ingredient_ids', $variant->exists
                ? $variant->ingredients->pluck('id')->toArray()
                : []);
        @endphp
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
            @foreach($ingredients as $id => $name)
            <div class="col">
                <div class="form-check">
                    <input type="checkbox" name="ingredient_ids[]" value="{{ $id }}"
                           id="ing_{{ $id }}" class="form-check-input"
                           {{ in_array($id, $selectedIngredients) ? 'checked' : '' }}>
                    <label class="form-check-label small font-monospace" for="ing_{{ $id }}">
                        {{ $name }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex gap-2 mb-4">
    <button type="submit" class="btn btn-primary">
        {{ $variant->exists ? 'Salva modifiche' : 'Crea Variante' }}
    </button>
    <a href="{{ route('variants.index') }}" class="btn btn-outline-secondary">Annulla</a>
</div>

</form>
@endsection