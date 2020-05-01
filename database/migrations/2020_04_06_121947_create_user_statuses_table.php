<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_reason_id');

            $table->timestamp('from', 0)->default(now());
            $table->timestamp('to', 0)->nullable();
            $table->string('note', 100)->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_reason_id')->references('id')->on('status_reasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');
    }
}
