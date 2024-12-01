<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImageAnalysisController ;

Route::get('/', function () {
    return view('welcome');
});

Route::post("api/register",[ApiController::class, 'register'])->name('Register');



Route::post("api/image-analisis",[ImageAnalysisController::class, 'analyze'])->name('analyze');
Route::post("api/login",[ApiController::class, 'login'])->name('login');

Route::get('/docs', function () {
    return view('l5-swagger::index');
});
Route::get('/docs', [ApiDocsController::class, 'swagger']);
