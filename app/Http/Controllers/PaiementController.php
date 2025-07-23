<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    public function simuler(Request $request)
    {
        $data = $request->validate([
            'telephone' => 'required|string|min:8|max:15',
            'montant'   => 'required|numeric|min:100',
            'operateur' => 'required|string|in:Moov,Airtel,OrangeMoney',
        ]);

        $panier = session('panier');
        if (!$panier || count($panier) === 0) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // ✅ Calcul du total du panier
        $total = 0;
        foreach ($panier as $produit) {
            $total += $produit['prix'] * $produit['quantite'];
        }

        // ✅ Création du paiement simulé
        $paiement = Paiement::create([
            'telephone'      => $data['telephone'],
            'montant'        => $total,
            'operateur'      => $data['operateur'],
            'statut'         => 'Réussi',
            'transaction_id' => strtoupper(Str::random(10)),
        ]);

        // ✅ Création de la commande après paiement
        $commande = Commande::create([
            'user_id'           => Auth::id(),
            'paiement_id'       => $paiement->id,
            'statut'            => 'Confirmée',
            'paiement_effectue' => true,
            'total'             => $total,
        ]);

        // ✅ Ajout des produits à la commande
        foreach ($panier as $produit_id => $produit) {
            $commande->produits()->attach($produit_id, [
                'quantite'      => $produit['quantite'],
                'prix_unitaire' => $produit['prix'],
            ]);
        }

        // ✅ Nettoyage du panier
        session()->forget('panier');

        // ✅ Rediriger automatiquement vers la confirmation
        session()->put('derniere_commande_id', $commande->id);
        return redirect()->route('commande.confirmation', ['id' => $commande->id])->with('success', '✅ Paiement réussi. Commande confirmée.');
    }
}
