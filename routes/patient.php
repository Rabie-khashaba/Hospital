<?php


use App\Http\Controllers\Dashboard_patient\PatientCaontroller;
use App\Http\Controllers\RayEmployee_dashboard\InvoiceRayController;
use App\Livewire\Chat\CreateChat;
use App\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| patient Routes
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



    Route::get('/dashboard/patient', function (){
        return view('Dashboard.Dashboard_patient.dashboard');
    })->middleware(['auth:patient'])->name('dashboard.patient');


    // -------------------------------------------------------------
    Route::middleware(['auth:patient'])->group(function (){

        Route::get('invoices' , [PatientCaontroller::class , 'invoices'])->name('invoices.patient');

        Route::get('laboratories' , [PatientCaontroller::class , 'Laboratorie'])->name('laboratories.patient');
        Route::get('laboratorie_view/{id}' , [PatientCaontroller::class , 'LaboratorieView'])->name('laboratorie_view');

        Route::get('rays' , [PatientCaontroller::class , 'ray'])->name('rays.patient');
        Route::get('rays_view/{id}' , [PatientCaontroller::class , 'raysView'])->name('rays_view');

        Route::get('payments', [PatientCaontroller::class,'payments'])->name('payments.patient');


        //chat
        Route::get('list/doctors',Createchat::class)->name('list.doctors');
        Route::get('chat/doctors',Main::class)->name('chat.doctors');



    });


    require __DIR__.'/auth.php';

});

