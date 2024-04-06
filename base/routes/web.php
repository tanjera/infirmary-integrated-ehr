<?php

use App\Http\Middleware;
use App\Http\Controllers\CensusController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/census/facility', [CensusController::class, 'facility_index'])->name('census.facility');
    Route::get('/census/unit/{id}', [CensusController::class, 'unit_index'])->name('census.unit');

    Route::get('/chart/dashboard/{id}', [ChartController::class, 'dashboard'])->name('chart.dashboard');
});


Route::middleware(['auth', 'verified', 'role:manager,administrator'])->group(function() {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients/add', [PatientController::class, 'add'])->name('patients.add');
    Route::get('/patients/edit/{id}', [PatientController::class, 'edit'])->name('patients.edit');
    Route::post('/patients/edit/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::get('/patients/delete/confirm/{id}', [PatientController::class, 'confirm'])->name('patients.confirm');
    Route::get('/patients/delete/process/{id}', [PatientController::class, 'delete'])->name('patients.delete');

    Route::get('/rooms/assign/{id}', [RoomController::class, 'select'])->name('rooms.select');
    Route::post('/rooms/assign/{id}', [RoomController::class, 'assign'])->name('rooms.assign');
    Route::get('/rooms/unassign/{id}', [RoomController::class, 'unassign'])->name('rooms.unassign');

    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::post('/facilities/add', [FacilityController::class, 'add'])->name('facilities.add');
    Route::get('/facilities/edit/{id}', [FacilityController::class, 'edit'])->name('facilities.edit');
    Route::post('/facilities/edit/{id}', [FacilityController::class, 'update'])->name('facilities.update');
    Route::get('/facilities/delete/confirm/{id}', [FacilityController::class, 'confirm'])->name('facilities.confirm');
    Route::get('/facilities/delete/process/{id}', [FacilityController::class, 'delete'])->name('facilities.delete');
});

Route::middleware(['auth', 'verified', 'role:administrator'])->group(function() {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/add', [UserController::class, 'add'])->name('users.add');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/edit/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/delete/confirm/{id}', [UserController::class, 'confirm'])->name('users.confirm');
    Route::get('/users/delete/process/{id}', [UserController::class, 'delete'])->name('users.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
