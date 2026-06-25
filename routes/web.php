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

//Authentication routes
Auth::routes();
Route::middleware(['auth'])->group(function () {
    // all user can access
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/dashboard', function () {
        return redirect()->route('login');
    });

    //only admin can access
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    //only doctor can access
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor', function () {
            return view('doctor.dashboard');
        })->name('doctor.dashboard');
    });

    //only member can access
    Route::middleware(['role:member'])->group(function () {
        Route::get('/member', function () {
            return view('member.dashboard');
        })->name('member.dashboard');
    });

    // ==================== CATEGORY ROUTES ====================
    Route::resource('/dashboard/categories', CategoryController::class);
    Route::get('/categories/showExpensiveService', [CategoryController::class, 'showExpensiveService'])->name('categories.expensive');
    Route::post('/categories/showInfo', [CategoryController::class, 'showInfo'])->name('categories.showInfo');
    Route::post('/categories/showListServices', [CategoryController::class, 'showListServices'])->name('categories.showListServices');

    // ==================== SERVICE ROUTES ====================
    Route::resource('/dashboard/services', ServiceController::class);

    // ==================== DOCTOR ROUTES ====================
    Route::get('/dashboard/doctor', [DoctorController::class, 'index'])->name('doctor');
    Route::post('/ajax/doctor/getEditFormB', [DoctorController::class, 'getEditFormB'])->name('doctor.getEditFormB');
    Route::post('/ajax/doctor/saveDataUpdate', [DoctorController::class, 'saveDataUpdate'])->name('doctor.saveDataUpdate');
    Route::post('/ajax/doctor/deleteData', [DoctorController::class, 'deleteData'])->name('doctor.deleteData');

    // ==================== ARTICLE ROUTES ====================
    Route::get('/dashboard/article', [ArticleController::class, 'index'])->name('article');
    Route::get('/dashboard/article/{id}', [ArticleController::class, 'show'])->name('article.show');

    // ==================== TRANSACTION ROUTES ====================
    Route::resource('/dashboard/transaction', TransactionController::class);
    Route::get('/dashboard/transaction', [TransactionController::class, 'index'])->name('transaction');

    // ==================== OTHER ROUTES ====================
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/dashboard/chat', [MessageController::class, 'index'])->name('chat');

    // ==================== APPOINTMENT ROUTES ====================
    Route::get('/dashboard/booking', [AppointmentController::class, 'index'])->name('booking');
    Route::post('/ajax/appointment/getEditFormB', [AppointmentController::class, 'getEditFormB'])->name('appointment.getEditFormB');
    Route::post('/ajax/appointment/saveDataUpdate', [AppointmentController::class, 'saveDataUpdate'])->name('appointment.saveDataUpdate');
    Route::post('/ajax/appointment/deleteData', [AppointmentController::class, 'deleteData'])->name('appointment.deleteData');


});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==================== REGISTER ROUTES ====================
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// admin access only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/dashboard/categories', CategoryController::class);
    Route::resource('/dashboard/services', ServiceController::class);
});
// doctor access only
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard/doctor', [DoctorController::class, 'index'])->name('doctor');
});
// member access only
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/dashboard/booking', [AppointmentController::class, 'index'])->name('booking');
});

