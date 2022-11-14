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
            $table->string('api_key');
            $table->string('api_secret');
            $table->string('ex_sms_phone_number')->nullable()->change();
            $table->string('api_login')->nullable()->change();
            $table->string('api_password')->nullable()->change();
            $table->string('api_account_name')->nullable()->change();
            $table->string('api_passphase')->nullable()->change();
            $table->string('api_fund_password')->nullable()->change();
            $table->string('api_doc')->nullable()->change();
            $table->string('api_doc_link')->nullable()->change();
            $table->string('bank_login')->nullable()->change();
            $table->string('bank_password')->nullable()->change();
            $table->string('bank_link')->nullable()->change();
            $table->string('bank_other')->nullable()->change();
            $table->string('contact_name')->nullable()->change();
            $table->string('contact_email')->nullable()->change();
            $table->string('contact_phone')->nullable()->change();
            $table->string('contact_telegram')->nullable()->change();
            $table->string('contact_whatsapp')->nullable()->change();
            $table->string('contact_skype')->nullable()->change();
            $table->string('contact_boom_boom_chat')->nullable()->change();
            $table->smallInteger('state')->nullable()->change();
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
