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
        $this->app->bind(TimetableService::class, function ($app) {
            return new TimetableService();
        });
    }
}
