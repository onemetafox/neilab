<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellController extends Controller
{
    //
    public function index()
    {
        $page_title = __('locale.sell_wizard');
        $page_description = 'Some description for the page';
        $action = 'wizard';
        return view('zenix.client.sellwizard', compact('page_title', 'page_description', 'action'));
    }
}
