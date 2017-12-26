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

class LocalController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de locales.
     * 
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
        }

        return view('administracion.locales.index')
            ->with('locales', $locales)
            ->with('searchText', $query);
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
     * @param  qfproject\Http\Requests\LocalRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(LocalRequest $request)
    {
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
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                El local "' . $local->nombre . '" se ha guardado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('locales.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el local especificado.
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
     * Muestra el formulario para editar el local especificado.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        $local = Local::find($id);

        return view('administracion.locales.edit')->with('local', $local);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza el local especificado en la base de datos.
     * 
     * @param  qfproject\Http\Requests\LocalRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(LocalRequest $request, $id)
    {
        $local = Local::find($id);

        if ($request->file('imagen'))
        {
            $file = $request->file('imagen');
            $nombre = 'local_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/images/locales/';
            $file->move($path, $nombre);
            $local->imagen = $nombre;
        }

        $local->nombre = $request->get('nombre');
        $local->capacidad = $request->get('capacidad');
        $local->save();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
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
        $local->delete();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                El local ha sido eliminada correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('locales.index');
    }
}
