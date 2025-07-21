<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produit;
use App\Models\Commande;

class CommandeSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // On prend le 1er utilisateur

        if (!$user) {
            $this->command->info('Aucun utilisateur trouvé. Veuillez en créer un avant de lancer le seeder.');
            return;
        }

        $produits = Produit::all();

        if ($produits->isEmpty()) {
            $this->command->info('Aucun produit trouvé. Veuillez peupler les produits avant.');
            return;
        }

        // Générer 5 commandes
        for ($i = 0; $i < 5; $i++) {
            $commande = Commande::create([
                'user_id' => $user->id,
                'total' => 0,
                'statut' => 'en cours',
            ]);

            $total = 0;

            // Choisir 2 à 4 produits aléatoires
            $produitsSelectionnes = $produits->random(rand(2, 4));

            foreach ($produitsSelectionnes as $produit) {
                $quantite = rand(1, 5);
                $prix_unitaire = $produit->prix;

                $commande->produits()->attach($produit->id, [
                    'quantite' => $quantite,
                    'prix_unitaire' => $prix_unitaire,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $total += $quantite * $prix_unitaire;
            }

            $commande->update(['total' => $total]);
        }

        $this->command->info('5 commandes générées avec succès pour l’utilisateur : ' . $user->email);
    }
}
