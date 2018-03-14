<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Carbon\Carbon;
use Excel;
use Laracasts\Flash\Flash;
use qfproject\Actividad;
use qfproject\Asignatura;
use qfproject\Asueto;
use qfproject\Local;
use qfproject\Notifications\CredencialesNotification;
use qfproject\Notifications\ReservacionNotification;
use qfproject\Reservacion;
use qfproject\Suspension;
use qfproject\User;
use Storage;

class ImportacionController extends Controller
{
    /****************************** RESERVACIONES *******************************/

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear nuevas reservaciones mediante un archivo
     * de Excel.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function importarReservaciones()
    {
        return view('reservaciones.importar');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena las reservaciones recién importadas de un archivo de Excel en la
     * base de datos.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function almacenarReservaciones(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'archivo' => 'required|mimes:xlsx,xls'
        ]);

        /**
         * Obteniendo archivo.
         */

        $file = $request->file('archivo');

        $nombre = 'reservaciones_' . time() . '.' . $file->getClientOriginalExtension();

        $archivo = Storage::disk('archivos')->put($nombre, \File::get($file));

        $ruta = storage_path('archivos') . '/' . $nombre;

        /**
         * Importando datos del archivo.
         */

        if ($archivo) {
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $registros = $hoja->get();

                $i = 2; // Número de fila.

                $j = 0; // Número de reservaciones registradas.

                foreach ($registros as $fila) {
                    $error = $this->validarReservacion($fila);

                    if ($error[0]) {
                        flash('
                            <h4>
                                <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                                Detalles de la operación
                            </h4>
                            <p class="info-circle">
                                Reservaciones registradas satisfactoriamente: ' . $j . '.
                            </p>
                            <p class="info-circle">
                                En la fila ' . $i . ' se presentó el siguiente error: ' . $error[1] . ' <strong>Los registros en las filas anteriores se guardaron correctamente</strong>.
                            </p>
                        ')
                        ->info()
                        ->important();

                        break;
                    }

                    $reservacion = new Reservacion;

                    $reservacion->user_id = $fila->user_id;
                    $reservacion->local_id = $fila->local_id;
                    $reservacion->asignatura_id = $fila->asignatura_id;
                    $reservacion->actividad_id = $fila->actividad_id;
                    $reservacion->fecha = $fila->fecha;
                    $reservacion->hora_inicio = $fila->hora_inicio;
                    $reservacion->hora_fin = $fila->hora_fin;
                    $reservacion->tema = $fila->tema;
                    $reservacion->tipo = $fila->tipo;

                    /**
                     * Generando código de comprobación.
                     */

                    $cr = str_pad(substr($j, -3, 3), 3, '0', STR_PAD_LEFT);
                    $ca = str_pad(substr($reservacion->asignatura_id, 0, 2), 2, '0', STR_PAD_LEFT);
                    $cl = str_pad(substr($reservacion->local_id, 0, 2), 2, '0', STR_PAD_LEFT);
                    $cu = str_pad(substr($reservacion->user_id, 0, 2), 2, '0', STR_PAD_LEFT);

                    $reservacion->codigo = $cr . '-' . time() . '-' . $ca . '-' . $cl . '-' . $cu;

                    $reservacion->save();

                    /**
                     * Notificando a los usuarios correspondientes la acción realizada.
                     */

                    $this->notificar($reservacion, 'crear');

                    $i++;

                    $j++;
                }

                if (!$error[0]) {
                    flash('
                        <h4>
                            <i class="fa fa-check icon" aria-hidden="true"></i>
                            ¡Bien hecho!
                        </h4>
                        <p class="check">
                            Todas las reservaciones fueron registradas correctamente.
                        </p>
                        <p class="check">
                            Total de reservaciones registradas: ' . $j . '.
                        </p>
                    ')
                    ->success()
                    ->important();
                }
            });

            /**
             * Eliminando archivo almacenado previamente.
             */

            if (\File::exists($ruta)) {
                \File::delete($ruta);
            }

            return redirect()->route('reservaciones.index');
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida exhaustivamente los datos ingresados de la reservación.
     * 
     * @param  \Maatwebsite\Excel\Readers\LaravelExcelReader  $fila
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function validarReservacion($fila)
    {
        /**
         * Validando ingreso de campos obligatorios y que existe el local, la
         * asignatura, el usuario y la actividad ingresada.
         */

        $fila->fecha = Carbon::parse($fila->fecha)->format('Y-m-d');
        $fila->hora_inicio = Carbon::parse($fila->hora_inicio)->format('H:i:s');
        $fila->hora_fin = Carbon::parse($fila->hora_fin)->format('H:i:s');

        if ($fila->user_id == null || $fila->local_id == null || $fila->asignatura_id == null || $fila->actividad_id == null || $fila->fecha == null || $fila->hora_inicio == null || $fila->hora_fin == null) {
            return [true, 'La fila está vacía o no ingresó algún dato requerido para realizar la reservación.'];
        } elseif (User::where('id', '=', $fila->user_id)->first() == null) {
            return [true, 'No existe el usuario ingresado.'];
        } elseif (Local::where('id', '=', $fila->local_id)->first() == null) {
            return [true, 'No existe el local ingresado.'];
        } elseif (Asignatura::where('id', '=', $fila->asignatura_id)->first() == null) {
            return [true, 'No existe la asignatura ingresada.'];
        } elseif (Actividad::where('id', '=', $fila->actividad_id)->first() == null) {
            return [true, 'No existe la actividad ingresada.'];
        }

        /**
         * Validando que la fecha, la hora de inicio y la hora de finalización cumplen
         * con las reglas del negocio.
         */

        $hi = explode(':', $fila->hora_inicio);
        $hf = explode(':', $fila->hora_fin);

        $fecha_actual = Carbon::now()->format('Y-m-d');
        $hora_actual = Carbon::now()->format('H:i:s');
        
        if ($fila->fecha < $fecha_actual) {
            return [true, 'No puede realizar una reservación en una fecha anterior a la actual.'];
        } elseif ($fila->hora_inicio < '07:00:00' || $fila->hora_inicio > '17:00:00') {
            return [true, 'La hora de inicio debe ser entre 07:00 AM y 05:00 PM.'];
        } elseif ($fila->hora_fin <= $fila->hora_inicio || $fila->hora_fin > '18:00:00') {
            return [true, 'La hora de finalización debe ser mayor a la hora de inicio y menor o igual a las 06:00 PM.'];
        } elseif ($hi[1] != '00' || $hf[1] != '00') {
            return [true, 'No puedes ingresar minutos distintos a cero.'];
        } elseif ($fila->fecha == $fecha_actual && $fila->hora_inicio < $hora_actual) {
            return [true, 'Si la reservación se desea programar para el día de hoy no puede ingresar una hora inferior a la actual.'];
        }

        /**
         * Validando que la fecha, la hora de inicio y la hora de finalización no
         * coincidan con un asueto, suspensión de actividades o en día domingo.
         * Esto solo para las reservaciones de tipo Extraordinaria.
         */

        if ($fila->tipo == 'Extraordinaria') {
            if (date('N', strtotime($fila->fecha)) == 7) {
                return [true, 'No puede reservar un día domingo.'];
            }

            $asuetos = Asueto::all();

            $f = explode('-', $fila->fecha);
            
            if ($asuetos->count() > 0) {
                foreach ($asuetos as $asueto) {
                    if ($f[1] == $asueto->mes && $f[2] == $asueto->dia) {
                        return [true, 'Para la fecha que ingresaste hay programado un asueto por ser: ' . $asueto->nombre . '.'];
                    }
                }
            }
            
            $suspensiones = Suspension::where('fecha', '=', $fila->fecha)->get();

            if ($suspensiones->count() > 0) {
                foreach ($suspensiones as $suspension) {
                    if (($fila->hora_inicio >= $suspension->hora_inicio && $fila->hora_inicio < $suspension->hora_fin) || ($fila->hora_fin <= $suspension->hora_fin && $fila->hora_fin > $suspension->hora_inicio)) {
                        $suspension->fecha = Carbon::parse($suspension->fecha)->format('d/m/Y');
                        $suspension->hora_inicio = Carbon::parse($suspension->hora_inicio)->format('h:i A');
                        $suspension->hora_fin = Carbon::parse($suspension->hora_fin)->format('h:i A');

                        return [true, 'Para la fecha ' . $suspension->fecha . ' hay programada una suspensión de actividades de ' . $suspension->hora_inicio . ' a ' . $suspension->hora_fin . '.'];
                    }
                }
            }
        }


        /**
         * Validando que el local esté disponible para la fecha y hora de la
         * reservación.
         */

        $reservaciones = Reservacion::where('fecha', '=', $fila->fecha)
            ->where('hora_inicio', '>=', $fila->hora_inicio)
            ->where('hora_inicio', '<', $fila->hora_fin)
            ->where('local_id', '=', $fila->local_id)
            ->orWhere('fecha', '=', $fila->fecha)
            ->where('hora_fin', '<=', $fila->hora_fin)
            ->where('hora_fin', '>', $fila->hora_inicio)
            ->where('local_id', '=', $fila->local_id)
            ->get();

        if ($reservaciones->count() > 0) {
            return [true, 'El local no está disponible para reservarse en la fecha y horas ingresadas.'];
        }

        /**
         * Si pasó todas las validaciones.
         */

        return [false, null];
    }

    /********************************* USUARIOS *********************************/

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear nuevos usuarios mediante un archivo de
     * Excel.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function importarUsers()
    {
        return view('administracion.users.importar');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena las reservaciones recién importadas de un archivo de Excel en la
     * base de datos.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function almacenarUsers(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'archivo' => 'required|mimes:xlsx,xls'
        ]);

        /**
         * Obteniendo archivo.
         */

        $file = $request->file('archivo');

        $nombre = 'users_' . time() . '.' . $file->getClientOriginalExtension();

        $archivo = Storage::disk('archivos')->put($nombre, \File::get($file));

        $ruta = storage_path('archivos') . '/' . $nombre;

        /**
         * Importando datos del archivo.
         */

        if ($archivo) {
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $registros = $hoja->get();

                $i = 2; // Número de fila.

                $j = 0; // Número de usuarios registrados.

                $envio_falla = []; // Arreglo con los correos a los que el envío de credenciales falló.

                foreach ($registros as $fila) {
                    $error = $this->validarUser($fila);

                    if ($error[0]) {
                        flash('
                            <h4>
                                <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                                Detalles de la operación
                            </h4>
                            <p class="info-circle">
                                <strong>Usuarios registrados satisfactoriamente: ' . $j . '.</strong>
                            </p>
                            <p class="info-circle">
                                En la fila ' . $i . ' se presentó el siguiente error: ' . $error[1] . ' <strong>Los registros en las filas anteriores se guardaron correctamente</strong>.
                            </p>
                        ')
                        ->info()
                        ->important();

                        break;
                    }

                    $user = new User;

                    $user->name = $fila->name;
                    $user->lastname = $fila->lastname;
                    $user->email = $fila->email;
                    $user->password = $fila->password;
                    $user->tipo = $fila->tipo;

                    /**
                     * Almacenando username.
                     */

                    $username = explode('@', $fila->email);

                    $username_almacenar = $username[0];

                    $u = 1;

                    $bandera = true;

                    while ($bandera) {
                        if (User::where('username', '=', $username_almacenar)->first()) {
                            $username_almacenar = $username[0] . $u;

                            $u++;
                        } else {
                            $user->username = $username_almacenar;

                            $bandera = false;
                        }
                    }

                    $user->save();

                    /**
                     * Notificando sus credenciales al usuario.
                     */

                    try {
                        $user->notify(new CredencialesNotification($user->username, $request->password));
                    } catch (\Exception $e) {
                        array_push($envio_falla, $user->email);
                    }

                    $i++;

                    $j++;
                }

                if (!$error[0]) {
                    flash('
                        <h4>
                            <i class="fa fa-check icon" aria-hidden="true"></i>
                            ¡Bien hecho!
                        </h4>
                        <p class="check">
                            Todos los usuarios fueron registrados correctamente.
                        </p>
                        <p class="check">
                            Total de usuarios registrados: ' . $j . '.
                        </p>
                    ')
                        ->success()
                        ->important();

                    if (count($envio_falla) > 0) {
                        foreach ($envio_falla as $ef) {
                            flash('
                                <h4>
                                    <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                                    ¡Envío de correo con credenciales falló!
                                </h4>
                                <p class="exclamation-triangle">
                                    No se pudo enviar las credenciales al correo: ' . $ef . '
                                </p>
                            ')
                                ->warning()
                                ->important();
                        }
                    }
                }
            });


            /**
             * Eliminando archivo almacenado previamente.
             */

            if (\File::exists($ruta)) {
                \File::delete($ruta);
            }

            return redirect()->route('users.index');
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida exhaustivamente los datos ingresados del usuario.
     * 
     * @param  \Maatwebsite\Excel\Readers\LaravelExcelReader  $fila
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function validarUser($fila)
    {
        /**
         * Validando ingreso de campos obligatorios y que cumplan con las reglas
         * del negocio.
         */

        if ($fila->name == null || $fila->lastname == null || $fila->email == null || $fila->password == null || $fila->tipo == null) {
            return [true, 'La fila está vacía o no ingresó algún dato requerido para registrar al usuario.'];
        } elseif ($fila->tipo != 'Administrador' && $fila->tipo != 'Asistente' && $fila->tipo != 'Docente' && $fila->tipo != 'Visitante') {
            return [true, 'El tipo de usuario ingresado no existe'];
        } elseif (User::where('email', '=', $fila->email)->first()) {
            return [true, 'El correo electrónico ' . $fila->email . ' ya existe.'];
        }

        /**
         * Si pasó todas las validaciones.
         */

        return [false, null];
    }

    /**
     * ---------------------------------------------------------------------------
     * Crea y envia notificaciones de las acciones de editar y eliminar
     * reservaciones a los usuarios correspondientes.
     * 
     * @param  \qfproject\Reservacion  $reservacion
     * @param  string  $tipo
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function notificar($reservacion, $tipo)
    {
        if (\Auth::user()->id == $reservacion->user_id) {

            /**
             * Cuando la acción fue realizada por el propietario de la
             * reservación.
             */

            if (!\Auth::user()->administrador()) {
                if (\Auth::user()->asistente()) {
                    $users = User::where('tipo', '=', 'Administrador')
                        ->get();
                } else {
                    $users = User::where('tipo', '=', 'Administrador')
                        ->orWhere('tipo', '=', 'Asistente')
                        ->get();
                }

                foreach ($users as $user) {
                    $user->notify(new ReservacionNotification($reservacion, $tipo, true));
                }
            }
        } else {

            /**
             * Cuando la acción no fue realizada por el propietario de la
             * reservación.
             */

            if (\Auth::user()->administrador()) {
                $user = User::where('id', '=', $reservacion->user_id)->first();

                $user->notify(new ReservacionNotification($reservacion, $tipo, false));
            } else {
                $users = User::where('tipo', '=', 'Administrador')
                    ->orWhere('id', '=', $reservacion->user_id)
                    ->get();

                foreach ($users as $user) {
                    if ($user->administrador()) {
                        $user->notify(new ReservacionNotification($reservacion, $tipo, true));
                    } else {
                        $user->notify(new ReservacionNotification($reservacion, $tipo, false));
                    }
                }
            }
        }
    }
}
