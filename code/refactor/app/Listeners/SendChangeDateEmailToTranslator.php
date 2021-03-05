<?php

namespace App\Listeners;

use App\Events\ChangeDate;
use App\Mail\ChangeDateEmailToTranslator;
use DTApi\Models\Job;

class SendChangeDateEmailToTranslator
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
        \Mail::to($translator->email)->send(new ChangeDateEmailToTranslator($translator,$event->job,$event->oldTime));
    }
}
