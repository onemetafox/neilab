<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingCampainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_campains', function (Blueprint $table) {
            $table->id();
            $table->string('campain_name');
            $table->smallInteger('total_fee');
            $table->smallInteger('internal_sales_fee');
            $table->smallInteger('uni_level_fee');
            $table->smallInteger('external_sales_manager');
            $table->smallInteger('trust_fee');
            $table->smallInteger('profit_fee');
            $table->smallInteger('kyc_required');
            $table->string('domain_url');
            $table->string('marketing_campain');
            $table->string('number_of_signups');
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
        Schema::dropIfExists('marketing_campains');
    }
}
