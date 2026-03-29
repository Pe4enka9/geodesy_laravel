<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalibrationController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Гость
Route::middleware('guest')->group(function () {
    // Авторизация
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login-form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Владелец и админ
Route::middleware('owner_or_admin')->group(function () {
    // Дашборд
    Route::get('/dashboard', [MainController::class, 'index'])->name('dashboard');

    // Оборудование
    Route::resource('/equipments', EquipmentController::class)->only(['index', 'show']);

    // Пользователи
    Route::resource('/users', UserController::class)->except('show');

    // Модели оборудования
    Route::resource('/models', EquipmentModelController::class)->only('index');

    // Типы оборудования
    Route::resource('/types', EquipmentTypeController::class)->only('index');

    // Поверки
    Route::resource('/calibrations', CalibrationController::class)->only('index');
});

// Авторизованный пользователь
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Админ
Route::middleware('admin')->group(function () {
    // Оборудование
    Route::resource('/equipments', EquipmentController::class)->except(['index', 'show']);

    // Модели оборудования
    Route::resource('/models', EquipmentModelController::class)->except(['index', 'show']);

    // Типы оборудования
    Route::resource('/types', EquipmentTypeController::class)->except(['index', 'show']);

    // Поверки
    Route::resource('/calibrations', CalibrationController::class)->except(['index', 'show']);
});
