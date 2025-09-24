<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\PDF\PDF as CustomPDF;
use App\Services\Contracts\ImageBbUploaderInterface;
use App\Services\ImgBbUploaderService;

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
            ImageBbUploaderInterface::class,
            ImgBbUploaderService::class
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
