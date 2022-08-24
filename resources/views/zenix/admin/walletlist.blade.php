{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.adminwalletlist')}}</h2>
		<a href="/admin/newWalletlist" class="btn btn-secondary mb-2"><i class="las la-plus scale5 me-3"></i>{{__('locale.admin_create_new_internal_wallet_list')}}</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.adminwalletlist')}}</h4>
                    @if(session()->has('error'))
					<div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
					@endif

					@if(session()->has('success'))
					<div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
					@endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example7" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>{{__('locale.wallet_list_id')}}</th>
                                    <th>{{__('locale.wallet_list_internal_treasury_account')}}</th>
                                    <th>{{__('locale.wallet_list_type')}}</th>
                                    <th>{{__('locale.wallet_list_chainstack')}}</th>
                                    <th>{{__('locale.wallet_list_internal_wallet_address')}}</th>
                                    <th>{{__('locale.wallet_list_cold_storage_address')}}</th>
                                    <th>{{__('locale.wallet_list_market_price')}}</th>
                                    <th>{{__('locale.wallet_list_withdraw')}}</th>
                                    <th>{{__('locale.wallet_list_in_house_balance')}}</th>
                                    <th>{{__('locale.wallet_list_cold_storage_balance')}}</th>
                                    <th>{{__('locale.wallet_list_history')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($internal_wallet as $key => $value)
                                <tr>
                                    <td>{{$value['id']}}</td>
									<td></td>
									<td>{{$value['chain_stack']}}</td>
									<td>{{$value['chain_stack']}}</td>
									<td>{{$value['wallet_address']}}</td>
									<td><a href="/admin/internal_wallet/setup_cold_storage_address/{{$value['id']}}">cold storage</a></td>
									<td>25775</td>
									<td><a href="/admin/internal_wallet/withdraw/{{$value['id']}}">Withdraw</a></td>
									<td>25</td>
									<td>balance</td>
									<td><a href="/admin/internal_wallet/history/{{$value['id']}}">History</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection	

{{-- Scripts --}}
@section('scripts')
	<script>
		jQuery(document).ready(function(){
			dezSettingsOptions.version = 'dark';
			setTimeout(function() {
				dezSettingsOptions.version = 'dark';
				new dezSettings(dezSettingsOptions);
			}, 1500)
		});
	</script>
@endsection	