<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('welcome');
});



Route::post("service/register",[ApiController::class, 'register'])->name('Register');

Route::get('/docs', function () {
    return view('l5-swagger::index');
});