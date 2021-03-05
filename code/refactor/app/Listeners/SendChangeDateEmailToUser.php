<?php

namespace App\Listeners;

use App\Events\ChangeDate;
use App\Mail\ChangeDateEmailToUser;
use App\Mail\ChangeTranslatorEmailToUser;

class SendChangeDateEmailToUser
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
    public function handle(ChangeDate $event)
    {
        $user = $event->job->user()->first();
        \Mail::to((!empty($event->job->user_email)) ? $event->job->user_email : $user->email)->send(new ChangeDateEmailToUser($user,$event->job,$event->oldTime));
    }
}
