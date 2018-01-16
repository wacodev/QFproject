<?php

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí es donde puede registrar rutas web para su aplicación. Estas rutas
| las carga el RouteServiceProvider dentro de un grupo que contiene el
| grupo de middleware "web". ¡Ahora crea algo grandioso!
|
*/

/**
 * ---------------------------------------------------------------------------
 * Administración - [Configuración y Usuarios].
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'administracion', 'middleware' => ['auth', 'administrador']], function() {

    /**
     * Opciones de configuración.
     */

    Route::resource('actividades', 'ActividadController');
    Route::resource('asignaturas', 'AsignaturaController');
    Route::resource('asuetos', 'AsuetoController');
    Route::resource('locales', 'LocalController');
    Route::resource('suspensiones', 'SuspensionController');

    /**
     * Usuarios.
     */

    Route::resource('users', 'UserController');

});

/**
 * ---------------------------------------------------------------------------
 * Autentificación de usuarios.
 * ---------------------------------------------------------------------------
 */

Auth::routes();

/**
 * ---------------------------------------------------------------------------
 * Notificaciones.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'notificaciones', 'middleware' => 'auth'], function() {

    Route::get('/', 'HomeController@verNotificaciones')->name('notificaciones');
    Route::get('/{notificacion}/destroy', 'HomeController@eliminarNotificacion')->name('notificaciones.destroy');

});

/**
 * ---------------------------------------------------------------------------
 * Página de inicio.
 * ---------------------------------------------------------------------------
 */

Route::get('/home', 'HomeController@index')->name('home');

/**
 * ---------------------------------------------------------------------------
 * Raíz - Inicio de sesión.
 * ---------------------------------------------------------------------------
 */

Route::get('/', 'HomeController@index');

/**
 * ---------------------------------------------------------------------------
 * Reservaciones de locales.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'reservaciones', 'middleware' => 'auth'], function() {

    /**
     * Opciones básicas para las reservaciones.
     */

    Route::get('/{reservacion}/edit', 'ReservacionController@edit')->name('reservaciones.edit');
    Route::put('/{reservacion}', 'ReservacionController@update')->name('reservaciones.update');
    Route::delete('/{reservacion}', 'ReservacionController@destroy')->name('reservaciones.destroy');

    /**
     * Comprobante de reservación.
     */

    Route::get('/{reservacion}/comprobante', 'PdfController@generarComprobante')->name('reservacion.comprobante');

    /**
     * Reservaciones individuales.
     */

    Route::get('/paso-uno', 'ReservacionController@create')->name('reservaciones.paso-uno');
    Route::get('/paso-dos', 'ReservacionController@hacerPasoUno')->name('reservaciones.paso-dos');
    Route::get('/paso-tres', 'ReservacionController@hacerPasoDos')->name('reservaciones.paso-tres');
    Route::post('/store', 'ReservacionController@hacerPasoTres')->name('reservaciones.store');

    Route::group(['middleware' => 'asistente'], function() {

        /**
         * Opciones básicas para las reservaciones - [Administradores y Asistentes].
         */

        Route::get('/', 'ReservacionController@index')->name('reservaciones.index');
        Route::get('/{reservacion}/show', 'ReservacionController@show')->name('reservaciones.show');

        /**
         * Reservaciones por ciclo.
         */

        Route::get('/crear-ciclo', 'ReservacionController@crearNuevoCiclo')->name('reservaciones.crear-ciclo');
        Route::post('/registrar-ciclo', 'ReservacionController@registrarNuevoCiclo')->name('reservaciones.registrar-ciclo');

        /**
         * Importar reservaciones desde Excel.
         */

        Route::get('/importar', 'ImportacionController@importarReservaciones')->name('reservaciones.importar');
        Route::post('/almacenar', 'ImportacionController@almacenarReservaciones')->name('reservaciones.almacenar');

        /**
         * Exportar reservaciones a Excel.
         */

        Route::get('/exportar', 'ExportacionController@exportarReservaciones')->name('reservaciones.exportar');
        Route::post('/recibir', 'ExportacionController@recibirReservaciones')->name('reservaciones.recibir');
          });

    /**
     * ---------------------------------------------------------------------------
     * Estadísticas.
     * ---------------------------------------------------------------------------
    */
       Route::get('estadisticas-local', 'ChartController@index')->name('estadisticas.uno');
       Route::get('estadisticas-actividad', 'ChartController@porActividad')->name('estadisticas.dos');
       Route::get('estadisticas-asignatura', 'ChartController@porAsignatura')->name('estadisticas.tres');
       Route::get('estadisticas-usuario', 'ChartController@porUsuarios')->name('estadisticas.cuatro');

});