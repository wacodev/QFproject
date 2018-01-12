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
}
