<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ObjetoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post("api/register",[ApiController::class, 'register'])->name('Register');

Route::post("api/login",[ApiController::class, 'login'])->name('login');

Route::post("api/store",[ObjetoController::class, 'store'])->name('store');

Route::get("api/getTrash/{id}",[ObjetoController::class, 'getTrash'])->name('getTrash');

Route::get('/docs', function () {
    return view('l5-swagger::index');
});
Route::get('/docs', [ApiDocsController::class, 'swagger']);
