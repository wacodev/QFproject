<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/*
 * ---------------------------------------------------------------------------
 * Clases agregadas por el autor.
 * ---------------------------------------------------------------------------
 */

use qfproject\Http\Requests\LocalRequest;
use qfproject\Local;
use Laracasts\Flash\Flash;
use DB;

class LocalController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            DB::beginTransaction();
            if ($request)
            {
                $query = trim($request -> get('searchText'));
                $locales = Local::where('nombre', 'like', '%' . $query . '%')
                    ->orderBy('nombre', 'asc')
                    ->paginate(10);
                return view('administracion.locales.index')
                    ->with('locales', $locales)
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
        return view('administracion.locales.create');
    }

    public function store(LocalRequest $request)
    {
        try
        {
            DB::beginTransaction();
            if ($request->file('imagen'))
            {
                $file = $request->file('imagen');
                $nombre = 'local_' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/images/locales/';
                $file->move($path, $nombre);
            }
            $local = new Local($request->all());
            if ($local->imagen)
            {
                $local->imagen = $nombre;
            }
            $local->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
        	DB::rollback();
        	abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>El local "' . $local->nombre . '" se ha guardado correctamente.')
            ->success()
            ->important();
        return redirect()->route('locales.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $local = Local::find($id);
        return view('administracion.locales.edit')
            ->with('local', $local);
    }

    public function update(LocalRequest $request, $id)
    {
        try
        {
        	DB::beginTransaction();
            /*
            if ($request->file('imagen'))
            {
                $file = $request->file('imagen');
                $nombre = 'local_' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/images/locales/';
                $file->move($path, $nombre);
            }
            if ($local->imagen)
            {
                $local->imagen = $nombre;
            }
            */
            $local = Local::find($id);
            $local->fill($request -> all());
            $local->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>El local "' . $local -> nombre . '" se ha editado correctamente.')
            ->success()
            ->important();
        return redirect()->route('locales.index');
    }

    public function destroy($id)
    {
        try
        {
        	DB::beginTransaction();
            $local = Local::find($id);
            $local->delete();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            abort(503);
        }
        flash('<h4>¡Bien hecho!</h4>El local ha sido eliminada correctamente.')
            ->success()
            ->important();
        return redirect()->route('locales.index');
    }
}
