<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;

class CommandeController extends Controller
{
    // 1. Historique des commandes
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $commandes = Commande::where('user_id', $user->id)
                    ->with('produits')
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('mespages.commandes', compact('commandes'));
    }

    // 2. Page de confirmation après commande
    public function confirmation($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $commande = Commande::where('id', $id)
            ->where('user_id', $user->id)
            ->with('produits')
            ->first();

        if (!$commande) {
            return redirect()->route('commandes')->with('error', 'Commande introuvable.');
        }

        return view('mespages.confirmation', compact('commande'));
    }
    // 3. Validation de commande (seulement si paiement simulé)
public function validerCommande(Request $request)
{
    if (!session('paiement_ok')) {
        return redirect()->back()->with('error', 'Veuillez effectuer un paiement avant de valider votre commande.');
    }

    // Ici tu peux insérer les données de la commande en BDD si besoin
    // $commande = Commande::create([...]);

    session()->forget('paiement_ok'); // Réinitialiser après commande
    session()->forget('panier'); // Vider le panier après validation

    return redirect()->route('commandes')->with('success', 'Commande validée avec succès.');
}

}
