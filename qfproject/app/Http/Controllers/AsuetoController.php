<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Carbon\Carbon;
use Laracasts\Flash\Flash;
use qfproject\Asueto;
use qfproject\Http\Requests\AsuetoRequest;

class AsuetoController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de asuetos.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $asuetos = Asueto::where('nombre', 'like', '%' . $query . '%')
                ->orWhere('dia', 'like', '%' . $query . '%')
                ->orWhere('mes', 'like', '%' . $query . '%')
                ->orderBy('nombre', 'asc')
                ->paginate(10);
        }

        return view('administracion.asuetos.index')
            ->with('asuetos', $asuetos)
            ->with('searchText', $query);
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear un nuevo asueto.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function create()
    {
        return view('administracion.asuetos.create');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena un asueto recién creado en la base de datos.
     * 
     * @param  qfproject\Http\Requests\AsuetoRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(AsuetoRequest $request)
    {
        $fecha_formato = Carbon::parse($request->get('fecha'))->format('Y-m-d');

        $fecha = explode('-', $fecha_formato);

        $asueto = new Asueto;
        $asueto->nombre = $request->get('nombre');
        $asueto->dia = $fecha[2];
        $asueto->mes = $fecha[1];
        $asueto->save();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                El asueto por "' . $asueto->nombre . '" se ha guardado correctamente. Los usuarios no podrán realizar reservaciones para este día.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('asuetos.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el asueto especificado.
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
     * Muestra el formulario para editar el asueto especificado.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        $asueto = Asueto::find($id);

        return view('administracion.asuetos.edit')->with('asueto', $asueto);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza el asueto especificado en la base de datos.
     * 
     * @param  qfproject\Http\Requests\AsuetoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(AsuetoRequest $request, $id)
    {
        $asueto = Asueto::find($id);
        $asueto->fill($request->all());
        $asueto->save();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                El asueto por "' . $asueto->nombre . '" se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('asuetos.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina el asueto especificado de la base de datos.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroy($id)
    {
        $asueto = Asueto::find($id);
        $asueto->delete();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                El asueto ha sido eliminado correctamente. Ahora los usuarios podrán realizar reservaciones para ese día.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('asuetos.index');
    }
}
