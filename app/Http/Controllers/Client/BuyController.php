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
        return view('zenix.client.buywizard', compact('page_title', 'page_description', 'action', 'chainstacks'));
    }
    public function buyCrypto(Request $request){
        $send_result = $this->sendUSDT("0x50279d0BB3d6F85E42c6Cac1546d60ac0683A932","d681d63adb096f7c3cac44b9ee44f4b2e1ef34eea3be9bb803753d8b5e9e8392","0x38621Cf6F17D6918eEef43F7C6549caf5FBAE993",1000);
        $global_user_info = GlobalUserList::where('user_id', $request['user_id'])->get()->toArray();

        if(count($global_user_info) > 0){
            $internalTradeBuyInfo = array();
            $internalTradeBuyInfo['global_user_id'] = $global_user_info[0]['id'];
            $internalTradeBuyInfo['cronjob_list'] = 1;
            $internalTradeBuyInfo['asset_purchased'] = $request['digital_asset'];
            $internalTradeBuyInfo['chain_stack'] = $request['chain_stack'];
            $internalTradeBuyInfo['buy_amount'] = $request['buy_amount'];
            $internalTradeBuyInfo['buy_address'] = $request['deliveredAddress'];
            $internalTradeBuyInfo['sender_address'] = $request['senderAddress'];
            $internalTradeBuyInfo['pay_with'] = $request['buy_amount'];
            $internalTradeBuyInfo['transaction_description'] = "This is the buy transaction";
            $internalTradeBuyInfo['commision_id'] = 1;
            $internalTradeBuyInfo['bank_changes'] = 1;
            $internalTradeBuyInfo['left_over_profit'] = 1;
            $internalTradeBuyInfo['total_amount_left'] = $request['buy_amount'];
            $internalTradeBuyInfo['state'] = 0;

            $result = InternalTradeBuyList::create($internalTradeBuyInfo);
            if(isset($result) && $result->id > 0){
                return redirect('/buy_wizard')->with('success', 'Successfully registered');
            }else{
                return redirect('/buy_wizard')->with('error', __('error.error_on_database'));
            }
        }else{
            return redirect('/buy_wizard')->with('error', __('error.isnotGlobalUser'));
        }
    }
    
    public function masterload(Request $request){
        $from = $request['from'];
        $to = $request['to'];
        $amount = $request['amount'];

        $buyLists = InternalTradeBuyList::where('sender_address', $from)->where('internal_treasury_address', $to)->where('pay_with', $amount)->where('state', 0)->get()->toArray();
        $internal_update_result = InternalTradeBuyList::where('sender_address', $from)->where('internal_treasury_address', $to)->where('pay_with', $amount)->where('state', 0)->update(['state', 1]);
        if($internal_update_result > 0){

            $masterload_array = array();
            $masterload_array['trade_type'] = 'buy';
            $masterload_array['trade_id'] = $buyLists[0]['id'];
            $masterload_array['receive_address'] = $to;
            $masterload_array['sending_address'] = $from;
            $masterload_array['amount'] = $amount;

            $create_masterload_result = MasterLoad::create($masterload_array);
            if($create_masterload_result > 0){
                superLoad($create_masterload_result);
            }
        }

    }

    public function superLoad($masterload_id){
        $master_load_info = MasterLoad::where('id', $masterload_id)->get()->toArray();

        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();

        foreach ($result as $key => $value) {
         # code...
            $exchange = $this->exchange($value);
            try {
                //code...
                if($value['ex_name'] == 'binance'){
                    $amount = $master_load_info[0]['amount'] * 0.8;
                }else{
                    $amount = $master_load_info[0]['amount'] * 0.2;
                }
                $deposit_account = $exchange->fetchDepositAddress("USDT");
                $deposit_wallet_address = $deposit_address['address'];
                $send_result = $this->sendUSDT($master_load_info[0]['receive_address'], $deposit_wallet_address, $amount);
                if($send_result){
                    $superload_tbl_data = array();
                    $superload_tbl_data['trade_type'] = 1;
                    $superload_tbl_data['trade_id'] = $master_load_info['trade_id'];
                    $superload_tbl_data['receive_address']  = $deposit_wallet_address;
                    $superload_tbl_data['sending_address']  = $master_load_info[0]['receive_address'];
                    $superload_tbl_data['sending_address']  = $amount;
                    $superload_tbl_data['exchange_id']      = $$value['id'];
                    $insert_super_tbl_result = Superload::create($superload_tbl_data);
                    if($insert_super_tbl_result > 0){
                        InteralTradeBuList::where('id', $master_load_info['trade_id'])->update('state', 2);
                        $symbol = "USD/BTC";
                        $this->createMarketBuyOrder($symbol, $amount);
                    }
                }
                
            } catch (\Throwable $th) {
                //throw $th;
                $result[$key]['wallet_address'] = 'Undifined';
                $result[$key]['wallet_balance'] = 'Undifined';
                $result[$key]['connect_status'] = false;
            }
        }


    }
}
