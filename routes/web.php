<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

$pages = [
    'dashboard' => 'dashboard',
    'myTask' => 'mytask',
    'planning' => 'planning',
];

foreach ($pages as $route => $view) {
    Route::get("/$route", fn () => view($view))
        ->middleware(['auth', 'verified'])
        ->name($route);
}

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tasks', TaskController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('projectRoles', ProjectRoleController::class);
});

Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])
    ->name('tasks.updateStatus')
    ->middleware('auth');

require __DIR__.'/auth.php';
