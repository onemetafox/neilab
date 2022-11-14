{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.adminexchangelist')}}</h2>

		<a href="{!! url('/admin/new_exchange_list'); !!}" class="btn btn-secondary mb-2"><i class="las la-plus scale5 me-3"></i>{{__('locale.admin_create_new_exchange_list')}}</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.adminexchangelist')}}</h4>
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
                                    <th>{{__('locale.exchange_list_id')}}</th>
                                    <th>{{__('locale.exchange_list_name')}}</th>
                                    <th>{{__('locale.exchange_list_email')}}</th>
                                    <th>{{__('locale.exchange_list_wallet_address')}}</th>
                                    <th>{{__('locale.exchange_list_test_status')}}</th>
                                    <th>{{__('locale.exchange_list_certified')}}</th>
                                    <th>{{__('locale.exchange_list_state')}}</th>
                                    <th>{{__('locale.exchange_list_action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $key => $value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    @switch($value['ex_name'])
                                        @case('Binance')
                                            <td>Binance</td>
                                            @break
                                        @case('FTX')
                                            <td>FTX</td>
                                            @break
                                        @case('kucoin')
                                            <td>Kucoin</td>
                                            @break
                                        @case('gateio')
                                            <td>Gate.io</td>
                                            @break
                                        @case('bitfinex')
                                            <td>Bitfinex</td>
                                            @break
                                        @case('huobi')
                                            <td>Huobi</td>
                                            @break
                                        @case('bitstamp')
                                            <td>Bitstamp</td>
                                            @break
                                        @case('okx')
                                            <td>OKX</td>
                                            @break

                                        @default

                                    @endswitch
                                    <td>{{$value['ex_login']}}</td>
                                    <td>{{$value['wallet_address']}}</td>
                                    <td>
                                        @if ($value['connect_status'] == false)
                                        <span class="badge light badge-danger">
                                            <i class="fa fa-circle text-danger me-1"></i>
                                            Disconnected
                                        </span>
                                        @else
                                        <span class="badge light badge-success">
                                            <i class="fa fa-circle text-success me-1"></i>
                                            Connected
                                        </span>
                                        @endif
                                    </td>
                                    <td>Certified</td>
                                    <td>
										<select id="exchange_state_{{$value['id']}}" data-id="{{$value['id']}}" name="exchange_state_{{$value['id']}}" onchange="updateExchangeState(this);">
                                            <option value="1" {{isset($value['state']) && $value['state']==1?'selected':''}}>Enabled</option>
											<option value="0" {{isset($value['state']) && $value['state']==0?'selected':''}}>Disabled</option>
										</select></div>
                                    </td>
                                    <td>
                                        <div class="dropdown ms-auto text-right">
                                            <div class="btn-link" data-bs-toggle="dropdown">
                                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-end">

												<a class="dropdown-item" href="{!! url('/admin/new_exchange_list/'.$value['id']); !!}">Edit</a>
												<a class="dropdown-item" href="{!! url('/admin/delete_exchange_list/'.$value['id']); !!}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
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
			dezSettingsOptions.version = '<?php echo $theme_mode?>';
			setTimeout(function() {
				dezSettingsOptions.version = '<?php echo $theme_mode?>';
				new dezSettings(dezSettingsOptions);
			}, 1500)
		});
		function updateExchangeState(e){
			var exchange_id = $(e).data('id');
			var state = $("#exchange_state_"+exchange_id).val();
            console.log(state);
			$.ajax({
				type: "post",
				url : '{!! url('/admin/updatestate'); !!}',
				data: {
					"_token": "{{ csrf_token() }}",
					"id": exchange_id,
					"state": state,
				},
				success: function(data){
					if(data.success){
                        alertSuccess();
                    }else{
						alertError("Database Error!");
					}
				},
			});
		}

		function alertSuccess(){
			toastr.info("Updated Successfully", "Success", {
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1
                })
		}

		function alertError(msg){
			toastr.error(msg, "Error", {
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1
                })
		}
	</script>
@endsection
