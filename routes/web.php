<?php

use App\Http\Controllers\Cotizaciones\AutoController as cotizacionesAuto;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\Cotizaciones\VidaController as cotizacionesVida;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Polizas\AutoController as polizasAuto;
use App\Http\Controllers\PolizasController;
use App\Http\Controllers\Polizas\VidaController as polizasVida;
use App\Http\Controllers\Polizas\ReportesController as reportes;
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
Route::get('cotizaciones', [CotizacionesController::class, "index"])->middleware("sesion")->name("cotizaciones.index");
Route::get('cotizar/{tipo}', [CotizacionesController::class, "cotizar"])->middleware("sesion")->name("cotizaciones.cotizar");
Route::get('cotizacion/{id}', [CotizacionesController::class, "detalles"])->middleware("sesion")->name("cotizaciones.detalles");
Route::get('cotizacion/descargar/{id}', [CotizacionesController::class, "descargar"])->middleware("sesion")->name("cotizaciones.descargar");
Route::get('cotizacion/emitir/{id}', [CotizacionesController::class, "emitir"])->middleware("sesion")->name("cotizaciones.emitir");
Route::get('cotizar/vida', [CotizacionesController::class, "vida"])->middleware("sesion")->name("vida.cotizar");
Route::get('cotizacion/documentos/{id}', [CotizacionesController::class, "documentos"])->middleware("sesion")->name("cotizaciones.documentos");
Route::get('cotizacion/descargar/adjunto/{planid}/{adjuntoid}', [CotizacionesController::class, "adjunto"])->middleware("sesion")->name("cotizaciones.adjunto");

//Auto
Route::post('coizaciones/modelos', [CotizacionesController::class, "modelos"])->middleware("sesion")->name("cotizaciones.modelos");
Route::resource('cotizacionesAuto', cotizacionesAuto::class)->middleware("sesion");

//Vida
Route::resource('cotizacionesVida', cotizacionesVida::class)->middleware("sesion");


//PolizasController
Route::get('poliza/{id}', [PolizasController::class, "detalles"])->middleware("sesion")->name("polizas.detalles");
Route::get('poliza/descargar/{id}', [PolizasController::class, "descargar"])->middleware("sesion")->name("polizas.descargar");
Route::get('polizas/reportes', [PolizasController::class, "reportes"])->middleware("sesion")->name("polizas.reportes");
Route::resource('reportes', reportes::class)->middleware("sesion");

//Auto
Route::resource('polizasAuto', polizasAuto::class)->middleware("sesion");

//Vida
Route::resource('polizasVida', polizasVida::class)->middleware("sesion");