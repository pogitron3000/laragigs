<?php

use App\Http\Controllers\ListingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::get('/', [ListingsController::class, 'index']);

Route::get('/listings/create', [ListingsController::class, 'create']);

Route::post('/listings', [ListingsController::class, 'store']);

Route::get('/listings/{listing}/edit', [ListingsController::class, 'edit']);

Route::put('/listings/{listing}', [ListingsController::class, 'update']);

Route::delete('/listings/{listing}', [ListingsController::class, 'destroy']);

Route::get('/listings/{listing}', [ListingsController::class, 'show']); 



Route::get('/register', [UsersController::class, 'register']);

Route::post('/users', [UsersController::class, 'store']);

Route::post('/logout', [UsersController::class, 'logout']);