@extends('layouts.app')

@section('content')
    <h1>Nos Produits</h1>

    <div class="row g-4"> <!-- g-4 ajoute un espacement de 1.5rem entre les colonnes -->
        @foreach ($produits as $produit)
            <div class="col-md-4">
                <a href="{{ route('produits.detail', $produit->id) }}" style="text-decoration: none; color: inherit; width: 100%;">
                    <div class="card h-100" style="width: 100%;">
                        <img src="{{ asset('images/' . $produit->image) }}" 
                             class="card-img-top" 
                             alt="Image produit" 
                             style="height: 380px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text">{{ $produit->description }}</p>
                            <p class="mt-auto"><strong>Prix : {{ $produit->prix }} MAD</strong></p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
