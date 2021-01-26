<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PolizasController;
use App\Http\Controllers\EmitirController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\CotizarController;
use App\Http\Controllers\DocumentosController;

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
Route::get('/', [HomeController::class, 'index'])->name("inicio")->middleware('sesion');

//ZohoController
Route::get('/zoho', [ZohoController::class, 'index']);

//LoginController
Route::any('ingresar', [LoginController::class, 'ingresar'])->name("ingresar");
Route::get('salir', [LoginController::class, 'salir'])->name("salir");

//PolizasController
Route::get('polizas', [PolizasController::class, 'index'])->name("polizas")->middleware('sesion');
Route::get('poliza/detalles/{id}', [PolizasController::class, 'detalles'])->name("poliza.detalles")->middleware('sesion');
Route::get('poliza/descargar/{id}', [PolizasController::class, 'descargar'])->name("poliza.descargar")->middleware('sesion');

//EmitirController
Route::any('emitir/auto/{id}', [EmitirController::class, 'auto'])->name("emitir.auto")->middleware('sesion');
Route::any('emitir/vida/{id}', [EmitirController::class, 'vida'])->name("emitir.vida")->middleware('sesion');

//ReportesController
Route::any('reporte/polizas', [ReportesController::class, 'polizas'])->name("reporte.polizas")->middleware('sesion');
Route::get('reporte/general/{id}', [ReportesController::class, 'general'])->name("reporte.general");
Route::get('reporte/accidente/{id}', [ReportesController::class, 'accidente'])->name("reporte.accidente");
Route::get('reporte/aseguradora/{id}', [ReportesController::class, 'aseguradora'])->name("reporte.aseguradora");
Route::get('reporte/lote/general/{id}', [ReportesController::class, 'generalLote'])->name("reporte.generalLote");
Route::get('reporte/lote/accidente/{id}', [ReportesController::class, 'accidenteLote'])->name("reporte.accidenteLote");
Route::get('reporte/lote/aseguradora/{id}', [ReportesController::class, 'aseguradoraLote'])->name("reporte.aseguradoraLote");

//UsuariosController
Route::any('editar', [UsuariosController::class, 'editar'])->name("editar")->middleware('sesion');

//CotizacionesController
Route::get('cotizaciones', [CotizacionesController::class, 'index'])->name("cotizaciones")->middleware('sesion');
Route::get('cotizacion/detalles/{id}', [CotizacionesController::class, 'detalles'])->name("cotizacion.detalles")->middleware('sesion');
Route::get('cotizacion/descargar/{id}', [CotizacionesController::class, 'descargar'])->name("cotizacion.descargar")->middleware('sesion');

//CotizarController
Route::get('cotizar', [CotizarController::class, 'index'])->name("cotizar")->middleware('sesion');
Route::any('cotizar/auto', [CotizarController::class, 'auto'])->name("cotizar.auto")->middleware('sesion');
Route::any('cotizar/vida', [CotizarController::class, 'vida'])->name("cotizar.vida")->middleware('sesion');
Route::post('modelos', [CotizarController::class, 'modelos'])->name("modelos");

//DocumentosController
Route::any('documentos/{id}', [DocumentosController::class, 'index'])->name("documentos")->middleware('sesion');