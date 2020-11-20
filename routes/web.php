<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SesionesController;
use App\Http\Controllers\CotizacionesController;

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

//Inicio
Route::get('/', HomeController::class)->middleware('sesion');

//Sesion
Route::get('sesiones', [SesionesController::class, 'index']);
Route::post('ingresar', [SesionesController::class, 'ingresar']);
Route::get('salir', [SesionesController::class, 'salir']);

//Cotizaciones
Route::any('cotizaciones/{pagina?}', [CotizacionesController::class, 'index'])->middleware('sesion');
Route::get('cotizar/{tipo}', [CotizacionesController::class, 'cotizar'])->middleware('sesion');
Route::get('cotizacion/{id}', [CotizacionesController::class, 'detalles'])->middleware('sesion');
Route::get('cotizacion/descargar/{id}', [CotizacionesController::class, 'descargar'])->middleware('sesion');

//Cotizaciones - Vehiculo
Route::post('ajax/modelos', [CotizacionesController::class, 'modelosAJAX'])->middleware('sesion');
Route::post('cotizar/vehiculo', [CotizacionesController::class, 'vehiculo'])->middleware('sesion');

//Cotizaciones - Persona
Route::any('cotizar/persona', [CotizacionesController::class, 'persona'])->middleware('sesion');

//Route::any('emitir/{id}', [CotizacionesController::class, 'emitir'])->middleware('sesion');
