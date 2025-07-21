<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'stock',
        'image',
        'categorie_produit_id',
    ];

    public function categorie()
    {
        return $this->belongsTo(CategorieProduit::class, 'categorie_produit_id');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'produit_commandes')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
