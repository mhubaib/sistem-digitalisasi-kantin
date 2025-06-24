<?php

use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Topup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

// Admin-only: 
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('/product', ProductController::class);
    Route::resource('/expenses', ExpenseController::class);

    // Santri Approval
    Route::get('/santri-approvals', [AuthController::class, 'index'])->name('santri.approvals');
    Route::patch('/santri-approvals/{id}/approve', [AuthController::class, 'approveSantri'])->name('santri.approve');
    Route::patch('/santri-approvals/{id}/reject', [AuthController::class, 'rejectSantri'])->name('santri.reject');

    // Transaction Route
    Route::get('admin/transaction/cart', [TransactionController::class, 'cart'])->name('admin.transaction.cart');
    Route::post('admin/transaction/store', [TransactionController::class, 'store'])->name('admin.transaction.store');
    Route::post('admin/transaction/sync-cart', [TransactionController::class, 'syncCart'])->name('admin.transaction.syncCart');
    Route::get('admin/transaction/export/excel', [TransactionController::class, 'exportExcel'])->name('admin.transaction.export.excel');
    Route::get('admin/transaction/export/pdf', [TransactionController::class, 'exportPdf'])->name('admin.transaction.export.pdf');

    // Routes untuk quantity controls:
    Route::patch('/admin/transaction/cart/increment/{id}', [TransactionController::class, 'incrementQuantity'])->name('admin.transaction.cart.increment');
    Route::patch('/admin/transaction/cart/decrement/{id}', [TransactionController::class, 'decrementQuantity'])->name('admin.transaction.cart.decrement');

    // Routes untuk Topup
    Route::get('/topup', [TopupController::class, 'index'])->name('topup.index');
    Route::get('/topup/create', [TopupController::class, 'create'])->name('topup.create');
    Route::post('/topup/store', [TopupController::class, 'store'])->name('topup.store');

    // Routes untuk Wallet Histories
    Route::get('/wallet-histories', [App\Http\Controllers\WalletHistoryController::class, 'index'])->name('wallet_histories.index');

    // admin Santri index
    Route::get('/santri/index', [UserController::class, 'santriIndex'])->name('santri.index');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/history', [NotificationController::class, 'historyAdmin'])->name('notifications.history');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/admin/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::get('/transaction/index', [TransactionController::class, 'allTransactions'])->name('transaction.index');

    // Santri Status Routes
    Route::get('/santri/{santri}/status/edit', [UserController::class, 'editSantriStatus'])->name('santri.status.edit');
    Route::put('/santri/{santri}/status', [UserController::class, 'updateSantriStatus'])->name('santri.status.update');
});


// Santri-only Dashboard
Route::middleware(['auth', 'role:santri'])->prefix('santri')->name('santri.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'santri'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'santriProfile'])->name('profile');
    Route::get('/product/index', [DashboardController::class, 'products'])->name('product.index');
    Route::get('/transactions/index', [DashboardController::class, 'transactions'])->name('transactions.index');
    Route::get('/topups/index', [DashboardController::class, 'topups'])->name('topups.index');

    // Santri notifications routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/history', [NotificationController::class, 'historySantri'])->name('notifications.history');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

// Wali-only Dashboard
Route::middleware(['auth', 'role:wali'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'wali'])->name('dashboard');
    Route::get('/transactions', [DashboardController::class, 'waliTransactions'])->name('transactions');
    Route::get('/topups', [DashboardController::class, 'waliTopups'])->name('topups');

    // Wali notifications routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/history', [NotificationController::class, 'historyWali'])->name('notifications.history');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::get('/profile', [UserController::class, 'waliProfile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
