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
     * @param  \Illuminate\Http\Request  $request
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

            return view('administracion.asuetos.index')
                ->with('asuetos', $asuetos)
                ->with('searchText', $query);
        }
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
     * @param  \qfproject\Http\Requests\AsuetoRequest  $request
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
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                El asueto por "' . $asueto->nombre . '" se ha guardado correctamente. Los usuarios no podrán realizar reservaciones para este día.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('asuetos.index');
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

        if (!$asignatura) {
            abort(404);
        }

        return view('administracion.asuetos.edit')->with('asueto', $asueto);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza el asueto especificado en la base de datos.
     * 
     * @param  \qfproject\Http\Requests\AsuetoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(AsuetoRequest $request, $id)
    {
        $asueto = Asueto::find($id);

        if (!$asignatura) {
            abort(404);
        }

        $asueto->fill($request->all());

        $asueto->save();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
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

        if (!$asignatura) {
            abort(404);
        }

        $asueto->delete();

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                El asueto ha sido eliminado correctamente. Ahora los usuarios podrán realizar reservaciones para ese día.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('asuetos.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear una nueva vacación.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function createVacacion()
    {
        return view('administracion.asuetos.create-vacacion');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena la vacación recién creada en la base de datos.
     * 
     * @param  \qfproject\Http\Requests\AsuetoRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function storeVacacion(AsuetoRequest $request)
    {
        /**
         * Convirtiendo fechas ingresadas al formato Y-m-d.
         */

        $fecha = explode(' - ', $request->fecha);

        $fecha[0] = Carbon::parse($fecha[0])->format('Y-m-d');
        $fecha[1] = Carbon::parse($fecha[1])->format('Y-m-d');

        /**
         * Obteniendo diferencia, en días, entre el limite inferior y superior del
         * rango de fechas.
         */

        $fi = explode('-', $fecha[0]);
        $ff = explode('-', $fecha[1]);

        $fi_carbon = Carbon::create($fi[0], $fi[1], $fi[2], 0);
        $ff_carbon = Carbon::create($ff[0], $ff[1], $ff[2], 0);

        $diferencia = $fi_carbon->diffInDays($ff_carbon);

        /**
         * Obteniendo datos solicitados por el usuario.
         */

        for ($i = 0; $i <= $diferencia; $i++) {
            $fecha_formato = Carbon::parse($fi_carbon)->format('Y-m-d');

            $f = explode('-', $fecha_formato);

            $asueto = new Asueto;
            
            $asueto->nombre = $request->get('nombre');
            $asueto->dia = $f[2];
            $asueto->mes = $f[1];
            
            $asueto->save();

            $fi_carbon = $fi_carbon->addDays(1);
        }

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                La vacación por "' . $asueto->nombre . '" se ha guardado correctamente en un total de ' . $i++ . ' días. Los usuarios no podrán realizar reservaciones en estos días.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('asuetos.index');
    }
}
