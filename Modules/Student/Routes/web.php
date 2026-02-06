<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\StudentController;
use Modules\Student\Http\Controllers\FeeTypeController;
use Modules\Student\Http\Controllers\FeeStructureController;
use Modules\Student\Http\Controllers\StudentFeeController;
use Modules\Student\Http\Controllers\PaymentController;
use Modules\Student\Http\Controllers\InvoiceController;
use Modules\Student\Http\Controllers\ExpenseTypeController;
use Modules\Student\Http\Controllers\ExpenseController;
use Modules\Student\Http\Controllers\ClassController;
use Modules\Student\Http\Controllers\BalanceSheetController;
use Modules\Student\Http\Controllers\FinanceSummaryController;



// use Modules\Student\Http\Controllers\PaymentItemController;

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | STUDENT MAIN ROUTES
    |--------------------------------------------------------------------------
    */
   Route::resource('student', StudentController::class); 
   Route::get('student2',[StudentController::class,'index2'])->name('student.index2'); 
   Route::patch('student/status/{id}', [StudentController::class, 'status'])->name('student.status');
    /*
    |--------------------------------------------------------------------------
    | STUDENT MODULE ROUTES (PREFIXED)
    |--------------------------------------------------------------------------
    */
    // Route::prefix('student')->name('student.')->group(function () {

        // ================= Fee Management =================
        Route::resource('fee-types', FeeTypeController::class)->except(['show']);
        Route::resource('fee-structures', FeeStructureController::class)->except(['show']);
        Route::resource('classes', ClassController::class)->except(['show']);
        

        // ================= Individual Student Fees =================
        Route::get('fees/{student_id}', [StudentFeeController::class, 'index'])->name('fees.index');
        Route::get('fees/{student_id}/create', [StudentFeeController::class, 'create'])->name('fees.create');
        Route::post('fees/store', [StudentFeeController::class, 'store'])->name('fees.store');

      // payments listing
Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

// global create (select student from dropdown)
Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');

// create for specific student (prefilled fees)
Route::get('payments/{student_id}/create', [PaymentController::class, 'createForStudent'])->name('payments.createForStudent');

// // store
// Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');

// // show
// Route::get('payments/{id}', [PaymentController::class, 'show'])->name('payments.show');

        // ================= Invoices =================

        // ================= Expenses =================
        Route::resource('expense-types', ExpenseTypeController::class)->except(['show']);
        Route::resource('expenses', ExpenseController::class)->except(['show']);
        Route::get('/expenses/create/current/{student_id}', [ExpenseController::class, 'createForCurrentStudent'])
    ->name('expenses.create.current');

    });
// });



// Payment routes
Route::get('payments/use-advance-only/{student_id}', [PaymentController::class, 'useAdvanceOnly'])->name('payments.use.advance.only');
Route::get('payments/{payment}/receipt', [InvoiceController::class, 'generateReceipt'])->name('payments.receipt');
Route::resource('payments', PaymentController::class);

// Invoice routes
Route::get('invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::get('invoices/{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');
Route::resource('invoices', InvoiceController::class);
Route::get('/payments/get-student-details', [PaymentController::class, 'getStudentDetails'])->name('payments.get.student.details');
// Global Payment Routes
Route::get('/payments/global', [PaymentController::class, 'createGlobal'])->name('payments.global.create');
Route::get('/payments/global/show-form', [PaymentController::class, 'showStudentPaymentForm'])->name('payments.global.show-form');
Route::get('/payments/global/use-advance-only/{student_id}', [PaymentController::class, 'useAdvanceOnlyGlobal'])->name('payments.global.use.advance.only');

Route::prefix('balancesheet')->group(function () {
    Route::get('/', [BalanceSheetController::class, 'index'])->name('balancesheet.index');
    Route::post('/deposit', [BalanceSheetController::class, 'storeDeposit'])->name('balancesheet.storeDeposit');
});

Route::prefix('finance')->group(function () {
    Route::get('/summary', [FinanceSummaryController::class, 'index'])->name('finance.summary');
});
