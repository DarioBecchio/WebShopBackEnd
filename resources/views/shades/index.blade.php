@extends('layouts.cosmetici')

@section('cosmetici-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Tonalità</h2>
    <a href="{{ route('shades.create') }}" class="btn btn-primary btn-sm">+ Nuova Tonalità</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cerca tonalità..." class="form-control form-control-sm w-auto">
    <button class="btn btn-outline-secondary btn-sm">Cerca</button>
    @if(request('search'))
        <a href="{{ route('shades.index') }}" class="btn btn-outline-danger btn-sm">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Colore</th>
                    <th>Nome</th>
                    <th>Famiglia</th>
                    <th>Finish</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($shades as $shade)
                <tr>
                    <td>
                        @if($shade->hex_color)
                            <span class="d-inline-block rounded border"
                                  style="width:28px;height:28px;background:{{ $shade->hex_color }}"></span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="fw-medium">{{ $shade->name }}</td>
                    <td>{{ $shade->family?->name ?? '—' }}</td>
                    <td>{{ $shade->finish?->label ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('shades.edit', $shade) }}"
                           class="btn btn-outline-primary btn-sm">Modifica</a>
                        <form method="POST" action="{{ route('shades.destroy', $shade) }}"
                              class="d-inline" onsubmit="return confirm('Eliminare questa tonalità?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Nessuna tonalità trovata.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shades->hasPages())
        <div class="card-footer">{{ $shades->links() }}</div>
    @endif
</div>

@endsection