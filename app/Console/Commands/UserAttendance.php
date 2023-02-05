<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UserAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will schedule the attendance of Employee';

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
        $users = User::where('employ_type', 1)->get();
        $today = Carbon::today()->format('Y-m-d');
        $today_l = Carbon::parse($today)->format('l');

        $weekends = env('WEEKENDS');
        $weekends = explode(",", $weekends);
        $weekends = array_map('ucfirst', $weekends);

        foreach ($users as $user) {
            $attendanceTimings = $user->shifts()->pluck('from')->toArray();

            if ($attendanceTimings) {
                foreach ($attendanceTimings as $time) {
                    $attendTime = Carbon::createFromFormat('g A', $time);

                    if (!$user->userAttendances()->where('shift_time', $attendTime)->count()) {

                        $status = 'absent';
                        $label = 'weekdays';

                        if (in_array($today_l, $weekends)) {
                            $status = 'weekend';
                            $label = 'weekend';
                        }

                        $user->userAttendances()->create([
                            'shift_time' => $attendTime,
                            'status' => $status,
                            'label' => $label,
                            'ip' => request()->ip(),
                        ]);
                        $this->info($user->name . ' attendance marked for time: ' . $attendTime->toDateTimeString());
                    } else {
                        $this->line($user->name . ' attendance already marked for time: ' . $attendTime->toDateTimeString());
                    }
                }
            }
        }
    }
}
