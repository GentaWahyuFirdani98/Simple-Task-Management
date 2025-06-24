<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskRawController;
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

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (No middleware needed)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes (Require authentication via session)
Route::middleware(['auth.session'])->group(function () {
    // Dashboard - DB Helper Implementation
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

    // Task Management Routes - DB Helper Implementation
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // AJAX Routes - DB Helper Implementation
    Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Filter Routes - DB Helper Implementation
    Route::get('/tasks/filter/{status}', [TaskController::class, 'filterByStatus'])->name('tasks.filter');

    // ========================================
    // DB RAW IMPLEMENTATION ROUTES
    // ========================================

    // Dashboard - DB Raw Implementation
    Route::get('/dashboard/raw', [TaskRawController::class, 'dashboard'])->name('dashboard.raw');

    // Task Management Routes - DB Raw Implementation
    Route::get('/tasks/raw/create', function() {
        return view('tasks.create-raw');
    })->name('tasks.create.raw');
    Route::post('/tasks/raw', [TaskRawController::class, 'store'])->name('tasks.store.raw');
    Route::get('/tasks/raw/{id}/edit', [TaskRawController::class, 'edit'])->name('tasks.edit.raw');
    Route::put('/tasks/raw/{id}', [TaskRawController::class, 'update'])->name('tasks.update.raw');
    Route::delete('/tasks/raw/{id}', [TaskRawController::class, 'destroy'])->name('tasks.destroy.raw');

    // AJAX Routes - DB Raw Implementation
    Route::patch('/tasks/raw/{id}/status', [TaskRawController::class, 'updateStatus'])->name('tasks.updateStatus.raw');

    // Filter Routes - DB Raw Implementation
    Route::get('/tasks/raw/filter/{status}', [TaskRawController::class, 'filterByStatus'])->name('tasks.filter.raw');

    // Advanced DB Raw Examples
    Route::get('/tasks/raw/complex', [TaskRawController::class, 'getTasksWithComplexConditions'])->name('tasks.complex.raw');
    Route::get('/tasks/raw/statistics', [TaskRawController::class, 'getAdvancedStatistics'])->name('tasks.statistics.raw');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
