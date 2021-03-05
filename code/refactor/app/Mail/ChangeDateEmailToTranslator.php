<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ChangeDateEmailToTranslator extends Mailable
{
    private $user;
    private $job;
    private $old_time;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $job, $old_time)
    {
        $this->user = $user;
        $this->job = $job;
        $this->old_time = $old_time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Meddelande om ändring av tolkbokning för uppdrag # ' . $this->job->id .')')
            ->view('emails.job-changed-date', [
                'user'     => $this->user,
                'job'      => $this->job,
                'old_time' => $this->old_time
            ]);
    }
}
