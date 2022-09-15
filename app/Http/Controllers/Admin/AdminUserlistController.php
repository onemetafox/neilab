<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MarketingCampain;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AdminUserlistController extends Controller
{
    //
    public function index(){
        $page_title = __('locale.adminuserlist');
        $page_description = 'Some description for the page';
        $action = 'userlist';
        $result = User::orderBy('id', 'asc')->get()->toArray();
        
        $campaigns = MarketingCampain::where('status', 1)->get();
        return view('zenix.admin.userlist', compact('page_title', 'page_description', 'action', 'result', 'campaigns'));
    }
    public function getUserByID(Request $request){
        $id = $request['id'];
        $result = User::where('id', $id)->get()->toArray();
        $success = true;
        return response()->json(['success'=>$success, 'data'=>$result]);
    }

    public function assignCampaignId(Request $request) {
        $user_id = $request->user_id;
        $campaign_id = $request->campaign_id;
        if(empty($campaign_id)){
            $redirect = '';
        }else{
            $campaign = MarketingCampain::find($campaign_id);
            $kyc = $campaign->kyc_required;
            $redirect = $kyc==2?'agreement':'kyc';
        }
        $user = User::find($user_id);
        $user->marketing_campain_id = $campaign_id;
        $user->redirect = $redirect;
        if($user->save()) return 'success';
        else return 'error';
    }

    public function changeUserEmail(Request $request){
        $id = $request['user_id'];
        $target_email = $request['target_email'];

        $result = User::where("id", $id)->update(["email" => $target_email]);

        if($result > 0){
            return redirect('/admin/userlist')->with('success', 'Email has been updated successfully ');
        }else{
            return redirect('/admin/userlist')->with('error', 'Try again. There is error in database');
        }
    }

    public function changeUserPassword(Request $request){
        $id = $request['user_password_id'];
        $result = User::where("id", $id)->update(["password" => Hash::make(12345)]);
        if($result > 0){
            return redirect('/admin/userlist')->with('success', 'Password has been formated to number "12345".');
        }else{
            return redirect('/admin/userlist')->with('error', 'Try again. There is error in database');
        }
    }
    public function changeUserState($id, $state){
        $result = User::where("id", $id)->update(["state" => $state]);
        if($result > 0){
            return redirect('/admin/userlist')->with('success', 'User state has been changed successfully');
        }else{
            return redirect('/admin/userlist')->with('error', 'Try again. There is error in database');
        }
    }
}
