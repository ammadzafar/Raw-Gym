<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collected_by')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('member_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('membership_id')->index()->nullable()->constrained()->restrictOnDelete();
            $table->unsignedInteger('reg_fee')->nullable();
            $table->unsignedInteger('fees')->default('0');
            $table->unsignedInteger('pending_fees')->nullable();
            $table->unsignedInteger('personal_training_fees')->nullable();
            $table->unsignedInteger('pending_personal_training_fees')->nullable();
            $table->enum('payment_method', ['Mpesa', 'cash', 'other']);
            $table->timestamp('payment_date');
            $table->timestamp('expire_date');
            $table->enum('status', ['paid', 'unpaid', 'pending', 'un_attendant'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
