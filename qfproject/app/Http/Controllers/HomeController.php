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
        Carbon::setLocale('es');
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
        if ($request) {
            $query = trim($request->get('searchText'));

            $hoy = Carbon::now();

            $reservaciones = Reservacion::where('user_id', '=', \Auth::user()->id)
                ->where('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
                ->where('codigo', 'like', '%' . $query . '%')
                ->orWhere('user_id', '=', \Auth::user()->id)
                ->where('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
                ->where('fecha', 'like', '%' . $query . '%')
                ->orderBy('fecha', 'desc')
                ->paginate(5);

            $reservaciones->each(function($reservaciones) {
                $reservaciones->user;
                $reservaciones->local;
                $reservaciones->asignatura;
                $reservaciones->actividad;
            });

            return view('home')
                ->with('reservaciones', $reservaciones)
                ->with('searchText', $query);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de notificaciones del usuario.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function verNotificaciones(Request $request)
    {
        $notificaciones = \Auth::user()
            ->notifications()
            ->paginate(5);

        return view('notificaciones')
            ->with('notificaciones', $notificaciones);
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina la notificación especificada de la base de datos.
     *
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function eliminarNotificacion($id)
    {
        $notificacion = \Auth::user()
            ->notifications()
            ->where('id', '=', $id);

        $notificacion->delete();

        return back();
    }
}
