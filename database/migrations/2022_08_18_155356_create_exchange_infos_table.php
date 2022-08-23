<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_infos', function (Blueprint $table) {
            $table->id();
            $table->string('ex_name');
            $table->string('ex_login');
            $table->string('ex_password');
            $table->string('ex_sms_phone_number');
            $table->string('api_login');
            $table->string('api_password');
            $table->string('api_account_name');
            $table->string('api_key');
            $table->string('api_secret');
            $table->string('api_passphase');
            $table->string('api_fund_password');
            $table->string('api_doc');
            $table->string('api_doc_link');
            $table->string('bank_login');
            $table->string('bank_password');
            $table->string('bank_link');
            $table->string('bank_other');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('contact_telegram');
            $table->string('contact_whatsapp');
            $table->string('contact_skype');
            $table->string('contact_boom_boom_chat');
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
        Schema::dropIfExists('exchange_infos');
    }
}
