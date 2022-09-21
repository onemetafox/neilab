<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\InternalTradeBuyList;
use App\Models\GlobalUserList;
use App\Models\ChainStack;
use Illuminate\Support\Arr;
use App\Models\MasterLoad;
use App\Models\SuperLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalWallet;
use Auth;
use Illuminate\Support\Facades\DB;

class BuyReportController extends Controller
{
    //
    public function index(){

        $page_title = __('locale.buy_report');
        $page_description = 'Some description for the page';
        $action = 'report';
        
        $user_id = Auth::user()->id;

        $result = DB::table('internal_trade_buy_lists')
                ->join('global_user_lists', 'internal_trade_buy_lists.global_user_id', '=', 'global_user_lists.id')
                ->join('users', 'global_user_lists.user_id', '=', 'users.id')
                ->join('master_loads as a', 'a.trade_id', '=', 'internal_trade_buy_lists.id')
                ->join('master_loads as b', 'b.trade_type', '=', 1)
                ->select('internal_trade_buy_lists.*', 'users.email','global_user_lists.user_id', 'global_user_lists.user_type')
                ->where('users.id', $user_id)
                ->get()->toArray();
        print_r($result);
        exit;
        return view('zenix.client.buyReport', compact('page_title', 'page_description', 'action'));
    }
}

