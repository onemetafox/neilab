<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\InternalTradeBuyList;
use App\Models\GlobalUserList;
use App\Models\ChainStack;
use Illuminate\Support\Arr;
use App\Models\MasterLoad;
use App\Models\SuperLoad;
use App\Models\SubLoad;
use App\Models\ExchangeInfo;
use App\Models\InternalWallet;
use Auth;
use Illuminate\Support\Facades\DB;

class AdminBuyRequestController extends Controller
{

    public function index(){

        $page_title = __('locale.buy_request');
        $page_description = 'Some description for the page';
        $action = 'request';


        $result = DB::table('internal_trade_buy_lists')
                ->join('users', 'internal_trade_buy_lists.user_id', '=', 'users.id')
                ->join('master_loads as a', 'a.trade_id', '=', 'internal_trade_buy_lists.id')
                ->join('internal_wallets as b', 'b.id', '=', 'internal_trade_buy_lists.internal_treasury_wallet_id')
                ->select('internal_trade_buy_lists.*', 'users.email','users.id as user_id', 'a.id as masterload_id', 'b.wallet_address')
                ->where('a.trade_type', 1)
                ->where('internal_trade_buy_lists.state', 3)
                ->get()->toArray();

        $theme_mode = $this->getThemeMode();
        return view('zenix.admin.report.buyRequest', compact('page_title', 'page_description', 'action', 'result', 'theme_mode'));
    }

}

