<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->timestamp('birth');
            $table->string('email', 100);
            $table->string('password');
            $table->unsignedBigInteger('work_schedule_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();

            $table->foreign('work_schedule_id')->references('id')->on('work_schedules');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
