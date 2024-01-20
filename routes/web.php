<?php

use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/produtos', [ProdutoController::class, 'index'])->middleware('auth');
Route::post('/produtos', [ProdutoController::class, 'store'])->middleware('auth')->name('produtos.store');

Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->middleware('auth');
Route::post('/configuracoes', [ConfiguracaoController::class, 'store'])->middleware('auth')->name('config.store');

Route::get('/usuarios', [UsuarioController::class, 'index'])->middleware('auth');

Route::post('/usuario', [UsuarioController::class, 'store'])->name('usuario.store')->middleware('auth');

Route::post('/usuario/reset-pass', [UsuarioController::class, 'restPassword'])->name('usuario.reset.password')->middleware('auth');


Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['status' => __($status)], 200)
        : response()->json(['email' => __($status)], 404);
})->middleware('auth')->name('password.email');
