<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\PDF\PDF as CustomPDF;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\SalaryRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\SalaryRepository;
use App\Repositories\StudentRepository;
use App\Services\Contracts\EmployeeCreatorServiceInterface;
use App\Services\Contracts\EmployeeUpdaterServiceInterface;
use App\Services\Contracts\ImageUploaderInterface;
use App\Services\Contracts\SalaryUpdaterServiceInterface;
use App\Services\Contracts\StudentCreatorServiceInterface;
use App\Services\Contracts\StudentUpdaterServiceInterface;
use App\Services\EmployeeCreatorService;
use App\Services\EmployeeUpdaterService;
use App\Services\ImgBbUploaderService;
use App\Services\SalaryUpdaterService;
use App\Services\StudentCreatorService;
use App\Services\StudentUpdaterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // PDF service
        $this->app->singleton('pdf.custom', function () {
            return new CustomPDF();
        });

        // Image upload service
        $this->app->bind(
            ImageUploaderInterface::class,
            ImgBbUploaderService::class
        );
        // student respository
        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );

        //student service creator
        $this->app->bind(
            StudentCreatorServiceInterface::class,
            StudentCreatorService::class
        );

        //student service updater
        $this->app->bind(
            StudentUpdaterServiceInterface::class,
            StudentUpdaterService::class
        );

        //employee repository
        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        //employee service creator
        $this->app->bind(
            EmployeeCreatorServiceInterface::class,
            EmployeeCreatorService::class
        );

        //employee service updater
        $this->app->bind(
            EmployeeUpdaterServiceInterface::class,
            EmployeeUpdaterService::class
        );

        $this->app->bind(
            SalaryRepositoryInterface::class,
            SalaryRepository::class
        );

        $this->app->bind(
            SalaryUpdaterServiceInterface::class,
            SalaryUpdaterService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
