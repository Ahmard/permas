<?php

use App\Http\Controllers\Api\NoteCategoryController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\AuthController;
use QuickRoute\Crud;
use QuickRoute\Route;

Route::prefix('users')->group(function () {
    Route::post('/signup', [AuthController::class, 'doCreate']);
    Route::post('/login', [AuthController::class, 'doLogin']);
});

Route::middleware('auth:user')
    ->group(function () {
        Crud::create('notes', NoteController::class)
            ->numericParameter('noteId')
            ->disableDestroyAllRoute()
            ->go();

        Crud::create('categories', NoteCategoryController::class)
            ->numericParameter('catId')
            ->disableDestroyAllRoute()
            ->go();
    });