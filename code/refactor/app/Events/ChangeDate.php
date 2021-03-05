<?php

namespace App\Events;

class ChangeDate
{
    public $job;
    public $oldTime;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($job, $oldTime)
    {
        $this->job = $job;
        $this->oldTime = $oldTime;
    }
}
