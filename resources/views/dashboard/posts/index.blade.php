@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Post</h1>
    <a href="{{ route('dashboard.posts.create') }}" class="btn btn-primary">+ Nuovo Post</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Titolo</th>
                    <th>Categoria</th>
                    <th>Stato</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category ?? '-' }}</td>
                    <td>
                        @if($post->status === 'published')
                            <span class="badge bg-success">Pubblicato</span>
                        @else
                            <span class="badge bg-secondary">Bozza</span>
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('dashboard.posts.edit', $post) }}" 
                           class="btn btn-sm btn-warning">Modifica</a>
                        <form method="POST" 
                              action="{{ route('dashboard.posts.destroy', $post) }}" 
                              class="d-inline"
                              onsubmit="return confirm('Sei sicuro di voler eliminare questo post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Nessun post trovato</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $posts->links() }}
</div>
@endsection