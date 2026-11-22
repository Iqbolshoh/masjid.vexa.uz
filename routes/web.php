<?php

use App\Http\Controllers\Admin\MosqueAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MosqueController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/mosques', [HomeController::class, 'getMosquesApi'])->name('api.mosques');
Route::get('/mosque/{slug}', [MosqueController::class, 'show'])->name('mosque.show');
Route::get('/masjid/{slug}', [MosqueController::class, 'show']); // Backward compatibility alias

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected admin routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [MosqueAdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/mosque/{mosque}/prayer-times', [MosqueAdminController::class, 'updatePrayerTimes'])->name('admin.prayer-times.update');
    Route::post('/admin/mosque/{mosque}/details', [MosqueAdminController::class, 'updateDetails'])->name('admin.details.update');

    // Superadmin management routes
    Route::get('/superadmin', [MosqueAdminController::class, 'superadminDashboard'])->name('superadmin.dashboard');
    Route::post('/superadmin/mosques', [MosqueAdminController::class, 'storeMosque'])->name('superadmin.mosques.store');
});
