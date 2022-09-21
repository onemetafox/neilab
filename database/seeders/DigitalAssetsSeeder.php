<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DigitalAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('digital_assets')->insert(
            [
                'digital_asset_name' => 'BTC',
                'status' => 1,
            ],[
                'cold_address' => 'USDT',
                'wallet_type' => 2,
            ]);
    }
}
