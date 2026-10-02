<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Siswa & Guru)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi Admin
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rute Pengelola / Admin (Terproteksi Middleware Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD & Manajemen Menu
    Route::post('/menus', [AdminController::class, 'storeMenu'])->name('menus.store');
    Route::put('/menus/{id}', [AdminController::class, 'updateMenu'])->name('menus.update');
    Route::patch('/menus/{id}/toggle', [AdminController::class, 'toggleAvailability'])->name('menus.toggle');
    Route::delete('/menus/{id}', [AdminController::class, 'destroyMenu'])->name('menus.destroy');

    // Pengaturan Informasi Kantin (Mendukung nama 'information.update' dan 'info.update')
    Route::post('/information', [AdminController::class, 'updateInfo'])->name('information.update');
    Route::post('/info', [AdminController::class, 'updateInfo'])->name('info.update');

    // Cetak Katalog Cetak Fisik A4
    Route::get('/print', [AdminController::class, 'printCatalog'])->name('print');
});