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
                        <h4 class="card-title">{{__('locale.sell_wizard')}}</h4>
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
													<option value="2">USDT</option>
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
												<label class="text-label">How Many Coins Do You Want To Sell?</label>
												<input type="number" name="sell_amount" id="sell_amount" class="form-control" min="0" step="any" required>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Paste your USDT (ERC20) wallet address whree your coins delivered to</label>
												<input type="text" class="form-control" id="deliveredAddress" name="deliveredAddress" required>
											</div>
										</div>
									</div>
								</div>
								<div id="wizard_Time" class="tab-pane" role="tabpanel">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="mb-1"><strong>HOW TO YOU WANT TO RECEIVE PAYMENT</strong></label>
												<select id="pay_method" name="pay_method" onchange="handleChangeStatus(this)">
													<option value="1" selected>BTC/BIC COIN</option>
													<option value="2">Bank Account</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Copy this address and send coins to this address</label>
												<input type="text" class="form-control" id="receive_address" name="receive_address" value="{{$bitcoin_wallet}}">
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
												<label class='text-label'>Pay with Bit Coin</label>
												<input type='number' name='pay_with' id='pay_with' class='form-control' min='0' step='any' required>
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Past the transaction ID which money sent to</label>
												<input type="text" class="form-control" id="tx_id" name="tx_id" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 mb-2 mt-4">
											<div class="form-group">
												<input type="button" class="btn btn-secondary mb-2" onclick="handleSubmit()" value="Submit"></input>
											</div>
										</div>
									</div>
								</div>
								</from>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/btcl-bcoin@1.0.0-beta.14b/lib/bcoin.js" integrity="sha256-X6zYD1A5XVau2MsOXN691kJVy2279xV2AuyNb0UXOAI=" crossorigin="anonymous"></script>
<script>
	function sendBTC(){
		
		$.ajax({
				type: "get",
				url : '{!! url('/send_btc'); !!}',
				success: function(data){
					if(data.success){
					}else{
						alertError();
					}
				},
			});
	}

	var interval  = null;
	function handleSubmit(){
		var user_id 			= $('#user_id').val();
		var digital_asset 		= $('#digital_asset').val();
		var chain_stack 		= $('#chain_stack').val();
		var sell_amount 		= $('#sell_amount').val();
		var deliveredAddress 	= $('#deliveredAddress').val();
		var pay_method 			= $('#pay_method').val();
		var receive_address 	= $('#receive_address').val();
		var senderAddress 		= $('#senderAddress').val();
		var buy_amount 			= $('#buy_amount').val();
		var pay_with		 	= $('#pay_with').val();
		var tx_id 				= $('#tx_id').val();
		
		$.ajax({
				type: "post",
				url : '{!! url('/sell_crypto'); !!}',
				data: {
					"_token": "{{ csrf_token() }}",
					"user_id": user_id,
					"digital_asset" : digital_asset,
					"chain_stack" : chain_stack,
					"sell_amount" : sell_amount,
					"delivered_address" : deliveredAddress,
					"pay_method" : pay_method,
					"receive_address" : receive_address,
					"sender_address" : senderAddress,
					"tx_id" : tx_id,
					"pay_with" : pay_with,
				},
				success: function(data){
					if(data.success){
						alertRegisteredSuccess();
					}else{
						alertError();
					}
				},
			});

	}

	function checkTransferBTCConfirmed(tx_id, pay_with, senderAddress,receive_address){
		$.ajax({
				type: "post",
				url : '{!! url('/confirm_btc_payment'); !!}',
				data: {
					"_token": "{{ csrf_token() }}",
					"amount": pay_with,
					"txid" : tx_id,
				},
				success: function(data){
					if(data.status=="success" && data.result=="true"){
						$.ajax({
							type: "post",
							url : '{!! url('/sell_master_load'); !!}',
							data: {
								"_token": "{{ csrf_token() }}",
								"sender_address" : senderAddress,
								"toAddress" : receive_address,
								"amount": pay_with,
								"tx_id" : tx_id,
							},
							success: function(data){
								if(data.success){
									alertPaidSuccess();
									clearInterval(interval);
									superload(data.master_load_id);
								}else{
									alertError();
								}
							},
						});
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
					"<option value='{{$value['id']}}'>{{$value['stackname']}}</option>"+
				"@endforeach"
			);
		}else{
			$('#chain_stack').html(
				"<option value='1'>BTC</option>"
			);
		}
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
		toastr.info("Successfully Ordered", "Success", {
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

	function alertError(){
		toastr.error("Database error", "Error", {
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

	// function getTransactionsByAccount(senderAddress, receive_address, pay_with){
	// 	$.ajax({
	// 		type: "post",
	// 		url : '{!! url('/sell_master_load'); !!}',
	// 		data: {
	// 			"_token": "{{ csrf_token() }}",
	// 			"sender_address" : fromAddress,
	// 			"toAddress"		 : toAddress,
	// 			"amount" 	     : web3.utils.fromWei(amount, unit)
	// 		},
	// 		success: function(data){
	// 			if(data.success){
	// 				alertPaidSuccess(web3.utils.fromWei(amount, unit), contractData.symbol);
	// 				superload(data.master_load_id);
	// 			}else{
	// 				alertError();
	// 			}
	// 		},
	// 	});
	// }

	function superload(masterload_id){
		$.ajax({
			type: "post",
			url : '{!! url('/sell_super_load'); !!}',
			data: {
				"_token": "{{ csrf_token() }}",
				"masterload_id" : masterload_id,
			},
			success: function(data){
				if(data.success){
					alertSuperLoadSuccess();
				}else{
					alertError();
				}
			},
		});
	}
</script>
@endsection
