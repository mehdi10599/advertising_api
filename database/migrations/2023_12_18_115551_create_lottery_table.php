<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery', function (Blueprint $table) {
            $table->id();
            $table->string('lottery_id');
            $table->integer('price');
            $table->integer('required_gold');
            $table->integer('required_gem');
            $table->integer('subscriber_count');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->timestamps();

            $table->unique('lottery_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery');
    }
}
