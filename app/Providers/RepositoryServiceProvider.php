<?php

namespace App\Providers;

use App\Interfaces\Ambulance\AmbulanceRepositoryInterface;
use App\Interfaces\Doctor\DoctorRepositoryInterface;
use App\Interfaces\Doctor_dashboard\DiagnosisRepositoryInterface;
use App\Interfaces\Doctor_dashboard\InvoicesRepositoryInterface;
use App\Interfaces\Doctor_dashboard\RaysRepositoryInterface;
use App\Interfaces\Finance\PaymentRepositoryInterface;
use App\Interfaces\Finance\ReceiptRepositoryInterface;
use App\Interfaces\Insurances\insuranceRepositoryInterface;
use App\Interfaces\Patients\PatientRepositoryInterface;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Repository\Ambulance\AmbulanceRepository;
use App\Repository\Doctor\DoctorRepository;
use App\Repository\Doctor_dashboard\DiagnosisRepository;
use App\Repository\Doctor_dashboard\InvoicesRepository;
use App\Repository\Doctor_dashboard\RaysRepository;
use App\Repository\Finance\PaymentRepository;
use App\Repository\Finance\ReceiptRepository;
use App\Repository\Insurances\insuranceRepository;
use App\Repository\Patients\PatientRepository;
use App\Repository\Sections\SectionRepository;
use App\Repository\Services\SingleServiceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        //admin
        $this->app->bind(SectionRepositoryInterface::class , SectionRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class , DoctorRepository::class);
        $this->app->bind(SingleServiceRepositoryInterface::class , SingleServiceRepository::class);
        $this->app->bind(insuranceRepositoryInterface::class , insuranceRepository::class);
        $this->app->bind(AmbulanceRepositoryInterface::class , AmbulanceRepository::class);
        $this->app->bind(PatientRepositoryInterface::class , PatientRepository::class);
        $this->app->bind(ReceiptRepositoryInterface::class , ReceiptRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class , PaymentRepository::class);


        //doctor
        $this->app->bind(InvoicesRepositoryInterface::class , InvoicesRepository::class);
        $this->app->bind(DiagnosisRepositoryInterface::class , DiagnosisRepository::class);
        $this->app->bind(RaysRepositoryInterface::class , RaysRepository::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
