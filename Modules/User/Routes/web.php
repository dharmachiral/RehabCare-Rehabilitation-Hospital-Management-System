<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\ProfileController;
use Modules\User\Http\Controllers\UsersController;
// use Modules\User\Http\Controllers\StudentPasswordController;
use Modules\User\Http\Controllers\RolesController;

Route::group(['middleware' => 'auth'], function () {

    // Profile Routes (for all users)
    Route::prefix('user')->group(function () {
        // Common profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');

        // Student-specific profile
        Route::get('/student-profile', [ProfileController::class, 'studentProfile'])
            ->name('profile.student')
            ->middleware('student.role'); // Custom middleware to check role_id=7
    });

    // User Management
    Route::resource('users', UsersController::class)->except('show');
    Route::get('user/status/{id}', [UsersController::class, 'status'])->name('user.status');

    // Role Management
    Route::resource('roles', RolesController::class)->except('show');

    // Student Password Reset (simplified)
    // Route::prefix('student')->group(function () {
    //     Route::get('/reset-password', [StudentPasswordController::class, 'showResetForm'])
    //         ->name('student.password.reset');

    //     Route::post('/reset-password', [StudentPasswordController::class, 'reset'])
    //         ->name('student.password.update');
    // });
});
