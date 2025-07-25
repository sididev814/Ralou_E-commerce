<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), $this->data['nom']) // Affiche le nom du client dans Gmail
                    ->subject('Nouveau message de contact')
                    ->view('emails.contact')
                    ->with('data', $this->data);
    }
}
