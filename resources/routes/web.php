<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use QuickRoute\Route;

Route::get('/', [MainController::class, 'index']);

Route::match(['get', 'post'], 'login', [AuthController::class, 'showLoginForm'])->name('login.');
Route::match(['get', 'post'], 'register', [AuthController::class, 'showRegisterForm'])->name('register.');
