<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Carbon\Carbon;
use DB;
use Laracasts\Flash\Flash;
use qfproject\Actividad;
use qfproject\Asignatura;
use qfproject\Asueto;
use qfproject\Local;
use qfproject\Notifications\ReservacionNotification;
use qfproject\Reservacion;
use qfproject\Suspension;
use qfproject\User;

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
            
            $reservaciones->each(function($reservaciones) {
                $reservaciones->user;
                $reservaciones->local;
                $reservaciones->asignatura;
                $reservaciones->actividad;
            });

            return view('reservaciones.index')
                ->with('reservaciones', $reservaciones)
                ->with('searchText', $query);
        }
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
        /**
         * Validando acceso para mostrar la reservación especificada.
         */

        $tipo = \Auth::user()->tipo;
        
        if ($tipo == 'Administrador' || $tipo == 'Asistente') {
            $reservacion = Reservacion::find($id);

            return view('reservaciones.show')->with('reservacion', $reservacion);
        } else {
            return abort(503);
        }
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

        /**
         * Validando acceso para editar la reservación especificada.
         */

        $acceso = false;
        
        switch ($reservacion->user->tipo) {
            case 'Administrador':
                if (\Auth::user()->id == $reservacion->user_id) {
                    $acceso = true;
                }
                
                break;
            
            case 'Asistente':
                if (\Auth::user()->tipo == 'Administrador' || \Auth::user()->id == $reservacion->user_id) {
                    $acceso = true;
                }
                
                break;
            
            case 'Docente':
                $acceso = true;
                
                break;
        }

        if ($acceso) {
            $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');
            
            $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

            return view('reservaciones.edit')
                ->with('reservacion', $reservacion)
                ->with('asignaturas', $asignaturas)
                ->with('actividades', $actividades);
        } else {
            return abort(503);
        }
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
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'asignatura_id' => 'required',
            'actividad_id'  => 'required'
        ]);

        $reservacion = Reservacion::find($id);
        
        $reservacion->fill($request->all());
        
        $reservacion->save();

        /**
         * Notificando a los usuarios correspondientes la acción realizada.
         */

        $this->notificar($reservacion, 'editar');

        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                La reservación se ha editado correctamente.
            </p>
        ')
            ->success()
            ->important();

        if (\Auth::user()->tipo == 'Administrador' || \Auth::user()->tipo == 'Asistente') {
            return redirect()->route('reservaciones.index');
        } else {
            return redirect()->route('home');
        }
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

        /**
         * Validando acceso para eliminar la reservación especificada.
         */

        $acceso = false;
        
        switch ($reservacion->user->tipo) {
            case 'Administrador':
                if (\Auth::user()->id == $reservacion->user_id) {
                    $acceso = true;
                }
                
                break;
            
            case 'Asistente':
                if (\Auth::user()->tipo == 'Administrador' || \Auth::user()->id == $reservacion->user_id) {
                    $acceso = true;
                }
                
                break;
            
            case 'Docente':
                $acceso = true;
                
                break;
        }

        if ($acceso) {
            $reservacion->delete();

            /**
             * Notificando a los usuarios correspondientes la acción realizada.
             */

            $this->notificar($reservacion, 'eliminar');

            flash('
                <h4>
                    <i class="fa fa-check icon" aria-hidden="true"></i>
                    ¡Bien hecho!
                </h4>
                <p class="check">
                    La reservacion ha sido eliminada correctamente.
                </p>
            ')
                ->success()
                ->important();

            if (\Auth::user()->tipo == 'Administrador' || \Auth::user()->tipo == 'Asistente') {
                return redirect()->route('reservaciones.index');
            } else {
                return redirect()->route('home');
            }
        } else {
            return abort(503);
        }
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
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'fecha'       => 'date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'hora_inicio' => 'required|after_or_equal:07:00:00|before_or_equal:17:00:00',
            'hora_fin'    => 'required|after:hora_inicio|before_or_equal:18:00:00'
        ]);

        /**
         * Convirtiendo fecha al formato Y-m-d y horas al formato H:i:s.
         */

        $reservacion = new Reservacion($request->all());
        
        $reservacion->fecha = Carbon::parse($reservacion->fecha)->format('Y-m-d');
        $reservacion->hora_inicio = Carbon::parse($reservacion->hora_inicio)->format('H:i:s');
        $reservacion->hora_fin = Carbon::parse($reservacion->hora_fin)->format('H:i:s');
        
        /**
         * Validando que las horas ingresadas cumplan con las reglas del negocio.
         */
        
        $error = $this->validarHoras($reservacion->fecha, $reservacion->hora_inicio, $reservacion->hora_fin);
        
        if ($error[0]) {
            flash('
                <h4>
                    <i class="fa fa-ban icon" aria-hidden="true"></i>
                    ¡Error en ingreso de datos!
                </h4>
                <p class="ban">'
                    . $error[1] .
                '</p>
            ')
                ->error()
                ->important();
            
            return back();
        }

        /**
         * Asignando tipo de reservación Extraordinaria en caso que el usuario sea
         * de tipo Docente o no se haya llenado el campo en el formulario.
         */

        if ($reservacion->tipo == null) {
            $reservacion->tipo = 'Extraordinaria';
        }

        /**
         * Validaciones solo para las reservaciones de tipo Extraordinaria.
         */

        if ($reservacion->tipo == 'Extraordinaria') {

            /**
             * Validando que la fecha ingresada no coincide con un asueto.
             */
            
            $error = $this->validarAsueto($reservacion->fecha);
            
            if ($error[0])
            {
                flash('
                    <h4>
                        <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                        ¡No puedes hacer una reservación para esa fecha y hora!
                    </h4>
                    <p class="exclamation-triangle">'
                        . $error[1] .
                    '</p>
                ')
                    ->warning()
                    ->important();
                
                return back();
            }

            /**
             * Validando que la fecha ingresada no coincide con una suspensión de
             * actividades.
             */

            $error = $this->validarSuspension($reservacion->fecha, $reservacion->hora_inicio, $reservacion->hora_fin);
            
            if ($error[0])
            {
                flash('
                    <h4>
                        <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                        ¡No puedes hacer una reservación para esa fecha y hora!
                    </h4>
                    <p class="exclamation-triangle">'
                        . $error[1] .
                    '</p>
                ')
                    ->warning()
                    ->important();
                
                return back();
            }
        }
        
        /**
         * Obteniendo locales disponibles para la fecha y hora ingresada.
         */
        
        $locales_disponibles = $this->obtenerLocalesDisponibles($reservacion->fecha, $reservacion->hora_inicio, $reservacion->hora_fin);
        
        if ($locales_disponibles == null)
        {
            flash('
                <h4>
                    <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                    ¡No hay locales disponibles!
                </h4>
                <p class="exclamation-triangle">
                    Lo sentimos, para la fecha y hora que ingresaste no hay ningún local disponible.
                </p>
            ')
                ->warning()
                ->important();
            
            return back();
        } else {
            return view('reservaciones.paso-dos')
                ->with('reservacion', $reservacion)
                ->with('locales_disponibles', $locales_disponibles);
        }
        
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
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'local_id' => 'required'
        ]);

        /**
         * Obteniendo datos necesarios para el paso tres.
         */

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
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'asignatura_id' => 'required',
            'actividad_id'  => 'required'
        ]);

        /**
         * Convirtiendo fecha al formato Y-m-d y horas al formato H:i:s y
         * guardando todos los datos de la reservación.
         */

        $reservacion = new Reservacion($request->all());

        $reservacion->fecha = Carbon::parse($reservacion->fecha)->format('Y-m-d');
        $reservacion->hora_inicio = Carbon::parse($reservacion->hora_inicio)->format('H:i:s');
        $reservacion->hora_fin = Carbon::parse($reservacion->hora_fin)->format('H:i:s');
        $reservacion->user_id = \Auth::user()->id;

        /**
         * Generando código de comprobación.
         */

        $cr = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
        $ca = str_pad(substr($reservacion->asignatura_id, 0, 2), 2, '0', STR_PAD_LEFT);
        $cl = str_pad(substr($reservacion->local_id, 0, 2), 2, '0', STR_PAD_LEFT);
        $cu = str_pad(substr($reservacion->user_id, 0, 2), 2, '0', STR_PAD_LEFT);

        $reservacion->codigo = $cr . '-' . time() . '-' . $ca . '-' . $cl . '-' . $cu;

        /**
         * Validando que local aún está disponible.
         */

        $reservaciones = Reservacion::where('fecha', '=', $reservacion->fecha)
            ->where('hora_inicio', '>=', $reservacion->hora_inicio)
            ->where('hora_inicio', '<', $reservacion->hora_fin)
            ->where('local_id', '=', $reservacion->local_id)
            ->orWhere('fecha', '=', $reservacion->fecha)
            ->where('hora_fin', '<=', $reservacion->hora_fin)
            ->where('hora_fin', '>', $reservacion->hora_inicio)
            ->where('local_id', '=', $reservacion->local_id)
            ->get();

        if ($reservaciones->count() > 0) {
            flash('
                <h4>
                    <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                    ¡Algo ha salido mal!
                </h4>
                <p class="exclamation-triangle">
                    La reservación no pudo ser registrada. Otro usuario reservó el local mientras tú completabas el formulario.
                </p>
            ')
            ->warning()
            ->important();

            return redirect()->route('reservaciones.paso-uno');
        }

        $reservacion->save();

        /**
         * Notificando a los usuarios correspondientes la acción realizada.
         */

        if (\Auth::user()->tipo != 'Administrador') {
            
            /**
             * Obteniendo usuarios que se les enviará la notificación.
             */

            if (\Auth::user()->tipo == 'Asistente') {
                $users = User::where('tipo', '=', 'Administrador')
                    ->get();
            } else {
                $users = User::where('tipo', '=', 'Administrador')
                    ->orWhere('tipo', '=', 'Asistente')
                    ->get();
            }

            /**
             * Enviando notificaciones.
             */

            foreach ($users as $user) {
                $user->notify(new ReservacionNotification($reservacion, 'crear', true));
            }
        }
        
        flash('
            <h4>
                <i class="fa fa-check icon" aria-hidden="true"></i>
                ¡Bien hecho!
            </h4>
            <p class="check">
                La reservación ha sido guardada correctamente.
            </p>
        ')
            ->success()
            ->important();

        if (\Auth::user()->tipo == 'Administrador' || \Auth::user()->tipo == 'Asistente') {
            return redirect()->route('reservaciones.index');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario para registrar las mismas reservaciones de un periodo
     * anterior en futuras fechas.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function crearNuevoCiclo()
    {
        return view('reservaciones.crear-ciclo');
    }

    /**
     * ---------------------------------------------------------------------------
     * Almacena un conjunto de reservaciones en la base de datos. Utilizado para
     * el registro de reservaciones por ciclo.
     * 
     * @param  qfproject\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function registrarNuevoCiclo(Request $request)
    {
        /**
         * Validando datos de entrada.
         */
        
        $this->validate(request(), [
            'fecha'       => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'rango_fecha' => 'required'
        ]);
        
        /**
         * Convirtiendo fechas ingresadas al formato Y-m-d.
         */
        
        $fecha = Carbon::parse($request->fecha)->format('Y-m-d'); // Fecha de inicio del ciclo nuevo.
        
        $rango_fecha = explode(' - ', $request->rango_fecha); // Rango de fechas del ciclo anterior.
        $rango_fecha[0] = Carbon::parse($rango_fecha[0])->format('Y-m-d');
        $rango_fecha[1] = Carbon::parse($rango_fecha[1])->format('Y-m-d');
        
        /**
         * Validando que en el rango de fechas, el limite superior sea mayor al
         * limite inferior.
         */
        
        $error = $this->validarFechaMayor($rango_fecha[0], $rango_fecha[1]);
        
        if ($error) {
            flash('
                <h4>
                    <i class="fa fa-ban icon" aria-hidden="true"></i>
                    ¡Error en ingreso de datos!
                </h4>
                <p class="ban">
                    El limite superior del rango de fechas debe ser mayor al limite inferior.
                </p>
            ')
                ->error()
                ->important();
            
            return back();
        }
        
        /**
         * Validando que la fecha de inicio de ciclo sea mayor al limite superior
         * del rango de fechas.
         */
        
        $error = $this->validarFechaMayor($rango_fecha[1], $fecha);
        
        if ($error) {
            flash('
                <h4>
                    <i class="fa fa-ban icon" aria-hidden="true"></i>
                    ¡Error en ingreso de datos!
                </h4>
                <p class="ban">
                    La fecha de inicio de ciclo debe ser mayor al limite superior del rango de fechas.
                </p>
            ')
                ->error()
                ->important();
            
            return back();
        }
        
        /**
         * Obteniendo diferencia, en días, entre el limite inferior del rango de
         * fechas y la fecha de inicio de ciclo.
         */
        
        $li = explode('-', $rango_fecha[0]);
        $li_carbon = Carbon::create($li[0], $li[1], $li[2], 0);
        
        $f = explode('-', $fecha);
        $f_carbon = Carbon::create($f[0], $f[1], $f[2], 0);
        
        $diferencia = $li_carbon->diffInDays($f_carbon);
        
        /**
         * Obteniendo nuevo rango de fechas.
         */
        
        $li_nuevo = Carbon::parse($li_carbon->addDays($diferencia))->format('Y-m-d');
        
        $ls = explode('-', $rango_fecha[1]);
        $ls_carbon = Carbon::create($ls[0], $ls[1], $ls[2], 0);
        $ls_nuevo = Carbon::parse($ls_carbon->addDays($diferencia))->format('Y-m-d');
        
        /**
         * En caso de ocurrir un problema en algún registro toda la operación es
         * cancelada.
         */
        
        try {
            DB::beginTransaction();
            
            /**
             * Eliminando las reservaciones que se encuentran en el nuevo rango
             * de fechas.
             */
            
            $reservaciones_eliminar = Reservacion::where('fecha', '>=', $li_nuevo)
                ->where('fecha', '<=', $ls_nuevo)
                ->get();
            
            $re = 0; // Número de reservaciones eliminadas en el nuevo rango de fechas.
            
            if ($reservaciones_eliminar->count() > 0) {
                foreach ($reservaciones_eliminar as $reservacion_eliminar) {
                    $reservacion_eliminar->delete();
                    
                    $re++;
                }
            }
            
            /**
             * Obteniendo todas las reservaciones que se encuentren dentro del
             * rango de fechas original.
             */
            
            $reservaciones = Reservacion::where('fecha', '>=', $rango_fecha[0])
                ->where('fecha', '<=', $rango_fecha[1])
                ->where('tipo', '=', 'Ordinaria')
                ->get();
            
            /**
             * Registrando las reservaciones anteriores en sus correspondientes
             * fechas futuras.
             */
            
            // $ra = 0; // Número de reservaciones no registradas por coincidir con un asueto.
            
            $rr = 0; // Número de reservaciones registradas.
            
            if ($reservaciones->count() > 0) {
                foreach ($reservaciones as $reservacion) {

                    /**
                     * Obteniendo nueva fecha de la reservación.
                     */

                    $fn = explode('-', $reservacion->fecha);
                    $fn_carbon = Carbon::create($fn[0], $fn[1], $fn[2], 0);
                    $fecha_nueva = Carbon::parse($fn_carbon->addDays($diferencia))->format('Y-m-d');

                    $reservacion_nueva = new Reservacion;
                        
                    $reservacion_nueva->user_id = \Auth::user()->id;
                    $reservacion_nueva->local_id = $reservacion->local_id;
                    $reservacion_nueva->asignatura_id = $reservacion->asignatura_id;
                    $reservacion_nueva->actividad_id = $reservacion->actividad_id;
                    $reservacion_nueva->fecha = $fecha_nueva;
                    $reservacion_nueva->hora_inicio = $reservacion->hora_inicio;
                    $reservacion_nueva->hora_fin = $reservacion->hora_fin;
                    $reservacion_nueva->tema = $reservacion->tema;
                    $reservacion_nueva->tipo = 'Ordinaria';

                    /**
                     * Generando código de comprobación.
                     */

                    $cr = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                    $ca = str_pad(substr($reservacion_nueva->asignatura_id, 0, 2), 2, '0', STR_PAD_LEFT);
                    $cl = str_pad(substr($reservacion_nueva->local_id, 0, 2), 2, '0', STR_PAD_LEFT);
                    $cu = str_pad(substr($reservacion_nueva->user_id, 0, 2), 2, '0', STR_PAD_LEFT);

                    $reservacion_nueva->codigo = $cr . '-' . time() . '-' . $ca . '-' . $cl . '-' . $cu;

                    $reservacion_nueva->save();
                    
                    $rr++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            flash('
                <h4>
                    <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                    ¡Algo ha salido mal!
                </h4>
                <p class="exclamation-triangle">
                    Ocurrió un error y la operación ha sido cancelada. Intente nuevamente.
                </p>
            ')
                ->warning()
                ->important();
            
            return back();
        }

        flash('
            <h4>
                <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                Detalles de la operación
            </h4>
            <p class="info-circle">
                Se registraron ' . $rr . ' reservaciones de un total de ' . $reservaciones->count() . '.
            </p>
            <p class="info-circle">
                Reservaciones antiguas que fueron eliminadas: ' . $re . '.
            </p>
        ')
            ->info()
            ->important();
        
        return redirect()->route('reservaciones.index');
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
        /**
         * Obteniendo datos necesarios con los parámetros recibidos.
         */
        
        $locales = Local::all();

        $reservaciones = Reservacion::where('fecha', '=', $fecha)
            ->where('hora_inicio', '>=', $hora_inicio)
            ->where('hora_inicio', '<', $hora_fin)
            ->orWhere('fecha', '=', $fecha)
            ->where('hora_fin', '<=', $hora_fin)
            ->where('hora_fin', '>', $hora_inicio)
            ->get();

        /**
         * Si no hay ninguna reservación para la fecha y hora recibida se
         * entiende que todos los locales están disponibles en ese momento, caso
         * contrario se revisa cada reservación y se determina la disponibilidad
         * del local si éste no se encuentra seleccionado en ningún registro.
         */

        if ($reservaciones->count() <= 0) {
            return $locales;
        } else {
            $locales_disponibles = null;

            foreach ($locales as $local) {
                $i = 0; // Índice del arreglo de locales disponibles.
                
                $disponible = true;            
                
                foreach ($reservaciones as $reservacion) {
                    if ($reservacion->local_id == $local->id) {
                        $disponible = false;
                        
                        break;
                    }
                }
                
                if ($disponible) {
                    $locales_disponibles[$i] = $local;
                }
                
                $i++;
            }

            return $locales_disponibles;
        }
    }
    /**
     * ---------------------------------------------------------------------------
     * Verifica si la fecha ingresada coincide con un asueto.
     * 
     * @param  date  $fecha
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function validarAsueto($fecha)
    {
        $asuetos = Asueto::all();
        
        $f = explode('-', $fecha);
        
        foreach ($asuetos as $asueto) {
            if ($f[1] == $asueto->mes && $f[2] == $asueto->dia) {
                return [true, 'Para la fecha que ingresaste hay programado un asueto por ser: ' . $asueto->nombre . '.'];
            } else {
                return [false, null];
            }
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Verifica que el limite inferior sea menor al limite superior.
     * 
     * @param  date  $limite_inferior
     * @param  date  $limite_superior
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function validarFechaMayor($limite_inferior, $limite_superior)
    {
        if ($limite_inferior >= $limite_superior) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Verifica que los minutos sean iguales a cero y que la hora de inicio sea
     * mayor a la hora actual, si la fecha ingresada es igual a la fecha actual.
     * 
     * @param  date  $fecha
     * @param  time  $hora_inicio
     * @param  time  $hora_fin
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function validarHoras($fecha, $hora_inicio, $hora_fin)
    {
        $hi = explode(':', $hora_inicio);
        $hf = explode(':', $hora_fin);

        $fecha_actual = Carbon::now()->format('Y-m-d');
        
        $hora_actual = Carbon::now()->format('H:i:s');

        if ($hi[1] != '00' || $hf[1] != '00') {
            return [true, 'No puedes ingresar minutos distintos a cero.'];
        } elseif ($fecha == $fecha_actual && $hora_inicio < $hora_actual) {
            return [true, 'Si la reservación se desea programar para el día de hoy no puede ingresar una hora inferior a la actual.'];
        } else {
            return [false, null];
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Verifica que la fecha y horas ingresadas no coincidan con una suspensión
     * de actividades.
     * 
     * @param  date  $fecha
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function validarSuspension($fecha, $hora_inicio, $hora_fin)
    {
        $suspensiones = Suspension::where('fecha', '=', $fecha)->get();

        if ($suspensiones->count() > 0) {
            foreach ($suspensiones as $suspension) {
                if (($hora_inicio >= $suspension->hora_inicio && $hora_inicio < $suspension->hora_fin) || ($hora_fin <= $suspension->hora_fin && $hora_fin > $suspension->hora_inicio)) {
                    $suspension->fecha = Carbon::parse($suspension->fecha)->format('d/m/Y');
                    $suspension->hora_inicio = Carbon::parse($suspension->hora_inicio)->format('h:i A');
                    $suspension->hora_fin = Carbon::parse($suspension->hora_fin)->format('h:i A');
                    
                    return [true, 'Para la fecha ' . $suspension->fecha . ' hay programada una suspensión de actividades de ' . $suspension->hora_inicio . ' a ' . $suspension->hora_fin . '.'];
                }
            }
        } else {
            return [false, null];
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Crea y envia notificaciones de las acciones de editar y eliminar
     * reservaciones a los usuarios correspondientes.
     * 
     * @param  qfproject\Reservacion  $reservacion
     * @param  string  $tipo
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function notificar($reservacion, $tipo)
    {
        if (\Auth::user()->id == $reservacion->user_id) {

            /**
             * Cuando la acción fue realizada por el propietario de la
             * reservación.
             */

            if (\Auth::user()->tipo != 'Administrador') {
                if (\Auth::user()->tipo == 'Asistente') {
                    $users = User::where('tipo', '=', 'Administrador')
                        ->get();
                } else {
                    $users = User::where('tipo', '=', 'Administrador')
                        ->orWhere('tipo', '=', 'Asistente')
                        ->get();
                }

                foreach ($users as $user) {
                    $user->notify(new ReservacionNotification($reservacion, $tipo, true));
                }
            }
        } else {

            /**
             * Cuando la acción no fue realizada por el propietario de la
             * reservación.
             */

            if (\Auth::user()->tipo == 'Administrador') {
                $user = User::where('id', '=', $reservacion->user_id)->first();

                $user->notify(new ReservacionNotification($reservacion, $tipo, false));
            } else {
                $users = User::where('tipo', '=', 'Administrador')
                    ->orWhere('id', '=', $reservacion->user_id)
                    ->get();

                foreach ($users as $user) {
                    if ($user->tipo == 'Administrador') {
                        $user->notify(new ReservacionNotification($reservacion, $tipo, true));
                    } else {
                        $user->notify(new ReservacionNotification($reservacion, $tipo, false));
                    }
                }
            }
        }
    }
}