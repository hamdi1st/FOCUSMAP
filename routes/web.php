<?php

use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('goals', GoalController::class); // includes index, create, store, show, edit, update, destroy
    Route::get('/map', [GoalController::class, 'map'])->name('goals.map');
});

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
});

Route::post('/goals/{goal}/steps', [\App\Http\Controllers\StepController::class, 'store'])->name('steps.store');
Route::patch('/goals/{goal}/steps/{step}/toggle', [\App\Http\Controllers\StepController::class, 'toggle'])->name('steps.toggle');
Route::delete('/goals/{goal}/steps/{step}', [\App\Http\Controllers\StepController::class, 'destroy'])->name('steps.destroy');
Route::get('/goals/{goal}/mindmap', [\App\Http\Controllers\GoalController::class, 'mindmap'])->name('goals.mindmap');

Route::get('/public-goals', [GoalController::class, 'publicGoals'])->name('goals.public');


require __DIR__.'/auth.php';
