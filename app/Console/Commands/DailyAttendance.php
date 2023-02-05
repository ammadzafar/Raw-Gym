<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to mark the daily attendance of members';

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
        $members = Member::all();
        $today = Carbon::today()->format('Y-m-d');

        foreach ($members as $member) {
            if (!$member->attendances()->where('date', $today)->count()) {

                $member->attendances()->create([
                    'date' => $today
                ]);

                $this->info($member->name . ' attendance marked.');
            } else {
                $this->line($member->name . ' attendance already marked.');
            }

        }
    }
}
