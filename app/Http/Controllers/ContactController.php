<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Contact;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function show()
    {
        return view('mespages.contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:1000',
        ]);

        // Enregistrer dans la base
        Contact::create($validated);

        // Journaliser
        Log::info('Formulaire de contact soumis', $validated);

        try {
            // Envoyer le mail avec toutes les données
            Mail::to('sididev202@gmail.com')->send(
                new ContactMessage($validated) // ✅ ICI : on envoie 1 tableau
            );
        } catch (\Exception $e) {
            Log::error('Erreur lors de l’envoi de l’email : ' . $e->getMessage());
            return back()->withErrors(['email' => 'Erreur lors de l\'envoi. Veuillez réessayer.']);
        }

        return back()->with('success', 'Votre message a bien été envoyé.');
    }
}
