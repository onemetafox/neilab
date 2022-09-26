<!--**********************************
	Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
		<div class="main-profile">
			<h5 class="name"><span class="font-w400">Hello,</span> {{Auth::user()->first_name.' '.Auth::user()->last_name}} </h5>
			<p class="email">{{Auth::user()->email}}</p>
		</div>
		<ul class="metismenu" id="menu">
            <li>
				@if(Auth::user()->user_type=="admin")
            	<a href="{!! url('/admin/dashboard'); !!}" aria-expanded="false">
					<i class="flaticon-096-dashboard"></i>{{__('locale.admindashboard')}}
				</a>
				@elseif(Auth::user()->user_type=="client")
            	<a href="{!! url('/client/dashboard'); !!}" aria-expanded="false">
					<i class="flaticon-096-dashboard"></i>
					<span class="nav-text">{{__('locale.clientdashboard')}}</span>
				</a>
				@endif
            </li>
			@if(Auth::user()->user_type=="admin")
			<li class="nav-label first">Admin Menu</li>
			<li>
				<a href="{!! url('/admin/exchangelist'); !!}" aria-expanded="false">
					<i class="flaticon-088-tools"></i>{{__('locale.adminexchangelist')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/admin/userlist'); !!}" aria-expanded="false">
					<i class="flaticon-153-user"></i>{{__('locale.adminuserlist')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/admin/walletlist'); !!}" aria-expanded="false">
					<i class="flaticon-092-money"></i>{{__('locale.adminwalletlist')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/admin/globaluserlist'); !!}" aria-expanded="false">
					<i class="flaticon-028-user-1"></i>{{__('locale.global_user_list')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/admin/marketingcampain'); !!}" aria-expanded="false">
					<i class="flaticon-081-up-arrow-2"></i>{{__('locale.marketing_campain')}}
				</a>
			</li>
            <!-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class="flaticon-077-menu-1"></i>
					<span class="nav-text">Internal Trade</span>
				</a>
                <ul aria-expanded="false">
                    <li><a href="{!! url('/admin/internalTradeBuy'); !!}">{{__('locale.internal_trade_buy')}}</a></li>
					<li><a href="{!! url('/admin/internalTradeSell'); !!}">{{__('locale.internal_trade_sell')}}</a></li>
				</ul>
			</li> -->
			@endif
			@if(Auth::user()->user_type=="client")
			<li class="nav-label">Digital Assets Desk</li>
			<li>
				<a href="{!! url('/buy_wizard'); !!}" aria-expanded="false">
					<i class="flaticon-065-right-arrow-1"></i>{{__('locale.buy_wizard')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/sell_wizard'); !!}" aria-expanded="false">
					<i class="flaticon-075-left-arrow-2"></i>{{__('locale.sell_wizard')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/buy_report'); !!}" aria-expanded="false">
					<i class="flaticon-039-shuffle"></i>{{__('locale.buy_report')}}
				</a>
			</li>
			<li>
				<a href="{!! url('/sell_report'); !!}" aria-expanded="false">
					<i class="flaticon-039-shuffle"></i>{{__('locale.sell_report')}}
				</a>
			</li>
			@endif
			<li>
				<a href="{!! url('/invite_friends'); !!}" aria-expanded="false">
					<i class="flaticon-039-shuffle"></i> Invite Friends
				</a>
			</li>
			<li>
				<a href="{!! url('/commisions'); !!}" aria-expanded="false">
					<i class="flaticon-039-shuffle"></i>{{__('locale.commisions')}}
				</a>
			</li>
        </ul>
		<div class="copyright">
			<strong>NeilLab Dashboard</strong>
			<p> © 2022 All Rights Reserved</p>
		</div>
	</div>
</div>
<!--**********************************
	Sidebar end
***********************************-->