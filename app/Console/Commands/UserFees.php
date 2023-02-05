<?php

namespace App\Console\Commands;

use App\Models\Fee;
use App\Models\FeeLog;
use App\Models\Member;
use Illuminate\Console\Command;

class UserFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:fees';

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
     *
     */
    public function handle()
    {
        $members = Member::all();
        foreach ($members as $member) {
            $memberid = $member->id;
            $memberFee = $member->fee_structure;
            $userId = 1;
            $updatedBy = 'Awais Shakir';
            $feeLog = new FeeLog();
            $feeLog->member_id = $memberid;
            $feeLog->user_id = $userId;
            $feeLog->fees = $memberFee;
            $feeLog->updated_by = $updatedBy;
            $feeLog->save();
            if ($member->fees()->exists()) {
                foreach ($member->fees as $fees) {
                    $reg_fees = (int)$fees->reg_fee;
                    $fees->total_payment = (int)$fees->fees;
                    $fees->fees = $fees->total_payment - $reg_fees;
                    // $fees->payment_date = $fees->payment_date;
                    $fees->save();
                }
            }
        }
        $this->line('Updated Successfully');
    }
}
