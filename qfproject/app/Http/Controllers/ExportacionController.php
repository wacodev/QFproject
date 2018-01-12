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
use qfproject\Local;
use qfproject\Reservacion;
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
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function recibirReservaciones(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'fecha' => 'required'
        ]);

        /**
         * Creando archivo de Excel.
         */

        Excel::create('Reporte', function($excel) use($request) {
            $excel->sheet('Datos', function($sheet) use($request) {

                /**
                 * Obteniendo datos solicitados por el usuario.
                 */

                $fecha = explode(' - ', $request->fecha);

                $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
                $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');

                if ($request->local_id) {
                    $reservaciones = Reservacion::where('local_id', '=', $request->local_id)
                        ->where('fecha', '>=', $fecha[0])
                        ->where('fecha', '<=', $fecha[1])
                        ->orderBy('fecha', 'desc')
                        ->get();
                } else {
                    $reservaciones = Reservacion::where('fecha', '>=', $fecha[0])
                        ->where('fecha', '<=', $fecha[1])
                        ->orderBy('fecha', 'desc')
                        ->get();
                }

                /**
                 * Encabezado del archivo.
                 */

                $sheet->mergeCells('A1:K1');

                $sheet->row(1, ['Reporte de reservaciones de locales: ' . $fecha[0] . ' - ' . $fecha[1]]);

                $sheet->row(2, ['ID', 'Código', 'Tipo', 'Usuario', 'Local', 'Fecha', 'Hora inicio', 'Hora fin', 'Asignatura', 'Actividad', 'Tema']);

                /**
                 * Datos del archivo.
                 */

                foreach ($reservaciones as $reservacion) {
                	$fila = [];
                    $fila[0]  = $reservacion->id;
                    $fila[1]  = $reservacion->codigo;
                    $fila[2]  = $reservacion->tipo;
                    $fila[3]  = $reservacion->user->name . ' ' . $reservacion->user->lastname;
                	$fila[4]  = $reservacion->local->nombre;
                	$fila[5]  = $reservacion->fecha;
                	$fila[6]  = $reservacion->hora_inicio;
                	$fila[7]  = $reservacion->hora_fin;
                    $fila[8]  = $reservacion->asignatura->codigo . ' - ' . $reservacion->asignatura->nombre;
                    $fila[9]  = $reservacion->actividad->nombre;
                	$fila[10] = $reservacion->tema;
                	$sheet->appendRow($fila);
                }
            });
        })->export('xls');
    }
}
