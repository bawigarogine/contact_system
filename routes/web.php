<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\UserController::class, 'login']);



Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/contact', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/greeting', [App\Http\Controllers\UserController::class, 'greeting']);
    Route::get('/create', [App\Http\Controllers\UserController::class, 'create']);
    Route::post('/store', [App\Http\Controllers\UserController::class, 'store']);
    Route::post('delete', [App\Http\Controllers\UserController::class, 'delete']);
    Route::post('/search', [App\Http\Controllers\UserController::class, 'search']);
    Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::put('update/{id}', [App\Http\Controllers\UserController::class, 'update']);
});

require __DIR__.'/auth.php';
