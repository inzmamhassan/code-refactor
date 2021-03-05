<?php

namespace App\Providers;

use App\Events\ChangeDate;
use App\Events\ChangeTranslator;
use App\Listeners\SendChangeDateEmailToTranslator;
use App\Listeners\SendChangeDateEmailToUser;
use App\Listeners\SendChangeTranslatorEmailToCurrentTranslator;
use App\Listeners\SendChangeTranslatorEmailToNewTranslator;
use App\Listeners\SendChangeTranslatorEmailToUser;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\JobStored;
use App\Listeners\SendEmailToUserOnJobstore;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        JobStored::class => [
            SendEmailToUserOnJobstore::class,
        ],
        ChangeTranslator::class => [
            SendChangeTranslatorEmailToUser::class,
            SendChangeTranslatorEmailToNewTranslator::class,
            SendChangeTranslatorEmailToCurrentTranslator::class
        ],
        ChangeDate::class => [
            SendChangeDateEmailToUser::class,
            SendChangeDateEmailToTranslator::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
