<?php

use App\Http\Middleware;
use App\Http\Controllers\CensusController;
use App\Http\Controllers\Chart\ChartController;
use App\Http\Controllers\Chart\AllergyController;
use App\Http\Controllers\Chart\DiagnosticsController;
use App\Http\Controllers\Chart\NoteController;
use App\Http\Controllers\Chart\OrderController;
use App\Http\Controllers\Chart\MARController;
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
    Route::get('/storage/note_attachments/{filename}', [NoteController::class, 'view_attachment'])->name('note_attachments.view');

    Route::get('/chart/diagnostics/{id}', [DiagnosticsController::class, 'index'])->name('chart.diagnostics');
    Route::get('/chart/diagnostics/view/{id}', [DiagnosticsController::class, 'view'])->name('chart.diagnostics.view');
    Route::get('/chart/diagnostics/create/{id}', [DiagnosticsController::class, 'create'])->name('chart.diagnostics.create');
    Route::post('/chart/diagnostics/create/{id}', [DiagnosticsController::class, 'add'])->name('chart.diagnostics.add');
    Route::get('/chart/diagnostics/append/{id}', [DiagnosticsController::class, 'append'])->name('chart.diagnostics.append');
    Route::post('/chart/diagnostics/affix/{id}', [DiagnosticsController::class, 'affix'])->name('chart.diagnostics.affix');
    Route::get('/storage/diagnostic_attachments/{filename}', [DiagnosticsController::class, 'view_attachment'])->name('diagnostics_attachments.view');

    Route::get('/chart/orders/{id}', [OrderController::class, 'index'])->name('chart.orders');
    Route::get('/chart/orders/active/{id}', [OrderController::class, 'index'])->name('chart.active.orders');
    Route::get('/chart/orders/view/{id}', [OrderController::class, 'view'])->name('chart.orders.view');
    Route::get('/chart/orders/create/{id}', [OrderController::class, 'create'])->name('chart.orders.create');
    Route::post('/chart/orders/create/{id}', [OrderController::class, 'add'])->name('chart.orders.add');
    Route::get('/chart/orders/cosign/{id}', [OrderController::class, 'cosign'])->name('chart.orders.cosign');
    Route::get('/chart/orders/activate/{id}', [OrderController::class, 'activate'])->name('chart.orders.activate');
    Route::get('/chart/orders/complete/{id}', [OrderController::class, 'complete'])->name('chart.orders.complete');
    Route::get('/chart/orders/discontinue/{id}', [OrderController::class, 'discontinue'])->name('chart.orders.discontinue');

    Route::get('/chart/results/{id}', [ChartController::class, 'results'])->name('chart.results');
    Route::get('/chart/flowsheet/{id}', [ChartController::class, 'flowsheet'])->name('chart.flowsheet');

    Route::get('/chart/mar/{id}', [MARController::class, 'index'])->name('chart.mar');
    Route::get('/chart/mar/q_dose/{id}', [MARController::class, 'q_dose'])->name('chart.mar.q_dose');
    Route::get('/chart/mar/q_given/{id}', [MARController::class, 'q_given'])->name('chart.mar.q_given');
    Route::get('/chart/mar/q_status/{id}', [MARController::class, 'q_status'])->name('chart.mar.q_status');
    Route::post('/chart/mar/q_status/{id}', [MARController::class, 'q_modify'])->name('chart.mar.q_modify');

    Route::get('/chart/mar/prn_dose/{id}', [MARController::class, 'prn_dose'])->name('chart.mar.prn_dose');
    Route::get('/chart/mar/prn_given/{id}', [MARController::class, 'prn_given'])->name('chart.mar.prn_given');
    Route::post('/chart/mar/prn_status/{id}', [MARController::class, 'prn_modify'])->name('chart.mar.prn_modify');
});

Route::middleware(['auth', 'verified', 'role:manager,administrator'])->group(function() {
    Route::get('/chart/notes/delete/{id}', [NoteController::class, 'delete'])->name('chart.notes.delete');
    Route::get('/chart/diagnostics/delete/{id}', [DiagnosticsController::class, 'delete'])->name('chart.diagnostics.delete');
    Route::get('/chart/orders/delete/{id}', [OrderController::class, 'confirm'])->name('chart.orders.delete');
    Route::get('/chart/orders/delete/confirm/{id}', [OrderController::class, 'confirm_rx'])->name('chart.orders.delete.confirm');
    Route::get('/chart/orders/delete/process/{id}', [OrderController::class, 'delete'])->name('chart.orders.delete.process');

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
