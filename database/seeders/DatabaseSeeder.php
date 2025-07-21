<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création d'un utilisateur test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Appel des seeders personnalisés
        $this->call([
            CategorieProduitSeeder::class,
            ProduitSeeder::class,
            CommandeSeeder::class, // Ajout du seeder CommandeSeeder ici
        ]);
    }
}
