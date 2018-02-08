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
use qfproject\Notifications\TareaNotification;
use qfproject\Reservacion;
use qfproject\Suspension;
use qfproject\User;

class ReservacionController extends Controller
{
    /**************************** FUNCIONES BÁSICAS *****************************/

    /**
     * ---------------------------------------------------------------------------
     * Muestra una lista de reservaciones.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            

            $reservaciones=DB::table('reservaciones')
            ->join('locales', 'reservaciones.local_id', 'locales.id')
            ->join('asignaturas', 'reservaciones.asignatura_id', 'asignaturas.id')
            ->join('users', 'reservaciones.user_id', 'users.id')
            ->join('actividades', 'reservaciones.actividad_id', 'actividades.id')
            ->select('reservaciones.*', 'locales.nombre as local', 'asignaturas.nombre as asignatura', 'users.name as user', 'users.lastname as last', 'users.tipo as t', 'actividades.nombre as actividad')
            ->where('asignaturas.nombre', 'like', '%' .$query .'%')
            ->orWhere('locales.nombre', 'like', '%' .$query .'%')
            ->orWhere('users.name', 'like', '%' .$query .'%')
            ->orWhere('users.lastname', 'like', '%' .$query .'%')
            ->orWhere('actividades.nombre', 'like', '%' .$query .'%')
            ->orWhere('responsable', 'like', '%' .$query .'%')
            ->orWhere('fecha', 'like', '%' .$query .'%')
            ->orWhere('hora_inicio', 'like', '%' .$query .'%')
            ->orWhere('hora_fin', 'like', '%' .$query .'%')
            ->orderBy('id', 'desc')
            ->paginate(25);

            return view('reservaciones.index')
                ->with('reservaciones', $reservaciones)
                ->with('searchText', $query);
        }
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
        $reservacion = Reservacion::find($id);

        return view('reservaciones.show')->with('reservacion', $reservacion);
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

        $acceso = $this->acceder($reservacion->user->tipo, $reservacion->user_id);

        if ($acceso) {
            $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');
            
            $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

            return view('reservaciones.edit')
                ->with('reservacion', $reservacion)
                ->with('asignaturas', $asignaturas)
                ->with('actividades', $actividades);
        } else {
            abort(403);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Actualiza la reservación especificada en la base de datos.
     * 
     * @param  \Illuminate\Http\Request  $request
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
            'actividad_id'  => 'required',
            'tipo'          => 'required'
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

        if (\Auth::user()->docente() || \Auth::user()->visitante()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('reservaciones.index');
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

        $acceso = $this->acceder($reservacion->user->tipo, $reservacion->user_id);

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

            if (\Auth::user()->docente() || \Auth::user()->visitante()) {
                return redirect()->route('home');
            } else {
                return redirect()->route('reservaciones.index');
            }
        } else {
            abort(403);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Elimina las reservaciones especificadas de la base de datos.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function destroyMultiple(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'seleccion' => 'required'
        ]);

        $seleccion = $request->get('seleccion');

        $i = 0; // Número de reservaciones eliminadas.

        foreach ($seleccion as $s) {
            $reservacion = Reservacion::find($s);

            /**
             * Validando acceso para eliminar la reservación especificada.
             */

            $acceso = $this->acceder($reservacion->user->tipo, $reservacion->user_id);

