<?php

use App\Http\Controllers\TareaController;
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
    return view('app_tareas.index');
});

Route::post('/login', function () {
    //almacenando usuario

    return view('welcome');
});



Route::get('/usuarios', function () {
    //vista de usuario
    return view('welcome');
});

Route::post('/usuarios', function () {
    //almacenando usuario

    return view('welcome');
});


Route::get('/tareas', function () {
    //vista de usuario
    return view('welcome');
});

Route::post('/tareas', function () {
    //vista de usuario
    return view('welcome');
});
Route::put('/tareas/{id}', function () {
    //vista de usuario
    return view('welcome');
});


Route::resource('/tareas',TareaController::class);