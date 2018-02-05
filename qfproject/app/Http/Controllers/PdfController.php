<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use DB;
use Carbon\Carbon;
use PDF;
use qfproject\Actividad;
use qfproject\Asignatura;
use qfproject\Local;
use qfproject\Reservacion;

class PdfController extends Controller
{
    /************************ COMPROBANTE DE RESERVACIÓN ************************/

    /**
     * ---------------------------------------------------------------------------
     * Genera un comprobante con todos los datos de la reservación.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function generarComprobante($id)
    {
        $reservacion = Reservacion::find($id);

        $reservacion->fecha = Carbon::parse($reservacion->fecha)->format('d/m/Y');
        $reservacion->hora_inicio = Carbon::parse($reservacion->hora_inicio)->format('h:i A');
        $reservacion->hora_fin = Carbon::parse($reservacion->hora_fin)->format('h:i A');

        $hoy = Carbon::now()->format('d/m/y h:i A');

        $pdf = \PDF::loadView('reportes.comprobante', ['reservacion' => $reservacion, 'hoy' => $hoy]);

        return $pdf->stream('comprobante_' . $reservacion->codigo . '.pdf');
    }

    /**
     * Reservas del día siguiente
     *
     */
   public function proximasReservas(){

    $mañana = new Carbon('tomorrow');

    $reservaciones=DB::table('reservaciones')
    ->join('locales', 'reservaciones.local_id', '=', 'locales.id')
    ->join('asignaturas', 'reservaciones.asignatura_id', '=', 'asignaturas.id')
    ->join('actividades', 'reservaciones.actividad_id', '=', 'actividades.id')
    ->select('reservaciones.*', 'locales.nombre as local', 'asignaturas.nombre', 'actividades.nombre as actividad')
    ->where('reservaciones.fecha', [$mañana])
    ->get();


    $pdf=PDF::loadView('reportes.reservacion-lista', ['reservaciones'=>$reservaciones]);
    return $pdf ->download('proximasReservas.pdf');

   }

   /****************************** HORARIO SEMANAL ******************************/

   /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para generar horarios.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function exportarHorarios()
    {
        $locales = Local::orderBy('nombre')->pluck('nombre', 'id');

        return view('reportes.exportar-horarios')->with('locales', $locales);
    }

    /**
     * ---------------------------------------------------------------------------
     * Genera un horario semanal de las reservaciones programadas para un local.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function generarHorarios(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'fecha' => 'required|date',
            'local_id' => 'required'
        ]);

        /**
         * Validando que la fecha ingresada sea un día lunes.
         */

        $fecha = Carbon::parse($request->fecha)->format('Y-m-d');

        if (date('N', strtotime($fecha)) != 1) {
            flash('
                <h4>
                    <i class="fa fa-ban icon" aria-hidden="true"></i>
                    ¡Error en ingreso de datos!
                </h4>
                <p class="ban">
                    Debes seleccionar un día lunes.
                </p>
            ')
                ->error()
                ->important();
            
            return back();
        }

        /**
         * Obteniendo fechas y horas.
         */

        $f = explode('-', $fecha);
        $f_carbon = Carbon::create($f[0], $f[1], $f[2], 0); // Fecha inicial como instancia de Carbon.

        $fechas = []; // Arreglo con todas las fechas.

        for ($i = 0; $i < 6; $i++) { 
            $f_almacenar = Carbon::parse($f_carbon)->format('Y-m-d');

            array_push($fechas, $f_almacenar);

            $f_carbon = $f_carbon->addDays(1);
        }

        $horas = ['07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00']; // Arreglo con todas las horas.

        /**
         * Obteniendo arreglo con las reservaciones para generar los horarios.
         */

        $tabla = []; // Arreglo con las reservaciones del horario de un local.

        foreach ($horas as $hora) {
            $fila = []; // Arreglo con las reservaciones de una determinada hora.

            foreach ($fechas as $fecha) {
                $reservacion = Reservacion::where('local_id', '=', $request->local_id)
                    ->where('fecha', '=', $fecha)
                    ->where('hora_inicio', '<=', $hora)
                    ->where('hora_fin', '>', $hora)
                    ->first();

                array_push($fila, $reservacion);
            }

            array_push($tabla, $fila);
        }

        /**
         * Generando PDF.
         */

        $local = Local::find($request->local_id);

        $fecha_inicio = Carbon::parse($fechas[0])->format('d/m/Y');

        $fecha_fin = Carbon::parse($fechas[5])->format('d/m/Y');

        $pdf = \PDF::loadView('reportes.horarios', ['tabla' => $tabla, 'local' => $local, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin])
            ->setPaper('letter', 'landscape');

        return $pdf->stream('horarios.pdf');
    }

    /****************** LISTADO DE RESERVACIONES POR ACTIVIDAD ******************/

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para generar el listado de reservaciones por
     * actividad.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function exportarListaActividad()
    {
        $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');

        $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

        return view('reportes.exportar-lista-actividad')
            ->with('asignaturas', $asignaturas)
            ->with('actividades', $actividades);
    }

    /**
     * ---------------------------------------------------------------------------
     * Genera un listado con las reservaciones de una asignatura por actividad.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function generarListaActividad(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'fecha' => 'required',
            'asignatura_id' => 'required',
            'actividad_id' => 'required'
        ]);

        /**
         * Obteniendo datos solicitados por el usuario.
         */

        $fecha = explode(' - ', $request->fecha);

        $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
        $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');

        $reservaciones = Reservacion::where('asignatura_id', '=', $request->asignatura_id)
            ->where('actividad_id', '=', $request->actividad_id)
            ->where('fecha', '>=', $fecha[0])
            ->where('fecha', '<=', $fecha[1])
            ->orderBy('fecha', 'asc')
            ->get();

        /**
         * Generando PDF.
         */

        $asignatura = Asignatura::find($request->asignatura_id);

        $actividad = Actividad::find($request->actividad_id);

        $fecha_inicio = Carbon::parse($fecha[0])->format('d/m/Y');

        $fecha_fin = Carbon::parse($fecha[1])->format('d/m/Y');

        $pdf = \PDF::loadView('reportes.lista-actividad', ['reservaciones' => $reservaciones, 'asignatura' => $asignatura, 'actividad' => $actividad, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]);

        return $pdf->stream('listado_actividad.pdf');
    }
}
