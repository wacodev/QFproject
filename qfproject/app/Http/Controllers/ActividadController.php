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

class ActividadController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de actividades.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $actividades = Actividad::where('nombre', 'like', '%' . $query . '%')
                ->orderBy('nombre', 'asc')
                ->paginate(10);
        }
        return view('administracion.actividades.index')
            ->with('actividades', $actividades)
            ->with('searchText', $query);
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
     * @param  qfproject\Http\Requests\ActividadRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(ActividadRequest $request)
    {
        $actividad = new Actividad($request->all());
        $actividad->save();
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La actividad "' . $actividad->nombre . '" se ha guardado correctamente.
            </p>
        ')
            ->success()
            ->important();
        return redirect()->route('actividades.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra la actividad especificada.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function show($id)
    {
        //
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
        $actividad->fill($request->all());
        $actividad->save();
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
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
        $actividad->delete();
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La actividad ha sido eliminada correctamente.
            </p>
        ')
            ->success()
            ->important();
        return redirect()->route('actividades.index');
    }
}
