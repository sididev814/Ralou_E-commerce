<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $commandes = Commande::where('user_id', $user->id)
                    ->with('produits')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('mespages.commandes', compact('commandes'));
    }

    public function confirmation()
    {
        $commandeId = session('derniere_commande_id');

        if (!$commandeId) {
            return redirect()->route('produits')->with('error', 'Aucune commande à afficher.');
        }

        $commande = Commande::where('id', $commandeId)
            ->where('user_id', Auth::id())
            ->with('produits')
            ->first();

        if (!$commande) {
            return redirect()->route('produits')->with('error', 'Commande introuvable.');
        }

        session()->forget('derniere_commande_id');

        return view('mespages.confirmation', compact('commande'));
    }
}
