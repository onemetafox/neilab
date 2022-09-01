<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalBuyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_buy_lists', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('global_user_id');
            $table->smallInteger('cronjob_list');
            $table->smallInteger('asset_purchased');
            $table->double('buy_ammount');
            $table->string('buy_address');
            $table->string('pay_with');
            $table->smallInteger('chain_stack_and_bank');
            $table->string('transaction_description');
            $table->Integer('trust_fee');
            $table->string('campain_type');
            $table->Integer('profit');
            $table->Integer('commission');
            $table->Integer('fee_from_exchange');
            $table->Integer('bank_exchange');
            $table->Integer('left_over_profit');
            $table->Integer('total_amount_left_buy');
            $table->Integer('master_load');
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
        Schema::dropIfExists('internal_buy_lists');
    }
}
