<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserJobStored extends Mailable
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
        return $this->subject('Vi har mottagit er tolkbokning. Bokningsnr: #' . $this->job->id)
            ->view('emails.job-created', [
                'user' => $this->user,
                'job'  => $this->job
            ]);
    }
}
