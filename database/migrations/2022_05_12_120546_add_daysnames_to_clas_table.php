<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysnamesToClasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clas', function (Blueprint $table) {
            $table->boolean('Monday')->default(false)->after('name');
            $table->boolean('Tuesday')->default(false)->after('name');
            $table->boolean('Wednesday')->default(false)->after('name');
            $table->boolean('Thursday')->default(false)->after('name');
            $table->boolean('Friday')->default(false)->after('name');
            $table->boolean('Saturday')->default(false)->after('name');
            $table->boolean('Sunday')->default(false)->after('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clas', function (Blueprint $table) {
            $table->dropColumn('Monday');
            $table->dropColumn('Tuseday');
            $table->dropColumn('Wednesday');
            $table->dropColumn('Thursday');
            $table->dropColumn('Friday');
            $table->dropColumn('Satureday');
            $table->dropColumn('Sunday');
        });
    }
}
