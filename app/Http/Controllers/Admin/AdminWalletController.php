<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\ColdWallet;
use App\Models\InternalWallet;
use kornrunner\Ethereum\Address;
use Illuminate\Support\Facades\Storage;
use ccxt;
use Denpa\Bitcoin\Client as BitcoinClient;
use Illuminate\Support\Arr;

class AdminWalletController extends Controller
{
    public function index(){
        $page_title = __('locale.adminwalletlist');
        $page_description = 'Some description for the page';
        $action = 'walletlist';

        $internal_wallet  = InternalWallet::orderBy('id', 'asc')->get()->toArray();

        // foreach ($internal_wallet as $key => $value) {
        //     # code...
        //     $cold_storage_address = ColdWallet::select("cold_address")->where("id", $internal_wallet[$key]['cold_storage_status'])->get()->toArray();
        //     $internal_wallet[$key]['cold_storage_address'] = $cold_storage_address[0]['cold_address'];
        //     $cold_storage_balance = $this->getBalance($cold_storage_address[0]['cold_address']);
        //     $internal_wallet[$key]['cold_storage_balance'] = $cold_storage_balance;
        // }

        return view('zenix.admin.walletlist', compact('page_title', 'page_description', 'action', 'internal_wallet'));
    }
    public function viewNewWalletlist($id = null){
        $page_title = __('locale.admin_create_new_internal_wallet_list');
        $page_description = 'Some description for the page';
        $action = 'walletlist';
        if($id){
            $result = InternalWallet::where("id", $id)->get()->toArray();
            return view('zenix.admin.updateInternalWallet', compact('page_title', 'page_description', 'action', 'result'));
        }else{
            return view('zenix.admin.updateInternalWallet', compact('page_title', 'page_description', 'action'));
        }
    }

    public function generateNewWalletAddress(Request $request){
        $chain_stack = $request['chain_stack'];
        $ipaddress = $request['ipaddress'];
        $login = $request['login'];
        $password = $request['password'];
        $success = true;
        $error = false;
        if($chain_stack == 1){
            try {
                $bitcoind = new BitcoinClient('http://'.$login.':'.$password.'@'.$ipaddress.':8332');
                $address = $bitcoind->wallet('internal_wallet')->getnewaddress()->result();
                return response()->json(["success" => $success, "address" => $address]);
            } catch (\Throwable $th) {
                return response()->json(["success" => $error, "message" => "Invalid Information!"]);
            }
        }else{
            $metamaskAddressInfo = $this->createMetamaskWalletAddress();
            $metamaskAddress = $metamaskAddressInfo->get();
            $metamaskPrivateKey = $metamaskAddressInfo->getPrivateKey();
            return response()->json(["success" => $success, "address" => $metamaskAddress, "private_key" => $metamaskPrivateKey]);
        }
    }

    public function updateWalletList(Request $request){
        $payLoad = Arr::except($request->all(),['_token']);
        // if($request->old_id){
        //     $result = ExchangeInfo::where("id", $request->old_id)->update($payLoad);
        //     if($result > 0){
        //         return redirect('/admin/new_exchange_list/'.$request->old_id)->with('success', 'Successfully updated');
        //     }else{
        //         return redirect('/admin/new_exchange_list/'.$request->old_id)->with('error', 'Try again. There is error in database');
        //     }
        // }else{
            $result = InternalWallet::create($payLoad);
            if(isset($result) && $result->id > 0){
                return redirect('/admin/walletlist'.$request->old_id)->with('success', 'Successfully created');
            }else{
                return redirect('/admin/walletlist'.$request->old_id)->with('error', 'Try again. There is error in database');
            }
        // }
    }
    function getBalance($address) {
        return file_get_contents('https://blockchain.info/q/addressbalance/'. $address);
    }
    function createMetamaskWalletAddress (){
        $address = new Address();
        return $address;
    }
}
