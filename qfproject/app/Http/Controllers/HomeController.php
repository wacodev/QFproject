<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Carbon\Carbon;
use DB;
use Laracasts\Flash\Flash;
use qfproject\Actividad;
use qfproject\Asignatura;
use qfproject\Http\Requests\ActividadRequest;
use qfproject\Http\Requests\AsignaturaRequest;
use qfproject\Http\Requests\UserRequest;
use qfproject\Reservacion;
use qfproject\User;

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
     * Muestra una lista de reservaciones vigentes hechas por el usuario y un
     * panel con los datos del mismo.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $hoy = Carbon::now();

           $reservaciones=DB::table('reservaciones')
            ->join('locales', 'reservaciones.local_id', 'locales.id')
            ->join('asignaturas', 'reservaciones.asignatura_id', 'asignaturas.id')
            ->join('users', 'reservaciones.user_id', 'users.id')
            ->join('actividades', 'reservaciones.actividad_id', 'actividades.id')
            ->select('reservaciones.*', 'locales.nombre as local', 'locales.imagen as img', 'asignaturas.nombre as asignatura', 'asignaturas.codigo as cod', 'users.name as user', 'users.lastname as last', 'actividades.nombre as actividad')
            ->where('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
            ->where('user_id', '=', \Auth::user()->id)
            ->where('asignaturas.nombre', 'like', '%' . $query . '%')
            ->orWhere('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
            ->where('user_id', '=', \Auth::user()->id)
            ->where('locales.nombre', 'like', '%' . $query . '%')
            ->orWhere('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
            ->where('user_id', '=', \Auth::user()->id)
            ->where('actividades.nombre', 'like', '%' . $query . '%')
            ->orWhere('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
            ->where('user_id', '=', \Auth::user()->id)
            ->where('hora_inicio', 'like', '%' . $query . '%')
            ->orWhere('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
            ->where('user_id', '=', \Auth::user()->id)
            ->where('hora_fin', 'like', '%' . $query . '%')
            ->orWhere('fecha', '>=', Carbon::parse($hoy)->format('Y-m-d'))
            ->where('user_id', '=', \Auth::user()->id)
            ->where('responsable', 'like', '%' . $query . '%')
            ->orderBy('id', 'desc')
            ->paginate(15);

            foreach ($reservaciones as $reservacion) {
                $ft = explode(' ', $reservacion->created_at);
                $f = explode('-', $ft[0]);
                $t = explode(':', $ft[1]);

                $f_carbon = Carbon::create($f[0], $f[1], $f[2], $t[0], $t[1], $t[2]);

                $reservacion->created_at = $f_carbon->diffForHumans();
            }

            return view('home')
                ->with('reservaciones', $reservaciones)
                ->with('searchText', $query);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de todas las reservaciones hechas por el usuario.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function verHistorial(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $hoy_carbon = Carbon::now();

            $hoy = Carbon::parse($hoy_carbon)->format('Y-m-d');

            $reservaciones = Reservacion::where('user_id', '=', \Auth::user()->id)
                ->where('codigo', 'like', '%' . $query . '%')
                ->orWhere('user_id', '=', \Auth::user()->id)
                ->where('fecha', 'like', '%' . $query . '%')
                ->orWhere('user_id', '=', \Auth::user()->id)
                ->where('responsable', 'like', '%' . $query . '%')
                ->orderBy('fecha', 'desc')
                ->paginate(15);

            $reservaciones->each(function($reservaciones) {
                $reservaciones->user;
                $reservaciones->local;
                $reservaciones->asignatura;
                $reservaciones->actividad;
            });

            return view('reservaciones.historial')
                ->with('reservaciones', $reservaciones)
                ->with('hoy', $hoy)
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

    public function verNotificaciones()
    {
        $notificaciones = \Auth::user()
            ->notifications()
            ->where('type', '=', 'qfproject\Notifications\ReservacionNotification')
            ->paginate(15);

        return view('notificaciones')
            ->with('notificaciones', $notificaciones);
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina la notificación especificada de la base de datos.
     *
     * @param  int  $id
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

    /**
     * ---------------------------------------------------------------------------
     * Elimina las notificaciones del usuario de la base de datos.
     *
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function eliminarNotificaciones()
    {
        $notificaciones = \Auth::user()
            ->notifications()
            ->where('type', '=', 'qfproject\Notifications\ReservacionNotification');

        $notificaciones->delete();

        return back();
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para editar el usuario especificado.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function editarPerfil()
    {
        $user = User::find(\Auth::user()->id);

        return view('editar-perfil')->with('user', $user);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza el usuario especificado en la base de datos.
     * 
     * @param  qfproject\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function actualizarPerfil(UserRequest $request, $id)
    {
        $user = User::find($id);

        /**
         * Almacenando nueva imagen.
         */

        if ($request->file('imagen')) {
            $file = $request->file('imagen');

            $nombre = 'user_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path() . '/images/users/';

            $file->move($path, $nombre);

            /**
             * Eliminando imagen anterior.
             */

            if (\File::exists($path . $user->imagen) && $user->imagen != 'user_default.jpg') {
                \File::delete($path . $user->imagen);
            }

            /**
             * Guardando nueva imagen.
             */

            $user->imagen = $nombre;
        }

        $user->name = $request->get('name');
        $user->lastname = $request->get('lastname');
        $user->email = $request->get('email');
        $user->password = $request->get('password');

        $user->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                Tu perfil se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('home');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena una actividad recién creada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\ActividadRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function storeActividad(ActividadRequest $request)
    {
        $actividad = new Actividad($request->all());
        
        $actividad->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                La actividad "' . $actividad->nombre . '" se ha guardado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return back();
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena una asignatura recién creada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\AsignaturaRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function storeAsignatura(AsignaturaRequest $request)
    {
        $asignatura = new Asignatura($request->all());
        
        $asignatura->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
                </h4>
                <p class="check">
                    La asignatura "' . $asignatura->nombre . '" se ha guardado correctamente.
                </p>
        ')
            ->success()
            ->important();

        return back();
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de notificaciones de las acciones hechas por el usuario.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function verAcciones()
    {
        $acciones = \Auth::user()
            ->notifications()
            ->where('type', '=', 'qfproject\Notifications\TareaNotification')
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('acciones')
            ->with('acciones', $acciones);
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina las notificaciones de acción de la base de datos.
     *
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function eliminarAcciones()
    {
        $acciones = \Auth::user()
            ->notifications()
            ->where('type', '=', 'qfproject\Notifications\TareaNotification');

        $acciones->delete();

        return back();
    }
}