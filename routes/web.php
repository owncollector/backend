<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImageAnalysisController ;

Route::get('/', function () {
    return view('welcome');
});

Route::post("service/register",[ApiController::class, 'register'])->name('Register');



Route::post("api/image-analisis",[ImageAnalysisController::class, 'analyze'])->name('analyze');