<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ZenixadminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminExchangeListController;
use App\Http\Controllers\Admin\AdminUserlistController;
use App\Http\Controllers\Admin\AdminWalletController;
use App\Http\Controllers\Admin\AdminGlobalUserController;
use App\Http\Controllers\Admin\AdminMarketingCampainController;
use App\Http\Controllers\Admin\AdminInternalTradeBuyController;
use App\Http\Controllers\Admin\AdminInternalTradeSellController;



use App\Http\Controllers\Client\BuyController;
use App\Http\Controllers\Client\BuyReportController;
use App\Http\Controllers\Client\SellController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


    Route::get('/',                     [HomeController::class,'index']);
    Route::get('/login',                [ZenixadminController::class,'page_login']);
    Route::get('/logout',               [LoginController::class, 'logout']);
    Route::post('/login_user',          [LoginController::class, 'login']);
    Route::get('/register',             [ZenixadminController::class,'page_register']);
    Route::post('/register_new_user',   [RegisterController::class, 'customRegisterUser']);

    Route::group(['middleware' => ['auth']], function(){
        Route::get('/kyc',                  [RegisterController::class, 'page_kyc']);
        Route::get('/agreement',            [RegisterController::class, 'page_agreement']);
        Route::post('/agreement',            [RegisterController::class, 'agree_terms_conditions']);
        Route::get('/trainee_video',            [RegisterController::class, 'page_trainee_video']);
        Route::post('/trainee_video',            [RegisterController::class, 'understood_video']);
    });

    // Admin Routing
    Route::group(['middleware' => ['isAdmin']], function(){
        // Route::get('/', function(){
        //     return redirect('/admin/dashboard');
        // });
        Route::get('/admin/exchangelist',               [AdminExchangeListController::class, "index"]);
        Route::get('/admin/new_exchange_list/{id?}',    [AdminExchangeListcontroller::class, "editExchange"]);
        Route::get('/admin/delete_exchange_list/{id?}', [AdminExchangeListcontroller::class, "deleteExchange"]);
        
        Route::post('/update_exchange_list',    [AdminExchangeListController::class, 'updateExchangeList']);
        Route::get('/admin/dashboard',          [AdminDashboardController::class,'index']);

        // Admin User list routing
        Route::get('/admin/userlist',                       [AdminUserlistController::class,'index']);
        Route::post('/admin/getUserByID',                   [AdminUserlistController::class,'getUserByID']);
        Route::post('/admin/assignCampaignId',              [AdminUserlistController::class,'assignCampaignId']);
        Route::post('/admin/changeUserEmail',               [AdminUserlistController::class,'changeUserEmail']);
        Route::post('/admin/changeUserPassword',            [AdminUserlistController::class,'changeUserPassword']);
        Route::get('/admin/change_userstate/{id}/{state}',  [AdminUserlistController::class,'changeUserState']);

        
        Route::get('/admin/walletlist',     [AdminWalletController::class,'index']);
        Route::get('/admin/newWalletlist/{id?}',  [AdminWalletController::class,'viewNewWalletlist']);
        Route::post('/admin/getNewWalletAddress',  [AdminWalletController::class,'generateNewWalletAddress']);
        Route::post('/admin/update_wallet_list',  [AdminWalletController::class,'updateWalletList']);
        Route::post('/admin/editColdStorage',  [AdminWalletController::class,'editColdStorage']);
        Route::post('/admin/getWalletInfoByID',  [AdminWalletController::class,'getWalletInfoByID']);
        Route::post('/admin/withdrawToColdStorage',  [AdminWalletController::class,'withdrawToColdStorage']);

        
        Route::get('/admin/globaluserlist', [AdminGlobalUserController::class,'index']);
        Route::get('/admin/editGlobalUser/{id?}', [AdminGlobalUserController::class,'editGlobalUser']);
        Route::post('/admin/updateGlobalUserList', [AdminGlobalUserController::class,'updateGlobalUserList']);
        Route::post('/admin/changeBuyWeightByID', [AdminGlobalUserController::class,'changeBuyWeightByID']);
        Route::post('/admin/changeSellWeightByID', [AdminGlobalUserController::class,'changeSellWeightByID']);
        Route::post('/admin/changeStatusByID', [AdminGlobalUserController::class,'changeStatusByID']);

        Route::get('/admin/marketingcampain', [AdminMarketingCampainController::class,'index']);
        Route::get('/admin/editMarketingCampain/{id?}', [AdminMarketingCampainController::class,'editMarketingCampain']);
        Route::post('/admin/changeMarketingCampainStatusByID', [AdminMarketingCampainController::class,'changeMarketingCampainStatusByID']);
        Route::get('/admin/previewMarketingCampain/{id}', [AdminMarketingCampainController::class,'previewMarketingCampain']);
        Route::post('/admin/updateMarketing', [AdminMarketingCampainController::class,'updateMarketing']);

        Route::get('/admin/internalTradeBuy', [AdminInternalTradeBuyController::class,'index']);
        Route::get('/admin/internalTradeSell', [AdminInternalTradeSellController::class,'index']);

    });
    
    // Client Routing
    Route::group(['middleware' => ['isClient']], function(){
        // Route::get('/', function(){
        //     return redirect('/client/dashboard');
        // });
    
        Route::get('/client/dashboard',     [AdminDashboardController::class,'index']);

    });


    Route::get('/buy_wizard',           [BuyController::class, 'index']);
    Route::post('/buy_crypto',          [BuyController::class, 'buyCrypto']);
    Route::post('/master_load',         [BuyController::class, 'masterload']);
    Route::post('/super_load',          [BuyController::class, 'superload_v']);

    Route::get('/sell_wizard',          [SellController::class, 'index']);
    Route::post('/sell_crypto',         [SellController::class, 'sellCrypto']);
    Route::get('/send_btc',             [SellController::class, 'sendBTC']);
    Route::post('/sell_master_load',    [SellController::class, 'masterload']);
    Route::post('/sell_super_load',     [SellController::class, 'superload_v']);
    
    Route::get('/get_new_btc_wallet_addr',  [SellController::class, 'get_new_btc_wallet_address']);
    Route::get('/get_receiving_btc_address',  [SellController::class, 'get_receiving_btc_address']);
    Route::post('/confirm_btc_payment',  [SellController::class, 'confirm_btc_payment']);

    Route::get('/get_balance',  [SellController::class, 'get_balance']);
    Route::get('/send_BTC',  [SellController::class, 'send_BTC']);


    Route::get('/buy_report',           [BuyReportController::class, 'index']);
    Route::post('/get_buy_report_infos',[BuyReportController::class, 'get_buy_info']);

    Route::get('/sell_report',          [SellController::class, 'report']);

    Route::get('/invite_friends', [BuyController::class, 'report']);


    // Client Routing


    Route::get('/index',                    [ZenixadminController::class,'dashboard_1']);
    Route::get('/index-2',                  [ZenixadminController::class,'dashboard_2']);
    Route::get('/coin-details',             [ZenixadminController::class,'coin_details']);
    Route::get('/portofolio',               [ZenixadminController::class,'portofolio']);
    Route::get('/market-capital',           [ZenixadminController::class,'market_capital']);
    Route::get('/tranasactions',            [ZenixadminController::class,'tranasactions']);
    Route::get('/my-wallets',               [ZenixadminController::class,'my_wallets']);
    Route::get('/app-profile',              [ZenixadminController::class,'app_profile']);
    Route::get('/post-details',             [ZenixadminController::class,'post_details']);
    Route::get('/page-chat',                [ZenixadminController::class,'page_chat']);
    Route::get('/project-list',             [ZenixadminController::class,'project_list']);
    Route::get('/project-card',             [ZenixadminController::class,'project_card']);
    Route::get('/contact-list',             [ZenixadminController::class,'contact_list']);
    Route::get('/contact-card',             [ZenixadminController::class,'contact_card']);
    Route::get('/email-compose',            [ZenixadminController::class,'email_compose']);
    Route::get('/email-inbox',              [ZenixadminController::class,'email_inbox']);
    Route::get('/email-read',               [ZenixadminController::class,'email_read']);
    Route::get('/app-calender',             [ZenixadminController::class,'app_calender']);
    Route::get('/ecom-checkout',            [ZenixadminController::class,'ecom_checkout']);
    Route::get('/ecom-customers',           [ZenixadminController::class,'ecom_customers']);
    Route::get('/ecom-invoice',             [ZenixadminController::class,'ecom_invoice']);
    Route::get('/ecom-product-detail',      [ZenixadminController::class,'ecom_product_detail']);
    Route::get('/ecom-product-grid',        [ZenixadminController::class,'ecom_product_grid']);
    Route::get('/ecom-product-list',        [ZenixadminController::class,'ecom_product_list']);
    Route::get('/ecom-product-order',       [ZenixadminController::class,'ecom_product_order']);
    Route::get('/chart-chartist',           [ZenixadminController::class,'chart_chartist']);
    Route::get('/chart-chartjs',            [ZenixadminController::class,'chart_chartjs']);
    Route::get('/chart-flot',               [ZenixadminController::class,'chart_flot']);
    Route::get('/chart-morris',             [ZenixadminController::class,'chart_morris']);
    Route::get('/chart-peity',              [ZenixadminController::class,'chart_peity']);
    Route::get('/chart-sparkline',          [ZenixadminController::class,'chart_sparkline']);
    Route::get('/ui-accordion',             [ZenixadminController::class,'ui_accordion']);
    Route::get('/ui-alert',                 [ZenixadminController::class,'ui_alert']);
    Route::get('/ui-badge',                 [ZenixadminController::class,'ui_badge']);
    Route::get('/ui-button',                [ZenixadminController::class,'ui_button']);
    Route::get('/ui-button-group',          [ZenixadminController::class,'ui_button_group']);
    Route::get('/ui-card',                  [ZenixadminController::class,'ui_card']);
    Route::get('/ui-carousel',              [ZenixadminController::class,'ui_carousel']);
    Route::get('/ui-dropdown',              [ZenixadminController::class,'ui_dropdown']);
    Route::get('/ui-grid',                  [ZenixadminController::class,'ui_grid']);
    Route::get('/ui-list-group',            [ZenixadminController::class,'ui_list_group']);
    Route::get('/ui-media-object',          [ZenixadminController::class,'ui_media_object']);
    Route::get('/ui-modal',                 [ZenixadminController::class,'ui_modal']);
    Route::get('/ui-pagination',            [ZenixadminController::class,'ui_pagination']);
    Route::get('/ui-popover',               [ZenixadminController::class,'ui_popover']);
    Route::get('/ui-progressbar',           [ZenixadminController::class,'ui_progressbar']);
    Route::get('/ui-tab',                   [ZenixadminController::class,'ui_tab']);
    Route::get('/ui-typography',            [ZenixadminController::class,'ui_typography']);
    Route::get('/uc-nestable',              [ZenixadminController::class,'uc_nestable']);
    Route::get('/uc-lightgallery',          [ZenixadminController::class,'uc_lightgallery']);
    Route::get('/uc-noui-slider',           [ZenixadminController::class,'uc_noui_slider']);
    Route::get('/uc-select2',               [ZenixadminController::class,'uc_select2']);
    Route::get('/uc-sweetalert',            [ZenixadminController::class,'uc_sweetalert']);
    Route::get('/uc-toastr',                [ZenixadminController::class,'uc_toastr']);
    Route::get('/map-jqvmap',               [ZenixadminController::class,'map_jqvmap']);
    Route::get('/widget-basic',             [ZenixadminController::class,'widget_basic']);
    Route::get('/form-editor-summernote',   [ZenixadminController::class,'form_editor_summernote']);
    Route::get('/form-element',             [ZenixadminController::class,'form_element']);
    Route::get('/form-pickers',             [ZenixadminController::class,'form_pickers']);
    Route::get('/form-validation-jquery',   [ZenixadminController::class,'form_validation_jquery']);
    Route::get('/form-wizard',              [ZenixadminController::class,'form_wizard']);
    Route::get('/table-bootstrap-basic',    [ZenixadminController::class,'table_bootstrap_basic']);
    Route::get('/table-datatable-basic',    [ZenixadminController::class,'table_datatable_basic']);
    Route::get('/page-error-400',           [ZenixadminController::class,'page_error_400']);
    Route::get('/page-error-403',           [ZenixadminController::class,'page_error_403']);
    Route::get('/page-error-404',           [ZenixadminController::class,'page_error_404']);
    Route::get('/page-error-500',           [ZenixadminController::class,'page_error_500']);
    Route::get('/page-error-503',           [ZenixadminController::class,'page_error_503']);
    Route::get('/page-forgot-password',     [ZenixadminController::class,'page_forgot_password']);
    Route::get('/page-lock-screen',         [ZenixadminController::class,'page_lock_screen']);
    Route::get('/page-login',               [ZenixadminController::class,'page_login']);
    Route::get('/page-register',            [ZenixadminController::class,'page_register']);
