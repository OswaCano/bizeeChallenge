<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredAgentController;

Route::post('/companies', [CompanyController::class, 'store']);

Route::put('registered-agent/{company}', [RegisteredAgentController::class, 'updateAgent']);

Route::get('registered-agent-capacity/{state}', [RegisteredAgentController::class, 'checkCapacity']);
