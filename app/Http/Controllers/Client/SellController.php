<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalTradeSellList;
use App\Models\GlobalUserList;

class SellController extends Controller
{
    //
    public function index()
    {
        $page_title = __('locale.sell_wizard');
        $page_description = 'Some description for the page';
        $action = 'wizard';
        $target_address = "bc1qnw59phah4mzrpulys435pglhym92h5e7exnqez";
        return view('zenix.client.sellwizard', compact('page_title', 'page_description', 'action', 'target_address'));
    }
    public function sellCrypto(Request $request){
        

        $global_user_info = GlobalUserList::where('user_id', $request['user_id'])->get()->toArray();

        if(count($global_user_info) > 0){
            $internalTradeSellInfo = array();
            $internalTradeSellInfo['global_user_id'] = $global_user_info[0]['id'];
            $internalTradeSellInfo['cronjob_list'] = 1;
            $internalTradeSellInfo['asset_sold'] = $request['chain_stack'];
            $internalTradeSellInfo['chain_stack'] = $request['chain_stack'];
            $internalTradeSellInfo['sell_amount'] = $request['buy_amount'];
            $internalTradeSellInfo['receive_address'] = $request['deliveredAddress'];
            $internalTradeSellInfo['pay_with'] = $request['chain_stack'];
            $internalTradeSellInfo['transaction_description'] = "This is the buy transaction";
            $internalTradeSellInfo['trust_fee'] = 3;
            $internalTradeSellInfo['campain_type'] = 1;
            $internalTradeSellInfo['profit'] = 70;
            $internalTradeSellInfo['commision_id'] = 1;
            $internalTradeSellInfo['fee_from_exchange'] = 1;
            $internalTradeSellInfo['bank_changes'] = 1;
            $internalTradeSellInfo['left_over_profit'] = 1;
            $internalTradeSellInfo['total_amount_left'] = $request['buy_amount'];
            $internalTradeSellInfo['master_load'] =3;

            $result = InternalTradeSellList::create($internalTradeSellInfo);
            if(isset($result) && $result->id > 0){
                return redirect('/sell_wizard')->with('success', 'Successfully registered');
            }else{
                return redirect('/sell_wizard')->with('error', __('error.error_on_database'));
            }
        }else{
            return redirect('/sell_wizard')->with('error', __('error.isnotGlobalUser'));
        }
    }
}
