<?php

namespace App\Mail;

use App\Models\Messe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MesseCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $messe;
    public $celebrant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Messe $messe, User $celebrant)
    {
        $this->messe = $messe;
        $this->celebrant = $celebrant;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@paroissesmart.com', 'Paroisse Smart')
            ->subject('Messe Programmée')
            ->view('emails.messe_created')
            ->with([
                'date_messe' => $this->messe->date_messe,
                'heure_messe' => $this->messe->heure_messe,
                'lieu_messe' => $this->messe->lieu_messe,
                'celebrant' => $this->celebrant->name,
            ]);
    }
}
