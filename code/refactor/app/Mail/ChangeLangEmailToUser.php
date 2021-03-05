<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ChangeLangEmailToUser extends Mailable
{
    private $user;
    private $job;
    private $old_lang;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $job, $old_lang)
    {
        $this->user = $user;
        $this->job = $job;
        $this->old_lang = $old_lang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Meddelande om ändring av tolkbokning för uppdrag # ' . $this->job->id .')')
            ->view('emails.job-changed-lang', [
                'user'     => $this->user,
                'job'      => $this->job,
                'old_lang' => $this->old_lang
            ]);
    }
}
