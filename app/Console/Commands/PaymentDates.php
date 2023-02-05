<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;

class PaymentDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach ($members as $member){
            $member_id = $member->id;
            if ($member->fees()->exists()){
                foreach ($member->fees as $fees){
                    $payment_date = $fees->payment_date;
                    $fees->payment_month = $payment_date;
                    $fees->save();
                }
            }
        }
        $this->line('Payment Dates Updated Successfully');
    }
}
