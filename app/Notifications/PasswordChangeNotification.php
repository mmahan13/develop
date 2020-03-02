<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class PasswordChangeNotification extends Notification
{
    use Queueable;
    protected $token;
    protected $user;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
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
            ->subject('Notificación de cambio de contraseña')
            ->line('Este correo ha sido enviado porque has solicitado cambiar tu contraseña de Futurener')
            ->action('Cambiar contraseña', url('password/reset', $this->token))
            ->line('Si no has solicitado el cambio de contraseña no es necesaria ninguna acción.')
            ->greeting('Hola, '.$this->user->name);
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
