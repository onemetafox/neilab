<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColdWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cold_wallets')->insert(
            [
            'cold_address' => '1F1tAaz5x1HUXrCNLbtMDqcw6o5GNn4xqX',
            'wallet_type' => 1,
            ],[
            'cold_address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh',
            'wallet_type' => 2,
            ]);
    }
}
