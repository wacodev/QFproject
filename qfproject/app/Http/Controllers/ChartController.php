<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;
use qfproject\Http\Requests;
use DB;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use qfproject\Local;
use qfproject\Reservacion;
use Storage;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
       return view('statistics.chart-uno');

    }

       public function locales(Request $request){
       $this->validate(request(), [
            'fecha' => 'required'
       
        ]);

        $fecha = explode(' - ', $request->fecha);


        $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
        $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');
        $hora_inicio = Carbon::parse($request->get('hora_inicio'))->format('H:i:s');
        $hora_fin = Carbon::parse($request->get('hora_fin'))->format('H:i:s');
        

        $pastel =DB::table('reservaciones')
      ->join('locales', 'reservaciones.local_id', '=', 'locales.id')
      ->whereBetween('fecha', [$fecha[0], $fecha[1]])
      ->where('hora_inicio', '>=', [$hora_inicio])
      ->where('hora_fin', '<=', [$hora_fin])
      ->select('reservaciones.*', 'locales.nombre')
      ->select(DB::raw("nombre, count(*) as id"))
      ->groupBy('nombre')
      ->get();
  
      
       return view('statistics.chart1', ['pastel'=>$pastel]);

    }

    public function porActividad()
    {
       return view('statistics.chart-dos');
    }


      public function actividades(Request $request)
    {

       $this->validate(request(), [
            'fecha' => 'required'
        ]);

        $fecha = explode(' - ', $request->fecha);

        $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
        $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');
        $hora_inicio = Carbon::parse($request->get('hora_inicio'))->format('H:i:s');
        $hora_fin = Carbon::parse($request->get('hora_fin'))->format('H:i:s');

      $pastel =DB::table('reservaciones')
      ->join('actividades', 'reservaciones.actividad_id', '=', 'actividades.id')
      ->whereBetween('fecha', [$fecha[0], $fecha[1]])
      ->where('hora_inicio', '>=', [$hora_inicio])
      ->where('hora_fin', '<=', [$hora_fin])
      ->select('reservaciones.*', 'actividades.nombre')
      ->select(DB::raw("nombre, count(*) as id"))
      ->groupBy('nombre')
      ->get();
       return view('statistics.chart2', ['pastel'=>$pastel]);
    }


     public function porAsignatura()
    {
       return view('statistics.chart-tres');
    }


      public function asignaturas(Request $request)
    {

       $this->validate(request(), [
            'fecha' => 'required'
        ]);

        $fecha = explode(' - ', $request->fecha);

        $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
        $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');
        $hora_inicio = Carbon::parse($request->get('hora_inicio'))->format('H:i:s');
        $hora_fin = Carbon::parse($request->get('hora_fin'))->format('H:i:s');

      $pastel =DB::table('reservaciones')
      ->join('asignaturas', 'reservaciones.asignatura_id', '=', 'asignaturas.id')
      ->whereBetween('fecha', [$fecha[0], $fecha[1]])
      ->where('hora_inicio', '>=', [$hora_inicio])
      ->where('hora_fin', '<=', [$hora_fin])
      ->select('reservaciones.*', 'asignaturas.nombre')
      ->select(DB::raw("nombre, count(*) as id"))
      ->groupBy('nombre')
      ->get();
       return view('statistics.chart3', ['pastel'=>$pastel]);
    }


     public function porUsuarios()
    {
       return view('statistics.chart-cuatro');
    }


      public function usuarios(Request $request)
    {

       $this->validate(request(), [
            'fecha' => 'required'
        ]);

        $fecha = explode(' - ', $request->fecha);

        $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
        $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');
        $hora_inicio = Carbon::parse($request->get('hora_inicio'))->format('H:i:s');
        $hora_fin = Carbon::parse($request->get('hora_fin'))->format('H:i:s');


      $pastel =DB::table('reservaciones')
      ->join('users', 'reservaciones.user_id', '=', 'users.id')
      ->whereBetween('fecha', [$fecha[0], $fecha[1]])
      ->where('hora_inicio', '>=', [$hora_inicio])
      ->where('hora_fin', '<=', [$hora_fin])
      ->select('reservaciones.*', 'users.name')
      ->select(DB::raw("name, count(*) as id"))
      ->groupBy('name')
      ->get();
       return view('statistics.chart4', ['pastel'=>$pastel]);
    }



}
