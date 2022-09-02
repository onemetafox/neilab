<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalTradeBuyList;
use App\Models\GlobalUserList;


class BuyController extends Controller
{
    //
    public function index()
    {
        $page_title = __('locale.buy_wizard');
        $page_description = 'Some description for the page';
        $action = 'wizard';
        return view('zenix.client.buywizard', compact('page_title', 'page_description', 'action'));
    }
    public function buyCrypto(Request $request){

        $global_user_info = GlobalUserList::where('user_id', $request['user_id'])->get()->toArray();

        if(count($global_user_info) > 0){
            $internalTradeBuyInfo = array();
            $internalTradeBuyInfo['global_user_id'] = $global_user_info[0]['id'];
            $internalTradeBuyInfo['cronjob_list'] = 1;
            $internalTradeBuyInfo['asset_purchased'] = $request['chain_stack'];
            $internalTradeBuyInfo['chain_stack'] = $request['chain_stack'];
            $internalTradeBuyInfo['buy_amount'] = $request['buy_amount'];
            $internalTradeBuyInfo['buy_address'] = $request['deliveredAddress'];
            $internalTradeBuyInfo['pay_with'] = $request['chain_stack'];
            $internalTradeBuyInfo['transaction_description'] = "This is the buy transaction";
            $internalTradeBuyInfo['trust_fee'] = 3;
            $internalTradeBuyInfo['campain_type'] = 1;
            $internalTradeBuyInfo['profit'] = 70;
            $internalTradeBuyInfo['commision_id'] = 1;
            $internalTradeBuyInfo['fee_from_exchange'] = 1;
            $internalTradeBuyInfo['bank_changes'] = 1;
            $internalTradeBuyInfo['left_over_profit'] = 1;
            $internalTradeBuyInfo['total_amount_left'] = $request['buy_amount'];
            $internalTradeBuyInfo['master_load'] =3;

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
}
