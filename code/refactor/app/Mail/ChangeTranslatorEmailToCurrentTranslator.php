<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ChangeTranslatorEmailToCurrentTranslator extends Mailable
{
    private $user;
    private $job;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $job)
    {
        $this->user = $user;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Meddelande om tilldelning av tolkuppdrag för uppdrag # ' . $this->job->id .')')
            ->view('emails.job-changed-translator-new-translator', [
                'user' => $this->user
            ]);
    }
}
