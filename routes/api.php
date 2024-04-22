<?php

use App\Http\Controllers\cricket_controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('addscorer',[cricket_controller::class,'scorerRegister']);
Route::get('scorerlogin',[cricket_controller::class,'scorerLogin']);
Route::get('scorerlogout',[cricket_controller::class,'scorerLogout']);

Route::post('addviewer',[cricket_controller::class,'viewerRegister']);
Route::get('viewerlogin',[cricket_controller::class,'viewerLogin']);
Route::get('viewerlogout',[cricket_controller::class,'viewerLogout']);

Route::post('batorbowl', [cricket_controller::class, 'storeData']);

Route::post('add-score', [cricket_controller::class, 'add_score']);

Route::get('scorecard',[cricket_controller::class,'scoreCard']);