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
use App\Models\User;
use App\Models\MarketingCampain;
use App\Models\MarketingFeeWallet;
use App\Models\SendFeeTransaction;





class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->RPCusername = config('app.RPCusername');
        $this->RPCpassword = config('app.RPCpassword');
        $this->withdraw_limit = config('app.withdraw_limit');

    }

    // Redirect to Required Marketing page and coming soon page

    public function requiredMarketingCampain(){
        $page_title = 'required marketing campaign';
        $page_description = 'Some description for the page';
        $action = __FUNCTION__;
        return view('zenix.page.requiredMarketingCampain', compact('page_title', 'page_description', 'action'));
    }

    public function coming_soon(){
        $page_title = 'Coming Soon...';
        $page_description = 'Some description for the page';
        $action = __FUNCTION__;
        return view('zenix.page.coming_soon', compact('page_title', 'page_description', 'action'));
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

    public function getBTCMarketPrice($exchange_info, $amount){
        # code...
        $bitcoin_ticker = $exchange_info->fetch_ticker('BTC/USDT');
        $btc_amount = round($amount/$bitcoin_ticker['bid'], 6);
        return $btc_amount;
    }
    
    public function getUSDTPrice($exchange_info, $amount){
        # code...
        $bitcoin_ticker = $exchange_info->fetch_ticker('BTC/USDT');
        $usdt_amount = round($amount*$bitcoin_ticker['bid'], 6);
        return $usdt_amount;
    }

    public function createMarketBuyOrder($symbol, $amount, $exchange){
        $type = 'market';
        $side = 'buy';
        $order = $exchange->createOrder($symbol, $type, $side, $amount);
        \Log::info("Create Market Buy Order which amount is".$amount);
        return $order;
    }

    public function createMarketSellOrder($symbol, $amount, $exchange){
        $type = 'market';
        $side = 'sell';
        $order = $exchange->createOrder($symbol, $type, $side, $amount);
        \Log::info("Create Market Sell Order which amount is".$amount);
        return $order;
    }

    public function marketBuyOrder($exchange, $amount, $superload_id){
        $symbol = "BTC/USDT";
        $market_amount = round($this->getBTCMarketPrice($exchange, $amount)*0.999, 6);
        $order = $this->createMarketBuyOrder($symbol, $market_amount, $exchange);

        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        if($order['amount'] > 0){
            /* update result amount of marketing sale */
            $total_sold_amount = $superload_info[0]['result_amount'] + $order['amount'];
            $update_superload_result = SuperLoad::where('id', $superload_id)->update(['result_amount' => $total_sold_amount]);
            \Log::info("New marketing buy has been request. amount = ".$order['amount']);
        }
        /* If all deposited money has been saled, withdraw the total result amount. */
        if($superload_info[0]['status'] == 1 && $superload_info[0]['result_amount'] < $this->withdraw_limit){
            $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
            $update_result = InternalTradeBuyList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);

            sleep(13);
            $this->withdraw($exchange, $superload_id);
        }
    }

    public function marketSellOrder($exchange, $amount, $superload_id){
        $symbol = "BTC/USDT";
        $market_amount = round($amount*0.999, 6);
        $order = $this->createMarketSellOrder($symbol, $amount, $exchange);

        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        if($order['amount'] > 0){
            $total_sold_amount = $superload_info[0]['result_amount'] + $order['amount'];
            $update_superload_result = SuperLoad::where('id', $superload_id)->update(['result_amount' => $total_sold_amount]);
            \Log::info("New marketing sell has been request. amount = ".$order['amount']);
        }
        if($superload_info[0]['status'] == 1 && $superload_info[0]['result_amount'] < $this->withdraw_limit){
            $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
            $update_result = InternalTradeSellList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);

            sleep(13);
            $this->withdraw($exchange, $superload_id);
        }
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

    public function withdraw($exchange, $superload_id){

        $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
        $withdraw_info = array();

        if(isset($superload_info[0]['trade_type']) && $superload_info[0]['trade_type'] == 1){

            $code = "BTC";
            $amount = $superload_info[0]['result_amount'];
            $internal_wallets = InternalWallet::where('chain_stack', 1)->where('wallet_type', 1)->get()->toArray();
            $address = $internal_wallets[0]['wallet_address'];
            $withdraw_detail = $exchange->withdraw($code, $amount, $address);
            \Log::info("Withdraw request has been ordered. amount = ".$amount." to ".$address);
            $withdraw_info['trade_type'] = 1;


        }else if(isset($superload_info[0]['trade_type']) && $superload_info[0]['trade_type'] == 2){
            $code = "USDT";
            $amount = $superload_info[0]['result_amount'];
            $usdt_amount = $this->getUSDTPrice($exchange, $amount);
            $internal_wallets = InternalWallet::where('chain_stack', 2)->where('wallet_type', 1)->get()->toArray();

            $address = $internal_wallets[0]['wallet_address'];
            $withdraw_detail = $exchange->withdraw($code, $usdt_amount, $address);
            \Log::info("Withdraw request has been ordered. amount = ".$usdt_amount." to ".$address);
            $withdraw_info['trade_type'] = 2;
        }
        $withdraw_info['trade_id'] = $superload_info[0]['trade_id'];
        $withdraw_info['superload_id'] = $superload_id;
        $withdraw_info['exchange_id'] = $superload_info[0]['exchange_id'];
        $withdraw_info['withdraw_order_id'] = $withdraw_detail['id'];
        $withdraw_info['manual_flag'] = 0;
        $withdraw_info['status'] = 0;
        $result = Withdraw::create($withdraw_info);
    }

    /* This function works every 3 minutes */
    public function cronHandleFunction(){
        /* 
        order_size_limit_btc => This is the order size limit that system can order at once.
        order_size_limit_usdt => This is the order size limit that system can order at once.
        */
        $order_size_limit_btc = 0.001;
        $order_size_limit_usdt = 20;

        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();

            /* retrieve exchanges whether deposit transaction has been completed or not */
            foreach ($result as $key => $value) {
            $exchange = $this->exchange($value);
            $usdt_deposit_history = $exchange->fetchDeposits("USDT");
            foreach ($usdt_deposit_history as $key => $deposit_value) {
                # code...
                /* If deposit transaction has been completed, take a place next logic. */
                if($deposit_value['status'] == 'ok'){
                    if(isset($deposit_value['txid'])){
                        $database_status_of_superload = SuperLoad::where('tx_id', $deposit_value['txid'])->get()->toArray();

                        /* If there remains unordered amount, request order till left amount is zero */
                        if(count($database_status_of_superload) != 0 && $database_status_of_superload[0]['left_amount'] > 0 && $database_status_of_superload[0]['status'] == 0){
                            /* If remains amount is less than 15 usdt. */
                            if($database_status_of_superload[0]['left_amount'] - $order_size_limit_usdt < 15){
                                $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['left_amount' => 0,'status' => 1]);
                                $this->marketBuyOrder($exchange, $database_status_of_superload[0]['left_amount'], $database_status_of_superload[0]['id']);
                                \Log::info("Deposit transaction of ".$deposit_value['txid']." has been confirmed from ".$value['ex_name']);
                            }else if($database_status_of_superload[0]['left_amount'] > $order_size_limit_usdt){
                                $this->marketBuyOrder($exchange, $order_size_limit_usdt, $database_status_of_superload[0]['id']);
                                $remain_amount = $database_status_of_superload[0]['left_amount'] - $order_size_limit_usdt;
                                SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['left_amount' => $remain_amount]);
                            }else{
                                /* If all money has been ordered, update status. */
                                $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['left_amount' => 0,'status' => 1]);
                                $this->marketBuyOrder($exchange, $database_status_of_superload[0]['left_amount'], $database_status_of_superload[0]['id']);
                                \Log::info("Deposit transaction of ".$deposit_value['txid']." has been confirmed from ".$value['ex_name']);
                            }
                        }
                    }
                }
            }
            $btc_deposit_history = $exchange->fetchDeposits("BTC");
            foreach ($btc_deposit_history as $key => $deposit_value) {
                # code...
                /* If deposit transaction has been completed, take a place next logic. */
                if($deposit_value['status'] == 'ok'){
                    if(isset($deposit_value['txid'])){
                        $database_status_of_superload = SuperLoad::where('tx_id', $deposit_value['txid'])->get()->toArray();

                        /* If there remains unordered amount, request order till left amount is zero */
                        if(count($database_status_of_superload) != 0 && $database_status_of_superload[0]['left_amount'] > 0 && $database_status_of_superload[0]['status'] == 0){
                            /* If remains amount is less than 0.001 btc. */
                            if($database_status_of_superload[0]['left_amount'] - $order_size_limit_btc < 0.001){
                                $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['left_amount' => 0,'status' => 1]);
                                $this->marketSellOrder($exchange, $database_status_of_superload[0]['left_amount'], $database_status_of_superload[0]['id']);
                                \Log::info("Deposit transaction of ".$deposit_value['txid']." has been confirmed from ".$value['ex_name']);
                           
                            }else if($database_status_of_superload[0]['left_amount'] > $order_size_limit_btc){
                                $this->marketSellOrder($exchange, $order_size_limit_btc, $database_status_of_superload[0]['id']);
                                $remain_amount = $database_status_of_superload[0]['left_amount'] - $order_size_limit_btc;
                                SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['left_amount' => $remain_amount]);
                            }else{
                                /* If all money has been ordered, update status. */
                                $update_superload_result = SuperLoad::where('id', $database_status_of_superload[0]['id'])->update(['left_amount' => 0,'status' => 1]);
                                $this->marketSellOrder($exchange, $database_status_of_superload[0]['left_amount'], $database_status_of_superload[0]['id']);
                                \Log::info("Deposit transaction of ".$deposit_value['txid']." has been confirmed from ".$value['ex_name']);
                            }
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
                    \Log::info("DEBUG-----------------------------------------------");
                    $this->lastStep($asset, $value, $confirm_result['withdraw_transaction']);
                }
            }else{
                $asset = "USDT";
                $confirm_result = $this->confirmWithdrawTransaction($asset, $value);
                if($confirm_result['success']){
                    \Log::info("DEBUG-----------------------------------------------");
                    $this->lastStep($asset, $value, $confirm_result['withdraw_transaction']);
                }
            }
        }
    }
    public function handleSendFee($trade_info, $amount, $trade_type){
        $user_info = User::where('id', $trade_info['user_id'])->get()->toArray();
        $marketing_info = MarketingCampain::where('id', $user_info[0]['marketing_campain_id'])->get()->toArray();

        $fee_amount = round($amount/100*$marketing_info[0]['total_fee'],6);
        $remain_amount = $amount - $fee_amount;

        if($trade_type == 1){
            $marketing_fee_wallets = MarketingFeeWallet::where('fee_type', 1)->where('chain_net', 1)->get()->toArray();
            $send_result = $this->sendBTC($marketing_fee_wallets[0]['wallet_address'], $fee_amount);
            \Log::info("Total Fee (".$fee_amount."BTC)has been sent to " . $marketing_fee_wallets[0]['wallet_address']);

            $tx_id =  $send_result['txid'];
            $chain_net = 1;
        }else{
            $marketing_fee_wallets = MarketingFeeWallet::where('fee_type', 1)->where('chain_net', 2)->get()->toArray();

            $internal_wallet_info = InternalWallet::where('wallet_type',1)->where('chain_stack',2)->get()->toArray();
            $private_key = base64_decode($internal_wallet_info[0]['private_key']);
            $address = $internal_wallet_info[0]['wallet_address'];

            $send_usdt_result = $this->sendUSDT($address, $private_key , $marketing_fee_wallets[0]['wallet_address'], $fee_amount);
            \Log::info("Total Fee (".$fee_amount."USDT)has been sent to " . $marketing_fee_wallets[0]['wallet_address']);

            $tx_id = $send_usdt_result[1];
            $chain_net = 2;
        }
        $transaction_history = array();
        $transaction_history['fee_type'] = 1;
        $transaction_history['chain_net'] = $chain_net;
        $transaction_history['amount'] = $fee_amount;
        $transaction_history['tx_id'] = $tx_id;
        $transaction_history['user_id'] = $trade_info['user_id'];

        $transaction_create_result = SendFeeTransaction::create($transaction_history);
        if($transaction_create_result->id > 0){
            $return_status = true;
        }else{
            $return_status = false;
        }

        return (['status' => $return_status, 'remain_amount' => $remain_amount]);
    }
    public function lastStep($asset, $withdraw_tbl, $withdraw_transaction){
        $update_withdraw_tbl_result = Withdraw::where('id', $withdraw_tbl['id'])->update(['status' => 1]);
        $subload_info = array();
        
        if($asset == 'BTC'){
            $trade_info = InternalTradeBuyList::where('id', $withdraw_tbl['trade_id'])->get()->toArray();
            $sending_fee_result = $this->handleSendFee($trade_info[0], $withdraw_transaction['amount'], 1);
            if($sending_fee_result['status']){
                sleep(25);
                $send_result = $this->sendBTC($trade_info[0]['delivered_address'], $sending_fee_result['remain_amount']);
                $subload_info['tx_id'] = $send_result['txid'];
                \Log::info("Complete one subload of buy transaction");
            }
        }else if($asset == 'USDT'){
            $trade_info = InternalTradeSellList::where('id', $withdraw_tbl['trade_id'])->get()->toArray();
            $sending_fee_result = $this->handleSendFee($trade_info[0], $withdraw_transaction['amount'], 2);
            if($sending_fee_result['status']){
                sleep(25);
                $internal_wallet_info = InternalWallet::where('wallet_type',1)->where('chain_stack',2)->get()->toArray();
                $private_key = base64_decode($internal_wallet_info[0]['private_key']);
                $address = $internal_wallet_info[0]['wallet_address'];
                $send_usdt_result = $this->sendUSDT($address, $private_key, $trade_info[0]['delivered_address'],  $sending_fee_result['remain_amount']);
                $subload_info['tx_id'] = $send_usdt_result[1];
                \Log::info("Complete one subload of buy transaction");
            }
        }
        $subload_info['trade_type']         = $withdraw_tbl['trade_type'];
        $subload_info['trade_id']           = $withdraw_tbl['trade_id'];
        $subload_info['superload_id']       = $withdraw_tbl['superload_id'];
        $subload_info['exchange_id']        = $withdraw_tbl['exchange_id'];
        $subload_info['receive_address']    = $withdraw_transaction['addressTo'];
        $subload_info['amount']             = $withdraw_transaction['amount'];
        $subload_info['withdraw_order_id']  = $withdraw_transaction['id'];
        $subload_info['status']             = 1;
        $subload_create_result = SubLoad::create($subload_info);
        sleep(20);
    }

    public function confirmWithdrawTransaction($asset, $value){
        $exchange_info = ExchangeInfo::where('id', $value['exchange_id'])->get()->toArray();
        $exchange = $this->exchange($exchange_info[0]);
        $withdraw_transaction_history = $exchange->fetchWithdrawals($asset);

        $return = false;
        $transaction = array();

        foreach ($withdraw_transaction_history as $key => $history_value) {
            # code...
            if($value['manual_flag'] == 0){
                if($history_value['id'] == $value['withdraw_order_id'] && $history_value['status'] == 'ok'){

                    \Log::info("Withdarw request has been confirmed from ".$exchange_info[0]['ex_name']."!");
                    $return = true;
                    $transaction = $history_value;
                    break;
                }
            }else if($value['manual_flag'] == 1){
                if($history_value['txid'] == $value['withdraw_order_id'] && $history_value['status'] == 'ok'){

                    \Log::info("Withdarw request has been confirmed from ".$exchange_info[0]['ex_name']."!");
                    $return = true;
                    $transaction = $history_value;
                    break;
                }
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

    public function sendUSDT($from, $from_pk, $to, $amount){
        $amount_big = $amount*1000000;
        exec('node C:\NeilLab\app\Http\Controllers\Admin\USDTSendServer\sendUSDT.js ' .$from.' '.$from_pk. ' '.$to.' '.$amount_big, $output);
        return $output;
    }

}