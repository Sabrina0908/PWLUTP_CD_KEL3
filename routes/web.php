<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Home/Landing Page - Redirect ke Login atau Dashboard
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('auth.showLoginForm');
});

// Rute Autentikasi
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegisterForm')->name('auth.showRegisterForm'); 
    Route::post('/register', 'register')->name('auth.register'); 
    
    Route::get('/login', 'showLoginForm')->name('auth.showLoginForm'); 
    Route::post('/login', 'login')->name('auth.login'); 
    
    Route::post('/logout', 'logout')->name('auth.logout')->middleware('auth');
});


// Rute Membutuhkan Login (Auth)
Route::middleware('auth')->group(function () {
    
    // Dashboard (Memuat semua data tugas dan prioritas)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Tasks (Dapat diakses User biasa & Admin) - TANPA INDEX
    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Rute tambahan untuk toggle status selesai
    Route::put('tasks/{task}/complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggleComplete');


    // Rute Admin Khusus (Dilindungi oleh Middleware 'is_admin')
    Route::middleware('is_admin')->group(function () {
        // CRUD Prioritas - TIDAK MENYERTAKAN INDEX DAN SHOW
        Route::resource('priorities', PriorityController::class)->except(['index', 'show']);
    });
});