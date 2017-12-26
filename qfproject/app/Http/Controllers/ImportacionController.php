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
use qfproject\Reservacion;
use qfproject\Suspension;
use Storage;

class ImportacionController extends Controller
{
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
     * @param  qfproject\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function almacenarReservaciones(Request $request)
    {
        $archivo = $request->file('archivo');

        $nombre_original = $archivo->getClientOriginalName();
        $extension = $archivo->getClientOriginalExtension();
        $rl = Storage::disk('archivos')->put($nombre_original, \File::get($archivo));
        $ruta = storage_path('archivos') . "/" . "$nombre_original";

        if ($rl) {
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $registros = $hoja->get();
                $i = 2;
                foreach ($registros as $fila) {
                    $error = $this->validarReservacion($fila);
                    if ($error != 'No hay errores') {
                        flash('
                            <h4>
                                <i class="fa fa-ban icono-margen-grande" aria-hidden="true"></i>¡Error en ingreso de datos!
                            </h4>
                            <p style="padding-left: 30px;">
                                En la fila ' . $i . ' se presentó el siguiente error: ' . $error . '
                            </p>
                            <p style="padding-left: 30px;">
                                Las reservaciones anteriores se guardaron correctamente.
                            </p>
                        ')
                        ->error()
                        ->important();
                        break;
                    }
                    $reservacion = new Reservacion;
                    $reservacion->user_id = \Auth::user()->id;
                    $reservacion->local_id = $fila->local_id;
                    $reservacion->asignatura_id = $fila->asignatura_id;
                    $reservacion->actividad_id = $fila->actividad_id;
                    $reservacion->fecha = $fila->fecha;
                    $reservacion->hora_inicio = $fila->hora_inicio;
                    $reservacion->hora_fin = $fila->hora_fin;
                    $reservacion->tema = $fila->tema;
                    $reservacion->tipo = 'Ordinaria';
                    $reservacion->codigo = $i . '-' . time() . '-' . $reservacion->asignatura_id . '-' . $reservacion->local_id . '-' . $reservacion->user_id;
                    $reservacion->save();
                    $i++;
                }
                if ($error == 'No hay errores') {
                    flash('
                    <h4>
                        <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
                    </h4>
                    <p style="padding-left: 34px;">
                        Se han registrado todas las reservaciones correctamente.
                    </p>
                ')
                    ->success()
                    ->important();
                }
            });
            return redirect()->route('home');
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida exhaustivamente los datos ingresados de la reservación.
     * 
     * @param  RowCollection  $fila
     * @return string
     * ---------------------------------------------------------------------------
     */

    public function validarReservacion($fila)
    {        
        /**
         * ---------------------------------------------------------------------------
         * Validando ingreso de campos obligatorios y que existe el local, la
         * asignatura y la actividad ingresada.
         * ---------------------------------------------------------------------------
         */

        $fila->fecha = Carbon::parse($fila->fecha)->format('Y-m-d');
        $fila->hora_inicio = Carbon::parse($fila->hora_inicio)->format('H:i:s');
        $fila->hora_fin = Carbon::parse($fila->hora_fin)->format('H:i:s');

        if ($fila->local_id == null || $fila->asignatura_id == null || $fila->actividad_id == null || $fila->fecha == null || $fila->hora_inicio == null || $fila->hora_fin == null) {
            return 'No ingresó algún dato requerido para realizar la reservación. Revise que se ingresó: Local, asignatura, actividad, fecha, hora de inicio y hora de finalización de la reservación.';
        } elseif (Local::where('id', '=', $fila->local_id)->first() == null) {
            return 'No existe el local ingresado.';
        } elseif (Asignatura::where('id', '=', $fila->asignatura_id)->first() == null) {
            return 'No existe la asignatura ingresada.';
        } elseif (Actividad::where('id', '=', $fila->actividad_id)->first() == null) {
            return 'No existe la actividad ingresada.';
        }

        /**
         * ---------------------------------------------------------------------------
         * Validando que la fecha, la hora de inicio y la hora de finalización cumplen
         * con las reglas del negocio.
         * ---------------------------------------------------------------------------
         */

        $hi = explode(':', $fila->hora_inicio);
        $hf = explode(':', $fila->hora_fin);

        $fecha_actual = Carbon::now()->format('Y-m-d');
        $hora_actual = Carbon::now()->format('H:i:s');
        
        if ($fila->fecha < $fecha_actual) {
            return 'No puede realizar una reservación en una fecha anterior a la actual.';
        } elseif ($fila->hora_inicio < '07:00:00' || $fila->hora_inicio > '17:00:00') {
            return 'La hora de inicio debe ser entre 07:00 AM y 05:00 PM.';
        } elseif ($fila->hora_fin <= $fila->hora_inicio || $fila->hora_fin > '18:00:00') {
            return 'La hora de finalización debe ser mayor a la hora de inicio y menor o igual a las 06:00 PM.';
        } elseif ($hi[1] != '00' || $hf[1] != '00') {
            return 'No puedes ingresar minutos distintos a cero.';
        } elseif ($fila->fecha == $fecha_actual && $fila->hora_inicio < $hora_actual) {
            return 'Si la reservación se desea programar para el día de hoy no puede ingresar una hora inferior a la actual.';
        }

        /**
         * ---------------------------------------------------------------------------
         * Validando que la fecha, la hora de inicio y la hora de finalización no
         * coincidan con un asueto o suspensión de actividades.
         * ---------------------------------------------------------------------------
         */

        $asuetos = Asueto::all();

        $f = explode('-', $fila->fecha);
        
        foreach ($asuetos as $asueto) {
            if ($f[1] == $asueto->mes && $f[2] == $asueto->dia) {
                return 'Para la fecha que ingresaste hay programado un asueto por ser: ' . $asueto->nombre . '.';
            }
        }
        
        $suspensiones = Suspension::where('fecha', '=', $fila->fecha)->get();

        if ($suspensiones->count() > 0) {
            foreach ($suspensiones as $suspension) {
                if (($fila->hora_inicio >= $suspension->hora_inicio && $fila->hora_inicio < $suspension->hora_fin) || ($fila->hora_fin <= $suspension->hora_fin && $fila->hora_fin > $suspension->hora_inicio)) {
                    $suspension->fecha = Carbon::parse($suspension->fecha)->format('d/m/Y');
                    $suspension->hora_inicio = Carbon::parse($suspension->hora_inicio)->format('h:i A');
                    $suspension->hora_fin = Carbon::parse($suspension->hora_fin)->format('h:i A');
                    return 'Para la fecha ' . $suspension->fecha . ' hay programada una suspensión de actividades de ' . $suspension->hora_inicio . ' a ' . $suspension->hora_fin . '.';
                }
            }
        }

        /**
         * ---------------------------------------------------------------------------
         * Validando que el local esté disponible para la fecha y hora de la
         * reservación.
         * ---------------------------------------------------------------------------
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
            return 'El local no está disponible para reservarse en la fecha y horas ingresadas.';
        }

        /**
         * ---------------------------------------------------------------------------
         * Si pasó todas las validaciones.
         * ---------------------------------------------------------------------------
         */

        return 'No hay errores';
    }
}
