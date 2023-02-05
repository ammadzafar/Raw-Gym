<?php

namespace App\Console\Commands;

use App\Models\Fee;
use App\Models\Member;
use App\Models\RegisterLog;
use http\Env\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class MemberRegDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:regdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to assign registration date in fee table and RegLog';

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

            foreach ($members as $member) {

                if (!$member->registerLogs()->exists()) {
                    $regLog = new RegisterLog();
                    $regLog->user_id = 1;
                    $regLog->member_id = $member->id;
                    $regLog->reg_date = $member->created_at;
                    $regLog->reg_fee = $member->reg_fee;
                    $regLog->updated_by = "Awais Shakir";
                    $regLog->save();
                    if ($member->fees()->exists()) {
                        foreach ($member->fees as $fee) {
                            $fee->reg_date = $member->created_at;
                            // Fee::update(['reg_date'=>$member->created_at]);
                            $fee->save();
                        }
                    }

                    DB::commit();
$this->line($member->name .'successfully updated');
                } else {
                    $this->warn($member->name . " already have registration logs");
                }

            }


       } catch
        (\Doctrine\DBAL\Exception $exception)
        {
            $exception->getMessage();
        }
    }
}
