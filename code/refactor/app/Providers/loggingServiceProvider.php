<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CustomLog;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\CustomLog', function ($app) {
            return new CustomLog();
        });
    }
}
