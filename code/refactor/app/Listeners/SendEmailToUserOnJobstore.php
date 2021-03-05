<?php

namespace App\Listeners;

use App\Events\JobStored;
use App\Mail\UserJobStored;

class SendEmailToUserOnJobstore
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
    public function handle(JobStored $event)
    {
        \Mail::to((!empty($event->job->user_email)) ? $event->job->user_email : $event->user->email)->send(new UserJobStored($event->user,$event->job));
    }
}
