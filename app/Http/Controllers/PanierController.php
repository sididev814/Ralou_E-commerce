<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\Commande;

class PanierController extends Controller
{
    // Affiche tous les produits
    public function produits()
    {
        $produits = Produit::all();
        return view('mespages.produits', compact('produits'));
    }

    // Affiche le contenu du panier
    public function index()
    {
        return view('mespages.panier');
    }

    // Ajouter un produit au panier
    public function ajouter($id)
    {
        $produit = Produit::findOrFail($id);
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite'] += 1;
        } else {
            $panier[$id] = [
                "nom" => $produit->nom,
                "prix" => $produit->prix,
                "quantite" => 1
            ];
        }

        session()->put('panier', $panier);

        return redirect()->back()->with('success', 'Produit ajouté au panier.');
    }

    // Retirer une quantité du produit
    public function retirer($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite'] -= 1;

            if ($panier[$id]['quantite'] <= 0) {
                unset($panier[$id]);
            }

            session()->put('panier', $panier);
        }

        return redirect()->back()->with('success', 'Quantité mise à jour.');
    }

    // Supprimer complètement un produit du panier
    public function supprimerDuPanier($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return redirect()->back()->with('success', 'Produit supprimé du panier.');
    }

    // Valider le panier et créer une commande
    public function validerCommande()
    {
        $panier = session()->get('panier', []);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        if (empty($panier)) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $commande = Commande::create([
            'user_id' => $user->id,
            'total' => 0,
            'statut' => 'en cours'
        ]);

        $total = 0;

        foreach ($panier as $produit_id => $details) {
            $quantite = $details['quantite'];
            $prix = $details['prix'];

            $commande->produits()->attach($produit_id, [
                'quantite' => $quantite,
                'prix_unitaire' => $prix,
            ]);

            $total += $quantite * $prix;
        }

        $commande->update(['total' => $total]);

        // Vider le panier
        session()->forget('panier');

        return redirect()->route('commande.confirmation', ['id' => $commande->id]);
    }
}
