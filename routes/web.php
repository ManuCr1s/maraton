<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProvinceController;
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

Route::controller(UserController::class)->group(function(){
    Route::get('/','index')->name('welcome');
    Route::get('/formulario','form')->name('form');
    Route::get('/tablero','dashboard')->middleware('auth')->name('dashboard');
    Route::get('/registro','register')->middleware('auth')->name('register');
    Route::get('/inscrito','inscription')->middleware('auth')->name('inscription');
    Route::get('/documents/{nombreArchivo}', 'download')->name('download');
    Route::get('/login','login')->name('login');
    Route::post('/acceso','store')->name('access');
    Route::post('/cerrar','logout')->name('logout');
});

Route::controller(PersonController::class)->group(function(){
    Route::post('/dni','store')->name('dni');
    Route::post('/datos','file')->name('dates');
    Route::post('/categoria','show_count')->name('level');
    Route::post('/actualizarRegistro','update')->name('numberCorredor');
    Route::get('/listadoInscrito','inscription')->name('listadoInscription');
    Route::get('/listadoRegistro','register')->middleware('auth')->name('listadoRegistro');
});

Route::controller(ProvinceController::class)->group(function(){
    Route::post('/provincia','store')->name('province');
    Route::post('/distrito','show')->name('district');
    Route::post('/paises','find')->name('country');
});