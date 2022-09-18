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
            $internalTradeBuyInfo = array();
            $internalTradeBuyInfo['global_user_id']                 = $global_user_info[0]['id'];
            $internalTradeBuyInfo['cronjob_list']                   = 1;
            $internalTradeBuyInfo['asset_purchased']                = $request['digital_asset'];
            $internalTradeBuyInfo['chain_stack']                    = $request['chain_stack'];
            $internalTradeBuyInfo['sell_amount']                    = $request['sell_amount'];
            $internalTradeBuyInfo['delivered_address']              = $request['delivered_address'];
            $internalTradeBuyInfo['sender_address']                 = $request['sender_address'];
            $internalTradeBuyInfo['internal_treasury_wallet_id']    = $internal_treasury_wallet_info[0]['id'];
            $internalTradeBuyInfo['pay_with']                       = $request['pay_with'];
            $internalTradeBuyInfo['transaction_description']        = "This is the buy transaction";
            $internalTradeBuyInfo['commision_id']                   = 1;
            $internalTradeBuyInfo['bank_changes']                   = 1;
            $internalTradeBuyInfo['left_over_profit']               = 1;
            $internalTradeBuyInfo['total_amount_left']              = $request['sell_amount'];
            $internalTradeBuyInfo['state']                          = 0;

            $result = InternalTradeSellList::create($internalTradeBuyInfo);

            if(isset($result) && $result->id > 0){
                return response()->json(["success" => $success,]);
            }else{
                return response()->json(["success" => $error,]);
            }
        }else{
            return response()->json(["success" => $error,]);
        }
    }
}
