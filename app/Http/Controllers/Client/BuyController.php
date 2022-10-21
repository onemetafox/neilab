<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalTradeBuyList;
use App\Models\GlobalUserList;
use App\Models\ChainStack;
use Illuminate\Support\Arr;
use App\Models\MasterLoad;
use App\Models\SuperLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalWallet;


class BuyController extends Controller
{
    //
    
    

    public function index()
    {
        $page_title = __('locale.buy_wizard');
        $page_description = 'Some description for the page';
        $action = 'wizard';
        $chainstack_info = ChainStack::orderBy('id', 'asc')->get()->toArray();
        $chainstacks = Arr::except($chainstack_info,['0']);
        
        $internal_ethereum_wallet_list = InternalWallet::where('chain_stack', 2)->where('wallet_type', 1)->get()->toArray();

        $ethereum_wallet = $internal_ethereum_wallet_list[0]['wallet_address'];
        $theme_mode = $this->getThemeMode();

        return view('zenix.client.buywizard', compact('page_title', 'page_description', 'action', 'chainstacks', 'ethereum_wallet', 'theme_mode'));
    }

    public function buyCrypto(Request $request){


        $success    = true;
        $error      = false;

        $internal_treasury_wallet_info = InternalWallet::where('wallet_address', $request['receive_address'])->get()->toArray();

        $transaction_status = $this->checkTransaction($request['sender_address'], $request['receive_address'], $request['pay_with'], $request['tx_id']);
        
        if(isset($transaction_status[0]) && $transaction_status[0] == true){
            $internalTradeBuyInfo = array();
            $internalTradeBuyInfo['user_id']                        = $request['user_id'];
            $internalTradeBuyInfo['cronjob_list']                   = 1;
            $internalTradeBuyInfo['asset_purchased']                = $request['digital_asset'];
            $internalTradeBuyInfo['chain_stack']                    = $request['chain_stack'];
            $internalTradeBuyInfo['buy_amount']                     = $request['buy_amount'];
            $internalTradeBuyInfo['delivered_address']              = $request['delivered_address'];
            $internalTradeBuyInfo['sender_address']                 = $request['sender_address'];
            $internalTradeBuyInfo['internal_treasury_wallet_id']    = $internal_treasury_wallet_info[0]['id'];
            $internalTradeBuyInfo['pay_with']                       = $request['pay_with'];
            $internalTradeBuyInfo['pay_method']                     = $request['pay_method'];
            $internalTradeBuyInfo['transaction_description']        = "This is the buy transaction";
            $internalTradeBuyInfo['commision_id']                   = 1;
            $internalTradeBuyInfo['bank_changes']                   = 1;
            $internalTradeBuyInfo['left_over_profit']               = 1;
            $internalTradeBuyInfo['total_amount_left']              = $request['buy_amount'];
            $internalTradeBuyInfo['state']                          = 0;

            $result = InternalTradeBuyList::create($internalTradeBuyInfo);

            if(isset($result) && $result->id > 0){

                $masterload_array = array();
                $masterload_array['trade_type'] = 1;
                $masterload_array['trade_id'] = $result->id;
                $masterload_array['internal_treasury_wallet_id'] = $internal_treasury_wallet_info[0]['id'];
                $masterload_array['sending_address'] = $request['sender_address'];
                $masterload_array['amount'] = $request['pay_with'];
                $masterload_array['tx_id'] = $request['tx_id'];
    
                $create_masterload_result = MasterLoad::create($masterload_array);
                if(isset($create_masterload_result) && $create_masterload_result->id > 0){
    
                    $this->superload_v($create_masterload_result->id);
    
                }else{
                    return response()->json(["success" => $error,"msg" => "Masterload error"]);
                }
            }else{
                return response()->json(["success" => $error,"msg" => "Order error"]);
            }
        }


    }
    
    public function superload_v($masterload_id){
        
        $master_load_info = MasterLoad::where('id', $masterload_id)->get()->toArray();
        $internal_treasury_wallet_info = InternalWallet::where('id', $master_load_info[0]['internal_treasury_wallet_id'])->get()->toArray();

        $amount_result = $this->getAmountBinanceFTX($master_load_info[0]['amount']);

        if(count($amount_result['exchange_available_accounts']) > 0){

            foreach ($amount_result['exchange_available_accounts'] as $value) {
                # code...
                try {
                    //code...
                    $exchange_info = ExchangeInfo::where('id', $value)->get()->toArray();
                    $exchange = $this->exchange($exchange_info[0]);
    
                    $deposit_account = $exchange->fetchDepositAddress("USDT");
                    $deposit_wallet_address = $deposit_account['address'];
                    if($exchange_info[0]['ex_name'] == 'Binance'){
                        $amount = round($amount_result['binance_deposite_amount'], 6);
                    }else{
                        $amount = round($amount_result['ftx_deposite_amount'], 6);
                    }
                    $private_key = base64_decode($internal_treasury_wallet_info[0]['private_key']);
                    $send_result = $this->sendUSDT($internal_treasury_wallet_info[0]['wallet_address'],$private_key, $deposit_wallet_address, $amount);
            
                    \Log::info("send ".$amount."usdt from ".$internal_treasury_wallet_info[0]['wallet_address']."to ".$deposit_wallet_address);
            
                    sleep(25);
                    if(!empty($send_result)){
                        $superload_tbl_data = array();
                        $superload_tbl_data['trade_type']                   = 1;
                        $superload_tbl_data['trade_id']                     = $master_load_info[0]['trade_id'];
                        $superload_tbl_data['masterload_id']                = $masterload_id;
                        $superload_tbl_data['receive_address']              = $deposit_wallet_address;
                        $superload_tbl_data['sending_address']              = $internal_treasury_wallet_info[0]['wallet_address'];
                        $superload_tbl_data['tx_id']                        = $send_result[1];
                        $superload_tbl_data['internal_treasury_wallet_id']  = $internal_treasury_wallet_info[0]['id'];
                        $superload_tbl_data['amount']                       = $amount;
                        $superload_tbl_data['left_amount']                  = $amount;
                        $superload_tbl_data['result_amount']                = 0;
                        $superload_tbl_data['exchange_id']                  = $value;
                        $superload_tbl_data['status']                       = 0;
                        
                        $insert_super_tbl_result = SuperLoad::create($superload_tbl_data);
                        if(isset($insert_super_tbl_result) && $insert_super_tbl_result->id > 0){
                            $update_result = InternalTradeBuyList::where('id', $master_load_info[0]['trade_id'])->update(['state' => 2]);
                        }
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                    \Log::info("One superload has been failed. because ".$th->getMessage());
                }
            }
        }
    }
}
