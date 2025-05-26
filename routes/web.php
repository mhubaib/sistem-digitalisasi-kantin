<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman awal
Route::get('/', function () {
    return redirect('/login');
});

// Autentikasi (Login & Register)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Admin-only: Approve / Reject Santri
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    Route::get('/santri-approvals', [AuthController::class, 'index'])->name('santri.approvals');
    Route::patch('/santri-approvals/{id}/approve', [AuthController::class, 'approveSantri'])->name('santri.approve');
    Route::patch('/santri-approvals/{id}/reject', [AuthController::class, 'rejectSantri'])->name('santri.reject');
});

// Santri-only Dashboard
Route::middleware(['auth', 'role:santri'])->prefix('santri')->name('santri.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'santri'])->name('dashboard');
});

// Wali-only Dashboard
Route::middleware(['auth', 'role:wali'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'wali'])->name('dashboard');
});
