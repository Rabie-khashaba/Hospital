<?php

namespace App\Providers;

use App\Interfaces\Ambulance\AmbulanceRepositoryInterface;
use App\Interfaces\Doctor\DoctorRepositoryInterface;
use App\Interfaces\Insurances\insuranceRepositoryInterface;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Repository\Ambulance\AmbulanceRepository;
use App\Repository\Doctor\DoctorRepository;
use App\Repository\Insurances\insuranceRepository;
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
        $this->app->bind(SectionRepositoryInterface::class , SectionRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class , DoctorRepository::class);
        $this->app->bind(SingleServiceRepositoryInterface::class , SingleServiceRepository::class);
        $this->app->bind(insuranceRepositoryInterface::class , insuranceRepository::class);
        $this->app->bind(AmbulanceRepositoryInterface::class , AmbulanceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
