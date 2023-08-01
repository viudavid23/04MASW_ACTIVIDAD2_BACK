<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ResidentsController::class)->prefix('residents')->group(function () {
    Route::get('/find-all','index');
    Route::post('/store','store');
    Route::put('/update/{id}','update');
    Route::get('/findById/{id}','show');
    Route::delete('/delete/{id}','destroy');
});