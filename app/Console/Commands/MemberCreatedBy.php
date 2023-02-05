<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;

class MemberCreatedBy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:createdby';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command assign created_by id to members who has no assign created_by';

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
       foreach ($members as $member)
       {
           if($member->created_by==null)
           {
               $member->created_by = 1;
               $member->save();
               $this->line($member->name."is Created by Super Admin");
           }else
           {
               $this->warn('All member have author');
           }
       }
    }
}
