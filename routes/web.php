<?php

use App\Http\Controllers\ConsultaSoatController;
use App\Http\Controllers\PoliticaController;
use App\Http\Controllers\QrConfigController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Rutas públicas de consulta SOAT
|--------------------------------------------------------------------------
*/
Route::post('/consulta', [ConsultaSoatController::class, 'consulta'])->name('consulta.publica');
Route::get('/consulta/resultados', [ConsultaSoatController::class, 'resultados'])->name('consulta.resultados');
Route::get('/soat/confirmacion', [ConsultaSoatController::class, 'confirmacion'])->name('soat.confirmacion');
Route::get('/soat/pago', [ConsultaSoatController::class, 'pago'])->name('soat.pago');
Route::get('/soat/pago/qr', [ConsultaSoatController::class, 'pagoQr'])->name('soat.pago.qr');
Route::get('/soat/pago/tarjeta', [ConsultaSoatController::class, 'pagoTarjeta'])->name('soat.pago.tarjeta');

/*
|--------------------------------------------------------------------------
| Rutas públicas de políticas
|--------------------------------------------------------------------------
*/
Route::get('/politica-privacidad', [PoliticaController::class, 'privacidad'])->name('politica.privacidad');
Route::get('/terminos-condiciones', [PoliticaController::class, 'terminos'])->name('terminos.condiciones');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (auth)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
    Route::get('/configuracion/qr', [QrConfigController::class, 'edit'])->name('qr-config.edit');
    Route::put('/configuracion/qr', [QrConfigController::class, 'update'])->name('qr-config.update');
});

require __DIR__.'/auth.php';
