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
use App\Models\SubLoad;
use App\Models\Withdraw;

use App\Models\ExchangeInfo;
use App\Models\InternalTradeBuyList;
use App\Models\InternalTradeSellList;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $RPCusername = 'lam';
    private $RPCpassword = 'Masterskills113';
    public function requiredMarketingCampain(){
        $page_title = 'required marketing campaign';
        $page_description = 'Some description for the page';
        $action = __FUNCTION__;
        return view('zenix.page.requiredMarketingCampain', compact('page_title', 'page_description', 'action'));
    }
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
    public function createMarketTestBuyOrder(){
        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();
        $type = "market";
        $side = "sell";
        $symbol = "BTC/USDT";
        $amount = 0.0014;
        $market_amount = $this->getBTCMarketPrice($amount);
        foreach ($result as $key => $value) {
            if($value['ex_name'] == "FTX"){
                $exchange = $this->exchange($value);
                // $order = $exchange->createOrder($symbol, $type, $side, $amount);
                // echo($order['amount']);
                // print_r($order);
            }
        }
        exit;
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
    public function getUSDTPrice($amount){
        $url='https://bitpay.com/api/rates';
        $json=json_decode( file_get_contents( $url ) );
        $dollar=$btc=0;
        
        foreach( $json as $obj ){
            if( $obj->code=='USD' )$btc=$obj->rate;
        }
        $result = round( $btc * $amount,8 );
        return $result;
    }
    public function checkTransaction($from, $to, $amount, $tx_id){
        
        exec('node C:\NeilLab\app\Http\Controllers\Admin\USDTSendServer\checkTransaction.js ' .$from.' '.$to. ' '.$amount.' '.$tx_id, $output);
        return $output;
    }
    public function withdraw_old(){
        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();

        $code = "BTC";
        $superload_id = 1;
        $amount = 0.0027;

        $exchange = $this->exchange($result[0]);
        $order = array();
        $order['amount'] = 0.0027;

        $this->withdraw($exchange, $superload_id, $order);
    }

    public function withdraw($exchange, $superload_id, $order){

        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        $withdraw_info = array();

        if(isset($superload_info[0]['trade_type']) && $superload_info[0]['trade_type'] == 1){

            $code = "BTC";
            $amount = $order['amount'];
            $address = 'bc1q8qd968ch8uth08m2uwyzwgvcrchepjr2qqdacw';
            $withdraw_detail = $exchange->withdraw($code, $amount, $address);
            $withdraw_info['trade_type'] = 1;


        }else if(isset($superload_info[0]['trade_type']) && $superload_info[0]['trade_type'] == 2){
            $code = "USDT";
            $amount = $order['amount'];
            $usdt_amount = $this->getUSDTPrice($amount);
            \Log::info($usdt_amount);
            $address = '0xb72be9c6d9F9Ac2F6742f281d6Cb03aF013e09a7';
            $withdraw_detail = $exchange->withdraw($code, $usdt_amount, $address);
            $withdraw_info['trade_type'] = 2;
        }
        $withdraw_info['trade_id'] = $superload_info[0]['trade_id'];
        $withdraw_info['superload_id'] = $superload_id;
        $withdraw_info['exchange_id'] = $superload_info[0]['exchange_id'];
        $withdraw_info['withdraw_order_id'] = $withdraw_detail['id'];
        $withdraw_info['status'] = 0;
        $result = Withdraw::create($withdraw_info);
    }

    public function marketBuyOrder($exchange, $amount, $superload_id){
        $symbol = "BTC/USDT";
        $market_amount = $this->getBTCMarketPrice($amount);
        // \Log::info($market_amount.$superload_id);
        $order = $this->createMarketBuyOrder($symbol, $market_amount, $exchange);
        $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        $update_result = InternalTradeBuyList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);

        $exchange_detail = ExchangeInfo::where('id', $superload_info[0]['exchange_id'])->get()->toArray();
        if(isset($exchange_detail[0]['ex_name']) && $exchange_detail[0]['ex_name'] == 'Binance'){
            sleep(20);
            $this->withdraw($exchange, $superload_id, $order);
        }
    }
    public function marketSellOrder($exchange, $amount, $superload_id){
        $symbol = "BTC/USDT";
        $order = $this->createMarketSellOrder($symbol, $amount, $exchange);
        $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        $update_result = InternalTradeSellList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);

        $exchange_detail = ExchangeInfo::where('id', $superload_info[0]['exchange_id'])->get()->toArray();
        if(isset($exchange_detail[0]['ex_name']) && $exchange_detail[0]['ex_name'] == 'Binance'){
            sleep(20);
            $this->withdraw($exchange, $superload_id, $order);
        }
    }

    public function cronHandleFunction(){
        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();
        foreach ($result as $key => $value) {
            $exchange = $this->exchange($value);

            $usdt_deposit_history = $exchange->fetchDeposits("USDT");
            // \Log::info($usdt_deposit_history);
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
            // \Log::info($btc_deposit_history);
            foreach ($btc_deposit_history as $key => $value) {
                # code...
                if($value['status'] == 'ok'){
                    if(isset($value['txid'])){
                        $database_status_of_superload = SuperLoad::where('tx_id', $value['txid'])->get()->toArray();
                        if(count($database_status_of_superload) != 0 && $database_status_of_superload[0]['status'] == 0){
                            \Log::info($database_status_of_superload[0]['tx_id']."------------peding complete");
                            $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['status' => 1]);
                            $this->marketSellOrder($exchange, $database_status_of_superload[0]['amount'], $database_status_of_superload[0]['id']);
                        }
                    }
                }
            }
        }
    }
    
    public function cronWithdrawHandleFunction(){
        $withdraw_order_info = Withdraw::where('status', 0)->get()->toArray();
        foreach ($withdraw_order_info as $key => $value) {
            # code...
            if($value['trade_type'] == 1){
                $asset = "BTC";
                $confirm_result = $this->confirmWithdrawTransaction($asset, $value);
                if($confirm_result['success']){
                    \Log::info($confirm_result['withdraw_transaction']);
                    $this->lastStep($asset, $value, $confirm_result['withdraw_transaction']);
                }
            }else{
                $asset = "USDT";
                $confirm_result = $this->confirmWithdrawTransaction($asset, $value);
                if($confirm_result['success']){
                    \Log::info($confirm_result['withdraw_transaction']);
                    $this->lastStep($asset, $value, $confirm_result['withdraw_transaction']);
                }

            }
        }
    }

    public function lastStep($asset, $withdraw_tbl, $withdraw_transaction){
        $update_withdraw_tbl_result = Withdraw::where('id', $withdraw_tbl['id'])->update(['status' => 1]);
        $subload_info = array();
        
        $subload_info['trade_type']         = $withdraw_tbl['trade_type'];
        $subload_info['trade_id']           = $withdraw_tbl['trade_id'];
        $subload_info['superload_id']       = $withdraw_tbl['superload_id'];
        $subload_info['exchange_id']        = $withdraw_tbl['exchange_id'];
        $subload_info['receive_address']    = $withdraw_transaction['addressTo'];
        $subload_info['tx_id']              = $withdraw_transaction['txid'];
        $subload_info['amount']             = $withdraw_transaction['amount'];
        $subload_info['withdraw_order_id']  = $withdraw_transaction['id'];
        $subload_info['status']             = 1;

        $subload_create_result = SubLoad::create($subload_info);
        $superload_update_resultt = SuperLoad::where('id', $withdraw_tbl['superload_id'])->update(['status' => 3]);

        $trade_info = InternalTradeBuyList::where('id', $withdraw_tbl['trade_id'])->get()->toArray();

        if($asset == 'BTC'){
            $this->sendBTC($trade_info[0]['delivered_address'], $withdraw_transaction['amount']);
        }else if($asset == 'USDT'){
            $internal_wallet_info = InternalWallet::where('wallet_address', '0xb72be9c6d9F9Ac2F6742f281d6Cb03aF013e09a7')->get()->toArray();
            $this->sendUSDT($internal_wallet_info[0]['wallet_address'], $internal_wallet_info[0]['private_key'], $trade_info[0]['delivered_address'], $withdraw_transaction['amount']);
        }
    }

    public function confirmWithdrawTransaction($asset, $value){
        $exchange_info = ExchangeInfo::where('id', $value['exchange_id'])->get()->toArray();
        $exchange = $this->exchange($exchange_info[0]);
        $withdraw_transaction_history = $exchange->fetchWithdrawals($asset);
        // \Log::info($withdraw_transaction_history);
        $return = false;
        $transaction = array();

        foreach ($withdraw_transaction_history as $key => $history_value) {
            # code...
            if($history_value['id'] == $value['withdraw_order_id'] && $history_value['status'] == 'ok'){
                $return = true;
                $transaction = $history_value;
                break;
            }
        }
        return ['success' => $return, 'withdraw_transaction' => $transaction];
    }

    public function confirm_btc_payment ($amount, $txid) {

        $curl = curl_init();
        $year = date('Y');

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:7890",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->RPCusername.':'.$this->RPCpassword,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => '{ "id": "curltext", "method":"onchain_history", "params": {"year": '.$year.' } }',
            CURLOPT_POST => 1,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['status'=>'error', 'message'=>$err];
        } else {
            $result = json_decode($response);
            if(isset($result->result)){
                $transactions = $result->result->transactions;
                foreach($transactions as $tx) {
                    if(floatval($tx->bc_value) === floatval($amount) && $tx->txid === $txid && $tx->confirmations >= 6) {
                        return ['status'=>'success', 'result'=>'true'];
                    }
                }
                return ['status'=>'success', 'result'=>'false'];
            }else{
                return ['status'=>'error', 'message'=>'Some error occured!'];
            }
        }
    }

    public function sendBTC($to, $amount){

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:7890",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->RPCusername.':'.$this->RPCpassword,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => '{"id":"curltext","method":"payto","params": ["'.$to.'", '.$amount.']}',
            CURLOPT_POST => 1,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if ($err) {
            return ['status'=>'error', 'message'=>$err];
        } else {
            $result = json_decode($response);
            if(isset($result->result)){

                curl_setopt_array($curl, [
                    CURLOPT_URL => "http://localhost:7890",
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                    CURLOPT_USERPWD => $this->RPCusername.':'.$this->RPCpassword,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POSTFIELDS => '{"id":"curltext","method":"broadcast","params": ["'.$result->result.'"]}',
                    CURLOPT_POST => 1,
                ]);
        
                $response1 = curl_exec($curl);
                $err1 = curl_error($curl);
                curl_close($curl);

                if($err1){
                    return ['status'=>'error', 'message'=>$err1];
                }else{
                    $result1 = json_decode($response1);
                    if(isset($result1->result)){
                        return ['status'=>'success', 'txid'=>$result1->result];
                    }else{
                        return ['status'=>'error', 'message'=>'An error occured!'];
                    }
                }
            }else{
                return ['status'=>'error', 'message'=>$result->error->message];
            }
        }
    }

    public function coming_soon(){
        $page_title = 'Coming Soon...';
        $page_description = 'Some description for the page';
        $action = __FUNCTION__;
        return view('zenix.page.coming_soon', compact('page_title', 'page_description', 'action'));
    }
}