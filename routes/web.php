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
use App\Http\Controllers\MemberController;

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

    // ==================== CATEGORY ROUTES ====================
    Route::resource('/categories', CategoryController::class);
    Route::get('/categories/showExpensiveService',[CategoryController::class, 'showExpensiveService'])->name('categories.expensive');
    Route::post('/categories/showInfo',[CategoryController::class, 'showInfo'])->name('categories.showInfo');
    Route::post('/categories/showListServices',[CategoryController::class, 'showListServices'])->name('categories.showListServices');

    Route::post('/ajax/categories/getEditFormB', [CategoryController::class, 'getEditFormB'])->name('categories.getEditFormB');
    Route::post('/ajax/categories/saveDataUpdate', [CategoryController::class, 'saveDataUpdate'])->name('categories.saveDataUpdate');
    Route::post('/ajax/categories/deleteData', [CategoryController::class, 'deleteData'])->name('categories.deleteData');
    // ==================== SERVICE ROUTES ====================
    Route::resource('/services', ServiceController::class);

    Route::post('/ajax/services/getEditFormB', [ServiceController::class, 'getEditFormB'])->name('services.getEditFormB');
    Route::post('/ajax/services/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])->name('services.saveDataUpdate');
    Route::post('/ajax/services/deleteData', [ServiceController::class, 'deleteData'])->name('services.deleteData');

    // ==================== DOCTOR ROUTES ====================
    Route::resource('/listDoctor', DoctorController::class);
    Route::post('/ajax/doctor/getEditFormB', [DoctorController::class, 'getEditFormB'])->name('doctor.getEditFormB');
    Route::post('/ajax/doctor/saveDataUpdate', [DoctorController::class, 'saveDataUpdate'])->name('doctor.saveDataUpdate');
    Route::post('/ajax/doctor/deleteData', [DoctorController::class, 'deleteData'])->name('doctor.deleteData');
    //member
    Route::resource('/members', MemberController::class);
    Route::post('/ajax/members/getEditFormB', [MemberController::class, 'getEditFormB'])->name('members.getEditFormB');
    Route::post('/ajax/members/saveDataUpdate', [MemberController::class, 'saveDataUpdate'])->name('members.saveDataUpdate');
    Route::post('/ajax/members/deleteData', [MemberController::class, 'deleteData'])->name('members.deleteData');
    //profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    //profile edit 
    Route::post('/ajax/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/ajax/profile/update', [ProfileController::class, 'update'])->name('profile.update');

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

        Route::get('/chat/{appointment}', [MessageController::class, 'show'])
            ->name('chat.show');

        Route::put(
            '/appointment/{appointment}/status',
            [AppointmentController::class, 'updateStatus']
        )->name('appointment.updateStatus');

        Route::post(
            '/appointment/saveNotes',
            [AppointmentController::class, 'saveNotes']
        )->name('appointment.saveNotes');
    });

    //only member can access
    Route::middleware(['role:member'])->group(function () {
        Route::get('/member', function () {
            return view('member.dashboard');
        })->name('member.dashboard');
    });

    //doctor and admin can access
    Route::middleware(['role:doctor,admin'])->group(function () {
        // ==================== APPOINTMENT ROUTES ====================
        Route::get('booking/index', [AppointmentController::class, 'index'])->name('doctorBooking');
        Route::post('/ajax/appointment/getEditFormB', [AppointmentController::class, 'getEditFormB'])->name('appointment.getEditFormB');
        Route::post('/ajax/appointment/saveDataUpdate', [AppointmentController::class, 'saveDataUpdate'])->name('appointment.saveDataUpdate');
        Route::post('/ajax/appointment/deleteData', [AppointmentController::class, 'deleteData'])->name('appointment.deleteData');
    });




    // ==================== ARTICLE ROUTES ====================
    Route::get('/dashboard/article', [ArticleController::class, 'index'])->name('article');
    Route::get('/dashboard/article/{id}', [ArticleController::class, 'show'])->name('article.show');

    // ==================== TRANSACTION ROUTES ====================
    Route::resource('/dashboard/transaction', TransactionController::class);
    Route::get('/dashboard/transaction', [TransactionController::class, 'index'])->name('transaction');

    // ==================== OTHER ROUTES ====================
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/dashboard/chat', [MessageController::class, 'index'])->name('chat');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==================== REGISTER ROUTES ====================
Route::get('/register', function () {
    return view('auth.register');
})->name('register');


// // doctor access only
// Route::middleware(['auth', 'role:doctor'])->group(function () {
//     Route::get('/dashboard/doctor', [DoctorController::class, 'index'])->name('doctor');
// });
// // member access only
// Route::middleware(['auth', 'role:member'])->group(function () {
//     Route::get('/dashboard/booking', [AppointmentController::class, 'index'])->name('booking');
// });
