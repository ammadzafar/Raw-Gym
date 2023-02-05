<?php

use Illuminate\Database\Seeder;

class PaymentReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'financial_report',

        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::updateOrCreate([
                'name' => $permission
            ]);
        }
    }
}
