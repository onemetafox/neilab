{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.admin_create_new_internal_wallet_list')}}</h2>
		<a href="javascript:void(0);" class="btn btn-secondary mb-2"><i class="las la-calendar scale5 me-3"></i>Filter Periode</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.admin_create_new_internal_wallet_list')}}</h4>
					@if(session()->has('error'))
					<div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
					@endif

					@if(session()->has('success'))
					<div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
					@endif
                </div>
                <div class="card-body">
					<div class="row no-gutters">
						<form method="post" action="{!! url('/admin/update_wallet_list'); !!}">
							@csrf
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Chain Stack Type</strong></label>
										<select id="chain_stack" name="chain_stack">
											<option value="1">Bitcore</option>
											<option value="2">Metamask</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Login</strong></label>
										<input type="text" class="form-control" id="login" name="login"  value="{{isset($result)?$result[0]['login']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Password</strong></label>
										<input type="text" class="form-control" id="password" name="password"  value="{{isset($result)?$result[0]['password']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>IP Address</strong></label>
										<input type="text" class="form-control" id="ipaddress" name="ipaddress"  value="{{isset($result)?$result[0]['ipaddress']:''}}">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Generate Adddress</strong></label>
										<div class="input-group mb-3">
											<input type="text" class="form-control" id="wallet_address" name="wallet_address">
											<button class="btn btn-primary" type="button" onclick="generateWalletAddress()">Generate</button>
										</div>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Private Key</strong></label>
										<input type="text" class="form-control" id="private_key" name="private_key">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Cold Storage Wallets</strong></label>
										<select id="cold_wallet" name="cold_storage_wallet_id">
											@foreach($cold_wallet as $key => $value)
											<option value="{{$value['id']}}">{{$value['cold_address']}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Set as new treasury wallet address</strong></label>
										<select id="set_as_treasury_wallet" name="set_as_treasury_wallet">
											<option value="1">yes</option>
											<option value="2">no</option>
										</select>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Send unpaid commions to cold storge	</strong></label>
										<select id="send_unpaid_commision" name="send_unpaid_commision">
											<option value="1">yes</option>
											<option value="2">no</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Send Trust Fee to cold storage</strong></label>
										<select id="send_trust_fee" name="send_trust_fee">
											<option value="1">yes</option>
											<option value="2">no</option>
										</select>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Send profit to cold storge	</strong></label>
										<select id="send_profit" name="send_profit">
											<option value="1">yes</option>
											<option value="2">no</option>
										</select>
									</div>
								</div>
							</div>
							<input type="submit" class="btn btn-secondary mb-2" value="Save"></input>
						</form>
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

		function generateWalletAddress(){
			var chain_stack = $('#chain_stack').find(':selected').val();
			var login = $('#login').val();
			var password = $('#password').val();
			var ipaddress = $('#ipaddress').val();
			$.ajax({
					type: "post",
					url : '{!! url('/admin/getNewWalletAddress'); !!}',
					data: {
						"_token": "{{ csrf_token() }}",
						"chain_stack": chain_stack,
						"login" : login,
						"password" : password,
						"ipaddress" : ipaddress
					},
					success: function(data){
						if(data.success){
							$('#wallet_address').val(data.address);
							if(chain_stack == 2){
								$('#private_key').val(data.private_key);
							}
						}else{
							swal({
								title: "Error",
								text: data.message,
								timer: 2e3,
								showConfirmButton: !1
							})
						}
					},
				});
				$('#changePasswordModal').modal('show')
			}
	</script>
@endsection	