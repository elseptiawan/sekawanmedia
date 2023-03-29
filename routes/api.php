<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    OrderController,
    ApproverController
};

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

Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function(){
    Route::resource('order', OrderController::class)
    ->missing(function () {
        return response()->json(['message' => 'data not found'], 400);;
    });;
});

Route::group(['middleware' => ['auth:sanctum', 'ability:approver']], function(){
    Route::get('/approve', [ApproverController::class, 'index']);
    Route::put('/approve/{id}', [ApproverController::class, 'approve']);
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/export', [OrderController::class, 'export']);
