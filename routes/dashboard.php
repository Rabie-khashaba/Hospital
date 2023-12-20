<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
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

Route::get('/Dashboard_Admin', [DashboardController::class , 'index'] )->middleware(['auth', 'verified'])->name('dashboard');





Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::get('/dashboard/user', function (){
        return view('Dashboard.user.dashboard');
    })->middleware(['auth'])->name('dashboard.user');


    Route::get('/dashboard/admin', function (){
        return view('Dashboard.admin.dashboard');
    })->middleware(['auth:admin'])->name('dashboard.admin');


    require __DIR__.'/auth.php';

});

