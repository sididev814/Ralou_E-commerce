<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use App\Models\CategorieProduit;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $categories = CategorieProduit::all();

        $produits = [
            ['Ordinateur HP', 'PC portable, 8Go RAM', 799.99, 10, 'hp.png', 'Informatique'],
            ['Imprimante Canon', 'Jet d’encre couleur', 149.00, 5, 'canon.png', 'Informatique'],
            ['Lave-linge Bosch', '9kg, classe A++', 499.50, 3, 'bosch.png', 'Électroménager'],
            ['Micro-ondes Samsung', '700W, grill', 89.90, 8, 'samsung.png', 'Électroménager'],
            ['T-shirt coton', 'Taille M, blanc', 19.99, 20, 'shirt.png', 'Vêtements'],
            ['Jeans homme', 'Taille 42, bleu foncé', 39.99, 15, 'jeans.png', 'Vêtements'],
            ['Le Petit Prince', 'Livre pour enfants', 8.50, 50, 'livre1.png', 'Livres'],
            ['1984 - Orwell', 'Roman dystopique', 12.00, 25, 'livre2.png', 'Livres'],
            ['Chaise de bureau', 'Ergonomique, noire', 129.99, 6, 'chaise.png', 'Mobilier'],
            ['Table basse bois', '80x80 cm', 179.90, 4, 'table.png', 'Mobilier']
        ];

        foreach ($produits as [$nom, $desc, $prix, $stock, $image, $catNom]) {
            $cat = $categories->where('nom', $catNom)->first();

            if ($cat) {
                Produit::create([
                    'nom' => $nom,
                    'description' => $desc,
                    'prix' => $prix,
                    'stock' => $stock,
                    'image' => $image,
                    'categorie_produit_id' => $cat->id,
                ]);
            }
        }
    }
}
