<?php

namespace App\Listeners;

use App\Events\ChangeTranslator;
use App\Mail\ChangeTranslatorEmailToUser;

class SendChangeTranslatorEmailToUser
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
        $user = $event->job->user()->first();
        \Mail::to((!empty($event->job->user_email)) ? $event->job->user_email : $user->email)->send(new ChangeTranslatorEmailToUser($user,$event->job));
    }
}
