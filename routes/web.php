<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LoginController;
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
    Route::livewire('/users', 'pages::users')->name('users');
});

// Авторизованный пользователь
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Дашборд
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');

    // Оборудование
    Route::livewire('/equipments', 'pages::equipments')->name('equipments');

    // Модели оборудования
    Route::livewire('/models', 'pages::models')->name('models');

    // Типы оборудования
    Route::livewire('/types', 'pages::types')->name('types');

    // Поверки
    Route::livewire('/calibrations', 'pages::calibrations')->name('calibrations');

    // Передачи
    Route::livewire('/transfers', 'pages::transfers')->name('transfers');
    Route::get('/transfers/{transfer}/print', [DocumentController::class, 'printAct'])->name('print-act');
    Route::post('/transfers/{transfer}/upload', [DocumentController::class, 'uploadAct'])->name('upload-act');
    Route::get('/transfers/{transfer}/download', [DocumentController::class, 'downloadAct'])->name('download-act');

    // Отчет по оборудованию
    Route::get('/full-inventory-export', [DocumentController::class, 'exportEquipment'])->name('full-inventory-export');
    // Отчет по передачам оборудования
    Route::get('/full-transfers-export', [DocumentController::class, 'exportTransfers'])->name('full-transfers-export');
    // Отчет по поверкам
    Route::get('/full-calibrations-export', [DocumentController::class, 'exportCalibrations'])->name('full-calibrations-export');
});
