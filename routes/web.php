<?php

use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UsuarioController;
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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/produtos', [ProdutoController::class, 'index'])->middleware('auth');
Route::post('/produtos', [ProdutoController::class, 'store'])->middleware('auth')->name('produtos.store');

Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->middleware('auth');
Route::post('/configuracoes', [ConfiguracaoController::class, 'store'])->middleware('auth')->name('config.store');

Route::get('/usuarios', [UsuarioController::class, 'index'])->middleware('auth');
