@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Modifica Post</h1>
    <a href="{{ route('dashboard.posts.index') }}" class="btn btn-secondary">← Torna ai Post</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('dashboard.posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Titolo *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contenuto *</label>
                <textarea name="content" rows="8" 
                          class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" name="category" class="form-control" 
                           value="{{ old('category', $post->category) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stato *</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Bozza</option>
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Pubblicato</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Immagine</label>
                @if($post->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($post->image) }}" alt="Immagine post" 
                             class="img-thumbnail" style="max-height: 200px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                       accept="image/*">
                <div class="form-text">Carica una nuova immagine per sostituire quella attuale.</div>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Aggiorna Post</button>
        </form>
    </div>
</div>
@endsection