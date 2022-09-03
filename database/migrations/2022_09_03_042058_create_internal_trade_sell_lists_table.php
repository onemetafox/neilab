<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTradeSellListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_trade_sell_lists', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('global_user_id');
            $table->smallInteger('cronjob_list');
            $table->smallInteger('asset_sold');
            $table->smallInteger('sell_amount');
            $table->string      ('receive_address');
            $table->string      ('pay_with');
            $table->smallInteger('chain_stack');
            $table->string      ('transaction_description');
            $table->smallInteger('trust_fee');
            $table->smallInteger('campain_type');
            $table->smallInteger('profit');
            $table->smallInteger('commision_id');
            $table->smallInteger('fee_from_exchange');
            $table->smallInteger('bank_changes');
            $table->smallInteger('left_over_profit');
            $table->smallInteger('total_amount_left');
            $table->smallInteger('master_load');
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
        Schema::dropIfExists('internal_trade_sell_lists');
    }
}
