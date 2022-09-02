<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GlobalUserList;
use App\Models\ExchangeInfo;
use App\Models\TradingPair;
use App\Models\ColdWallet;
use App\Models\MarketingCampain;
use App\Models\DomainList;

use App\Http\Controllers\Controller;

class AdminMarketingCampainController extends Controller
{
    //
    
    public function index(){
        $page_title = __('locale.marketing_campain');
        $page_description = 'Some description for the page';
        $action = 'marketing_campain';
        $result = MarketingCampain::orderBy('id', 'asc')->get()->toArray();
        foreach ($result as $key => $value) {
            # code...
            $domain_info = DomainList::where('id', $value['domain_id'])->get()->toArray();
            $result[$key]['domain_url'] = $domain_info[0]['domain_name'];
            $result[$key]['number_of_signups'] = $domain_info[0]['signup_user_number'];
        }
        return view('zenix.admin.marketing_campain', compact('page_title', 'page_description', 'action', 'result'));
    }
    public function editMarketingCampain($id = null){
        if($id){

        }else{
            $page_title = __('locale.add_new_marketing_campain');
            $page_description = 'Some description for the page';
            $action = 'marketing_campain';
            $domains = DomainList::orderBy('id', 'asc')->get()->toArray();
            return view('zenix.admin.editMarketingCampain', compact('page_title', 'page_description', 'action', 'domains'));
        }
    }
    public function updateMarketing(Request $request){
        $marketing_array = array();
        $marketing_array['campain_name'] = $request['campain_name'];
        $marketing_array['total_fee'] = $request['total_fee'];
        $marketing_array['internal_sales_fee'] = $request['internal_sales_fee'];
        $marketing_array['uni_level_fee'] = $request['uni_level_fee'];
        $marketing_array['external_sales_fee'] = $request['external_sales_fee'];
        $marketing_array['trust_fee'] = $request['trust_fee'];
        $marketing_array['profit_fee'] = $request['profit_fee'];
        $marketing_array['domain_id'] = $request['domain_id'];
        $marketing_array['kyc_required'] = $request['kyc_required'];
        $marketing_array['status'] = 1;

        if(isset($request['active_add_new']) && $request['active_add_new'] == "on"){
            $domain_array = array();
            $domain_array['domain_name'] = $request['domain_name'];
            $domain_array['signup_page'] = $request['signup_page'];
            $domain_array['agreement_page'] = $request['agreement_page'];
            $domain_array['last_page'] = $request['last_page'];
            $domain_array['status'] = 1;
            $domain_array['del_flag'] = 0;
            $domain_array['signup_user_number'] = 0;

            $new_domain_id = DomainList::create($domain_array);

            $marketing_array['domain_id'] = $new_domain_id->id;

            $result = MarketingCampain::create($marketing_array);
            if(isset($result) && $result->id > 0){
                return redirect('/admin/marketingcampain')->with('success', 'Successfully created');
            }else{
                return redirect('/admin/marketingcampain')->with('error', __('error.error_on_database'));
            }
        }else{
            $result = MarketingCampain::create($marketing_array);
            if(isset($result) && $result->id > 0){
                return redirect('/admin/marketingcampain')->with('success', 'Successfully created');
            }else{
                return redirect('/admin/marketingcampain')->with('error', __('error.error_on_database'));
            }
        }
    }

    public function changeMarketingCampainStatusByID(Request $request){
        $id = $request['id'];
        $value = $request['value'];
        $result = MarketingCampain::where("id", $id)->update(["status" => $value]);
        $success = true;
        $error = false;

        if($result > 0){
            return response()->json(["success" => $success,]);
        }else{
            return response()->json(["success" => $error,]);
        }
    }

    public function viewCamapinByID($id = null){
        $page_title = __('locale.marketing_campain_view');
        $page_description = 'Some description for the page';
        $action = 'marketing_campain';

        $result = MarketingCampain::where('id', $id)->get()->toArray();
        $domain_info = DomainList::where('id', $result[0]['domain_id'])->get()->toArray();
        $result['domain_url'] = $domain_info[0]['domain_name'];
        $result['number_of_signups'] = $domain_info[0]['signup_user_number'];
        return view('zenix.admin.marketing_campain_view', compact('page_title', 'page_description', 'action', 'result'));
    }
    
}
