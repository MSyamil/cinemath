<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/process', [MovieController::class, 'process'])->name('process');
Route::post('/process', [MovieController::class, 'process']);
Route::get('/export-excel', [MovieController::class, 'exportExcel'])->name('movies.export-excel');
Route::post('/export-excel', [MovieController::class, 'exportExcel']);

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/movies/{movie_id}/toggle-watched', [MovieController::class, 'toggleWatched'])->name('movies.toggle-watched');
    Route::view('/account/biometric', 'auth.biometric-settings')->name('biometric.settings');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});
