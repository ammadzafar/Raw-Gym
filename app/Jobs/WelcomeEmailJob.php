<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $member;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $this->member= $member;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      \Mail::to($this->member->email)->send(new WelcomeMail($this->member));
    }
}
