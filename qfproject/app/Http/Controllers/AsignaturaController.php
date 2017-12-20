<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Laracasts\Flash\Flash;
use qfproject\Asignatura;
use qfproject\Http\Requests\AsignaturaRequest;

class AsignaturaController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de asignaturas.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $asignaturas = Asignatura::where('nombre', 'like', '%' . $query . '%')
                ->orWhere('codigo', 'like', '%' . $query . '%')
                ->orderBy('codigo', 'asc')
                ->paginate(10);
        }
        return view('administracion.asignaturas.index')
            ->with('asignaturas', $asignaturas)
            ->with('searchText', $query);
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear una nueva asignatura.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function create()
    {
        return view('administracion.asignaturas.create');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena una asignatura recién creada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\AsignaturaRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(AsignaturaRequest $request)
    {
        $asignatura = new Asignatura($request->all());
        $asignatura->save();
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
                </h4>
                <p style="padding-left: 34px;">
                    La asignatura "' . $asignatura->nombre . '" se ha guardado correctamente.
                </p>
        ')
            ->success()
            ->important();
        return redirect()->route('asignaturas.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra la asignatura especificada.
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
     * Muestra el formulario para editar la asignatura especificada.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        $asignatura = Asignatura::find($id);
        return view('administracion.asignaturas.edit')->with('asignatura', $asignatura);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza la asignatura especificada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\AsignaturaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(AsignaturaRequest $request, $id)
    {
        $asignatura = Asignatura::find($id);
        $asignatura->fill($request->all());
        $asignatura->save();
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La asignatura "' . $asignatura->nombre . '" se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();
        return redirect()->route('asignaturas.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina la asignatura especificada de la base de datos.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroy($id)
    {
        $asignatura = Asignatura::find($id);
        $asignatura->delete();
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La asignatura ha sido eliminada correctamente.
            </p>
        ')
            ->success()
            ->important();
        return redirect()->route('asignaturas.index');
    }
}
