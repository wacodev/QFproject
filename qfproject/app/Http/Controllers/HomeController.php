<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Carbon\Carbon;
use qfproject\Reservacion;

class HomeController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Crea una nueva instancia de controlador.
     *
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de reservaciones hechas por el usuario y un panel con los
     * datos del mismo.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $reservaciones = Reservacion::where('user_id', '=', \Auth::user()->id)
                ->where('fecha', '>=', Carbon::now())
                ->where('codigo', 'like', '%' . $query . '%')
                ->orWhere('user_id', '=', \Auth::user()->id)
                ->where('fecha', '>=', Carbon::now())
                ->where('fecha', 'like', '%' . $query . '%')
                ->orderBy('fecha', 'desc')
                ->paginate(5);
            $reservaciones->each(function($reservaciones) {
                $reservaciones->user;
                $reservaciones->local;
                $reservaciones->asignatura;
                $reservaciones->actividad;
            });
        }
        return view('home')
            ->with('reservaciones', $reservaciones)
            ->with('searchText', $query);
    }
}
