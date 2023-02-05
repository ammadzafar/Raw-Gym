<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!$this->data['last_payment']->pending_fees || !$this->data['last_payment']->pending_personal_training_fees) {
            $this->data['last_payment']->reg_fee = $this->data['last_payment']->reg_fee??0;
            $this->data['last_payment']->fees =$this->data['last_payment']->fees>5000?$this->data['last_payment']->fees:5000; //env('BASIC_FEES') ?? 5000;
            $this->data['last_payment']->pending_fees = 0;
            $this->data['last_payment']->personal_training_fees;
            $this->data['last_payment']->pending_personal_training_fees = 0;
        }

        return $this->subject('RAW Gym')->view('backend.email.paymentEmail')->with('data', $this->data);
    }
}
