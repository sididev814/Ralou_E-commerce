<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CategorieProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaiementController;
/*
|--------------------------------------------------------------------------
| Page d’accueil
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('mespages.acceuil');
})->name('accueil');

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'toLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
Route::get('/produits', [ProduitController::class, 'index'])->name('produits');
Route::get('/produits/{id}', [ProduitController::class, 'detail'])->name('produits.detail');
Route::get('/categories', [CategorieProduitController::class, 'index'])->name('categories.index');
Route::get('/panier', [PanierController::class, 'index'])->name('panier');

// Pages statiques
Route::view('/mentions-legales', 'mespages.mentions')->name('mentions');
Route::view('/contact', 'mespages.contact')->name('contact');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
/*
|--------------------------------------------------------------------------
| Routes protégées (authentifiés)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Panier
    Route::post('/ajouter-au-panier/{id}', [PanierController::class, 'ajouter'])->name('ajouter.panier');
    Route::post('/retirer-du-panier/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');
    Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimerDuPanier'])->name('supprimer.panier');
    Route::post('/panier/valider', [PanierController::class, 'validerCommande'])->name('valider.commande');
    Route::post('/paiement/simuler', [PaiementController::class, 'simuler'])->name('paiement.simuler');
    // Compte utilisateur
    Route::get('/compte', function () {
        return view('mespages.compte');
    })->name('compte');

    // Commandes
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes');
    Route::get('/commande/confirmation/{id}', [CommandeController::class, 'confirmation'])->name('commande.confirmation');
});

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Produits
    Route::get('/produits', [ProduitController::class, 'adminIndex'])->name('produits.index');
    Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
    Route::get('/produits/{id}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{id}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy'])->name('produits.destroy');

    // CRUD Catégories
    Route::get('/categories', [CategorieProduitController::class, 'adminIndex'])->name('categories.index');
    Route::get('/categories/create', [CategorieProduitController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategorieProduitController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategorieProduitController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategorieProduitController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategorieProduitController::class, 'destroy'])->name('categories.destroy');

    // Liste des commandes
    Route::get('/commandes', [CommandeController::class, 'adminIndex'])->name('commandes.index');
});
