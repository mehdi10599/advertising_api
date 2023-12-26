<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWithdrawHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_withdraw_history', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('helios_id');
            $table->integer('golds');
            $table->integer('gems');
            $table->integer('ads');
            $table->boolean('payment_status')->default(false);
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_withdraw_history');
    }
}
