<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','paiement_effectue', 'total', 'statut'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_commandes')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
