<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\InternalTradeSellList;
use App\Models\GlobalUserList;
use App\Models\ChainStack;
use Illuminate\Support\Arr;
use App\Models\MasterLoad;
use App\Models\SuperLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalWallet;
use Auth;
use Illuminate\Support\Facades\DB;

class SellReportController extends Controller
{
    //
    public function index(){

        $page_title = __('locale.sell_report');
        $page_description = 'Some description for the page';
        $action = 'report';
        
        $user_id = Auth::user()->id;

        $result = DB::table('internal_trade_sell_lists')
                ->join('global_user_lists', 'internal_trade_sell_lists.global_user_id', '=', 'global_user_lists.id')
                ->join('users', 'global_user_lists.user_id', '=', 'users.id')
                ->join('master_loads as a', 'a.trade_id', '=', 'internal_trade_sell_lists.id')
                ->join('internal_wallets as b', 'b.id', '=', 'internal_trade_sell_lists.internal_treasury_wallet_id')
                ->select('internal_trade_sell_lists.*', 'users.email','global_user_lists.user_id', 'global_user_lists.user_type', 'a.id as masterload_id', 'b.wallet_address')
                ->where('users.id', $user_id)
                ->where('a.trade_type', 2)
                ->get()->toArray();
        return view('zenix.client.sellReport', compact('page_title', 'page_description', 'action', 'result'));
    }

    public function masterload_report($masterload_id = null){
        $page_title = __('locale.masterload_report');
        $page_description = 'Some description for the page';
        $action = 'report';
        $result = DB::table('master_loads')
        ->join('internal_wallets as b', 'b.id', '=', 'master_loads.internal_treasury_wallet_id')
        ->select('master_loads.*', 'b.wallet_address')
        ->where('master_loads.id', $masterload_id)
        ->get()->toArray();
        return view('zenix.client.masterload_report', compact('page_title', 'page_description', 'action', 'result'));
    }
    public function superload_report($masterload_id = null){
        $page_title = __('locale.super_load_report');
        $page_description = 'Some description for the page';
        $action = 'report';
        $result = SuperLoad::where('masterload_id', $masterload_id)->where('trade_type', 2)->get()->toArray();
        return view('zenix.client.superload_report', compact('page_title', 'page_description', 'action', 'result'));
    }
}

