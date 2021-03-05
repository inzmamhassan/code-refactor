<?php

namespace App\Events;

class JobStored
{
    public $user;
    public $job;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $job)
    {
        $this->user = $user;
        $this->job = $job;
    }
}
