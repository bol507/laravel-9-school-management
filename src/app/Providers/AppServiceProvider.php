<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\PDF\PDF as CustomPDF;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pdf.custom', function () {
        return new CustomPDF();
    });
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
