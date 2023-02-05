<?php

namespace App\Jobs;

use App\Mail\DuesFeeNotificationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class SendDuesEmailToExpireMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $member, $quote;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $quotes = config('quotes.motivational');

        $this->member = $member;
        $this->quote = $quotes ? Arr::random($quotes) : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->member->email)->send(new DuesFeeNotificationEmail($this->member, $this->quote));
    }
}
