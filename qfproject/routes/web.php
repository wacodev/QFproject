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
    Route::get('/vacaciones', 'AsuetoController@createVacacion')->name('asuetos.create-vacacion');
    Route::post('/vacaciones/store', 'AsuetoController@storeVacacion')->name('asuetos.store-vacacion');

    /**
     * Usuarios.
     */

    Route::resource('users', 'UserController');
    Route::get('/importar/users', 'ImportacionController@importarUsers')->name('users.importar');
    Route::post('/almacenar/users', 'ImportacionController@almacenarUsers')->name('users.almacenar');

});

/**
 * ---------------------------------------------------------------------------
 * Autentificación de usuarios.
 * ---------------------------------------------------------------------------
 */

Auth::routes();

/**
 * ---------------------------------------------------------------------------
 * Editar perfil.
 * ---------------------------------------------------------------------------
 */

Route::get('/editar', 'HomeController@editarPerfil')->name('editar-perfil');
Route::put('/{user}', 'HomeController@actualizarPerfil')->name('actualizar-perfil');

/**
 * ---------------------------------------------------------------------------
 * Estadísticas.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'estadisticas', 'middleware' => 'asistente'], function() {

    Route::get('estadisticas-local', 'ChartController@index')->name('estadisticas.uno');
    Route::get('estadisticas-actividad', 'ChartController@porActividad')->name('estadisticas.dos');
    Route::get('estadisticas-asignatura', 'ChartController@porAsignatura')->name('estadisticas.tres');
    Route::get('estadisticas-usuario', 'ChartController@porUsuarios')->name('estadisticas.cuatro');
    Route::post('actividades', 'ChartController@actividades')->name('ver.actividades');
    Route::post('locales', 'ChartController@locales')->name('ver.locales');
    Route::post('asignaturas', 'ChartController@asignaturas')->name('ver.asignaturas');
    Route::post('usuarios', 'ChartController@usuarios')->name('ver.usuarios');




});

/**
 * ---------------------------------------------------------------------------
 * Notificaciones.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'notificaciones', 'middleware' => 'auth'], function() {

    Route::get('/', 'HomeController@verNotificaciones')->name('notificaciones');
    Route::get('/{notificacion}/destroy', 'HomeController@eliminarNotificacion')->name('notificaciones.destroy');
    Route::get('/destroy-multiple', 'HomeController@eliminarNotificaciones')->name('notificaciones.destroy-multiple');

});

/**
 * ---------------------------------------------------------------------------
 * Notificaciones de las acciones realizadas.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'acciones', 'middleware' => 'asistente'], function() {

    Route::get('/', 'HomeController@verAcciones')->name('acciones');
    Route::get('/{accion}/destroy', 'HomeController@eliminarNotificacion')->name('acciones.destroy');
    Route::get('/destroy-multiple', 'HomeController@eliminarAcciones')->name('acciones.destroy-multiple');

});

Route::group(['prefix' => 'estadisticas', 'middleware' => 'asistente'], function() {
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
 * Reportes.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'reportes', 'middleware' => ['auth', 'asistente']], function() {

    /**
     * Horario semanal.
     */

    Route::get('/exportar-horarios', 'PdfController@exportarHorarios')->name('reportes.exportar-horarios');
    Route::post('/horarios', 'PdfController@generarHorarios')->name('reportes.horarios');

    /**
     * Lista de reservaciones de una asignatura por actividad.
     */

    Route::get('/exportar-lista-actividad', 'PdfController@exportarListaActividad')->name('reportes.exportar-lista-actividad');
    Route::post('/lista-actividad', 'PdfController@generarListaActividad')->name('reportes.lista-actividad');

});

/**
 * ---------------------------------------------------------------------------
 * Reservaciones de locales.
 * ---------------------------------------------------------------------------
 */

Route::group(['prefix' => 'reservaciones', 'middleware' => 'auth'], function() {
Route::group(['prefix' => 'estadisticas', 'middleware' => 'visitante'], function() {

});
    /**
     * Opciones básicas para las reservaciones.
     */

    Route::get('/{reservacion}/edit', 'ReservacionController@edit')->name('reservaciones.edit');
    Route::put('/{reservacion}', 'ReservacionController@update')->name('reservaciones.update');
    Route::get('/{reservacion}/destroy', 'ReservacionController@destroy')->name('reservaciones.destroy');
    
    /**
     * Agregar actividades y asignaturas en el formulario de reservaciones.
     */

    Route::post('/storeActividad', 'HomeController@storeActividad')->name('store-actividad');
    Route::post('/storeAsignatura', 'HomeController@storeAsignatura')->name('store-asignatura');

    /**
     * Comprobante de reservación.
     */

    Route::get('/{reservacion}/comprobante', 'PdfController@generarComprobante')->name('reservacion.comprobante');
    Route::get('/formulario-comprobante', 'PdfController@formularComprobante')->name('reservaciones.formulario-comprobante');
    Route::post('/descargar-comprobante', 'PdfController@exportarComprobante')->name('reservaciones.descargar-comprobante');

    /**
     * Historial de reservaciones.
     */

    Route::get('/historial', 'HomeController@verHistorial')->name('reservaciones.historial');

    /**
     * Próximas reservas.
     */
     Route::get('/listado_reservas', 'PdfController@proximasReservas')->name('reportes.reservacion-lista');

    /**
     * Reservaciones individuales.
     */

    Route::get('/paso-uno', 'ReservacionController@create')->name('reservaciones.paso-uno');
    Route::get('/paso-dos', 'ReservacionController@hacerPasoUno')->name('reservaciones.paso-dos');
    Route::get('/paso-tres', 'ReservacionController@hacerPasoDos')->name('reservaciones.paso-tres');
    Route::get('/store', 'ReservacionController@hacerPasoTres')->name('reservaciones.store');
    Route::get('/comprobante', 'PdfController@descargarComprobante')->name('reservaciones.comprobante');

    Route::group(['middleware' => 'asistente'], function() {

        /**
         * Opciones básicas para las reservaciones - [Administradores y Asistentes].
         */

        Route::get('/', 'ReservacionController@index')->name('reservaciones.index');
        Route::get('/{reservacion}/show', 'ReservacionController@show')->name('reservaciones.show');
        Route::get('/destroy-multiple', 'ReservacionController@destroyMultiple')->name('reservaciones.destroy-multiple');

        /**
         * Reservaciones por ciclo.
         */

        Route::get('/crear-ciclo', 'ReservacionController@crearNuevoCiclo')->name('reservaciones.crear-ciclo');
        Route::get('/registrar-ciclo', 'ReservacionController@registrarNuevoCiclo')->name('reservaciones.registrar-ciclo');
        Route::post('/choques', 'ReservacionController@verChoquesNuevoCiclo')->name('reservaciones.choques');

        /**
         * Reservaciones semanales.
         */

        Route::get('/paso-uno-semana', 'ReservacionController@createSemana')->name('reservaciones.paso-uno-semana');
        Route::get('/paso-dos-semana', 'ReservacionController@hacerPasoUnoSemana')->name('reservaciones.paso-dos-semana');
        Route::get('/paso-tres-semana', 'ReservacionController@hacerPasoDosSemana')->name('reservaciones.paso-tres-semana');
        Route::post('/almacenar-semana', 'ReservacionController@hacerPasoTresSemana')->name('reservaciones.almacenar-semana');

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

        /**
        * Ayuda.
        */
        Route::get('/ayuda', 'AyudaController@mostrar')->name('mostrar-ayuda');

    });


});