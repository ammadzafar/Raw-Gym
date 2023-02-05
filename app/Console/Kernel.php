<?php

namespace App\Console;

use App\Console\Commands\DailyAttendance;
use App\Console\Commands\ExpireMember;
use App\Console\Commands\MakeSuperAdmin;
use App\Console\Commands\InstagramFeeds;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Console\Command\Command;
use Phpfastcache\Config\ConfigurationOption;
use InstagramScraper\Instagram;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MakeSuperAdmin::class,
        Commands\DailyAttendance::class,
        Commands\ExpireMember::class,
        Commands\UserAttendance::class,
        Commands\GenerateMembersRollNo::class,
        //Commands\InstagramFeeds::class,
        Commands\BirthdayWishes::class,
        Commands\SendWeeklyReportCommand::class,
       // Commands\UserFees::class,
      //  Commands\MemberCreatedBy::class,
       // Commands\MemberRegDate::class,
        Commands\MemberPtf::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('daily:attendance')->daily();
/*        $schedule->command('users:attendance')->daily();*/
        $schedule->command('expire:members')->daily();
    /*    $schedule->command('members:birthday')->daily();*/
        //  $schedule->command('instagram:feeds')->daily();
        $schedule->command('send:weekly-report')->weeklyOn(7, '23:59');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
