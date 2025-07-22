<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    /**
     * Simule un paiement MyNita
     */
   public function simuler(Request $request)
{
    $data = $request->validate([
        'telephone' => 'required|string|min:8|max:15',
        'montant'   => 'required|numeric|min:100',
        'operateur' => 'required|string|in:Moov,Airtel,Zamani',
    ]);

    $paiement = Paiement::create([
        'telephone'      => $data['telephone'],
        'montant'        => $data['montant'],
        'operateur'      => $data['operateur'],
        'statut'         => 'Réussi',
        'transaction_id' => strtoupper(Str::random(10)),
    ]);

    session(['paiement_ok' => true]);

    return redirect()->back()->with('success', '✅ Paiement simulé avec succès. Transaction ID : ' . $paiement->transaction_id);
}

}
