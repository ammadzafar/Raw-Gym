<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BirthdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send email to that members whoes birthday are today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = \Carbon\Carbon::today();
        $currentMonth = $today->month;
        $birthyDayMemberCount = \App\Models\Member::whereMonth('dob', $currentMonth)->whereDay('dob', $today)->count();
        $members = \App\Models\Member::whereMonth('dob', $currentMonth)->whereDay('dob', $today)->get();
        dispatch(new \App\Jobs\SendBirthdayEmailJob($members));
        $this->info("Birthday Email send to Related Members");
    }
}
