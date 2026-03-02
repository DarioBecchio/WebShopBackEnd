@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Nuovo Post</h1>
    <a href="{{ route('dashboard.posts.index') }}" class="btn btn-secondary">← Torna ai Post</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('dashboard.posts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Titolo *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contenuto *</label>
                <textarea name="content" rows="8" 
                          class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stato *</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Bozza</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Pubblicato</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Immagine</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                       accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Salva Post</button>
        </form>
    </div>
</div>
@endsection