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
                        <h4 class="card-title">{{__('locale.sell_wizard')}}</h4>
                    </div>
                    <div class="card-body">
						<form method="post" action="{!! url('/sell_crypto/id'); !!}">
							@csrf
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
												<select id="chain_stack" name="chain_stack">
													<option value="1">Bitcore</option>
													<option value="2">Metamask</option>
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
												<label class="text-label">Copy this address and send coins to this address</label>
												<input type="text" class="form-control" id="deliveredAddress" name="deliveredAddress" disabled>
											</div>
										</div>
									</div>
								</div>
								<div id="wizard_Time" class="tab-pane" role="tabpanel">
									<div class="row">
										<div class="col-lg-12 mb-2">
											<div class="form-group">
												<label class="mb-1"><strong>HOW TO YOU WANT TO RECEIVE PAYMENT</strong></label>
												<select id="pay_method" name="pay_method" onchange="handleChangeStatus(this)">
													<option value="1" selected>USDT/Ethereum Chain Stack</option>
													<option value="2">Bank Account</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div id="wizard_Details" class="tab-pane" role="tabpanel">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<div class="form-group" id="pay_step" name="pay_step">
												<label class='text-label'>Receive Payment In Crypto</label>
												<input type='number' name='buy_amount' id='buy_amount' class='form-control' min='0' step='any' required>
											</div>
										</div>
										<div class="col-lg-6 mb-2 mt-4">
											<div class="form-group">
												<input type="submit" class="btn btn-secondary mb-2" value="Submit"></input>
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

<script>
	function handleChangeStatus(val){
		if(val.value == 1){
			$('#pay_step').html("<label class='text-label'Receive Payment InCrypto</label>"+
				"<input type='number' name='buy_amount' id='buy_amount' class='form-control' min='0' step='any' required>");
		}else{
			$('#pay_step').html("<label class='text-label'>Receive Payment In Bank</label>");
		}
	}
</script>