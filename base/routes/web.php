<?php

use App\Http\Middleware;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:manager,administrator'])->group(function() {
    Route::get('/patients', [PatientsController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientsController::class, 'create'])->name('patients.create');
    Route::post('/patients/add', [PatientsController::class, 'add'])->name('patients.add');
    Route::get('/patients/edit/{id}', [PatientsController::class, 'edit'])->name('patients.edit');
    Route::post('/patients/edit/{id}', [PatientsController::class, 'update'])->name('patients.update');
    Route::get('/patients/delete/confirm/{id}', [PatientsController::class, 'confirm'])->name('patients.confirm');
    Route::get('/patients/delete/process/{id}', [PatientsController::class, 'delete'])->name('patients.delete');

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
