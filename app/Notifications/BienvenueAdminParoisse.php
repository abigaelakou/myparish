<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BienvenueAdminParoisse extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $name;
    protected $paroisse;
    protected $email;
    protected $password;

    public function __construct($name, $paroisse, $email, $password)
    {
        $this->name = $name;
        $this->paroisse = $paroisse;
        $this->email = $email;
        $this->password = $password;
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
        return (new MailMessage)
        ->subject('Bienvenue sur Paroisse Smart')
        ->greeting('Bonjour ' . $this->name . ',')
        ->line('Votre paroisse "' . $this->paroisse . '" a été enregistrée avec succès sur notre plateforme.')
        ->line('Voici vos identifiants de connexion :')
        ->line('**Email :** ' . $this->email)
        ->line('**Mot de passe temporaire :** ' . $this->password)
        ->line('Veuillez vous connecter et changer votre mot de passe immédiatement pour sécuriser votre compte.')
        ->action('Se connecter', url('//https://www.paroissesmart.com/login')) //
        ->line('Merci de faire partie de notre communauté !');
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
