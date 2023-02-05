<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;

class GenerateMembersRollNo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:roll-no';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate roll numbers of members have roll number is missing.';

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
            if(!$member->roll_number) {
                $member->roll_number = 'MBR-' . $member->id;
                $member->save();
                $this->info($member->roll_number . ' roll no generated against ' . $member->name);
            } else {
                $this->line($member->name . ' already has roll number.');
            }
        }
    }
}
