<?php

namespace qfproject\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use qfproject\Actividad;
use qfproject\Asignatura;
use qfproject\Local;
use qfproject\Reservacion;
use qfproject\User;

class TareaNotification extends Notification
{
    use Queueable;

    /**
     * ---------------------------------------------------------------------------
     * Instancia de Reservación.
     *
     * @var \qfproject\Reservacion
     * ---------------------------------------------------------------------------
     */

    protected $reservacion;

    /**
     * ---------------------------------------------------------------------------
     * Tipo de notificación según la acción realizada por el usuario.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $tipo;

    /**
     * ---------------------------------------------------------------------------
     * Crea una nueva instancia de notificación.
     *
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function __construct($reservacion, $tipo)
    {
        $this->reservacion = $reservacion;

        $this->tipo = $tipo;
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
        return ['database'];
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene la representación de base de datos de la notificación.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * ---------------------------------------------------------------------------
     */

    public function toDatabase($notifiable)
    {
        return [
            'reservacion' => $this->reservacion,
            'tipo'        => $this->tipo,
            'propietario' => User::find($this->reservacion->user_id),
            'local'       => Local::find($this->reservacion->local_id),
            'asignatura'  => Asignatura::find($this->reservacion->asignatura_id),
            'actividad'   => Actividad::find($this->reservacion->actividad_id)
        ];
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene la representación de la matriz de la notificación.
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
