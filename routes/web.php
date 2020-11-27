<?php

use App\Http\Controllers\CotizacionesAutoController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PolizasAutoController;
use App\Http\Controllers\PolizasController;
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
//Route::get('/', function () {
// return 'Hello World';
//})->middleware("sesion")->name("inicio");
Route::get('/', HomeController::class)->middleware("sesion")->name("inicio");


Route::resource('usuario', UsuariosController::class)->except([
    'index', 'show'
]);


Route::resource('cotizacion', CotizacionesController::class)->except([
   
])->middleware("sesion");


Route::get('poliza/descargar/adjunto/{planid}/{adjuntoid}', [PolizasController::class,"adjunto"])->middleware("sesion")->name("poliza.adjunto");
Route::resource('poliza', CotizacionesController::class)->except([
   
])->middleware("sesion");


Route::post('cotizacion/auto/modelos', [CotizacionesAutoController::class,"modelos"])->middleware("sesion")->name("cotizacionAuto.modelos");
Route::get('cotizacion/auto/descargar/{id}', [CotizacionesAutoController::class,"descargar"])->middleware("sesion")->name("cotizacionAuto.descargar");
Route::resource('cotizacionAuto', CotizacionesAutoController::class)->only([
   "create","store","show"
])->middleware("sesion");


Route::get('poliza/auto/create/{id}', [PolizasAutoController::class,"create"])->middleware("sesion")->name("polizaAuto.create");
Route::get('poliza/auto/descargar/{id}', [PolizasAutoController::class,"descargar"])->middleware("sesion")->name("polizaAuto.descargar");
Route::resource('polizaAuto', PolizasAutoController::class)->except([
   "create"
])->middleware("sesion");
