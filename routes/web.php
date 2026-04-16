<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
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

    Route::get('/dashboard/charts/registrations', [DashboardController::class, 'ChartRegistrations'])
        ->name('dashboard.charts.registrations');
    Route::get('/dashboard/charts/attendance', [DashboardController::class, 'ChartAttendance'])
        ->name('dashboard.charts.attendance');
    Route::get('/dashboard/charts/attendance-status-today', [DashboardController::class, 'ChartAttendanceStatusToday'])
        ->name('dashboard.charts.attendance_status_today');

    // Users (CRUD)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/manage', [UserController::class, 'manage'])->name('users.manage');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

    Route::get('/attendance', [AttendanceController::class, 'GetAttendance'])->name('get.attendance');

    Route::post('/attendance', [AttendanceController::class, 'AddAttendance'])->name('post.attendance');

    // Admins (CRUD)
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/manage', [AdminController::class, 'manage'])->name('admins.manage');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

    // Activity logs & reports
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    // Backward-compatible alias for old sidebar links (deprecated)
    Route::get('/edit-Admins', fn () => redirect()->route('admins.manage'))->name('get.admin.edit');
});

// Routes تسجيل الدخول للمسؤول
Route::get('/login', [AdminController::class, 'GetLogin'])->name('login');
Route::get('/', [AdminController::class, 'GetLogin'])->name('login');
Route::post('/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
