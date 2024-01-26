<?php


use App\Http\Controllers\LaboratorieEmployee_dashboard\InvoiceController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| doctor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    // dashboard Doctor----------
    Route::get('/dashboard/laboratorie_employee', function (){
        return view('Dashboard.Dashboard_laboratorie_employee.dashboard');
    })->middleware(['auth:laboratorie_employee'])->name('dashboard.laboratorie_employee');



    // -------------------------------------------------------------
    Route::middleware(['auth:laboratorie_employee'])->group(function (){

            Route::resource('invoices_laboratorie_employee',InvoiceController::class );
            Route::get('completed_invoice', [InvoiceController::class,'completed_invoices'])->name('completed_invoice');
            Route::get('view_laboratorie/{id}',[InvoiceController::class,'view_laboratories'])->name('view_laboratorie');

    });


    require __DIR__.'/auth.php';

});

