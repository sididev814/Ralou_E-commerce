@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1>🛒 Mon Panier</h1>

    @if (session()->has('panier') && count(session('panier')) > 0)
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach (session('panier') as $id => $details)
                    @php $total += $details['prix'] * $details['quantite']; @endphp
                    <tr>
                        <td>{{ $details['nom'] }}</td>
                        <td class="d-flex align-items-center">
                            <!-- Diminuer -->
                            <form action="{{ route('panier.retirer', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" type="submit">-</button>
                            </form>

                            <span class="mx-2">{{ $details['quantite'] }}</span>

                            <!-- Augmenter -->
                            <form action="{{ route('ajouter.panier', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" type="submit">+</button>
                            </form>
                        </td>
                        <td>{{ $details['prix'] }} MAD</td>
                        <td>{{ $details['prix'] * $details['quantite'] }} MAD</td>
                        <td>
                            <form action="{{ route('supprimer.panier', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                <tr class="table-info">
                    <td colspan="3" class="text-end"><strong>Total :</strong></td>
                    <td colspan="2"><strong>{{ $total }} MAD</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Formulaire de validation de commande -->
        <form action="{{ route('valider.commande') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">✅ Valider la commande</button>
        </form>

    @else
        <p class="text-muted">Votre panier est vide.</p>
    @endif
</div>
@endsection
