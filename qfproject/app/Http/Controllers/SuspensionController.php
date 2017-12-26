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
use qfproject\Http\Requests\SuspensionRequest;
use qfproject\Suspension;

class SuspensionController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de suspensiones.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $suspensiones = Suspension::where('fecha', 'like', '%' . $query . '%')
                ->orWhere('hora_inicio', 'like', '%' . $query . '%')
                ->orWhere('hora_fin', 'like', '%' . $query . '%')
                ->orderBy('fecha', 'desc')
                ->paginate(10);
        }

        return view('administracion.suspensiones.index')
            ->with('suspensiones', $suspensiones)
            ->with('searchText', $query);
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para crear una nueva suspensión.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function create()
    {
        return view('administracion.suspensiones.create');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena una suspensión recién creada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\SuspensionRequest  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(SuspensionRequest $request)
    {
        $suspension = new Suspension($request->all());

        $suspension->fecha = Carbon::parse($suspension->fecha)->format('Y-m-d');
        $suspension->hora_inicio = Carbon::parse($suspension->hora_inicio)->format('H:i:s');
        $suspension->hora_fin = Carbon::parse($suspension->hora_fin)->format('H:i:s');

        $error = $this->validarFechaHora($suspension->fecha, $suspension->hora_inicio, $suspension->hora_fin);

        if ($error != 'No hay errores') {
            flash('
                <h4>
                    <i class="fa fa-ban icono-margen-grande" aria-hidden="true"></i>¡Error en ingreso de datos!
                </h4>
                <p style="padding-left: 30px;">' . $error . '</p>
            ')
                ->error()
                ->important();
            return back();
        }

        $suspension->save();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La suspensión se ha guardado correctamente. Puede que algún usuario anteriormente haya realizado una reservación en la fecha y hora de la suspensión, en ese caso, la eliminación de dichas reservaciones debe realizarse manualmente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('suspensiones.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra la suspensión especificada.
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
     * Muestra el formulario para editar la suspensión especificada.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        //
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza la suspensión especificada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\SuspensionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(SuspensionRequest $request, $id)
    {
        //
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina la suspensión especificada de la base de datos.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroy($id)
    {
        $suspension = Suspension::find($id);
        $suspension->delete();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La suspensión ha sido eliminada correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('suspensiones.index');
    }

    /**
     * ---------------------------------------------------------------------------
     * Verifica que los minutos sean iguales a cero y que la hora de inicio sea
     * mayor a la hora actual, si la fecha ingresada es igual a la fecha actual.
     * 
     * @param  date  $fecha
     * @param  time  $hora_inicio
     * @param  time  $hora_fin
     * @return string
     * ---------------------------------------------------------------------------
     */

    public function validarFechaHora($fecha, $hora_inicio, $hora_fin)
    {
        $hi = explode(':', $hora_inicio);
        $hf = explode(':', $hora_fin);

        $fecha_actual = Carbon::now()->format('Y-m-d');
        $hora_actual = Carbon::now()->format('H:i:s');

        if ($hi[1] != '00' || $hf[1] != '00') {
            return 'No puedes ingresar minutos distintos a cero.';
        } elseif ($fecha == $fecha_actual && $hora_inicio < $hora_actual) {
            return 'Si la reservación se desea programar para el día de hoy no puede ingresar una hora inferior a la actual.';
        }

        return 'No hay errores';
    }
}
