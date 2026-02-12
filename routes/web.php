<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DebugController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RenjaController;
use App\Http\Controllers\RkpdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserRenjaController;
use App\Http\Controllers\UserRkpdController;
use App\Http\Controllers\APBDController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\UserRealisasiController;
use App\Http\Controllers\UserAPBDController;

Route::get('/', [UserRenjaController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user?->role_id == 1) {
        return redirect('/admin/dashboard');
    }
    return redirect()->route('user.renja.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware(['auth'])->group(function () {
    // Route Modul C
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/history', [FeedbackController::class, 'history'])->name('feedback.history');
    Route::patch('/feedback/{id}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    
    Route::get('/dashboard-renja-user', [App\Http\Controllers\UserRenjaController::class, 'index'])
    ->middleware(['auth'])
    ->name('user.renja.dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [UserRenjaController::class, 'index'])->name('dashboard');
        Route::get('/user/renja', [UserRenjaController::class, 'index'])->name('user.renja.index');
        Route::get('/user/rkpd', [UserRkpdController::class, 'index'])->name('user.rkpd.index');
    });

   
    // Khusus Admin
    Route::get('/admin/feedback', [FeedbackController::class, 'adminIndex'])->name('feedback.admin');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Feedback Routes
    Route::get('/feedback', [FeedbackController::class, 'adminIndex'])->name('admin.feedback.index');
    Route::patch('/feedback/{id}/status', [FeedbackController::class, 'updateStatus'])->name('admin.feedback.updateStatus');
    
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

// Rute Admin untuk Anggaran (APBD)
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // APBD Routes
    Route::get('/apbd', [App\Http\Controllers\APBDController::class, 'index'])->name('admin.apbd.index');
    Route::get('/apbd/create', [App\Http\Controllers\APBDController::class, 'create'])->name('admin.apbd.create');
    Route::post('/apbd', [App\Http\Controllers\APBDController::class, 'store'])->name('admin.apbd.store');
    Route::post('/apbd/import', [App\Http\Controllers\APBDController::class, 'import'])->name('admin.apbd.import'); // Jika ada fitur import excel
    Route::get('/apbd/{apbd}/edit', [App\Http\Controllers\APBDController::class, 'edit'])->name('admin.apbd.edit');
    Route::put('/apbd/{apbd}', [App\Http\Controllers\APBDController::class, 'update'])->name('admin.apbd.update');
    Route::delete('/apbd/{apbd}', [App\Http\Controllers\APBDController::class, 'destroy'])->name('admin.apbd.destroy');

    // Realisasi Routes
    Route::get('/realisasi', [App\Http\Controllers\RealisasiController::class, 'index'])->name('admin.realisasi.index');
    Route::get('/realisasi/create', [App\Http\Controllers\RealisasiController::class, 'create'])->name('admin.realisasi.create');
    Route::post('/realisasi', [App\Http\Controllers\RealisasiController::class, 'store'])->name('admin.realisasi.store');
    Route::post('/realisasi/import', [App\Http\Controllers\RealisasiController::class, 'import'])->name('admin.realisasi.import');
    Route::get('/realisasi/{realisasi}/edit', [App\Http\Controllers\RealisasiController::class, 'edit'])->name('admin.realisasi.edit');
    Route::put('/realisasi/{realisasi}', [App\Http\Controllers\RealisasiController::class, 'update'])->name('admin.realisasi.update');
    Route::delete('/realisasi/{realisasi}', [App\Http\Controllers\RealisasiController::class, 'destroy'])->name('admin.realisasi.destroy');
});
