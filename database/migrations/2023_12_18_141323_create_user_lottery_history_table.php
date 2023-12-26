<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLotteryHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lottery_history', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('lottery_id');
            $table->integer('join_times')->default(0);
            $table->enum('result', ['isRunning', 'waiting','win','lose'])->default('isRunning');
            $table->string('helios_id')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();

            $table->primary(['user_id','lottery_id']);
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('lottery_id')->references('lottery_id')->on('lottery');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_lottery_history');
    }
}
