<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['telephone', 'montant', 'operateur', 'statut', 'transaction_id'];

}
