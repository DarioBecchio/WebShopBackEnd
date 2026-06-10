@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $claim->exists ? 'Modifica Claim' : 'Nuovo Claim' }}</h2>
    <a href="{{ route('claims.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<div class="card"><div class="card-body">
    <form method="POST" action="{{ $claim->exists ? route('claims.update', $claim) : route('claims.store') }}">
        @csrf
        @if($claim->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">Codice *</label>
                <input type="text" name="code" value="{{ old('code', $claim->code) }}"
                       class="form-control @error('code') is-invalid @enderror"
                       placeholder="es. paraben-free">
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Label *</label>
                <input type="text" name="label" value="{{ old('label', $claim->label) }}"
                       class="form-control @error('label') is-invalid @enderror">
                @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Categoria</label>
                <input type="text" name="category" value="{{ old('category', $claim->category) }}"
                       class="form-control" placeholder="es. ingredient, spf, eco">
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ $claim->exists ? 'Salva modifiche' : 'Crea Claim' }}
            </button>
            <a href="{{ route('claims.index') }}" class="btn btn-outline-secondary">Annulla</a>
        </div>
    </form>
</div></div>

@endsection