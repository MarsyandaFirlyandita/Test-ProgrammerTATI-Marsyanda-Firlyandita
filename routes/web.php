<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogHarianController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('log.index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::resource('log', LogHarianController::class);
    Route::post('log/{id}/verifikasi', [LogHarianController::class, 'verifikasi'])->name('log.verifikasi');
});
