<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\PDF\PDF as CustomPDF;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Services\Contracts\ImageUploaderInterface;
use App\Services\Contracts\StudentCreatorServiceInterface;
use App\Services\ImgBbUploaderService;
use App\Services\StudentCreatorService;

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
