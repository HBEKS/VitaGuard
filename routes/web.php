<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// ==================== CATEGORY ROUTES ====================
Route::resource('/dashboard/categories', CategoryController::class);
Route::get('/dashboard/categories/showExpensiveService', [CategoryController::class, 'showExpensiveService'])->name('categories.expensive');
Route::post('/dashboard/category/showInfo', [CategoryController::class, 'showInfo'])->name('category.showInfo');
Route::post('/dashboard/category/showListServices', [CategoryController::class, 'showListServices'])->name('category.showListServices');

// ==================== SERVICE ROUTES ====================
Route::resource('/dashboard/services', ServiceController::class);

// ==================== DOCTOR ROUTES ====================
Route::get('/dashboard/dokter', [DoctorController::class, 'index'])->name('dokter');

// ==================== ARTICLE ROUTES ====================
Route::get('/dashboard/artikel', [ArticleController::class, 'index'])->name('artikel');
Route::get('/dashboard/artikel/{id}', [ArticleController::class, 'show'])->name('artikel.show');

// ==================== OTHER ROUTES ====================
Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/dashboard/booking', [AppointmentController::class, 'index'])->name('booking');
Route::get('/dashboard/chat', [MessageController::class, 'index'])->name('chat');
Route::get('/dashboard/transaksi', [TransactionController::class, 'index'])->name('transaksi');
