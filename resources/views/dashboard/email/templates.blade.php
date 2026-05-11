@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Template Email</h1>
    <a href="{{ route('dashboard.email.index') }}" class="btn btn-outline-secondary">← Torna</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>File Blade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr>
                    <td>{{ $template['nome'] }}</td>
                    <td><span class="badge bg-secondary">{{ $template['tipo'] }}</span></td>
                    <td><code>{{ $template['file'] }}</code></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-info mt-4">
    Per modificare un template apri il file Blade corrispondente in
    <code>resources/views/</code> con il tuo editor.
</div>
@endsection