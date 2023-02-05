<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $income, $expense;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($income, $expense)
    {
        $this->income = $income;
        $this->expense = $expense;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Weekly Report | RAW Gym')->view('backend.email.sendWeeklyReportEmail')->with([
            'income' => $this->income,
            'expense' => $this->expense,
        ]);
    }
}
