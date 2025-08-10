<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    public function initier(Request $request)
    {
        $data = $request->validate([
            'telephone' => 'required|string|min:8|max:15',
            'operateur' => 'required|string|in:Moov,Airtel,OrangeMoney',
        ]);

        $panier = session('panier');
        if (!$panier || count($panier) === 0) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        $total = 0;
        foreach ($panier as $produit) {
            $total += $produit['prix'] * $produit['quantite'];
        }

        // Convertir en entier (XOF ne supporte pas les décimales)
        $montant = (int) round($total);

        if ($montant < 100) {
            return redirect()->back()->with('error', 'Le montant minimum de paiement est de 100 XOF.');
        }

        $transaction_id = strtoupper(Str::random(10));

        try {
            $response = Http::post('https://api-checkout.cinetpay.com/v2/payment', [
                'apikey'         => env('CINETPAY_API_KEY'),
                'site_id'        => env('CINETPAY_SITE_ID'),
                'transaction_id' => $transaction_id,
                'amount'         => $montant,
                'currency'       => 'XOF',
                'description'    => 'Paiement de commande',
                'notify_url'     => env('CINETPAY_NOTIFY_URL'),
                'return_url'     => env('CINETPAY_RETURN_URL'),
                'customer_name'  => Auth::user()->name,
                'customer_surname'=> '',
                'customer_email' => Auth::user()->email,
                'customer_phone_number' => $data['telephone'],
                'channels' => 'MOBILE_MONEY', // CinetPay attend une valeur fixe ici
                'metadata'       => json_encode(['user_id' => Auth::id()]),
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur API CinetPay initier : " . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la connexion à CinetPay.');
        }

        $responseBody = $response->json();

        if (isset($responseBody['code']) && $responseBody['code'] == '201') {
            $payment_url = $responseBody['data']['payment_url'];

            // Stocker temporairement transaction et panier
            session()->put('transaction_id', $transaction_id);
            session()->put('panier_en_cours', $panier);

            return redirect($payment_url);
        } else {
            Log::error('Erreur réponse CinetPay : ' . json_encode($responseBody));
            return redirect()->back()->with('error', 'Erreur lors de la connexion à CinetPay.');
        }
    }

    // Webhook Notification (appelé par CinetPay)
    public function notification(Request $request)
    {
        $data = $request->all();

        if (isset($data['code']) && $data['code'] == '00') { // Paiement réussi
            $transaction_id = $data['transaction_id'];

            $telephone = ($data['cpm_phone_prefixe'] ?? '') . ($data['cpm_phone_numero'] ?? '');

            $paiement = Paiement::create([
                'telephone'      => $telephone,
                'montant'        => $data['amount'],
                'operateur'      => $data['payment_method'] ?? 'inconnu',
                'statut'         => 'Réussi',
                'transaction_id' => $transaction_id,
            ]);

            $commande = Commande::create([
                'user_id'           => json_decode($data['metadata'])->user_id,
                'paiement_id'       => $paiement->id,
                'statut'            => 'Confirmée',
                'paiement_effectue' => true,
                'total'             => $data['amount'],
            ]);

            $panier = session('panier_en_cours');
            if ($panier) {
                foreach ($panier as $produit_id => $produit) {
                    $commande->produits()->attach($produit_id, [
                        'quantite'      => $produit['quantite'],
                        'prix_unitaire' => $produit['prix'],
                    ]);
                }
                session()->forget('panier_en_cours');
            } else {
                Log::warning("Notification CinetPay reçue, mais panier_en_cours absent pour transaction $transaction_id");
            }

            return response()->json(['message' => 'Commande confirmée.'], 200);
        }

        Log::warning("Paiement CinetPay échoué ou code non reçu : " . json_encode($data));
        return response()->json(['message' => 'Paiement échoué.'], 400);
    }

    // Retour utilisateur après paiement
    public function retour(Request $request)
    {
        $transaction_id = session('transaction_id');

        if (!$transaction_id) {
            return redirect()->route('produits')->with('error', 'Transaction non trouvée.');
        }

        $commande = Commande::where('paiement_effectue', true)
            ->whereHas('paiement', function ($q) use ($transaction_id) {
                $q->where('transaction_id', $transaction_id);
            })
            ->first();

        if ($commande) {
            session()->forget('transaction_id');
            return redirect()->route('commande.confirmation', ['id' => $commande->id])->with('success', '✅ Paiement validé, commande confirmée.');
        }

        return redirect()->route('produits')->with('error', 'Paiement non validé.');
    }
}
