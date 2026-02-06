<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\ServiceCategoryController;
use Modules\Service\Http\Controllers\ServiceController;
use Modules\Service\Http\Controllers\BafController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('service', ServiceController::class);
    Route::get('programs/status/{id}', [ServiceController::class,'status'])->name('programs.status');
    Route::get('programs-category/status/{id}', [ServiceCategoryController::class,'status'])->name('programs_category.status');
    Route::resource('servicecategory', ServiceCategoryController::class);
    // Route::post('baf/update/{id]', [BafController::class,'update'])->name('baf.update');
    Route::put('baf/update/{id}', [BafController::class, 'update'])->name('baf.update');
    Route::post('baf/store', [BafController::class,'store'])->name('baf.store');

    Route::get('baf', [BafController::class,'index'])->name('baf.index');

});

