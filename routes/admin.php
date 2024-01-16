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
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/Dashboard_Admin', [DashboardController::class , 'index'] );



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    // dashboard user-----------
    Route::get('/dashboard/user', function (){
        return view('Dashboard.user.dashboard');
    })->middleware(['auth'])->name('dashboard.user');

    // dashboard Admin----------
    Route::get('/dashboard/admin', function (){
        return view('Dashboard.admin.dashboard');
    })->middleware(['auth:admin'])->name('dashboard.admin');

    // dashboard Doctor----------
    Route::get('/dashboard/doctor', function (){
        return view('Dashboard.Dashboard_doctor.dashboard');
    })->middleware(['auth:doctor'])->name('dashboard.doctor');

    // dashboard Patient----------
    Route::get('/dashboard/patient', function (){
        return view('Dashboard.Dashboard_patient.dashboard');
    })->middleware(['auth:patient'])->name('dashboard.patient');



    // -------------------------------------------------------------
    Route::middleware(['auth:admin'])->group(function (){

        //section---------
        Route::resource('sections', SectionController::class);

        //Doctor----------
        Route::resource('Doctors',   DoctorController::class);
        Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
        Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');

        //Services
        Route::resource('Service', SingleServiceController::class);

        //Insurance
        Route::resource('insurance', InsuranceController::class);

        //ambulances
        Route::resource('Ambulance', AmbulanceController::class);

        //Patients
        Route::resource('Patients', PatientController::class);

        //Receipt (سند قبض)
        Route::resource('Receipt', ReceiptAccountController::class);

        //Payment (سند صرف)
        Route::resource('Payment', PaymentAccountController::class);



        //Livewire

        //Group Services( Livewire)
        Route::view('Add_GroupServices','livewire.GroupServices.include_create')->name('Add_GroupServices');

        //SingleInvoice
        Route::view('SingleServiceInvoice','livewire.single_invoices.index')->name('SingleServiceInvoice');
        Route::view('Print_single_invoices','livewire.single_invoices.print')->name('Print_single_invoices');

        //Group Invoice
        Route::view('GroupServiceInvoice','livewire.Group_Invoices.index')->name('GroupServiceInvoice');
        Route::view('group_Print_single_invoices','livewire.Group_Invoices.print')->name('group_Print_single_invoices');


    });


    require __DIR__.'/auth.php';

});

