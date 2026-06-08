@extends('layouts.dashboard')

@section('content')
<div class="row">

    {{-- Sidebar --}}
    <div class="col-md-2">
        <div class="list-group mb-4">
            <div class="list-group-item list-group-item-dark fw-bold">
                💄 Cosmetici
            </div>
            @php
                $links = [
                    ['route' => 'brands.index',         'label' => '🏷 Brand'],
                    ['route' => 'categories.index',     'label' => '📂 Categorie'],
                    ['route' => 'products.index',       'label' => '🧴 Prodotti'],
                    ['route' => 'variants.index',       'label' => '🎨 Varianti'],
                    ['route' => 'ingredients.index',    'label' => '🧪 Ingredienti'],
                    ['route' => 'shades.index',         'label' => '🎨 Tonalità'],
                    ['route' => 'claims.index',         'label' => '✅ Claim'],
                    ['route' => 'certifications.index', 'label' => '🏅 Certificazioni'],
                ];
            @endphp
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="list-group-item list-group-item-action
                          {{ request()->routeIs($link['route'].'*') ? 'active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Contenuto --}}
    <div class="col-md-10">
        @yield('cosmetici-content')
    </div>

</div>
@endsection