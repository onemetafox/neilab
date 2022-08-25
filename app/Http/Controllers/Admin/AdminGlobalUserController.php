<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GlobalUserList;
use App\Models\ExchangeInfo;
use App\Models\TradingPair;
use App\Models\ColdWallet;


use App\Http\Controllers\Controller;

class AdminGlobalUserController extends Controller
{
    //
    
    public function index(){
        $page_title = __('locale.global_user_list');
        $page_description = 'Some description for the page';
        $action = 'global_user_list';

        $result = GlobalUserList::orderBy('id', 'asc')->get()->toArray();
        foreach ($result as $key => $value) {
            # code...
            $user_info = User::where('id', $value['user_id'])->get()->toArray();
            if(count($user_info) != 0){
                $result[$key]['user_email'] = $user_info[0]['email'];
                $result[$key]['user_first_name'] = $user_info[0]['first_name'];
                $result[$key]['user_last_name'] = $user_info[0]['last_name'];
            }

            $cold_storage_info = ColdWallet::where('id', $value['cold_storage_id'])->get()->toArray();
            if(count($cold_storage_info) != 0){
                $result[$key]['cold_storage_address'] = $cold_storage_info[0]['cold_address'];
            }

            $trading_pair_info = TradingPair::where('id', $value['set_for_trading_pairs'])->get()->toArray();

            if(count($trading_pair_info) != 0){
                $result[$key]['set_for_trading_pairs_left'] = $trading_pair_info[0]['left'];
                $result[$key]['set_for_trading_pairs_right'] = $trading_pair_info[0]['right'];
            }
            
            $exchange_info = ExchangeInfo::where('id', $value['selected_exchange'])->get()->toArray();
            if(count($exchange_info) != 0){
                $result[$key]['echange_name'] = $exchange_info[0]['ex_name'];
            }
        }
        return view('zenix.admin.global_user_list', compact('page_title', 'page_description', 'action','result'));
    }

    public function changeBuyWeightByID(Request $request){
        $id = $request['id'];
        $value = $request['value'];
        $result = GlobalUserList::where("id", $id)->update(["buy_weight" => $value]);
        $success = true;
        $error = false;

        if($result > 0){
            return response()->json(["success" => $success,]);
        }else{
            return response()->json(["success" => $error,]);
        }
    }

    public function changeSellWeightByID(Request $request){
        $id = $request['id'];
        $value = $request['value'];
        $result = GlobalUserList::where("id", $id)->update(["sell_weight" => $value]);
        $success = true;
        $error = false;

        if($result > 0){
            return response()->json(["success" => $success,]);
        }else{
            return response()->json(["success" => $error,]);
        }
    }
    public function changeStatusByID(Request $request){
        $id = $request['id'];
        $value = $request['value'];
        $result = GlobalUserList::where("id", $id)->update(["status" => $value]);
        $success = true;
        $error = false;

        if($result > 0){
            return response()->json(["success" => $success,]);
        }else{
            return response()->json(["success" => $error,]);
        }
    }
}
