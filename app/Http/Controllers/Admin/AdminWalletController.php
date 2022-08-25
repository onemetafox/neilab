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

        foreach ($internal_wallet as $key => $value) {
            # code...
            if($internal_wallet[$key]['cold_storage_wallet_id'] != null){
                $cold_storage_address = ColdWallet::select("cold_address")->where("id", $internal_wallet[$key]['cold_storage_wallet_id'])->get()->toArray();
                $internal_wallet[$key]['cold_storage_address'] = $cold_storage_address[0]['cold_address'];
                $cold_storage_balance = $this->getBalance($cold_storage_address[0]['cold_address']);
                $internal_wallet[$key]['cold_storage_balance'] = $cold_storage_balance;
            }else{
                $internal_wallet[$key]['cold_storage_address'] = "Edit";
                $internal_wallet[$key]['cold_storage_balance'] = 0;

            }
        }
        $cold_wallet = ColdWallet::orderBy('id', 'asc')->get();
        return view('zenix.admin.walletlist', compact('page_title', 'page_description', 'action', 'internal_wallet','cold_wallet'));
    }
    public function viewNewWalletlist($id = null){
        $page_title = __('locale.admin_create_new_internal_wallet_list');
        $page_description = 'Some description for the page';
        $action = 'walletlist';
        if($id){
            $result = InternalWallet::where("id", $id)->get()->toArray();
            return view('zenix.admin.updateInternalWallet', compact('page_title', 'page_description', 'action', 'result'));
        }else{
            $cold_wallet = ColdWallet::orderBy('id', 'asc')->get()->toArray();
            return view('zenix.admin.updateInternalWallet', compact('page_title', 'page_description', 'action','cold_wallet'));
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
    public function editColdStorage(Request $request){
        $id = $request['user_id'];
        $wallet_id = $request['cold_storage_wallet_id'];
        $result = InternalWallet::where('id', $id)->update(['cold_storage_wallet_id' => $wallet_id]);
        if($result > 0){
            return redirect('/admin/walletlist')->with('success', 'Successfully created');
        }else{
            return redirect('/admin/walletlist')->with('error', 'Try again. There is error in database');
        }
    }

    public function getWalletInfoByID(Request $request){
        $id = $request['id'];
        $wallet_info = InternalWallet::where('id', $id)->get()->toArray();
        $wallet_balance = $this->getBalance($wallet_info[0]['wallet_address']);
        $cold_storage = ColdWallet::where('id', $wallet_info[0]['cold_storage_wallet_id'])->get()->toArray();
        $cold_address = $cold_storage[0]['cold_address'];
        $success = true;
        return response()->json(["success" => $success, "wallet_balance" => $wallet_balance, "cold_storage" => $cold_address]);
    }
    public function withdrawToColdStorage(Request $request){
        $success = true;
        $error = false;
        $id = $request['wallet_id'];
        $req['amount'] = $request['amount'];
        $description = $request['decription'];
        $wallet_info = InternalWallet::where('id', $id)->get()->toArray();

        $req['login'] = $wallet_info[0]['login'];
        $req['ipaddress'] = $wallet_info[0]['ipaddress'];
        $req['password'] = $wallet_info[0]['password'];

        $req['fromAddress'] = $wallet_info[0]['wallet_address'];
        $cold_storage = ColdWallet::where('id', $wallet_info[0]['cold_storage_wallet_id'])->get()->toArray();
        $req['toAddress'] = $cold_storage[0]['cold_address'];

        $result = $this->withDraw($req);
        if($result['status']){
            return response()->json(["success" => $success, "message" => $result['message']]);
        }else{
            return response()->json(["success" => $error, "message" => $result['message']]);
        }
    }
    function getBalance($address) {
        return file_get_contents('https://blockchain.info/q/addressbalance/'. $address);
    }
    function createMetamaskWalletAddress (){
        $address = new Address();
        return $address;
    }
    function withDraw($req){
        try {
            //code...
            $bitcoind = new BitcoinClient('http://'.$req['login'].':'.$req['password'].'@'.$req['ipaddress'].':8332');
            $result = $bitcoind->wallet('internal_wallet')->sendToAddress($req['toAddress'], $req['amount']);
            $result['status'] = true;
            $result['message'] = $result;
            return $result;
        } catch (\Throwable $th) {
            // throw $th;
            $result['status'] = false;
            $result['message'] = "Insufficient funds";
            return $result;
        }
    }
}
