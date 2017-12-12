<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/*
 * ---------------------------------------------------------------------------
 * Clases agregadas por el autor.
 * ---------------------------------------------------------------------------
 */

use qfproject\Http\Requests\ActividadRequest;
use qfproject\Actividad;
use Laracasts\Flash\Flash;
use DB;

class ActividadController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            DB::beginTransaction();
            if ($request)
            {
                $query = trim($request->get('searchText'));
                $actividades = Actividad::where('nombre', 'like', '%' . $query . '%')->orderBy('nombre', 'asc')->paginate(10);
                return view('administracion.actividades.index')
                    ->with('actividades', $actividades)
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
        return view('administracion.actividades.create');
    }

    public function store(ActividadRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $actividad = new Actividad($request->all());
            $actividad->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
        	DB::rollback();
        	abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La actividad "' . $actividad->nombre . '" se ha guardado correctamente.')
            ->success()
            ->important();
        return redirect()->route('actividades.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $actividad = Actividad::find($id);
        return view('administracion.actividades.edit')->with('actividad', $actividad);
    }

    public function update(ActividadRequest $request, $id)
    {
        try
        {
        	DB::beginTransaction();
            $actividad = Actividad::find($id);
            $actividad->fill($request->all());
            $actividad->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La actividad "' . $actividad->nombre . '" se ha editado correctamente.')->success()->important();
        return redirect()->route('actividades.index');
    }

    public function destroy($id)
    {
        try
        {
        	DB::beginTransaction();
            $actividad = Actividad::find($id);
            $actividad->delete();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La actividad ha sido eliminada correctamente.')
            ->success()
            ->important();
        return redirect()->route('actividades.index');
    }
}
