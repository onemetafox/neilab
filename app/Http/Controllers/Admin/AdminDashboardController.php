<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ccxt;
use App\Models\ExchangeInfo;
use kornrunner\Ethereum\Address;

class AdminDashboardController extends Controller
{
    public function index(){
        $page_title = __('locale.admindashboard');
        $page_description = 'Some description for the page';
        $action = 'dashboard_2';

        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();

        foreach ($result as $key => $value) {
         # code...
            $exchange = $this->exchange($value);
            try {
                //code...
                $btc_wallet = $exchange->fetchDepositAddress("BTC");
                $btc_wallet_address = $btc_wallet['address'];
                $btc_wallet_balance = $this->getBalance($btc_wallet_address);

                $result[$key]['wallet_address'] = $btc_wallet_address;
                $result[$key]['wallet_balance'] = $btc_wallet_balance;
                $result[$key]['connect_status'] = true;
            } catch (\Throwable $th) {
                //throw $th;
                $result[$key]['wallet_address'] = 'Undifined';
                $result[$key]['wallet_balance'] = 'Undifined';
                $result[$key]['connect_status'] = false;
            }
        }
        return view('zenix.admin.dashboard', compact('page_title', 'page_description', 'action', 'result'));
    }
}
