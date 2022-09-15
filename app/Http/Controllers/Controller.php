<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\InternalWallet;
use SWeb3\Sweb3;
use SWeb3\Sweb3_contract;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function exchange($param){
        $n_id = $param['ex_name'];
        $exchange_id = '\\ccxt\\' . $n_id;
        $exchange = new $exchange_id(array(
            'enableRateLimit' => true,
            'apiKey' => $param['api_key'],
            'secret' => $param['api_secret'],
            'options' => array(
                'defaultType' => 'future',
            ),
        ));
        // $exchange = new $exchange_id(array(
        //     'enableRateLimit' => true,
        //     'apiKey' => 'WuwQjNckG59iMabbJDuZb1nhHwcUIlwERJnKoxaI8JbBGE7YMUuFVlG6TskjcEOv',
        //     'secret' => 'lalUvZN7JwGCTLLkR8A23XzbLXh0nMK0I4aukKYFMz1zA3QQmbjDuLAyzLKXELjL',
        //     'options' => array(
        //         'defaultType' => 'future',
        //     ),
        // ));
        // $exchange->set_sandbox_mode(True);
        return $exchange;
    }
    function getBalance($address) {
        return file_get_contents('https://blockchain.info/q/addressbalance/'. $address);
    }

    public function sendUSDT($from, $from_pk, $to, $amount){
        // $wallet_info = InternalWallet::where('wallet_address', $from)->get()->toArray();
        // if($wallet_info > 0){
            // $private_key = $wallet_info[0]['private_key'];
            // echo('node Admin/USDTSendServer/sendUSDT.js ' .$from.' '.$from_pk. ' '.$to.' '.$amount);

            exec('node C:\NeilLab\app\Http\Controllers\Admin\USDTSendServer\sendUSDT.js ' .$from.' '.$from_pk. ' '.$to.' '.$amount, $output);
            print_r($output);
            exit;
        // }
    }
    // public function sendUSDT($from, $to, $amount){

    //     $wallet_info = InternalWallet::where('wallet_address', $from)->get()->toArray();
    //     if($wallet_info > 0){
    //         $private_key = $wallet_info[0]['private_key'];
    //         $abi = '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint8","name":"decimals","type":"uint8"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"constant":true,"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"address","name":"_to","type":"address"},{"internalType":"uint256","name":"_amount","type":"uint256"}],"name":"mint","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"address","name":"sender","type":"address"},{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"}]';
    //         $sweb3 = new Sweb3('https://rinkeby.infura.io/v3/9ad37bf7991e4b5b96ff8e5351d8b37c');
    //         $from_address = '0x50279d0BB3d6F85E42c6Cac1546d60ac0683A932';
    //         $from_address_pk = 'd681d63adb096f7c3cac44b9ee44f4b2e1ef34eea3be9bb803753d8b5e9e8392';
    //         $sweb3->setPersonalData($from_address, $from_address_pk);

    //         $contract = new Sweb3_contract($sweb3, '0x3B00Ef435fA4FcFF5C209a37d1f3dcff37c705aD', $abi);
    //         $res = $contract->call('balanceOf','0x50279d0BB3d6F85E42c6Cac1546d60ac0683A932');
    //         $res = $contract->call('transferFrom', '0x50279d0BB3d6F85E42c6Cac1546d60ac0683A932', '0x38621Cf6F17D6918eEef43F7C6549caf5FBAE993', 0.0001);
    //         print_r($res);
    //         exit;

    //         $sendParams = [ 
    //             'from' =>   $sweb3->personal->address,  
    //             'to' =>     '0x50279d0BB3d6F85E42c6Cac1546d60ac0683A932',
    //             'gasLimit' => 210000,
    //             'value' => $sweb3->utils->toWei('0.1', 'TUSDT'),
    //             'nonce' => $sweb3->personal->getNonce()
    //         ];    

    //         $result = $sweb3->send($sendParams); 
    //         exit;
    //     }
    // }

    public function createMarketBuyOrder($symbol, $amount){
        echo $symbol;
        echo $amount;
        exit;
    }
}
