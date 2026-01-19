<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/


// Routes خاصة بالمسؤول (Admin) محمية بميدلوير auth.admin
Route::middleware(['web','auth.admin'])->group(function () {

    // لوحة التحكم للمسؤول
    Route::get('/dashboard', [DashboardController::class, 'GetDashboard'])->name('dashboard');

    Route::get('/users', [UserController::class, 'Index'])->name('get.users');

    // حذف مستخدم
    Route::delete('/delete-user/{id}', [UserController::class, 'DeleteUser'])->name('user.delete');

    // تعديل مستخدم
    Route::post('/update-user/{id}', [UserController::class, 'UpdateUser'])->name('user.update');

    Route::get('/update-user/{id}', [UserController::class, 'GetUserUpdate'])->name('get.user.update');

    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

    Route::get('/attendance', [AttendanceController::class, 'GetAttendance'])->name('get.attendance');

    Route::post('/attendance', [AttendanceController::class, 'AddAttendance'])->name('post.attendance');

    Route::get('/edit-Admins', [AdminController::class, 'GetAllAdmins'])->name('get.admin.edit');

    //Route::post('/edit-Admins', [AdminController::class, 'GetEditAdmins'])->name('get.admin.edit');
});

// Routes تسجيل الدخول للمسؤول
Route::get('/login', [AdminController::class, 'GetLogin'])->name('login');
Route::get('/', [AdminController::class, 'GetLogin'])->name('login');
Route::post('/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
