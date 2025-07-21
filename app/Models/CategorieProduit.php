<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieProduit extends Model
{
    use HasFactory;

    protected $table = 'categorie_produits';

    protected $fillable = [
        'nom',
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_produit_id');
    }
}
