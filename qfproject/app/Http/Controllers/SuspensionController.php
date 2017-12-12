<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/*
 * ---------------------------------------------------------------------------
 * Clases agregadas por el autor.
 * ---------------------------------------------------------------------------
 */

use qfproject\Http\Requests\SuspensionRequest;
use qfproject\Suspension;
use Laracasts\Flash\Flash;
use DB;
use Carbon\Carbon;

class SuspensionController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            DB::beginTransaction();
            if ($request)
            {
                $query = trim($request->get('searchText'));
                $suspensiones = Suspension::where('fecha', 'like', '%' . $query . '%')->orderBy('fecha', 'desc')->paginate(10);
                return view('administracion.suspensiones.index')
                	->with('suspensiones', $suspensiones)
                	->with('searchText', $query);
            }
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            abort(503);
        }
    }

    public function create()
    {
        return view('administracion.suspensiones.create');
    }

    public function store(SuspensionRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $suspension = new Suspension($request->all());
            
            /*
             * ---------------------------------------------------------------------------
             * Convirtiendo fechas y horas al formato correcto de la base de datos.
             * ---------------------------------------------------------------------------
             */

            $suspension->fecha = Carbon::parse($suspension->fecha)->format('Y-m-d');
            $suspension->hora_inicio = Carbon::parse($suspension->hora_inicio)->format('H:i:s');
            $suspension->hora_fin = Carbon::parse($suspension->hora_fin)->format('H:i:s');
            
            /*
             * ---------------------------------------------------------------------------
             * Validando que la fecha no sea menor a la actual, que la hora de inicio no
             * sea mayor o igual a la hora de finalización, que los minutos no sean
             * distintos a "00", que si la fecha de suspensión es igual a la fecha actual,
             * la hora de inicio sea mayor a la hora actual y que la hora ingresada se
             * encuentre entre las 7:00 AM a 6:00 PM.
             * ---------------------------------------------------------------------------
             */

            $hi = explode(':', $suspension->hora_inicio);
            $hf = explode(':', $suspension->hora_fin);
            $fecha_actual = Carbon::now()->format('Y-m-d');
            $hora_actual = Carbon::now()->format('H:i:s');
            if ($suspension->fecha < $fecha_actual)
            {
                flash('<h4>¡Error en ingreso de datos!</h4>No puedes programar una suspensión de actividades en un día anterior a la fecha actual.')
                    ->error()
                    ->important();
                return back();
            }
            if ($suspension->hora_inicio >= $suspension->hora_fin)
            {
                flash('<h4>¡Error en ingreso de datos!</h4>La hora de inicio no puede ser mayor o igual a la hora de finalización.')
                    ->error()
                    ->important();
                return back();
            }
            if ($hi[1] != '00' || $hf[1] != '00')
            {
                flash('<h4>¡Error en ingreso de datos!</h4>No puedes ingresar minutos distintos a cero.')
                    ->error()
                    ->important();
                return back();
            }
            if ($suspension->fecha == $fecha_actual && $suspension->hora_inicio < $hora_actual)
            {
                flash('<h4>¡Error en ingreso de datos!</h4>No puedes programar una suspensión de actividades en una hora anterior a la hora actual')
                    ->error()
                    ->important();
                return back();
            }
            if ($suspension->hora_inicio < '07:00:00' || $suspension->hora_inicio > '18:00:00' || $suspension->hora_fin < '07:00:00' || $suspension->hora_fin >'18:00:00')
            {
                flash('<h4>¡Error en ingreso de datos!</h4>Solo puedes ingresar horas comprendidas entre las 7:00 AM y 6:00 PM')
                    ->error()
                    ->important();
                return back();
            }

            $suspension->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
        	DB::rollback();
        	abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La suspensión se ha guardado correctamente. Puede que algún usuario anteriormente haya realizado una reservación en la fecha y hora de la suspensión, en ese caso, la eliminación de dichas reservaciones debe realizarse manualmente.')
        	->success()
        	->important();
        return redirect()->route('suspensiones.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(SuspensionRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try
        {
        	DB::beginTransaction();
            $suspension = Suspension::find($id);
            $suspension->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La suspensión ha sido eliminada correctamente.')
        	->success()
        	->important();
        return redirect()->route('suspensiones.index');
    }
}
