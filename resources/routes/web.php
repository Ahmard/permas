<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\User\NoteController;
use QuickRoute\Route;

Route::get('/', [MainController::class, 'index']);

Route::match(['get', 'post'], 'login', [AuthController::class, 'showLoginForm'])->name('login.');
Route::match(['get', 'post'], 'register', [AuthController::class, 'showRegisterForm'])->name('register.');

Route::prefix('notes')
    ->name('notes.')
    ->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('index');
        Route::get('/{noteId}', [NoteController::class, 'view'])
            ->name('index')
            ->whereNumber('noteId');
    });