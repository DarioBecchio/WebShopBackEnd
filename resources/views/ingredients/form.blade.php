@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $ingredient->exists ? 'Modifica Ingrediente' : 'Nuovo Ingrediente' }}</h2>
    <a href="{{ route('ingredients.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST"
              action="{{ $ingredient->exists ? route('ingredients.update', $ingredient) : route('ingredients.store') }}">
            @csrf
            @if($ingredient->exists) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nome INCI *</label>
                    <input type="text" name="inci_name"
                           value="{{ old('inci_name', $ingredient->inci_name) }}"
                           class="form-control font-monospace @error('inci_name') is-invalid @enderror"
                           placeholder="Es. AQUA, NIACINAMIDE">
                    @error('inci_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Nome comune</label>
                    <input type="text" name="common_name"
                           value="{{ old('common_name', $ingredient->common_name) }}"
                           class="form-control" placeholder="Es. Vitamina C, Acido ialuronico">
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Funzione</label>
                    <textarea name="function_description" rows="3"
                              class="form-control"
                              placeholder="Es. Emolliente, conservante, agente attivo...">{{ old('function_description', $ingredient->function_description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="hidden" name="is_allergen" value="0">
                        <input type="checkbox" name="is_allergen" id="is_allergen" value="1"
                               class="form-check-input"
                               {{ old('is_allergen', $ingredient->is_allergen) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_allergen">
                            Allergene regolamentato UE
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="hidden" name="is_endocrine_disruptor" value="0">
                        <input type="checkbox" name="is_endocrine_disruptor" id="is_endocrine_disruptor" value="1"
                               class="form-check-input"
                               {{ old('is_endocrine_disruptor', $ingredient->is_endocrine_disruptor) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_endocrine_disruptor">
                            Potenziale distruttore endocrino
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ $ingredient->exists ? 'Salva modifiche' : 'Crea Ingrediente' }}
                </button>
                <a href="{{ route('ingredients.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
    </div>
</div>

@endsection