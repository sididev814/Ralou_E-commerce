@extends('layouts.app')

@section('title', 'Confirmation de commande')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3 class="text-success mb-2">
        <i class="bi bi-bag-check-fill me-2"></i>Commande confirmée
    </h3>

    <p class="mb-3">Merci pour votre achat, <strong>{{ Auth::user()->name ?? 'client' }}</strong> !</p>

    {{-- Détails commande --}}
    <table class="table table-borderless table-sm w-100 mb-3">
        <tr>
            <td><strong>Numéro :</strong></td>
            <td>#{{ $commande->id }}</td>
        </tr>
        <tr>
            <td><strong>Date :</strong></td>
            <td>{{ $commande->created_at ? $commande->created_at->format('d/m/Y à H:i') : 'Non disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Total :</strong></td>
            <td>{{ number_format($commande->total, 2, '.', ' ') }} MAD</td>
        </tr>
        <tr>
            <td><strong>Statut :</strong></td>
            <td><span class="badge bg-success">{{ ucfirst($commande->statut) }}</span></td>
        </tr>
    </table>

    {{-- Produits --}}
    <h5 class="mt-4 mb-2">🛍️ Produits commandés :</h5>
    @if ($commande->produits->count() > 0)
        <ul class="list-group list-group-flush mb-3">
            @foreach ($commande->produits as $produit)
                <li class="list-group-item py-2 px-3">
                    {{ $produit->nom }} — 
                    {{ $produit->pivot->quantite }} x 
                    {{ number_format($produit->pivot->prix_unitaire, 2, '.', ' ') }} MAD
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">Aucun produit trouvé pour cette commande.</p>
    @endif

    {{-- Boutons --}}
    <div class="mt-3">
        <a href="{{ route('produits') }}" class="btn btn-outline-primary btn-sm me-3">
            <i class="bi bi-box-arrow-left me-1"></i>Retour aux produits
        </a>
        <a href="{{ route('commandes') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-receipt me-1"></i>Voir mes commandes
        </a>
    </div>

</div>
@endsection
