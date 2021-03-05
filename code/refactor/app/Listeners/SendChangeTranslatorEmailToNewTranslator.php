<?php

namespace App\Listeners;

use App\Events\ChangeTranslator;
use App\Mail\ChangeTranslatorEmailToNewTranslator;

class SendChangeTranslatorEmailToNewTranslator
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
        \Mail::to($event->changeTranslator->user->email)->send(new ChangeTranslatorEmailToNewTranslator($event->changeTranslator->user,$event->job));
    }
}
