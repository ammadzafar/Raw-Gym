<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $pendingfeemember = 0;
        $expireMember = 0;
      if (DB::connection()->getDatabaseName() && Schema::hasTable('members')) {
            $members = \App\Models\Member::all();
            $expireMember = $members->where('is_expired', 1)->count();
            foreach ($members as $key => $member) {
                if ($member->fees()->exists() && $member->fees()->latest()->first()->status === 'pending') {
                    $pendingfeemember++;
                }
            }
        }

        view()->share(['pendingfeemember' => $pendingfeemember, 'expireMember' => $expireMember]);
    }
}
