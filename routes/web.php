<?php

use App\Http\Controllers\CotizacionesAutoController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\CotizacionesVidaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PolizasAutoController;
use App\Http\Controllers\PolizasController;
use App\Http\Controllers\PolizasVidaController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

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

//HomeController
Route::get('/', HomeController::class)->middleware("sesion")->name("inicio");

//UsuariosController
Route::resource('usuario', UsuariosController::class);

//CotizacionesController
Route::resource('cotizacion', CotizacionesController::class)->middleware("sesion");

//CotizacionesAutoController
Route::post('cotizacion/auto/modelos', [CotizacionesAutoController::class, "modelos"])->middleware("sesion")->name("cotizacionAuto.modelos");
Route::get('cotizacion/auto/descargar/{id}', [CotizacionesAutoController::class, "descargar"])->middleware("sesion")->name("cotizacionAuto.descargar");
Route::resource('cotizacionAuto', CotizacionesAutoController::class)->middleware("sesion");

//CotizacionesVidaController
Route::get('cotizacion/vida/descargar/{id}', [CotizacionesVidaController::class, "descargar"])->middleware("sesion")->name("cotizacionVida.descargar");
Route::resource('cotizacionVida', CotizacionesVidaController::class)->middleware("sesion");

//PolizasController
Route::get('poliza/descargar/adjunto/{planid}/{adjuntoid}', [PolizasController::class, "adjunto"])->middleware("sesion")->name("poliza.adjunto");
Route::resource('poliza', PolizasController::class)->middleware("sesion");

//PolizasAutoController
Route::get('poliza/auto/create/{id}', [PolizasAutoController::class, "create"])->middleware("sesion")->name("polizaAuto.create");
Route::get('poliza/auto/descargar/{id}', [PolizasAutoController::class, "descargar"])->middleware("sesion")->name("polizaAuto.descargar");
Route::resource('polizaAuto', PolizasAutoController::class)->middleware("sesion");

//PolizasVidaController
Route::get('poliza/vida/create/{id}', [PolizasVidaController::class, "create"])->middleware("sesion")->name("polizaVida.create");
Route::get('poliza/vida/descargar/{id}', [PolizasVidaController::class, "descargar"])->middleware("sesion")->name("polizaVida.descargar");
Route::resource('polizaVida', PolizasVidaController::class)->middleware("sesion");