            if ($acceso) {
                $reservacion->delete();

                /**
                 * Notificando a los usuarios correspondientes la acción realizada.
                 */

                $this->notificar($reservacion, 'eliminar');

                $i++;
            }
        }

        if ($i == count($seleccion)) {
            flash('
                <h4>
                    <i class="fa fa-check icon" aria-hidden="true"></i>
                    ¡Bien hecho!
                </h4>
                <p class="check">
                    Todas las reservaciones han sido eliminadas correctamente.
                </p>
            ')
                ->success()
                ->important();
        } else {
            $j = count($seleccion) - $i; // Número de reservaciones que no fueron eliminadas.

            flash('
                <h4>
                    <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                    Detalles de la operación
                </h4>
                <p class="info-circle">
                    Reservaciones eliminadas correctamente: ' . $i . '.
                </p>
                <p>
                    Reservaciones que no fueron eliminadas por no tener los permisos necesarios: ' . $j . '.
                </p>
            ')
                ->info()
                ->important();
        }

        return redirect()->route('reservaciones.index');
    }

    /************************ RESERVACIONES INDIVIDUALES ************************/

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
            'fecha'       => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
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
             * Validando que la fecha ingresada no sea un día domingo.
             */

            $error = $this->validarDomingo($reservacion->fecha);
            
            if ($error[0])
            {
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
            'locales' => 'required'
        ]);

        /**
         * Obteniendo datos necesarios para el paso tres.
         */

        $reservacion = new Reservacion;

        $reservacion->fecha = $request->get('fecha');
        $reservacion->hora_inicio = $request->get('hora_inicio');
        $reservacion->hora_fin = $request->get('hora_fin');
        $reservacion->tipo = $request->get('tipo');

        $locales = $request->get('locales');

        $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');

        $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

        if (\Auth::user()->administrador()) {
            $users = User::where('tipo', '!=', 'Administrador')
                ->orderBy('name')
                ->pluck('name', 'id');
        } else {
            $users = User::where('tipo', '!=', 'Administrador')
                ->where('tipo', '!=', 'Asistente')
                ->orderBy('name')
                ->pluck('name', 'id');
        }

        return view('reservaciones.paso-tres')
            ->with('reservacion', $reservacion)
            ->with('locales', $locales)
            ->with('asignaturas', $asignaturas)
            ->with('actividades', $actividades)
            ->with('users', $users);
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

        if (\Auth::user()->visitante()) {
            $this->validate(request(), [
                'asignatura_id' => 'required',
                'actividad_id'  => 'required',
                'responsable'   => 'required|max:190'
            ]);
        } else {
            $this->validate(request(), [
                'asignatura_id' => 'required',
                'actividad_id'  => 'required'
            ]);
        }

        /**
         * Almacenando las reservaciones de cada local.
         */

        $rc = []; // Arreglo con los id de las reservaciones a colocar en el comprobante.

        foreach ($request->l as $local_id) {

            /**
             * Convirtiendo fecha al formato Y-m-d y horas al formato H:i:s y
             * guardando todos los datos de la reservación.
             */

            $reservacion = new Reservacion;

            $reservacion->fecha = Carbon::parse($request->fecha)->format('Y-m-d');
            $reservacion->hora_inicio = Carbon::parse($request->hora_inicio)->format('H:i:s');
            $reservacion->hora_fin = Carbon::parse($request->hora_fin)->format('H:i:s');
            $reservacion->tipo = $request->get('tipo');
            $reservacion->local_id = $local_id;
            $reservacion->asignatura_id = $request->get('asignatura_id');
            $reservacion->actividad_id = $request->get('actividad_id');
            $reservacion->tema = $request->get('tema');
            $reservacion->responsable = $request->get('responsable');

            if ($request->user_id) {
                $reservacion->user_id = $request->get('user_id');
            } else {
                $reservacion->user_id = \Auth::user()->id;
            }

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
                if (count($request->l) > 1) {
                    if (count($rc) > 0) {
                        flash('
                            <h4>
                                <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                                Detalles de la operación
                            </h4>
                            <p class="info-circle">
                                La reservación en el local ' . $reservacion->local->nombre . ' no pudo ser registrada. Otro usuario reservó el local mientras tú completabas el formulario.
                                <strong>
                                    Las reservaciones anteriores a esa se registraron correctamente.
                                </strong>
                            </p>
                        ')
                            ->info()
                            ->important();

                        return view('reservaciones.comprobante')->with('rc', $rc);
                    } else {
                        flash('
                            <h4>
                                <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                                ¡Algo ha salido mal!
                            </h4>
                            <p class="exclamation-triangle">
                                No se pudo registrar ninguna reservación. Intenta nuevamente.
                            </p>
                        ')
                            ->warning()
                            ->important();

                        return redirect()->route('reservaciones.paso-uno');
                    }
                } else {
                    flash('
                        <h4>
                            <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                            ¡Algo ha salido mal!
                        </h4>
                        <p class="exclamation-triangle">
                            La reservación en el local ' . $reservacion->local->nombre . ' no pudo ser registrada. Otro usuario reservó el local mientras tú completabas el formulario.
                        </p>
                    ')
                    ->warning()
                    ->important();

                    return redirect()->route('reservaciones.paso-uno');
                }
            }

            $reservacion->save();

            array_push($rc, $reservacion->id);

            /**
             * Notificando a los usuarios correspondientes la acción realizada.
             */

            $this->notificar($reservacion, 'crear');
        }

        if (count($request->l) > 1) {
            flash('
                <h4>
                    <i class="fa fa-check icon" aria-hidden="true"></i>
                    ¡Bien hecho!
                </h4>
                <p class="check">
                    Se guardaron ' . count($request->l) . ' reservaciones correctamente.
                </p>
            ')
                ->success()
                ->important();
        } else {
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
        }

        return view('reservaciones.comprobante')->with('rc', $rc);

        /*
        if (\Auth::user()->docente() || \Auth::user()->visitante()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('reservaciones.index');
        }
        */
    }

    /************************* RESERVACIONES POR SEMANA *************************/

    /**
     * ---------------------------------------------------------------------------
     * Muestra el formulario del paso uno para crear una nueva reservación
     * semanal.
     * 
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function createSemana()
    {
        return view('reservaciones.paso-uno-semana');
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida la fecha inicial, hora de inicio, hora de finalización de la
     * reservación y número de semanas a reservar. Obtiene los locales disponibles
     * para los parámetros anteriores y muestra el formulario del paso dos para
     * crear una nueva reservación semanal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function hacerPasoUnoSemana(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'fecha'       => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'hora_inicio' => 'required|after_or_equal:07:00:00|before_or_equal:17:00:00',
            'hora_fin'    => 'required|after:hora_inicio|before_or_equal:18:00:00',
            'frecuencia'  => 'required',
            'semana'      => 'required|integer|min:2'
        ]);

        $frecuencia = $request->get('frecuencia');
        $semana = $request->get('semana');

        /**
         * Convirtiendo fecha al formato Y-m-d y horas al formato H:i:s.
         */

        $fecha = Carbon::parse($request->get('fecha'))->format('Y-m-d');
        $hora_inicio = Carbon::parse($request->get('hora_inicio'))->format('H:i:s');
        $hora_fin = Carbon::parse($request->get('hora_fin'))->format('H:i:s');
        
        /**
         * Validando que las horas ingresadas cumplan con las reglas del negocio.
         */
        
        $error = $this->validarHoras($fecha, $hora_inicio, $hora_fin);
        
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
         * Validando que el número de semanas sea par si la frecuencia de la
         * reservación es cada dos semanas.
         */

        if ($frecuencia == 2 && $semana % 2 != 0) {
            flash('
                <h4>
                    <i class="fa fa-ban icon" aria-hidden="true"></i>
                    ¡Error en ingreso de datos!
                </h4>
                <p class="ban">
                    Si la frecuencia de la reservación es cada dos semanas, el número de semanas debe ser un número par.
                </p>
            ')
                ->error()
                ->important();
            
            return back();
        }

        /**
         * Obteniendo fechas y locales disponibles en esas fechas.
         */

        $f = explode('-', $fecha);
        $f_carbon = Carbon::create($f[0], $f[1], $f[2], 0); // Fecha inicial como instancia de Carbon.

        $fechas = []; // Arreglo con todas las fechas a reservar.

        $l_disponibles = []; // Arreglo con todos los locales disponibles para la hora y fechas indicadas.

        for ($i = 0; $i < $semana / $frecuencia; $i++) { 
            $f_almacenar = Carbon::parse($f_carbon)->format('Y-m-d');

            $l_almacenar = $this->obtenerLocalesDisponibles($f_almacenar, $hora_inicio, $hora_fin);

            array_push($fechas, $f_almacenar);

            array_push($l_disponibles, $l_almacenar);

            $f_carbon = $f_carbon->addDays(7);
        }

        /**
         * Obteniendo locales cuya disponibilidad coincidan en todas las fechas.
         */

        $locales_disponibles = []; // Arreglo con los locales disponibles en todas las fechas indicadas.

        for ($i = 0; $i < count($l_disponibles[0]); $i++) { 
            for ($j = 1; $j < count($l_disponibles); $j++) { 
                for ($k = 0; $k < count($l_disponibles[$j]); $k++) { 
                    $disponible = false;

                    if ($l_disponibles[0][$i]->id == $l_disponibles[$j][$k]->id) {
                        $disponible = true;

                        break;
                    }
                }

                if ($disponible == false) {
                    break;
                }
            }

            if ($disponible == true) {
                array_push($locales_disponibles, $l_disponibles[0][$i]);
            }
        }

        if (count($locales_disponibles) <= 0) {
            flash('
                <h4>
                    <i class="fa fa-exclamation-triangle icon" aria-hidden="true"></i>
                    ¡No hay locales disponibles!
                </h4>
                <p class="exclamation-triangle">
                    Lo sentimos, no hay ningún local cuya disponibilidad coincida en todas las fechas indicadas.
                </p>
            ')
                ->warning()
                ->important();
            
            return back();
        } else {
            return view('reservaciones.paso-dos-semana')
                ->with('hora_inicio', $hora_inicio)
                ->with('hora_fin', $hora_fin)
                ->with('fechas', $fechas)
                ->with('locales_disponibles', $locales_disponibles);
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida la selección del local y muestra el formulario del paso tres para
     * crear una nueva reservación semanal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function hacerPasoDosSemana(Request $request)
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

        $fechas = $request->get('fechas');
        $hora_inicio = $request->get('hora_inicio');
        $hora_fin = $request->get('hora_fin');
        $local_id = $request->get('local_id');

        $asignaturas = Asignatura::orderBy('nombre')->pluck('nombre', 'id');

        $actividades = Actividad::orderBy('nombre')->pluck('nombre', 'id');

        if (\Auth::user()->administrador()) {
            $users = User::where('tipo', '!=', 'Administrador')
                ->orderBy('name')
                ->pluck('name', 'id');
        } else {
            $users = User::where('tipo', '!=', 'Administrador')
                ->where('tipo', '!=', 'Asistente')
                ->orderBy('name')
                ->pluck('name', 'id');
        }
        
        return view('reservaciones.paso-tres-semana')
            ->with('fechas', $fechas)
            ->with('hora_inicio', $hora_inicio)
            ->with('hora_fin', $hora_fin)
            ->with('local_id', $local_id)
            ->with('asignaturas', $asignaturas)
            ->with('actividades', $actividades)
            ->with('users', $users);
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida la selección de la asignatura y la actividad. Almacena la
     * reservación semanal recién creada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function hacerPasoTresSemana(Request $request)
    {
        /**
         * Validando datos de entrada.
         */

        $this->validate(request(), [
            'asignatura_id' => 'required',
            'actividad_id'  => 'required'
        ]);

        /**
         * Guardando cada reservación.
         */

        $fechas = $request->get('f'); // Arreglo con todas las fechas a reservar.

        $i = 0; // Índice para el código.

        $rr = 0; // Número de reservaciones que fueron registradas.

        $rnr = 0; // Número de reservaciones que no fueron registradas.

        foreach ($fechas as $fecha) {
            $reservacion = new Reservacion;

            $reservacion->fecha = $fecha;
            $reservacion->hora_inicio = Carbon::parse($request->get('hora_inicio'))->format('H:i:s');
            $reservacion->hora_fin = Carbon::parse($request->get('hora_fin'))->format('H:i:s');
            $reservacion->local_id = $request->get('local_id');
            $reservacion->asignatura_id = $request->get('asignatura_id');
            $reservacion->actividad_id = $request->get('actividad_id');
            $reservacion->tema = $request->get('tema');
            $reservacion->responsable = $request->get('responsable');
            $reservacion->tipo = 'Ordinaria';

            if ($request->user_id) {
                $reservacion->user_id = $request->get('user_id');
            } else {
                $reservacion->user_id = \Auth::user()->id;
            }

            /**
             * Generando código de comprobación.
             */

            $cr = str_pad(substr($i, -3, 3), 3, '0', STR_PAD_LEFT);
            $ca = str_pad(substr($reservacion->asignatura_id, -2, 2), 2, '0', STR_PAD_LEFT);
            $cl = str_pad(substr($reservacion->local_id, -2, 2), 2, '0', STR_PAD_LEFT);
            $cu = str_pad(substr($reservacion->user_id, -2, 2), 2, '0', STR_PAD_LEFT);

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
                \Auth::user()->notify(new TareaNotification($reservacion, 'no-registro'));

                $rnr++;
            } else {
                $reservacion->save();

                /**
                 * Notificando a los usuarios correspondientes la acción realizada.
                 */

                $this->notificar($reservacion, 'crear');

                $rr++;
            }


            $i++;
        }

        if ($rnr > 0) {
            flash('
                <h4>
                    <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                    Detalles de la operación
                </h4>
                <p class="info-circle">
                    Reservaciones guardadas correctamente: ' . $rr . '.
                </p>
                <p class="info-circle">
                    Reservaciones que no fueron registradas porque otro usuario reservó el local mientras llenabas el formulario: ' . $rnr . '.
                </p>
                <p class="info-circle">
                    <strong>
                        Consulta en tus acciones las reservaciones que no pudieron ser registradas.
                    </strong>
                </p>
            ')
                ->info()
                ->important();
        } else {
            flash('
                <h4>
                    <i class="fa fa-check icon" aria-hidden="true"></i>
                    ¡Bien hecho!
                </h4>
                <p class="check">
                    Las reservaciones han sido guardadas correctamente.
                </p>
            ')
                ->success()
                ->important();
        }


        return redirect()->route('reservaciones.index');
    }

    /************************* RESERVACIONES POR CICLO **************************/

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
     * @param  \qfproject\Http\Request  $request
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
            'rango_fecha' => 'required',
            'propiedad'   => 'required'
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
         * En caso de ocurrir un problema en algún registro toda la operación es
         * cancelada.
         */
        
        try {
            DB::beginTransaction();

            /**
             * Obteniendo todas las reservaciones que se encuentren dentro del
             * rango de fechas original.
             */

            $reservaciones = Reservacion::where('fecha', '>=', $rango_fecha[0])
                ->where('fecha', '<=', $rango_fecha[1])
                ->where('tipo', '=', 'Ordinaria')
                ->orderBy('fecha', 'asc')
                ->get();

            /**
             * Registrando las reservaciones anteriores en sus correspondientes
             * fechas futuras.
             */

            $rr = 0; // Número de reservaciones registradas.

            if ($reservaciones->count() > 0) {

                $i = 0; // Índice para el código.

                $reservaciones_p = []; // Arreglo con las reservaciones pendientes por la no disponibilidad del local.

                foreach ($reservaciones as $reservacion) {

                    /**
                     * Obteniendo nueva fecha de la reservación.
                     */

                    $fn = explode('-', $reservacion->fecha);
                    $fn_carbon = Carbon::create($fn[0], $fn[1], $fn[2], 0);
                    $fecha_nueva = Carbon::parse($fn_carbon->addDays($diferencia))->format('Y-m-d');

                    $reservacion_nueva = new Reservacion;

                    $reservacion_nueva->local_id = $reservacion->local_id;
                    $reservacion_nueva->asignatura_id = $reservacion->asignatura_id;
                    $reservacion_nueva->actividad_id = $reservacion->actividad_id;
                    $reservacion_nueva->fecha = $fecha_nueva;
                    $reservacion_nueva->hora_inicio = $reservacion->hora_inicio;
                    $reservacion_nueva->hora_fin = $reservacion->hora_fin;
                    $reservacion_nueva->tema = $reservacion->tema;
                    $reservacion_nueva->tipo = 'Ordinaria';

                    if ($request->propiedad) {
                        $reservacion_nueva->user_id = \Auth::user()->id;
                    } else {
                        $reservacion_nueva->user_id = $reservacion->user_id;
                    }

                    /**
                     * Validando que local está disponible.
                     */

                    $reservaciones_v = Reservacion::where('fecha', '=', $reservacion_nueva->fecha)
                        ->where('hora_inicio', '>=', $reservacion_nueva->hora_inicio)
                        ->where('hora_inicio', '<', $reservacion_nueva->hora_fin)
                        ->where('local_id', '=', $reservacion_nueva->local_id)
                        ->orWhere('fecha', '=', $reservacion_nueva->fecha)
                        ->where('hora_fin', '<=', $reservacion_nueva->hora_fin)
                        ->where('hora_fin', '>', $reservacion_nueva->hora_inicio)
                        ->where('local_id', '=', $reservacion_nueva->local_id)
                        ->get();

                    /**
                     * En caso de encontrar reservaciones que chocan con la nueva
                     * que se quiere registrar, se almacenará en el arreglo
                     * $reservaciones_p lo siguiente: el primer elemento es la
                     * nueva reservación y los posteriores son las reservaciones
                     * con que choca. El código en cada reservación es sustituido
                     * por la posición que tienen en el arreglo $reservaciones_p
                     * para que luego sirva como elemento que las relacione.
                     */

                    if ($reservaciones_v->count() > 0) {
                        $rp = []; // Arreglo temporal con las reservaciones a agregar en $reservaciones_p.

                        $reservacion_nueva->codigo = count($reservaciones_p);

                        $rp[0] = $reservacion_nueva;

                        foreach ($reservaciones_v as $reservacion_v) {
                            $reservacion_v->codigo = count($reservaciones_p);

                            array_push($rp, $reservacion_v);
                        }

                        array_push($reservaciones_p, $rp);
                    } else {

                        /**
                         * Generando código de comprobación.
                         */

                        $cr = str_pad(substr($i, -3, 3), 3, '0', STR_PAD_LEFT);
                        $ca = str_pad(substr($reservacion_nueva->asignatura_id, -2, 2), 2, '0', STR_PAD_LEFT);
                        $cl = str_pad(substr($reservacion_nueva->local_id, -2, 2), 2, '0', STR_PAD_LEFT);
                        $cu = str_pad(substr($reservacion_nueva->user_id, -2, 2), 2, '0', STR_PAD_LEFT);

                        $reservacion_nueva->codigo = $cr . '-' . time() . '-' . $ca . '-' . $cl . '-' . $cu;

                        $reservacion_nueva->save();

                        /**
                         * Notificando a los usuarios correspondientes la acción realizada.
                         */

                        $this->notificar($reservacion_nueva, 'crear');

                        $rr++;
                    }
                    
                    $i++;
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

        /**
         * Si hay reservaciones que chocan mandar a la vista correspondiente
         * para solucionar ese problema.
         */

        if (count($reservaciones_p) > 0) {
            flash('
                <h4>
                    <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                    Detalles de la operación
                </h4>
                <p class="info-circle">
                    Se registraron ' . $rr . ' reservaciones de un total de ' . $reservaciones->count() . '.
                </p>
            ')
                ->info()
                ->important();

            return view('reservaciones.choques')
                ->with('reservaciones_p', $reservaciones_p);
        } else {
            flash('
                <h4>
                    <i class="fa fa-check icon" aria-hidden="true"></i>
                    ¡Bien hecho!
                </h4>
                <p class="check">
                    Todas las reservaciones se guardaron correctamente.
                </p>
            ')
                ->success()
                ->important();
            
            return redirect()->route('reservaciones.index');
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Muestra un listado de reservaciones que chocan con otras para que el
     * usuario decida si eliminar o no aquellas que interfieren con la suya.
     * 
     * @param  \qfproject\Http\Request  $request
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------
     */

    public function verChoquesNuevoCiclo(Request $request)
    {
        /**
         * Arreglo con el identificador de posición donde se decidió registrar la
         * nueva reservación y eliminar aquellas con que choca.
         */

        $seleccionadas = $request->get('seleccionadas');

        /**
         * Arreglo con los datos de todas las reservaciones.
         */

        $reservaciones = $request->get('r');

        $i = 0; // Índice para el código.

        $rnr = 0; // Número de reservaciones nuevas no registradas.

        $re = 0; // Número de reservaciones eliminadas que chocaban.

        /**
         * Guardando o eliminando reservaciones según sea el caso.
         */

        foreach ($reservaciones as $reservacion) {
            $registrada = false; // Variable para indicar si la reservación nueva ha sido registrada en la base de datos.

            $r = explode(',-:', $reservacion);

            /**
             * Si el arreglo posee más de dos elementos significa que es una nueva
             * reservación que aún no ha sido registrada. Se extrae cada uno de
             * los elementos del arreglo y se crea una instancia de Reservación
             * con ellos.
             */

            if (count($r) > 2) {
                $reservacion = new Reservacion;
                        
                $reservacion->user_id = $r[1];
                $reservacion->local_id = $r[2];
                $reservacion->asignatura_id = $r[3];
                $reservacion->actividad_id = $r[4];
                $reservacion->fecha = $r[5];
                $reservacion->hora_inicio = $r[6];
                $reservacion->hora_fin = $r[7];
                $reservacion->tema = $r[8];
                $reservacion->tipo = $r[9];

                /**
                 * Generando código de comprobación.
                 */

                $cr = str_pad(substr($i, -3, 3), 3, '0', STR_PAD_LEFT);
                $ca = str_pad(substr($reservacion->asignatura_id, -2, 2), 2, '0', STR_PAD_LEFT);
                $cl = str_pad(substr($reservacion->local_id, -2, 2), 2, '0', STR_PAD_LEFT);
                $cu = str_pad(substr($reservacion->user_id, -2, 2), 2, '0', STR_PAD_LEFT);

                $reservacion->codigo = $cr . '-' . time() . '-' . $ca . '-' . $cl . '-' . $cu;

                $i++;
            }

            /**
             * Si la reservación ha sido seleccionada se procede de la siguiente
             * manera: Las reservaciones nuevas se guardan y las reservaciones
             * que provocaban el choque son eliminadas.
             */

            foreach ($seleccionadas as $seleccion) {
                if ($r[0] == $seleccion) {
                    if (count($r) > 2) {
                        $reservacion->save();

                        /**
                         * Notificando a los usuarios correspondientes la acción realizada.
                         */

                        $this->notificar($reservacion, 'crear');                        

                        $registrada = true;
                    } else {
                        $reservacion = Reservacion::find($r[1]);

                        $reservacion->delete();

                        /**
                         * Notificando a los usuarios correspondientes la acción realizada.
                         */

                        $this->notificar($reservacion, 'eliminar');

                        \Auth::user()->notify(new TareaNotification($reservacion, 'eliminar'));

                        $re++;
                    }

                    break;
                }
            }

            if (!$registrada && count($r) > 2) {
                $rnr++;

                \Auth::user()->notify(new TareaNotification($reservacion, 'no-registro'));
            }
        }

        flash('
            <h4>
                <i class="fa fa-info-circle icon" aria-hidden="true"></i>
                Detalles de la operación
            </h4>
            <p class="info-circle">
                Reservaciones nuevas que no fueron registradas: ' . $rnr . '.
            </p>
            <p class="info-circle">
                Reservaciones que fueron eliminadas: ' . $re . '.
            </p>
            <p class="info-circle">
                <strong>
                    Consulta en tus acciones las reservaciones que has eliminado y aquellas que no pudieron ser registradas.
                </strong>
            </p>
        ')
            ->info()
            ->important();

        return redirect()->route('reservaciones.index');
    }

    /********************** VALIDACIONES Y OTRAS FUNCIONES **********************/

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
            $locales_disponibles = []; // Arreglo con los locales disponibles.

            foreach ($locales as $local) {
                
                $disponible = true;            
                
                foreach ($reservaciones as $reservacion) {
                    if ($reservacion->local_id == $local->id) {
                        $disponible = false;
                        
                        break;
                    }
                }
                
                if ($disponible) {
                    array_push($locales_disponibles, $local);
                }
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
     * @param  \qfproject\Reservacion  $reservacion
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

            if (!\Auth::user()->administrador()) {
                if (\Auth::user()->asistente()) {
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

            if (\Auth::user()->administrador()) {
                $user = User::where('id', '=', $reservacion->user_id)->first();

                $user->notify(new ReservacionNotification($reservacion, $tipo, false));
            } else {
                $users = User::where('tipo', '=', 'Administrador')
                    ->orWhere('id', '=', $reservacion->user_id)
                    ->get();

                foreach ($users as $user) {
                    if ($user->administrador()) {
                        $user->notify(new ReservacionNotification($reservacion, $tipo, true));
                    } else {
                        $user->notify(new ReservacionNotification($reservacion, $tipo, false));
                    }
                }
            }
        }
    }

    /**
     * ---------------------------------------------------------------------------
     * Valida si el usuario tiene acceso para realizar una acción.
     * 
     * @param  string  $tipo
     * @param  int  $propietario
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function acceder($tipo, $propietario)
    {
        $acceso = false;

        switch ($tipo) {
            case 'Administrador':
                if (\Auth::user()->id == $propietario) {
                    $acceso = true;
                }
                
                break;
            
            case 'Asistente':
                if (\Auth::user()->administrador() || \Auth::user()->id == $propietario) {
                    $acceso = true;
                }
                
                break;
            
            case 'Docente':
                if (\Auth::user()->administrador() || \Auth::user()->asistente() || \Auth::user()->id == $propietario) {
                    $acceso = true;
                }
                
                break;

            case 'visitante':
                if (\Auth::user()->administrador() || \Auth::user()->asistente() || \Auth::user()->id == $propietario) {
                    $acceso = true;
                }
                
                break;
        }

        return $acceso;
    }

    /**
     * ---------------------------------------------------------------------------
     * Verifica que la fecha ingresada no sea un día domingo.
     * 
     * @param  date  $fecha
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function validarDomingo($fecha)
    {
        if (date('N', strtotime($fecha)) == 7) {
            return [true, 'No puede reservar un día domingo.'];
        } else {
            return [false, null];
        }
    }
}