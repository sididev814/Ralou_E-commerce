<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'telephone',
        'montant',
        'operateur',
        'statut',
        'transaction_id',
    ];

    // Relation inverse vers Commandes (une paiement peut avoir plusieurs commandes si besoin)
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
