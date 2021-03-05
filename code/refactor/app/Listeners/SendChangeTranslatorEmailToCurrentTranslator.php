<?php

namespace App\Listeners;

use App\Events\ChangeTranslator;
use App\Mail\ChangeTranslatorEmailToCurrentTranslator;

class SendChangeTranslatorEmailToCurrentTranslator
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobStored  $event
     * @return void
     */
    public function handle(ChangeTranslator $event)
    {
        \Mail::to($event->currentTranslator->user->email)->send(new ChangeTranslatorEmailToCurrentTranslator($event->currentTranslator->user,$event->job));
    }
}
