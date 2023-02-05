<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->foreignId('membership_id')->index()->nullable()->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('image')->nullable();
            $table->enum('gender', ['male', 'female', 'trans', 'other'])->default('male');
            $table->string('address')->nullable();
            $table->timestamp('dob')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedInteger('reg_fee')->nullable();
            $table->unsignedInteger('fee_structure')->default('0');
            $table->boolean('is_expired')->default(true);
            $table->unsignedBigInteger('personal_training_fees')->nullable();
            $table->boolean('personal_training')->default(false);

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
        Schema::dropIfExists('members');
    }
}
