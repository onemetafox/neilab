<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalTradeSellList;
use App\Models\GlobalUserList;
use App\Models\ChainStack;
use Illuminate\Support\Arr;
use App\Models\MasterLoad;
use App\Models\SuperLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalWallet;

class SellController extends Controller
{
    //
    private $RPCusername = 'lam';
    private $RPCpassword = 'Masterskills113';

    public function index()
    {
        $page_title = __('locale.sell_wizard');
        $page_description = 'Some description for the page';
        $action = 'wizard';

        $chainstacks = ChainStack::orderBy('id', 'asc')->get()->toArray();
                
        $internal_bitcoin_wallet_list = InternalWallet::where('chain_stack', 1)->get()->toArray();

        $bitcoin_wallet = $internal_bitcoin_wallet_list[0]['wallet_address'];

        return view('zenix.client.sellwizard', compact('page_title', 'page_description', 'action', 'bitcoin_wallet', 'chainstacks'));
    }

    public function sellCrypto(Request $request){
        $success    = true;
        $error      = false;

        $global_user_info = GlobalUserList::where('user_id', $request['user_id'])->get()->toArray();

        $internal_treasury_wallet_info = InternalWallet::where('wallet_address', $request['receive_address'])->get()->toArray();

        if(count($global_user_info) > 0){
            $internalTradeSellInfo = array();
            $internalTradeSellInfo['global_user_id']                 = $global_user_info[0]['id'];
            $internalTradeSellInfo['cronjob_list']                   = 1;
            $internalTradeSellInfo['asset_purchased']                = $request['digital_asset'];
            $internalTradeSellInfo['chain_stack']                    = $request['chain_stack'];
            $internalTradeSellInfo['sell_amount']                    = $request['sell_amount'];
            $internalTradeSellInfo['delivered_address']              = $request['delivered_address'];
            $internalTradeSellInfo['sender_address']                 = $request['sender_address'];
            $internalTradeSellInfo['internal_treasury_wallet_id']    = $internal_treasury_wallet_info[0]['id'];
            $internalTradeSellInfo['pay_with']                       = $request['pay_with'];
            $internalTradeSellInfo['transaction_description']        = "This is the sell transaction";
            $internalTradeSellInfo['commision_id']                   = 1;
            $internalTradeSellInfo['bank_changes']                   = 1;
            $internalTradeSellInfo['left_over_profit']               = 1;
            $internalTradeSellInfo['total_amount_left']              = $request['sell_amount'];
            $internalTradeSellInfo['tx_id']                          = $request['tx_id'];
            $internalTradeSellInfo['state']                          = 0;

            $result = InternalTradeSellList::create($internalTradeSellInfo);

            if(isset($result) && $result->id > 0){
                return response()->json(["success" => $success,]);
            }else{
                return response()->json(["success" => $error,]);
            }
        }
    }

