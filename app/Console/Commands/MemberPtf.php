<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\PtfLog;
use Doctrine\DBAL\Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class MemberPtf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:ptf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to assign ptf to member';

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
        try {
            DB::beginTransaction();
            $members = Member::all();
            foreach ($members as $member)
            {
                if($member->personal_training_fees)
                {
                    $userId = 1;
                    $updatedBy = 'Awais Shakir';
                    $memberId = $member->id;
                    $Ptf = $member->personal_training_fees;
                    $ptf  = new PtfLog();
                    $ptf->user_id = $userId;
                    $ptf->member_id =$memberId;
                    $ptf->updated_by = $updatedBy;
                    $ptf->personal_training_fees =$Ptf;
                    $ptf->save();
                        foreach($member->fees as $fee)
                        {
                            $fee->total_payment = $fee->total_payment + $fee->personal_training_fees;
                            $fee->save();
                        }
                    DB::commit();
                    $this->line($member->name ." have Ptf");
                }
            }
        }catch (Exception $exception)
        {
           return  response()->json($exception->getMessage());
        }
    }
}
