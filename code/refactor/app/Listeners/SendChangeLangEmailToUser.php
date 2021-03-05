<?php

namespace App\Listeners;

use App\Events\ChangeLang;
use App\Mail\ChangeLangEmailToUser;

class SendChangeLangEmailToUser
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
    public function handle(ChangeLang $event)
    {
        $user = $event->job->user()->first();
        \Mail::to((!empty($event->job->user_email)) ? $event->job->user_email : $user->email)->send(new ChangeLangEmailToUser($user,$event->job,$event->oldLang));
    }
}
