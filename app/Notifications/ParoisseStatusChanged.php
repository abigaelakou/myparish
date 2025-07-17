<?php

namespace App\Notifications;

use App\Models\Paroisse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ParoisseStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;
    protected $paroisse;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Paroisse $paroisse)
    {
        //
        $this->paroisse = $paroisse;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // ->line('The introduction to the notification.')
        // ->action('Notification Action', url('/'))
        // ->line('Thank you for using our application!');

        $greeting = 'Bonjour à vous! Nous espérons que vous allez bien ?';
        $statusMessage = '';

        if ($this->paroisse->status == 1) {
            $statusMessage = 'Votre paroisse est de nouveau active. Vous pouvez continuer à explorer l\'application.';
        } else {
            $statusMessage = 'Votre paroisse est désactivée. Merci de nous contacter pour plus d\'informations.';
        }

        return (new MailMessage)
            ->greeting($greeting)
            ->line($statusMessage)
            ->action('Voir votre paroisse', url('/paroisses/' . $this->paroisse->id))
            ->line('Merci de votre attention !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
