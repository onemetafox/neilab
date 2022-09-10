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

        $global_user_info = GlobalUserList::where('user_id', $request['user_id'])->get()->toArray();

        if(count($global_user_info) > 0){
            $internalTradeBuyInfo = array();
            $internalTradeBuyInfo['global_user_id'] = $global_user_info[0]['id'];
            $internalTradeBuyInfo['cronjob_list'] = 1;
            $internalTradeBuyInfo['asset_purchased'] = $request['digital_asset'];
            $internalTradeBuyInfo['chain_stack'] = $request['chain_stack'];
            $internalTradeBuyInfo['buy_amount'] = $request['buy_amount'];
            $internalTradeBuyInfo['buy_address'] = $request['deliveredAddress'];
            $internalTradeBuyInfo['sending_address'] = $request['sendingAddress'];
            $internalTradeBuyInfo['pay_with'] = $request['pay_amount'];
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
                        $this->createMarketBuyOrder($amount);
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
