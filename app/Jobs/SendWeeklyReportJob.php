<?php

namespace App\Jobs;

use App\Mail\SendWeeklyReportMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWeeklyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $income, $expense;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($income, $expense)
    {
        $this->income = $income;
        $this->expense = $expense;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $adminEmails = User::role('super-admin')->pluck('email')->toArray();

        foreach ($adminEmails as $email) {
            \Mail::to($email)->send(new SendWeeklyReportMail($this->income, $this->expense));
        }
    }
}
