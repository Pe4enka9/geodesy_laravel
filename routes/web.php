<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalibrationController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TransferRequestController;
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
    // Персонал
    Route::livewire('/users', 'pages::users')->name('users.index');
});

// Авторизованный пользователь
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Дашборд
    Route::get('/dashboard', [MainController::class, 'index'])->name('dashboard');

    // Оборудование
    Route::livewire('/equipments', 'pages::equipments')->name('equipments.index');

    // Модели оборудования
    Route::livewire('/models', 'pages::models')->name('models.index');

    // Типы оборудования
    Route::livewire('/types', 'pages::types')->name('types.index');

    // Поверки
    Route::livewire('/calibrations', 'pages::calibrations')->name('calibrations.index');

    // Передачи
    Route::livewire('/transfers', 'pages::transfers')->name('transfers.index');
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
