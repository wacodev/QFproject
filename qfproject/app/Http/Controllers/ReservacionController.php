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
use qfproject\Actividad;
use qfproject\Asignatura;
use qfproject\Asueto;
use qfproject\Local;
use qfproject\Reservacion;
use qfproject\Suspension;

class ReservacionController extends Controller
{
    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de reservaciones.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $reservaciones = Reservacion::where('fecha', 'like', '%' . $query . '%')
                ->orWhere('hora_inicio', 'like', '%' . $query . '%')
                ->orWhere('hora_fin', 'like', '%' . $query . '%')
                ->orderBy('fecha', 'desc')
                ->paginate(10);
        }

        return view('reservaciones.index')
            ->with('reservaciones', $reservaciones)
            ->with('searchText', $query);
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario del paso uno para crear una nueva reservación.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function create()
    {
        return view('reservaciones.paso-uno');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena una reservación recién creada en la base de datos.
     * 
     * @param  qfproject\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function store(Request $request)
    {
        //
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra la reservación especificada.
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
     * Muestra el formulario para editar la reservación especificada.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function edit($id)
    {
        $reservacion = Reservacion::find($id);
        $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');
        $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

        return view('reservaciones.edit')
            ->with('reservacion', $reservacion)
            ->with('asignaturas', $asignaturas)
            ->with('actividades', $actividades);
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza la reservación especificada en la base de datos.
     * 
     * @param  qfproject\Http\Requests\SuspensionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'asignatura_id' => 'required',
            'actividad_id'  => 'required'
        ]); 

        $reservacion = Reservacion::find($id);
        $reservacion->fill($request->all());
        $reservacion->save();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La reservación se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('home');
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina la reservación especificada de la base de datos.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroy($id)
    {
        $reservacion = Reservacion::find($id);
        $reservacion->delete();

        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La reservacion ha sido eliminada correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('home');
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida la fecha, hora de inicio y hora de finalización de la reservación.
     * Obtiene los locales disponibles para los parámetros anteriores y muestra
     * el formulario del paso dos para crear una nueva reservación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function hacerPasoUno(Request $request)
    {
        $this->validate(request(), [
            'fecha'       => 'date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'hora_inicio' => 'required|after_or_equal:07:00:00|before_or_equal:17:00:00',
            'hora_fin'    => 'required|after:hora_inicio|before_or_equal:18:00:00',
        ]);

        $reservacion = new Reservacion($request->all());

        $reservacion->fecha = Carbon::parse($reservacion->fecha)->format('Y-m-d');
        $reservacion->hora_inicio = Carbon::parse($reservacion->hora_inicio)->format('H:i:s');
        $reservacion->hora_fin = Carbon::parse($reservacion->hora_fin)->format('H:i:s');

        $errorUno = $this->validarFechaHora($reservacion->fecha, $reservacion->hora_inicio, $reservacion->hora_fin);

        if ($errorUno != 'No hay errores') {
            flash('
                <h4>
                    <i class="fa fa-ban icono-margen-grande" aria-hidden="true"></i>¡Error en ingreso de datos!
                </h4>
                <p style="padding-left: 30px;">' . $errorUno . '</p>
            ')
                ->error()
                ->important();
            return back();
        }

        $errorDos = $this->validarAsuetoSuspension($reservacion->fecha, $reservacion->hora_inicio, $reservacion->hora_fin);
        
        if ($errorDos != 'No hay errores')
        {
            flash('
                <h4>
                    <i class="fa fa-exclamation-triangle icono-margen-grande" aria-hidden="true"></i>¡No puedes hacer una reservación para esa fecha y hora!
                </h4>
                <p style="padding-left: 34px;">' . $errorDos . '</p>
            ')
                ->warning()
                ->important();
            return back();
        }

        $locales_disponibles = $this->obtenerLocalesDisponibles($reservacion->fecha, $reservacion->hora_inicio, $reservacion->hora_fin);        

        if ($locales_disponibles == null)
        {
            flash('
                <h4>
                    <i class="fa fa-exclamation-triangle icono-margen-grande" aria-hidden="true"></i>¡No hay locales disponibles!
                </h4>
                <p style="padding-left: 34px;">
                    Lo sentimos, para la fecha y hora que ingresaste no hay ningún local disponible.
                </p>
            ')
                ->warning()
                ->important();
            return back();
        }

        return view('reservaciones.paso-dos')
            ->with('reservacion', $reservacion)
            ->with('locales_disponibles', $locales_disponibles);
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida la selección del local y muestra el formulario del paso tres para
     * crear una nueva reservación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function hacerPasoDos(Request $request)
    {
        $this->validate(request(), [
            'local_id' => 'required'
        ]);

        $reservacion = new Reservacion($request->all());

        $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');
        $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

        return view('reservaciones.paso-tres')
            ->with('reservacion', $reservacion)
            ->with('asignaturas', $asignaturas)
            ->with('actividades', $actividades);
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida la selección de la asignatura y la actividad. Almacena la
     * reservación recién creada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function hacerPasoTres(Request $request)
    {
        $this->validate(request(), [
            'asignatura_id' => 'required',
            'actividad_id'  => 'required'
        ]);

        $reservacion = new Reservacion($request->all());

        $reservacion->fecha = Carbon::parse($reservacion->fecha)->format('Y-m-d');
        $reservacion->hora_inicio = Carbon::parse($reservacion->hora_inicio)->format('H:i:s');
        $reservacion->hora_fin = Carbon::parse($reservacion->hora_fin)->format('H:i:s');
        $reservacion->user_id = \Auth::user()->id;
        $reservacion->codigo = time() . '-' . $reservacion->asignatura_id . '-' . $reservacion->local_id . '-' . $reservacion->user_id;

        if ($reservacion->tipo == null) {
            $reservacion->tipo = 'Extraordinaria';
        }

        $reservacion->save();
        
        flash('
            <h4>
                <i class="fa fa-check icono-margen-grande" aria-hidden="true"></i>¡Bien hecho!
            </h4>
            <p style="padding-left: 34px;">
                La reservación ha sido guardada correctamente.
            </p>
        ')
            ->success()
            ->important();

        return redirect()->route('home');
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

    /**
     * ---------------------------------------------------------------------------
     * Verifica que la fecha y horas ingresadas no coincidan con asuetos o
     * suspensiones de actividades.
     * 
     * @param  date  $fecha
     * @param  time  $hora_inicio
     * @param  time  $hora_fin
     * @return string
     * ---------------------------------------------------------------------------
     */

    public function validarAsuetoSuspension($fecha, $hora_inicio, $hora_fin)
    {
        $asuetos = Asueto::all();

        $f = explode('-', $fecha);

        foreach ($asuetos as $asueto) {
            if ($f[1] == $asueto->mes && $f[2] == $asueto->dia) {
                return 'Para la fecha que ingresaste hay programado un asueto por ser: ' . $asueto->nombre . '.';
            }
        }

        $suspensiones = Suspension::where('fecha', '=', $fecha)->get();

        if ($suspensiones->count() > 0) {
            foreach ($suspensiones as $suspension) {
                if (($hora_inicio >= $suspension->hora_inicio && $hora_inicio < $suspension->hora_fin) || ($hora_fin <= $suspension->hora_fin && $hora_fin > $suspension->hora_inicio)) {
                    $suspension->fecha = Carbon::parse($suspension->fecha)->format('d/m/Y');
                    $suspension->hora_inicio = Carbon::parse($suspension->hora_inicio)->format('h:i A');
                    $suspension->hora_fin = Carbon::parse($suspension->hora_fin)->format('h:i A');
                    return 'Para la fecha ' . $suspension->fecha . ' hay programada una suspensión de actividades de ' . $suspension->hora_inicio . ' a ' . $suspension->hora_fin . '.';
                }
            }
        }

        return 'No hay errores';
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene los locales disponibles para reservar en la fecha y horas
     * ingresadas por el usuario.
     * 
     * @param  date  $fecha
     * @param  time  $hora_inicio
     * @param  time  $hora_fin
     * @return string
     * ---------------------------------------------------------------------------
     */

    public function obtenerLocalesDisponibles($fecha, $hora_inicio, $hora_fin)
    {
        $locales = Local::all();

        $reservaciones = Reservacion::where('fecha', '=', $fecha)
            ->where('hora_inicio', '>=', $hora_inicio)
            ->where('hora_inicio', '<', $hora_fin)
            ->orWhere('fecha', '=', $fecha)
            ->where('hora_fin', '<=', $hora_fin)
            ->where('hora_fin', '>', $hora_inicio)
            ->get();

        if ($reservaciones->count() <= 0) {
            return $locales;
        }

        $locales_disponibles = null;

        foreach ($locales as $local) {
            $i = 0;
            $disponible = true;            
            foreach ($reservaciones as $reservacion) {
                if ($reservacion->local_id == $local->id) {
                    $disponible = false;
                    break;
                }
            }
            if ($disponible == true) {
                $locales_disponibles[$i] = $local;
            }
            $i++;
        }

        return $locales_disponibles;
    }
}