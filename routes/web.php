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
Route::post('/dashboard/categories/showInfo', [CategoryController::class, 'showInfo'])->name('categories.showInfo');
Route::post('/dashboard/categories/showListServices', [CategoryController::class, 'showListServices'])->name('categories.showListServices');

// ==================== SERVICE ROUTES ====================
Route::resource('/dashboard/services', ServiceController::class);

// ==================== DOCTOR ROUTES ====================
Route::get('/dashboard/doctor', [DoctorController::class, 'index'])->name('doctor');

// ==================== ARTICLE ROUTES ====================
Route::get('/dashboard/article', [ArticleController::class, 'index'])->name('article');
Route::get('/dashboard/article/{id}', [ArticleController::class, 'show'])->name('article.show');

// ==================== TRANSACTION ROUTES ====================
Route::resource('/dashboard/transaction', TransactionController::class);
Route::get('/dashboard/transaction', [TransactionController::class, 'index'])->name('transaction'); 

// ==================== OTHER ROUTES ====================
Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/dashboard/booking', [AppointmentController::class, 'index'])->name('booking');
Route::get('/dashboard/chat', [MessageController::class, 'index'])->name('chat');

