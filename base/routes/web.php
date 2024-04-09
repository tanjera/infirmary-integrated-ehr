<?php

use App\Http\Middleware;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CensusController;
use App\Http\Controllers\Chart\ChartController;
use App\Http\Controllers\Chart\AllergyController;
use App\Http\Controllers\Chart\NoteController;
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

    Route::get('/chart/{id}', [ChartController::class, 'index'])->name('chart');
    Route::get('/chart/demographics/{id}', [ChartController::class, 'demographics'])->name('chart.demographics');

    Route::get('/chart/allergies/{id}', [AllergyController::class, 'index'])->name('chart.allergies');
    Route::get('/chart/allergies/create/{id}', [AllergyController::class, 'create'])->name('chart.allergies.create');
    Route::post('/chart/allergies/add/{id}', [AllergyController::class, 'add'])->name('chart.allergies.add');
    Route::get('/chart/allergies/delete/{id}', [AllergyController::class, 'delete'])->name('chart.allergies.delete');

    Route::get('/chart/notes/{id}', [NoteController::class, 'index'])->name('chart.notes');
    Route::get('/chart/notes/view/{id}', [NoteController::class, 'view'])->name('chart.notes.view');
    Route::get('/chart/notes/create/{id}', [NoteController::class, 'create'])->name('chart.notes.create');
    Route::post('/chart/notes/create/{id}', [NoteController::class, 'add'])->name('chart.notes.add');
    Route::get('/chart/notes/append/{id}', [NoteController::class, 'append'])->name('chart.notes.append');
    Route::post('/chart/notes/affix/{id}', [NoteController::class, 'affix'])->name('chart.notes.affix');
    Route::get('/note_attachments/{filename}', [NoteController::class, 'get_attachment'])->name('note_attachments.get');

    Route::get('/chart/results/{id}', [ChartController::class, 'results'])->name('chart.results');
    Route::get('/chart/diagnostics/{id}', [ChartController::class, 'diagnostics'])->name('chart.diagnostics');
    Route::get('/chart/orders/{id}', [ChartController::class, 'orders'])->name('chart.orders');
    Route::get('/chart/flowsheet/{id}', [ChartController::class, 'flowsheet'])->name('chart.flowsheet');
    Route::get('/chart/mar/{id}', [ChartController::class, 'mar'])->name('chart.mar');
});


Route::middleware(['auth', 'verified', 'role:manager,administrator'])->group(function() {
    Route::get('/chart/notes/delete/{id}', [NoteController::class, 'delete'])->name('chart.notes.delete');

    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients/add', [PatientController::class, 'add'])->name('patients.add');
    Route::get('/patients/edit/{id}', [PatientController::class, 'edit'])->name('patients.edit');
    Route::post('/patients/edit/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::get('/patients/delete/confirm/{id}', [PatientController::class, 'confirm'])->name('patients.confirm');
    Route::get('/patients/delete/process/{id}', [PatientController::class, 'delete'])->name('patients.delete');

    Route::get('/rooms/confirm', function() { return view('rooms.confirm'); })->name('rooms.confirm');
    Route::get('/rooms/clear', [RoomController::class, 'clear'])->name('rooms.clear');
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
