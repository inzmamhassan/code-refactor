<?php

namespace App\Listeners;

use App\Events\ChangeDate;
use App\Mail\ChangeLangEmailToTranslator;
use DTApi\Models\Job;

class SendChangeLangEmailToTranslator
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
        $translator = Job::getJobsAssignedTranslatorDetail($event->job);
        $user = $event->job->user()->first();
        \Mail::to($translator->email)->send(new ChangeLangEmailToTranslator($user,$event->job,$event->oldLang));
    }
}
