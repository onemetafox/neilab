<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InternalWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            [
                'chain_stack' => 2,
                'login' => 'test', 
                'password' => '12345', 
                'ipaddress' => 'localhost', 
                'wallet_address' => '0xb72be9c6d9F9Ac2F6742f281d6Cb03aF013e09a7',
                'private_key' => '933f6fcaeec6191ed3b306f155406d1f3117d6e684d751a7473a4dca30ce6e44',
                'set_as_treasury_wallet' => 1,
                'send_unpaid_commision' => 1,
                'send_trust_fee' => 1,
                'send_profit' => 1,
                'cold_storage_wallet_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],[
                'chain_stack' => 1,
                'login' => 'lam', 
                'password' => 'masterskills113@gmail.com', 
                'ipaddress' => 'InternalBTCWallet', 
                'wallet_address' => 'bc1q8qd968ch8uth08m2uwyzwgvcrchepjr2qqdacw',
                'private_key' => 'fe20198a3bee128a7eea22ad043ac25d510925197061c32dda3a2e16285f7ecc',
                'set_as_treasury_wallet' => 1,
                'send_unpaid_commision' => 1,
                'send_trust_fee' => 1,
                'send_profit' => 1,
                'cold_storage_wallet_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]];
        DB::table('internal_wallets')->insert($categories);
    }
}
