<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paiement_id',       // <-- ajouter ce champ pour la relation
        'total',
        'statut',
        'paiement_effectue',
    ];

    // Relation vers User (propriétaire de la commande)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers Paiement
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    // Relation vers produits (pivot produit_commandes)
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_commandes')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
