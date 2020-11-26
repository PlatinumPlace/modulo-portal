<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\Cotizaciones\AutoController as cotizacionAuto;
use App\Http\Controllers\Cotizaciones\VidaController as cotizacionVida;
use App\Http\Controllers\PolizasController;
use App\Http\Controllers\Polizas\AutoController as polizaAuto;
use App\Http\Controllers\Polizas\VidaController as polizaVida;

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

//Sesion
Route::get('usuario/ingresar', [UsuariosController::class, 'create']);
Route::post('usuario/ingresar', [UsuariosController::class, 'store']);
Route::get('usuario/salir', [UsuariosController::class, 'destroy']);
Route::get('usuario/editar', [UsuariosController::class, 'edit']);
Route::post('usuario/editar', [UsuariosController::class, 'update']);


//Cotizaciones
Route::get('cotizaciones/{pag?}', [CotizacionesController::class, 'index'])->middleware('sesion');
Route::post('cotizaciones', [CotizacionesController::class, 'search'])->middleware('sesion');
Route::get('cotizacion/crear', [CotizacionesController::class, 'create'])->middleware('sesion');


//Cotizaciones - auto
Route::get('cotizacion/auto/crear', [cotizacionAuto::class, 'create'])->middleware('sesion');
Route::post('cotizacion/auto/ajax', [cotizacionAuto::class, 'ajax'])->middleware('sesion');
Route::post('cotizacion/auto/crear', [cotizacionAuto::class, 'store'])->middleware('sesion');
Route::get('cotizacion/auto/{id}', [cotizacionAuto::class, 'show'])->middleware('sesion');
Route::get('cotizacion/auto/descargar/{id}', [cotizacionAuto::class, 'download'])->middleware('sesion');


//Cotizaciones - vida
Route::get('cotizacion/vida/crear', [cotizacionVida::class, 'create'])->middleware('sesion');
Route::post('cotizacion/vida/crear', [cotizacionVida::class, 'store'])->middleware('sesion');
Route::get('cotizacion/vida/{id}', [cotizacionVida::class, 'show'])->middleware('sesion');
Route::get('cotizacion/vida/descargar/{id}', [cotizacionVida::class, 'download'])->middleware('sesion');


//Polizas
Route::get('/', [PolizasController::class, 'index'])->middleware('sesion');
Route::get('polizas/{pag?}', [PolizasController::class, 'list'])->middleware('sesion');
Route::post('polizas', [PolizasController::class, 'search'])->middleware('sesion');
Route::get('polizas/lista/emisiones', [PolizasController::class, 'emisiones'])->middleware('sesion');
Route::get('polizas/lista/vencimientos', [PolizasController::class, 'vencimientos'])->middleware('sesion');
Route::get('poliza/adjunto/descargar/{id}', [PolizasController::class, 'adjunto'])->middleware('sesion');


//Polizas - auto
Route::get('poliza/auto/{id}', [polizaAuto::class, 'show'])->middleware('sesion');
Route::get('poliza/auto/descargar/{id}', [polizaAuto::class, 'download'])->middleware('sesion');
Route::get('poliza/auto/crear/{id}', [polizaAuto::class, 'create'])->middleware('sesion');
Route::post('poliza/auto/crear', [polizaAuto::class, 'store'])->middleware('sesion');


//Polizas - vida
Route::get('poliza/vida/{id}', [polizaVida::class, 'show'])->middleware('sesion');
Route::get('poliza/vida/descargar/{id}', [polizaVida::class, 'download'])->middleware('sesion');
Route::get('poliza/vida/crear/{id}', [polizaVida::class, 'create'])->middleware('sesion');
Route::post('poliza/vida/crear', [polizaVida::class, 'store'])->middleware('sesion');