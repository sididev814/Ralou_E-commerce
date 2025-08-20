@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container my-5">

    <!-- Barre de recherche -->
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('produits') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher un produit..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>
        </div>
    </div>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($produits->take(6) as $index => $produit)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('images/' . $produit->image) }}" class="d-block w-100" alt="{{ $produit->nom }}" style="height:400px; object-fit:cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                    <h5>{{ $produit->nom }}</h5>
                    <p>{{ Str::limit($produit->description, 60) }}</p>
                    <a href="{{ route('produits.detail', $produit->id) }}" class="btn btn-primary btn-sm">Voir le produit</a>
                    @if($produit->promotion)
                        <span class="badge bg-danger ms-2">En solde</span>
                    @elseif($produit->is_new)
                        <span class="badge bg-success ms-2">Nouveau</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <!-- Catégories Populaires -->
    <h2 class="mb-4 text-center">Catégories populaires</h2>
    <div class="row g-4 mb-5">
        @foreach($categories as $categorie)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ isset($categorie->produits[0]) ? asset('images/' . $categorie->produits[0]->image) : asset('images/default.jpg') }}" 
                     class="card-img-top" alt="{{ $categorie->nom }}" style="height:250px; object-fit:cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $categorie->nom }}</h5>
                    <p class="card-text text-muted">{{ $categorie->produits_count ?? 0 }} produits</p>
                    <a href="{{ route('produits.parCategorie', $categorie->id) }}" class="btn btn-primary">Voir les produits</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Nouveautés / Meilleures ventes -->
    <h2 class="mb-4 text-center">Nouveautés & Meilleures ventes</h2>
    <div class="row g-4">
        @foreach($produits as $produit)
        <div class="col-md-3">
            <div class="card h-100 shadow-sm position-relative">
                <img src="{{ asset('images/' . $produit->image) }}" 
                     class="card-img-top" alt="{{ $produit->nom }}" style="height:200px; object-fit:cover;">
                @if($produit->promotion)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">En solde</span>
                @elseif($produit->is_new)
                    <span class="badge bg-success position-absolute top-0 start-0 m-2">Nouveau</span>
                @endif
                <div class="card-body d-flex flex-column text-center">
                    <h6 class="card-title">{{ $produit->nom }}</h6>
                    <p class="mt-auto"><strong>{{ $produit->prix }} MAD</strong></p>
                    <a href="{{ route('produits.detail', $produit->id) }}" class="btn btn-outline-primary btn-sm mt-2">Voir le produit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Call to Action -->
    <div class="my-5 text-center">
        <h3>Découvrez nos promotions exclusives !</h3>
        <a href="{{ route('produits') }}" class="btn btn-lg btn-success mt-3">Voir tous les produits</a>
    </div>

</div>
@endsection
