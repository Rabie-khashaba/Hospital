<?php

use App\Http\Controllers\Dashboard\AmbulanceController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\InsuranceController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\PaymentAccountController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Http\Controllers\Doctor_dashboard\DiagnosticController;
use App\Http\Controllers\Doctor_dashboard\InvoiceController;
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
    Route::get('/dashboard/doctor', function (){
        return view('Dashboard.Dashboard_doctor.dashboard');
    })->middleware(['auth:doctor'])->name('dashboard.doctor');



    // -------------------------------------------------------------
    Route::middleware(['auth:doctor'])->group(function (){

        Route::prefix('doctor')->group(function () {

            //الكشوفات
            Route::resource('invoices', InvoiceController::class);

            //Diagnostic
            Route::resource('Diagnostics', DiagnosticController::class);




        });
    });


    require __DIR__.'/auth.php';

});

