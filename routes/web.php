<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard/artikel', [ArticleController::class, 'index'])->name('artikel');

Route::get('/dashboard/dokter', [DoctorController::class, 'index'])->name('dokter');

Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');

Route::get('/dashboard/booking', [AppointmentController::class, 'index'])->name('booking');

Route::get('/dashboard/chat', [MessageController::class, 'index'])->name('chat');

Route::get('/dashboard/transaksi', [TransactionController::class, 'index'])->name('transaksi');
