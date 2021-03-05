<?php

namespace App\Events;

class ChangeLang
{
    public $job;
    public $oldLang;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($job, $oldLang)
    {
        $this->job = $job;
        $this->oldLang = $oldLang;
    }
}
