<?php

use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return Auth::check() ? redirect('/home') : view('auth.login');
});

Auth::routes();

Route::prefix('')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('')->get('/produtos', [ProdutoController::class, 'index'])->middleware('auth')->name('produtos');
Route::prefix('')->post('/produtos', [ProdutoController::class, 'store'])->middleware('auth')->name('produtos.store');

Route::prefix('')->get('/configuracoes', [ConfiguracaoController::class, 'index'])->middleware('auth')->name('config');
Route::prefix('')->post('/configuracoes', [ConfiguracaoController::class, 'store'])->middleware('auth')->name('config.store');

Route::prefix('')->get('/usuarios', [UsuarioController::class, 'index'])->middleware('auth')->name('usuarios');

Route::prefix('')->post('/usuario', [UsuarioController::class, 'store'])->name('usuario.store')->middleware('auth')->name('usuarios.store');

Route::prefix('')->post('/usuario/reset-pass', [UsuarioController::class, 'restPassword'])->name('usuario.reset.password')->middleware('auth')->name('usuarios.reset.password');


Route::prefix('')->post('/forgot-password-mail', [UsuarioController::class, 'restPasswordMail'])->middleware('auth')->name('password.email');
