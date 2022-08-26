<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GlobalUserList;
use App\Models\ExchangeInfo;
use App\Models\TradingPair;
use App\Models\ColdWallet;
use App\Models\MarketingCampain;

use App\Http\Controllers\Controller;

class AdminMarketingCampainController extends Controller
{
    //
    
    public function index(){
        $page_title = __('locale.marketing_campain');
        $page_description = 'Some description for the page';
        $action = 'marketing_campain';
        $result = MarketingCampain::orderBy('id', 'asc')->get()->toArray();
        return view('zenix.admin.marketing_campain', compact('page_title', 'page_description', 'action', 'result'));
    }
    public function changeMarketingCampainStatusByID(Request $request){
        $id = $request['id'];
        $value = $request['value'];
        $result = MarketingCampain::where("id", $id)->update(["status" => $value]);
        $success = true;
        $error = false;

        if($result > 0){
            return response()->json(["success" => $success,]);
        }else{
            return response()->json(["success" => $error,]);
        }
    }

    public function viewCamapinByID($id = null){
        $page_title = __('locale.marketing_campain_view');
        $page_description = 'Some description for the page';
        $action = 'marketing_campain';

        $result = MarketingCampain::where('id', $id)->get()->toArray();

        return view('zenix.admin.marketing_campain_view', compact('page_title', 'page_description', 'action', 'result'));
    }
    
}
