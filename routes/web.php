<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PredictAnxietyController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/anxiety-prediction', function () {
        return view('anxiety-prediction');
    })->name('anxiety-prediction');
    
});
Route::post('/anxiety-prediction/prediction-in-progress', [PredictAnxietyController::class, 'predict'])->name('prediction.result');
Route::get('/prediction-result', [PredictAnxietyController::class, 'showResult'])->name('prediction.result.view');





