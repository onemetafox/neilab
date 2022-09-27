{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.adminwalletlist')}}</h2>
		<a href="{!! url('/admin/newWalletlist'); !!}" class="btn btn-secondary mb-2"><i class="las la-plus scale5 me-3"></i>{{__('locale.admin_create_new_internal_wallet_list')}}</a>
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
                                    @if($value['chain_stack'] == 1)
									<td>Bitcoin core</td>
                                    @elseif($value['chain_stack'] == 2)
									<td>Metamask</td>
                                    @endif
                                    @if($value['chain_stack'] == 1)
									<td>Bitcoin</td>
                                    @elseif($value['chain_stack'] == 2)
									<td>Ethereum</td>
                                    @endif
									<td id="address_{{$key}}" class="copy_address" data-clipboard-target="#address_{{$key}}">{{$value['wallet_address']}}</td>
									<td><a href="javascript:fireColdWalletChangeModal({{$value['id']}})">{{$value['cold_storage_address']}}</a></td>
									<td>25775</td>
									<td><a href="javascript:fireWithdrawModal({{$value['id']}})">Withdraw</a></td>
									<td>25</td>
									<td>{{$value['cold_storage_balance']}}</td>
									<td><a href="{!! url('/admin/internal_wallet/history/'.$value['id']); !!}">History</a></td>
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
<div class="modal fade" id="coldStorageModal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
        
			<form method="post" action="{!! url('/admin/editColdStorage'); !!}">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Select Cold Storage Wallet</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="user_id" name="user_id"/>
					<div class="col-xl-12">
						<div class="form-group">
                            <label class="mb-1"><strong>Cold Storage Wallets</strong></label>
                            <select id="cold_wallet_select" name="cold_storage_wallet_id">
                                @foreach($cold_wallet as $key => $value)
                                <option value="{{++$key}}">{{$value['cold_address']}}</option>
                                @endforeach
                            </select>
                        </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="withdrawModal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdraw live to cold storage BTC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="wallet_id" name="wallet_id"/>
                <div class="col-xl-12">
                    <div class="form-group">
                        <label class="mb-1"><strong>Wallet Balance</strong></label>
                        <input type="text" class="form-control" id="wallet_balance" name="wallet_balance" disabled>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="form-group">
                        <label class="mb-1"><strong>Cold Storage</strong></label>
                        <input type="text" class="form-control" id="cold_storage" name="cold_storage" disabled>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="form-group">
                        <label class="mb-1"><strong>Amount to Withdraw</strong></label>
                        <input type="number" class="form-control" id="amount" name="amount" step="any">
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="form-group">
                        <label class="mb-1"><strong>Description</strong></label>
                        <textarea class="form-control" id="description" name="description" maxlength="100"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                <button onclick="withhdraw()" class="btn btn-primary">Withdraw</button>
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
            new ClipboardJS('.copy_address');
		});

        function fireColdWalletChangeModal(id){
            $("#user_id").val(id);
			$('#coldStorageModal').modal('show')
		}
        function withhdraw(){
            var wallet_id = $('#wallet_id').val();
            var amount = $('#amount').val();
            var description = $('#description').val();
            $.ajax({
					type: "post",
					url : '{!! url('/admin/withdrawToColdStorage'); !!}',
					data: {
						"_token": "{{ csrf_token() }}",
						"wallet_id": wallet_id,
                        "amount" : amount,
                        "description" : description
					},
					success: function(data){
						if(data.success){
                            swal({
								title: "Success",
								text: data.message,
								timer: 2e3,
								showConfirmButton: !1
							})
						}else{
                            sweetAlert("Oops...", data.message, "error")
						}
					},
				});
        }
        function fireWithdrawModal(id){
			$.ajax({
					type: "post",
					url : '{!! url('/admin/getWalletInfoByID'); !!}',
					data: {
						"_token": "{{ csrf_token() }}",
						"id": id,
					},
					success: function(data){
						if(data.success){
                            $('#wallet_id').val(id);
							$('#wallet_balance').val(data.wallet_balance);
							$('#cold_storage').val(data.cold_storage);
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
				$('#withdrawModal').modal('show');
		}
	</script>
@endsection	