{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
	<div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('locale.buy_wizard')}}</h4>
						@if(session()->has('error'))
						<div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
						@endif

						@if(session()->has('success'))
						<div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
						@endif
                    </div>
                    <div class="card-body">
						<input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}"/>
						<div id="smartwizard" class="form-wizard order-create">
							<ul class="nav nav-wizard">
								<li><a class="nav-link" href="#wizard_Service"> 
									<span>1</span> 
								</a></li>
								<li><a class="nav-link" href="#wizard_Time">
									<span>2</span>
								</a></li>
								<li><a class="nav-link" href="#wizard_Details">
									<span>3</span>
								</a></li>
							</ul>
							<div class="tab-content">
								<div id="wizard_Service" class="tab-pane" role="tabpanel">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="mb-1"><strong>Select Degital Asset</strong></label>
												<select id="digital_asset" name="digital_asset" onchange="handleChange(this)">
													<option value="1">BTC</option>
													<option value="2" disabled>USDT</option>
												</select>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="mb-1"><strong>Chain Stack</strong></label>
												<select id="chain_stack" name="chain_stack">
													<option value="1">BTC</option>
												</select>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">How Many Coins Do You Want To Buy?</label>
												<input type="number" name="buy_amount" id="buy_amount" class="form-control" min="0" step="any" required>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Paste your wallet address whree you wnat the coins delivered to</label>
												<input type="text" class="form-control" id="deliveredAddress" name="deliveredAddress" required>
											</div>
										</div>
									</div>
								</div>
								<div id="wizard_Time" class="tab-pane" role="tabpanel">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="mb-1"><strong>How To You Want to Pay?</strong></label>
												<select id="pay_method" name="pay_method" onchange="handleChangeStatus(this)">
													<option value="1" selected>USDT/Ethereum Chain Stack</option>
													<option value="2">Bank Account</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Copy the address you should send to</label>
												<input type="text" class="form-control" id="receive_address" name="receive_address" value="{{$ethereum_wallet}}" disabled>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Past your wallet address</label>
												<input type="text" class="form-control" id="senderAddress" name="senderAddress" required>
											</div>
										</div>
									</div>
								</div>
								
								<div id="wizard_Details" class="tab-pane" role="tabpanel">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group" id="pay_step" name="pay_step">
												<label class='text-label'>Pay With Crypto</label>
												<input type='number' name='pay_with' id='pay_with' class='form-control' min='0' step='any' required>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Past your transaction ID</label>
												<input type="text" class="form-control" id="tx_id" name="tx_id" required>
											</div>
									</div>
									<div class="row">
										<div class="col-lg-6 mb-2 mt-4">
											<div class="form-group">
												<input type="button" class="btn btn-secondary mb-2" onclick="alertConfirmRegister()" value="Submit"></input>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.8.0/web3.min.js" integrity="sha512-bSQ2kf76XufUYS/4XinoHLp5S4lNOyRv0/x5UJACiOMy8ueqTNwRFfUZWmWpwnczjRp9SjiF1jrXbGEim7Y0Xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	function alertConfirmRegister(){
		var deliveredAddress 	= $('#deliveredAddress').val();
		var pay_with		 	= $('#pay_with').val();
		Swal.fire({
		title: 'Please Confirm Your Request! \n You will get BTC of '+pay_with+'USDT to this address. \n '+deliveredAddress,
		confirmButtonText: 'OK',
		showCancelButton: true,
		}).then((result) => {
		if (result.value) {
			handleSubmit();
		} else if (result.dismiss) {
		}
		})
	}
	function handleSubmit(){
		var user_id 			= $('#user_id').val();
		var digital_asset 		= $('#digital_asset').val();
		var chain_stack 		= $('#chain_stack').val();
		var buy_amount 			= $('#buy_amount').val();
		var deliveredAddress 	= $('#deliveredAddress').val();
		var pay_method 			= $('#pay_method').val();
		var receive_address 	= $('#receive_address').val();
		var senderAddress 		= $('#senderAddress').val();
		var pay_with		 	= $('#pay_with').val();
		var tx_id		 		= $('#tx_id').val();

		$.ajax({
			type: "post",
			url : '{!! url('/buy_crypto'); !!}',
			data: {
				"_token": "{{ csrf_token() }}",
				"user_id": user_id,
				"digital_asset" : digital_asset,
				"chain_stack" : chain_stack,
				"buy_amount" : buy_amount,
				"delivered_address" : deliveredAddress,
				"pay_method" : pay_method,
				"receive_address" : receive_address,
				"sender_address" : senderAddress,
				"pay_with" : pay_with,
				"tx_id" : tx_id
			},
			success: function(data){
				if(data.success){
					alertRegisteredSuccess();
					superload(data.master_load_id);
				}else{
					alertError("Database Error");
				}
			},
		});
	}

	function handleChangeStatus(val){
		if(val.value == 1){
			$('#pay_step').html("<label class='text-label'>Pay With Crypto</label>"+
				"<input type='number' name='pay_amount' id='pay_amount' class='form-control' min='0' step='any' required>");
		}else{
			$('#pay_step').html("<label class='text-label'>Bank Pay</label>");
		}
	}

	function handleChange(val){
		if(val.value == 2){
			$('#chain_stack').html(
				"@foreach ($chainstacks as $key => $value)"+
					"<option value='{{$value['id']}}' disabled'>{{$value['stackname']}}</option>"+
				"@endforeach"
			);
		}else{
			$('#chain_stack').html(
				"<option value='1'>BTC</option>"
			);
		}
	}
	
	function alertSuperLoadSuccess(amount, symbol){
		swal("Thanks, Well Done !!", "Your "+amount+symbol+" has been deposite successfully !!", "success");
	}

	function alertDepositeError(message){
		sweetAlert("Oops...", message, "error");
	}
	function alertPaidSuccess(amount, symbol){
		toastr.info("Paid "+amount+symbol+" Successfully", "Success", {
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
	
	function alertRegisteredSuccess(){
		swal({
            title: "Your order registered successfully",
            text: "Please don't leave this webpage until deposit successfully!!",
            type: "success",
            timer: 10000
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

	function superload(masterload_id){
		$.ajax({
			type: "post",
			url : '{!! url('/super_load'); !!}',
			data: {
				"_token": "{{ csrf_token() }}",
				"masterload_id" : masterload_id,
			},
			success: function(data){
				if(data.success){
					alertSuperLoadSuccess();
				}else{
					alertDepositeError("Database Error");
				}
			},
		});
	}
</script>
@endsection