<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;
use qfproject\Http\Requests;
use DB;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $pastel = DB::select("select count('id') as cantidad, nombre as local from locales inner join reservaciones on locales.id = reservaciones.local_id group by nombre");
       return view('statistics.chart-uno', ['pastel'=>$pastel]);
    }

      public function porActividad()
    {
      $pastel = DB::select("select count('id') as cantidad, nombre as actividad from actividades inner join reservaciones on actividades.id = reservaciones.actividad_id group by nombre");
       return view('statistics.chart-dos', ['pastel'=>$pastel]);

    }

     public function porAsignatura()
    {
      $barra = DB::select("select count('id') as cantidad, nombre as asignatura from asignaturas inner join reservaciones on asignaturas.id = reservaciones.asignatura_id group by nombre");
       return view('statistics.chart-tres', ["barra"=>$barra]);
     

    }

     public function porUsuarios()
    {
      $pastel = DB::select("select count('id') as cantidad, name as usuarios from users inner join reservaciones on users.id = reservaciones.user_id group by name");
       return view('statistics.chart-cuatro', ['pastel'=>$pastel]);
        
    }



}
