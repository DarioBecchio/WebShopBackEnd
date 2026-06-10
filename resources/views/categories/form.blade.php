@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">{{ $category->exists ? 'Modifica Categoria' : 'Nuova Categoria' }}</h2>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">← Torna alla lista</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST"
              action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
            @csrf
            @if($category->exists) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-medium">Nome *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Categoria padre</label>
                    <select name="parent_id" class="form-select">
                        <option value="">— Nessuna (categoria radice) —</option>
                        @foreach($parents as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('parent_id', $category->parent_id) == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ $category->exists ? 'Salva modifiche' : 'Crea Categoria' }}
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
    </div>
</div>

@endsection