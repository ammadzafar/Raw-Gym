<?php

namespace App\Jobs;

use App\Mail\ConsultantEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailtoConsultantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $consultant;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($consultant)
    {
        $this->consultant = $consultant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->consultant['email'])->send(new ConsultantEmail($this->consultant));
    }
}
