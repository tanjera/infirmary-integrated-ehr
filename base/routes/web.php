<?php

use App\Http\Middleware;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:clinician,administrator'])->group(function() {
    Route::get('/patients', function () {
        return view('patients');
    })->name('patients');
});

Route::middleware(['auth', 'verified', 'role:administrator'])->group(function() {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users/add', [UsersController::class, 'add'])->name('users.add');
    Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
    Route::post('/users/edit/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::get('/users/delete/confirm/{id}', [UsersController::class, 'confirm'])->name('users.confirm');
    Route::get('/users/delete/process/{id}', [UsersController::class, 'delete'])->name('users.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
