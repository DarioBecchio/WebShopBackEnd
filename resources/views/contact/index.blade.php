<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contattaci - {{ config('app.name') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<div class="container py-5" style="max-width: 700px">
    <h1 class="mb-2">Contattaci</h1>
    <p class="text-muted mb-4">Compila il modulo e ti risponderemo entro 24-48 ore lavorative.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('contact.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()?->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', auth()->user()?->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo di richiesta *</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">Seleziona...</option>
                        <option value="complaint"  {{ old('type') === 'complaint'  ? 'selected' : '' }}>Reclamo</option>
                        <option value="return"     {{ old('type') === 'return'     ? 'selected' : '' }}>Richiesta reso</option>
                        <option value="order"      {{ old('type') === 'order'      ? 'selected' : '' }}>Problema ordine</option>
                        <option value="info"       {{ old('type') === 'info'       ? 'selected' : '' }}>Informazioni</option>
                        <option value="other"      {{ old('type') === 'other'      ? 'selected' : '' }}>Altro</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Oggetto *</label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                           value="{{ old('subject') }}" placeholder="Es. Problema con ordine #ORD-123">
                    @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Messaggio *</label>
                    <textarea name="message" rows="5"
                              class="form-control @error('message') is-invalid @enderror"
                              placeholder="Descrivi la tua richiesta nel dettaglio...">{{ old('message') }}</textarea>
                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Invia messaggio</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>