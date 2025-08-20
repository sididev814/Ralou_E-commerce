@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">Nos Catégories</h1>

    <div class="row">
        @foreach ($categories as $categorie)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    {{-- Image : première image du produit ou image par défaut --}}
                    <div style="height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="{{ isset($categorie->produits[0]) ? asset('images/' . $categorie->produits[0]->image) : asset('images/default.jpg') }}" 
                             alt="{{ $categorie->nom }}"
                             style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    </div>

                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $categorie->nom }}</h5>
                        <p class="card-text text-muted">
                            {{ $categorie->produits_count ?? 0 }} produits disponibles
                        </p>
                        <a href="{{ route('produits.parCategorie', $categorie->id) }}" 
                           class="btn btn-primary">
                            Voir les produits
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
