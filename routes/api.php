<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServicesController; 

Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::put('/clients/{id}', [ClientController::class, 'update']);

Route::get('/services', [ServicesController::class, 'index']);
Route::post('/services', [ServicesController::class, 'store']);
Route::get('/services/{id}', [ServicesController::class, 'show']);
Route::put('/services/{id}', [ServicesController::class, 'update']);

Route::post('/services/{service_id}/clients/{client_id}', [ServicesController::class, 'add_service_to_client']);
Route::delete('/services/{service_id}/clients/{client_id}', [ServicesController::class, 'remove_service_from_client']);