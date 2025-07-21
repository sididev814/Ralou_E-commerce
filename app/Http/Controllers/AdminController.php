<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Commande;
use App\Models\User;
use App\Models\CategorieProduit;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord de l'administrateur
     */
    public function dashboard()
    {
        $nombreProduits = Produit::count();
        $nombreCommandes = Commande::count();
        $nombreUsers = User::count();
        $nombreCategories = CategorieProduit::count();

        return view('admin.dashboard', compact(
            'nombreProduits',
            'nombreCommandes',
            'nombreUsers',
            'nombreCategories'
        ));
    }

    /**
     * Liste des produits
     */
    public function produitsIndex()
    {
        $produits = Produit::latest()->paginate(10);
        return view('admin.produits.index', compact('produits'));
    }

    /**
     * Liste des catégories
     */
    public function categoriesIndex()
    {
        $categories = CategorieProduit::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Liste des commandes
     */
    public function commandesIndex()
    {
        $commandes = Commande::latest()->paginate(10);
        return view('admin.commandes.index', compact('commandes'));
    }
}
