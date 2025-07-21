<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategorieProduit;

class CategorieProduitSeeder extends Seeder
{
    public function run(): void
    {
        $noms = ['Informatique', 'Électroménager', 'Vêtements', 'Livres', 'Mobilier'];

        foreach ($noms as $nom) {
            CategorieProduit::create(['nom' => $nom]);
        }
    }
}
