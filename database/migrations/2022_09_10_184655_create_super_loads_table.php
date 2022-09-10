<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_loads', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('trade_type');
            $table->smallInteger('trade_id');
            $table->smallInteger('master_load_id');
            $table->smallInteger('exchange_id');
            $table->string      ('receive_address');
            $table->string      ('sending_address');
            $table->float       ('amount');
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
        Schema::dropIfExists('super_loads');
    }
}
