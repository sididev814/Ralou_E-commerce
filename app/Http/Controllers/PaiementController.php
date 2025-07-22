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
        // ✅ Validation des données
        $data = $request->validate([
            'telephone' => 'required|string|min:8|max:15',
            'montant'   => 'required|numeric|min:100',
            'operateur' => 'required|string|in:Moov,Airtel,Zamani',
        ]);

        // ✅ Simulation de création d’un paiement
        $paiement = Paiement::create([
            'telephone'      => $data['telephone'],
            'montant'        => $data['montant'],
            'operateur'      => $data['operateur'],
            'statut'         => 'Réussi', // ou 'En attente' si on veut simuler une file
            'transaction_id' => strtoupper(Str::random(10)),
        ]);

        // ✅ Message de retour avec ID de transaction
        return redirect()->back()->with('success', '✅ Paiement simulé avec succès. Transaction ID : ' . $paiement->transaction_id);
    }
}
