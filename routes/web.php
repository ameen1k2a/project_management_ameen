<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

// Automatically load the 'projects.index' page when accessing the root URL
Route::get('/', [ProjectController::class, 'index'])->name('projects.index');


Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/tasks', [ProjectController::class, 'tasks'])->name('tasks.index');
Route::get('/time-entries', [ProjectController::class, 'timeEntries'])->name('time-entries.index');
//Route::post('/time-entry', [ProjectController::class, 'addTimeEntry'])->name('time-entry.store');

Route::get('/tasks/get/{projectId}', [ProjectController::class, 'getTasks']);
Route::post('/time-entry/store', [ProjectController::class, 'store']);

// Add the route for the report page
Route::get('/report_view', [ProjectController::class, 'report_view'])->name('report_view.index');
Route::get('/projects/report', [ProjectController::class, 'report'])->name('projects.report');

