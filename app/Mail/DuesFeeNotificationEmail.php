<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DuesFeeNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $member, $quote;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($member, $quote)
    {
        $this->member = $member;
        $this->quote = $quote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAW Gym')->view('backend.email.pendingDuesToExpiredMembersEmail')->with([
            'member' => $this->member,
            'quote' => $this->quote,
        ]);
    }
}
