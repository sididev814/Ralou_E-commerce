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
        <table class="table">
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
                            <form action="{{ route('panier.retirer', $id) }}" method="POST" class="me-2">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" type="submit">-</button>
                            </form>

                            <span>{{ $details['quantite'] }}</span>

                            <form action="{{ route('ajouter.panier', $id) }}" method="POST" class="ms-2">
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

        <!-- Boutons en dehors du tableau -->
        <div class="d-flex justify-content-between mt-4">
            <!-- Bouton Valider commande -->
            <!-- <form action="{{ route('valider.commande') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success" {{ session('paiement_effectue') ? '' : 'disabled' }}>
                    ✅ Valider la commande
                </button>
                @if (!session('paiement_effectue'))
                    <small class="text-danger ms-2">💡 Faites d'abord le paiement.</small>
                @endif
            </form> -->

            <!-- Bouton Paiement -->
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#paiementModal">
                💳 Payer maintenant
            </button>
        </div>

        <!-- Modal Bootstrap pour paiement -->
        <div class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="paiementModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('paiement.simuler') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paiementModalLabel">Informations de Paiement Mobile Money</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="telephone">Numéro de téléphone</label>
                            <input type="text" name="telephone" class="form-control" placeholder="Ex: 90909090" required>
                        </div>
                        <div class="mb-3">
                            <label for="operateur">Opérateur Mobile Money</label>
                            <select name="operateur" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="OrangeMoney">Orange Money</option>
                                <option value="Airtel">Airtel Money</option>
                                <option value="Moov">Moov Money</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="montant">Montant</label>
                            <input type="number" name="montant" class="form-control" value="{{ $total }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">✅ Confirmer le paiement</button>
                    </div>
                </div>
            </form>
          </div>
        </div>

    @else
        <p class="text-muted">Votre panier est vide.</p>
    @endif
</div>
@endsection
