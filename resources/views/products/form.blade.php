@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $product->exists ? 'Modifica Prodotto' : 'Nuovo Prodotto' }}</h2>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<form method="POST"
      action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
@csrf
@if($product->exists) @method('PUT') @endif

{{-- Dati base --}}
<div class="card mb-4">
    <div class="card-header fw-medium">Dati base</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">SKU *</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                       class="form-control font-monospace @error('sku') is-invalid @enderror">
                @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Brand *</label>
                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                    <option value="">— Seleziona —</option>
                    @foreach($brands as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('brand_id', $product->brand_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Categoria *</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">— Seleziona —</option>
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Linea prodotto</label>
                <select name="product_line_id" class="form-select">
                    <option value="">— Nessuna —</option>
                    @foreach($productLines as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('product_line_id', $product->product_line_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Tipo di pelle</label>
                <select name="skin_type_id" class="form-select">
                    <option value="">— Tutti —</option>
                    @foreach($skinTypes as $id => $label)
                        <option value="{{ $id }}"
                            {{ old('skin_type_id', $product->skin_type_id) == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-medium">Data lancio</label>
                <input type="date" name="launched_at"
                       value="{{ old('launched_at', $product->launched_at?->format('Y-m-d')) }}"
                       class="form-control">
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="form-check-input"
                           {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Prodotto attivo</label>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Traduzione italiana --}}
<div class="card mb-4">
    <div class="card-header fw-medium">Testi (italiano)</div>
    <div class="card-body">
        @php $trans = $product->translations->firstWhere('locale','it'); @endphp
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-medium">Nome prodotto *</label>
                <input type="text" name="trans_name"
                       value="{{ old('trans_name', $trans?->name) }}"
                       class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label fw-medium">Descrizione breve</label>
                <input type="text" name="trans_short_description"
                       value="{{ old('trans_short_description', $trans?->short_description) }}"
                       class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label fw-medium">Descrizione completa</label>
                <textarea name="trans_description" rows="3"
                          class="form-control">{{ old('trans_description', $trans?->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-medium">Come si usa</label>
                <textarea name="trans_how_to_use" rows="2"
                          class="form-control">{{ old('trans_how_to_use', $trans?->how_to_use) }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- Claim --}}
<div class="card mb-4">
    <div class="card-header fw-medium">Claim</div>
    <div class="card-body">
        <div class="row row-cols-2 row-cols-md-3 g-2">
            @foreach($allClaims as $claim)
            <div class="col">
                <div class="form-check">
                    <input type="checkbox" name="claim_ids[]" value="{{ $claim->id }}"
                           id="claim_{{ $claim->id }}" class="form-check-input"
                           {{ in_array($claim->id, old('claim_ids', $product->claims->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="claim_{{ $claim->id }}">
                        {{ $claim->label }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Certificazioni --}}
<div class="card mb-4">
    <div class="card-header fw-medium">Certificazioni</div>
    <div class="card-body">
        <div class="row row-cols-2 row-cols-md-3 g-2">
            @foreach($allCerts as $cert)
            <div class="col">
                <div class="form-check">
                    <input type="checkbox" name="certification_ids[]" value="{{ $cert->id }}"
                           id="cert_{{ $cert->id }}" class="form-check-input"
                           {{ in_array($cert->id, old('certification_ids', $product->certifications->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="cert_{{ $cert->id }}">
                        {{ $cert->name }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Skin concerns --}}
<div class="card mb-4">
    <div class="card-header fw-medium">Problematiche pelle</div>
    <div class="card-body">
        <div class="row row-cols-2 row-cols-md-3 g-2">
            @foreach($allConcerns as $concern)
            <div class="col">
                <div class="form-check">
                    <input type="checkbox" name="skin_concern_ids[]" value="{{ $concern->id }}"
                           id="concern_{{ $concern->id }}" class="form-check-input"
                           {{ in_array($concern->id, old('skin_concern_ids', $product->skinConcerns->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="concern_{{ $concern->id }}">
                        {{ $concern->label }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex gap-2 mb-4">
    <button type="submit" class="btn btn-primary">
        {{ $product->exists ? 'Salva modifiche' : 'Crea Prodotto' }}
    </button>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Annulla</a>
</div>

</form>
@endsection