<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PushNotification\PushNotificationInterface;

class PushNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\PushNotification\PushNotificationInterface', '\App\Services\PushNotification\OneSignalPushNotification');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(PushNotificationInterface $pushNotification)
    {
        //
    }
}
