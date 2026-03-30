<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/dashboard/artikel', function () {
    return view('artikel');
})->name('artikel');

Route::get('/dashboard/my-artikel', function () {
    return view('my_artikel');
})->name('my.artikel');

Route::get('/dashboard/tambah-artikel', function () {
    return view('tambah_artikel');
})->name('tambah.artikel');

Route::get('/dashboard/dokter', function () {
    return view('dokter');
})->name('dokter');

Route::get('/dashboard/member', function () {
    return view('member');
})->name('member');

Route::get('/dashboard/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/dashboard/booking', function () {
    return view('booking');
})->name('booking');

Route::get('/dashboard/konsultasi', function () {
    return view('konsultasi');
})->name('konsultasi');

Route::get('/dashboard/edit-laporan', function () {
    return view('edit_laporan');
})->name('edit.laporan');

Route::get('/dashboard/laporan', function () {
    return view('laporan');
})->name('laporan');

Route::get('/dashboard/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/dashboard/profile', function () {
    return view('profile');
})->name('profile');
