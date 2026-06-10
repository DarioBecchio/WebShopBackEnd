@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $shade->exists ? 'Modifica Tonalità' : 'Nuova Tonalità' }}</h2>
    <a href="{{ route('shades.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<div class="card"><div class="card-body">
    <form method="POST"
          action="{{ $shade->exists ? route('shades.update', $shade) : route('shades.store') }}">
        @csrf
        @if($shade->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-medium">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $shade->name) }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Es. Cherry Red, Nude Beige">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label fw-medium">Colore HEX</label>
                <div class="input-group">
                    <input type="color" name="hex_color"
                           value="{{ old('hex_color', $shade->hex_color ?? '#ffffff') }}"
                           class="form-control form-control-color">
                    <input type="text" id="hex_text"
                           value="{{ old('hex_color', $shade->hex_color) }}"
                           class="form-control @error('hex_color') is-invalid @enderror"
                           placeholder="#RRGGBB" maxlength="7">
                </div>
                @error('hex_color') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label fw-medium">Famiglia *</label>
                <select name="shade_family_id"
                        class="form-select @error('shade_family_id') is-invalid @enderror">
                    <option value="">— Seleziona —</option>
                    @foreach($families as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('shade_family_id', $shade->shade_family_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('shade_family_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Finish</label>
                <select name="finish_id" class="form-select">
                    <option value="">— Nessuno —</option>
                    @foreach($finishes as $id => $label)
                        <option value="{{ $id }}"
                            {{ old('finish_id', $shade->finish_id) == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ $shade->exists ? 'Salva modifiche' : 'Crea Tonalità' }}
            </button>
            <a href="{{ route('shades.index') }}" class="btn btn-outline-secondary">Annulla</a>
        </div>
    </form>
</div></div>

<script>
    // Sincronizza il color picker con il campo testo
    const colorPicker = document.querySelector('input[type=color]');
    const hexText     = document.getElementById('hex_text');
    colorPicker.addEventListener('input', () => {
        hexText.value = colorPicker.value;
        colorPicker.name = ''; // evita doppio invio
    });
    hexText.addEventListener('input', () => {
        if (/^#[0-9A-Fa-f]{6}$/.test(hexText.value)) {
            colorPicker.value = hexText.value;
        }
        hexText.name = 'hex_color';
    });
</script>

@endsection