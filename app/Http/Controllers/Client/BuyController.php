<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    //
    public function index()
    {
        $page_title = __('locale.buy_wizard');
        $page_description = 'Some description for the page';
        $action = 'wizard';
        return view('zenix.client.buywizard', compact('page_title', 'page_description', 'action'));
    }
    public function buyCrypto(Request $request){
        
    }
}
