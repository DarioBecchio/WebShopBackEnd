@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4">Benvenuto, {{ auth()->user()->name }}!</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Post totali</h5>
                <p class="card-text display-6">{{ \App\Models\Post::count() }}</p>
                <a href="{{ route('dashboard.posts.index') }}" class="btn btn-light btn-sm">Gestisci Post</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Post pubblicati</h5>
                <p class="card-text display-6">{{ \App\Models\Post::published()->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-secondary mb-3">
            <div class="card-body">
                <h5 class="card-title">Bozze</h5>
                <p class="card-text display-6">{{ \App\Models\Post::where('status', 'draft')->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection