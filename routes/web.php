<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DebugController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user?->role_id == 1) {
        return redirect('/admin/dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RenjaController;
use App\Http\Controllers\RkpdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserRenjaController;

Route::middleware(['auth'])->group(function () {
    // Route Modul C
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/history', [FeedbackController::class, 'history'])->name('feedback.history');
    Route::put('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    
    Route::get('/dashboard-renja-user', [App\Http\Controllers\UserRenjaController::class, 'index'])
    ->middleware(['auth'])
    ->name('user.renja.dashboard');
    // Khusus Admin
    Route::get('/admin/feedback', [FeedbackController::class, 'adminIndex'])->name('feedback.admin');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // RENJA Routes
    Route::get('/renja', [RenjaController::class, 'index'])->name('admin.renja.index');
    Route::get('/renja/create', [RenjaController::class, 'create'])->name('admin.renja.create');
    Route::post('/renja', [RenjaController::class, 'store'])->name('admin.renja.store');
    Route::post('/renja/upload', [RenjaController::class, 'uploadStore'])->name('admin.renja.upload');
    Route::get('/renja/{renja}/edit', [RenjaController::class, 'edit'])->name('admin.renja.edit');
    Route::put('/renja/{renja}', [RenjaController::class, 'update'])->name('admin.renja.update');
    Route::delete('/renja/{renja}', [RenjaController::class, 'destroy'])->name('admin.renja.destroy');
    
    // RKPD Routes
    Route::get('/rkpd', [RkpdController::class, 'index'])->name('admin.rkpd.index');
    Route::get('/rkpd/create', [RkpdController::class, 'create'])->name('admin.rkpd.create');
    Route::post('/rkpd', [RkpdController::class, 'store'])->name('admin.rkpd.store');
    Route::post('/rkpd/upload', [RkpdController::class, 'uploadStore'])->name('admin.rkpd.upload');
    Route::get('/rkpd/{rkpd}/edit', [RkpdController::class, 'edit'])->name('admin.rkpd.edit');
    Route::put('/rkpd/{rkpd}', [RkpdController::class, 'update'])->name('admin.rkpd.update');
    Route::delete('/rkpd/{rkpd}', [RkpdController::class, 'destroy'])->name('admin.rkpd.destroy');
});

require __DIR__.'/auth.php';

// Debug route
Route::middleware('auth')->group(function () {
    Route::get('/api/check-auth', [DebugController::class, 'checkAuth']);
});
