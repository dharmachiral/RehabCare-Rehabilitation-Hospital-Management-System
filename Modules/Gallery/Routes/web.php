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

// use Modules\Gallery\Entities\GalleryCategory;
use Modules\Gallery\Http\Controllers\GalleryController;
use Modules\Gallery\Http\Controllers\GalleryCategoryController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('galleries', GalleryController::class);
    Route::resource('galleriescategory', GalleryCategoryController::class);
    Route::get('galleries-category/status/{id}',[GalleryCategoryController::class,'status'])->name('galleries-category.status');
    Route::get('galleries/status/{id}',[GalleryController::class,'status'])->name('galleries.status');
    Route::get('/galleries-category-data/{id}', [GalleryController::class, 'showCategoryGalleries'])->name('galleries-category.view');

});
