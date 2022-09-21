<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChainStackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chain_stacks')->insert(
            [
                'stackname' => 'BTC',
                'status' => 1,
            ],[
                'stackname' => 'ERC20',
                'status' => 1,
            ],[
                'stackname' => 'TRC20',
                'status' => 1,
            ],[
                'stackname' => 'BEP20',
                'status' => 1,
            ],[
                'stackname' => 'BEP2',
                'status' => 1,
            ],[
                'stackname' => 'HECO',
                'status' => 1,
            ],[
                'stackname' => 'OMNI',
                'status' => 1,
            ]
            );
    }
}
