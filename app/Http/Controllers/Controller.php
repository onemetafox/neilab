<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\InternalWallet;
use SWeb3\Sweb3;
use SWeb3\Sweb3_contract;

use App\Models\SuperLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalTradeBuyList;
use App\Models\InternalTradeSellList;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function exchange($param=null){
        $n_id = $param['ex_name'];
        $exchange_id = '\\ccxt\\' . $n_id;
        $exchange = new $exchange_id(array(
            'enableRateLimit' => true,
            'apiKey' => $param['api_key'],
            'secret' => $param['api_secret'],
        ));
        return $exchange;
    }
    function getBalance($address) {
        return file_get_contents('https://blockchain.info/q/addressbalance/'. $address);
    }

    public function sendUSDT($from, $from_pk, $to, $amount){
            $amount_big = $amount*1000000;
            exec('node C:\NeilLab\app\Http\Controllers\Admin\USDTSendServer\sendUSDT.js ' .$from.' '.$from_pk. ' '.$to.' '.$amount_big, $output);
            return $output;
    }


    public function createMarketBuyOrder($symbol, $amount, $exchange){
        $type = 'market';
        $side = 'buy';
        $order = $exchange->createOrder($symbol, $type, $side, $amount);
        return $order;
    }

    public function createMarketSellOrder($symbol, $amount, $exchange){
        $type = 'market';
        $side = 'sell';
        $order = $exchange->createOrder($symbol, $type, $side, $amount);
        return $order;
    }

    public function getBTCMarketPrice($amount){

        $url='https://bitpay.com/api/rates';
        $json=json_decode( file_get_contents( $url ) );
        $dollar=$btc=0;
        
        foreach( $json as $obj ){
            if( $obj->code=='USD' )$btc=$obj->rate;
        }
        $dollar=1 / $btc;
        $result = round( $dollar * $amount,8 );
        return $result;
    }

    public function checkTransaction($from, $to, $amount, $tx_id){
        
        exec('node C:\NeilLab\app\Http\Controllers\Admin\USDTSendServer\checkTransaction.js ' .$from.' '.$to. ' '.$amount.' '.$tx_id, $output);
        return $output;
    }
    
    public function marketBuyOrder($exchange, $amount, $superload_id){
        $symbol = "BTC/USDT";
        $market_amount = $this->getBTCMarketPrice($amount);
        \Log::info($market_amount.$superload_id);
        $order = $this->createMarketBuyOrder($symbol, $market_amount, $exchange);
        $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        $update_result = InternalTradeBuyList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);
    }
    public function marketSellOrder($exchange, $amount, $superload_id){
        $symbol = "BTC/USDT";
        $order = $this->createMarketSellOrder($symbol, $amount, $exchange);
        $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        $update_result = InternalTradeSellList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);
    }

    public function cronHandleFunction(){
        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();
        foreach ($result as $key => $value) {
            $exchange = $this->exchange($value);

            $usdt_deposit_history = $exchange->fetchDeposits("USDT");
            \Log::info($usdt_deposit_history);
            foreach ($usdt_deposit_history as $key => $value) {
                # code...
                if($value['status'] == 'ok'){
                    if(isset($value['txid'])){
                        $database_status_of_superload = SuperLoad::where('tx_id', $value['txid'])->get()->toArray();
                        if(count($database_status_of_superload) != 0 && $database_status_of_superload[0]['status'] == 0){
                            $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['status' => 1]);
                            $this->marketBuyOrder($exchange, $database_status_of_superload[0]['amount'], $database_status_of_superload[0]['id']);
                        }
                    }
                }
            }
            $btc_deposit_history = $exchange->fetchDeposits("BTC");
            \Log::info($btc_deposit_history);
            foreach ($btc_deposit_history as $key => $value) {
                # code...
                if($value['status'] == 'ok'){
                    if(isset($value['txid'])){
                        $database_status_of_superload = SuperLoad::where('tx_id', $value['txid'])->get()->toArray();
                        if(count($database_status_of_superload) != 0 && $database_status_of_superload[0]['status'] == 0){
                            $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['status' => 1]);
                            $this->marketSellOrder($exchange, $database_status_of_superload[0]['amount'], $database_status_of_superload[0]['id']);
                        }
                    }
                }
            }
        }
    }
}