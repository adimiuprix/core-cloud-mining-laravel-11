<?php

use App\Http\Controllers\{HomeController, DashboardController};
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::post('authorize', [HomeController::class, 'authorize']);
Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('logout', [HomeController::class, 'logout']);
