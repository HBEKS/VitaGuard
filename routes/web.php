<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MemberController;

Auth::routes();
Route::middleware(['auth', 'nocache'])->group(function () {

    #region FINAL ROUTE
    //JUJUR PUYENK
    #region semua user bisa akses

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/dashboard', function () {
        return redirect()->route('login');
    });



    //profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/ajax/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/ajax/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    #region admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::post('/dashboard/article', [ArticleController::class, 'store'])->name('article.store');
        Route::post('/ajax/articles/getEditFormB', [ArticleController::class, 'getEditFormB'])->name('articles.getEditFormB');
        Route::post('/ajax/articles/saveDataUpdate', [ArticleController::class, 'saveDataUpdate'])->name('articles.saveDataUpdate');
        Route::post('/ajax/articles/deleteData', [ArticleController::class, 'deleteData'])->name('articles.deleteData');

        Route::resource('/members', MemberController::class);
        Route::post('/ajax/members/getEditFormB', [MemberController::class, 'getEditFormB'])->name('members.getEditFormB');
        Route::post('/ajax/members/saveDataUpdate', [MemberController::class, 'saveDataUpdate'])->name('members.saveDataUpdate');
        Route::post('/ajax/members/deleteData', [MemberController::class, 'deleteData'])->name('members.deleteData');
        //CRUD DOCTOR
        Route::post('/ajax/doctor/getEditFormB', [DoctorController::class, 'getEditFormB'])->name('doctor.getEditFormB');
        Route::post('/ajax/doctor/saveDataUpdate', [DoctorController::class, 'saveDataUpdate'])->name('doctor.saveDataUpdate');
        Route::post('/ajax/doctor/deleteData', [DoctorController::class, 'deleteData'])->name('doctor.deleteData');

        Route::post('/ajax/services/getEditFormB', [ServiceController::class, 'getEditFormB'])->name('services.getEditFormB');
        Route::post('/ajax/services/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])->name('services.saveDataUpdate');
        Route::post('/ajax/services/deleteData', [ServiceController::class, 'deleteData'])->name('services.deleteData');

        Route::post('/listDoctor', [DoctorController::class, 'store'])
            ->name('listDoctor.store');

        Route::put('/listDoctor/{doctor}', [DoctorController::class, 'update'])
            ->name('listDoctor.update');

        Route::delete('/listDoctor/{doctor}', [DoctorController::class, 'destroy'])
            ->name('listDoctor.destroy');
    });
    #endregion

    #region doctor only
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor', [DoctorController::class, 'dashboard'])
            ->name('doctor.dashboard');

        Route::put(
            '/appointment/{appointment}/status',
            [AppointmentController::class, 'updateStatus']
        )->name('appointment.updateStatus');

        Route::post(
            'ajax/appointment/saveNotes',
            [AppointmentController::class, 'saveNotes']
        )->name('appointment.saveNotes');



        Route::post('/ajax/doctor/getEditFormB', [DoctorController::class, 'getEditFormB'])->name('doctor.getEditFormB');
        Route::post('/ajax/doctor/saveDataUpdate', [DoctorController::class, 'saveDataUpdate'])->name('doctor.saveDataUpdate');
        Route::post('/ajax/doctor/deleteData', [DoctorController::class, 'deleteData'])->name('doctor.deleteData');
    });
    #endregion

    #region member only
    Route::middleware(['role:member'])->group(function () {
        Route::get('/member', [MemberController::class, 'dashboard'])
            ->name('member.dashboard');
        Route::get('/booking', [AppointmentController::class, 'create'])->name('booking.index');
    });
    #endregion

    #region admin + doctor only
    Route::middleware(['role:doctor,admin'])->group(function () {
        Route::get('booking/index', [AppointmentController::class, 'index'])->name('doctorBooking');
    });

    #endregion

    #region doctor + member only
    Route::middleware(['role:doctor,member'])->group(function () {
        //chat
        Route::get('/chat/{appointment}', [MessageController::class, 'index'])->name('chat.show');
        Route::post('/chat/send', [MessageController::class, 'store'])->name('chat.send');
        Route::post('/ajax/appointment/getEditFormB', [AppointmentController::class, 'getEditFormB'])->name('appointment.getEditFormB');
        Route::post('/ajax/appointment/saveDataUpdate', [AppointmentController::class, 'saveDataUpdate'])->name('appointment.saveDataUpdate');
        Route::post('/ajax/appointment/deleteData', [AppointmentController::class, 'deleteData'])->name('appointment.deleteData');
        Route::post('/ajax/appointment/updateStatus', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');
    });

    #endregion

    #region admin + member only
    Route::middleware(['role:admin,member'])->group(function () {
        Route::get('/categories/showExpensiveService', [CategoryController::class, 'showExpensiveService'])->name('categories.expensive');
        Route::post('/categories/showInfo', [CategoryController::class, 'showInfo'])->name('categories.showInfo');
        Route::post('/categories/showListServices', [CategoryController::class, 'showListServices'])->name('categories.showListServices');

        Route::post('/ajax/categories/getEditFormB', [CategoryController::class, 'getEditFormB'])->name('categories.getEditFormB');
        Route::post('/ajax/categories/saveDataUpdate', [CategoryController::class, 'saveDataUpdate'])->name('categories.saveDataUpdate');
        Route::post('/ajax/categories/deleteData', [CategoryController::class, 'deleteData'])->name('categories.deleteData');

        //articles
        Route::get('/dashboard/article', [ArticleController::class, 'index'])->name('article');
        Route::get('/dashboard/article/{id}', [ArticleController::class, 'show'])->name('article.show');

        //akses list of categories
        Route::resource('/categories', CategoryController::class);

        //akses list of services
        Route::resource('/services', ServiceController::class);

        //akses list of doctor
        Route::get('/listDoctor', [DoctorController::class, 'index'])->name('listDoctor');
    });
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');




    // // ==================== TRANSACTION ROUTES ====================
    // Route::resource('/dashboard/transaction', TransactionController::class);
    // Route::get('/dashboard/transaction', [TransactionController::class, 'index'])->name('transaction');

    // // ==================== OTHER ROUTES ====================
    // Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
    // Route::get('/dashboard/chat', [MessageController::class, 'index'])->name('chat');
