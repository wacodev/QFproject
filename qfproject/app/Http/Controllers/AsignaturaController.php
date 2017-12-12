<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/*
 * ---------------------------------------------------------------------------
 * Clases agregadas por el autor.
 * ---------------------------------------------------------------------------
 */

use qfproject\Http\Requests\AsignaturaRequest;
use qfproject\Asignatura;
use Laracasts\Flash\Flash;
use DB;

class AsignaturaController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            DB::beginTransaction();
            if ($request)
            {
                $query = trim($request->get('searchText'));
                $asignaturas = Asignatura::where('nombre', 'like', '%' . $query . '%')
                    ->orWhere('codigo', 'like', '%' . $query . '%')
                    ->orderBy('codigo', 'asc')
                    ->paginate(10);
                return view('administracion.asignaturas.index')
                    ->with('asignaturas', $asignaturas)
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
        return view('administracion.asignaturas.create');
    }

    public function store(AsignaturaRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $asignatura = new Asignatura($request->all());
            $asignatura->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
        	DB::rollback();
        	abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La asignatura "' . $asignatura->nombre . '" se ha guardado correctamente.')
            ->success()
            ->important();
        return redirect()->route('asignaturas.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $asignatura = Asignatura::find($id);
        return view('administracion.asignaturas.edit')
            ->with('asignatura', $asignatura);
    }

    public function update(AsignaturaRequest $request, $id)
    {
        try
        {
        	DB::beginTransaction();
            $asignatura = Asignatura::find($id);
            $asignatura->fill($request->all());
            $asignatura->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La asignatura "' . $asignatura->nombre . '" se ha editado correctamente.')
            ->success()
            ->important();
        return redirect()->route('asignaturas.index');
    }

    public function destroy($id)
    {
        try
        {
        	DB::beginTransaction();
            $asignatura = Asignatura::find($id);
            $asignatura->delete();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>La asignatura ha sido eliminada correctamente.')
            ->success()
            ->important();
        return redirect()->route('asignaturas.index');
    }
}
