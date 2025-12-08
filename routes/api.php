<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredAgentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/companies', [CompanyController::class, 'store']);

    Route::put('/registered-agent/{company_id}', [RegisteredAgentController::class, 'updateAgent']);

    Route::get('/registered-agent-capacity/{state}', [RegisteredAgentController::class, 'checkCapacity']);

});

Route::post('/login', [UserController::class, 'login']);
