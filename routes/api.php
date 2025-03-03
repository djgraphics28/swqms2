<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UpdateDashboardController;

Route::post('/update-dashboard', [UpdateDashboardController::class, 'store']);
