<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_loads', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('trade_type');
            $table->smallInteger('trade_id');
            $table->smallInteger('superload_id');
            $table->smallInteger('exchange_id');
            $table->string      ('receive_address');
            $table->string      ('sending_address');
            $table->string      ('tx_id');
            $table->float       ('amount',10,6);
            $table->Integer       ('withdraw_order_id');
            $table->smallInteger('status');
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
        Schema::dropIfExists('sub_loads');
    }
}
