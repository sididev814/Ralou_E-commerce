<?php
namespace App\Http\Controllers;

use App\Models\CategorieProduit;
use App\Models\Produit;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        $categories = CategorieProduit::withCount('produits')->with('produits')->get();

        // Si recherche, filtrer les produits
        $query = Produit::query();
        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }
        $produits = $query->latest()->take(12)->get();

        return view('mespages.acceuil', compact('categories', 'produits'));
    }
}
