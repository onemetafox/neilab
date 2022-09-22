{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.masterload_report')}}</h2>
		<div class="weather-btn mb-2">
			<span class="me-3 font-w600 text-black"><i class="fa fa-cloud me-2"></i>21</span>
			<select class="form-control style-1 default-select  me-3 ">
				<option>Medan, IDN</option>
				<option>Jakarta, IDN</option>
				<option>Surabaya, IDN</option>
			</select>
		</div>
		<a href="javascript:void(0);" class="btn btn-secondary mb-2"><i class="las la-calendar scale5 me-3"></i>Filter Periode</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.masterload_report')}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example7" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>{{__('locale.time_stamp')}}</th>
                                    <th>{{__('locale.trade_type')}}</th>
                                    <th>{{__('locale.sender_address')}}</th>
                                    <th>{{__('locale.to_address')}}</th>
                                    <th>{{__('locale.amount')}}</th>
                                    <th>{{__('locale.transction_detail')}}</th>
                                    <th>{{__('locale.superload_view')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $value)
								<tr>
									<td>{{$value->updated_at}}</td>
                                    <td>
                                        <?php echo $value->trade_type == 1? "Buy":"Sell" ?>
                                    </td>
                                    <td>{{$value->sending_address}}</td>
                                    <td>{{$value->wallet_address}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>
                                        <?php
                                            if($value->trade_type == 1){ ?>
                                        <a href="https://etherscan.io/tx/{{$value->tx_id}}" target="_blank">{{$value->tx_id}}</a>
                                        <?php }else{ ?>
                                        <a href="https://www.blockchain.com/btc/tx/{{$value->tx_id}}" target="_blank">{{$value->tx_id}}</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($value->trade_type == 1){ ?>
                                        <a href="{!! url('/superload_report_buy/'.$value->id); !!}">View Super Load</a>
                                        <?php }else{ ?>
                                            <a href="{!! url('/superload_report_sell/'.$value->id); !!}">View Super Load</a>
                                        <?php } ?>
                                    </td>
                                    <td ></td>
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