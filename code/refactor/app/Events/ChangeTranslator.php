<?php

namespace App\Events;

class ChangeTranslator
{
    public $changeTranslator;
    public $currentTranslator;
    public $job;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($changeTranslator, $currentTranslator, $job)
    {
        $this->changeTranslator = $changeTranslator;
        $this->currentTranslator = $currentTranslator;
        $this->job = $job;
    }
}
