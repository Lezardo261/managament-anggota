<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\TaskSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\Admin\LeaveRequestAdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware(['auth', 'checkrole'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/export-user-stats', [DashboardController::class, 'exportUserStats'])->name('admin.exportUserStats');
            Route::get('/users/{encryptedId}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/users/{encryptedId}', [UserController::class, 'update'])->name('admin.users.update');
            Route::put('/{user}/updateRole', [UserController::class, 'updateRole'])->name('admin.user.updateRole');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            // Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
            Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
            Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
            Route::get('/attendances', [AdminAttendanceController::class, 'index'])->name('admin.attendances.index');
            Route::get('/leave-requests', [LeaveRequestAdminController::class, 'index'])->name('admin.leave-requests.index');
            Route::post('/leave-requests/{id}/approve', [LeaveRequestAdminController::class, 'approve'])->name('admin.leave-requests.approve');
            Route::post('/leave-requests/{id}/reject', [LeaveRequestAdminController::class, 'reject'])->name('admin.leave-requests.reject');
            Route::get('/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
            Route::get('/tasks/{task}/submissions', [TaskController::class, 'getSubmissions'])->name('admin.tasks.getSubmissions');
            Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
            Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
            Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');


            Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('admin.user.dashboard');
        });
        
        
        Route::prefix('user')->group(function() {
            Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.user.index');
            Route::post('/attendance', [AttendController::class, 'store'])->name('attendances.store');
            Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
            Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
            Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
            Route::delete('/leave-requests/{id}', [LeaveRequestController::class, 'destroy'])->name('leave-requests.destroy'); 
            Route::post('/tasks/submit', [TaskSubmissionController::class, 'store'])->name('tasks.submit');
            Route::post('/logout', [LeaveRequestController::class, 'destroy'])->name('user.logout');
        });
});
require __DIR__.'/auth.php';