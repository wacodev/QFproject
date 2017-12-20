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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'administracion'], function () {
    
    Route::resource('actividades', 'ActividadController');
    Route::resource('asignaturas', 'AsignaturaController');
    Route::resource('asuetos', 'AsuetoController');
    Route::resource('locales', 'LocalController');
    Route::resource('suspensiones', 'SuspensionController');
    Route::resource('users', 'UserController');

});

Route::group(['prefix' => 'reservaciones'], function () {

    Route::get('/paso-uno', 'ReservacionController@individual')->name('reservaciones.paso-uno');
    Route::get('/paso-dos', 'ReservacionController@pasoUno')->name('reservaciones.paso-dos');
    Route::get('/paso-tres', 'ReservacionController@pasoDos')->name('reservaciones.paso-tres');
    Route::post('/', 'ReservacionController@pasoTres')->name('reservaciones.guardar');
    Route::delete('/{reservacion}', 'ReservacionController@destroy')->name('reservaciones.destroy');
    Route::get('/{reservacion}/edit', 'ReservacionController@edit')->name('reservaciones.edit');
    Route::put('/{reservacion}', 'ReservacionController@update')->name('reservaciones.update');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{reservacion}/comprobante', 'PdfController@generarComprobante')->name('reservacion.comprobante');