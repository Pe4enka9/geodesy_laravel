<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalibrationController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TransferRequestController;
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
//    Route::resource('/equipments', EquipmentController::class)->only(['index', 'show']);
    Route::livewire('/equipments', 'pages::equipments')->name('equipments.index');

    // Пользователи
//    Route::resource('/users', UserController::class)->except('show');
    Route::livewire('/users', 'pages::users')->name('users.index');

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

    // Передачи
    Route::resource('/transfers', TransferRequestController::class)->only(['index', 'create', 'store']);
    Route::post('/transfers/{transfer}/accept', [TransferRequestController::class, 'accept'])->name('transfers.accept');
    Route::post('/transfers/{transfer}/cancel', [TransferRequestController::class, 'cancel'])->name('transfers.cancel');
    Route::post('/transfers/{transfer}/reject', [TransferRequestController::class, 'reject'])->name('transfers.reject');
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
