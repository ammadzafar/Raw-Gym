<?php

namespace App\Console\Commands;

use App\Mail\DuesFeeNotificationEmail;
use App\Jobs\SendDuesEmailToExpireMembers;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;


class ExpireMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire member on subscription.';

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
        $members = Member::get();

        foreach ($members as $member) {

            if ($member->is_expired) {
                $this->line($member->name . ' already expired.');
            } else {
                $member_last_fees = $member->fees()->latest()->first();

                if ($member_last_fees) {
                    $expire_date = Carbon::create($member_last_fees->expire_date);
                    $current_date = Carbon::today()->format('Y-m-d');
                    if ($expire_date == $current_date || $expire_date < $current_date) {
                        $member->is_expired = true;

                        if ($expire_date->diffInMonths() >= 1) {
                            $member->is_expired = true;
                            $member->expired_at = now();
                            $member->status = false;
                        }

                        $member->save();

                        dispatch(new SendDuesEmailToExpireMembers($member));

                        $this->info($member->name . ' expired.');
                    }

                }
            }
        }
    }
}