    public function masterload($request){
        $success    = true;
        $error      = false;

        $from = $request['sender_address'];
        $to = $request['toAddress'];
        $amount = $request['amount'];
        $tx_id = $request['tx_id'];

        $internal_treasury_wallet_info = InternalWallet::where('wallet_address',$to)->get()->toArray();

        $internal_treasury_wallet_id = $internal_treasury_wallet_info[0]['id'];

        $sellLists = InternalTradeSellList::where('sender_address', $from)->where('internal_treasury_wallet_id', $internal_treasury_wallet_id)->where('pay_with', $amount)->where('state', 1)->get()->toArray();
        
        // $internal_update_result = InternalTradeSellList::where('id', $sellLists[0]['id'])->update(['state' => 1]);

        // if($internal_update_result > 0){

        $masterload_array = array();
        $masterload_array['trade_type'] = 2;
        $masterload_array['trade_id'] = $sellLists[0]['id'];
        $masterload_array['internal_treasury_wallet_id'] = $internal_treasury_wallet_id;
        $masterload_array['sending_address'] = $from;
        $masterload_array['amount'] = $amount;
        $masterload_array['tx_id'] = $tx_id;

        $create_masterload_result = MasterLoad::create($masterload_array);
        if(isset($create_masterload_result) && $create_masterload_result->id > 0){

            return ["success" => $success, "master_load_id" => $create_masterload_result->id];

        }else{
            return ["success" => $error,];
        }

        // }

    }

    
    public function superload_v($master_load_id_param){

        $success = true;
        $error   = false;
        
        $masterload_id = $master_load_id_param;
        $master_load_info = MasterLoad::where('id', $masterload_id)->get()->toArray();
        $internal_treasury_wallet_info = InternalWallet::where('id', $master_load_info[0]['internal_treasury_wallet_id'])->get()->toArray();
        
        $binance_account_result = ExchangeInfo::where('ex_name', 'Binance')->get()->toArray();
        $total_amount_for_binance = $master_load_info[0]['amount'] * 0.9;
        $deposit_amount_for_binance = $total_amount_for_binance / count($binance_account_result);

        $ftx_account_result = ExchangeInfo::where('ex_name', 'FTX')->get()->toArray();
        $total_amount_for_ftx = $master_load_info[0]['amount'] * 0.1;
        $deposit_amount_for_ftx = $total_amount_for_ftx / count($ftx_account_result);

        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();
        
        foreach ($result as $key => $value) {
            # code...
            try {
                //code...
                $exchange = $this->exchange($value);
                
                $deposit_account = $exchange->fetchDepositAddress("BTC");
                $deposit_wallet_address = $deposit_account['address'];
                if($value['ex_name'] == 'Binance'){
                    $amount = $deposit_amount_for_binance;
                }else{
                    $amount = $deposit_amount_for_ftx;
                }

                $send_result = $this->sendBTC($deposit_wallet_address, $amount);

                sleep(10);

                if($send_result['status'] == 'success'){
                    $superload_tbl_data = array();
                    $superload_tbl_data['trade_type']                   = 2;
                    $superload_tbl_data['trade_id']                     = $master_load_info[0]['trade_id'];
                    $superload_tbl_data['masterload_id']                = $masterload_id;
                    $superload_tbl_data['receive_address']              = $deposit_wallet_address;
                    $superload_tbl_data['sending_address']              = $internal_treasury_wallet_info[0]['wallet_address'];
                    $superload_tbl_data['tx_id']                        = $send_result['txid'];
                    $superload_tbl_data['internal_treasury_wallet_id']  = $internal_treasury_wallet_info[0]['id'];
                    $superload_tbl_data['amount']                       = $amount;
                    $superload_tbl_data['exchange_id']                  = $value['id'];
                    $superload_tbl_data['status']                       = 0;
                    
                    $insert_super_tbl_result = SuperLoad::create($superload_tbl_data);
                    if(isset($insert_super_tbl_result) && $insert_super_tbl_result->id > 0){
                        $update_result = InternalTradeSellList::where('id', $master_load_info[0]['trade_id'])->update(['state' => 2]);
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                print_r($th->getMessage());
                // return response()->json(["success" => $error, "message" => $th->getMessage()]);
            }
        }
        // return response()->json(["success" => $success]);
    }

    public function get_new_btc_wallet_address () {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:7890",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->RPCusername.':'.$this->RPCpassword,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => '{"id":"curltext","method":"createnewaddress","params":[]}',
            CURLOPT_POST => 1,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return null;
        } else {
            $result = json_decode($response);
            return $result->result;
            // if(isset($result->result)){
            //     $address = $result->result;
            //     return ['status'=>'success', 'address'=>$address];
            // }else{
            //     return ['status'=>'error', 'message'=>'Could not get new address'];
            // }
        }
    }
    public function get_balance(){
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:7890",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->RPCusername.':'.$this->RPCpassword,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => '{"id":"curltext","method":"getbalance","params":[]}',
            // CURLOPT_POSTFIELDS => '{"id":"curltext","method":"listaddresses","params":["receiving"]}',
            CURLOPT_POST => 1,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['status'=>'error', 'message'=>$err];
        } else {
            $result = json_decode($response);
            dd($result);
            if(isset($result->result)){
                $k = array_rand($result->result);
                return ['status'=>'success', 'address'=>$result->result[$k]];
            }else{
                return ['status'=>'error', 'message'=>'Could not get an address'];
            }
        }
    }
    public function get_receiving_btc_address () {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:7890",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->RPCusername.':'.$this->RPCpassword,
            CURLOPT_RETURNTRANSFER => 1,
            // CURLOPT_POSTFIELDS => '{"id":"curltext","method":"getbalance","params":[]}',
            CURLOPT_POSTFIELDS => '{"id":"curltext","method":"listaddresses","params":["receiving"]}',
            CURLOPT_POST => 1,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['status'=>'error', 'message'=>$err];
        } else {
            $result = json_decode($response);
            // dd($result);
            if(isset($result->result)){
                $k = array_rand($result->result);
                return ['status'=>'success', 'address'=>$result->result[$k]];
            }else{
                return ['status'=>'error', 'message'=>'Could not get an address'];
            }
        }

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
                    if(floatval($tx->bc_value) === floatval($amount) && $tx->txid === $txid && $tx->confirmations >= 3) {
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

    public function send_BTC(){
        $to = 'bc1qskrw3qfhszl8m2l6qhaqzche762lk3g8qjhxre';
        $amount = 0.002;

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
                    echo($err1);
                    exit;
                }else{
                    $result1 = json_decode($response1);
                    if(isset($result->result)){
                        print_r($result1);
                        exit;
                    }else{
                        echo("error");
                        exit;
                    }
                }
            }else{
                return ['status'=>'error', 'message'=>$result->error->message];
            }
        }
    }

    public function cronHandleFunction(){
        \Log::info("new cron ---------------------------------------------");
        $btc_trade_lists = InternalTradeSellList::where('state', 0)->get()->toArray();

        if(count($btc_trade_lists) != 0){
            foreach ($btc_trade_lists as $key => $value) {
                # code...
                $amount = $value['pay_with'];
                $tx_id  = $value['tx_id'];

                $confirm_result = $this->confirm_btc_payment($amount, $tx_id);
                \Log::info($confirm_result);
                if($confirm_result['status'] == 'success' && $confirm_result['result'] == 'true'){
                    $internal_trade_update_result = InternalTradeSellList::where('id', $value['id'])->update(['state' => 1]);
                    $internal_treasury_wallet = InternalWallet::where('id', $value['internal_treasury_wallet_id'])->get()->toArray();
                    \Log::info("confirm payment ---------------------------------------------");
                    
                    if($internal_trade_update_result > 0){
                        $request = array();

                        $request['sender_address'] = $value['sender_address'];
                        $request['toAddress'] = $internal_treasury_wallet[0]['wallet_address'];
                        $request['amount'] = $value['pay_with'];
                        $request['tx_id'] = $value['tx_id'];

                        $master_load_result = $this->masterload($request);

                        if($master_load_result['success'] == true){
                            $this->superload_v($master_load_result['master_load_id']);
                        }
                    }
                }
            }
        }
    }
}
