<?php

namespace App\Mail;

use App\Models\Messe;
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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Messe $messe)
    {
        //
        $this->messe = $messe;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Messe Created',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        // return new Content(
        //     view: 'view.name',
        // );

        return $this->view('emails.messe_created')
            ->with([
                'date_messe' => $this->messe->date_messe,
                'heure_messe' => $this->messe->heure_messe,
                'lieu_messe' => $this->messe->lieu_messe,
            ]);
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
