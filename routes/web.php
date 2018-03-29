<?php

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
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('usuario/redefinir-senha', 'RedefinirSenhaController@showRedefinirSenhaFormUser')->name('usuarios.form.alterar-senha');
Route::post('usuario/redefinir-senha', 'RedefinirSenhaController@redefinirSenhaUser')->name('usuarios.alterar-senha');

Route::post('moip/webhook', 'MoipController@webhook')->name("moip.webhook");

Route::get('{vue_capture?}', function () {
    return view('admin_vue.app');
})->where('vue_capture', '[\/\w\.-]*');