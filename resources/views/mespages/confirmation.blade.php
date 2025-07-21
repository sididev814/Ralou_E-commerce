@extends('layouts.app')

@section('title', 'Confirmation de commande')

@section('content')
<div class="container py-5">
    <h2>🎉 Commande confirmée</h2>

    <p>Merci pour votre achat, {{ Auth::user()->name ?? 'client' }} !</p>

    <ul>
        <li><strong>Numéro :</strong> {{ $commande->id }}</li>
        <li><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y') }}</li>
        <li><strong>Total :</strong> {{ number_format($commande->total, 2, '.', ' ') }} MAD</li>
        <li><strong>Statut :</strong> {{ ucfirst($commande->statut) }}</li>
    </ul>

    <h4>🛍️ Produits commandés :</h4>
    <ul>
        @foreach ($commande->produits as $produit)
            <li>
                {{ $produit->nom }} – 
                {{ $produit->pivot->quantite }} x 
                {{ number_format($produit->pivot->prix_unitaire, 2, '.', ' ') }} MAD
            </li>
        @endforeach
    </ul>

    <div class="mt-4">
        <a href="{{ route('produits') }}" class="btn btn-primary">Retour aux produits</a>
        <a href="{{ route('commandes') }}" class="btn btn-secondary">Voir mes commandes</a>
    </div>
</div>
@endsection
