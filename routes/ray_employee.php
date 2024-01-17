<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| ray_employee Routes
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
    Route::get('/dashboard/ray_employee', function (){
        return view('Dashboard.Dashboard_ray_employee.dashboard');
    })->middleware(['auth:ray_employee'])->name('dashboard.ray_employee');



    // -------------------------------------------------------------
    Route::middleware(['auth:ray_employee'])->group(function (){

        Route::prefix('ray_employee')->group(function () {

            //الكشوفات



        });
    });


    require __DIR__.'/auth.php';

});

