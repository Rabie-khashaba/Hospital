<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\DoctorController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Laboratorie_employeeController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PatientController;
use App\Http\Controllers\Auth\RayEmployeeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    //---------user
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.user');

    //---------admin
    Route::post('login/admin', [AdminController::class, 'store'])->name('login.admin');

    //Doctor
    Route::post('login/doctor', [DoctorController::class, 'store'])->name('login.doctor');

    //Patient
    Route::post('login/patient', [PatientController::class, 'store'])->name('login.patient');

    //laboratorie_employees
    Route::post('login/laboratorie_employee', [Laboratorie_employeeController::class, 'store'])->name('login.laboratorie_employee');

    //ray_employee
    Route::post('login/ray_employee', [RayEmployeeController::class, 'store'])->name('login.ray_employee');






    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');


    //logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout.user');
});


//admin
Route::middleware('auth:admin')->group(function () {
    //logout
    Route::post('logout/admin', [AdminController::class, 'destroy'])->name('logout.admin');


});

// doctor
Route::middleware('auth:doctor')->group(function () {
    //logout
    Route::post('logout/doctor', [DoctorController::class, 'destroy'])->name('logout.doctor');


});

//patients
Route::middleware('auth:patient')->group(function () {
    //logout
    Route::post('logout/patient', [PatientController::class, 'destroy'])->name('logout.patient');

});
//laboratorie_employee
Route::middleware('auth:laboratorie_employee')->group(function () {
    //logout
    Route::post('logout/laboratorie_employee', [Laboratorie_employeeController::class, 'destroy'])->name('logout.laboratorie_employee');

});

//ray_employee
Route::middleware('auth:ray_employee')->group(function () {
    //logout
    Route::post('logout/ray_employee', [Laboratorie_employeeController::class, 'destroy'])->name('logout.ray_employee');

});




