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

class ExportacionController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para exportar reservaciones a un archivo de Excel.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function exportarReservaciones()
    {
        $locales = Local::orderBy('nombre')->pluck('nombre', 'id');

        return view('reservaciones.exportar')->with('locales', $locales);
    }

    /**
     * ---------------------------------------------------------------------------
     * Exporta las reservaciones almacenadas en la base de datos a un archivo de
     * Excel.
     * 
     * @param  qfproject\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function recibirReservaciones(Request $request)
    {
        $this->validate(request(), [
            'fecha' => 'required'
        ]);

        Excel::create('Reservaciones', function($excel) use($request) {

            $excel->sheet('Datos', function($sheet) use($request) {

                $fecha = explode(' - ', $request->fecha);
                $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
                $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');

                if ($request->local_id) {
                	$reservaciones = Reservacion::where('local_id', '=', $request->local_id)
	                    ->where('fecha', '>=', $fecha[0])
	                    ->where('fecha', '<=', $fecha[1])
	                    ->get();
                } else {
                	$reservaciones = Reservacion::where('fecha', '>=', $fecha[0])
	                    ->where('fecha', '<=', $fecha[1])
	                    ->get();
                }


                //$sheet->row(1, ['local_id', 'asignatura_id', 'actividad_id', 'fecha', 'hora_inicio', 'hora_fin', 'tema', 'tipo']);

                $sheet->setColumnFormat(array(
                    'F' => 'dd/mm/yyyy',
                ));
                $sheet->fromArray($reservaciones);
                
                /*
                foreach ($reservaciones as $reservacion) {
                	$fila = [];
                	$fila[0] = $reservacion->local_id;
                	$fila[1] = $reservacion->asignatura_id;
                	$fila[2] = $reservacion->actividad_id;
                	$fila[3] = $reservacion->fecha;
                	$fila[4] = $reservacion->hora_inicio;
                	$fila[5] = $reservacion->hora_fin;
                	$fila[6] = $reservacion->tema;
                	$fila[7] = $reservacion->tipo;
                	$sheet->appendRow($fila);
                }
                */

            });

        })->export('xls');
    }
}
