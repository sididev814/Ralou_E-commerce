@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card" style="max-width: 600px;">
            <img src="{{ asset('images/' . $produit->image) }}" 
            class="card-img-top" 
            alt="Image produit" 
            style="height: 270px; object-fit: cover;">
            <div class="card-body">
                <h3 class="card-title">{{ $produit->nom }}</h3>
                <p class="card-text">{{ $produit->description }}</p>
                <p><strong>Prix : </strong>{{ $produit->prix }} MAD</p>

                @php
                    $panier = session('panier', []);
                @endphp

                @if (!isset($panier[$produit->id]))
                    <form action="{{ route('ajouter.panier', $produit->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                    </form>
                @else
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('panier.retirer', $produit->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-secondary" type="submit">-</button>
                        </form>

                        <span class="mx-2">{{ $panier[$produit->id]['quantite'] }}</span>

                        <form action="{{ route('ajouter.panier', $produit->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-secondary" type="submit">+</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
