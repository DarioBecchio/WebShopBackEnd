@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Invia Newsletter</h1>
    <a href="{{ route('dashboard.email.index') }}" class="btn btn-outline-secondary">← Torna</a>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted mb-4">Verrà inviata a <strong>{{ $iscritti }}</strong> utenti iscritti.</p>

        <form method="POST" action="{{ route('dashboard.email.newsletter.send') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Oggetto *</label>
                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                       value="{{ old('subject') }}" placeholder="Es. Offerta speciale maggio 2026">
                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Testo *</label>
                <textarea name="body" rows="6" class="form-control @error('body') is-invalid @enderror"
                          placeholder="Scrivi il contenuto della newsletter...">{{ old('body') }}</textarea>
                @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">URL pulsante (opzionale)</label>
                    <input type="url" name="cta_url" class="form-control"
                           value="{{ old('cta_url') }}" placeholder="https://tuosito.it/promozioni">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Testo pulsante</label>
                    <input type="text" name="cta_label" class="form-control"
                           value="{{ old('cta_label', 'Scopri di più') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary"
                    onclick="return confirm('Inviare la newsletter a {{ $iscritti }} utenti?')">
                Invia Newsletter
            </button>
        </form>
    </div>
</div>
@endsection
