<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TradingPairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trading_pairs')->insert(
            [
                'exchange_id' => 1,
                'left' => 'BTC',
                'l_chin_stack' => 'Bitcoin',
                'right' => 'USDT',
                'r_chain_stack' => 'Ethereum',
                'select_all' => 1,
                'select_exhcnage_they_can' => 1,
            ]);
    }
}
