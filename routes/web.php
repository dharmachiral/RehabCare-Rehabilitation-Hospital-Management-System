<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AppoitmentController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Frontend Public Routes
|--------------------------------------------------------------------------
*/
Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('frontend.index');
    Route::get('/about', 'about')->name('frontend.about');
    Route::get('/program', 'service')->name('frontend.program');
    Route::get('/servicefront', 'service')->name('frontend.servicefront');

    Route::get('/service-details/{id}', 'serviceDetails')
        ->name('frontend.service_details');

    Route::get('/treatment-details/{id}', 'treatmentDetails')
        ->name('frontend.treatment_details');

    Route::get('/team', 'team')->name('frontend.team');
    Route::get('/team-details/{slug}', 'teamDetails')
        ->name('frontend.team_details');

    Route::get('/frontend_gallery', 'gallery')
        ->name('frontend.gallery');

    Route::get('/testimonial', 'testimonial')
        ->name('frontend.testimonial');

    Route::get('/blog', 'blog')->name('frontend.blog');
    Route::get('/blog-details/{slug}', 'blogDetails')
        ->name('frontend.blog_details');

    Route::get('/appointment', 'appointment')
        ->name('frontend.appointment');

    Route::get('/contact', 'contact')->name('frontend.contact');
    Route::get('/faq', 'faq')->name('frontend.faq');
});

/*
|--------------------------------------------------------------------------
| Appointment Routes
|--------------------------------------------------------------------------
*/
Route::prefix('appointment')->name('appointment.')->group(function () {
    Route::get('/', [AppoitmentController::class, 'index'])
        ->name('index');

    Route::post('/store', [AppoitmentController::class, 'store'])
        ->name('store');

    Route::delete('/{id}', [AppoitmentController::class, 'destroy'])
        ->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Inquiry / Contact Routes
|--------------------------------------------------------------------------
*/
Route::resource('inquiries', InquiryController::class)
    ->only(['index', 'store']);
