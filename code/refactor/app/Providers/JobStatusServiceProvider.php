<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JobStatus;

class JobStatusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\JobStatus', function ($app) {
            return new JobStatus();
        });
    }
}
