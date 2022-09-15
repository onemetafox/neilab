<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\MarketingCampain;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function index()
    {
        $banner_title = 'World First Decentralized Marketplace with blockchain infrastructure';
        $banner_content = 'The first decentralized Marketplace which makes simplifies and standarizes data with blockchain technology. We provides user-friendly, efficient and secure crypto solutions and utilizing blockchain technology.';
        $logo_path = '/front/images/logo-s2-white.png';
        if(Auth::check()) {
            $campaign = MarketingCampain::find(auth()->user()->marketing_campain_id);
            if($campaign) {
                $banner_title = $campaign->banner_title;
                $banner_content = $campaign->banner_content;
                $logo_path = '/storage/logo_images/'.$campaign->logo_image;
            }
        }
        return view('front.home', compact('banner_title', 'banner_content', 'logo_path'));
    }

}
