<?php

namespace App\Jobs;

use App\Mail\BirthdayEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     private $members;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($members)
    {
     $this->members = $members;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->members as $member){
            Mail::to($member->email)->send(new BirthdayEmail($member));

        }

    }
}
