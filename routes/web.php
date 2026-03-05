<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', fn () => redirect()->route('tasks.index'));
Route::resource('tasks', TaskController::class);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
// = resourse route for task controller
// Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
// Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
// Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
// Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
// Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');


require __DIR__ . '/auth.php';
