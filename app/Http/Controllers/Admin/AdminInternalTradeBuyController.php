<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modles\InternalTradeBuyList;
use Illuminate\Support\Facades\DB;

class AdminInternalTradeBuyController extends Controller
{
    //
    public function index(){
        // $internal_trade_buy_list_info = InternalTradeBuyList::orderBy('id', 'asc')->get()->toArray();

        $result = DB::table('internal_trade_buy_lists')
                                        ->join('global_user_lists', 'internal_trade_buy_lists.global_user_id', '=', 'global_user_lists.id')
                                        ->join('users', 'global_user_lists.user_id', '=', 'users.id')
                                        ->select('internal_trade_buy_lists.*', 'users.email','global_user_lists.user_id', 'global_user_lists.user_type')
                                        ->get()->toArray();

        $page_title = __('locale.internal_trade_buy');
        $page_description = 'Some description for the page';
        $action = 'internal_trade';
        return view('zenix.admin.internalTradeBuy', compact('page_title', 'page_description', 'action','result'));

    }
}
