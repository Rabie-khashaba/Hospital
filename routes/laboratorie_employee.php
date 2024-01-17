<?php

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

        Route::prefix('laboratorie_employee')->group(function () {

            //الكشوفات



        });
    });


    require __DIR__.'/auth.php';

});

