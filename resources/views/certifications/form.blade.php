@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $certification->exists ? 'Modifica Certificazione' : 'Nuova Certificazione' }}</h2>
    <a href="{{ route('certifications.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<div class="card"><div class="card-body">
    <form method="POST" action="{{ $certification->exists ? route('certifications.update', $certification) : route('certifications.store') }}">
        @csrf
        @if($certification->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">Codice *</label>
                <input type="text" name="code" value="{{ old('code', $certification->code) }}"
                       class="form-control @error('code') is-invalid @enderror">
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-8">
                <label class="form-label fw-medium">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $certification->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Ente certificatore</label>
                <input type="text" name="issuing_body" value="{{ old('issuing_body', $certification->issuing_body) }}"
                       class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">URL Logo</label>
                <input type="url" name="logo_url" value="{{ old('logo_url', $certification->logo_url) }}"
                       class="form-control" placeholder="https://...">
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ $certification->exists ? 'Salva modifiche' : 'Crea Certificazione' }}
            </button>
            <a href="{{ route('certifications.index') }}" class="btn btn-outline-secondary">Annulla</a>
        </div>
    </form>
</div></div>

@endsection