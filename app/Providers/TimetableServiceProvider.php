<?php

namespace App\Providers;

use App\Services\TimetableService;
use Illuminate\Support\ServiceProvider;

class TimetableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\TimetableService', function ($app) {
            return new TimetableService();
        });
    }
}
