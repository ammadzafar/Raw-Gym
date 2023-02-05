<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $details, $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $password)
    {
        $this->details = $details;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from RAW Gym')->view('backend.email.passwordEmail')->with([
            'details' => $this->details,
            'password' => $this->password
        ]);
    }
}
