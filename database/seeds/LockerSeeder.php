<?php

use Illuminate\Database\Seeder;

class LockerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=16; $i++)
        {
            \App\Models\Locker::updateOrCreate([
                'number'=>$i
            ]);
        }
    }
}
