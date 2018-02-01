<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use qfproject\Actividad;
use qfproject\Asignatura;
use Carbon\Carbon;
use qfproject\Local;
use qfproject\Reservacion;
use PDF;
use DB;





class PdfController extends Controller
{
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
}
