<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Laracasts\Flash\Flash;
use qfproject\Http\Requests\LocalRequest;
use qfproject\Local;
use qfproject\Notifications\ReservacionNotification;
use qfproject\Reservacion;
use qfproject\User;

class LocalController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de locales.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request -> get('searchText'));

            $locales = Local::where('nombre', 'like', '%' . $query . '%')
                ->orderBy('nombre', 'asc')
                ->paginate(10);

            return view('administracion.locales.index')
                ->with('locales', $locales)
                ->with('searchText', $query);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear un nuevo local.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function create()
    {
        return view('administracion.locales.create');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena un local recién creado en la base de datos.
     * 
     * @param  \qfproject\Http\Requests\LocalRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(LocalRequest $request)
    {
        /**
         * Almacenando imagen.
         */

        if ($request->file('imagen')) {
            $file = $request->file('imagen');

            $nombre = 'local_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path() . '/images/locales/';

            $file->move($path, $nombre);
        }

        $local = new Local($request->all());

        if ($local->imagen) {
            $local->imagen = $nombre;
        }

        $local->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                El local "' . $local->nombre . '" se ha guardado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('locales.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para editar el local especificado.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        $local = Local::find($id);

        if (!$local) {
            abort(404);
        }

        return view('administracion.locales.edit')->with('local', $local);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza el local especificado en la base de datos.
     * 
     * @param  \qfproject\Http\Requests\LocalRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(LocalRequest $request, $id)
    {

        $local = Local::find($id);

        if (!$local) {
            abort(404);
        }

        /**
         * Almacenando nueva imagen.
         */

        if ($request->file('imagen')) {
            $file = $request->file('imagen');

            $nombre = 'local_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path() . '/images/locales/';

            $file->move($path, $nombre);

            /**
             * Eliminando imagen anterior.
             */

            if (\File::exists($path . $local->imagen) && $local->imagen != 'local_default.jpg') {
                \File::delete($path . $local->imagen);
            }

            /**
             * Guardando nueva imagen.
             */

            $local->imagen = $nombre;
        }

        $local->nombre = $request->get('nombre');
        $local->capacidad = $request->get('capacidad');

        $local->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                El local "' . $local -> nombre . '" se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('locales.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina el local especificado de la base de datos.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroy($id)
    {
        $local = Local::find($id);

        if (!$local) {
            abort(404);
        }

        /**
         * Eliminando reservaciones registradas anteriormente con el local
         * recién eliminado.
         */

        $reservaciones = Reservacion::where('local_id', '=', $local->id)
            ->where('tipo', '=', 'Extraordinaria')
            ->get();

        $local->delete();

        /**
         * Notificando a los usuarios correspondientes la acción realizada.
         */

        $i = 0; // Número de reservaciones eliminadas.

        if ($reservaciones->count() > 0) {
            foreach ($reservaciones as $reservacion) {
                $reservacion->delete();

                if (\Auth::user()->id != $reservacion->user_id) {
                    $user = User::where('id', '=', $reservacion->user_id)->first();

                    $user->notify(new ReservacionNotification($reservacion, 'local', false));
                }

                $i++;
            }
        }

        /**
         * Eliminando imagen.
         */

        $path = public_path() . '/images/locales/';

        if (\File::exists($path . $local->imagen) && $local->imagen != 'local_default.jpg') {
            \File::delete($path . $local->imagen);
        }

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                El local ha sido eliminado correctamente.
            </p>
            <p class="check">
                Reservaciones extraordinarias eliminadas por tener asignadas el local recién eliminado: ' . $i . '.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('locales.index');
    }
}
