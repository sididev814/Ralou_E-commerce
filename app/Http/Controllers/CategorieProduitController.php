<?php

namespace App\Http\Controllers;

use App\Models\CategorieProduit;

class CategorieProduitController extends Controller
{
    public function index()
    {
        // On charge les catégories avec le nombre de produits et les produits eux-mêmes
        $categories = CategorieProduit::withCount('produits')
                                      ->with('produits') // charge les produits pour récupérer l'image
                                      ->get();

        return view('mespages.categories', compact('categories'));
    }
}
