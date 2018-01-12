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

class ReservacionNotification extends Notification
{
    use Queueable;

    protected $reservacion;

    protected $tipo;

    protected $propietario;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservacion, $tipo, $propietario)
    {
        $this->reservacion = $reservacion;
        $this->tipo = $tipo;
        $this->propietario = $propietario;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        switch ($this->tipo) {
            case 'crear':
                $mensaje = 'Ha realizado una nueva reservación';

                break;

            case 'editar':
                if ($this->propietario) {
                    $mensaje = 'Ha editado una reservación';
                } else {
                    $mensaje = 'Ha editado tu reservación';
                }

                break;

            case 'eliminar':
                if ($this->propietario) {
                    $mensaje = 'Ha eliminado una reservación';
                } else {
                    $mensaje = 'Ha eliminado tu reservación';
                }

                break;

            case 'suspension':
                $mensaje = 'Ha eliminado tu reservación por coincidar con una suspensión de actividades';

                break;

            case 'actividad':
                $mensaje = 'Ha eliminado tu reservación porque la actividad asignada ya no existe.';

                break;

            case 'asignatura':
                $mensaje = 'Ha eliminado tu reservación porque la asignatura asignada ya no existe.';

                break;

            case 'local':
                $mensaje = 'Ha eliminado tu reservación porque el local asignado ya no existe.';

                break;
        }

        return [
            'reservacion' => $this->reservacion,
            'tipo'        => $this->tipo,
            'mensaje'     => $mensaje,
            'user'        => User::find(\Auth::user()->id),
            'local'       => Local::find($this->reservacion->local_id),
            'asignatura'  => Asignatura::find($this->reservacion->asignatura_id),
            'actividad'   => Actividad::find($this->reservacion->actividad_id)
        ];
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