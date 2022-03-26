<?php

use App\Http\Controllers\productosController;
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

Route::prefix('productos')->group(function () {
    Route::get('/',[productosController::class, 'get']);
    Route::get('/{slug}',[productosController::class, 'getSlug']);
    Route::post('/',[productosController::class, 'create']);
    Route::post('/{id}',[productosController::class, 'update']);
    Route::delete('/{id}',[productosController::class, 'delete']);
});

