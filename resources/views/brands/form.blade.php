@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $brand->exists ? 'Modifica Brand' : 'Nuovo Brand' }}</h2>
    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST"
              action="{{ $brand->exists ? route('brands.update', $brand) : route('brands.store') }}">
            @csrf
            @if($brand->exists) @method('PUT') @endif

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-medium">Nome *</label>
                    <input type="text" name="name" value="{{ old('name', $brand->name) }}"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Codice paese (es. IT, FR)</label>
                    <input type="text" name="country_code" maxlength="2"
                           value="{{ old('country_code', $brand->country_code) }}"
                           class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Sito Web</label>
                    <input type="url" name="website_url"
                           value="{{ old('website_url', $brand->website_url) }}"
                           placeholder="https://..."
                           class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Descrizione</label>
                    <textarea name="description" rows="3"
                              class="form-control">{{ old('description', $brand->description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="hidden" name="is_cruelty_free" value="0">
                        <input type="checkbox" name="is_cruelty_free" id="cruelty_free" value="1"
                               class="form-check-input"
                               {{ old('is_cruelty_free', $brand->is_cruelty_free) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cruelty_free">Cruelty Free</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="hidden" name="is_vegan" value="0">
                        <input type="checkbox" name="is_vegan" id="is_vegan" value="1"
                               class="form-check-input"
                               {{ old('is_vegan', $brand->is_vegan) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_vegan">Vegan</label>
                    </div>
                </div>

            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ $brand->exists ? 'Salva modifiche' : 'Crea Brand' }}
                </button>
                <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>

        </form>
    </div>
</div>

@endsection