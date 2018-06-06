<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Laracasts\Flash\Flash;
use qfproject\Actividad;
use qfproject\Http\Requests\ActividadRequest;
use qfproject\Notifications\ReservacionNotification;
use qfproject\Notifications\TareaNotification;
use qfproject\Reservacion;
use qfproject\User;

class ActividadController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de actividades.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            
            $actividades = Actividad::where('nombre', 'like', '%' . $query . '%')
                ->orderBy('nombre', 'asc')
                ->paginate(25);
            
            return view('administracion.actividades.index')
                ->with('actividades', $actividades)
                ->with('searchText', $query);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear una nueva actividad.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function create()
    {
        return view('administracion.actividades.create');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena una actividad recién creada en la base de datos.
     * 
     * @param  \qfproject\Http\Requests\ActividadRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(ActividadRequest $request)
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

        return redirect()->route('actividades.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para editar la actividad especificada.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        $actividad = Actividad::find($id);

        if (!$actividad) {
            abort(404);
        }

        return view('administracion.actividades.edit')->with('actividad', $actividad);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza la actividad especificada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\ActividadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(ActividadRequest $request, $id)
    {
        $actividad = Actividad::find($id);

        if (!$actividad) {
            abort(404);
        }
        
        $actividad->fill($request->all());
        
        $actividad->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                La actividad "' . $actividad->nombre . '" se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('actividades.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina la actividad especificada de la base de datos.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroy($id)
    {
        $actividad = Actividad::find($id);

        if (!$actividad) {
            abort(404);
        }

        /**
         * Eliminando reservaciones registradas anteriormente con la actividad
         * recién eliminada.
         */

        $reservaciones = Reservacion::where('actividad_id', '=', $actividad->id)->get();

        $actividad->delete();

        /**
         * Notificando a los usuarios correspondientes la acción realizada.
         */

        $i = 0; // Número de reservaciones eliminadas.

        if ($reservaciones->count() > 0) {
            foreach ($reservaciones as $reservacion) {
                $reservacion->delete();

                if (\Auth::user()->id != $reservacion->user_id) {
                    $user = User::where('id', '=', $reservacion->user_id)->first();

                    $user->notify(new ReservacionNotification($reservacion, 'actividad', false));
                }

                \Auth::user()->notify(new TareaNotification($reservacion, 'eliminar'));

                $i++;
            }
        }

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                La actividad ha sido eliminada correctamente.
            </p>
            <p class="check">
                Reservaciones eliminadas por tener asignadas la actividad recién eliminada: ' . $i . '.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('actividades.index');
    }
}
