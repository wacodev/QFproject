<?php

namespace qfproject\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CredencialesNotification extends Notification
{
    use Queueable;

    /**
     * ---------------------------------------------------------------------------
     * Nombre de usuario.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $username;

    /**
     * ---------------------------------------------------------------------------
     * Contraseña del usuario.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $password;

    /**
     * ---------------------------------------------------------------------------
     * Crea una nueva instancia de notificación.
     *
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function __construct($username, $password)
    {
        $this->username = $username;

        $this->password = $password;
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene los canales de entrega de la notificación.
     *
     * @param  mixed  $notifiable
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene la representación de correo electrónico de la notificación.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * ---------------------------------------------------------------------------
     */

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Credenciales')
            ->greeting('Hola')
            ->line('Se ha creado tu cuenta satisfactoriamente. Tus credenciales para acceder al Sistema de Reservación de Locales de la Facultad de Química y Farmacia son:')
            ->line('Usuario: ' . $this->username)
            ->line('Contraseña: ' . $this->password);
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene la representación de matriz de la notificación.
     *
     * @param  mixed  $notifiable
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
