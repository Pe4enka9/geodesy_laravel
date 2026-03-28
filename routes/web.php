<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Гость
Route::middleware('guest')->group(function () {
    // Авторизация
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login-form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Авторизованный пользователь
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Дашборд
    Route::get('/dashboard', [MainController::class, 'index'])->name('dashboard');

    // Оборудование
    Route::resource('/equipments', EquipmentController::class)->except(['show']);
});
