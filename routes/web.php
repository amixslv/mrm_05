<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TrainingEventController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('resources', ResourceController::class);
    Route::resource('trainingevents', TrainingEventController::class);
    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('departments', DepartmentController::class);

    Route::get('/events/{event}/add-resource', [EventController::class, 'addResourceForm'])->name('events.add-resource-form');
    Route::post('/events/{event}/add-resource', [EventController::class, 'addResourceToEvent'])->name('events.add-resource');
    Route::post('/events/{event}/return-resources', [EventController::class, 'returnResources'])->name('events.return-resources');
    Route::get('events/print', [EventController::class, 'print'])->name('events.print');
});

require __DIR__.'/auth.php';
