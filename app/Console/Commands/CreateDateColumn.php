<?php

namespace App\Console\Commands;

use App\Models\Fee;
use Illuminate\Console\Command;

class CreateDateColumn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fees:date';

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
        $fees = Fee::all();
        foreach ($fees as $fee){
            $date = $fee['created_at']->toDateString();
            $fee['date'] = $date;
            $fee->save();
        }
        $this->line('Dates Updated Successfully');
    }
}
