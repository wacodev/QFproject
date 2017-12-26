<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

// Área administrativa
Route::group(['prefix' => 'administracion'], function () {
    
    Route::resource('actividades', 'ActividadController');
    Route::resource('asignaturas', 'AsignaturaController');
    Route::resource('asuetos', 'AsuetoController');
    Route::resource('locales', 'LocalController');
    Route::resource('suspensiones', 'SuspensionController');
    Route::resource('users', 'UserController');

});

// Reservaciones simples
Route::group(['prefix' => 'reservaciones'], function () {

    Route::get('/paso-uno', 'ReservacionController@create')->name('reservaciones.paso-uno');
    Route::get('/paso-dos', 'ReservacionController@hacerPasoUno')->name('reservaciones.paso-dos');
    Route::get('/paso-tres', 'ReservacionController@hacerPasoDos')->name('reservaciones.paso-tres');
    Route::post('/', 'ReservacionController@hacerPasoTres')->name('reservaciones.store');
    Route::delete('/{reservacion}', 'ReservacionController@destroy')->name('reservaciones.destroy');
    Route::get('/{reservacion}/edit', 'ReservacionController@edit')->name('reservaciones.edit');
    Route::put('/{reservacion}', 'ReservacionController@update')->name('reservaciones.update');

});

Route::group(['prefix' => 'importaciones'], function () {

    Route::get('/reservaciones', 'ImportacionController@importarReservaciones')->name('reservaciones.importar');
    Route::post('/', 'ImportacionController@almacenarReservaciones')->name('reservaciones.almacenar');

});

Route::group(['prefix' => 'exportaciones'], function () {
    
    Route::get('/reservaciones', 'ExportacionController@exportarReservaciones')->name('reservaciones.exportar');
    Route::post('/', 'ExportacionController@recibirReservaciones')->name('reservaciones.recibir');

});

Auth::routes();

// Página de inicio
Route::get('/home', 'HomeController@index')->name('home');

// Comprobante de reservación
Route::get('/{reservacion}/comprobante', 'PdfController@generarComprobante')->name('reservacion.comprobante');

