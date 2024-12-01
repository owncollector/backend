<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('welcome');
});



Route::post("service/register",[ApiController::class, 'register'])->name('Register');

Route::post("service/login",[ApiController::class, 'login'])->name('login');

Route::post("service/store",[ObjetoController::class, 'store'])->name('store');

Route::get('/docs', function () {
    return view('l5-swagger::index');
});