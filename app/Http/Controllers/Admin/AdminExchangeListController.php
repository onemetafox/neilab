<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ccxt;
use App\Models\ExchangeInfo;
use kornrunner\Ethereum\Address;
use Illuminate\Support\Arr;

class AdminExchangeListController extends Controller
{
    public function index(){
        $page_title = __('locale.adminexchangelist');
        $page_description = 'Some description for the page';
        $action = 'exchangelist';

        $result = ExchangeInfo::orderBy('id', 'asc')->get()->toArray();

        foreach ($result as $key => $value) {
         # code...
            $exchange = $this->exchange($value);
            try {
                //code...
                $btc_wallet = $exchange->fetchDepositAddress("BTC");
                $btc_wallet_address = $btc_wallet['address'];

                $result[$key]['wallet_address'] = $btc_wallet_address;
                $result[$key]['connect_status'] = true;
            } catch (\Throwable $th) {
                //throw $th;
                $result[$key]['wallet_address'] = 'Undifined';
                $result[$key]['connect_status'] = false;
            }
        }
        $theme_mode = $this->getThemeMode();

        return view('zenix.admin.exchangelist', compact('page_title', 'page_description', 'action', 'result', 'theme_mode'));

    }

    public function editExchange($id = null){
        $page_title = __('locale.admin_create_new_exchange_list');
        $page_description = 'Some description for the page';
        $action = 'exchangelist';
        $theme_mode = $this->getThemeMode();
        if($id){
            $result = ExchangeInfo::where("id", $id)->get()->toArray();
            return view('zenix.admin.newExchangeList', compact('page_title', 'page_description', 'action', 'result', 'theme_mode'));
        }else{
            return view('zenix.admin.newExchangeList', compact('page_title', 'page_description', 'action', 'theme_mode'));
        }
    }

    public function updateExchangeList(Request $request){
        $payLoad = Arr::except($request->all(),['_token','old_id']);
        if($request->old_id){
            $result = ExchangeInfo::where("id", $request->old_id)->update($payLoad);
            if($result > 0){
                return redirect('/admin/new_exchange_list/'.$request->old_id)->with('success', 'Successfully updated');
            }else{
                return redirect('/admin/new_exchange_list/'.$request->old_id)->with('error', 'Try again. There is error in database');
            }
        }else{
            $result = ExchangeInfo::create($payLoad);
            if(isset($result) && $result->id > 0){
                return redirect('/admin/new_exchange_list/'.$request->old_id)->with('success', 'Successfully created');
            }else{
                return redirect('/admin/new_exchange_list/'.$request->old_id)->with('error', 'Try again. There is error in database');
            }
        }
    }

    public function deleteExchange($id = null){
        $res=ExchangeInfo::where('id',$id)->delete();
        if($res > 0){
            return redirect('/admin/exchangelist/')->with('success', 'Successfully deleted');
        }else{
            return redirect('/admin/exchangelist/')->with('error', 'Try again. There is error in database');
        }
    }
    

}
