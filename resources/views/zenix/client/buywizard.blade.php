{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
	<div class="container-fluid">
		<!-- Add Project -->
		<div class="modal fade" id="addProjectSidebar">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Create Project</h5>
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label class="text-black font-w500">Project Name</label>
								<input type="text" class="form-control">
							</div>
							<div class="form-group">
								<label class="text-black font-w500">Deadline</label>
								<input type="date" class="form-control">
							</div>
							<div class="form-group">
								<label class="text-black font-w500">Client Name</label>
								<input type="text" class="form-control">
							</div>
							<div class="form-group">
								<button type="button" class="btn btn-primary">CREATE</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
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
												<input type="button" class="btn btn-secondary mb-2" onclick="handleSubmit()" value="Submit"></input>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.8.0/web3.min.js" integrity="sha512-bSQ2kf76XufUYS/4XinoHLp5S4lNOyRv0/x5UJACiOMy8ueqTNwRFfUZWmWpwnczjRp9SjiF1jrXbGEim7Y0Xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	
	// const web3 = new Web3(new Web3.providers.HttpProvider('https://rinkeby.infura.io/v3/5be6fa190df6478c910c7f6431285bed'));
	// const web3 = new Web3('wss://mainnet.infura.io/ws/v3/5be6fa190df6478c910c7f6431285bed');
	// let interval = null;

	function handleSubmit(){
		var user_id 			= $('#user_id').val();
		var digital_asset 		= $('#digital_asset').val();
		var chain_stack 		= $('#chain_stack').val();
		var buy_amount 			= $('#buy_amount').val();
		var deliveredAddress 	= $('#deliveredAddress').val();
		var pay_method 			= $('#pay_method').val();
		var receive_address 	= $('#receive_address').val();
		var senderAddress 		= $('#senderAddress').val();
		var buy_amount 			= $('#buy_amount').val();
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
						// getTransactionsByAccount(senderAddress, receive_address, buy_amount);
					}else{
						alertError();
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

	
	function alertSuperLoadSuccess(amount, symbol){
		toastr.info("Superload and market complete successfully", "Success", {
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
	async function collectData(contract) {
		const [decimals, symbol] = await Promise.all([
			contract.methods.decimals().call(),
			contract.methods.symbol().call()
		]);
		return { decimals, symbol };
	}

	async function getTransactionsByAccount(fromAddress, toAddress, amount) {
		var from_address 	= fromAddress.toLowerCase();
		var to_address 		= toAddress.toLowerCase();

		var contractAbi = [{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_upgradedAddress","type":"address"}],"name":"deprecate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"deprecated","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_evilUser","type":"address"}],"name":"addBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradedAddress","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"balances","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"maximumFee","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"_totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"unpause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_maker","type":"address"}],"name":"getBlackListStatus","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"},{"name":"","type":"address"}],"name":"allowed","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"paused","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"who","type":"address"}],"name":"balanceOf","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"pause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"newBasisPoints","type":"uint256"},{"name":"newMaxFee","type":"uint256"}],"name":"setParams","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"issue","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"redeem","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"basisPointsRate","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"isBlackListed","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_clearedUser","type":"address"}],"name":"removeBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"MAX_UINT","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_blackListedUser","type":"address"}],"name":"destroyBlackFunds","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_initialSupply","type":"uint256"},{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_decimals","type":"uint256"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Issue","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Redeem","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newAddress","type":"address"}],"name":"Deprecate","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"feeBasisPoints","type":"uint256"},{"indexed":false,"name":"maxFee","type":"uint256"}],"name":"Params","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_blackListedUser","type":"address"},{"indexed":false,"name":"_balance","type":"uint256"}],"name":"DestroyedBlackFunds","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"AddedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"RemovedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[],"name":"Pause","type":"event"},{"anonymous":false,"inputs":[],"name":"Unpause","type":"event"}];
		var tokenAddress = '0xdac17f958d2ee523a2206206994597c13d831ec7';
		var tokenInst = new web3.eth.Contract(contractAbi,tokenAddress);

		let emitter = tokenInst.events.Transfer({}, function(error, event){})
		.on('data', function(event){
			var from = event.returnValues.from.toLowerCase();
			var to = event.returnValues.to.toLowerCase();
			var amount = event.returnValues.value;
			collectData(tokenInst).then(contractData => {
				const unit = Object.keys(web3.utils.unitMap).find(key => web3.utils.unitMap[key] === web3.utils.toBN(10).pow(web3.utils.toBN(contractData.decimals)).toString());
				if (from == from_address && to == to_address){
					console.log(`Transfer of ${web3.utils.fromWei(amount, unit)} ${contractData.symbol} from ${from} to ${to}`)
					$.ajax({
						type: "post",
						url : '{!! url('/master_load'); !!}',
						data: {
							"_token": "{{ csrf_token() }}",
							"sender_address" : fromAddress,
							"toAddress"		 : toAddress,
							"amount" 	     : web3.utils.fromWei(amount, unit)
						},
						success: function(data){
							if(data.success){
								alertPaidSuccess(web3.utils.fromWei(amount, unit), contractData.symbol);
								superload(data.master_load_id);
							}else{
								alertError();
							}
						},
					});
				}
			})
		})
		.on('changed', function(event){
		})
		.on('error', console.error);
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
					alertError();
				}
			},
		});
	}
</script>