<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InternalTradeSellList;
use App\Models\InternalTradeBuyList;
use App\Models\GlobalUserList;
use App\Models\ChainStack;

use Illuminate\Support\Arr;

use App\Models\MasterLoad;
use App\Models\SuperLoad;
use App\Models\SubLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalWallet;
use App\Models\User;
use Auth;
use App\Models\Withdraw;

use Illuminate\Support\Facades\DB;

class AdminManualWithdrawController extends Controller
{
    //
    public function __construct()
    {
        $this->withdraw_limit = config('app.withdraw_limit');

    }
    public function index(){
        $page_title = __('locale.manual_withdraw');
        $page_description = 'Some description for the page';
        $action = 'manual_withdraw';

        $superloads_info = SuperLoad::where('status', 1)->where('result_amount', '>', $this->withdraw_limit)->get()->toArray();
        foreach ($superloads_info as $key => $value) {
            # code...
            if($value['trade_type'] == 1){
                $trade_info = InternalTradeBuyList::where('id', $value['trade_id'])->get()->toArray();
                $user_info = User::where('id', $trade_info[0]['user_id'])->get()->toArray();
                $superloads_info[$key]['email'] = $user_info[0]['email'];
                $superloads_info[$key]['username'] = $user_info[0]['first_name'] . $user_info[0]['last_name'];

            }else{
                $trade_info = InternalTradeSellList::where('id', $value['trade_id'])->get()->toArray();
                $user_info = User::where('id', $trade_info[0]['user_id'])->get()->toArray();
                $superloads_info[$key]['email'] = $user_info[0]['email'];
                $superloads_info[$key]['username'] = $user_info[0]['first_name'] . $user_info[0]['last_name'];

                $exchange_info = ExchangeInfo::where('id', $value['exchange_id'])->get()->toArray();
                $exchange = $this->exchange($exchange_info[0]);
                $superloads_info[$key]['result_amount'] = $this->getUSDTPrice($exchange, $superloads_info[$key]['result_amount']);
            }
            $exchange_info = ExchangeInfo::where('id', $value['exchange_id'])->get()->toArray();
            $superloads_info[$key]['exchange_name'] = $exchange_info[0]['ex_name'];
        }
        return view('zenix.admin.manual_withdraw', compact('page_title', 'page_description', 'action', 'superloads_info'));

    }

    public function registerWithdraw(Request $request){
        $superload_id = $request['superload_id'];
        $tx_id = $request['tx_id'];

        $success = true;
        $error = false;

        $withdraw_tx_history = Withdraw::find($tx_id);
        if(isset($withdraw_tx_history->id) && $withdraw_tx_history->id > 0){
            return response()->json(["success" => $error, "msg" => "This transaction has already been used before."]);
        }else{


            $superload_info = SuperLoad::where('id', $superload_id)->get()->toArray();
            
            $update_superload_result = SuperLoad::where('id', $superload_id)->update(['status' => 2]);
            if($superload_info[0]['trade_type'] == 1){
                $update_result = InternalTradeBuyList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);
            }else{
                $update_result = InternalTradeSellList::where('id', $superload_info[0]['trade_id'])->update(['state' => 3]);
            }

            $withdraw_info = array();
            $withdraw_info['trade_type'] = $superload_info[0]['trade_type'];
            $withdraw_info['trade_id'] = $superload_info[0]['trade_id'];
            $withdraw_info['superload_id'] = $superload_id;
            $withdraw_info['exchange_id'] = $superload_info[0]['exchange_id'];
            $withdraw_info['withdraw_order_id'] = $tx_id;
            $withdraw_info['manual_flag'] = 1;
            $withdraw_info['status'] = 0;
            $result = Withdraw::create($withdraw_info);

            if($result->id > 0){
                return response()->json(["success" => $success]);
            }else{
                return response()->json(["success" => $error, "msg" => "Database Error"]);
            }
        }
    }
}
