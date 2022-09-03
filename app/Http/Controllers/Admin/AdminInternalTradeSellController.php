<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modles\InternalTradeSellList;
use Illuminate\Support\Facades\DB;

class AdminInternalTradeSellController extends Controller
{
    //
    public function index(){
        // $internal_trade_buy_list_info = InternalTradeBuyList::orderBy('id', 'asc')->get()->toArray();

        $result = DB::table('internal_trade_sell_lists')
                                        ->join('global_user_lists', 'internal_trade_sell_lists.global_user_id', '=', 'global_user_lists.id')
                                        ->join('users', 'global_user_lists.user_id', '=', 'users.id')
                                        ->select('internal_trade_sell_lists.*', 'users.email','global_user_lists.user_id', 'global_user_lists.user_type')
                                        ->get()->toArray();

        $page_title = __('locale.internal_trade_sell');
        $page_description = 'Some description for the page';
        $action = 'internal_trade';
        return view('zenix.admin.internalTradeSell', compact('page_title', 'page_description', 'action','result'));

    }
}
