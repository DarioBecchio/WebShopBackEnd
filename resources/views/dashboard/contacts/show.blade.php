@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Messaggio da {{ $contact->name }}</h1>
    <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-outline-secondary">← Torna</a>
</div>

<div class="row">
    {{-- Messaggio --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <span>
                    <span class="badge bg-{{ $contact->typeColor() }}">{{ $contact->typeLabel() }}</span>
                    {{ $contact->subject }}
                </span>
                <small class="text-muted">{{ $contact->created_at->format('d/m/Y H:i') }}</small>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $contact->message }}</p>
            </div>
        </div>

        @if($contact->admin_reply)
        <div class="card mb-4 border-success">
            <div class="card-header bg-success text-white">La tua risposta</div>
            <div class="card-body">
                <p class="mb-0">{{ $contact->admin_reply }}</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="col-md-4">
        {{-- Info mittente --}}
        <div class="card mb-4">
            <div class="card-header">Mittente</div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $contact->name }}</strong></p>
                <p class="mb-1 text-muted">{{ $contact->email }}</p>
                @if($contact->user)
                    <p class="mb-0">
                        <small class="text-muted">Utente registrato</small>
                    </p>
                @else
                    <p class="mb-0">
                        <small class="text-muted">Utente non registrato</small>
                    </p>
                @endif
            </div>
        </div>

        {{-- Gestione --}}
        <div class="card">
            <div class="card-header">Gestisci</div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.contacts.update', $contact) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Stato</label>
                        <select name="status" class="form-select">
                            <option value="new"         {{ $contact->status === 'new'         ? 'selected' : '' }}>Nuovo</option>
                            <option value="in_progress" {{ $contact->status === 'in_progress' ? 'selected' : '' }}>In gestione</option>
                            <option value="resolved"    {{ $contact->status === 'resolved'    ? 'selected' : '' }}>Risolto</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note interne</label>
                        <textarea name="admin_reply" rows="4" class="form-control"
                                  placeholder="Note di gestione...">{{ $contact->admin_reply }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Salva</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection